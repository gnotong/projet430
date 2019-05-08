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
     * This function used to get user information by id
     * @param int $userId : This is user id
     * @return object $result : This is user
     */
    function getUserById(int $userId): object
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();

        return $query->result()[0];
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param $email
     * @param int $userId
     * @return boolean
     */
    function checkEmailExists($email, $userId = 0): bool
    {
        $this->db->select("email");
        $this->db->from("users");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if ($userId != 0) {
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }


    /**
     * This function is used to add new user to system
     * @param $userInfo
     * @return mixed
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
     * @param $userId
     * @param $userInfo
     * @return mixed
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
     * This function is used to get the logs count
     * @return int
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
     * @return int
     */
    function usersCount()
    {
        $this->db->select('*');
        $this->db->from('users as BaseTbl');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function truncate()
    {
        $this->db->truncate('users');
    }
}

