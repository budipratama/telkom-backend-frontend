<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finpay extends MY_Controller {

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
    public function view_finpay(){
          //filter search
         $this->db->start_cache();
        if ($this->input->get('s')) {
            $keyword = $this->db->escape('%'. $this->input->get('s'). '%');
            $this->db->where("(`f_customer`.EMAIL LIKE $keyword ", null, FALSE);
            $this->db->or_where("`f_payment_code`.PAYMENTCODE LIKE $keyword )", null, FALSE);
        }
         //filter range tanggal
        if($this->input->get('range')){
            $tanggal = explode('-', $this->input->get('range'));
            $tanggal_awal = date('Y-m-d 00:00:00',strtotime($tanggal[0]));
            $tanggal_akhir = date('Y-m-d 23:59:59',strtotime($tanggal[1]));
            $this->db->where('TIMESTAMP BETWEEN "'.$tanggal_awal.'" AND "'.$tanggal_akhir.'"');
        }
        $this->db->join('f_customer','f_customer.CUSTCODE = f_payment_code.IDTMONEY','INNER');
        $this->db->order_by('TIMESTAMP','DESC');
        $this->db->stop_cache();

         //pagination
        $get = $_GET;
        unset($get['p']);
        $base_url = (!empty($get))? base_url('report/finpay/view_invoice?'. http_build_query($get)):base_url('report/finpay/view_invoice?');
        $this->load->library('pagination');
        $config['base_url'] = $base_url;
        $config['total_rows'] = $this->db->get('f_payment_code')->num_rows();
        $config['per_page'] =  $this->per_page_view;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'p';
        $config['reuse_query_string']           = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination']  = $this->pagination->create_links();

        //pagination query
        $offset = isset($_GET['p'])?($_GET['p'] - 1)*$this->per_page_view:0;
        $this->db->limit($this->per_page_view,$offset);
        $this->data['finpay'] = $this->db->get('f_payment_code')->result_array();
        
        $this->db->flush_cache();
        
        $sessionMenu = array(
       'parent_menu_active'  => 'report',
       'child_menu_active'  => 'report_finpay',
       'other_menu_active'  => 'view_report_finpay');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/report/report_finpay';
        $this->data['title_page'] = 'View Report Finpay';
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }

     public function topup(){
         //filter search
        if ($this->input->get()) {
            $this->db->start_cache();
            $keyword = $this->db->escape('%'. $this->input->get('s'). '%');
            $this->db->where("(`f_customer`.EMAIL LIKE $keyword ", null, FALSE);
            $this->db->or_where("`f_payment_code`.PAYMENTCODE LIKE $keyword )", null, FALSE);
            if ( $this->input->get('range')) {
                $tanggal = explode('-', $this->input->get('range'));
                $tanggal_awal = date('Y-m-d 00:00:00',strtotime($tanggal[0]));
                $tanggal_akhir = date('Y-m-d 23:59:59',strtotime($tanggal[1]));
                $this->db->where('TIMESTAMP BETWEEN "'.$tanggal_awal.'" AND "'.$tanggal_akhir.'"');
            }
            $this->db->join('f_customer','f_customer.CUSTCODE = f_payment_code.IDTMONEY','INNER');
            $this->db->order_by('TIMESTAMP','DESC');
            $this->db->where('PAID',1);
            $this->db->where('TOPUPRESPONSECODE !=','0');
            $this->db->where('TOPUPRESPONSECODE !=',NULL);
            $this->db->stop_cache();

             //pagination
            $get = $_GET;
            unset($get['p']);
            $base_url = (!empty($get))? base_url('report/finpay/topup?'. http_build_query($get)):base_url('report/finpay/topup?');
            $this->load->library('pagination');
            $config['base_url'] = $base_url;
            $config['total_rows'] = $this->db->get('f_payment_code')->num_rows();
            $config['per_page'] =  $this->per_page_view;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'p';
            $config['reuse_query_string']           = TRUE;
            $this->pagination->initialize($config);
            $this->data['pagination']  = $this->pagination->create_links();
            

            //pagination query
            $offset = isset($_GET['p'])?($_GET['p'] - 1)*$this->per_page_view:0;
            $this->db->limit($this->per_page_view,$offset);
            $this->data['finpay'] = $this->db->get('f_payment_code')->result_array();
        }else{
            $this->data['finpay'] = array();
            $this->data['pagination'] = '';
        }
        
        
        
        $this->db->flush_cache();

        $sessionMenu = array(
       'parent_menu_active'  => 'report',
       'child_menu_active'  => 'report_finpay',
       'other_menu_active'  => 'topup_finpay');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/report/topup_finpay';
        $this->data['title_page'] = 'Topup Finpay';
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }

    public function topup_process(){
        if ($this->input->post('payment_code')) {
            $payment_code = (int) $this->input->post('payment_code');

            //check payment code paid status
            $payment_code_data =  $this->db->where('PAID',1)->where('PAYMENTCODE',$payment_code)->where('TOPUPRESPONSECODE !=','0')->get('f_payment_code')->row_array();
            if (empty($payment_code_data))redirect('report/finpay/topup');

            //get respon log
            $log = $this->db->like('RESPON',$payment_code)->get('f_payment_code_respon_log')->row_array();

            //cek log status
            if (!empty($log)) {
                //send post data
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, 'https://prodapi.tmoney.co.id/api/finpay-response');
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS,$log['RESPON']);
                $response = curl_exec($curl_handle);
                curl_close($curl_handle);

                //send message
                $this->session->set_flashdata('msg', 'Berhasil di topup ulang');
                redirect('report/finpay/topup');
            }else{
                //send message
                $this->session->set_flashdata('msg', 'Gagal topup ulang, Ada kesalahan data.');
                redirect('report/finpay/topup');
            }
        }
    }

    public function export(){
         //filter search
         $this->db->start_cache();
        if ($this->input->get('s')) {
            $keyword = $this->db->escape('%'. $this->input->get('s'). '%');
            $this->db->where("`f_customer`.EMAIL LIKE $keyword ", null, FALSE);
        }
         //filter range tanggal
        if($this->input->get('range')){
            $tanggal = explode('-', $this->input->get('range'));
            $tanggal_awal = date('Y-m-d 00:00:00',strtotime($tanggal[0]));
            $tanggal_akhir = date('Y-m-d 23:59:59',strtotime($tanggal[1]));
            $this->db->where('TIMESTAMP BETWEEN "'.$tanggal_awal.'" AND "'.$tanggal_akhir.'"');
        }
        $this->db->join('f_customer','f_customer.CUSTCODE = f_payment_code.IDTMONEY','INNER');
        $this->db->limit(10000);
        $this->db->stop_cache();
       $this->data['finpay'] = $this->db->get('f_payment_code')->result_array();

        //START EXCEL
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Laporan Finpay');

        //HEADER\
        $header = array('Invoice', 'Amount','Payment Code', 'ID tmoney', 'Email' , 'ID Fusion', 'PAID' , 'TOPUP RESPONSECODE','FINRESULTCODE','FINRESULTDESC','FINPAYMENTSOURCE','DATE');
        $col = "A";
        

        foreach ($header as $head) {
            $this->excel->getActiveSheet()->setCellValue($col. '1' , $head);
            $this->excel->getActiveSheet()->getStyle($col. '1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
            $col++;
        }

        $row = 2;
        foreach ($this->data['finpay'] as $data) {
            $this->excel->getActiveSheet()->setCellValue('A'.$row , $data['INVOICE']);
            $this->excel->getActiveSheet()->setCellValue('B'.$row , 'Rp. ' . number_format( $data['AMOUNT'], 0 , '.' , '.' ));
            $this->excel->getActiveSheet()->setCellValue('C'.$row , $data['PAYMENTCODE']);
            $this->excel->getActiveSheet()->setCellValue('D'.$row , $data['IDTMONEY']);
            $this->excel->getActiveSheet()->setCellValue('E'.$row , $data['EMAIL']);
            $this->excel->getActiveSheet()->setCellValue('F'.$row , $data['IDFUSION']);
            $this->excel->getActiveSheet()->setCellValue('G'.$row , $data['PAID']);
            $this->excel->getActiveSheet()->setCellValue('H'.$row , $data['TOPUPRESPONSECODE']);
            $this->excel->getActiveSheet()->setCellValue('I'.$row , $data['FINRESULTCODE']);
            $this->excel->getActiveSheet()->setCellValue('J'.$row , $data['FINRESULTDESC']);
            $this->excel->getActiveSheet()->setCellValue('K'.$row , $data['FINPAYMENTSOURCE']);
            $this->excel->getActiveSheet()->setCellValue('L'.$row , $data['TIMESTAMP']);

            $this->excel->getActiveSheet()->setCellValueExplicit('C'.$row, $data['PAYMENTCODE'], PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('D'.$row, $data['IDTMONEY'], PHPExcel_Cell_DataType::TYPE_STRING);
            $row++;
        }

        $filename='Laporan Finpay (' . date('d-m-Y , G.i'). ').xls'; //save our workbook as this file name
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

}
