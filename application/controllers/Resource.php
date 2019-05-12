<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Resource (ResourceController)
 * Manager class to control to authenticate manager credentials and include manager functions.
 */
class Resource extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();

        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();

        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            redirect('login');
        } else {
            if ($this->isManagerOrTeacher() == TRUE) {
                $this->accesslogincontrol();
            }
        }
    }

    /**
     * This function used to show resources
     */
    public function list()
    {
        $data['resourcesRecords'] = $this->resource_model->getResources();

        $process = 'Toutes les Ressources';
        $processFunction = 'Manager/resources';
        $this->log($process, $processFunction);

        $this->global['pageTitle'] = 'UY1: Toutes les Ressources';

        $this->loadViews("resources", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new resource
     */
    private function newResourceForm()
    {
        $data['resourcesCategories'] = $this->resource_model->getResourcesCategories();

        $this->global['pageTitle'] = 'UY1: Ajouter une ressource';

        $this->loadViews("form_add_resource", $this->global, $data, NULL);
    }

    /**
     * This function is used to add new resource to the system
     */
    public function create()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('label', 'Libellé', 'required');
        $this->form_validation->set_rules('category', 'Catégorie', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->newResourceForm();
        } else {
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $categoryId = $this->input->post('category');

            $resourceInfo = [
                'label' => $label,
                'description' => $description,
                'categoryId' => $categoryId,
                'createdBy' => $this->userId,
                'created' => date('Y-m-d H:i:s')
            ];

            $result = $this->resource_model->add($resourceInfo);

            if ($result > 0) {
                $process = 'Ajouter une ressource';
                $processFunction = 'Resource/create';
                $this->log($process, $processFunction);

                $this->session->set_flashdata('success', 'Ressource créée avec succès');
            } else {
                $this->session->set_flashdata('error', '    Vérifier le mot de passeRôle La création de la tâche a échoué');
            }

            redirect('add_resource');
        }
    }

    /**
     * This function is used to open edit resources view
     * @param null $resourceId
     */
    private function resourceForm($resourceId = NULL)
    {
        $data['resource'] = $this->resource_model->getResourceInfo($resourceId);
        $data['resourcesCategories'] = $this->resource_model->getResourcesCategories();
        $data['resources_situations'] = $this->resource_model->getResourcesSituations();

        $this->global['pageTitle'] = 'UY1 : Modifier la resource';

        $this->loadViews("form_edit_resource", $this->global, $data, NULL);
    }

    /**
     * This function is used to edit resource
     * @param null $resourceId
     */
    public function editResource($resourceId = NULL): void
    {

        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->resourceForm($resourceId);
        } else {

            $this->load->library('form_validation');
            $this->form_validation->set_rules('label', 'Libellé', 'required');
            $this->form_validation->set_rules('category', 'Catégorie', 'required');

            $resourceId = $this->input->post('resourceId');
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $category = $this->input->post('category');

            $resourceInfo = [
                'label' => $label,
                'description' => $description,
                'categoryId' => $category,
            ];

            $result = $this->resource_model->editResource($resourceInfo, $resourceId);

            if ($result > 0) {
                $process = 'Edition de ressource';
                $processFunction = 'Manager/editResource';
                $this->log($process, $processFunction);
                $this->session->set_flashdata('success', 'Ressource modifiée avec succès');
            } else {
                $this->session->set_flashdata('error', 'La modification de la ressource a échoué');
            }
            redirect('resources');

        }
    }

    /**
     * This function is used to delete resources
     * @param null $resourceId
     */
    public function deleteResource($resourceId = NULL)
    {
        if ($resourceId == null) {
            redirect('resources');
        }

        $result = $this->resource_model->deleteResource($resourceId);

        if ($result == TRUE) {
            $process = 'Suprpession de ressources';
            $processFunction = 'Manager/deleteResource';
            $this->log($process, $processFunction);

            $this->session->set_flashdata('success', 'Ressources supprimées avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur de suppression de la ressource');
        }
        redirect('resources');
    }

}