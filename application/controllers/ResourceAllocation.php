<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'base/BaseController.php';

class ResourceAllocation extends BaseController
{
    public function index()
    {
        $this->global['pageTitle'] = 'Events';
        $data['colors'] = $this->getColors();
        $data['levels'] = $this->level_model->getAll();
        $data['days'] = $this->daysOfTheWeek();
        $data['semesters'] = $this->semester_model->getAll();

        if ($levelId = $this->input->post('globalLevel')) {
            $data['allocations'] = json_encode($this->resourceAllocation_model->getByLevel($levelId));
            $data['levelId'] = $levelId;
        } else {
            $data['allocations'] = json_encode($this->resourceAllocation_model->getAll());
        }

        $this->loadViews("resource_allocation", $this->global, $data, NULL);
    }

    /**
     * ADD and UPDATE EVENTS
     */
    public function add()
    {
        $message = null;
        $lastId = null;
        $eventId = $this->input->post('eventId');

        $events = [
            'resource_id' => $this->input->post('resource'),
            'level_id' => $this->input->post('level'),
            'lesson_id' => $this->input->post('lesson'),
            'teacher_id' => $this->input->post('teacher'),
            'semester_id' => $this->input->post('semester'),
            'background_color ' => $this->input->post('backgroundColor'),
            'border_color ' => $this->input->post('borderColor'),
            'start_date' => $this->input->post('start'),
            'end_date' => $this->input->post('end'),
            'all_day ' => $this->input->post('allDay'),
        ];

        try
        {
            if ($eventId) {
                $this->resourceAllocation_model->update($events, $eventId);
                $message = 'Affectation mise à jour avec succès';
            } else {
                $lastId = $this->resourceAllocation_model->insert($events);
                $message = 'Affectation ajoutée avec succès';
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        if ($lastId or $eventId) {
            echo json_encode(array('success' => 1, 'result' => $message, 'eventId' => $lastId ?? $eventId));
        }
    }

    public function edit()
    {
        echo json_encode([
            'success' => 1,
            'result' => [
                'levels' => $this->level_model->getAll(),
                'lessons' => $this->lesson_model->getLessonsByLevelId($this->input->post('level')),
                'teacher' => $this->user_model->getTeacherByLesson($this->input->post('lesson')),
                'rooms' => $this->room_model->getRooms(),
                'semesters' => $this->semester_model->getAll(),
                'event' => $this->resourceAllocation_model->getById($this->input->post('event'))[0],
                'daysOfTheWeek' => $this->daysOfTheWeek(),
            ]
        ]);
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
}