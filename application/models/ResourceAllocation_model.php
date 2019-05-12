<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ResourceAllocation_model extends CI_Model {

    private $event = 'resource_allocation';

    function getAll() {
        $this->db->select("
            re.label as title, 
            start_date as start, 
            end_date as end, 
            all_day as allDay, 
            background_color as backgroundColor, 
            border_color as borderColor,
            ra.resource_id as resourceId,
            ra.resource_type_id as resourceTypeId
        ");
        $this->db->from("$this->event as ra");
        $this->db->join('resources as re','re.id = ra.resource_id');
        $query = $this->db->get();

        if ($query) {
            return $query->result();
        }
        return NULL;
    }


    function insert($allocation)
    {
        $this->db->trans_start();
        $this->db->insert($this->event, $allocation);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

}