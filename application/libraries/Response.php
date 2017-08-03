<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Response Library
 * Handle response for ajax request which is sent
 * by the CIS.Ajax.request() Javascript function
 */

class Response {


    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
    }

    function send($data = NULL, $require_ajax = FALSE)
    {
        $_output = NULL;
        $output_type = 'json';
        
        if ($require_ajax === TRUE) 
        {
            $this->CI->output->set_status_header('403');
            $this->CI->output->set_header("Content-Type: text/plain");
            $_output = 'Invalid Request Origin';
        }
        else
        {
            switch ($output_type)
            {
                case 'json':
                default:
                    $_output = json_encode($data);
                    $this->CI->output->set_header('Content-Type: application/json');
                    break;
                
                case 'xml':
                    $this->CI->load->helper('encode_xml');
                    $_output = array_to_xml($data);
                    $this->CI->output->set_header('Content-Type: application/xhtml+xml');
                    break;
                
                case 'text':
                    $_output = $data;
                    $this->CI->output->set_header('Content-Type: text/plain');
                    break;
                
                case 'html':
                    $_output = $data;
                    $this->CI->output->set_header('Content-Type: text/html');
                    break;
            }
            
            $this->CI->output->set_status_header('200');
            $this->CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
            $this->CI->output->set_header('Pragma: no-cache');
            $this->CI->output->set_header('Access-Control-Allow-Origin: ' . base_url());
            $this->CI->output->set_header('Content-Length: '. strlen($_output));
        }
        
        echo $_output;
    }
}

/* End of file Response.php */
/* Location: ./application/libraries/Response.php */