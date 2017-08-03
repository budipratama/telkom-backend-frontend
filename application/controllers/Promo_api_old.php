<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_api extends CI_Controller {

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
	}

	public function merchant(){
		//parse parameter if exist
		$start = ($this->input->get('start'))?$this->input->get('start'):0;
		$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;
		$lat = $this->input->get('lat');
		$lng = $this->input->get('lng');
		$keyword = $this->input->get('keyword');

		if ($lat && $lng) {
			$this->db->select('*, ( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( MCL_LATITUDE ) ) * cos( radians( MCL_LONGITUDE ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( MCL_LATITUDE ) ) ) ) AS MCL_DISTANCE ', FALSE);
		}
		if ($keyword) {
			$this->db->like('MCL_NAME',$keyword);
		}
		$this->db->join('f_merchant_category','f_merchant_category.MCT_ID = f_merchant_list.MCT_ID','LEFT');
		//query
		if ($this->input->get('merchant_id')) {
			$this->db->where('MCL_ID',$this->input->get('merchant_id'));
			$merchant = $this->db->get('f_merchant_list')->row_array();
		}elseif ($this->input->get('category_id')) {
			//catefory query
			$this->db->where('f_merchant_list.MCT_ID',$this->input->get('category_id'));
			$this->db->limit($limit,$start);
			$merchant = $this->db->get('f_merchant_list')->result_array();
		}else{
			$this->db->limit($limit,$start);
			$merchant = $this->db->get('f_merchant_list')->result_array();
		}

		if ($this->input->get('merchant_id')) {
			$merchant['MCL_IMAGES'] = $this->merchant_img_url . $merchant['MCL_IMAGES'];
			$merchant['MCL_PROMO'] = $this->get_promo_by_merchant($merchant['MCL_ID']);
			foreach ($this->except_field as $e) {
				if(isset($merchant[$e])) unset($merchant[$e]);
			}
			if ($lat && $lng) $merchant['MCL_DISTANCE'] = round($merchant['MCL_DISTANCE'],2) . ' KM';
		}else{
			//image link
			foreach ($merchant as $key => $value) {
				$merchant[$key]['MCL_IMAGES'] = $this->merchant_img_url . $value['MCL_IMAGES'];
				$merchant[$key]['MCL_PROMO'] = $this->get_promo_by_merchant($value['MCL_ID']);
				foreach ($this->except_field as $e) {
					if(isset($merchant[$key][$e])) unset($merchant[$key][$e]);
				}
				if ($lat && $lng) $merchant[$key]['MCL_DISTANCE'] = round($merchant[$key]['MCL_DISTANCE'],2) . ' KM';
			}
		}
		

		//return
		if (!empty($merchant)) {
			$this->response->send(array('status'=>1,'data'=>$merchant));
		}else{
			$this->response->send(array('status'=>0,'data'=>array()));
		}
	}

	public function nearby()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('lat','lat','required');
        $this->form_validation->set_rules('lng','lng','required');

        if ($this->form_validation->run() == FALSE) {
        	$this->response->send(array('status'=>0,'data'=>'field lat & lng is required'));
        } else {

           	//parse parameter if exist
			$start = ($this->input->get('start'))?$this->input->get('start'):0;
			$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;
			$radius = ($this->input->get('radius'))?$this->input->get('radius'):5;
			$lat = $this->input->get('lat');
			$lng = $this->input->get('lng');

			//query
							$this->db->select('*, ( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( MCL_LATITUDE ) ) * cos( radians( MCL_LONGITUDE ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians( MCL_LATITUDE ) ) ) ) AS MCL_DISTANCE ', FALSE);
							$this->db->limit($limit,$start);
							$this->db->having('MCL_DISTANCE < ' . $radius);
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
				$this->response->send(array('status'=>1,'data'=>$nearby));
			}else{
				$this->response->send(array('status'=>0,'data'=>array()));
			}
        }
	}

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
			$this->response->send(array('status'=>1,'data'=>$recomended));
		}else{
			$this->response->send(array('status'=>0,'data'=>array()));
		}
	}

	public function category(){
		//parse parameter if exist
		$start = ($this->input->get('start'))?$this->input->get('start'):0;
		$limit = ($this->input->get('limit'))?$this->input->get('limit'):50;

		//query
					$this->db->select('MCT_ID,MCT_NAME,MCT_DESC,MCT_IMAGES');
					$this->db->limit($limit,$start);
		$category = $this->db->get('f_merchant_category')->result_array();

		//image link
		foreach ($category as $key => $value) {
			$category[$key]['MCT_IMAGES'] = $this->category_img_url . $value['MCT_IMAGES'];
		}

		//return
		if (!empty($category)) {
			$this->response->send(array('status'=>1,'data'=>$category));
		}else{
			$this->response->send(array('status'=>0,'data'=>array()));
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
			$this->response->send(array('status'=>1,'data'=>$promo));
		}else{
			$this->response->send(array('status'=>0,'data'=>array()));
		}
	}

	public function suggest(){
		$keyword = $this->input->get('keyword');

		if ($keyword) {
			$this->db->select('MCL_NAME,MCL_ID');
			$this->db->like('MCL_NAME' , $keyword);
			$merchant = $this->db->get('f_merchant_list')->result_array();
			

			if (!empty($merchant)) {
				$this->response->send(array('status'=>1,'data'=>$merchant));
			}else{
				$this->response->send(array('status'=>0,'data'=>array()));
			}
		}else{
			$this->response->send(array('status'=>0,'data'=>'keyword field is required'));
		}
	}

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

	private function countDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371){
	  // convert from degrees to radians
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;

	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  return $angle * $earthRadius;
	}


