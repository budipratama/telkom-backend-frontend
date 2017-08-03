<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {
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
    public function view_report(){
        $sessionMenu = array(
       'parent_menu_active'  => 'report',
       'child_menu_active'  => 'view_report');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/report/report_form';
        $this->data['title_page'] = 'View Report';
        $trxRefCodeData = $this->admin_model->get_all_data('f_fee_refcode');
        $this->data['refCodeActive'] = "2";
        $this->data['trxRefCodeData'] = $trxRefCodeData;
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }
    function get_report(){
        $this->checkPostData();
        $trxCode = $this->input->post('trxCode');
        $reservation = $this->input->post('reservation');
        $additional['tahapan'] = $this->input->post('tahapan');

        $dateRange = explode(" - ", $reservation);
        $dateFrom = date("Y-m-d 00:00:00", strtotime($dateRange[0]));
        $dateTo = date("Y-m-d 23:59:59", strtotime($dateRange[1]));
        $reportData['data'] = $this->admin_model->getReportRange($trxCode, $dateFrom, $dateTo, $additional);
        // var_dump($this->db->last_query());
        $reportData['export_query'] = base64_encode($this->db->last_query());
        echo json_encode($reportData);
    }

    public function export_to_pdf(){
        if( $export_query = base64_decode($this->input->get('data',TRUE),TRUE) ){
            $data['reports'] = $reports = $this->db->query($export_query)->result_array();
            // var_dump($data['reports']);exit();

            // filename
            $title = isset($reports[0]['TRXCODE']) ? $reports[0]['TRXCODE'] : '';
            $data['filename'] = $filename ='Laporan '.$title.' (' . date('d-m-Y , H:i:s'). ')'; //save our workbook as this file name

            // create pdf
            $this->load->helper('dompdf');
            $pdf_template = $this->load->view('admin/pages/report/report_pdf_template', $data, TRUE);
            pdf_create($pdf_template,$filename);
        }
        else{
            show_error('Invalid data');
        }
    }

    public function export_to_excel(){
        if( $export_query = base64_decode($this->input->get('data',TRUE),TRUE) ){
            $reports = $this->db->query($export_query)->result_array();

            // create excel
            $title = isset($reports[0]['TRXCODE']) ? $reports[0]['TRXCODE'] : '';
            $filename ='Laporan '.$title.' (' . date('d-m-Y , H:i:s'). ').xls'; //save our workbook as this file name
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle($title);
            // header
            $header = array('No', 'Receive Time', 'Invoice Number', 'Ref Code', 'Trx Value', 'Tahapan', 'Status');
            $col = "A";
            foreach ($header as $head) {
                $this->excel->getActiveSheet()->setCellValue($col. '1' , $head);
                $this->excel->getActiveSheet()->getStyle($col. '1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
                $col++;
            }
            // value
            $no = 1; $row = 2;
            foreach ($reports as $report) {
                $tahapan = '';
                $stat = '';

                if($report['LASTSTATE'] == 1){
                    $tahapan = "Incomplete";
                }else{
                    $tahapan = "Complete";
                }

                if($report['LASTRC'] == 0){
                    $stat = "Success";
                }else{
                    $stat = "Failed";
                }

                $this->excel->getActiveSheet()->setCellValue('A'.$row , $no);
                $this->excel->getActiveSheet()->setCellValue('B'.$row , $report['RCVTIME']);
                $this->excel->getActiveSheet()->setCellValue('C'.$row , $report['INVOICENO']);
                $this->excel->getActiveSheet()->setCellValueExplicit('D'.$row , $report['REFNO'], PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValue('E'.$row , $report['TRXVALUE']);
                $this->excel->getActiveSheet()->setCellValue('F'.$row , $tahapan);
                $this->excel->getActiveSheet()->setCellValue('G'.$row , $stat);
                // $this->excel->getActiveSheet()->setCellValue('F'.$row , $report['TRFCHARGES']);
                $no++; $row++;
            }
            // total
            $this->excel->getActiveSheet()->setCellValue('A'.$row , 'Total');
            $this->excel->getActiveSheet()->mergeCells('A'.$row . ':D' .$row);
            $this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->setCellValue('E'.$row ,'=SUM(E2:E'. ($row - 1) .')');
            $this->excel->getActiveSheet()->getStyle('E'.$row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->setCellValue('F'.$row ,'=SUM(F2:F'. ($row - 1) .')');
            $this->excel->getActiveSheet()->getStyle('F'.$row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G'.$row)->getFont()->setBold(true);
            // Output
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_end_clean();
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        }
        else{
            show_error('Invalid data');
        }
    }
    public function search_report(){
        $sessionMenu = array(
       'parent_menu_active'  => 'report',
       'child_menu_active'  => 'search_report');
        $this->session->set_flashdata($sessionMenu);
        $this->data['content_page'] = 'admin/pages/report/report_search';
        $this->data['title_page'] = 'Search Report';
        $this->data['menuListData'] = $this->menuSidebar();
        $this->load->view('admin/layout', $this->data);
    }

    public function get_search_report(){
        $this->checkPostData();
        $search_based = $this->input->post('search_based');
        $search_term = $this->input->post('search_term');

        $reportData['data'] = $this->admin_model->getReportSearch($search_based, $search_term);
        // var_dump($this->db->last_query());exit();
        $reportData['export_query'] = base64_encode($this->db->last_query());
        echo json_encode($reportData);
    }
}
