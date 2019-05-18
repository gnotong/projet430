<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'base/BaseController.php';

class ResourceAllocation extends BaseController
{
    public function index() {
        $this->global['pageTitle'] = 'Events';
        $data['colors'] = $this->getColors();
        $data['levels'] = $this->level_model->getAll();
        $data['allocations'] = json_encode($this->resourceAllocation_model->getAll());

        $this->loadViews("resource_allocation", $this->global, $data, NULL);
    }

    public function loadData(int $allocationId = null)
    {
        if ($allocationId) {
            $resources = $this->resourceAllocation_model->getById($allocationId);
        } else {
            $resources = $this->resourceAllocation_model->getAll();
        }

        if ($resources !== NULL) {
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
                'level_id' => $this->input->post('level'),
                'lesson_id' => $this->input->post('lesson'),
                'teacher_id' => $this->input->post('teacher'),
                'background_color ' => $this->input->post('backgroundColor'),
                'border_color ' => $this->input->post('borderColor'),
                'start_date' => $this->input->post('start'),
                'end_date' => $this->input->post('end'),
                'all_day ' => $this->input->post('allDay'),
            ];

            $lastId = $this->resourceAllocation_model->insert($events);
            $message = 'OK';
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        if($lastId) {
            echo json_encode(array('success' => 1, 'result' => $message, 'eventId' => $lastId));
        }
    }

    /**
     * @param int $event
     */
    public function delete(int $event)
    {
        $isDeleted = $this->resourceAllocation_model->delete('resource_allocation', 'id', $event);

        if ($isDeleted) {
            $process = 'Suprpession des affectation';
            $processFunction = 'RessourceAllocation/delete';
            $this->log($process, $processFunction);

            echo json_encode(array('success' => 1, 'result' => 'Affectation supprimée !'));
        } else {
            echo json_encode(array('success' => 0, 'result' => 'Erreur de suppression de l\'affectation !'));
        }
    }

    private function getColors():array
    {
        return [
            '&#9724; Dark blue' => '#0071c5',
            '&#9724; Turquoise' => '#40E0D0',
            '&#9724; Green' => '#008000',
            '&#9724; Yellow' => '#FFD700',
            '&#9724; Orange' => '#FF8C00',
            '&#9724; Red' => '#FF0000',
            '&#9724; Black' => '#000'
        ];
    }
}