/*	public function import(){
		exit();
		$this->load->library('excel');
		$file = 'merchant.xlsx';
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();


				foreach ($cell_collection as $cell) {
				    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				    //header will/should be in row 1 only. of course this can be modified to suit your need.
				    if ($row == 1) {
				        $header[$row][$column] = $data_value;
				    } else {
				        $arr_data[$row][$column] = $data_value;
				    }
				}
				//send the data in an array format
				$values = array_values($arr_data);
				//echo "<pre>" . print_r($values,1) . "</pre>";
				$kol = array(
					'B' => 'MCL_NAME',
					'C' => 'MCL_ADDRESS',
					'E' => 'MCL_CATEGORY',
					'F' => 'MCL_LATLNG',
					'G' => 'MCL_CONTACT',
					'H' => 'MCL_OPEN'
				);

				$new_values = array();
				$index = 0;

				foreach ($values as $row) {
					$new_values[$index] = array();

					foreach ($kol as $key => $value) {
						if (in_array($key, array_keys($row))) {
							$new_values[$index][$kol[$key]] = $row[$key];
						}else{
							$new_values[$index][$kol[$key]] = '';
						}
					}

					$index++;
				}
				//echo "<pre>" . print_r($new_values,1) . "</pre>";
				foreach ($new_values as $key => $m) {
					$latlng = explode(',', str_replace(' ', '',$m['MCL_LATLNG']));
					$lat = isset($latlng[0])?$latlng[0]:NULL;
					$lng = isset($latlng[1])?$latlng[1]:NULL;
					/*if ($m['MCL_OPEN'] != '') {
						$open = explode('-',str_replace('WIB','',$m['MCL_OPEN']));
						$open_hours = date('H:i' , strtotime($open[0]));
						$close_hours = date('H:i' , strtotime($open[1]));
						echo $open_hours . '-' . $close_hours . '<br>';
					}
					$category_id = $this->get_category_id($m['MCL_CATEGORY']);
					$insert_data = array(
						'MCT_ID' => $category_id,
						'MCL_NAME'=>$m['MCL_NAME'],
						'MCL_INFO'=>NULL,
						'MCL_ADDRESS'=>$m['MCL_ADDRESS'],
						'MCL_IMAGES'=>NULL,
						'MCL_CONTACT'=>$m['MCL_CONTACT'],
						'MCL_OPEN_HOURS'=>NULL,
						'MCL_CLOSE_HOURS'=>NULL,
						'MCL_LATITUDE'=>$lat,
						'MCL_LONGITUDE'=>$lng,
						'MCL_RECOMMENDED'=>0,
					);
					$this->db->insert('f_merchant_list',$insert_data);

					$new_values[$key] = $insert_data;
				}

				echo "<pre>" . print_r($new_values,1) . "</pre>";

	}*/

	/*private function get_category_id($name){
		if($name == ''){
			return NULL;
		}
		$name = trim($name);
		$cat = $this->db->where('MCT_NAME',$name)->get('f_merchant_category')->row_array();
		if(!empty($cat)){
			return $cat['MCT_ID'];
		}else{
			$insert_data = array(
				'MCT_NAME' => $name,
			);
			$this->db->insert('f_merchant_category',$insert_data);
			return $this->db->insert_id();
		}

	}*/


}
