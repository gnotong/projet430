<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Manager (ManagerController)
 * Manager class to control to authenticate manager credentials and include manager functions.
 */
class Manager extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('resource_model');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        else
        {
            if($this->isManagerOrAdmin() == TRUE)
            {
                $this->accesslogincontrol();
            }
        }
    }

     /**
     * This function used to show resources
     */
    function resources()
    {
            $data['resourcesRecords'] = $this->resource_model->getResources();

            $process = 'Toutes les Ressources';
            $processFunction = 'Manager/resources';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'UY1: Toutes les Ressources';
            
            $this->loadViews("resources", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new resource
     */
    function loadNewResource()
    {
            $data['resourcesCategories'] = $this->resource_model->getResourcesCategories();

            $this->global['pageTitle'] = 'UY1: Ajouter une ressource';

            $this->loadViews("addNewResource", $this->global, $data, NULL);
    }

     /**
     * This function is used to add new resource to the system
     */
    function addNewResource()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('label','Libellé','required');
        $this->form_validation->set_rules('category','Catégorie','required');

        if($this->form_validation->run() == FALSE)
        {
            $this->loadNewResource();
        }
        else
        {
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $categoryId = $this->input->post('category');
            $brand = $this->input->post('brand');

            $resourceInfo = [
                'label'=>$label,
                'description'=>$description,
                'brand'=>$brand,
                'categoryId'=>$categoryId,
                'createdBy'=>$this->vendorId,
                'created'=>date('Y-m-d H:i:s')
            ];

            $result = $this->resource_model->addNewResource($resourceInfo);

            if($result > 0)
            {
                $process = 'Ajouter une ressource';
                $processFunction = 'Manager/addNewResource';
                $this->logrecord($process,$processFunction);

                $this->session->set_flashdata('success', 'Ressource créée avec succès');
            }
            else
            {
                $this->session->set_flashdata('error', '    Vérifier le mot de passeRôle La création de la tâche a échoué');
            }

            redirect('add_resource');
        }
    }

    /**
     * This function is used to open edit resources view
     */
    function editOldResource($resourceId = NULL)
    {
            if($resourceId == null)
            {
                redirect('resources');
            }
            
            $data['resourceInfo'] = $this->resource_model->getResourceInfo($resourceId);
            $data['resourcesCategories'] = $this->resource_model->getResourcesCategories();
            $data['resources_situations'] = $this->resource_model->getResourcesSituations();
            
            $this->global['pageTitle'] = 'UY1 : Modifier la tâche';
            
            $this->loadViews("editOldResource", $this->global, $data, NULL);
    }

    /**
     * This function is used to edit resource
     */
    function editResource(): void
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('label','Libellé','required');
        $this->form_validation->set_rules('category','Catégorie','required');

        $resourceId = $this->input->post('resourceId');

        if($this->form_validation->run() == FALSE)
        {
            $this->editOldResource($resourceId);
        }
        else
        {
            $resourceId = $this->input->post('resourceId');
            $label = $this->input->post('label');
            $description = $this->input->post('description');
            $category = $this->input->post('category');
            $brand = $this->input->post('brand');

            $resourceInfo = [
                'label'=>$label,
                'description'=>$description,
                'categoryId'=>$category,
                'brand'=> $brand
            ];

            $result = $this->resource_model->editResource($resourceInfo,$resourceId);

            if($result > 0)
            {
                $process = 'Edition de ressource';
                $processFunction = 'Manager/editResource';
                $this->logrecord($process,$processFunction);
                $this->session->set_flashdata('success', 'Ressource modifiée avec succès');
            }
            else
            {
                $this->session->set_flashdata('error', 'La modification de la ressource a échoué');
            }
            redirect('resources');

        }
    }

    /**
     * This function is used to delete resources
     * @param null $resourceId
     */
    function deleteResource($resourceId = NULL)
    {
        if($resourceId == null)
            {
                redirect('resources');
            }

            $result = $this->resource_model->deleteResource($resourceId);
            
            if ($result == TRUE) {
                 $process = 'Suprpession de ressources';
                 $processFunction = 'Manager/deleteResource';
                 $this->logrecord($process,$processFunction);

                 $this->session->set_flashdata('success', 'Ressources supprimées avec succès');
                }
            else
            {
                $this->session->set_flashdata('error', 'Erreur de suppression de la ressource');
            }
            redirect('resources');
    }

}