<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


require 'BaseModel.php';


/**
 * Class Lesson_model
 */
class Lesson_model extends BaseModel
{
    /**
     * @return array $result : This is result
     */
    function getAll(): array
    {
        $this->db->select('les.id, les.label, les.code, lev.name as levelName, us.name as teacher');
        $this->db->from('lessons as les');
        $this->db->join('level_lesson as ll','les.id = ll.lesson_id');
        $this->db->join('levels as lev','lev.id = ll.level_id');
        $this->db->join('teacher_lesson as tl','tl.lesson_id = les.id');
        $this->db->join('users as us','us.userId = tl.teacher_id');
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * @param int $lessionId
     * @return null|object $result
     */
    function getLessonById(int $lessionId): ?object
    {
        $this->db->select('les.id, les.label, les.code, lev.id as levelId, tl.teacher_id as teacherId, lev.name as levelName');
        $this->db->from('lessons as les');
        $this->db->join('level_lesson as ll','les.id = ll.lesson_id');
        $this->db->join('teacher_lesson as tl','tl.lesson_id = ll.lesson_id', 'left');
        $this->db->join('levels as lev','lev.id = ll.level_id');
        $this->db->where('les.id', $lessionId);
        $query = $this->db->get();

        if (!$query->num_rows()) {
            return null;
        }

        return $query->result()[0];
    }

    /**
     * @param int $levelId
     * @return null|array $result
     */
    function getLessonsByLevelId(int $levelId): ?array
    {
        $this->db->select('*');
        $this->db->from('lessons as les');
        $this->db->join('level_lesson as ll','les.id = ll.lesson_id');
        $this->db->where('ll.level_id', $levelId);
        $query = $this->db->get();

        if (!$query->num_rows()) {
            return null;
        }

        return $query->result();
    }

}

