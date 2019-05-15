<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class Level_model
 */
class Level_model extends BaseModel
{
    /**
     * @return array $result : This is result
     */
    function getAll()
    {
        $this->db->select('*');
        $this->db->from('levels');
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * @param int $levelId
     * @return null|object $result
     */
    function getLevelById(int $levelId): ?object
    {
        $this->db->select('les.*');
        $this->db->from('levels as les');
        $this->db->where('les.id', $levelId);
        $query = $this->db->get();

        if (!$query->num_rows()) {
            return null;
        }

        return $query->result()[0];
    }
}

