<?php defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Class : BaseController (BaseController)
 */
class BaseController extends CI_Controller
{
    // User session variables
    protected $roleId = '';
    protected $roleCode = '';
    protected $vendorId = '';
    protected $name = '';
    protected $roleText = '';
    protected $global = array();
    protected $lastLogin = '';
    protected $status = '';

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

    /**
     * Takes mixed data and optionally a status code, then creates the response
     *
     * @access public
     * @param array|NULL $data
     *            Data to output to the user
     *            running the script; otherwise, exit
     */
    public function response($data = NULL)
    {
        $this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))->_display();
        exit ();
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset ($isLoggedIn) || $isLoggedIn != TRUE) {
            redirect('login');
        } else {
            $this->datas();
        }
    }

    /**
     * This function is used to check the admin access
     * Rol definetions in application/config/constants.php
     */
    function isAdmin()
    {
        if ($this->roleCode != ROLE_ADMIN) {
            return true;
        } else {
            return false;
        }
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
     * This function is used to get the user's status from the user table
     */
    function getUserStatus()
    {
        $this->datas();
        $status = $this->user_model->getUserStatus($this->vendorId);
        if ($status->status == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to view no access view
     */
    public function accesslogincontrol()
    {
        $process = 'Accès interdit';
        $processFunction = 'Admin/accesslogincontrol';
        $this->logrecord($process, $processFunction);

        redirect('noaccess');
    }

    /**
     * This function is used to logged out user from system
     */
    function logout()
    {

        $process = 'Déconnexion';
        $processFunction = 'BaseController/logout';
        $this->logrecord($process, $processFunction);

        $this->session->sess_destroy();

        redirect('login');
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
    function datas()
    {
        $this->roleId = $this->session->userdata('roleId');
        $this->vendorId = $this->session->userdata('userId');
        $this->name = $this->session->userdata('name');
        $this->roleText = $this->session->userdata('roleText');
        $this->roleCode = $this->session->userdata('roleCode');
        $this->lastLogin = $this->session->userdata('lastLogin');
        $this->status = $this->session->userdata('status');


        $this->global ['name'] = $this->name;
        $this->global ['role_id'] = $this->roleId;
        $this->global ['role'] = $this->roleCode;
        $this->global ['role_text'] = $this->roleText;
        $this->global ['last_login'] = $this->lastLogin;
        $this->global ['status'] = $this->status;

    }

    /**
     * This function insert into log to the log table
     * @param $process
     * @param $processFunction
     */
    function logrecord($process, $processFunction)
    {
        $this->datas();
        $logInfo = array("userId" => $this->vendorId,
            "userName" => $this->name,
            "process" => $process,
            "processFunction" => $processFunction,
            "userRoleId" => $this->roleId,
            "userRoleText" => $this->roleText,
            "userIp" => $_SERVER['REMOTE_ADDR'],
            "userAgent" => getBrowserAgent(),
            "agentString" => $this->agent->agent_string(),
            "platform" => $this->agent->platform()
        );

        $this->load->model('login_model');
        $this->login_model->loginsert($logInfo);
    }
}