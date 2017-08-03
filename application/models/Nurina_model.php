<?php
	defined('BASEPATH') OR exit('No direct script access allowed');


	final class Nurina_model extends CI_Model
	{

		const SMS_GATEWAY_CODE			= 'mainapi';
		const SMS_GATEWAY_ID			= 1;
		private $application_core		= 'T-MONEY';


		public function __construct()
		{
			parent::__construct();

			$this->load->database();
		}


		private function _build_otp_sms($customer_name = '', $customer_code = '', $otp = '')
		{
			$name 						= '';
			$exp_name 					= explode(' ', $customer_name);

			if(count($exp_name) == 1)
				$name					= $exp_name[0];
			else
			if(count($exp_name) == 2)
				$name					= $exp_name[0] . ' ' . $exp_name[1];
			else
				$name					= $exp_name[0] . ' ' . $exp_name[1] . ' ' . substr($exp_name[2], 0, 1);

			$message 					= 'Kode OTP untuk akun T-MONEY ' . @ splitter_vars($customer_code)
							. ' a.n. ' . ucwords(strtolower($name)) . ' : ' . @ splitter_vars($otp, 3, '-');

			return ($message);
		}


		private function _send_sms_notification($phone_number = '', $message = '', $gateway_choice = '')
		{
			$nurina						= $this->load->database('nurina', TRUE);

			$unit_value 				= 0;
			$gateway_code 				= '';
			$gateway_id 				= '';
			$return_params 				= array();

			if(substr($phone_number, 0, 3) == '+62')
				$phone_number			= '0' . substr($phone_number, 3);


			$gateway_exec 				= $nurina->select('ID, GATEWAY_CODE')
								->from(TBL_SMS_GATEWAY)
								->where('SET_AS_MAIN', 1)
								->limit(1)
							->get();

			if($gateway_exec->num_rows() == 0)
			{
				$gateway_code 			= self::SMS_GATEWAY_CODE;
				$gateway_id				= self::SMS_GATEWAY_ID;
			}
			else
			{
				$gateway_row 			= $gateway_exec->row();

				$gateway_code			= $gateway_row->GATEWAY_CODE;
				$gateway_id				= $gateway_row->ID;
			}


			$gateway_code 				= ($gateway_choice != '') ? $gateway_choice : $gateway_code;


			if($gateway_code == 'mainapi')
			{
				$unit_value 			= 295;

				$post_data				= 'msisdn=' . $phone_number . '&content=' . $message;

				$content_type			= 'Content-Type: application/x-www-form-urlencoded';
				$accept					= 'Accept: application/json';
				$authorization			= 'Authorization: Bearer ' . MAIN_API_KEY;

				$ch 					= curl_init();

				curl_setopt($ch, CURLOPT_URL, MAIN_API_URL);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array($content_type, $accept, $authorization));
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				$ch_result				= curl_exec($ch);
				$response 				= json_decode($ch_result, TRUE);

				curl_close($ch);

				if(isset($response['fault']))
					$return_params 		= array
									(
										'gateway'			=> $gateway_id,
										'resultCode'		=> $response['fault']['code'],
										'resultDesc'		=> $response['fault']['message'],
										'messageId'			=> ''
									);
				else
					$return_params 		= array
									(
										'gateway'			=> $gateway_id,
										'resultCode'		=> $response['code'],
										'resultDesc'		=> $response['message'],
										'messageId'			=> $response['msgid']
									);
			}
			else
			if($gateway_code == 'raja-sms')
			{
				$unit_value				= 120;

				$this->load->library(array('Raja_SMS'));

				$ch_result 				= $this->raja_sms->send_sms($phone_number, $message);

				$array 					= json_decode($ch_result, TRUE);

				$return_params 			= array
									(
										'gateway'			=> $gateway_id,
										'resultCode'		=> $array['sending_respon'][0]['datapacket'][0]['packet']['sendingstatus'],
										'resultDesc'		=> $array['sending_respon'][0]['datapacket'][0]['packet']['sendingstatustext'],
										'messageId'			=> $array['sending_respon'][0]['datapacket'][0]['packet']['sendingid']
									);
			}
			else
			if($gateway_code == 'zenziva')
			{
				$unit_value				= 1;

				$zenziva_url			= ZENZIVA_API_URL . '&nohp=' . $phone_number . '&pesan=' . urlencode($message);

				$ch_result 				= file_get_contents($zenziva_url);

				$xml_loader 			= simplexml_load_string($ch_result, "SimpleXMLElement", LIBXML_NOCDATA);
				$json 					= json_encode($xml_loader);
				$xml_array 				= json_decode($json, TRUE);
				# $xml_array				= unserialize(serialize(json_decode(json_encode((array) $xml_loader), 1)));

				$return_params 			= array
									(
										'gateway'			=> $gateway_id,
										'resultCode'		=> $xml_array['message']['status'],
										'resultDesc'		=> $xml_array['message']['text'],
										'messageId'			=> ''
									);
			}


			if(($gateway_code == 'mainapi' && $return_params['resultCode'] == 1) OR ($gateway_code == 'raja-sms' && $return_params['resultCode'] == 10)
				OR ($gateway_code == 'zenziva' && $return_params['resultCode'] == 0))
			{
				$sms_query 				= 'UPDATE `' . TBL_SMS_GATEWAY . '` SET `DEPOSIT_BALANCE` = `DEPOSIT_BALANCE` - ' . $unit_value
								. ' WHERE `GATEWAY_CODE` = "' . $gateway_code . '"';

				$nurina->query($sms_query);
			}


			# return TRUE;
			return ($return_params);
		}


		protected function _user_agent_recorder
		(
			$user_id = '', $ip_address = '', $os_platform = '', $user_agent = ''
		)
		{
			$nurina 					= $this->load->database('nurina', TRUE);


			$ua_query					= $nurina
								->select('USER_ID, UA_IP_ADDRESS, UA_OS_PLATFORM, UA_DEVICE_USERAGENT')
								->from(TBL_USER_AGENT)
								->where('USER_ID', $user_id)
								->where('UA_IP_ADDRESS', $ip_address)
								->where('UA_OS_PLATFORM', $os_platform)
								->where('UA_DEVICE_USERAGENT', $user_agent)
								->order_by('UA_ID', 'DESC')
								->limit(1)
							->get();


			if($ua_query->num_rows() > 0)
			{
				$ua_query->free_result();
				return FALSE;
			}

			$ua_query->free_result();


			$user_agent_data 			= array
									(
										'USER_ID'					=> $user_id,
										'UA_IP_ADDRESS'				=> $ip_address,
										'UA_OS_PLATFORM'			=> $os_platform,
										'UA_DEVICE_USERAGENT'		=> $user_agent,
										'FIRST_ACCESS_TIMESTAMP'	=> date($this->config->item('log_date_format'))
									);

			$nurina->insert(TBL_USER_AGENT, $user_agent_data);


			return TRUE;
		}


		public function activity_recorder
		(
			$activity_group = '', $activity_code = '', $user_id = '', $latitude = '', $longitude = '',
			$ip_address = '', $session_id = '', $parameters = array()
		)
		{
			$nurina 					= $this->load->database('nurina', TRUE);


			if($activity_group == 'AUTHENTICATION' && $activity_code == 'SIGN-IN')
			{
				$os_platform			= $parameters['platformUA'];
				$user_agent				= $parameters['deviceUA'];

				$this->_user_agent_recorder($user_id, $ip_address, $os_platform, $user_agent);
			}
			else
			if($activity_group == 'AUTHENTICATION' && $activity_code == 'SIGN-OUT')
			{
				$os_platform			= $parameters['platformUA'];
				$user_agent				= $parameters['deviceUA'];
			}
			else
			{
				$os_platform			= '';
				$user_agent				= '';
			}


			$activity_data 				= array
									(
										'GROUP_ID'		=> $activity_group,
										'REF_ID'		=> $activity_code,
										'SESSION_ID'	=> $session_id,
										'USER_ID'		=> $user_id,
										'LATITUDE'		=> $latitude,
										'LONGITUDE'		=> $longitude,
										'IP_ADDRESS'	=> $ip_address,
										'UA_PLATFORM'	=> $os_platform,
										'UA_DEVICE'		=> $user_agent,
										'PARAMETERS'	=> (count($parameters) > 0) ? json_encode($parameters) : '',
										'TIMESTAMP'		=> date($this->config->item('log_date_format'))
									);

			$nurina->insert(TBL_ALL_ACTIVITY, $activity_data);


			return (TRUE);
		}


		public function add_user
		(
			$user_id = '', $full_name = '', $password = '', $email_address = '', $phone_number = '',
			$status = 0, $level_id = 0, $address = ''
		)
		{
			$nurina 					= $this->load->database('nurina', TRUE);

			$user_data 					= array
									(
										'AUTH_USER_ID'		=> $user_id,
										'AUTH_FULL_NAME'	=> ucwords($full_name),
										'AUTH_PASSWORD'		=> hash('ripemd256', FUSION_SALT . $password),
										'EMAIL_ADDRESS'		=> $email_address,
										'PHONE_NUMBER'		=> $phone_number,
										'STATUS'			=> $status,
										'LEVEL_ID'			=> $level_id,
										'ADDRESS'			=> $address,
										'CREATED_ON'		=> date($this->config->item('log_date_format')),
										'CREATED_BY'		=> $this->session->userdata('user_id')
									);

			$nurina->insert(TBL_AUTHORIZATION, $user_data);


			return (TRUE);
		}


		public function get_customer($keytype = '', $keyword = '')
		{
			$data_query 				= 'SELECT CU.`CUSTCODE`, CU.`CUSTNAME`, CU.`EMAIL`, CU.`CUSTTYPEID`, CU.`CUSTADDRESS`, CU.`REGISTERDATE`, '
								. 'CU.`PASSFAILEDCOUNT`, CU.`STATUS`, CU.`ACTIVATIONCODE`, CU.`ACTIVATEDON`, CU.`CITYID`, CU.`PROVINCEID`, CU.`MERCHANTURL`, '
								. 'CI.`NAMA_KABUPATEN`, PR.`NAMA_PROVINSI` '
							. 'FROM `' . TBL_CUSTOMER . '` CU INNER JOIN `' . TBL_CITY . '` CI INNER JOIN `' . TBL_PROVINCE . '` PR '
							. 'ON CU.CITYID = CI.ID_KABUPATEN AND CI.ID_PROVINSI = PR.ID_PROVINSI '
							. 'WHERE CU.`' . $keytype
								. '` LIKE "%' . $keyword . '%" ORDER BY CU.`ID` DESC';

			$data_exec 					= $this->db->query($data_query);


			return ($data_exec);
		}


		public function get_finpay_0211($keytype = '', $keyword = '')
		{
			$data_query 				= 'SELECT `INVOICE`, `AMOUNT`, `PAYMENTCODE`, `IDTMONEY`, `IDFUSION`, `PAID`, `TERMINAL`, '
								. '`TOPUPRESPONSECODE`, `FINRESULTCODE`, `FINRESULTDESC`, `FINPAYMENTSOURCE` '
							. 'FROM `' . TBL_FINPAY . '` WHERE `' . $keytype
							. '` LIKE "%' . $keyword . '%" ORDER BY `NO` DESC';

			$data_exec 					= $this->db->query($data_query);


			return ($data_exec);
		}


		public function get_geo_ip_address($ip_address = '')
		{
			$ivana						= $this->load->database('ivana', TRUE);


			$ip_array 					= array();
			$ip_extract					= explode(',', $ip_address);

			for($r = 0; $r < count($ip_extract); $r++)
				$ip_array[$r]			= '"' . trim($ip_extract[$r]) . '"';


			$data_query 				= 'SELECT * FROM `' . TBL_IV_GEO_IP . '` WHERE `GIP_IP_ADDRESS` IN (' . implode(',', $ip_array) . ') ORDER BY `GIP_ID` ASC';

			$data_exec 					= $ivana->query($data_query);


			return ($data_exec);
		}


		public function get_phone_verification()
		{
			$ivana						= $this->load->database('ivana', TRUE);


			$data_query 				= 'SELECT `ID` AS `ID`, `CUSTOMER_CODE`, `CUSTOMER_NAME`, `PHONE_NUMBER`, `APPROVED`, `USED`, `DELIVERED`, '
								. '`OTP_CODE`, `APPROVED_BY`, `REQUEST_TIMESTAMP` , `DOC_KARPEG`, `DOC_KTP`, `APPROVED_TIMESTAMP`, '
								. '(SELECT COUNT(`VPN_ID`) FROM `' . TBL_IV_PHONE_VERIFY_RETRY . '` WHERE `VPN_ID` = `PV`.`ID`) AS `TOTAL_RETRY` '
								. 'FROM `' . TBL_IV_PHONE_VERIFY
								. '` AS `PV` WHERE `PV`.`APPROVED` IN (0, 1) AND `PV`.`USED` IN (0, 1) ORDER BY `PV`.`ID`, `PV`.`CUSTOMER_CODE` ASC';

			$data_exec 					= $ivana->query($data_query);


			return ($data_exec);
		}


		public function get_profile($profile_id = '')
		{
			$nurina 					= $this->load->database('nurina', TRUE);

			$profile_query 				= 'SELECT `AUTH_FULL_NAME`, `AUTH_USER_ID`, `EMAIL_ADDRESS`, `AUTH_PASSWORD`, `STATUS`, '
									. '`LEVEL_ID`, `PHONE_NUMBER` FROM `'
								. TBL_AUTHORIZATION . '` WHERE `AUTH_USER_ID` = "' . $profile_id . '" '
								. 'AND `STATUS` = 1 ORDER BY `AUTH_ID` DESC LIMIT 0, 1';

			$profile_exec 				= $nurina->query($profile_query);

			$profile_row 				= $profile_exec->row();
			$profile_exec->free_result();


			return ($profile_row);

		}


		public function get_reset_pin($keytype = '', $keyword = '')
		{
			$nurina 					= $this->load->database('nurina', TRUE);

			$data_query 				= 'SELECT * FROM `' . TBL_RESET_PIN . '` WHERE `' . $keytype
								. '` LIKE "%' . $keyword . '%" ORDER BY `RES_ID` DESC';

			$data_exec 					= $nurina->query($data_query);


			return ($data_exec);
		}


		public function get_sms_gateway()
		{
			$nurina 					= $this->load->database('nurina', TRUE);

			$data_query 				= 'SELECT * FROM `' . TBL_SMS_GATEWAY . '` ORDER BY `ID`';

			$data_exec 					= $nurina->query($data_query);


			return ($data_exec);
		}


		public function get_sms_gateway_sendtest()
		{
			$nurina 					= $this->load->database('nurina', TRUE);

			$data_query 				= 'SELECT * FROM `' . TBL_SMS_GATEWAY_SENDTEST . '` ORDER BY `SND_ID` DESC';

			$data_exec 					= $nurina->query($data_query);


			return ($data_exec);
		}


		public function get_summary_dashboard()
		{
			$current_month 				= date('Y-m-');


			$read_counter 				= read_file('./barrel/counter.txt');
			$explode_counter			= explode(';', $read_counter);


	        $array_result 				= array
		        				(
		        					'visitor'		=> array('all' => floatval($explode_counter[1]), 'monthly' => floatval($explode_counter[2]))
		        				);


	        return ($array_result);
		}


		public function get_transaction($keytype = '', $keyword = '')
		{
			if($keytype == 'CUSTCODE')
				$data_query 			= 'SELECT `SYSLOGNO`, `REFNO`, `TRXCODE`, `CUSTCODE`, `TRXVALUE`, `TRFCHARGES`, `LASTSTATE`, '
								. '`LASTRC`, `LASTRCFIN`, `RCVTIME`, `MERCHCODE`, `SUBMERCH`, `PRODCODE`, `INVOICENO`, `INVOICENAME`, '
								. '`DSAC`, `SRAC` FROM `' . TBL_TRANSACTION . '` WHERE '
									. '`SRAC` IN (SELECT `CONTACTPHONE` FROM `' . TBL_CUSTOMER . '` WHERE `CUSTCODE` = "' . $keyword . '") OR '
									. '`DSAC` IN (SELECT `CONTACTPHONE` FROM `' . TBL_CUSTOMER . '` WHERE `CUSTCODE` = "' . $keyword . '") '
								. 'ORDER BY `ID` DESC';
			else
				$data_query 			= 'SELECT `SYSLOGNO`, `REFNO`, `TRXCODE`, `CUSTCODE`, `TRXVALUE`, `TRFCHARGES`, `LASTSTATE`, '
								. '`LASTRC`, `LASTRCFIN`, `RCVTIME`, `MERCHCODE`, `SUBMERCH`, `PRODCODE`, `INVOICENO`, '
								. '`INVOICENAME`, `DSAC` '
							. 'FROM `' . TBL_TRANSACTION . '` WHERE `' . $keytype
							. '` LIKE "%' . $keyword . '%" ORDER BY `ID` DESC';

			$data_exec 					= $this->db->query($data_query);


			return ($data_exec);
		}


		public function get_transaction_last_day()
		{
			$current_date 				= date('Y-m-d');

			$data_query 				= 'SELECT `SYSLOGNO`, `REFNO`, `TRXCODE`, `CUSTCODE`, `TRXVALUE`, `TRFCHARGES`, `LASTSTATE`, '
								. '`LASTRC`, `LASTRCFIN`, `RCVTIME`, `MERCHCODE`, `SUBMERCH`, `PRODCODE`, `INVOICENO`, '
								. '`INVOICENAME`, `SRAC`, `DSAC` '
							. 'FROM `' . TBL_TRANSACTION . '` WHERE `RCVTIME` LIKE "%' . $current_date . '%" ORDER BY `ID` DESC';

			$data_exec 					= $this->db->query($data_query);


			return ($data_exec);
		}


		public function get_user()
		{
			$nurina 					= $this->load->database('nurina', TRUE);

			$data_query 				= 'SELECT AUTH.*, LEVEL.`LEVEL_NAME` FROM `' . TBL_AUTHORIZATION . '` AUTH INNER JOIN `'
						. TBL_AUTHORIZATION_LEVEL . '` LEVEL ON AUTH.`LEVEL_ID` = LEVEL.`LEVEL_ID` '
							. 'ORDER BY AUTH.`AUTH_ID`';

			$data_exec 					= $nurina->query($data_query);


			return ($data_exec);
		}


		public function get_user_account_activity($id_tmoney = '', $start_date = '', $stop_date = '')
		{
			$ivana						= $this->load->database('ivana', TRUE);

			$data_query 				= 'SELECT * FROM `' . TBL_IV_ALL_ACTIVITY . '` WHERE `CUSTOMER_CODE` = "' . $id_tmoney
							. '" AND `TIMESTAMP` BETWEEN "' . $start_date . '" AND "' . $stop_date . '" GROUP BY `SESSION_ID` ORDER BY `TIMESTAMP` ASC';

			$data_exec 					= $ivana->query($data_query);


			return ($data_exec);
		}


		public function otp_phone_verification($id_tmoney = '', $phone_number = '', $data_karpeg = '', $data_ktp = '')
		{
			$ivana						= $this->load->database('ivana', TRUE);


			$data_query 				= 'SELECT `ID`, `CUSTOMER_CODE`, `PHONE_NUMBER`, `APPROVED`, `USED`, `REQUEST_TIMESTAMP` FROM `' . TBL_IV_PHONE_VERIFY
								. '` WHERE `APPROVED` = 0 AND `USED` = 0 AND `CUSTOMER_CODE` = "' . $id_tmoney . '" AND `PHONE_NUMBER` = "' . $phone_number
								. '" ORDER BY `ID`, `CUSTOMER_CODE` ASC';

			$data_exec 					= $ivana->query($data_query);


			if($data_exec->num_rows() == 0)
			{
				$data_exec->free_result();
				return array('resultCode' => 'OTP-001', 'resultDesc' => 'Maaf data permohonan verifikasi Nomor HP tersebut tidak valid');
			}


			$data_row 					= $data_exec->row();
			$data_exec->free_result();


			$post_data['terminal'] 		= FUSION_TERMINAL;
			$post_data['idTmoney'] 		= $data_row->CUSTOMER_CODE;
			$post_data['phoneNumber']	= $data_row->PHONE_NUMBER;
			$post_data['token'] 		= FUSION_UNIQUE_TOKEN;


			$url 						= FUSION_API . 'customer-support/phone-verification';

			$response 					= '0'; # json_decode(curl_post($url, $post_data), TRUE);


			if($response == '0') # ->resultCode
			{
				$data_update 			= array
									(
										'APPROVED'				=> 1,
										'DELIVERED'				=> 1,
										'DOC_KARPEG'			=> $data_karpeg,
										'DOC_KTP'				=> $data_ktp,
										'APPROVED_BY'			=> $this->session->tempdata('user_id'),
										'APPROVED_TIMESTAMP'	=> date($this->config->item('log_date_format'))
									);

				$ivana->where('ID', $data_row->ID);
				$ivana->where('CUSTOMER_CODE', $data_row->CUSTOMER_CODE);
				$ivana->where('PHONE_NUMBER', $data_row->PHONE_NUMBER);
				$ivana->where('APPROVED', 0);
				$ivana->where('USED', 0);

				$ivana->update(TBL_IV_PHONE_VERIFY, $data_update);
			}


			return array('resultCode' => '0', 'resultDesc' => 'Sukses dan di-approve oleh sistem');
			# return array('resultCode' => $response->resultCode, 'resultDesc' => $response->resultDesc);
		}


		public function reset_pin_inquiry($id_tmoney = '')
		{
			$result						= array();
			$customer_query				= 'SELECT `CUSTCODE`, `EMAIL`, `CUSTNAME`, `CUSTTYPEID` FROM `' . TBL_CUSTOMER
								. '` WHERE (`EMAIL` = "' . $id_tmoney . '" OR `CUSTCODE` = "' . $id_tmoney . '") ORDER BY `ID` LIMIT 0, 1';

			$customer_exec 				= $this->db->query($customer_query);


			if($customer_exec->num_rows() == 0)
			{
				$customer_exec->free_result();

				$result 				= array
									(
										'resultCode'		=> 'RPI-001',
										'resultDesc'		=> 'Akun tersebut tidak terdaftar di dalam sistem T-MONEY'
									);
				return ($result);
			}


			$customer_row 				= $customer_exec->row();
			$customer_exec->free_result();


			$result						= array
									(
										'resultCode'		=> '0',
										'resultDesc'		=> 'Sukses dan di-approve oleh sistem',
										'idTmoney'			=> $customer_row->CUSTCODE,
										'email'				=> $customer_row->EMAIL,
										'customerName'		=> $customer_row->CUSTNAME,
										'customerType'		=> $customer_row->CUSTTYPEID
									);
			return ($result);
		}


	    public function reset_pin_confirmation($id_tmoney = '', $user_id = '', $data_karpeg = '', $data_ktp = '', $otp = '')
	    {
			$nurina 						= $this->load->database('nurina', TRUE);


	        $post_data['terminal'] 			= FUSION_TERMINAL;
	        $post_data['idTmoney'] 			= $id_tmoney;
	        $post_data['token'] 			= FUSION_UNIQUE_TOKEN;


	        $url 							= FUSION_API . 'customer-support/reset-pin';

	        $response 						= json_decode(curl_post($url, $post_data), TRUE);


	        $pin_data 						= array
	        							(
	        								'RESULT_CODE'		=> $response['resultCode'],
	        								'CUSTOMER_CODE'		=> isset($response['idTmoney']) ? $response['idTmoney'] : '',
	        								'CUSTOMER_NAME'		=> isset($response['customerName']) ? $response['customerName'] : '',
	        								'CUSTOMER_EMAIL'	=> isset($response['email']) ? $response['email'] : '',
	        								'DOC_KARPEG'		=> $data_karpeg,
	        								'DOC_KTP'			=> $data_ktp,
	        								'USER_ID'			=> $user_id,
	        								'TIMESTAMP'			=> date($this->config->item('log_date_format'))
	        							);

	        $nurina->insert(TBL_RESET_PIN, $pin_data);


	        if ($response['resultCode'] == 0)
	        {
	            $this->user_lib->reset_user_transaction();
	        }

	        return $response;
	    }


	    public function send_otp_phone_verification($record_id = '')
	    {
	    	$ivana	 						= $this->load->database('ivana', TRUE);


	    	/* $record_exec 					= $ivana->select('CUSTOMER_CODE, CUSTOMER_NAME, PHONE_NUMBER, OTP_CODE')
	    							->from(TBL_IV_PHONE_VERIFY)
	    							->where('ID', $record_id)
	    							->limit(1)
	    						->get(); */

			$record_query 					= 'SELECT `ID` AS `ID`, `CUSTOMER_CODE`, `CUSTOMER_NAME`, `PHONE_NUMBER`, `OTP_CODE`, '
								. '(SELECT COUNT(`VPN_ID`) FROM `' . TBL_IV_PHONE_VERIFY_RETRY . '` WHERE `VPN_ID` = `PV`.`ID`) AS `TOTAL_RETRY` '
								. 'FROM `' . TBL_IV_PHONE_VERIFY
								. '` AS `PV` WHERE `PV`.`ID` = "' . $record_id . '" ORDER BY `PV`.`ID` LIMIT 0, 1';

			$record_exec 					= $ivana->query($record_query);


	    	if($record_exec->num_rows() == 0)
	    	{
	    		$record_exec->free_result();
	    		return array('resultCode' => 'OTP-002', 'resultDesc' => 'Record tersebut tidak ditemukan di sistem kami');
	    	}

	    	$record_row 					= $record_exec->row();
	    	$record_exec->free_result();

	    	if($record_row->TOTAL_RETRY >= 3)
	    		return array('resultCode' => 'OTP-003', 'resultDesc' => 'Anda tidak dapat mengirimkan ulang OTP karena telah mencapai limit pengiriman maksimum (3 kali)');


	    	$ivana->where('ID', $record_id);
	    	$ivana->update(TBL_IV_PHONE_VERIFY, array('DELIVERED' => 1));


	    	$sms_content 					= $this->_build_otp_sms($record_row->CUSTOMER_NAME, $record_row->CUSTOMER_CODE, $record_row->OTP_CODE);
	    	$send_otp 						= $this->_send_sms_notification($record_row->PHONE_NUMBER, $sms_content);


	    	$data_insert					= array
	    								(
	    									'VPN_ID'			=> $record_id,
	    									'SMS_GATEWAY'		=> $send_otp['gateway'],
	    									'SMS_CONTENT'		=> $sms_content,
	    									'SMS_ID'			=> $send_otp['messageId'],
	    									'RESULT_CODE'		=> $send_otp['resultCode'],
	    									'RETRY_BY'			=> $this->session->tempdata('user_id'),
	    									'RETRY_TIMESTAMP'	=> date($this->config->item('log_date_format'))
	    								);

	    	$ivana->insert(TBL_IV_PHONE_VERIFY_RETRY, $data_insert);


	    	return array('resultCode' => '0', 'resultDesc' => 'Sukses dan di-approve oleh sistem');
	    }


	    public function sendtest_sms_gateway($gateway_id = '', $phone_number = '', $user_id = '')
	    {
	    	$nurina	 						= $this->load->database('nurina', TRUE);


	    	$message 						= 'Test pengiriman SMS menggunakan SMS Gateway : ' . strtoupper($gateway_id);

	    	$send_status					= $this->_send_sms_notification($phone_number, $message, $gateway_id);


	    	$insert_data 					= array
	    								(
	    									'GATEWAY_CODE'			=> $gateway_id,
	    									'PHONE_NUMBER'			=> $phone_number,
	    									'MESSAGE_ID'			=> $send_status['messageId'],
	    									'RESULT_CODE'			=> $send_status['resultCode'],
	    									'DELIVERED_BY'			=> $user_id,
	    									'DELIVERED_TIMESTAMP'	=> date($this->config->item('log_date_format'))
	    								);

	    	$nurina->insert(TBL_SMS_GATEWAY_SENDTEST, $insert_data);


	    	return ($send_status);
	    }


	    public function set_sms_gateway($gateway_id = '')
	    {
	    	$nurina	 						= $this->load->database('nurina', TRUE);


	    	$gateway_exec 					= $nurina->select('ID')
	    							->from(TBL_SMS_GATEWAY)
	    							->where('GATEWAY_CODE', $gateway_id)
	    							->limit(1)
	    						->get();

	    	if($gateway_exec->num_rows() == 0)
	    	{
	    		$gateway_exec->free_result();
	    		return array('resultCode' => 'SGW-001', 'resultDesc' => 'Record tersebut tidak ditemukan di sistem kami');
	    	}

	    	$gateway_row 					= $gateway_exec->row();
	    	$gateway_exec->free_result();

	    	$nurina->query('UPDATE `' . TBL_SMS_GATEWAY . '` SET `SET_AS_MAIN` = 1 WHERE `GATEWAY_CODE` = "' . $gateway_id . '"');
	    	$nurina->query('UPDATE `' . TBL_SMS_GATEWAY . '` SET `SET_AS_MAIN` = 0 WHERE `GATEWAY_CODE` <> "' . $gateway_id . '"');


	    	return array('resultCode' => '0', 'resultDesc' => 'Sukses dan di-approve oleh sistem');
	    }


	    public function set_user_status($user_id = '', $choice = 0)
	    {
	    	$nurina	 						= $this->load->database('nurina', TRUE);


	    	$user_exec 						= $nurina->select('AUTH_ID')
	    							->from(TBL_AUTHORIZATION)
	    							->where('AUTH_USER_ID', $user_id)
	    							->limit(1)
	    						->get();

	    	if($user_exec->num_rows() == 0)
	    	{
	    		$gateway_exec->free_result();
	    		return array('resultCode' => 'SUS-001', 'resultDesc' => 'Record tersebut tidak ditemukan di sistem kami');
	    	}

	    	$user_row 						= $user_exec->row();
	    	$user_exec->free_result();

	    	$nurina->query('UPDATE `' . TBL_AUTHORIZATION . '` SET `STATUS` = ' . $choice . ' WHERE `AUTH_USER_ID` = "' . $user_id . '"');


	    	return array('resultCode' => '0', 'resultDesc' => 'Sukses dan di-approve oleh sistem');
	    }

	}