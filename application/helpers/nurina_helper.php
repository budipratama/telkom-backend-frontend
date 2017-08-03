<?php
	defined('BASEPATH') OR exit('No direct script access allowed');


	/**
	 * captcha_generator()
	 *
	 * Create captcha from the CodeIgniter captcha helper
	 * Avoid from bots & make it safer
	 *
	 * @param
	 *
	 * @return		array $captcha
	 */
	if(! function_exists('captcha_generator'))
	{

		function captcha_generator()
		{

			$CI 			= get_instance();


			$CI->session->unset_userdata('danraCaptcha');

			$params 		= array
						(
							# 'word'          => 'Random word',
							'img_path'      => './captcha/',
							'img_url'       => base_url() . 'captcha/',
							# 'font_path'     => './path/to/fonts/texb.ttf',
							'img_width'     => 120,
							'img_height'    => 46,
							'expiration'    => 5,
							'word_length'   => 4,
							'font_size'     => 25,
							'img_id'        => 'captcha-danra',
							'pool'          => '0123456789', # abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ

							'colors'        => array(
										'background' 	=> array(255, 255, 255),
										'border' 		=> array(240, 240, 240),
										'text' 			=> array(0, 0, 0),
										'grid' 			=> array(255, 228, 228)
									)
						);

			$captcha 		= create_captcha($params);

			$CI->session->set_userdata('danraCaptcha', (($captcha['word'] != '') ? trim($captcha['word']) : 'DANRA'));


			return ($captcha);

		}

	}


	/**
	 * cleaner_vars()
	 *
	 * Clean the parameters from HTML, JS and CSS tag scripts
	 * Avoid from hijacking & make it safer
	 *
	 * @param		string $input
	 * @return		string $output
	 */
	if(! function_exists('cleaner_vars'))
	{

		function cleaner_vars($input = '')
		{

			$search 			= array
						(
							'@<script[^>]*?>.*?</script>@si', 	# Strip out any Javascript codes
							'@<[\/\!]*?[^<>]*?>@si', 			# Strip out any HTML tag codes
							'@<style[^>]*?>.*?</style>@siU', 	# Strip out any CSS tag codes
							'@<![\s\S]*?--[ \t\n\r]*>@'
						);

			$output 			= preg_replace($search, '', $input);
			return ($output);

		}

	}


	/**
	 * curl_post()
	 *
	 * Hit the remote url using cURL with POST method
	 * Return value will be set from the remote url
	 *
	 * @param		string $url
	 * @param		array $post_data
	 * @return		string
	 */
	if(! function_exists('curl_post'))
	{

		function curl_post($url = '', $post_data = '', $SSL_VERIFYPEER = TRUE, $debug = FALSE)
		{

			$curl_handle 		= curl_init();

	        curl_setopt($curl_handle, CURLOPT_URL, $url);
	        # curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, $SSL_VERIFYPEER);
	        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($curl_handle, CURLOPT_POST, 1);
	        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($curl_handle, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');

	        $response 			= curl_exec($curl_handle);


	        if ($debug)
	        {
	        	var_dump(curl_errno($curl_handle));
	        	var_dump($response);

	        	exit();
	        }


	        curl_close($curl_handle);

	        return $response;

		}

	}


	/**
	 * formatter_currency()
	 *
	 * Change the number of money format
	 *
	 * @param		int $value
	 * @return		string
	 */
	if(! function_exists('formatter_currency'))
	{

		function formatter_currency($value = 0)
		{

			return ('IDR ' . number_format($value, 0, ',', '.') . ',-');

		}

	}


	/**
	 * formatter_date()
	 *
	 * Formatting the date from [YYYY-MM-DD/DD-MM-YYYY] HH:II:SS
	 * into Indonesian medium date format (example : 20-02-2016 10:15:20)
	 *
	 * @param		string $input
	 *
	 * @return		string $output
	 */
	if(! function_exists('formatter_date'))
	{

		function formatter_date($input = '', $long = TRUE)
		{

			$chunks				= @ explode(' ', $input);
			$chunk_date			= @ explode('-', $chunks[0]);


			$day 				= (strlen($chunk_date[0]) == 2) ? $chunk_date[0] : $chunk_date[2];
			$month 				= $chunk_date[1];
			$year 				= (strlen($chunk_date[2]) == 4) ? $chunk_date[2] : $chunk_date[0];


			switch ($month)
			{
				case '01' :	$month = 'Jan';		break;
				case '02' :	$month = 'Feb';		break;
				case '03' :	$month = 'Mar';		break;
				case '04' :	$month = 'Apr';		break;
				case '05' :	$month = 'Mei';		break;
				case '06' :	$month = 'Jun';		break;
				case '07' :	$month = 'Jul';		break;
				case '08' :	$month = 'Agu';		break;
				case '09' :	$month = 'Sep';		break;
				case '10' :	$month = 'Okt';		break;
				case '11' :	$month = 'Nov';		break;
				case '12' :	$month = 'Des';		break;
			}


			return ($day . ' ' . $month . ' ' . $year . (($long == TRUE) ? ' - ' . $chunks[1] : ''));

		}

	}


	/**
	 * generate_session_id()
	 *
	 * Generate Unique SESSION ID for each User ID's sign in
	 *
	 * @param		string $user_id
	 * @param		string $time_stamp
	 *
	 * @return		string $output
	 */
	if(! function_exists('generate_session_id'))
	{

		function generate_session_id($user_id = '', $time_stamp = '')
		{

			$plain_data 		= $user_id . $time_stamp . mt_rand(0, 1000000);
			$cipher_data 		= hash('ripemd160', $plain_data);

			return ($cipher_data);

		}

	}


	/**
	 * get_client_ip_addr()
	 *
	 * Getting the IP Address of the client who hit this FUSION API
	 *
	 * @param
	 *
	 * @return		string $output
	 */
	if(! function_exists('get_client_ip_addr'))
	{

		function get_client_ip_addr()
		{

			if (isset($_SERVER))
			{

				if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
					return $_SERVER['HTTP_X_FORWARDED_FOR'];

				if (isset($_SERVER['HTTP_CLIENT_IP']))
					return $_SERVER['HTTP_CLIENT_IP'];


				return $_SERVER['REMOTE_ADDR'];

			}


			if (getenv('HTTP_X_FORWARDED_FOR'))
				return getenv('HTTP_X_FORWARDED_FOR');

			if (getenv('HTTP_CLIENT_IP'))
				return getenv('HTTP_CLIENT_IP');


			return getenv('REMOTE_ADDR');

		}

	}


	/**
	 * password_checker()
	 *
	 * Check the security level of password
	 * Avoid from insecure password and make it safer from hacking
	 *
	 * @param		string $input
	 * @return		boolean $result
	 */
	if(! function_exists('password_checker'))
	{

		function password_checker($input = '')
		{

			if (preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $input))
				$result			= TRUE;
			else
				$result			= FALSE;

			return ($result);

		}

	}


	/**
	 * sanitizer_vars()
	 *
	 * Sanitize each parameters executed in this application
	 * Avoid from hijacking & make it safer
	 *
	 * @param		string $input
	 * @return		string $output
	 */
	if(! function_exists('sanitizer_vars'))
	{

		function sanitizer_vars($input = '')
		{

		    if (is_array($input))
		    {

		        foreach($input as $var => $val)
		            $output[$var] 	= sanitizer_vars($val);

		    }
		    else
		    {

		        if (get_magic_quotes_gpc())
		            $output 		= @ stripslashes($input);
		        else
		        	$output 		= $input;


		       	$output  			= trim($output);
		        $output  			= cleaner_vars($output);
		        # $output 			= mysql_real_escape_string($output);

		    }

		    return ($output);

		}

	}


	/**
	 * splitter_vars()
	 *
	 * Splitting and combining string with our specified delimiter
	 * Default delimiter is "-" and length is 4
	 *
	 * @param		string $input $delimiter
	 * @param		int $length
	 *
	 * @return		string $output
	 */
	if(! function_exists('splitter_vars'))
	{

		function splitter_vars($input = '', $length = 4, $delimiter = ' ')
		{

			$split 				= str_split($input, $length);
			$output 			= implode($delimiter, $split);


			return ($output);

		}

	}
