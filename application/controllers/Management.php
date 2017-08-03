<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends MY_Controller {

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
        $this->load->model(array('admin_model'));
        $this->data['css_admin'] = $this->config->item('css_admin_patch');
        $this->data['js_admin'] = $this->config->item('js_admin_patch');
    }
	public function index(){
		redirect('dashboard');
	}
	public function city(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'city');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/city';
		$this->data['title_page'] = 'Management City';
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$arrayCity = array();
		foreach ($cityData as $keyCity => $valueCity) {
			foreach ($provinsiData as $keyProvinsi => $valueProvinsi) {
				if($valueCity['ID_PROVINSI'] == $valueProvinsi['ID_PROVINSI']){
					$arrayCity[] = array('cityId'=>$valueCity['ID_KABUPATEN'], 'cityName'=>$valueCity['NAMA_KABUPATEN'],'cityAlias'=> $valueCity['KODE_KABUPATEN'], 'STATUS'=>$valueCity['STATUS'], 'provinceName'=>$valueProvinsi['NAMA_PROVINSI']);
				}
			}
		}
		$this->data['cityDataList'] = $arrayCity;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function city_detail(){
		$this->checkPostData();
		$cityId = $this->input->post('id');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'city');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/city_detail';
		$this->data['title_page'] = 'Management City';
		$where = array('ID_KABUPATEN'=>$cityId);
		$cityData = $this->admin_model->get_where_data('f_kabkota', $where);
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$this->data['cityData'] = $cityData;
		$this->data['provinsiData'] = $provinsiData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function city_add(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'city');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/city_detail';
		$this->data['title_page'] = 'Management City';
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
                $this->data['menuListData'] = $this->menuSidebar();
		$this->data['provinsiData'] = $provinsiData;
		$this->load->view('admin/layout', $this->data);
	}
	function city_save(){
		$this->checkPostData();
		$cityId = $this->input->post('cityId');
		$cityName = $this->input->post('cityName');
		$provId = $this->input->post('provId');
		$cityCode = $this->input->post('cityCode');
		$active = $this->input->post('active');
		if($active == ''){
			$active = 0;
		}
		if(isset($cityId)){
			$tabel_name = 'f_kabkota';
			$where = array('ID_KABUPATEN' => $cityId);
			$postData = array('NAMA_KABUPATEN' => $cityName, 'ID_PROVINSI' => $provId, 'KODE_KABUPATEN' => $cityCode, 'STATUS' => $active, 'UPDATED_ON' => date('Y-m-d h:m:s'), 'UPDATED_BY' => $this->session->userdata('username'));
			$update = $this->admin_model->updateDb($tabel_name, $where, $postData);
			// $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Update user level Success'));
			$res = array('result' => TRUE, 'message' => 'Update Success');
			echo json_encode($res);
		}else{
			$tabel_name = 'f_kabkota';
			$postData = array('NAMA_KABUPATEN' => $cityName, 'ID_PROVINSI' => $provId, 'KODE_KABUPATEN' => $cityCode, 'STATUS' => $active, 'CREATED_ON' => date('Y-m-d h:m:s'), 'CREATED_BY' => $this->session->userdata('username'));
			$addData = $this->admin_model->addDb($tabel_name, $postData);
			if($addData){
				$this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user info Success'));
				redirect('management/city');
			}
		}
	}
	function city_delete(){
		$this->checkPostData();
		$id = $this->input->post('id');
		$where = array('ID_KABUPATEN' => $id);
		$delete = $this->admin_model->delete_where('f_kabkota', $where);
		if($delete){
			$res = array('result' => TRUE, 'message' => 'Delete Success');
		}
		echo json_encode($res);
	}
	public function province(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'province');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/province';
		$this->data['title_page'] = 'Management Province';
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$this->data['provinsiDataList'] = $provinsiData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function province_detail(){
		$this->checkPostData();
		$id = $this->input->post('id');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'province');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/province_detail';
		$this->data['title_page'] = 'Management Province';
		$where = array('ID_PROVINSI'=>$id);
		$provinsiData = $this->admin_model->get_where_data('f_provinsi', $where);
		$this->data['provinsiData'] = $provinsiData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function province_save(){
		$this->checkPostData();
		$provId = $this->input->post('provId');
		$provName = $this->input->post('provName');
		$active = $this->input->post('active');
		if($active == ''){
			$active = 0;
		}
		if(isset($provId)){
			$tabel_name = 'f_provinsi';
			$where = array('ID_PROVINSI' => $provId);
			$postData = array('NAMA_PROVINSI' => $provName,  'STATUS' => $active, 'UPDATED_ON' => date('Y-m-d h:m:s'), 'UPDATED_BY' => $this->session->userdata('username'));
			$update = $this->admin_model->updateDb($tabel_name, $where, $postData);
			// $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Update user level Success'));
			$res = array('result' => TRUE, 'message' => 'Update Success');
			echo json_encode($res);
		}else{
			$tabel_name = 'f_provinsi';
			$postData = array('NAMA_PROVINSI' => $provName, 'STATUS' => $active, 'CREATED_ON' => date('Y-m-d h:m:s'), 'CREATED_BY' => $this->session->userdata('username'));
			$addData = $this->admin_model->addDb($tabel_name, $postData);
			if($addData){
				$this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user info Success'));
				redirect('management/province');
			}
		}
	}
	function province_add(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'province');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/province_detail';
		$this->data['title_page'] = 'Management Province';
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function province_delete(){
		$this->checkPostData();
		$id = $this->input->post('id');
		$where = array('ID_PROVINSI' => $id);
		$delete = $this->admin_model->delete_where('f_provinsi', $where);
		if($delete){
			$res = array('result' => TRUE, 'message' => 'Delete Success');
		}
		echo json_encode($res);

	}
	public function customer_level(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'customer_level');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/customer_level';
		$this->data['title_page'] = 'Customer Level';
		$listLevel = $this->admin_model->get_all_data('f_cust_level');
		$this->data['listLevel'] = $listLevel;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
        function customer_level_add(){
            $sessionMenu = array(
           'parent_menu_active'  => 'management',
           'child_menu_active'  => 'customer_level');
            $this->session->set_flashdata($sessionMenu);
            $this->data['content_page'] = 'admin/pages/management/customer_level_detail';
            $this->data['title_page'] = 'Customer Level';
            $moduleLevelData = $this->admin_model->get_all_data('f_cust_level_module');
            $this->data['menuListData'] = $this->menuSidebar();
            $this->data['moduleLevelData'] = $moduleLevelData;

            // get group fee
            $this->data['group_fee'] = $this->admin_model->get_all_group_fee();

            // get next customer type ID
            $this->data['next_cust_type_id'] = $this->admin_model->next_cust_type_id();

            $this->load->view('admin/layout', $this->data);
	}

	function customer_level_detail(){
		$this->checkPostData();
		$id = $this->input->post('id');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'customer_level');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/customer_level_detail';
		$this->data['title_page'] = 'Customer Level';
		$where = array('ID'=>$id);
		$custLevel = $this->admin_model->get_where_data('f_cust_level', $where);
		$whereAcl = array('LEVELID'=>$id);
		$custLevelAcl = $this->admin_model->get_where_data('f_cust_level_acl', $whereAcl);
		$moduleLevelData = $this->admin_model->get_all_data('f_cust_level_module');
		$this->data['custLevel'] = $custLevel;
		$this->data['custLevelAcl'] = $custLevelAcl;
		$this->data['moduleLevelData'] = $moduleLevelData;
                $this->data['menuListData'] = $this->menuSidebar();

        // get group fee
        $this->data['group_fee'] = $this->admin_model->get_all_group_fee();

		$this->load->view('admin/layout', $this->data);
	}

    function customer_level_save(){
        $this->checkPostData();
        $levelId = $this->input->post('levelId');
        $levelName = $this->input->post('levelName');
        $levelDesc = $this->input->post('levelDesc');
        $levelAccess = $this->input->post('levelAccess');
        $custMinBal = $this->input->post('custMinBal');
        $custMaxBal = $this->input->post('custMaxBal');
        $custMaxOutGoing = $this->input->post('custMaxOutGoing');
        $custGroupFee = $this->input->post('custGroupFee');
        $active = $this->input->post('active');

        if($active == ''){
            $active = 0;
        }
        if($levelAccess != ''){
            $levelAccessImp = implode(',', $levelAccess);
        }else{
            $levelAccessImp = '';
        }

        // edit
        if($this->input->post('levelId')){

            $tabel_name = 'f_cust_level';
            $where = array('ID' => $levelId);
            $postData = array(
                    'LEVEL_NAME' => $levelName,
                    'LEVEL_DESC' => $levelDesc,
                    'LEVEL_MINBALANCE' => $custMinBal,
                    'LEVEL_MAXBALANCE' => $custMaxBal,
                    'LEVEL_MAXOUTGOING' => $custMaxOutGoing,
                    'GROUP_FEE' => $custGroupFee,
                    'LEVEL_STATUS'=>$active
                );
            $update = $this->admin_model->updateDb($tabel_name, $where, $postData);

            // create acl
            if (! $this->admin_model->level_acl_exists($levelId)) {
                $tabel_name2 = 'f_cust_level_acl';
                $postData2 = array(
                        'LEVELID'=> $levelId,
                        'ACCESS' => $levelAccessImp,
                        'STATUS'=>$active
                    );
                $insert = $this->admin_model->addDb($tabel_name2, $postData2);
            }
            // update acl
            else{
                $tabel_name2 = 'f_cust_level_acl';
                $where2 = array('LEVELID' => $levelId);
                $postData2 = array('ACCESS' => $levelAccessImp, 'STATUS'=>$active);
                $update = $this->admin_model->updateDb($tabel_name2, $where2, $postData2);
            }

            $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Update user level Success'));
            redirect('management/customer_level');
        }

        // add
        else{
            // set cust type id
            $custTypeID = $this->admin_model->next_cust_type_id();

            $tabel_name = 'f_cust_level';
            $postData = array(
                    'LEVEL_NAME' => $levelName,
                    'LEVEL_CODE'=>  sha1(date("Y-m-d hh-mm-ss")),
                    'LEVEL_DESC' => $levelDesc,
                    'LEVEL_MINBALANCE' => $custMinBal,
                    'LEVEL_MAXBALANCE' => $custMaxBal,
                    'LEVEL_MAXOUTGOING' => $custMaxOutGoing,
                    'GROUP_FEE' => $custGroupFee,
                    'CUST_TYPE_ID' => $custTypeID,
                    'LEVEL_STATUS'=>$active
                );
            $addData = $this->admin_model->addDb($tabel_name, $postData);

            if($addData){
                $tabel_name2 = 'f_cust_level_acl';
                $postData2 = array(
                        'LEVELID'=> $addData,
                        'ACCESS' => $levelAccessImp,
                        'STATUS'=>$active
                    );
                $update = $this->admin_model->addDb($tabel_name2, $postData2);
                $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user level Success'));
                redirect('management/customer_level');
            }
        }
    }

	function customer_level_delete(){
            $this->checkPostData();
            $levelId = $this->input->post('levelId');
            $where = array('ID' => $levelId);
            $delete = $this->admin_model->delete_where('f_cust_level', $where);
            if($delete){
                $where2 = array('LEVELID' => $levelId);
                $delete2 = $this->admin_model->delete_where('f_cust_level_acl', $where2);
                $res = array('result' => TRUE, 'message' => 'Delete Success');
            }
            echo json_encode($res);
	}
        public function merchant_registration(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'merchant_registration');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/merchant_registration';
		$this->data['title_page'] = 'Merchant Registration';
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$where = array('LEVEL_STATUS' => 1);
		$custLevel = $this->admin_model->get_where_data('f_cust_level', $where);
		$this->data['custLevel'] = $custLevel;
		$this->data['provinsiDataList'] = $provinsiData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function merchant_detail(){
		$custId = $this->input->post('custIdRegNew');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'merchant_registration');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/merchant_detail';
		$this->data['title_page'] = 'Authorize Registration Detail';
		$where = array('ID'=>$custId);
		$customerData = $this->admin_model->get_customer_where($where);
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$this->data['provinsiDataList'] = $provinsiData;
		$this->data['cityDataList'] = $cityData;
		$this->data['customerData'] = $customerData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);

	}
	public function ppob_registration(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'ppob_registration');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/ppob_registration';
		$this->data['title_page'] = 'PPOB Registration';
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$where = array('LEVEL_STATUS' => 1);
		$custLevel = $this->admin_model->get_where_data('f_cust_level', $where);
		$this->data['custLevel'] = $custLevel;
		$this->data['provinsiDataList'] = $provinsiData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}

	public function plasa_telkom(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'plasa_telkom');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/plasa_telkom';
		$this->data['title_page'] = 'Management Plasa Telkom';
		$plasaData = $this->admin_model->get_all_data('f_plasa_telkom');
		$this->data['plasaTelkomDataList'] = $plasaData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	
	public function partner(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'partner');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/partner';
		$this->data['title_page'] = 'Management Partner';
		$partnerData = $this->admin_model->get_all_data('f_client_partner');
		$this->data['partnerData'] = $partnerData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	
	public function partner_add(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'partner');
		$this->session->set_flashdata($sessionMenu);
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$this->data['provinsiData'] = $provinsiData;
        $this->data['cityData'] = $cityData;
		$this->data['content_page'] = 'admin/pages/management/partner_detail';
		$this->data['title_page'] = 'Detail Partner';
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	
	function partner_delete(){
		$this->checkPostData();
		$id = $this->input->post('id');
		$where = array('CP_ID' => $id);
		$delete = $this->admin_model->delete_where('f_client_partner', $where);
		if($delete){
				$res = array('result' => TRUE, 'message' => 'Delete Success');
		}
		echo json_encode($res);
    }
	
	public function partner_detail(){
		$this->checkPostData();
		$id = $this->input->post('id');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'terminal');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/partner_detail';
		$this->data['title_page'] = 'Detail Partner';
		$where = array('CP_ID'=>$id);
		$partnerData = $this->admin_model->get_where_data('f_client_partner', $where);
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$this->data['provinsiData'] = $provinsiData;
        $this->data['cityData'] = $cityData;
		$this->data['partnerData'] = $partnerData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	
	function partner_save(){
		$post = $this->input->post();
		$this->checkPostData();
		
		$partnerId = $this->input->post('partnerId');
		$cpName = $this->input->post('cpName');
		$cpCode = $this->input->post('cpCode');
		$publicKey = $this->input->post('publicKey');
		$privateKey = $this->input->post('privateKey');
		$cpUrl = $this->input->post('cpUrl');
		$active = $this->input->post('active');
		$description = $this->input->post('description');
		$identityType = $this->input->post('identityType');
		$identityNumber = $this->input->post('identityNumber');
		$address = $this->input->post('address');
		$custProv = $this->input->post('custProv');
		$custCity = $this->input->post('custCity');
		$passwordFormat = $this->input->post('passwordFormat');
		$strictIp = $this->input->post('strictIp');
		$signature = $this->input->post('signature');
		$usePassword = $this->input->post('usePassword');
		$updatePhone = $this->input->post('updatePhone');
		$emailNotification = $this->input->post('emailNotification');
		$smsNotification = $this->input->post('smsNotification');
		$tokenValidity = $this->input->post('tokenValidity');
		$handshakeEncryption = $this->input->post('handshakeEncryption');
		$handshakeAlgorithm = $this->input->post('handshakeAlgorithm');
		$handshakeKey = $this->input->post('handshakeKey');
		$handshakeBlockSize = $this->input->post('handshakeBlockSize');
		$createdBy = $this->input->post('createdBy');
		$updatedBy = $this->input->post('updatedBy');
		
		if(isset($partnerId)){
				$tabel_name = 'f_client_partner';
				$where = array('CP_ID' => $partnerId);
				$dateNow = date("Y-m-d H:i:s");
				$postData = array(
				'CP_NAME'=>$cpName,
				'CP_CODE'=>$cpCode,
				'CP_PUBLIC_KEY'=>$publicKey,
				'CP_PRIVATE_KEY'=>$privateKey,
				'CP_AUTH_URL'=>$cpUrl,
				'STATUS'=>$active,
				'CP_DESCRIPTION'=>$description,
				'CP_IDENTITYTYPE'=>$identityType,
				'CP_IDENTITYNUMBER'=>$identityNumber,
				'CP_ADDRESS'=>$address,
				'CP_CITY_ID'=>$custCity,
				'CP_PROVINCE_ID'=>$custProv,
				'CP_PASSWORD_FORMAT'=>$passwordFormat,
				'CP_STRICT_IP_ADDR'=>$strictIp,
				'CP_USE_SIGNATURE'=>$signature,
				'CP_USE_PASSWORD'=>$usePassword,
				'CP_UPDATE_PHONE'=>$updatePhone,
				'CP_EMAIL_NOTIFICATION'=>$emailNotification,
				'CP_SMS_NOTIFICATION'=>$smsNotification,
				'CP_TOKEN_VALIDITY'=>$tokenValidity,
				'CP_HANDSHAKE_ENCRYPTION'=>$handshakeEncryption,
				'CP_HANDSHAKE_ALGORITHM'=>$handshakeAlgorithm,
				'CP_HANDSHAKE_KEY'=>$handshakeKey,
				'CP_HANDSHAKE_BLOCKSIZE'=>$handshakeBlockSize,
				'UPDATED_ON'=>$dateNow,
				'UPDATED_BY'=>$createdBy			
				);
				$update = $this->admin_model->updateDb($tabel_name, $where, $postData);
				if($update){
					$res = array('result' => TRUE, 'message' => 'Update Success');
				}
				echo json_encode($res);
		}else{
				$tabel_name = 'f_client_partner';
				$dateNow = date("Y-m-d H:i:s");
				$postData = array(
				'CP_NAME'=>$cpName,
				'CP_CODE'=>$cpCode,
				'CP_PUBLIC_KEY'=>$publicKey,
				'CP_PRIVATE_KEY'=>$privateKey,
				'CP_AUTH_URL'=>$cpUrl,
				'STATUS'=>$active,
				'CP_DESCRIPTION'=>$description,
				'CP_IDENTITYTYPE'=>$identityType,
				'CP_IDENTITYNUMBER'=>$identityNumber,
				'CP_ADDRESS'=>$address,
				'CP_CITY_ID'=>$custCity,
				'CP_PROVINCE_ID'=>$custProv,
				'CP_PASSWORD_FORMAT'=>$passwordFormat,
				'CP_STRICT_IP_ADDR'=>$strictIp,
				'CP_USE_SIGNATURE'=>$signature,
				'CP_USE_PASSWORD'=>$usePassword,
				'CP_UPDATE_PHONE'=>$updatePhone,
				'CP_EMAIL_NOTIFICATION'=>$emailNotification,
				'CP_SMS_NOTIFICATION'=>$smsNotification,
				'CP_TOKEN_VALIDITY'=>$tokenValidity,
				'CP_HANDSHAKE_ENCRYPTION'=>$handshakeEncryption,
				'CP_HANDSHAKE_ALGORITHM'=>$handshakeAlgorithm,
				'CP_HANDSHAKE_KEY'=>$handshakeKey,
				'CP_HANDSHAKE_BLOCKSIZE'=>$handshakeBlockSize,
				'CREATED_ON'=>$dateNow,
				'CREATED_BY'=>$createdBy			
				);
				$addData = $this->admin_model->addDb($tabel_name, $postData);
				if($addData){
						$res = array('result' => TRUE, 'message' => 'Add Partner Success');
						$this->session->set_flashdata($res);
				}
				echo json_encode($res);
		}
    }
		
	public function terminal(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'terminal');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/terminal';
		$this->data['title_page'] = 'Management Terminal';
		$plasaData = $this->admin_model->get_all_data('f_terminal');
		$partnerData = $this->admin_model->get_all_data('f_client_partner');
		$this->data['partnerData'] = $partnerData;
		$this->data['terminal'] = $plasaData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}

	public function terminal_detail(){
		$this->checkPostData();
		$id = $this->input->post('id');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'terminal');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/terminal_detail';
		$this->data['title_page'] = 'Detail Terminal';
		$where = array('ID'=>$id);
		$terminalData = $this->admin_model->get_where_data('f_terminal', $where);
		$partnerData = $this->admin_model->get_all_data('f_client_partner');
        $this->data['terminalData'] = $terminalData;
		$this->data['partnerData'] = $partnerData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	public function terminal_add(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'terminal');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/terminal_detail';
		$this->data['title_page'] = 'Detail Terminal';
		$partnerData = $this->admin_model->get_all_data('f_client_partner');
		$this->data['partnerData'] = $partnerData;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	public function plasa_telkom_detail(){
		$this->checkPostData();
		$id = $this->input->post('id');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'plasa_telkom');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/plasa_telkom_detail';
		$this->data['title_page'] = 'Plasa Telkom';
		$where = array('ID'=>$id);
		$plasaData = $this->admin_model->get_where_data('f_plasa_telkom', $where);
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
                $this->data['plasaData'] = $plasaData;
		$this->data['provinsiData'] = $provinsiData;
                $this->data['cityData'] = $cityData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function plasa_telkom_add(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'management',
               'child_menu_active'  => 'plasa_telkom');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/management/plasa_telkom_detail';
		$this->data['title_page'] = 'Management Province';
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$this->data['provinsiData'] = $provinsiData;
                $this->data['cityData'] = $cityData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	
	function terminal_save(){
            $post = $this->input->post();
            $this->checkPostData();
            $terminalId = $this->input->post('terminalId');
            $terminalName = $this->input->post('terminalName');
            $clientPartner = $this->input->post('clientPartner');
            $description = $this->input->post('description');
            $createdBy = $this->input->post('createdBy');
            $active = $this->input->post('active');
            if(isset($terminalId)){
                    $tabel_name = 'f_terminal';
                    $where = array('ID' => $terminalId);
                     $postData = array('TERMINAL_NAME' => $terminalName, 'CP_ID' => $clientPartner, 'DESCRIPTION' => $description, 'CREATED_BY' => $createdBy,'ACTIVE'=> $active);
                    $update = $this->admin_model->updateDb($tabel_name, $where, $postData);
                    if($update){
                        $res = array('result' => TRUE, 'message' => 'Update Success');
                    }
                    echo json_encode($res);
            }else{
                    $tabel_name = 'f_terminal';
					$dateNow = date("Y-m-d H:i:s");
                    $postData = array('TERMINAL_NAME' => $terminalName, 'CP_ID' => $clientPartner, 'DESCRIPTION' => $description, 'CREATED_BY' => $createdBy,'ACTIVE'=> $active, 'CREATED_ON' => $dateNow);
                    $addData = $this->admin_model->addDb($tabel_name, $postData);
                    if($addData){
                            $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add Terminal Success'));
                            redirect('management/terminal');
                    }
            }
        }
		
		function terminal_delete(){
            $this->checkPostData();
            $id = $this->input->post('id');
            $where = array('ID' => $id);
            $delete = $this->admin_model->delete_where('f_terminal', $where);
            if($delete){
                    $res = array('result' => TRUE, 'message' => 'Delete Success');
            }
            echo json_encode($res);
        }
		
        function plasa_telkom_save(){
            $post = $this->input->post();
            $this->checkPostData();
            $plasaId = $this->input->post('plasaId');
            $custName = $this->input->post('custName');
            $custProv = $this->input->post('custProv');
            $custCity = $this->input->post('custCity');
            $custAddress = $this->input->post('custAddress');
            $custPhone = $this->input->post('custPhone');
//            $active = $this->input->post('active');
//            if($active == ''){
                    $active = 1;
//            }
            if(isset($plasaId)){
                    $tabel_name = 'f_plasa_telkom';
                    $where = array('ID' => $plasaId);
                    $postData = array('PLASANAME' => $custName, 'PROVINCEID' => $custProv, 'CITYID' => $custCity, 'PLASAADDRESS' => $custAddress,
                        'PHONE'=> $custPhone, 'STATUS'=>$active, 'CREATED_ON' => date('Y-m-d h:m:s'), 'CREATED_BY' => $this->session->userdata('username'));

                    $update = $this->admin_model->updateDb($tabel_name, $where, $postData);
                    if($update){
                        $res = array('result' => TRUE, 'message' => 'Update Success');
                    }
                    echo json_encode($res);
            }else{
                    $tabel_name = 'f_plasa_telkom';
                    $postData = array('PLASANAME' => $custName, 'PROVINCEID' => $custProv, 'CITYID' => $custCity, 'PLASAADDRESS' => $custAddress,
                        'PHONE'=> $custPhone, 'STATUS'=>$active, 'CREATED_ON' => date('Y-m-d h:m:s'), 'CREATED_BY' => $this->session->userdata('username'));
                    $addData = $this->admin_model->addDb($tabel_name, $postData);
                    if($addData){
                            $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add Plasa Telkom Success'));
                            redirect('management/plasa_telkom');
                    }
            }
        }
        function plasa_telkom_delete(){
            $this->checkPostData();
            $id = $this->input->post('id');
            $where = array('ID' => $id);
            $delete = $this->admin_model->delete_where('f_plasa_telkom', $where);
            if($delete){
                    $res = array('result' => TRUE, 'message' => 'Delete Success');
            }
            echo json_encode($res);
        }
}
