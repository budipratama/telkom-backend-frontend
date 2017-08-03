<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {

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
    public function tarif_template(){
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template';
        $this->data['title_page'] = 'Tarif Template';
        $tarifHeaderData = $this->admin_model->get_all_data('f_fee_header');
        $this->data['tarifHeaderData'] = $tarifHeaderData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function tarif_template_detail(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_detail';
        $this->data['title_page'] = 'Tarif Template';
        $where = array('FH_ID'=>$id);
        $tarifData = $this->admin_model->get_where_data('f_fee_header', $where);
        $this->data['tarifData'] = $tarifData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function tarif_template_add(){
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_detail';
        $this->data['title_page'] = 'Tarif Template';
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function tarif_template_save(){
        $this->checkPostData();
        $trfName = $this->input->post('trfName');
        $trfId = $this->input->post('trfId');
        $trfDesc = $this->input->post('trfDesc');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
        $active = $this->input->post('active');
        if($active == ''){
                $active = 0;
        }
        if(isset($trfId)){
            $tabel_name = 'f_fee_header';
            $where = array('FH_ID' => $trfId);
            $postData = array('FH_NAME' => $trfName,  'FH_STATUS' => $active, 'FH_ACTIVE_FROM'=>$dateFrom, 'FH_ACTIVE_TO' => $dateTo,
                        'DESCRIPTION'=>$trfDesc, 'UPDATED_ON' => date('Y-m-d h:m:s'), 'UPDATED_BY' => $this->session->userdata('username'));
            $update = $this->admin_model->updateDb($tabel_name, $where, $postData);
            // $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Update user level Success'));
            $res = array('result' => TRUE, 'message' => 'Update Success');
            echo json_encode($res);
        }else{
            $tabel_name = 'f_fee_header';
            $fh_code = sha1(date('Y-m-d h:m:s'));
            $postData = array('FH_CODE' => $fh_code, 'FH_NAME' => $trfName,  'FH_STATUS' => $active, 'FH_ACTIVE_FROM'=>$dateFrom, 'FH_ACTIVE_TO' => $dateTo,
                        'DESCRIPTION'=>$trfDesc, 'UPDATED_ON' => date('Y-m-d h:m:s'), 'UPDATED_BY' => $this->session->userdata('username'));
            $addData = $this->admin_model->addDb($tabel_name, $postData);
            if($addData){
                    $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add Success'));
                    redirect('setting/tarif_template');
            }
        }
    }
    function tarif_template_delete(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $where = array('FH_ID' => $id);
        $delete = $this->admin_model->delete_where('f_fee_header', $where);
        if($delete){
                $res = array('result' => TRUE, 'message' => 'Delete Success');
        }
        echo json_encode($res);
    }
    public function tarif_template_body(){
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template_body');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_body';
        $this->data['title_page'] = 'Tarif Template';
        $dataTarifBody = $this->admin_model->get_all_tarif_body();
        $tarifHeaderData = $this->admin_model->get_all_data('f_fee_header');
        $this->data['tarifHeaderData'] = $tarifHeaderData;
        $this->data['dataTarifBody'] = $dataTarifBody;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function tarif_template_body_detail(){
        $id = $this->input->post('id');
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template_body');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_body_detail';
        $this->data['title_page'] = 'Tarif Template';
        $where = array('FB_ID'=>$id);
        $tarifBodyData = $this->admin_model->get_where_data('f_fee_body', $where);


        $where = array('FB_ID'=>$id);
        $tarifDivideData = $this->admin_model->get_where_data('f_fee_divide', $where);


        $tarifHeaderData = $this->admin_model->get_all_data('f_fee_header');
        $tarifFlowData = $this->admin_model->get_all_data('f_fee_flow');
        $productData = $this->admin_model->get_all_data('f_product');
        $productValueData = $this->admin_model->get_all_data('f_product_value');
        $refcodeData = $this->admin_model->get_all_data('f_fee_refcode');
        $typeData = $this->admin_model->get_all_data('f_fee_type');
        $this->data['tarifBodyData'] = $tarifBodyData;
        $this->data['tarifDivideData'] = $tarifDivideData;
        $this->data['tarifHeaderData'] = $tarifHeaderData;
        $this->data['tarifFlowData'] = $tarifFlowData;
        $this->data['productData'] = $productData;
        $this->data['productValueData'] = $productValueData;
        $this->data['refcodeData'] = $refcodeData;
        $this->data['typeData'] = $typeData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function checkPrdValByPrdName(){
        $idPrdName = $this->input->post('prdName');
        $where = array('PRD_ID' => $idPrdName);
        $prdVal = $this->admin_model->get_where_data('f_product_value', $where);
        echo json_encode($prdVal);
    }
    function checkPrdByType(){
        $prdType = $this->input->post('prdType');
        $prdData = $this->admin_model->get_product_by_prd_type($prdType);
        echo json_encode($prdData);
    }
    function tarif_template_body_add(){
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template_body');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_body_detail';
        $this->data['title_page'] = 'Tarif Template';
        $tarifHeaderData = $this->admin_model->get_all_data('f_fee_header');
        $productData = $this->admin_model->get_all_data('f_product');
        $productValueData = $this->admin_model->get_all_data('f_product_value');
        $refcodeData = $this->admin_model->get_all_data('f_fee_refcode');
        $typeData = $this->admin_model->get_all_data('f_fee_type');
        $tarifFlowData = $this->admin_model->get_all_data('f_fee_flow');
        $productTypeData = $this->admin_model->get_all_data('f_product_type');
        $this->data['tarifHeaderData'] = $tarifHeaderData;
        $this->data['productData'] = $productData;
        $this->data['productValueData'] = $productValueData;
        $this->data['productTypeData'] = $productTypeData;
        $this->data['tarifFlowData'] = $tarifFlowData;
        $this->data['refcodeData'] = $refcodeData;
        $this->data['typeData'] = $typeData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function tarif_template_body_save(){
        $this->checkPostData();
        $FB_ID = $this->input->post('FB_ID');
        $FH_ID = $this->input->post('FH_ID');
        $REF_ID = $this->input->post('REF_ID');
        $PRD_NAME = $this->input->post('PRD_NAME');
        $PRD_VAL_ID = $this->input->post('PRD_VAL_ID');
        $FT_ID = $this->input->post('FT_ID');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
        $active = $this->input->post('active');

        $FF_ID_array = $this->input->post('FF_ID_array');
        $FD_TYPE_array = $this->input->post('FD_TYPE_array');
        $trfDivideVal = $this->input->post('trfDivideVal');
        $idFusion = $this->input->post('idFusion');

        if(!isset($FF_ID_array)){
            $FF_ID_array = $this->input->post('FF_ID');
            $FD_TYPE_array = $this->input->post('FD_TYPE');
            $trfDivideVal = $this->input->post('trfDivideVal');
            $idFusion = $this->input->post('idFusion');
        }
        if(!isset($PRD_NAME)){
            $PRD_NAME = "-";
        }
        if(!isset($PRD_VAL_ID)){
            $PRD_VAL_ID = "-";
        }
        if($active == ''){
            $active = 0;
        }

        // edit
        if(isset($FB_ID)){
            $tabel_name = 'f_fee_body';
            $where = array('FB_ID' => $FB_ID);
            $postData = array(
                'FH_ID' => $FH_ID, 'PRD_ID' => $PRD_NAME,
                'PRD_VAL_ID' => $PRD_VAL_ID, 'REF_ID'=>$REF_ID,
                'FB_ACTIVE_FROM'=>$dateFrom, 'FB_ACTIVE_TO' => $dateTo,
                'FT_ID'=>$FT_ID,  'FB_STATUS' => $active,
                'UPDATED_ON' => date('Y-m-d h:m:s'), 'UPDATED_BY' => $this->session->userdata('username')
              );
            $update = $this->admin_model->updateDb($tabel_name, $where, $postData);


            for($i=0; $i<count($FF_ID_array); $i++){
                $tabel_name2 = 'f_fee_divide';
                $where2 = array('FB_ID' => $FB_ID, 'FF_ID' => $FF_ID_array[$i]);
                $postData2 = array(
                    'FUSION_ID'=>$idFusion[$i],
                    'FD_VALUE' => $trfDivideVal[$i],
                    'UPDATED_ON' => date('Y-m-d h:m:s'),
                    'UPDATED_BY' => $this->session->userdata('username'),
                    'FD_TYPE' => $FD_TYPE_array[$i]
                );
                $update = $this->admin_model->updateDb($tabel_name2, $where2, $postData2);
            }



            // $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Update user level Success'));
            $res = array('result' => TRUE, 'message' => 'Update Success');
            echo json_encode($res);
        }
        // add
        else{
                $tabel_name = 'f_fee_body';
                $postData = array('FH_ID' => $FH_ID, 'PRD_ID' => $PRD_NAME, 'PRD_VAL_ID' => $PRD_VAL_ID, 'REF_ID'=>$REF_ID, 'FB_ACTIVE_FROM'=>$dateFrom, 'FB_ACTIVE_TO' => $dateTo,
                              'FT_ID'=>$FT_ID,  'FB_STATUS' => $active, 'CREATED_ON' => date('Y-m-d h:m:s'), 'CREATED_BY' => $this->session->userdata('username'));
                $addData = $this->admin_model->addDb($tabel_name, $postData);
                if($addData){

                    for($i=0; $i<count($FF_ID_array); $i++){
                        $sourcePay = 0;
                        if($FF_ID_array[$i] == "1"){
                            $sourcePay = 1;
                        }
                        $fd_type= 'F';
                        if($FF_ID_array[$i] == "4"){
                            $fd_type = 'P';
                        }
                        $tabel_name2 = 'f_fee_divide';
                        $postData2 = array(
                            'FB_ID'=>$addData,
                            'FD_SOURCE_PAY'=>$sourcePay,
                            'FD_STATUS'=>'1',
                            'FD_TYPE'=>$FD_TYPE_array[$i],
                            'FUSION_ID'=>$idFusion[$i],
                            'FF_ID'=>$FF_ID_array[$i],
                            'FD_VALUE' => $trfDivideVal[$i],
                            'CREATED_ON' => date('Y-m-d h:m:s'),
                            'CREATED_BY' => $this->session->userdata('username'),
                        );
                        $addData2 = $this->admin_model->addDb($tabel_name2, $postData2);

                    }
                        $this->session->set_flashdata(array('result' => TRUE, 'message' => 'Add user info Success'));
                        redirect('setting/tarif_template_body');
                }
        }
    }
    function tarif_template_body_delete(){
        $this->checkPostData();
        $id = $this->input->post('id');
        $where = array('FB_ID' => $id);
        $delete = $this->admin_model->delete_where('f_fee_body', $where);
        $delete2 = $this->admin_model->delete_where('f_fee_divide', $where);
        if($delete){
                $res = array('result' => TRUE, 'message' => 'Delete Success');
        }
        echo json_encode($res);
    }
    public function tarif_template_divide(){
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template_divide');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_divide';
        $this->data['title_page'] = 'Tarif Template';
        $dataTarifDivide = $this->admin_model->get_all_tarif_divide();
        $tarifHeaderData = $this->admin_model->get_all_data('f_fee_header');
        $this->data['tarifHeaderData'] = $tarifHeaderData;
        $this->data['dataTarifDivide'] = $dataTarifDivide;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function tarif_template_divide_detail(){
        $id = $this->input->post('id');
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template_divide');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_divide_detail';
        $this->data['title_page'] = 'Tarif Template';
        $where = array('FD_ID'=>$id);
        $tarifDivideData = $this->admin_model->get_where_data('f_fee_divide', $where);



        $tarifHeaderData = $this->admin_model->get_all_data('f_fee_header');
        $tarifBodyData = $this->admin_model->get_all_data('f_fee_body');
        $productData = $this->admin_model->get_all_data('f_product');
        $productValueData = $this->admin_model->get_all_data('f_product_value');
        $refcodeData = $this->admin_model->get_all_data('f_fee_refcode');
        $typeData = $this->admin_model->get_all_data('f_fee_type');
        $this->data['tarifDivideData'] = $tarifDivideData;
        $this->data['tarifBodyData'] = $tarifBodyData;
        $this->data['tarifHeaderData'] = $tarifHeaderData;
        $this->data['productData'] = $productData;
        $this->data['productValueData'] = $productValueData;
        $this->data['refcodeData'] = $refcodeData;
        $this->data['typeData'] = $typeData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function tarif_template_divide_add(){
        $sessionMenu = array(
       'parent_menu_active'  => 'setting',
       'child_menu_active'  => 'tarif_template_body');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/setting/tarif_template_body_detail';
        $this->data['title_page'] = 'Tarif Template';
        $tarifHeaderData = $this->admin_model->get_all_data('f_fee_header');
        $productData = $this->admin_model->get_all_data('f_product');
        $productValueData = $this->admin_model->get_all_data('f_product_value');
        $refcodeData = $this->admin_model->get_all_data('f_fee_refcode');
        $typeData = $this->admin_model->get_all_data('f_fee_type');
        $this->data['tarifHeaderData'] = $tarifHeaderData;
        $this->data['productData'] = $productData;
        $this->data['productValueData'] = $productValueData;
        $this->data['refcodeData'] = $refcodeData;
        $this->data['typeData'] = $typeData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
}
