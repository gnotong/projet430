<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class BaseModel extends CI_Model
{
    /**
     * @param string $table
     * @param array $data
     * @return mixed
     */
    function add(string $table, array $data): int
    {
        $this->db->trans_start();
        $this->db->insert($table, $data);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * @param string $table
     * @param array $data
     * @param string $filter
     * @param int $id
     * @return bool
     */
    function update(string $table, array $data, string $filter, int $id): bool
    {
        $this->db->where($filter, $id);
        $this->db->update($table, $data);

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

