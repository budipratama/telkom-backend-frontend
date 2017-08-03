<?php
	require_once('include/SMS_Regular_API.php');
	ob_start();

	class Raja_SMS
	{
		public function send_sms($phone_number = '', $message = '')
		{
			$CI 					= get_instance();

			$callback_url 			= '';

			$send_data 				= array
								(
									'apikey' 			=> RAJA_SMS_KEY,
									'callbackurl' 		=> $callback_url,
									'datapacket'		=> array()
								);


			array_push($send_data['datapacket'],
						array
						(
							'number'			=> $phone_number,
							'message'			=> urlencode(stripslashes(utf8_encode($message))),
							'sendingdatetime'	=> date($CI->config->item('log_date_format'))
						)
					);


			$sms 					= new sms_class_reguler_json();

			$sms->setIp(RAJA_SMS_URL);
			$sms->setData($send_data);

			$json 					= $sms->send();

			header('Content-Type: application/json');

			return ($json);
		}
	}