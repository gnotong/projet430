<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Resource_model extends CI_Model
{
    /**
     * This function is used to get resources
     */
    function getResources()
    {
        $this->db->select('*');
        $this->db->from('tasks as TaskTbl');
        $this->db->join('users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('roles as Roles','Roles.roleId = Users.roleId');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get resource categories
     */
    function getResourcesCategories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get task situations
     */
    function getResourcesSituations()
    {
        $this->db->select('*');
        $this->db->from('tbl_tasks_situations');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to add a new task
     */
    function addNewResource($resourceInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tasks', $resourceInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function used to get task information by id
     * @param number $resourceId : This is task id
     * @return array $result : This is task information
     */
    function getResourceInfo($resourceId)
    {
        $this->db->select('*');
        $this->db->from('tasks');
        $this->db->where('id', $resourceId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to edit resources
     */
    function editResource($resourceInfo, $resourceId)
    {
        $this->db->where('id', $resourceId);
        $this->db->update('tasks', $resourceInfo);
        
        return $this->db->affected_rows();
    }
    
    /**
     * This function is used to delete resources
     */
    function deleteResource($resourceId)
    {
        $this->db->where('id', $resourceId);
        $this->db->delete('tasks');
        return TRUE;
    }

    /**
     * This function is used to return the size of the table
     * @param string $tablename : This is table name
     * @param string $dbname : This is database name
     * @return array $return : Table size in mb
     */
    function gettablemb($tablename,$dbname)
    {
        $this->db->select('round(((data_length + index_length)/1024/1024),2) as total_size');
        $this->db->from('information_schema.tables');
        $this->db->where('table_name', $tablename);
        $this->db->where('table_schema', $dbname);
        $query = $this->db->get($tablename);
        
        return $query->row();
    }

    /**
     * This function is used to complete resources
     */
    function endResource($resourceId, $resourceInfo)
    {
        $this->db->where('id', $resourceId);
        $this->db->update('tasks', $resourceInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get the resources count
     * @return array $result : This is result
     */
    function resourcesCount()
    {
        $this->db->select('*');
        $this->db->from('tasks as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the finished resources count
     * @return array $result : This is result
     */
    function finishedResourcesCount()
    {
        $this->db->select('*');
        $this->db->from('tasks as BaseTbl');
        $this->db->where('BaseTbl.statusId', 2);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to open the resources page for users (no edit/delete etc)
     */
    function eresource()
    {
        $data['resourcesRecords'] = $this->user_model->getResources();

        $process = 'Toutes les Ressources';
        $processFunction = 'User/eresource';
        $this->logrecord($process,$processFunction);

        $this->global['pageTitle'] = 'UY1: Toutes les ressources';

        $this->loadViews("eresource", $this->global, $data, NULL);
    }
}

  