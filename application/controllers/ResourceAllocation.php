<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'base/BaseController.php';

class ResourceAllocation extends BaseController
{
    public function index() {
        $this->global['pageTitle'] = 'Events';
        $data['resourcesType'] = $this->resourceType_model->getResourceTypes();
        $data['levels'] = $this->level_model->getAll();
        $data['teachers'] = $this->user_model->getTeachers();

        if ($levelId = $this->input->post('level')){
            $data['allocations'] = json_encode($this->resourceAllocation_model->getByLevel($levelId));
            $data['lessons'] = $this->lesson_model->getLessonsByLevelId($levelId);
            $data['levelId'] = $levelId;
            $data['lessonId'] = $this->input->post('lesson');
            $data['teacherInfo'] = !empty($data['lessonId']) ? $this->user_model->getTeacherByLesson($data['lessonId']) : null;
            $data['rooms'] = !empty($data['teacherInfo']) ? $this->resource_model->getRooms() : null;
            $data['roomId'] = $this->input->post('room');
            $data['start'] = $this->input->post('start');
            $data['end'] = $this->input->post('end');
        } else {
            $data['allocations'] = json_encode($this->resourceAllocation_model->getAll());
        }

        $this->loadViews("resource_allocation", $this->global, $data, NULL);
    }

    public function loadData(int $resourceTypeId = null)
    {
        if ($resourceTypeId) {
            $resources = $this->resource_model->getResourceByCategory($resourceTypeId);
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
            $message = $exception->getMessage();
        }

        if($lastId) {
            echo json_encode(array('success' => 1, 'result' => $message, 'eventId' => $lastId));
        } else {
            echo json_encode(array('success' => 0, 'error' => $message));
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
}