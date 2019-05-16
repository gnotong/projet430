<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ResourceAllocation_model extends CI_Model {

    private $event = 'resource_allocation';

    public function getByLevel(int $levelId)
    {
        $qb = $this->getBaseQuery();
        $qb->where('ra.level_id', $levelId);
        $query = $qb->get();

        if ($query) {
            return $query->result();
        }

        return NULL;
    }

    function getAll() {
        $qb = $this->getBaseQuery();
        $query = $qb->get();

        if ($query) {
            return $query->result();
        }

        return NULL;
    }

    /**
     * @return CI_DB_query_builder
     */
    private function getBaseQuery(): CI_DB_query_builder
    {
        $this->db->select("
            re.label as title,
            start_date as start,
            end_date as end,
            all_day as allDay,
            background_color as backgroundColor,
            border_color as borderColor,
            ra.resource_id as resourceId
        ");
        $this->db->from("$this->event as ra");
        return $this->db->join('resources as re','re.id = ra.resource_id');
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