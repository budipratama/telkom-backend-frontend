<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_support extends MY_Controller {
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
    public function product(){
        $sessionMenu = array(
       'parent_menu_active'  => 'customer_support',
       'child_menu_active'  => 'product');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/product';
        $this->data['title_page'] = 'Product';
        $productData = $this->admin_model->get_all_products();
        // var_dump($this->db->last_query());exit();
        $this->data['productData'] = $productData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    public function product_detail(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $sessionMenu = array(
            'parent_menu_active'  => 'customer_support',
            'child_menu_active'  => 'product');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/product_detail';
        $this->data['title_page'] = 'Product';
        $productData = $this->admin_model->get_product(array('p.PRD_ID'=>$id));
        // $productData = $this->admin_model->get_where_data('f_product', $where);
        $productTypeData = $this->admin_model->get_all_data('f_product_type');
        $productGroupData = $this->admin_model->get_all_data('f_product_group');
        $operatorData = $this->admin_model->get_all_data('f_operator');
        $vendorData = $this->admin_model->get_all_data('f_vendor');

        // get vendor
        $where2 = array('PRD_ID'=>$id);
        $vendorSelected = $this->admin_model->get_where_data('f_product_to_vendor', $where2);

        $this->data['productData'] = $productData;
        $this->data['productTypeData'] = $productTypeData;
        $this->data['productGroupData'] = $productGroupData;
        $this->data['operatorData'] = $operatorData;
        $this->data['vendorData'] = $vendorData;
        $this->data['vendorSelected'] = $vendorSelected;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function product_add(){
        $sessionMenu = array(
            'parent_menu_active'  => 'customer_support',
            'child_menu_active'  => 'product');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/product_detail';
         $this->data['title_page'] = 'Product';
        $productTypeData = $this->admin_model->get_all_data('f_product_type');
        $productGroupData = $this->admin_model->get_all_data('f_product_group');
        $operatorData = $this->admin_model->get_all_data('f_operator');
        $vendorData = $this->admin_model->get_all_data('f_vendor');
        $this->data['vendorData'] = $vendorData;
        $this->data['productTypeData'] = $productTypeData;
        $this->data['productGroupData'] = $productGroupData;
        $this->data['operatorData'] = $operatorData;
         $this->data['menuListData'] = $this->menuSidebar();
         $this->load->view('admin/layout', $this->data);
    }
    function product_save(){
        $this->checkPostData();
        $prdName = $this->input->post('prdName');
        $prdId = $this->input->post('prdId');
        $prdCode = $this->input->post('prdCode');
        $prdType = $this->input->post('prdType');
        $prdGroup = $this->input->post('prdGroup');
        $operatorCode = $this->input->post('operatorCode');
        $vendorId = $this->input->post('vendorId');
        $active = $this->input->post('active');
        $prdOrder = $this->input->post('prdOrder');
        if($active == ''){
                $active = 0;
        }

        // update
        if(isset($prdId)){
            // update to product
            $tabel_name = 'f_product';
            $where = array('PRD_ID' => $prdId);
            $postData = array(
                'PRD_NAME' => $prdName, 'PRD_CODE' => $prdCode,
                'PRD_GROUP' => $prdGroup,'OP_CODE' => $operatorCode,
                'PRD_ACTIVE' => $active, 'UPDATED_ON' => date('Y-m-d h:m:s'),
                'UPDATED_BY' => $this->session->userdata('username')
            );
            $update = $this->admin_model->updateDb($tabel_name, $where, $postData);

            // update order
            $this->admin_model->update_product_order($prdId, $prdOrder);

            // update vendor
            $where2 = array('PRD_ID'=>$prdId);
            $getProdToVendor = $this->admin_model->get_where_data('f_product_to_vendor', $where2);
            if(empty($getProdToVendor)){
                $tabel_name3 = 'f_product_to_vendor';
                $postData3 = array('PRD_ID' => $prdId, 'VENDOR_ID' => $vendorId);
                $addData = $this->admin_model->addDb($tabel_name3, $postData3);
            }else{
                $tabel_name4 = 'f_product_to_vendor';
                $where4 = array('PRD_ID' => $prdId);
                $postData4 = array('VENDOR_ID' => $vendorId);
                $update2 = $this->admin_model->updateDb($tabel_name4, $where4, $postData4);
            }

            $res = array('result' => TRUE, 'message' => 'Update Success');
            echo json_encode($res);
        }

        // create
        else{
            // insert to product
            $tabel_name = 'f_product';
            $postData = array(
                'PRD_NAME' => $prdName, 'PRD_CODE' => $prdCode,
                'PRD_GROUP' => $prdGroup,'OP_CODE' => $operatorCode,
                'PRD_ACTIVE' => $active, 'CREATED_ON' => date('Y-m-d h:m:s'),
                'CREATED_BY' => $this->session->userdata('username')
            );
            $addData = $this->admin_model->addDb($tabel_name, $postData);

            // insert to vendor
            if($addData){
                $tabel_name3 = 'f_product_to_vendor';
                $postData3 = array('PRD_ID' => $addData, 'VENDOR_ID' => $vendorId);
                $addData3 = $this->admin_model->addDb($tabel_name3, $postData3);
                $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user info Success'));
                redirect('customer_support/product');
            }
        }
    }
    function product_delete(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $where = array('PRD_ID' => $id);

        // delete product
        $delete_product = $this->admin_model->delete_where('f_product', $where);
        if($delete_product){
            // delete product to vendor
            $delete_prod_to_vend = $this->admin_model->delete_where('f_product_to_vendor', $where);

            $res = array('result' => TRUE, 'message' => 'Delete Success');
        }
        echo json_encode($res);
    }
    public function vendor_profile(){
        $sessionMenu = array(
       'parent_menu_active'  => 'customer_support',
       'child_menu_active'  => 'vendor_profile');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/vendor_profile';
        $this->data['title_page'] = 'Vendor Profile';
        $vendorData = $this->admin_model->get_all_data('f_vendor');
        $this->data['vendorData'] = $vendorData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    public function vendor_profile_detail(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $sessionMenu = array(
            'parent_menu_active'  => 'customer_support',
            'child_menu_active'  => 'vendor_profile');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/vendor_profile_detail';
        $this->data['title_page'] = 'Vendor Profile';
        $where = array('ID'=>$id);
        $vendorData = $this->admin_model->get_where_data('f_vendor', $where);
        $this->data['vendorData'] = $vendorData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function vendor_profile_add(){
        $sessionMenu = array(
        'parent_menu_active'  => 'customer_support',
        'child_menu_active'  => 'vendor_profile');
         $this->session->set_flashdata($sessionMenu);
         $this->data['content_page'] = 'admin/pages/customer_support/vendor_profile_detail';
         $this->data['title_page'] = 'Vendor Profile';
         $this->data['menuListData'] = $this->menuSidebar();
         $this->load->view('admin/layout', $this->data);
    }
    function vendor_profile_save(){
        $this->checkPostData();
        $vendorName = $this->input->post('vendorName');
        $vendorId = $this->input->post('vendorId');
        $vendorCode = $this->input->post('vendorCode');
        $vendorAcc = $this->input->post('vendorAcc');
        $telcoCode = $this->input->post('telcoCode');
        $bankAcc = $this->input->post('bankAcc');
        $remarks = $this->input->post('remarks');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
        $active = $this->input->post('active');
        if($active == ''){
                $active = 0;
        }
        if(isset($vendorId)){
                $tabel_name = 'f_vendor';
                $where = array('ID' => $vendorId);
                $postData = array('VENDOR_NAME' => $vendorName, 'VENDOR_CODE' => $vendorCode, 'VENDOR_ACTIVE_FROM' => $dateFrom,
                                  'VENDOR_ACTIVE_TO' => $dateTo,'REMARKS' => $remarks,'TELCO_CODE' => $telcoCode,'VENDOR_ACCOUNT' => $vendorAcc,
                                  'BANK_ACCOUNT' => $bankAcc, 'STATUS' => $active, 'UPDATED_ON' => date('Y-m-d h:m:s'), 'UPDATED_BY' => $this->session->userdata('username'));
                $update = $this->admin_model->updateDb($tabel_name, $where, $postData);
                $res = array('result' => TRUE, 'message' => 'Update Success');
                echo json_encode($res);
        }else{
                $tabel_name = 'f_vendor';
                $postData = array('VENDOR_NAME' => $vendorName, 'VENDOR_CODE' => $vendorCode, 'VENDOR_ACTIVE_FROM' => $dateFrom,
                                  'VENDOR_ACTIVE_TO' => $dateTo,'REMARKS' => $remarks,'TELCO_CODE' => $telcoCode,'VENDOR_ACCOUNT' => $vendorAcc,
                                  'BANK_ACCOUNT' => $bankAcc, 'STATUS' => $active, 'CREATED_ON' => date('Y-m-d h:m:s'), 'CREATED_BY' => $this->session->userdata('username'));
                $addData = $this->admin_model->addDb($tabel_name, $postData);
                if($addData){
                        $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user info Success'));
                        redirect('customer_support/vendor_profile');
                }
        }
    }
    function vendor_profile_delete(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $where = array('ID' => $id);
        $delete = $this->admin_model->delete_where('f_vendor', $where);
        if($delete){
                $res = array('result' => TRUE, 'message' => 'Delete Success');
        }
        echo json_encode($res);
    }
    public function product_value(){
        $sessionMenu = array(
       'parent_menu_active'  => 'customer_support',
       'child_menu_active'  => 'product_value');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/product_value';
        $this->data['title_page'] = 'Product Value';
        $productValueData = $this->admin_model->get_all_data('f_product_value');
        $productData = $this->admin_model->get_all_data('f_product');
        $this->data['productValueData'] = $productValueData;
        $this->data['productData'] = $productData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function product_value_detail(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $sessionMenu = array(
            'parent_menu_active'  => 'customer_support',
            'child_menu_active'  => 'product_value');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/product_value_detail';
        $this->data['title_page'] = 'Product Value';
        $where = array('ID'=>$id);
        $productValueData = $this->admin_model->get_where_data('f_product_value', $where);
        $productData = $this->admin_model->get_all_data('f_product');
        $this->data['productData'] = $productData;
        $this->data['productValueData'] = $productValueData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function product_value_add(){
        $sessionMenu = array(
            'parent_menu_active'  => 'customer_support',
            'child_menu_active'  => 'product_value');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/customer_support/product_value_detail';
        $this->data['title_page'] = 'Product Value';
        $productData = $this->admin_model->get_all_data('f_product');
        $this->data['productData'] = $productData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function product_value_save(){
        $this->checkPostData();
        $prdName = $this->input->post('prdName');
        $prdValueId = $this->input->post('prdValueId');
        $prdValue = $this->input->post('prdValue');
        if(isset($prdValueId)){
                $tabel_name = 'f_product_value';
                $where = array('ID' => $prdValueId);
                $postData = array('PRD_ID' => $prdName, 'PRD_VALUE' => $prdValue);
                $update = $this->admin_model->updateDb($tabel_name, $where, $postData);
                $res = array('result' => TRUE, 'message' => 'Update Success');
                echo json_encode($res);
        }else{
                $tabel_name = 'f_product_value';
                $postData = array('PRD_ID' => $prdName, 'PRD_VALUE' => $prdValue);
                $addData = $this->admin_model->addDb($tabel_name, $postData);
                if($addData){
                        $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user info Success'));
                        redirect('customer_support/product_value');
                }
        }
    }
    function product_value_delete(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $where = array('ID' => $id);
        $delete = $this->admin_model->delete_where('f_product_value', $where);
        if($delete){
                $res = array('result' => TRUE, 'message' => 'Delete Success');
        }
        echo json_encode($res);
    }

    public function operator(){
        // set menu
        $sessionMenu = array(
           'parent_menu_active'  => 'customer_support',
           'child_menu_active'  => 'operator'
        );
        $this->session->set_flashdata($sessionMenu);

        $this->data['content_page'] = 'admin/pages/customer_support/operator';
        $this->data['title_page'] = 'Operator';
        $this->data['menuListData'] = $this->menuSidebar();

        // get data
        $data = $this->admin_model->get_all_operator();
        $this->data['operator'] = $data;

        $this->load->view('admin/layout', $this->data);
    }

    public function operator_add(){
        // set menu
        $sessionMenu = array(
           'parent_menu_active'  => 'customer_support',
           'child_menu_active'  => 'operator',
        );
        $this->session->set_flashdata($sessionMenu);

        $this->data['content_page'] = 'admin/pages/customer_support/operator_form';
        $this->data['title_page'] = 'Operator Add';
        $this->data['menuListData'] = $this->menuSidebar();

        // validate
        $this->form_validation->set_rules(array(
                array(
                        'field' => 'name',
                        'label' => 'Operator Name',
                        'rules' => 'required',
                    ),
            ));

        // form
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/layout', $this->data);
        }

        // add
        else {
            // set input
            $arg['OP_NAME'] = $this->input->post('name', TRUE);
            $arg['OP_ACTIVE'] = $this->input->post('active', TRUE);
            $arg['OP_ACTIVE'] = ($arg['OP_ACTIVE'] == '1') ? 1 : 0;

            $create = $this->admin_model->create_operator($arg);

            if($create === FALSE){
                $this->session->set_flashdata('msg-error', 'Sistem error, tambah operator gagal!');
            }
            elseif($create !== TRUE){
                $this->session->set_flashdata('msg-error', $create);
            }
            else{
                $this->session->set_flashdata('msg-success', 'Tambah operator berhasil!');

                redirect('customer_support/operator');
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function operator_detail($id = NULL){
        // set menu
        $sessionMenu = array(
           'parent_menu_active'  => 'customer_support',
           'child_menu_active'  => 'operator',
        );
        $this->session->set_flashdata($sessionMenu);

        $this->data['content_page'] = 'admin/pages/customer_support/operator_form';
        $this->data['title_page'] = 'Operator Add';
        $this->data['menuListData'] = $this->menuSidebar();

        // validate
        $this->form_validation->set_rules(array(
                array(
                        'field' => 'name',
                        'label' => 'Operator Name',
                        'rules' => 'required',
                    ),
            ));

        // form
        if ($this->form_validation->run() === FALSE) {
            // get data
            $this->data['operator'] = $this->admin_model->get_operator($id);

            $this->load->view('admin/layout', $this->data);
        }

        // add
        else {
            // set input
            $arg['OP_NAME'] = $this->input->post('name', TRUE);
            $arg['OP_ACTIVE'] = $this->input->post('active', TRUE);
            $arg['OP_ACTIVE'] = ($arg['OP_ACTIVE'] == '1') ? 1 : 0;

            $update = $this->admin_model->update_operator($id, $arg);

            if($update === FALSE){
                $this->session->set_flashdata('msg-error', 'Sistem error, update operator gagal!');
            }
            elseif($update !== TRUE){
                $this->session->set_flashdata('msg-error', $update);
            }
            else{
                $this->session->set_flashdata('msg-success', 'Update operator berhasil!');

                redirect('customer_support/operator');
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
