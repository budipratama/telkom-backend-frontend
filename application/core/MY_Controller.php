<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public $data = array();
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model(array('admin_model'));
        $this->isLogin();
        // $this->data['menuListData'] = $this->menuSidebar();
        date_default_timezone_set("Asia/Jakarta");
    }
    function isLogin(){
        if($this->session->userdata('login')){
            return TRUE;
        }else{
            redirect('auth/logout');
        }
    }
    function checkPostData(){
        if($this->input->post()){
            return true;
        }else{
            redirect('error');
        }
    }
    public function debug($string)
    {
        echo "<pre>";
        print_r($string);
        echo "</pre>";
    }

    function menuSidebar(){
        $userData = $this->admin_model->get_where_data('f_cms_user', array('ID' => $this->session->userdata('userId')));
        $userLevelData = $this->admin_model->get_where_data('f_cms_level', array('ID' => $userData[0]['LEVEL']));
        $userAccess = explode(",", $userLevelData[0]['ACCESS']);

        $arrayMenuDataPush = array();
        foreach ($userAccess as $key => $value) {
            $arrayWhere = array('CODE' => $value, 'STATUS' => 1);
            $this->db->order_by('CODE');
            $arrayMenu = $this->db->where($arrayWhere)->get('f_cms_module')->row_array();
            if (!empty($arrayMenu)) {
                $arrayMenuDataPush[] = $arrayMenu;
            }
        }
        $val = $this->recrusiveMenu($arrayMenuDataPush,0,0);
        /*foreach ($arrayMenuDataPush as $key => $value) {
            $parentID = '';
            if(isset($value[0]['CHILDID']) && $value[0]['CHILDID'] == 0){
                $parentID = $value[0]['CODE'];
                $parent_active = '';
                if($this->session->flashdata('parent_menu_active') == $value[0]['ACTIVENAME']){
                    $parent_active = ' active';
                }else{
                    $parent_active = '';
                }
                $val .= '<li class="treeview '.$parent_active.'">';
                $val .= '<a href="#">
                            <i class="'.$value[0]['ICON'].'"></i>
                            <span>'.$value[0]['NAME'].'</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>';
                $val .= '<ul class="treeview-menu">';
                $val .= $this->getChildMenu($parentID, $arrayMenuDataPush);
                $val .= '</ul>';
                $val .= '</li>';
            }
        }*/
/*        echo "<pre>" . print_r($val,1) . "</pre>";
        exit;*/
        return $val;
    }

    function getChildMenu($parentID, $arrayMenuDataPush){
        $valChild = '';
        foreach ($arrayMenuDataPush as $key => $value) {
            if(isset($value[0]['CHILDID']) && $value[0]['CHILDID'] == $parentID){
                $active_child = '';
                if($this->session->flashdata('child_menu_active') == $value[0]['ACTIVENAME']){
                    $active_child = 'active';
                }else{
                    $active_child = '';
                }
                $valChild .= '<li  class="'.$active_child.'"><a href="'.base_url().$value[0]['LINK'].'"><i class="'.$value[0]['ICON'].'"></i> '.$value[0]['NAME'].'</a></li>';
            }
        }
        return $valChild;
    }

    protected function recrusiveMenu($array, $parent_id)
    {   
        $val = '';

       foreach ($array as $value) {
            if ($value['CHILDID'] == $parent_id) {
                $child = $this->recrusiveMenu($array, $value['CODE']);
                $treeview = (empty($child))?'':'treeview';
                $arrow = (empty($child))?'':'<i class="fa fa-angle-left pull-right"></i>';
                $active = ($this->session->flashdata('child_menu_active') == $value['ACTIVENAME'] || $this->session->flashdata('parent_menu_active') == $value['ACTIVENAME'] || $this->session->flashdata('other_menu_active') == $value['ACTIVENAME'])?'active':'';

                $val .= '<li class="'.$treeview. ' ' .$active.'">';
                $val .= '<a href="'. site_url($value["LINK"]) .'">
                            <i class="'.$value['ICON'].'"></i>
                            <span>'.$value['NAME'].'</span>
                            '.$arrow.'
                        </a>';
                if (!empty($child)) {
                    $val .= '<ul class="treeview-menu">';
                    $val .= $child;
                    $val .= '</ul>';
                }
                $val .= '</li>';
            }
       }

       return $val;
    }
}
