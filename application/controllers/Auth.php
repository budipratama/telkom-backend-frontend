<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    var $GSECRET = "6Ld9fCITAAAAADdccJt8po2HvXX9lC-TK7SfnXbH";
    var $recapt;
	public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        //$this->load->helper('url');
        $this->data['css_admin'] = $this->config->item('css_admin_patch');
        $this->data['js_admin'] = $this->config->item('js_admin_patch');
        $this->load->model(array('auth_model'));
        $this->load->helper('url');
        require_once('inc/recaptchalib.php');
        $this->recapt = new ReCaptcha($this->GSECRET);
    }
	public function index(){
		if($this->session->userdata('login')){
			redirect('dashboard');
		}else{
			$this->load->view('auth/login', $this->data);
		}
	}
	function checkLogin(){
        // set origin
        header('Access-Control-Allow-Origin: *');

		$username = $this->input->post('username');
		$userpass = $this->input->post('userpass');
        // echo sha1($userpass);die();
		// $reCaptcha = $this->input->post('reCaptcha');
        // $chaptchaValidate = $this->chaeckCaptcha($reCaptcha);
        if(TRUE){
        	$userLogin = $this->auth_model->compareUserPassword($username, $userpass);
        	if($userLogin){
        		$setSession = array(
                    'login' => TRUE,
                    'username' => $userLogin['USERNAME'],
                    'userId' => $userLogin['USERID'],
                    'userRealName' => $userLogin['REALNAME'],
                    'level' => $userLogin['LEVEL']
                );
        		$this->session->set_userdata($setSession);
        		$res = array('result' => TRUE);
        	}else{
        		$res = array('result' => FALSE, 'message' => 'Wrong Username or Password');
        	}
        }else{
    		$res = array('result' => FALSE, 'message' => 'Wrong Captcha');
        }
        echo json_encode($res);
	}

    function chaeckCaptcha($reCaptcha) {
        $gresp = null;
        if (isset($reCaptcha)) {
            $gresp = $this->recapt->verifyResponse(
                    $_SERVER["REMOTE_ADDR"], $reCaptcha
            );
        }
        if ($gresp != null && $gresp->success) {
            return true;
        } else {
            return false;
        }
    }
    function logout(){
		$this->session->sess_destroy();
		redirect('auth');
    }
}
