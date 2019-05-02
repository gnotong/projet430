<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    /**
     * This function used to check the login credentials of the user
     * @param $email
     * @param $password
     * @return array
     */
    function loginMe($email, $password)
    {
        $this->db->select('
            u.userId, 
            u.password, 
            u.name,
            u.status,
            u.roleId, 
            r.role as role, 
            r.code as roleCode
        ');
        $this->db->from('users as u');
        $this->db->join('roles as r','r.roleId = u.roleId');
        $this->db->where('u.email', $email);
        $this->db->where('u.isDeleted', 0);
        $query = $this->db->get();
        
        $user = $query->result();
        
        if(!empty($user)){
            if(verifyHashedPassword($password, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function used to check email exists or not
     * @param $email
     * @return bool
     */
    function checkEmailExist($email)
    {
        $this->db->select('userId');
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function used to save login information of user
     * @param $logInfo
     */
    function loginsert($logInfo)
    {
        $this->db->trans_start();
        $this->db->insert('logs', $logInfo);
        $this->db->trans_complete();
    }

    /**
     * This function is used to get last login info by user id
     * @param number $userId : This is user id
     * @return number $result : This is query result
     */
    function lastLoginInfo($userId)
    {
        $this->db->select('u.createdDtm');
        $this->db->where('u.userId', $userId);
        $this->db->order_by('u.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('logs as u');

        return $query->row();
    }
}

?>