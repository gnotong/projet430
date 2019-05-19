<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class Semester_model
 */
class Semester_model extends BaseModel
{
    private $table = 'semesters';
    /**
     * @return array $result : This is result
     */
    function getAll()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('year', 'desc');
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * @param int $semesterId
     * @return object|null
     */
    function getById(int $semesterId): ?object
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $semesterId);
        $query = $this->db->get();

        if (!$query->num_rows()) {
            return null;
        }

        return $query->result()[0];
    }
}

