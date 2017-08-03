<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Byqr extends MY_Controller {

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
        $base_url = (!empty($get))? base_url('report/byqr/view_invoice?'. http_build_query($get)):base_url('report/byqr/view_invoice?');
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

    public function export(){
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
         $this->data['paybyqr'] = $this->db->get('f_transaction_history_log')->result_array();

        //START EXCEL
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Laporan Pay by QR');

        //HEADER\
        $header = array('TransId', 'Cust Code','Cust Name', 'Cust Email', 'Paid Amount' , 'Merchant Name', 'InvoiceId' , 'Date');
        $col = "A";

        

        foreach ($header as $head) {
            $this->excel->getActiveSheet()->setCellValue($col. '1' , $head);
            $this->excel->getActiveSheet()->getStyle($col. '1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
            $col++;
        }

        

        $row = 2;
        foreach ($this->data['paybyqr'] as $data) {
            $this->excel->getActiveSheet()->setCellValue('A'.$row , $data['trans_id']);
            $this->excel->getActiveSheet()->setCellValue('B'.$row , $data['CUSTCODE']);
            $this->excel->getActiveSheet()->setCellValue('C'.$row , $data['CUSTNAME']);
            $this->excel->getActiveSheet()->setCellValue('D'.$row , $data['EMAIL']);
            $this->excel->getActiveSheet()->setCellValue('E'.$row , $data['paidAmount']);
            $this->excel->getActiveSheet()->setCellValue('F'.$row , $data['merchantName']);
            $this->excel->getActiveSheet()->setCellValue('G'.$row , $data['invoiceId']);
            $this->excel->getActiveSheet()->setCellValue('H'.$row , $data['date']);

            $this->excel->getActiveSheet()->setCellValueExplicit('B'.$row, $data['CUSTCODE'], PHPExcel_Cell_DataType::TYPE_STRING);
            $row++;
        }

        $filename='Laporan Pay by QR (' . date('d-m-Y , G.i'). ').xls'; //save our workbook as this file name
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
