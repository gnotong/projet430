<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Login (LoginController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 */
class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function is used to open error /404 not found page
     */
    public function error()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            $this->load->view('login');
        } else {
            $process = 'Erreur';
            $processFunction = 'Login/error';
            $this->logrecord($process, $processFunction);
            redirect('pageNotFound');
        }
    }

    /**
     * This function is used to access denied page
     */
    public function noaccess()
    {

        $this->global['pageTitle'] = 'UY1 : accès refusé';
        $this->datas();

        $this->load->view('includes/header', $this->global);
        $this->load->view('access');
        $this->load->view('includes/footer');
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            $this->load->view('login');
        } else {
            redirect('/dashboard');
        }
    }


    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');

            $result = $this->login_model->loginMe($email, $password);

            if (count($result) > 0) {
                foreach ($result as $res) {
                    $lastLogin = $this->login_model->lastLoginInfo($res->userId);

                    $process = 'Connexion';
                    $processFunction = 'Login/loginMe';

                    $sessionArray = array(
                        'userId' => $res->userId,
                        'roleId' => $res->roleId,
                        'roleCode' => $res->roleCode,
                        'roleText' => $res->role,
                        'name' => $res->name,
                        'lastLogin' => $lastLogin->createdDtm,
                        'status' => $res->status,
                        'isLoggedIn' => TRUE
                    );

                    $this->session->set_userdata($sessionArray);

                    unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);

                    $this->logrecord($process, $processFunction);

                    redirect('/dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'L\'adresse email ou le mot de passe est incorrect');

                redirect('/login');
            }
        }
    }
}