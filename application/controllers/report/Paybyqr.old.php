<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paybyqr extends MY_Controller {

     // pagination
    protected $per_page_view = 10;
    protected $offset = 0;

    
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
    public function view_invoice(){

        //filter search
         $this->db->start_cache();
         $this->db->select('trans_id, CUSTCODE, CUSTNAME, EMAIL, paidAmount, merchantName, invoiceId, date');
        if ($this->input->get('s')) {
            $keyword = $this->db->escape('%'. $this->input->get('s'). '%');
            $this->db->where("( `f_customer`.EMAIL LIKE $keyword ", null, FALSE);
            $this->db->or_where("invoiceId LIKE $keyword ", null, FALSE);
            $this->db->or_where("`f_customer`.CUSTCODE LIKE $keyword )", null, FALSE);
        }
         //filter range tanggal
        if($this->input->get('range')){
            $tanggal = explode('-', $this->input->get('range'));
            $tanggal_awal = date('Y-m-d 00:00:00',strtotime($tanggal[0]));
            $tanggal_akhir = date('Y-m-d 23:59:59',strtotime($tanggal[1]));
            $this->db->where('date BETWEEN "'.$tanggal_awal.'" AND "'.$tanggal_akhir.'"');
        }
         $this->db->join('f_customer','f_customer.CUSTCODE = f_transaction_history_log.idTmoney','left');
        $this->db->where('type_request','ACKNOWLEDGMENT');
        $this->db->order_by('date','DESC');
        $this->db->stop_cache();

         //pagination
        $get = $_GET;
        unset($get['p']);
        $base_url = (!empty($get))? base_url('report/paybyqr/view_invoice?'. http_build_query($get)):base_url('report/paybyqr/view_invoice?');
        $this->load->library('pagination');
        $config['base_url'] = $base_url;
        $config['total_rows'] = $this->db->get('f_transaction_history_log')->num_rows();
        $config['per_page'] =  $this->per_page_view;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'p';
        $config['reuse_query_string']           = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination']  = $this->pagination->create_links();

        //pagination query
        $offset = isset($_GET['p'])?($_GET['p'] - 1)*$this->per_page_view:0;
        $this->db->limit($this->per_page_view,$offset);
        $this->data['paybyqr'] = $this->db->get('f_transaction_history_log')->result_array();
        
        $this->db->flush_cache();

        $sessionMenu = array(
       'parent_menu_active'  => 'report',
       'child_menu_active'  => 'report_paybyqr',
       'other_menu_active'  => 'view_paybyqr');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/report/report_paybyqr';
        $this->data['title_page'] = 'View Report Pay by QR';
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }



}
