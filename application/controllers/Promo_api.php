<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_api extends CI_Controller {

	protected $img_dir = 'assets/images/';
	protected $img_url = 'https://prodapi-app.tmoney.co.id/images/';
	
	protected $except_field = array('CREATED_ON','CREATED_BY','UPDATED_ON','UPDATED_BY');

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		header('Content-Type: application/json');
		$this->load->library('form_validation');

		$this->merchant_img_dir = $this->img_dir . 'merchant/';
		$this->promo_img_dir = $this->img_dir . 'merchant-promo/';
		$this->category_img_dir = $this->img_dir . 'merchant-category/';

		$this->merchant_img_url = $this->img_url . 'merchant/';
		$this->promo_img_url = $this->img_url . 'merchant-promo/';
		$this->category_img_url = $this->img_url . 'merchant-category/';
	}
	//**
	public function merchant(){
		//parse parameter if exist
		$start = ($this->input->get('start'))?$this->input->get('start'):0;
		$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;
		$lat = $this->input->get('lat');
		$lng = $this->input->get('lng');
		$keyword = $this->input->get('keyword');

		$this->db->select('f_merchant_list.*, GROUP_CONCAT(f_merchant_category.MCT_NAME) as MCT_NAME');

		if ($lat && $lng) {
			$this->db->select('f_merchant_list.*, GROUP_CONCAT(f_merchant_category.MCT_NAME) as MCT_NAME, ( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( MCL_LATITUDE ) ) * cos( radians( MCL_LONGITUDE ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( MCL_LATITUDE ) ) ) ) AS MCL_DISTANCE ', FALSE);
			$this->db->order_by('MCL_DISTANCE');
		}
		if ($keyword) {
			$this->db->like('MCL_NAME',$keyword);
		}
		$this->db->join('f_merchant_to_category','f_merchant_list.MCL_ID = f_merchant_to_category.MCL_ID','left');
		$this->db->join('f_merchant_category','f_merchant_to_category.MCT_ID = f_merchant_category.MCT_ID','left');
		$this->db->group_by('f_merchant_list.MCL_ID');
		//query
		if ($this->input->get('merchant_id')) {
			$this->db->where('f_merchant_list.MCL_ID',$this->input->get('merchant_id'));
			$merchant = $this->db->get('f_merchant_list')->row_array();
		}elseif ($this->input->get('category_id')) {
			//catefory query
			$this->db->where('f_merchant_to_category.MCT_ID',$this->input->get('category_id'));
			$this->db->limit($limit,$start);
			$merchant = $this->db->get('f_merchant_list')->result_array();
		}else{
			$this->db->limit($limit,$start);
			$merchant = $this->db->get('f_merchant_list')->result_array();
		}

		if ($this->input->get('merchant_id')) { // if single result
			$merchant['MCL_IMAGES'] = $this->merchant_img_url . $merchant['MCL_IMAGES'];
			$merchant['MCL_PROMO'] = $this->get_promo_by_merchant($merchant['MCL_ID']);
			$merchant['MCT_NAME'] = (is_null($merchant['MCT_NAME']))?'':$merchant['MCT_NAME'];
			foreach ($this->except_field as $e) {
				if(isset($merchant[$e])) unset($merchant[$e]);
			}
			if ($lat && $lng) $merchant['MCL_DISTANCE'] = round($merchant['MCL_DISTANCE'],2) . ' KM';
		}else{// if multiple result
			//image link
			foreach ($merchant as $key => $value) { 
				$merchant[$key]['MCL_IMAGES'] = $this->merchant_img_url . $value['MCL_IMAGES'];
				$merchant[$key]['MCL_PROMO'] = $this->get_promo_by_merchant($value['MCL_ID']);
				$merchant[$key]['MCT_NAME'] = (is_null($value['MCT_NAME']))?'':$value['MCT_NAME'];
				foreach ($this->except_field as $e) {
					if(isset($merchant[$key][$e])) unset($merchant[$key][$e]);
				}
				if ($lat && $lng) $merchant[$key]['MCL_DISTANCE'] = round($merchant[$key]['MCL_DISTANCE'],2) . ' KM';
			}
		}
		

		//return
		if (!empty($merchant)) {
			echo json_encode(array('status'=>1,'data'=>$merchant));
		}else{
			echo json_encode(array('status'=>0,'data'=>array()));
		}
	}
	//**
	public function nearby()
	{
		$this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('lat','lat','required');
        $this->form_validation->set_rules('lng','lng','required');

        if ($this->form_validation->run() == FALSE) {
        	echo json_encode(array('status'=>0,'data'=>'field lat & lng is required'));
        } else {

           	//parse parameter if exist
			$start = ($this->input->get('start'))?$this->input->get('start'):0;
			$limit = ($this->input->get('limit'))?$this->input->get('limit'):120;
			$radius = ($this->input->get('radius'))?$this->input->get('radius'):5;
			$lat = $this->input->get('lat');
			$lng = $this->input->get('lng');

			//query
							$this->db->select('*, ( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( MCL_LATITUDE ) ) * cos( radians( MCL_LONGITUDE ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( MCL_LATITUDE ) ) ) ) AS MCL_DISTANCE ', FALSE);
							$this->db->limit($limit,$start);
							$this->db->having('MCL_DISTANCE < 2');
							$this->db->order_by('MCL_DISCOUNT','DESC');
							$this->db->order_by('MCL_DISTANCE');
			$under2km = 	$this->db->get('f_merchant_list')->result_array();

			if ($limit - count($under2km) > 0) {
				$this->db->select('*, ( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( MCL_LATITUDE ) ) * cos( radians( MCL_LONGITUDE ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( MCL_LATITUDE ) ) ) ) AS MCL_DISTANCE ', FALSE);
							$this->db->limit($limit - count($under2km),$start);
							$this->db->having('MCL_DISTANCE < ' . $radius);
							$this->db->having('MCL_DISTANCE > 2');
							$this->db->order_by('MCL_DISTANCE');
				$more2km = 	$this->db->get('f_merchant_list')->result_array();
			}else{
				$more2km = array();
			}
							


			$nearby = array_merge($under2km,$more2km);

			//image link
			foreach ($nearby as $key => $value) {
				$nearby[$key]['MCL_IMAGES'] = $this->merchant_img_url . $value['MCL_IMAGES'];
				$nearby[$key]['MCL_DISTANCE'] = round($nearby[$key]['MCL_DISTANCE'],2) . ' KM';
				foreach ($this->except_field as $e) {
					if(isset($nearby[$key][$e])) unset($nearby[$key][$e]);
				}
			}

			//return
			if (!empty($nearby)) {
				echo json_encode(array('status'=>1,'data'=>$nearby));
			}else{
				echo json_encode(array('status'=>0,'data'=>array()));
			}
        }
	}
	//**
	public function recomended(){
		//parse parameter if exist
		$start = ($this->input->get('start'))?$this->input->get('start'):0;
		$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;

		//query
						$this->db->where('MCL_RECOMMENDED',1);
						$this->db->limit($limit,$start);
		$recomended = 	$this->db->get('f_merchant_list')->result_array();

		//image link
		foreach ($recomended as $key => $value) {
			$recomended[$key]['MCL_IMAGES'] = $this->merchant_img_url . $value['MCL_IMAGES'];
			foreach ($this->except_field as $e) {
				if(isset($recomended[$key][$e])) unset($recomended[$key][$e]);
			}
		}

		//return
		if (!empty($recomended)) {
			echo json_encode(array('status'=>1,'data'=>$recomended));
		}else{
			echo json_encode(array('status'=>0,'data'=>array()));
		}
	}

	public function category(){
		//parse parameter if exist
		$start = ($this->input->get('start'))?$this->input->get('start'):0;
		$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;

		//query
					$this->db->select('MCT_ID,MCT_NAME,MCT_DESC,MCT_IMAGES,MCT_ICON');
					$this->db->limit($limit,$start);
		$category = $this->db->get('f_merchant_category')->result_array();

		//image link
		foreach ($category as $key => $value) {
			$category[$key]['MCT_IMAGES'] = $this->category_img_url . $value['MCT_IMAGES'];
			$category[$key]['MCT_ICON'] = $this->category_img_url . $value['MCT_ICON'];
		}

		//return
		if (!empty($category)) {
			echo json_encode(array('status'=>1,'data'=>$category));
		}else{
			echo json_encode(array('status'=>0,'data'=>array()));
		}
	}

	public function promo(){
		//parse parameter if exist
		$start = ($this->input->get('start'))?$this->input->get('start'):0;
		$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;

		//query
					$this->db->where('MCP_ACTIVE <= ',date("Y-m-d H:i:s"));
					$this->db->where('MCP_INACTIVE >= ',date("Y-m-d H:i:s"));
					$this->db->limit($limit,$start);
		$promo = $this->db->get('f_merchant_promo')->result_array();


		//image link
		foreach ($promo as $key => $value) {
			$promo[$key]['MCP_IMAGES'] = $this->promo_img_url . $value['MCP_IMAGES'];
			$promo[$key]['MCP_MERCHANT'] = $this->get_merchant_by_promo($value['MCP_ID']);
			foreach ($this->except_field as $e) {
				if(isset($promo[$key][$e])) unset($promo[$key][$e]);
			}
		}

		//return
		if (!empty($promo)) {
			echo json_encode(array('status'=>1,'data'=>$promo));
		}else{
			echo json_encode(array('status'=>0,'data'=>array()));
		}
	}

	public function suggest(){
		$keyword = $this->input->get('keyword');

		if ($keyword) {
			$this->db->select('MCL_NAME,MCL_ID');
			$this->db->like('MCL_NAME' , $keyword);
			$merchant = $this->db->get('f_merchant_list')->result_array();
			

			if (!empty($merchant)) {
				echo json_encode(array('status'=>1,'data'=>$merchant));
			}else{
				echo json_encode(array('status'=>0,'data'=>array()));
			}
		}else{
			echo json_encode(array('status'=>0,'data'=>'keyword field is required'));
		}
	}
	//**
	public function merchant_by_promo(){
		$this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('lat','lat','required');
        $this->form_validation->set_rules('lng','lng','required');
        $this->form_validation->set_rules('promo_id','promo_id','required');
		if ($this->form_validation->run()) {
			//parse parameter if exist
			$start = ($this->input->get('start'))?$this->input->get('start'):0;
			$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;
			$radius = $this->input->get('radius');
			$lat = $this->input->get('lat');
			$lng = $this->input->get('lng');
			$promo_id = $this->input->get('promo_id');

			//query
							$this->db->select('*, ( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( MCL_LATITUDE ) ) * cos( radians( MCL_LONGITUDE ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( MCL_LATITUDE ) ) ) ) AS MCL_DISTANCE ', FALSE)
							->join('f_merchant_to_promo','f_merchant_list.MCL_ID = f_merchant_to_promo.MCL_ID','LEFT')
							->where('f_merchant_to_promo.MCP_ID',$promo_id);
							$this->db->limit($limit,$start);
							if ($radius) {
								$this->db->having('MCL_DISTANCE < ' . $radius);
							}
							$this->db->order_by('MCL_DISTANCE');
			$nearby = 	$this->db->get('f_merchant_list')->result_array();

			//image link
			foreach ($nearby as $key => $value) {
				$nearby[$key]['MCL_IMAGES'] = $this->merchant_img_url . $value['MCL_IMAGES'];
				$nearby[$key]['MCL_DISTANCE'] = round($nearby[$key]['MCL_DISTANCE'],2) . ' KM';
				foreach ($this->except_field as $e) {
					if(isset($nearby[$key][$e])) unset($nearby[$key][$e]);
				}
			}

			//return
			if (!empty($nearby)) {
				echo json_encode(array('status'=>1,'data'=>$nearby));
			}else{
				echo json_encode(array('status'=>0,'data'=>array()));
			}
		}else{
			echo json_encode(array('status'=>0,'data'=>'promo_id, lat, and lng field is required'));
		}
	}

	//**
	//PRIVATE AREA, TOO LAZY TO CREATE MODEL
	//**
	private function get_promo_by_merchant($MCL_ID){
		//query
		$this->db->join('f_merchant_to_promo','f_merchant_promo.MCP_ID = f_merchant_to_promo.MCP_ID','LEFT')
				->where('MCP_ACTIVE <= ',date("Y-m-d H:i:s"))
				->where('MCP_INACTIVE >= ',date("Y-m-d H:i:s"))
				->where('f_merchant_to_promo.MCL_ID',$MCL_ID);

		$promo = $this->db->get('f_merchant_promo')->result_array();


		//image link
		foreach ($promo as $key => $value) {
			$promo[$key]['MCP_IMAGES'] = $this->promo_img_url . $value['MCP_IMAGES'];
			foreach ($this->except_field as $e) {
				if(isset($promo[$key][$e])) unset($promo[$key][$e]);
			}
		}

		return $promo;
	}

	private function get_merchant_by_promo($MCP_ID){
			//query
			$this->db->join('f_merchant_to_promo','f_merchant_list.MCL_ID = f_merchant_to_promo.MCL_ID','LEFT')
					->where('f_merchant_to_promo.MCP_ID',$MCP_ID);
			$merchant = 	$this->db->get('f_merchant_list')->result_array();

			//image link
			foreach ($merchant as $key => $value) {
				$merchant[$key]['MCL_IMAGES'] = $this->merchant_img_url . $value['MCL_IMAGES'];
				foreach ($this->except_field as $e) {
					if(isset($merchant[$key][$e])) unset($merchant[$key][$e]);
				}
			}

			return $merchant;
	}




}
