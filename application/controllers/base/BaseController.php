<?php defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Class : BaseController (BaseController)
 */
class BaseController extends CI_Controller
{
    // User session variables
    /** @var int */
    protected $roleId;
    /** @var string */
    protected $roleCode;
    /**  @var int  */
    protected $userId;
    /** @var string */
    protected $name;
    /** @var string */
    protected $roleText;
    /** @var array */
    protected $global;
    /** @var string */
    protected $lastLogin;
    /** @var int */
    protected $status;
    /** @var boolean */
    protected $isLoggedIn;

    /** @var Login_model $login_model */
    public $login_model;
    /** @var Resource_model $resource_model */
    public $resource_model;
    /** @var User_model $user_model */
    public $user_model;
    /** @var CI_Session $session */
    public $session;
    /** @var CI_Form_validation $form_validation */
    public $form_validation;
    /** @var CI_input $input */
    public $input;
    /** @var CI_security $security */
    protected $security;


    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('resource_model');
        $this->load->model('login_model');
        $this->datas();
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        return isset($isLoggedIn) && $isLoggedIn;
    }

    /**
     * This function is used to check the admin access
     * Rol definetions in application/config/constants.php
     */
    function isAdmin()
    {
        return $this->roleCode === ROLE_ADMIN;
    }

    /**
     * This function is used to check the manager access
     * Rol definetions in application/config/constants.php
     */
    function isManagerOrTeacher()
    {
        if ($this->roleCode == ROLE_ADMIN || $this->roleCode == ROLE_TEACHER) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Checks if the user has logged in at least once
     * @return bool
     */
    function hasLoggedIn(): bool
    {
        $user = $this->user_model->getUserById($this->userId);

        return $user->status !== 0;
    }

    /**
     * This function is used to view no access view
     */
    public function accesslogincontrol()
    {
        $process = 'Accès interdit';
        $processFunction = 'Admin/accesslogincontrol';
        $this->log($process, $processFunction);

        redirect('noaccess');
    }

    /**
     * This function used to load views
     * @param string $viewName
     * @param null $headerInfo
     * @param null $pageInfo
     * @param null $footerInfo
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL)
    {
        $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
    }

    /**
     * This function used to load user sessions
     */
    function datas(): void
    {
        $this->roleId = $this->session->userdata('roleId');
        $this->userId = $this->session->userdata('userId');
        $this->name = $this->session->userdata('name');
        $this->roleText = $this->session->userdata('roleText');
        $this->roleCode = $this->session->userdata('roleCode');
        $this->lastLogin = $this->session->userdata('lastLogin');
        $this->status = $this->session->userdata('status');
        $this->isLoggedIn = $this->session->userdata('isLoggedIn');


        $this->global ['name'] = $this->name;
        $this->global ['userId'] = $this->userId;
        $this->global ['role_id'] = $this->roleId;
        $this->global ['role'] = $this->roleCode;
        $this->global ['role_text'] = $this->roleText;
        $this->global ['last_login'] = $this->lastLogin;
        $this->global ['status'] = $this->status;
        $this->global ['isLoggedIn'] = $this->isLoggedIn;

    }

    /**
     * This function insert into log to the log table
     * @param $process
     * @param $processFunction
     */
    function log($process, $processFunction)
    {
        $logInfo = array("userId" => $this->session->userdata('userId'),
            "userName" => $this->session->userdata('name'),
            "process" => $process,
            "processFunction" => $processFunction,
            "userRoleId" => $this->session->userdata('roleId'),
            "userRoleText" => $this->session->userdata('roleText'),
            "userIp" => $_SERVER['REMOTE_ADDR'],
            "userAgent" => getBrowserAgent(),
            "agentString" => $this->agent->agent_string(),
            "platform" => $this->agent->platform()
        );

        $this->login_model->loginsert($logInfo);
    }

    /**
     * @param bool $isProfile
     * @return bool
     */
    function validateUserForm(bool $isProfile = false): bool
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

        if ($isProfile) {
            $this->form_validation->set_rules('oldpassword', 'Old password', 'max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Password', 'matches[cpassword2]|max_length[20]');
            $this->form_validation->set_rules('cpassword2', 'Confirm Password', 'matches[cpassword]|max_length[20]');
        } else {
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('password', 'Password', 'matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'matches[password]|max_length[20]');
        }



        return $this->form_validation->run();
    }
}