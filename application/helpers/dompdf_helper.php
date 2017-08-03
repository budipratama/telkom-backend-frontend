<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('pdf_create')) {
    function pdf_create($html,$filename='', $stream=TRUE, $attachment = true){
        require_once(APPPATH.'third_party/dompdf/autoload.inc.php');

        $dompdf = new Dompdf\Dompdf();
        $dompdf->load_html($html);
        $dompdf->setPaper('A4','potrait');
        $dompdf->render();
        if ($stream) {
            if ($attachment) {
                $dompdf->stream($filename);
            }
            else{
                $dompdf->stream($filename,array('Attachment' => 0));
            }
        }
        else{
            return $dompdf->output();
        }
    }
}
