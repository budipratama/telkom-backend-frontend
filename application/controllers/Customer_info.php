<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_info extends MY_Controller {

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
        $this->load->model(array('admin_model','admin_model'));
        $this->load->library('form_validation');
        $this->data['css_admin'] = $this->config->item('css_admin_patch');
        $this->data['js_admin'] = $this->config->item('js_admin_patch');
    }
    public function index(){
        redirect('dashboard');
    }
    public function customer(){
        $sessionMenu = array(
            'parent_menu_active'  => 'customer_info',
            'child_menu_active'  => 'customer');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_info/customer';
        $this->data['title_page'] = 'Customer Info';
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }

    public function ajax_search_customer(){
        // search customer
        $customers = $this->admin_model->search_customer(array(
                'search_based' => $this->input->post('search_based'),
                'masukan_pencarian' => $this->input->post('masukan_pencarian'),
            ));

        // json
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($customers));
    }

    public function customer_detail(){
        $custId = $this->input->post('custId');
        $sessionMenu = array(
       'parent_menu_active'  => 'customer_info',
       'child_menu_active'  => 'customer');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_info/customer_detail';
        $this->data['title_page'] = 'Edit Customer Detail';
        $customerLevel = $this->admin_model->get_all_data('f_cust_level');
        $this->data['customerLevel'] = $customerLevel;

        // customer data
        $where = array('ID'=>$custId);
        $customerData = $this->admin_model->get_customer_where($where);
        $this->data['customerData'] = $customerData;
        $provinsiData = $this->admin_model->get_all_data('f_provinsi');
        $this->data['provinsiDataList'] = $provinsiData;
        $this->data['menuListData'] = $this->menuSidebar();

        $this->load->view('admin/layout', $this->data);
    }

    public function customer_update(){
        $this->form_validation->set_rules('custName','Customer Name','required');
        $this->form_validation->set_rules('custProv','Customer Province','required');
        $this->form_validation->set_rules('custCity','Customer City','required');
        $this->form_validation->set_rules('custAddress','Customer Address','required');
        $this->form_validation->set_rules('identityType','Customer Type','required');
        $this->form_validation->set_rules('identityCode','Customer Code','required');
        $this->form_validation->set_rules('custPhone','Customer Phone','required');

        if ($this->form_validation->run() == TRUE) {
                $input = $this->input->post();
                // var_dump($input);exit();
                $update = $this->admin_model->update_customer($input['custId'],array(
                                'CUSTNAME' => $input['custName'],
                                'PROVINCEID' => $input['custProv'],
                                'CITYID' => $input['custCity'],
                                'CUSTADDRESS' => $input['custAddress'],
                                'IDENTITYTYPE' => $input['identityType'],
                                'IDENTITYCODE' => $input['identityCode'],
                                'CUSTPHONE' => $input['custPhone'],
                        ));

                if($update){
                        $res = array('result' => TRUE, 'message' => 'Update success.');
                }else{
                        $res = array('result' => FALSE, 'message' => 'Update failed, terjadi kesalahan sistem!');
                }
        } else {
                $res = array('result' => FALSE, 'message' => 'Update failed, all field required!');
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

    public function ajax_set_block(){
        $custId = $this->input->post('custId');
        $blockStatus = $this->input->post('blockStatus');

        // unblock
        $status = $this->admin_model->set_block($custId, $blockStatus);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                    'status' => $status
                )));
    }

    public function merchant_setting(){
        $sessionMenu = array(
       'parent_menu_active'  => 'customer_info',
       'child_menu_active'  => 'merchant_setting');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_info/merchant_setting';
        $this->data['title_page'] = 'Merchant Setting';

        // customer data
        $merchantList = $this->admin_model->get_customer_where_in('CUSTTYPEID',array(3));
        $this->data['merchantList'] = $merchantList;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }

    public function merchant_detail(){
        $custId = $this->input->post('custId');
	   	$sessionMenu = array(
               'parent_menu_active'  => 'customer_info',
               'child_menu_active'  => 'merchant_setting');
		$this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_info/merchant_detail';
        $this->data['title_page'] = 'Edit Customer Detail';

        // customer data
        $where = array('C.ID'=>$custId);
        $customerData = $this->admin_model->get_merchant_detail($where);
        $where2 = array('CUSTCODE'=>$customerData[0]['CUSTCODE']);
        $tarifSelected = $this->admin_model->get_where_data('f_cust_to_fee_header', $where2);
        $tarifData = $this->admin_model->get_all_data('f_fee_header');
        $this->data['customerData'] = $customerData;
        $this->data['tarifData'] = $tarifData;
        $this->data['tarifSelected'] = $tarifSelected;
        $this->data['menuListData'] = $this->menuSidebar();

        $this->load->view('admin/layout', $this->data);
    }
    function merchant_setting_save(){
        $this->checkPostData();
        $custCode = $this->input->post('custCode');
        $mercTarif = $this->input->post('mercTarif');
        $tabel_name = 'f_cust_to_fee_header';
        $where = array('CUSTCODE' => $custCode);
        $postData = array('FH_ID' => $mercTarif);
        $update = $this->admin_model->updateDb($tabel_name, $where, $postData);
        if($update){
            redirect('customer_info/merchant_setting');
        }
    }
}
