<?php
	defined('BASEPATH') OR exit('No direct script access allowed');


	class User_lib
	{
	    protected $CI;


	    public function __construct()
	    {

	        $this->CI 						=& get_instance();

	    }


	    public function _validate_captcha_danra($captcha_key = '', $redirect_uri = '')
	    {

	    	$captcha_session 			= ($this->CI->session->userdata('danraCaptcha') != '') ? $this->CI->session->userdata('danraCaptcha') : '';


	        if (strtoupper($captcha_key) != strtoupper($captcha_session))
	        {
	            $this->CI->session->set_flashdata('errors', 'Kolom Kode keamanan (Captcha) tidak valid');
	            redirect($redirect_uri);
	        }


	        return TRUE;

	    }


	    public function get_user_transaction($owner = NULL)
	    {

	        $user_transaction 			= $this->CI->session->userdata('transaction');


	        if ($user_transaction['owner'] == $owner OR $user_transaction['owner'] == 'all')
	            return $user_transaction;
	        else
	            return NULL;

	    }


	    public function reset_user_transaction()
	    {

	        $this->CI->session->set_tempdata('transaction', NULL, 0);

	    }


	    public function set_user_transaction($inquiry_data = array(), $owner = '', $resultCode = NULL)
	    {

	        $valid_result_code 			= (! is_null($resultCode)) ? $resultCode : 0;
	        $inquiry_data['owner'] 		= $owner;


	        if ($inquiry_data['resultCode'] == $valid_result_code)
	            $this->CI->session->set_tempdata('transaction', $inquiry_data, FUSION_SESS_EXPIRED);
	        else
	            $this->CI->session->set_tempdata('transaction', NULL, FUSION_SESS_EXPIRED);

	    }


	    public function get_transaction_status($owner = NULL)
	    {

	        $transaction_status 		= $this->CI->session->userdata('final');


	        if ($transaction_status['owner'] == $owner OR $transaction_status['owner'] == 'all')
	            return $transaction_status;
	        else
	            return NULL;

	    }


	    public function reset_transaction_status()
	    {

	        $this->CI->session->set_tempdata('final', NULL, 0);

	    }


	    public function set_transaction_status($payment_data = array(), $owner = '', $resultCode = NULL)
	    {

	        $valid_result_code 			= (! is_null($resultCode)) ? $resultCode : 0;
	        $payment_data['owner'] 		= $owner;


	        if ($payment_data['resultCode'] == $valid_result_code)
	            $this->CI->session->set_tempdata('final', $payment_data, FUSION_SESS_EXPIRED);
	        else
	            $this->CI->session->set_tempdata('final', NULL, FUSION_SESS_EXPIRED);

	    }

	}