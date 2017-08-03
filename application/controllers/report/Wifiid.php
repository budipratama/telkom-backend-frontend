<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wifiid extends MY_Controller {

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
    public function resend(){

        //filter search
         $this->db->start_cache();
        if ($this->input->get('s')) {
            $keyword = $this->db->escape('%'. $this->input->get('s'). '%');
            $this->db->where("( `f_customer`.EMAIL LIKE $keyword ", null, FALSE);
            $this->db->or_where("invoiceId LIKE $keyword ", null, FALSE);
            $this->db->or_where("`f_customer`.CUSTCODE LIKE $keyword )", null, FALSE);
        }
         //filter range tanggal
        if($this->input->get('RCVTIME')){
            $tanggal = explode('-', $this->input->get('range'));
            $tanggal_awal = date('Y-m-d 00:00:00',strtotime($tanggal[0]));
            $tanggal_akhir = date('Y-m-d 23:59:59',strtotime($tanggal[1]));
            $this->db->where('date BETWEEN "'.$tanggal_awal.'" AND "'.$tanggal_akhir.'"');
        }
        $this->db->join('f_transaction_history_log','f_transaction_history_log.refNo = f_trx_logheader.REFNO','LEFT');
        $this->db->join('f_customer','f_customer.CUSTCODE = f_trx_logheader.CUSTCODE','left');
        $this->db->where('PRODCODE','WIFIID');
        $this->db->order_by('f_trx_logheader.ID','DESC');
        $this->db->stop_cache();

         //pagination
        $get = $_GET;
        unset($get['p']);
        $base_url = (!empty($get))? base_url('report/wifiid/resend?'. http_build_query($get)):base_url('report/wifiid/resend?');
        $this->load->library('pagination');
        $config['base_url'] = $base_url;
        $config['total_rows'] = $this->db->get('f_trx_logheader')->num_rows();
        $config['per_page'] =  $this->per_page_view;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'p';
        $config['reuse_query_string']           = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination']  = $this->pagination->create_links();

        //pagination query
        $offset = isset($_GET['p'])?($_GET['p'] - 1)*$this->per_page_view:0;
        $this->db->limit($this->per_page_view,$offset);
        $this->data['wifiid'] = $this->db->get('f_trx_logheader')->result_array();
        
        $this->db->flush_cache();

        $sessionMenu = array(
       'parent_menu_active'  => 'report',
       'child_menu_active'  => 'report_wifiid',
       'other_menu_active'  => 'resend_wifiid');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/report/report_wifiid';
        $this->data['title_page'] = 'View Report Wifiid';
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }

    public function resend_email($id){
        //get data
        $this->db->where('f_trx_logheader.SYSLOGNO',$id);
        $this->db->join('f_transaction_history_log','f_transaction_history_log.refNo = f_trx_logheader.REFNO','LEFT');
        $this->db->join('f_customer','f_customer.CUSTCODE = f_trx_logheader.CUSTCODE','left');
        $this->db->where('PRODCODE','WIFIID');
        $data = $this->db->get('f_trx_logheader')->row_array();
        //send email
        if (empty($data)) {
            $this->session->set_flashdata('msg', 'E-mail gagal dikirim');
            redirect('report/wifiid/resend');
        }

        $message = $this->load->view('admin/pages/report/email_wifiid',$data,TRUE);
        $mail_to = 'ihvanmultimedia@gmail.com';//$data['EMAIL'];
        $mail_subject = 'Wifi.id';

        $this->load->library('email');
        $this->email->initialize(
                        array
                        (
                            'useragent'         => 'T-MONEY',
                            'protocol'          => 'smtp',
                            'smtp_host'         => 'smtp.sendgrid.net',
                            'smtp_user'         => 'cstmoney', # 'ekopermonojati',
                            'smtp_pass'         => 'keong001', # 'M2l2ng11',
                            'smtp_port'         => 587,
                            'mailtype'          => 'html',
                            'charset'           => 'utf-8',
                            'crlf'              => "\r\n",
                            'newline'           => "\r\n"
                        )
                    );
        $this->email->from('service@tmoney.co.id','T-MONEY - Smart way to pay');
        $this->email->to($mail_to);
        $this->email->subject($mail_subject);
        $this->email->message($message);

        $this->email->send();
        $this->session->set_flashdata('msg', 'E-mail berhasil dikirim');
        redirect('report/wifiid/resend');
    }

}
