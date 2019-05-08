<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 */
class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('user_model');

        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();

        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            redirect('login');
        } else {
            if ($this->isAdmin() == TRUE) {
                $this->accesslogincontrol();
            }
        }
    }

    /**
     * This function is used to load the user list
     */
    function userList()
    {
        $data['users'] = $this->user_model->getAll();

        $this->global['pageTitle'] = 'UY1 : liste d\'utilisateurs';

        $this->loadViews("users", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the create user form
     * TODO: Factoriser les formulaires d'édition et de création (userForm et userEditForm)
     * TODO: Factoriser les action d'édition et de création d'utilisateur
     * TODO: Car code redondant
     */
    private function userForm()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'UY1 : Ajouter un utilisateur';

        $this->loadViews("form_add_user", $this->global, $data, NULL);
    }

    /**
     * This function gets data from the form and persist them in to the system
     */
    function addUser()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->userForm();
        } else {

            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

            $userInfo = [
                'email' => $this->security->xss_clean($this->input->post('email')),
                'password' => getHashedPassword($this->input->post('password')),
                'roleId' => $this->input->post('role'),
                'name' => ucwords(strtolower($this->security->xss_clean($this->input->post('fname')))),
                'mobile' => $this->security->xss_clean($this->input->post('mobile')),
                'createdBy' => $this->userId,
                'createdDtm' => date('Y-m-d H:i:s')
            ];

            $result = $this->user_model->add($userInfo);

            if ($result > 0) {
                $this->session->set_flashdata('success', 'Utilisateur créé avec succès');
            } else {
                $this->session->set_flashdata('error', 'La création de l\'utilisateur a échoué');
            }

            redirect('user_list');
        }
    }

    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    private function userEditForm($userId)
    {
        $data['roles'] = $this->user_model->getUserRoles();
        $data['userInfo'] = $this->user_model->getUserById($userId);

        $this->global['pageTitle'] = 'UY1 : Modification d\'un utilisateur';

        $this->loadViews("form_edit_user", $this->global, $data, NULL);
    }

    /**
     * This function is used to edit the user informations
     * @param null $userId
     */
    function editUser($userId = NULL)
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->userEditForm($userId);
        } else {
            $this->load->library('form_validation');

            $userId = $this->input->post('userId');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password', 'Password', 'matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

            $password = $this->input->post('password');
            $userInfo = [
                'email' => $this->security->xss_clean($this->input->post('email')),
                'password' => '',
                'roleId' => $this->input->post('role'),
                'name' => ucwords(strtolower($this->security->xss_clean($this->input->post('fname')))),
                'mobile' => $this->security->xss_clean($this->input->post('mobile')),
                'status' => 0,
                'updatedBy' => $this->userId,
                'updatedDtm' => date('Y-m-d H:i:s')
            ];

            if (!empty($password)) {
                $userInfo['password'] = getHashedPassword($password);
            } else {
                unset($userInfo['password']);
            }

            $result = $this->user_model->editUser($userInfo, $userId);

            if ($result == true) {
                $this->session->set_flashdata('success', 'Utilisateur mis à jour avec succès');
            } else {
                $this->session->set_flashdata('error', 'La mise à jour de l\'utilisateur a échoué');
            }

            redirect('user_list');
        }
    }

    /**
     * This function is used to delete the user using userId
     */
    function deleteUser()
    {
        $userId = $this->input->post('userId');
        $userInfo = array('isDeleted' => 1, 'updatedBy' => $this->userId, 'updatedDtm' => date('Y-m-d H:i:s'));

        $result = $this->user_model->deleteUser($userId, $userInfo);

        if ($result > 0) {
            echo(json_encode(array('status' => TRUE)));

            $process = 'Supprimer l\'utilisateur';
            $processFunction = 'Admin/deleteUser';
            $this->log($process,$processFunction);

        } else {
            echo(json_encode(array('status' => FALSE)));
        }
    }
}