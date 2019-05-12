<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'base/BaseController.php';

class ResourceCalendar extends BaseController
{

    public function index() {
        $this->global['pageTitle']  = 'Events';
        $this->loadViews("resource_calendar", $this->global, null, NULL);
    }

    public function loadData() {
        $events = $this->resourceCalendar_model->get_event_list();
        if($events !== NULL) {
            echo json_encode(array('success' => 1, 'result' => $events));
        } else {
            echo json_encode(array('success' => 0, 'error' => 'Event not found'));
        }
    }

}