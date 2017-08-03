<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authorize extends MY_Controller {

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
        date_default_timezone_set('Asia/Jakarta');
    }
	public function index(){
		redirect('dashboard');
	}
	public function merchant(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'authorize',
               'child_menu_active'  => 'merchant');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/authorize/merchant';
		$this->data['title_page'] = 'Authorize Merchant';
		$where = array(
                'CUSTTYPEID'=>3,
                'STATUS'=>0,
            );
		$customerList = $this->admin_model->get_customer_where($where);
		$this->data['customerList'] = $customerList;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function merchant_detail(){
		$custId = $this->input->post('custId');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'authorize',
               'child_menu_active'  => 'merchant');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/authorize/merchant_detail';
		$this->data['title_page'] = 'Authorize Merchant Detail';
		$where = array('C.ID'=>$custId);
		$customerData = $this->admin_model->get_merchant_detail($where);
		$this->data['customerData'] = $customerData;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
    function updateMerchant(){
        $postData = $this->input->post();
        if($postData['custId'] != '' && $postData['remarks'] != '' && $postData['approval'] !== ''){
            $updateMerchantData = $this->admin_model->updateDbMerchant($postData);
            if($updateMerchantData){
                $res = array('result' => TRUE, 'message' => 'Update Success');
            }else{
                $res = array('result' => FALSE, 'message' => 'Update Failed');
            }
        }else{
            $res = array('result' => FALSE, 'message' => 'Update Failed');
        }
        echo json_encode($res);
    }

	function merchantApproval(){
		$postData = $this->input->post();
		if($postData['custId'] != '' && $postData['remarks'] != '' && $postData['approval'] !== ''){
            // set aprroval
            $update_status = $this->admin_model->setMerchantApproval($postData['custId'], array(
                    'status' => $postData['approval'],
                    'remarks' => $postData['remarks'],
                ));

			if($update_status){
				$res = array('result' => TRUE, 'message' => 'Update Success');
			}else{
				$res = array('result' => FALSE, 'message' => 'Update Failed');
			}
		}else{
			$res = array('result' => FALSE, 'message' => 'Update Failed');
		}
		echo json_encode($res);
	}

	public function platinum(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'authorize',
               'child_menu_active'  => 'platinum');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/authorize/platinum';
		$this->data['title_page'] = 'Authorize Full Service';
		// $where = array('CUSTTYPEID'=>2); // update by note
		// $customerList = $this->admin_model->get_customer_where($where); //update by note
		$customerList = $this->admin_model->get_cust_req_upgrade();
		$this->data['customerList'] = $customerList;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function platinum_detail(){
		$custId = $this->input->post('custId');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'authorize',
               'child_menu_active'  => 'platinum');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/authorize/platinum_detail';
		$this->data['title_page'] = 'Authorize Full Service Detail';
		$where = array('C.ID'=>$custId);
		$customerData = $this->admin_model->get_request_upgrade_detail($where);
		$custLevel = $this->admin_model->get_all_data('f_cust_level');
		$this->data['customerData'] = $customerData;
		$this->data['custLevel'] = $custLevel;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function updatePlatinum(){
		$postData = $this->input->post();
		if($postData['custId'] != '' && $postData['remarks'] != '' && $postData['custType'] !== ''){
                    $updatePlatinumData = $this->admin_model->updateDbMerchant($postData);
                    if($updatePlatinumData){
                        $upgradeCode = $this->input->post('upgradeCode');

                        // update customer upgrade status
                        $this->admin_model->update_cust_upgrade($upgradeCode, 1);   // sukses

                        $res = array('result' => TRUE, 'message' => 'Update Success');
                    }else{
                        $res = array('result' => FALSE, 'message' => 'Update Failed');
                    }
		}else{
			$res = array('result' => FALSE, 'message' => 'Update Failed');
		}
		echo json_encode($res);
	}
	public function registration(){
	   	$sessionMenu = array(
               'parent_menu_active'  => 'authorize',
               'child_menu_active'  => 'registration');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/authorize/registration';
		$this->data['title_page'] = 'Registration Platinum';
		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$where = array('LEVEL_STATUS' => 1);
		$custLevel = $this->admin_model->get_where_data('f_cust_level', $where);
		$this->data['provinsiDataList'] = $provinsiData;
		$this->data['custLevel'] = $custLevel;
                $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}

    public function addRegistration(){
        $postData = $this->input->post();
        $custCodeLast = $this->admin_model->getLastCustCode();
        $custCode = $custCodeLast['CUSTCODE']+1;
        $regDate = date("Y-m-d H:i:s");
        $duplicatePhone = $this->admin_model->checkDuplicatePhoneNumber($postData['custPhone']);

        if(!$duplicatePhone){
            $checkEmail = $this->admin_model->checkEmail($postData['custEmail']);
            if($checkEmail){
                // register to API
                $addNewViaApi = $this->admin_model->addRegistrationApi($postData);

                // register via API success
                if(isset($addNewViaApi['resultCode']) && $addNewViaApi['resultCode'] == '0'){
                    $res = array('result'=>TRUE, 'custId' => $addNewViaApi['idTmoney']);
                }
                // failed register via API
                else{
                    // set msg
                    $resultDesc = isset($addNewViaApi['resultDesc']) ? $addNewViaApi['resultDesc'] : 'System error accured!';

                    // set response
                    $res = array(
                            'result' => FALSE,
                            'message' => 'Registration Failed',
                            'error' => $resultDesc
                        );
                }

            }else{
                $res = array(
                    'result' => FALSE,
                    'message' => 'Registration Failed',
                    'error' => 'User Email Exists!'
                );
            }
        }else{
            $res = array(
                'result' => FALSE,
                'message' => 'Registration Failed',
                'error' => 'Phone Number Exists!'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

	function registration_detail(){
		$custId = $this->input->post('custIdRegNew');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'authorize',
               'child_menu_active'  => 'registration');
		$this->session->set_flashdata($sessionMenu);
		$this->data['content_page'] = 'admin/pages/authorize/registration_detail';
		$this->data['title_page'] = 'Authorize Registration Detail';
        $customerData = $this->admin_model->get_customer($custId);

        // get cust type
        $custTypeId = isset($customerData[0]['CUSTTYPEID']) ? $customerData[0]['CUSTTYPEID'] : NULL;
		$custType = $this->admin_model->get_cust_type_where(array(
                'CUST_TYPE_ID' => $custTypeId,
            ));

		$provinsiData = $this->admin_model->get_all_data('f_provinsi');
		$cityData = $this->admin_model->get_all_data('f_kabkota');
		$this->data['provinsiDataList'] = $provinsiData;
		$this->data['cityDataList'] = $cityData;
        $this->data['customerData'] = $customerData;
		$this->data['customerTypeData'] = $custType;
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
	function getCityByProv(){
		$provId = $this->input->post('provId');
		$where = array('ID_PROVINSI' => $provId);
		$cityData = $this->admin_model->get_where_data('f_kabkota', $where);
		echo json_encode($cityData);
	}
}
