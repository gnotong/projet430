<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Login (LoginController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 */
class Login extends BaseController
{
    private const CONTROLLER = 'LoginController';

    /**
     * Index Page for this controller.
     */
    private function loginForm()
    {
        if (!$this->isLoggedIn()) {
            $this->loadViews('login', [
                'isLoggedIn' => false,
                'pageTitle' => 'UY1: Login'
            ]);
        } else {
            redirect('/dashboard');
        }
    }

    /**
     * This function is used to open error /404 not found page
     */
    public function error()
    {
        if (!$this->isLoggedIn()) {
            $this->loadViews('login', [
                'isLoggedIn' => false,
                'pageTitle' => 'UY1: Login'
            ]);
        } else {
            $this->log('Erreur', self::CONTROLLER . '/error');
            redirect('not_found');
        }
    }

    /**
     * This function is used to access denied page
     */
    public function noaccess()
    {
        $this->global['pageTitle'] = 'UY1 : accès refusé';

        $this->load->view('includes/header', $this->global);
        $this->load->view('access');
        $this->load->view('includes/footer');
    }


    /**
     * This function used to logged in user
     */
    public function connect()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->loginForm();
        } else {
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');

            $user = $this->login_model->checkUserCredentials($email, $password);

            if (!$user) {
                $this->session->set_flashdata('error', 'L\'adresse email ou le mot de passe est incorrect');
                redirect('/login');
            }

            $lastLogin = $this->login_model->lastLoginInfo($user->userId);

            $this->session->set_userdata([
                'userId' => $user->userId,
                'roleId' => $user->roleId,
                'roleCode' => $user->roleCode,
                'roleText' => $user->role,
                'name' => $user->name,
                'lastLogin' => $lastLogin->createdDtm,
                'status' => $user->status,
                'isLoggedIn' => true
            ]);

            $this->log('Connexion', self::CONTROLLER . '/connect');

            redirect('/dashboard');

        }
    }


    /**
     * This function is used to logged out user from system
     */
    function logout()
    {
        $this->log('Déconnexion', self::CONTROLLER . '/logout');

        $this->session->sess_destroy();

        redirect('login');
    }
}