<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @return array $result : This is result
     */
    function getAll()
    {
        $this->db->select('u.userId, u.email, u.name, u.mobile, r.role');
        $this->db->from('users as u');
        $this->db->join('roles as r', 'r.roleId = u.roleId', 'left');
        $this->db->where('u.isDeleted', 0);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('roles');
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("users");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if ($userId != 0) {
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function add($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('users', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();

        return $query->result()[0];
    }

    /**
     * This function is used to update the user information
     * @param $userInfo
     * @param $userId
     * @return bool
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('users', $userInfo);

        return TRUE;
    }

    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('users', $userInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function is used to match users password for change password
     * @param $userId
     * @param $oldPassword
     * @return array
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('users');

        $user = $query->result();

        if (empty($user) || !verifyHashedPassword($oldPassword, $user[0]->password)) {
            return array();
        }

        return $user;

    }


    function matchPassword($password, $verification)
    {
        return strcmp($password, $verification) === 0;
    }

    /**
     * This function is used to change users password
     * @param $userId
     * @param $userInfo
     * @return mixed
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('users', $userInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function is used to get user log history count
     * @param $userId
     * @return mixed
     */
    function logHistoryCount($userId)
    {
        $this->db->select('*');
        $this->db->from('logs as BaseTbl');

        if ($userId == NULL) {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            $this->db->where('BaseTbl.userId', $userId);
            $query = $this->db->get();
            return $query->num_rows();
        }
    }

    /**
     * This function is used to get user log history
     * @param number $userId : This is user id
     * @return array $result : This is result
     */
    function logHistory($userId)
    {
        $this->db->select('*');
        $this->db->from('logs as BaseTbl');

        if ($userId == NULL) {
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        } else {
            $this->db->where('BaseTbl.userId', $userId);
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();

        return $query->row();
    }

    /**
     * This function is used to get resources
     */
    function getResources()
    {
        $this->db->select('*');
        $this->db->from('resources as TaskTbl');
        $this->db->join('users as Users', 'Users.userId = TaskTbl.createdBy');
        $this->db->join('roles as Roles', 'Roles.roleId = Users.roleId');
        $this->db->join('categories as cat', 'cat.id = TaskTbl.categoryId');
        $this->db->order_by('TaskTbl.created DESC');
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
        $this->db->insert('resources', $resourceInfo);

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
        $this->db->join('categories as cat', 'cat.id = resources.categoryId');
        $this->db->where('id', $resourceId);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to get the logs count
     * @return array $result : This is result
     */
    function logsCount()
    {
        $this->db->select('*');
        $this->db->from('logs as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the users count
     * @return array $result : This is result
     */
    function usersCount()
    {
        $this->db->select('*');
        $this->db->from('users as BaseTbl');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getUserStatus($userId)
    {
        $this->db->select('BaseTbl.status');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->limit(1);
        $query = $this->db->get('users as BaseTbl');

        return $query->row();
    }
}

  