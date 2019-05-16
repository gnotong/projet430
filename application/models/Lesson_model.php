<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * TODO: factoriser les méthodes add, delete, edit dans un BaseModel, comme ça uniquement les BaseModel sera
 * TODO: chargé au niveau du base controller
 * Class Lesson_model
 */
class Lesson_model extends CI_Model
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
     * @param $lessonInfo
     * @return mixed
     */
    function add(array $lessonInfo): int
    {
        $this->db->trans_start();
        $this->db->insert('lessons', $lessonInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * @param array $lessonInfo
     * @param int $lessonId
     * @return bool
     */
    function update(array $lessonInfo, int $lessonId): bool
    {
        $this->db->where('id', $lessonId);
        $this->db->update('lessons', $lessonInfo);

        return true;
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
<<<<<<< Updated upstream
     * @param $levelLesson
     * @return mixed
     */
    function addLevelLesson(array $levelLesson): void
    {
        $this->db->trans_start();
        $this->db->insert('level_lesson', $levelLesson);
        $this->db->trans_complete();
    }

    /**
     * @param array $teacherLesson
     */
    function addTeacherLesson(array $teacherLesson): void
    {
        $this->db->trans_start();
        $this->db->insert('teacher_lesson', $teacherLesson);
        $this->db->trans_complete();
    }

    /**
     * @param array $levelLessonInfo
     * @param int $lessonId
     */
    function updateLevelLesson(array $levelLessonInfo, int $lessonId): void
    {
        $this->db->where('lesson_id', $lessonId);
        $this->db->update('level_lesson', $levelLessonInfo);
    }

    /**
     * @param array $teacherLesson
     * @param int $lessonId
     */
    function updateTeacherLesson(array $teacherLesson, int $lessonId): void
    {
        $this->db->where('lesson_id', $lessonId);
        $this->db->update('teacher_lesson', $teacherLesson);
    }

    /**
     * @param int $lessonId
     * @return bool
     */
    function delete(int $lessonId): bool
    {
        $this->db->where('id', $lessonId);
        $this->db->delete('lessons');
        return true;
    }

    /**
     * @param int $lessonId
     */
    function deleteLevelLesson(int $lessonId): void
    {
        $this->db->where('lesson_id', $lessonId);
        $this->db->delete('level_lesson');
    }

    /**
     * @param int $lessonId
     * @return bool
     */
    function deleteTeacherLesson(int $lessonId): bool
    {
        $this->db->where('lesson_id', $lessonId);
        $this->db->delete('teacher_lesson');
        return true;
    }
=======
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

>>>>>>> Stashed changes
}

