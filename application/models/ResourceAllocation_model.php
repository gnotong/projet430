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

    public function getById(int $id)
    {
        $qb = $this->getBaseQuery();
        $qb->where('ra.id', $id);
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
            ra.id as eventId,
            re.label as title,
            re.id as roomId,
            re.label as name,
            start_date as start,
            end_date as end,
            all_day as allDay,
            background_color as backgroundColor,
            border_color as borderColor,
            ra.resource_id as resourceId,
            us.userId as teacherId,
            us.name as teacherName,
            le.name as levelName,
            le.id as levelId,
            ls.label as lessonName,
            ls.id as lessonId,
        ");
        $this->db->from("$this->event as ra");
        $this->db->join('resources as re','re.id = ra.resource_id');
        $this->db->join('users as us', 'us.userId = ra.teacher_id');
        $this->db->join('levels as le', 'le.id = ra.level_id');
        return $this->db->join('lessons as ls', 'ls.id = ra.lesson_id');
    }

    function insert($allocation)
    {
        $this->db->trans_start();
        $this->db->insert($this->event, $allocation);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * @param array $allocation
     * @param int $allocationId
     * @return mixed
     */
    function update(array $allocation, int $allocationId)
    {
        $this->db->trans_start();
        $this->db->where('id', $allocationId);
        $this->db->update($this->event, $allocation);

        $this->db->trans_complete();

        return true;
    }

    /**
     * @param string $table
     * @param string $filter
     * @param int $id
     * @return bool
     */
    function delete(string $table, string $filter, int $id): bool
    {
        $this->db->where($filter, $id);
        $this->db->delete($table);
        return true;
    }
}