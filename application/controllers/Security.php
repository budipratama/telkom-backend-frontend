<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model(array('admin_model', 'auth_model'));
        $this->data['css_admin'] = $this->config->item('css_admin_patch');
        $this->data['js_admin'] = $this->config->item('js_admin_patch');
    }
	public function index(){
		redirect('dashboard');
	}
	public function change_password(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'change_password');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/change_password';
		$this->data['title_page'] = 'Change Password';
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
        $this->data['menuListData'] = $this->menuSidebar();
		$this->data['provinsiDataList'] = $provinsiData;
		$this->load->view('admin/layout', $this->data);
	}
	public function reset_password(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'reset_password');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/reset_password';
		$this->data['title_page'] = 'Reset Password';
		$userCmsList = $this->admin_model->get_all_data('f_cms_user');
		$this->data['userCmsList'] = $userCmsList;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function reset_password_detail(){
		$this->checkPostData();
		$userId = $this->input->post('userId');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'reset_password');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/reset_password_detail';
		$this->data['title_page'] = 'Reset Password';
		$where = array('ID'=>$userId);
		$userData = $this->admin_model->get_where_data('f_cms_user', $where);
		$this->data['userData'] = $userData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function reset_password_save(){
		$this->checkPostData();
		$userId = $this->input->post('userId');
		$userPass = $this->input->post('userPass');
		$changePass = $this->auth_model->changePassword($userId, $userPass);
		if($changePass){
			$res = array('result' => TRUE, 'message' => "Change Password Success");
		}else{
			$res = array('result' => FALSE, 'message' => "Change Password failed");
		}
		echo json_encode($res);

	}
	public function user_info(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'user_info');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/user_info';
		$this->data['title_page'] = 'User Info';
		$userCmsList = $this->admin_model->get_all_data('f_cms_user');
		$levelList = $this->admin_model->get_all_data('f_cms_level');
		$this->data['levelList'] = $levelList;
		$this->data['userCmsList'] = $userCmsList;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	public function user_info_detail(){
		$this->checkPostData();
		$userId = $this->input->post('userId');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'user_info');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/user_info_detail';
		$this->data['title_page'] = 'User Info';
		$where = array('ID'=>$userId);
		$userData = $this->admin_model->get_where_data('f_cms_user', $where);
		$levelList = $this->admin_model->get_all_data('f_cms_level');
		$this->data['levelList'] = $levelList;
		$this->data['userData'] = $userData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function user_info_save(){
		$this->checkPostData();
		$userId = $this->input->post('userId');
		$userName = $this->input->post('userName');
		$userRealName = $this->input->post('userRealName');
		$userLevel = $this->input->post('userLevel');
		if(isset($userId)){
			$tabel_name = 'f_cms_user';
			$where = array('ID' => $userId);
			$postData = array('USERNAME' => $userName, 'REALNAME' => $userRealName, 'LEVEL' => $userLevel, 'STATUS' => 1);
			$update = $this->admin_model->updateDb($tabel_name, $where, $postData);
			// $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Update user level Success'));
			$res = array('result' => TRUE, 'message' => 'Update Success');
			echo json_encode($res);
		}else{
			$userPass = $this->input->post('userPass');
			$tabel_name = 'f_cms_user';
			$postData = array('USERNAME' => $userName, 'PASSWORD' => sha1($userPass), 'REALNAME' => $userRealName, 'USERTYPE' => 1, 'LEVEL' => $userLevel, 'STATUS' => 1, 'CREATEDBY' => 'Root', 'CREATEDON' => date('Y-m-d h:m:s'));
			$addData = $this->admin_model->addDb($tabel_name, $postData);
			if($addData){
				$this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user info Success'));
				redirect('security/user_info');
			}
		}
	}
	function user_info_add(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'user_info');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/user_info_detail';
		$this->data['title_page'] = 'Add User Info';
		$moduleData = $this->admin_model->get_all_data('f_cms_module');
		$levelList = $this->admin_model->get_all_data('f_cms_level');
		$this->data['levelList'] = $levelList;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->data['moduleData'] = $moduleData;
		$this->load->view('admin/layout', $this->data);
	}
	function user_info_delete(){
		$this->checkPostData();
		$id = $this->input->post('id');
		$where = array('ID' => $id);
		$delete = $this->admin_model->delete_where('f_cms_user', $where);
		if($delete){
			$res = array('result' => TRUE, 'message' => 'Delete Success');
		}
		echo json_encode($res);
	}
	public function user_level(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'user_level');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/user_level';
		$this->data['title_page'] = 'User Level';
		$levelList = $this->admin_model->get_user_all_level();
        $this->data['menuListData'] = $this->menuSidebar();
		$this->data['levelList'] = $levelList;
		$this->load->view('admin/layout', $this->data);
	}
	function user_level_add(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'user_level');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/user_level_detail';
		$this->data['title_page'] = 'Add User Level';
		$moduleData = $this->admin_model->get_all_data('f_cms_module');
        $this->data['menuListData'] = $this->menuSidebar();
		$this->data['moduleData'] = $moduleData;
		$this->load->view('admin/layout', $this->data);
	}
	public function user_level_detail(){
		$this->checkPostData();
		$levelId = $this->input->post('id');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'security',
               'child_menu_active'  => 'user_level');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/security/user_level_detail';
		$this->data['title_page'] = 'User Level Detail';
		$where = array('ID'=>$levelId);
		$levelData = $this->admin_model->get_where_data('f_cms_level', $where);

		// prevent edit root level
		if(isset($levelData[0]['LEVELNAME']) && ($levelData[0]['LEVELNAME'] == 'root') )
			redirect('security/user_level');

		$moduleData = $this->admin_model->get_where_data('f_cms_module', array('STATUS' => 1));
        $this->data['menuListData'] = $this->menuSidebar();
		$this->data['levelData'] = $levelData;
		$this->data['moduleData'] = $moduleData;
		$this->load->view('admin/layout', $this->data);
	}
	function user_level_save(){
		$this->checkPostData();
		$levelId = $this->input->post('levelId');
		$levelName = $this->input->post('levelName');
		$levelDesc = $this->input->post('levelDesc');
		$levelAccess = $this->input->post('levelAccess');
                if($levelAccess != ''){
                    $levelAccessImp = implode(',', $levelAccess);
                }else{
                    $levelAccessImp = '';
                }
		if($this->input->post('levelId')){
			$tabel_name = 'f_cms_level';
			$where = array('ID' => $levelId);
			$postData = array('LEVELNAME' => $levelName, 'DESCRIPTION' => $levelDesc, 'ACCESS' => $levelAccessImp);
			$update = $this->admin_model->updateDb($tabel_name, $where, $postData);
			$this->session->set_flashdata(array('result' => TRUE, 'message' => 'Update user level Success'));
			redirect('security/user_level');
		}else{
			$tabel_name = 'f_cms_level';
			$postData = array('LEVELNAME' => $levelName, 'DESCRIPTION' => $levelDesc, 'ACCESS' => $levelAccessImp, 'STATUS' => 1);
			$addData = $this->admin_model->addDb($tabel_name, $postData);
			if($addData){
				$this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user level Success'));
				redirect('security/user_level');
			}
		}

	}
	function user_level_delete(){
		$this->checkPostData();
		$levelId = $this->input->post('levelId');
		$where = array('ID' => $levelId);
		$delete = $this->admin_model->delete_where('f_cms_level', $where);
		if($delete){
			$res = array('result' => TRUE, 'message' => 'Delete Success');
		}
		echo json_encode($res);
	}
	function updatePassword(){
		$this->checkPostData();
		$curnPass = $this->input->post('curnPass');
		$newPass = $this->input->post('newPass');
		$userId = $this->session->userdata('userId');
		$checkCurnPass = $this->auth_model->checkCurnPass($userId, $curnPass);
		if($checkCurnPass){
			$changePass = $this->auth_model->changePassword($userId, $newPass);
			$res = array('result' => TRUE, 'message' => "Change Password Success");
		}else{
			$res = array('result' => FALSE, 'message' => "Current Password Does'nt Match ");
		}
		echo json_encode($res);
	}
}
