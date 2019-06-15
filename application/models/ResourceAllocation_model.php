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
    public function getByLevelWithoutSemester(int $levelId)
    {
        $qb = $this->getBaseQueryWithoutSemester();
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

    public function getByIdWithoutSemester(int $id)
    {
        $qb = $this->getBaseQueryWithoutSemester();
        $qb->where('ra.id', $id);
        $query = $qb->get();

        if ($query) {
            return $query->result();
        }

        return NULL;
    }

    function getAll() {
        $qb = $this->getBaseQuery();
        $qb->order_by("start_date", "asc");
        $query = $qb->get();

        if ($query) {
            return $query->result();
        }

        return NULL;
    }

    function getAllWithoutSemester() {
        $qb = $this->getBaseQueryWithoutSemester();
        $qb->order_by("start_date", "asc");
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
            CONCAT(se.year,' - ', se.name) as semesterName,
            se.id as semesterId
        ");
        $this->db->from("$this->event as ra");
        $this->db->join('resources as re','re.id = ra.resource_id');
        $this->db->join('users as us', 'us.userId = ra.teacher_id');
        $this->db->join('levels as le', 'le.id = ra.level_id');
        $this->db->join('lessons as ls', 'ls.id = ra.lesson_id');
        return $this->db->join('semesters as se', 'se.id = ra.semester_id');
    }

    /**
     * @return CI_DB_query_builder
     */
    private function getBaseQueryWithoutSemester(): CI_DB_query_builder
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
            ls.id as lessonId
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

    /**
     * @param int $teacherId
     * @return bool
     */
    function teacherIsInClass(int $teacherId): bool
    {
        $this->db->select('ra.*');
        $this->db->from("$this->event as ra");
        $this->db->where('ra.teacher_id', $teacherId);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    /**
     * @param int $lessonId
     * @return bool
     */
    function lessonIsBeingTeached(int $lessonId): bool
    {
        $this->db->select('ra.*');
        $this->db->from("$this->event as ra");
        $this->db->where('ra.lesson_id', $lessonId);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    /**
     * @param int $semesterId
     * @return bool
     */
    function semesterHasLessons(int $semesterId): bool
    {
        $this->db->select('ra.*');
        $this->db->from("$this->event as ra");
        $this->db->where('ra.semester_id', $semesterId);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    /**
     * @param int $levelId
     * @return bool
     */
    function levelHasBeenAllocated(int $levelId): bool
    {
        $this->db->select('ra.*');
        $this->db->from("$this->event as ra");
        $this->db->where('ra.level_id', $levelId);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    /**
     * @param int $resourceId
     * @return bool
     */
    function resourceHasBeenAllocated(int $resourceId): bool
    {
        $this->db->select('ra.*');
        $this->db->from("$this->event as ra");
        $this->db->where('ra.resource_id', $resourceId);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }
}