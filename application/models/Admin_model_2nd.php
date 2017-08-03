<?php
class Admin_model_2nd extends CI_Model{
	  function __construct(){
        parent::__construct();
  	}

    function get_customer_where_in($where,$in){
        return $this->db->where_in($where,$in)
            ->get(T_CUST)
            ->result_array();
    }

    public function update_customer($id,$data){
        return $this->db->where('ID',$id)->update(T_CUST,$data);
    }
}
