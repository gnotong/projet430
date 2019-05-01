<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 */
class User extends BaseController
{
    /**
     * @var Resource_model $resource_model
     */
    public $resource_model;

    /**
     * @var User_model $user_model
     */
    public $user_model;

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('resource_model');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'UY1 : Acceuil';

        $data['resourcesCount'] = $this->resource_model->resourcesCount();
        $data['finishedResourcesCount'] = $this->resource_model->finishedResourcesCount();
        $data['usersCount'] = $this->user_model->usersCount();
        $data['logsCount'] = $this->user_model->logsCount();

        if ($this->getUserStatus() == TRUE) {
            $this->session->set_flashdata('error', 'Veuillez d\'abord changer votre mot de passe pour votre sécurité.');
            redirect('loadChangePass');
        }

        $this->loadViews("dashboard", $this->global, $data, NULL);
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {
            echo("true");
        } else {
            echo("false");
        }
    }

    /**
     * This function is used to load edit user view
     * TODO: Edit profile form à factoriser trop de code redondant
     */
    private function userProfileForm()
    {
        $this->global['pageTitle'] = 'UY1 : Paramètres du compte';

        $data['userInfo'] = $this->user_model->getUserInfo($this->vendorId);

        $this->loadViews("form_user_profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the of the user info
     */
    function editProfile()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->userProfileForm();
        } else {
            $this->load->library('form_validation');

            $userId = $this->input->post('userId');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('oldpassword', 'Old password', 'max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Password', 'matches[cpassword2]|max_length[20]');
            $this->form_validation->set_rules('cpassword2', 'Confirm Password', 'matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

            $name = $this->security->xss_clean($this->input->post('fname'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('cpassword');
            $password2 = $this->input->post('cpassword2');
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $oldPassword = $this->input->post('oldpassword');

            $userInfo = array();

            if (empty($password)) {
                $userInfo = array('email' => $email, 'name' => $name,
                    'mobile' => $mobile, 'status' => 1, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:s'));
            } else {
                $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
                $pwdAreSame = $this->user_model->matchPassword($password, $password2);

                if (empty($resultPas)) {
                    $this->session->set_flashdata('nomatch', 'Votre ancien mot de passe n\'est pas correct');
                    redirect('user_edit_profile');
                } elseif (!$pwdAreSame) {
                    $this->session->set_flashdata('nomatch', 'Vos nouveaux mots de passes ne sont pas identiques');
                    redirect('user_edit_profile');
                } else {
                    $userInfo = array('email' => $email, 'password' => getHashedPassword($password),
                        'name' => ucwords($name), 'mobile' => $mobile, 'status' => 1, 'updatedBy' => $this->vendorId,
                        'updatedDtm' => date('Y-m-d H:i:s'));
                }
            }

            $result = $this->user_model->editUser($userInfo, $userId);

            if ($result == true) {
                $process = 'Mise à jour des paramètres du compte';
                $processFunction = 'User/editProfile';
                $this->logrecord($process, $processFunction);

                $this->session->set_flashdata('success', 'Les paramètres de votre compte ont été mis à jour avec succès');
            } else {
                $this->session->set_flashdata('error', 'Échec de la mise à jour des paramètres du compte');
            }

            redirect('user_edit_profile');
        }
    }

    /**
     * This function is used to load the change password view
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'UY1 : Changer le mot de passe';

        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }

    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', 'Old password', 'required|max_length[20]');
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            $this->loadChangePass();
        } else {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if (empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'Votre ancien mot de passe n\'est pas correct');
                redirect('loadChangePass');
            } else {
                $usersData = array(
                    'password' => getHashedPassword($newPassword),
                    'status' => 1,
                    'updatedBy' => $this->vendorId,
                    'updatedDtm' => date('Y-m-d H:i:s'));

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if ($result > 0) {

                    $process = 'Changement de mot de passe';
                    $processFunction = 'User/changePassword';
                    $this->logrecord($process, $processFunction);

                    $this->session->set_flashdata('success', 'Mot de passe mis à jour avec succès');
                } else {
                    $this->session->set_flashdata('error', 'Le changement de mot de passe a échoué');
                }

                redirect('loadChangePass');
            }
        }
    }

    /**
     * This function is used to open 404 view
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'UY1 : 404 - Page non trouvée';

        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>