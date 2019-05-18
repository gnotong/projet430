<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 */
class Admin extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->isLoggedIn()) {
            redirect('login');
        }
        if (!$this->isAdmin()) {
            $this->accesslogincontrol();
        }
    }

    /**
     * This function is used to load the user list
     */
    function userList()
    {
        $data['users'] = $this->user_model->getAll();

        $this->global['pageTitle'] = 'UY1 : liste d\'utilisateurs';

        $this->loadViews("user/list", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the create user form
     */
    private function userForm()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'UY1 : Ajouter un utilisateur';

        $this->loadViews("user/form_add_user", $this->global, $data, NULL);
    }

    /**
     * This function gets data from the form and persist them in to the system
     */
    function addUser()
    {
        if (!$this->validateUserForm()) {
            $this->userForm();
        } else {
            $userInfo = [
                'email' => $this->security->xss_clean($this->input->post('email')),
                'password' => getHashedPassword($this->input->post('password')),
                'roleId' => $this->input->post('role'),
                'name' => ucwords(strtolower($this->security->xss_clean($this->input->post('fname')))),
                'serial_number' => ucwords(strtoupper($this->security->xss_clean($this->input->post('serialNumber')))),
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

        if (!$data['userInfo']) {
            $this->session->set_flashdata('error', "L'utilisateur que vous voulez éditer n'existe pas");
            redirect('user_list');
        }

        $this->global['pageTitle'] = 'UY1 : Modification d\'un utilisateur';

        $this->loadViews("user/form_edit_user", $this->global, $data, NULL);
    }

    /**
     * This function is used to edit the user informations
     * @param int $userId
     */
    function editUser(int $userId)
    {
        if (!$this->validateUserForm()) {
            $this->userEditForm($userId);
        } else {

            $password = $this->input->post('password');
            $userInfo = [
                'email' => $this->security->xss_clean($this->input->post('email')),
                'password' => '',
                'roleId' => $this->input->post('role'),
                'name' => ucwords(strtolower($this->security->xss_clean($this->input->post('fname')))),
                'serial_number' => ucwords(strtoupper($this->security->xss_clean($this->input->post('serialNumber')))),
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


    /**
     * @param int $lesson
     */
    function userAjax(int $lesson)
    {
        $teacher = null;
        if ($lesson) {
            $teacher = $this->user_model->getTeacherByLesson($lesson);
        }

        if ($teacher) {
            echo json_encode(array('success' => 1, 'json' => [$teacher]));
        } else {
            echo(json_encode(array('success' => 0, 'error' => 'Aucun enseignant n\'a été trouvé.')));
        }
    }
}