<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'base/BaseController.php';

class ResourceAllocation extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->datas();

        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            redirect('login');
        } else {
            if (!$this->isAdmin()) {
                $this->accesslogincontrol();
            }
        }
    }

    public function list()
    {
        $this->global['pageTitle'] = 'Liste des affectations';
        $data['allocations'] = $this->resourceAllocation_model->getAll();

        $this->loadViews("allocation/list", $this->global, $data, NULL);
    }

    public function index()
    {
        $this->global['pageTitle'] = 'Events';
        $data['colors'] = $this->getColors();
        $data['levels'] = $this->level_model->getAll();
        $data['actions'] = $this->getActions();
        $data['days'] = $this->daysOfTheWeek();
        $data['semesters'] = $this->semester_model->getAll();
        $levelId = $this->input->post('globalLevel');
        $action = $this->input->post('action');

        $isReservation = $action == 2;

        if ($levelId) {

            if ($isReservation) { // Réservation
                $data['allocations'] = json_encode($this->resourceAllocation_model->getByLevelWithoutSemester($levelId));
            }

            if (!$isReservation) { //Affectation
                $data['allocations'] = json_encode($this->resourceAllocation_model->getByLevel($levelId));
            }

            $data['levelId'] = $levelId;
            $data['action'] = $action;
        } else {
            if ($isReservation) {
                $data['allocations'] = json_encode($this->resourceAllocation_model->getAllWithoutSemester());
            }

            if (!$isReservation) {
                $data['allocations'] = json_encode($this->resourceAllocation_model->getAll());
            }
        }

        $this->loadViews("allocation/resource_allocation", $this->global, $data, NULL);
    }

    /**
     * ADD and UPDATE EVENTS
     */
    public function add()
    {
        $message = null;
        $lastId = null;
        $eventId = $this->input->post('eventId');
        $isReservation = $this->input->post('isReservation');

        $events = [
            'resource_id' => $this->input->post('resource'),
            'level_id' => $this->input->post('level'),
            'lesson_id' => $this->input->post('lesson'),
            'teacher_id' => $this->input->post('teacher'),
            'semester_id' => !$isReservation? $this->input->post('semester') : null,
            'background_color ' => $this->input->post('backgroundColor'),
            'border_color ' => $this->input->post('borderColor'),
            'start_date' => $this->input->post('start'),
            'end_date' => $this->input->post('end'),
            'all_day ' => $this->input->post('allDay'),
        ];

        try
        {
            if ($eventId) {
                if ($this->room_model->isRoomAvailable($events)) {
                    $this->resourceAllocation_model->update($events, $eventId);
                    $message = 'Affectation mise à jour avec succès';
                } else {
                    throw new Exception('Mise à jour impossible car la période choisie n\'est pas disponible');
                }
            }

            if (!$eventId) {
                $lastId = $this->resourceAllocation_model->insert($events);
                $message = 'Affectation ajoutée avec succès';
            }

            if ($lastId or $eventId) {
                echo json_encode(array('success' => 1, 'result' => $message, 'eventId' => $lastId ?? $eventId));
            }

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function edit()
    {
        $isReservation = $this->input->post('isReservation');

        $result['levels'] = $this->level_model->getAll();
        $result['lessons'] = $this->lesson_model->getLessonsByLevelId($this->input->post('level'));
        $result['teacher'] = $this->user_model->getTeacherByLesson($this->input->post('lesson'));
        $result['rooms'] = $this->room_model->getRooms();

        if ($isReservation) {
            $result['event'] = $this->resourceAllocation_model->getByIdWithoutSemester($this->input->post('event'))[0];
        } else {
            $result['event'] = $this->resourceAllocation_model->getById($this->input->post('event'))[0];
            $result['semesters'] = $this->semester_model->getAll();
            $result['daysOfTheWeek'] = $this->daysOfTheWeek();
        }

        echo json_encode([
            'success' => 1,
            'result' => $result
        ]);
    }

    /**
     * @param int $event
     */
    public function delete(int $event = null)
    {
        $isAjaxRequest = $this->input->is_ajax_request();

        $isDeleted = false;

        try
        {
            $eventIds = $this->input->post('eventId');
            if ($eventIds) {
                foreach ($eventIds as $eventId) {
                    $isDeleted = $this->resourceAllocation_model->delete('resource_allocation', 'id', $eventId);
                }
            } else {
                $isDeleted = $this->resourceAllocation_model->delete('resource_allocation', 'id', $event);
            }

            if ($isDeleted) {
                $process = 'Suprpession des affectation';
                $processFunction = 'RessourceAllocation/delete';
                $this->log($process, $processFunction);
            }

            if ($isDeleted && !$isAjaxRequest) {
                $this->session->set_flashdata('success', 'Affectation supprimée !');
                redirect('allocation_list');
            }

            echo json_encode(array('success' => 1, 'result' => 'Affectation(s) supprimée(s) !'));
        }
        catch (\Exception $exception)
        {
            if (!$isAjaxRequest) {
                $this->session->set_flashdata('error', $exception->getMessage());
                redirect('allocation_list');
            }
            echo json_encode(array('success' => 0, 'result' => $exception->getMessage()));
        }
    }

    private function getColors(): array
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

    private function daysOfTheWeek(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Lundi'
            ], [
                'id' => 2,
                'name' => 'Mardi'
            ], [
                'id' => 3,
                'name' => 'Mercredi'
            ], [
                'id' => 4,
                'name' => 'Jeudi'
            ], [
                'id' => 5,
                'name' => 'Vendredi'
            ], [
                'id' => 6,
                'name' => 'Samedi'
            ],
        ];
    }

    public function getDaysAjax(): void
    {
        echo json_encode(array('success' => 1, 'json' => $this->daysOfTheWeek(), 'placeholder' => 'Choisir le jour'));
    }

    public function getActions(): array
    {
        return [
            1 => 'Affectations',
            2 => 'Reservations'
        ];
    }
}