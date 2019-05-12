<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'base/BaseController.php';

class ResourceAllocation extends BaseController
{

    public function index() {
        $this->global['pageTitle']  = 'Events';
        $this->global['resourcesType']  = $this->resourceType_model->getResourceTypes();
        $this->global['resources']  = $this->resource_model->getResources();
        $this->global['allocations']  =  json_encode($this->resourceAllocation_model->getAll());

        $this->loadViews("resource_allocation", $this->global, null, NULL);
    }

    public function loadData(int $resourceTypeId = null) {

        if ($resourceTypeId) {
            $resources = $this->resource_model->getResourceByCategory($resourceTypeId);
        } else {
            $resources = $this->resourceAllocation_model->getAll();
        }

        if($resources !== NULL) {
            echo json_encode(array('success' => 1, 'resources' => $resources));
        } else {
            echo json_encode(array('success' => 0, 'error' => 'Event not found'));
        }
    }

    /**
     * @throws Exception
     */
    public function add()
    {
        $message = null;
        $lastId = null;

        try {
            $events = [
                'resource_id' => $this->input->post('resource'),
                'resource_type_id' => $this->input->post('resourceType'),
                'start_date' => $this->input->post('start'),
                'end_date' => $this->input->post('end'),
                'all_day ' => $this->input->post('allDay'),
                'background_color ' => $this->input->post('backgroundColor'),
                'border_color ' => $this->input->post('borderColor'),
            ];

            $lastId = $this->resourceAllocation_model->insert($events);
            $message = 'OK';
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
        }


        if($lastId) {
            echo json_encode(array('success' => 1, 'result' => $message));
        } else {
            echo json_encode(array('success' => 0, 'error' => $message));
        }
    }


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