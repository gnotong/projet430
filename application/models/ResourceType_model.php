<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ResourceType_model extends CI_Model
{
    /**
     * @return array
     */
    function getResourceTypes(): array
    {
        $this->db->select('
            ca.id, 
            ca.label as name
        ');
        $this->db->from('categories as ca');
        $query = $this->db->get();
        return $query->result();
    }
}

  