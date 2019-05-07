<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Home (HomeController)
 */
class Home extends BaseController
{
    /**
     * shows the site dashboard
     */
    public function index()
    {
        $this->global['pageTitle'] = 'UY1 : Home';

        $data['resourcesCount'] = $this->resource_model->resourcesCount();
        $data['finishedResourcesCount'] = $this->resource_model->finishedResourcesCount();
        $data['usersCount'] = $this->user_model->usersCount();
        $data['logsCount'] = $this->user_model->logsCount();

        if (!$this->hasLoggedIn()) {
            $this->session->set_flashdata('error', 'Veuillez d\'abord changer votre mot de passe pour votre sécurité.');
            redirect('changePassword');
        }

        $this->loadViews("dashboard", $this->global, $data, NULL);
    }
}