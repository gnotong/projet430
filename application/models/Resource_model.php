<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Resource_model extends CI_Model
{
    /**
     * This function is used to get resources
     */
    function getResources()
    {
        $this->db->select('
            res.id, 
            res.label as name, 
            res.description, 
            res.created, 
            usr.name as creator, 
            rol.role as creatorRole, 
            cat.label as category'
        );
        $this->db->from('resources as res');
        $this->db->join('categories as cat','cat.id = res.categoryId');
        $this->db->join('users as usr','usr.userId = res.createdBy');
        $this->db->join('roles as rol','rol.roleId = usr.roleId');
        $this->db->order_by("res.created", "desc");
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
     * @param array $resourceInfo
     * @return
     */
    function add(array $resourceInfo)
    {
        $this->db->trans_start();
        $this->db->insert('resources', $resourceInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to add a new task
     */
    function addCategory($category)
    {
        $this->db->trans_start();
        $this->db->insert('categories', $category);

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
        $this->db->from('resources');
        $this->db->where('id', $resourceId);
        $query = $this->db->get();
        
        return $query->result()[0];
    }

    function getResourceByCategory(int $resourceTypeId)
    {
        $this->db->select('re.id, re.label as name');
        $this->db->from('resources as re');
        $this->db->join('categories as ca','ca.id = re.categoryId');
        $this->db->where('re.categoryId', $resourceTypeId);
        $query = $this->db->get();

        return $query->result();
    }
    
    /**
     * This function is used to edit resources
     */
    function editResource($resourceInfo, $resourceId)
    {
        $this->db->where('id', $resourceId);
        $this->db->update('resources', $resourceInfo);
        
        return $this->db->affected_rows();
    }
    
    /**
     * This function is used to delete resources
     */
    function deleteResource($resourceId)
    {
        $this->db->where('id', $resourceId);
        $this->db->delete('resources');
        return TRUE;
    }

    /**
     * This function is used to complete resources
     */
    function endResource($resourceId, $resourceInfo)
    {
        $this->db->where('id', $resourceId);
        $this->db->update('resources', $resourceInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get the resources count
     * @return array $result : This is result
     */
    function resourcesCount()
    {
        $this->db->select('*');
        $this->db->from('resources as BaseTbl');
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
        $this->db->from('resources as BaseTbl');
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
        $this->log($process,$processFunction);

        $this->global['pageTitle'] = 'UY1: Toutes les ressources';

        $this->loadViews("eresource", $this->global, $data, NULL);
    }

    function truncate()
    {
        $this->db->truncate('resources');
    }

    function truncateCategory()
    {
        $this->db->truncate('categories');
    }
}

  