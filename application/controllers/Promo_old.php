<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends MY_Controller {

	protected $img_dir = '../../tmoney-web/assets/images/';
	protected $img_url = 'https://tmoney.mozaik.id/assets/images/';
	
	protected $except_field = array('CREATED_ON','CREATED_BY','UPDATED_ON','UPDATED_BY');

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('response');

		$this->merchant_img_dir = $this->img_dir . 'merchant/';
		$this->promo_img_dir = $this->img_dir . 'merchant-promo/';
		$this->category_img_dir = $this->img_dir . 'merchant-category/';

		$this->merchant_img_url = $this->img_url . 'merchant/';
		$this->promo_img_url = $this->img_url . 'merchant-promo/';
		$this->category_img_url = $this->img_url . 'merchant-category/';

		$this->load->helper('url');
        $this->load->model(array('admin_model'));
        $this->data['css_admin'] = $this->config->item('css_admin_patch');
        $this->data['js_admin'] = $this->config->item('js_admin_patch');
        $this->data['title_page'] = 'Merchant Promo';
        $this->data['menuListData'] = $this->menuSidebar();
	}

	public function merchant(){
		$this->db->order_by('MCL_ID','desc');
		$this->db->join('f_merchant_category','f_merchant_category.MCT_ID = f_merchant_list.MCT_ID','left');
		$this->data['merchants']  = $this->db->get('f_merchant_list')->result_array();

		$this->data['content_page'] = 'admin/pages/promo/merchant';
		$this->data['link_img'] = $this->merchant_img_url;
		$this->load->view('admin/layout', $this->data);
	}

	public function merchant_detail($id){
		$this->db->where('MCL_ID',$id);
		$this->db->join('f_merchant_category','f_merchant_category.MCT_ID = f_merchant_list.MCT_ID','left');
		$this->data['merchant']  = $this->db->get('f_merchant_list')->row_array();

		if (empty($this->data['merchant'] )) show_404();

		$this->data['content_page'] = 'admin/pages/promo/merchant_detail';
		$this->data['link_img'] = $this->merchant_img_url;
		$this->load->view('admin/layout', $this->data);
	}

	public function merchant_add(){
		$this->db->order_by('MCT_ID','desc');
		$this->data['category']  = $this->db->get('f_merchant_category')->result_array();
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MCL_NAME','Name','required');
			$this->form_validation->set_rules('MCL_ADDRESS','Address','required');
			$this->form_validation->set_rules('MCL_LATITUDE','Latitude','required');
			$this->form_validation->set_rules('MCL_LONGITUDE','Longitude','required');
			if ($this->form_validation->run()) {
				$add_data = $this->input->post();
				$add_data['MCL_RECOMMENDED'] = ($this->input->post('MCL_RECOMMENDED')) ? 1 : 0;
				$default_params = array(
					'MCT_ID'=>NULL,
					'MCL_NAME'=>NULL,
					'MCL_INFO'=>NULL,
					'MCL_ADDRESS'=>NULL,
					'MCL_IMAGES'=>NULL,
					'MCL_CONTACT'=>NULL,
					'MCL_OPEN_HOURS'=>NULL,
					'MCL_CLOSE_HOURS'=>NULL,
					'MCL_LATITUDE'=>NULL,
					'MCL_LONGITUDE'=>NULL,
					'MCL_RECOMMENDED'=>0,
				);

				 if($_FILES['image']['error']==0) {
	                $config['upload_path'] = $this->merchant_img_dir;
	                $config['encrypt_name'] = TRUE;
	                $config['allowed_types'] = 'gif|jpg|png';
	                $this->load->library('upload', $config);
	           
	                if ( ! $this->upload->do_upload('image')){
	                    header('HTTP/1.1 500 Internal Server Error');
	                    header('Content-type: text/plain');
	                    exit($this->upload->display_errors());
	                }else{
	                    $data =  $this->upload->data();
	                    $add_data['MCL_IMAGES'] = $data['file_name'];
	                }
	            }

			    // merge insert data data to default params
		        $ins_data = array_intersect_key(  $add_data, $default_params)  +  $default_params;

		        // save guru
		        $query = $this->db->insert('f_merchant_list',$ins_data);

		        redirect('promo/merchant');
			}
		}
		$this->data['content_page'] = 'admin/pages/promo/merchant_add';
		$this->load->view('admin/layout', $this->data);
	}

	public function merchant_edit($id){
		$this->db->order_by('MCT_ID','desc');
		$this->data['category']  = $this->db->get('f_merchant_category')->result_array();
		$this->data['merchant']  = $this->db->where('MCL_ID',$id)->get('f_merchant_list')->row_array();
		if (empty($this->data['merchant']))show_404();
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MCL_NAME','Name','required');
			$this->form_validation->set_rules('MCL_ADDRESS','Address','required');
			$this->form_validation->set_rules('MCL_LATITUDE','Latitude','required');
			$this->form_validation->set_rules('MCL_LONGITUDE','Longitude','required');
			if ($this->form_validation->run()) {
				$edit_data = $this->input->post();
				$edit_data['MCL_RECOMMENDED'] = ($this->input->post('MCL_RECOMMENDED')) ? 1 : 0;
				$default_params = array(
					'MCT_ID'=>NULL,
					'MCL_NAME'=>NULL,
					'MCL_INFO'=>NULL,
					'MCL_ADDRESS'=>NULL,
					'MCL_IMAGES'=>NULL,
					'MCL_CONTACT'=>NULL,
					'MCL_OPEN_HOURS'=>NULL,
					'MCL_CLOSE_HOURS'=>NULL,
					'MCL_LATITUDE'=>NULL,
					'MCL_LONGITUDE'=>NULL,
					'MCL_RECOMMENDED'=>0,
				);

				 if($_FILES['image']['error']==0) {
	                $config['upload_path'] = $this->merchant_img_dir;
	                $config['encrypt_name'] = TRUE;
	                $config['allowed_types'] = 'gif|jpg|png';
	                $this->load->library('upload', $config);
	           
	                if ( ! $this->upload->do_upload('image')){
	                    header('HTTP/1.1 500 Internal Server Error');
	                    header('Content-type: text/plain');
	                    exit($this->upload->display_errors());
	                }else{
	                    $data =  $this->upload->data();
	                    $edit_data['MCL_IMAGES'] = $data['file_name'];
	                }
	            }

			     // merge insert data data to default params
		        $update_data = array_intersect_key( $edit_data, $default_params);

		        // save guru
		        $this->db->where('MCL_ID',$id);
		        $query = $this->db->update('f_merchant_list',$update_data);

		        redirect('promo/merchant');
			}
		}
		$this->data['link_img'] = $this->merchant_img_url;
		$this->data['content_page'] = 'admin/pages/promo/merchant_edit';
		$this->load->view('admin/layout', $this->data);
	}

	public function merchant_delete($id){
		$this->db->where('MCL_ID',$id)->delete('f_merchant_list');
		redirect('promo/merchant');
	}

	public function promo(){
		$this->db->order_by('MCP_ID','desc');
		$this->data['promo']  = $this->db->get('f_merchant_promo')->result_array();

		$this->data['content_page'] = 'admin/pages/promo/promo';
		$this->data['link_img'] = $this->promo_img_url;
		$this->load->view('admin/layout', $this->data);
	}

	public function promo_add(){
		$this->data['merchant'] = $this->db->get('f_merchant_list')->result_array();
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MCP_ACTIVE','Active Time','required');
			$this->form_validation->set_rules('MCP_INACTIVE','Inactive Time','required');
			$this->form_validation->set_rules('MCP_HEADLINE','Headline','required');
			if ($this->form_validation->run()) {
				$add_data = $this->input->post();
				$add_data['MCP_ACTIVE'] = date('Y:m:d H:i:s', strtotime($add_data['MCP_ACTIVE']));
				$add_data['MCP_INACTIVE'] = date('Y:m:d H:i:s', strtotime($add_data['MCP_INACTIVE']));
				$default_params = array(
					'MCP_HEADLINE'=>NULL,
					'MCP_DESC'=>NULL,
					'MCP_IMAGES'=>NULL,
					'MCP_ACTIVE'=>NULL,
					'MCP_INACTIVE'=>NULL,
				);

				if($_FILES['image']['error']==0) {
	                $config['upload_path'] = $this->promo_img_dir;
	                $config['encrypt_name'] = TRUE;
	                $config['allowed_types'] = 'gif|jpg|png';
	                $this->load->library('upload', $config);
	           
	                if ( ! $this->upload->do_upload('image')){
	                    header('HTTP/1.1 500 Internal Server Error');
	                    header('Content-type: text/plain');
	                    exit($this->upload->display_errors());
	                }else{
	                    $data =  $this->upload->data();
	                    $add_data['MCP_IMAGES'] = $data['file_name'];
	                }
	            }
			    // merge insert data to default params
		        $ins_data = array_intersect_key(  $add_data, $default_params)  +  $default_params;
		        // save promo
		        $query = $this->db->insert('f_merchant_promo',$ins_data);
		        $promo_id = $this->db->insert_id();

		        foreach ($this->input->post('MCL_ID') as $key => $value) {
		        	$this->db->insert('f_merchant_to_promo',array('MCL_ID'=>$value,'MCP_ID'=>$promo_id));
		        }

		        redirect('promo/promo');
			}
		}
		$this->data['content_page'] = 'admin/pages/promo/promo_add';
		$this->load->view('admin/layout', $this->data);
	}

	public function promo_edit($id){
		$this->db->select('f_merchant_promo.*, GROUP_CONCAT(f_merchant_to_promo.MCL_ID) as merchant_id');
		$this->db->join('f_merchant_to_promo','f_merchant_promo.MCP_ID = f_merchant_to_promo.MCP_ID','LEFT');
		$this->data['promo']  = $this->db->where('f_merchant_promo.MCP_ID',$id)->get('f_merchant_promo')->row_array();
		$this->data['promo']['merchant']  = explode(',', $this->data['promo']['merchant_id']);
		$this->data['merchant'] = $this->db->get('f_merchant_list')->result_array();
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MCP_ACTIVE','Active Time','required');
			$this->form_validation->set_rules('MCP_INACTIVE','Inactive Time','required');
			$this->form_validation->set_rules('MCP_HEADLINE','Headline','required');
			if ($this->form_validation->run()) {
				$edit_data = $this->input->post();
				$edit_data['MCP_ACTIVE'] = date('Y:m:d H:i:s', strtotime($edit_data['MCP_ACTIVE']));
				$edit_data['MCP_INACTIVE'] = date('Y:m:d H:i:s', strtotime($edit_data['MCP_INACTIVE']));
				$default_params = array(
					'MCP_HEADLINE'=>NULL,
					'MCP_DESC'=>NULL,
					'MCP_IMAGES'=>NULL,
					'MCP_ACTIVE'=>NULL,
					'MCP_INACTIVE'=>NULL,
				);

				 if($_FILES['image']['error']==0) {
	                $config['upload_path'] = $this->promo_img_dir;
	                $config['encrypt_name'] = TRUE;
	                $config['allowed_types'] = 'gif|jpg|png';
	                $this->load->library('upload', $config);
	           
	                if ( ! $this->upload->do_upload('image')){
	                    header('HTTP/1.1 500 Internal Server Error');
	                    header('Content-type: text/plain');
	                    exit($this->upload->display_errors());
	                }else{
	                    $data =  $this->upload->data();
	                    $edit_data['MCP_IMAGES'] = $data['file_name'];
	                }
	            }

			    // merge insert data data to default params
		        $update_data = array_intersect_key( $edit_data, $default_params);

		        // save guru
		        $this->db->where('MCP_ID',$id);
		        $query = $this->db->update('f_merchant_promo',$update_data);

		        $promo_id = $id;

		        $this->db->where('MCP_ID',$promo_id)->delete('f_merchant_to_promo');
		        foreach ($this->input->post('MCL_ID') as $key => $value) {
		        	$this->db->insert('f_merchant_to_promo',array('MCL_ID'=>$value,'MCP_ID'=>$promo_id));
		        }

		        redirect('promo/promo');
			}
		}
		if (empty($this->data['promo']))show_404();

		$this->data['link_img'] = $this->promo_img_url;
		$this->data['content_page'] = 'admin/pages/promo/promo_edit';
		$this->load->view('admin/layout', $this->data);
	}

	public function promo_delete($id){
		$this->db->where('MCP_ID',$id)->delete('f_merchant_promo');
		redirect('promo/promo');
	}

	public function category(){
		$this->db->order_by('MCT_ID','desc');
		$this->data['category']  = $this->db->get('f_merchant_category')->result_array();
		$this->data['link_img'] = $this->category_img_url;

		$this->data['content_page'] = 'admin/pages/promo/category';
		$this->load->view('admin/layout', $this->data);
	}

	public function category_add(){
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MCT_NAME','Category Name','required');
			if ($this->form_validation->run()) {
				$default_params = array(
					'MCT_NAME'=>NULL,
					'MCT_DESC'=>NULL,
					'MCT_IMAGES'=>NULL,
				);

				 if($_FILES['image']['error']==0) {
	                $config['upload_path'] = $this->category_img_dir;
	                $config['encrypt_name'] = TRUE;
	                $config['allowed_types'] = 'gif|jpg|png';
	                $this->load->library('upload', $config);
	           
	                if ( ! $this->upload->do_upload('image')){
	                    header('HTTP/1.1 500 Internal Server Error');
	                    header('Content-type: text/plain');
	                    exit($this->upload->display_errors());
	                }else{
	                    $data =  $this->upload->data();
	                    $default_params['MCT_IMAGES'] = $data['file_name'];
	                }
	            }

			    // merge insert data data to default params
		        $ins_data = array_intersect_key( $this->input->post(), $default_params)  +  $default_params;

		        // save guru
		        $query = $this->db->insert('f_merchant_category',$ins_data);

		        redirect('promo/category');
			}
		}
		$this->data['content_page'] = 'admin/pages/promo/category_add';
		$this->load->view('admin/layout', $this->data);
	}

	public function category_edit($id){
		$this->data['category']  = $this->db->where('MCT_ID',$id)->get('f_merchant_category')->row_array();
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MCT_NAME','Category Name','required');
			if ($this->form_validation->run()) {
				$edit_data = $this->input->post();
				$default_params = array(
					'MCT_NAME'=>NULL,
					'MCT_DESC'=>NULL,
					'MCT_IMAGES'=>NULL,
				);

				 if($_FILES['image']['error']==0) {
	                $config['upload_path'] = $this->category_img_dir;
	                $config['encrypt_name'] = TRUE;
	                $config['allowed_types'] = 'gif|jpg|png';
	                $this->load->library('upload', $config);
	           
	                if ( ! $this->upload->do_upload('image')){
	                    header('HTTP/1.1 500 Internal Server Error');
	                    header('Content-type: text/plain');
	                    exit($this->upload->display_errors());
	                }else{
	                    $data =  $this->upload->data();
	                    $edit_data['MCT_IMAGES'] = $data['file_name'];
	                }
	            }

			    // merge insert data data to default params
		        $update_data = array_intersect_key( $edit_data, $default_params);

		        // save guru
		        $this->db->where('MCT_ID',$id);
		        $query = $this->db->update('f_merchant_category',$update_data);

		        redirect('promo/category');
			}
		}
		if (empty($this->data['category']))show_404();

		$this->data['link_img'] = $this->category_img_url;
		$this->data['content_page'] = 'admin/pages/promo/category_edit';
		$this->load->view('admin/layout', $this->data);
	}

	public function category_delete($id){
		$this->db->where('MCT_ID',$id)->delete('f_merchant_category');
		redirect('promo/category');
	}



}
