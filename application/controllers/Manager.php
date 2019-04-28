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
        $this->load->model('user_model');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        // isLoggedIn / Login control function /  This function used login control
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        else
        {
            // isManagerOrAdmin / Admin or manager role control function / This function used admin or manager role control
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
            $data['taskRecords'] = $this->user_model->getTasks();

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
            $data['resources_prioritys'] = $this->user_model->getTasksPrioritys();

            $this->global['pageTitle'] = 'UY1: Ajouter une ressource';

            $this->loadViews("addNewResource", $this->global, $data, NULL);
    }

     /**
     * This function is used to add new resource to the system
     */
    function addNewResource()
    {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Titre de la tâche','required');
            $this->form_validation->set_rules('priority','Priorité','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->loadNewResource();
            }
            else
            {
                $title = $this->input->post('fname');
                $comment = $this->input->post('comment');
                $priorityId = $this->input->post('priority');
                $statusId = 1;
                $permalink = sef($title);
                
                $resourceInfo = array('title'=>$title, 'comment'=>$comment, 'priorityId'=>$priorityId, 'statusId'=> $statusId,
                                    'permalink'=>$permalink, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                                    
                $result = $this->user_model->addNewResource($resourceInfo);
                
                if($result > 0)
                {
                    $process = 'Ajouter une ressource';
                    $processFunction = 'Manager/addNewResource';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'Tâche créée avec succès');
                }
                else
                {
                    $this->session->set_flashdata('error', '    Vérifier le mot de passeRôle La création de la tâche a échoué');
                }
                
                redirect('addNewResource');
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
            
            $data['resourceInfo'] = $this->user_model->getResourceInfo($resourceId);
            $data['resources_prioritys'] = $this->user_model->getTasksPrioritys();
            $data['resources_situations'] = $this->user_model->getTasksSituations();
            
            $this->global['pageTitle'] = 'UY1 : Modifier la tâche';
            
            $this->loadViews("editOldResource", $this->global, $data, NULL);
    }

    /**
     * This function is used to edit resource
     */
    function editResource(): void
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname','Titre de la tâche','required');
        $this->form_validation->set_rules('priority','Priorité','required');

        $resourceId = $this->input->post('taskId');

        if($this->form_validation->run() == FALSE)
        {
            $this->editOldResource($resourceId);
        }
        else
        {
            $resourceId = $this->input->post('taskId');
            $title = $this->input->post('fname');
            $comment = $this->input->post('comment');
            $priorityId = $this->input->post('priority');
            $statusId = $this->input->post('status');
            $permalink = sef($title);

            $resourceInfo = array('title'=>$title, 'comment'=>$comment, 'priorityId'=>$priorityId, 'statusId'=> $statusId,
                                'permalink'=>$permalink);
                                
            $result = $this->user_model->editResource($resourceInfo,$resourceId);

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

            $result = $this->user_model->deleteResource($resourceId);
            
            if ($result == TRUE) {
                 $process = 'Görev Silme';
                 $processFunction = 'Manager/deleteResource';
                 $this->logrecord($process,$processFunction);

                 $this->session->set_flashdata('success', 'Görev silme başarılı');
                }
            else
            {
                $this->session->set_flashdata('error', 'Görev silme başarısız');
            }
            redirect('resources');
    }

}