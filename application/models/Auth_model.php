<?php
class Auth_model extends CI_Model{
	  function __construct(){
        parent::__construct();
        define('T_CMS_USER', 'f_cms_user');

  	}
    	function compareUserPassword($username, $userpass){
        $query = $this->db->select('CU.ID as USERID, CU.*, CL.*')
          ->from(T_CMS_USER.' as CU')
          ->join('f_cms_level as CL', 'CL.ID = CU.LEVEL')
          ->where('USERNAME', $username)
          ->where('PASSWORD', sha1($userpass))
          ->get();
        // echo $this->db->last_query();  die();
        $user = $query->row_array();

        return $user;
  	}
  	function checkCurnPass($userId, $curnPass){
        $query = $this->db->get_where(T_CMS_USER, array('ID' => $userId, 'PASSWORD' => sha1($curnPass)));
        return $query->row_array();
  	}
  	function changePassword($userId, $newPass){
        return $this->db->where('ID',$userId)->update(T_CMS_USER,array('PASSWORD' => sha1($newPass)));
  	}
}
