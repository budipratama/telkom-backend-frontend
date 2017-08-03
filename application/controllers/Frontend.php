<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Frontend extends CI_Controller
	{

		protected $_uri 		= array
					(
						'reset-pin'		=> array
									(
										'default' 		=> 'frontend/authorize/reset-pin-inquiry',
										'confirmation' 	=> 'frontend/authorize/reset-pin-confirmation',
										'final' 		=> 'frontend/authorize/reset-pin-status'
									)
					);


		public function __construct()
		{

			parent::__construct();

			$this->load->helpers(array());
			$this->load->library(array('form_validation', 'user_lib'));
			$this->load->model(array('Nurina_model' => 'nurina'));

			$this->load->database();

			$this->load->library('grocery_CRUD');

		}


		private function auth_access()
		{
			#penambahan dari kondisi dari budi untuk session $this->session->tempdata('level') !='Administrator'
			if($this->session->tempdata('logged_in') == TRUE && $this->session->tempdata('user_id') != '' && $this->session->tempdata('level') !='Administrator')
			{

				if($this->session->tempdata('lock_screen') == TRUE)
					@ redirect('frontend/lock-screen');

			}
			else

				@ redirect('frontend/sign-in');

		}


		private function counter_access()
		{

			if($this->session->userdata('counterAccess') == '' OR $this->session->userdata('counterAccess') == NULL)
			{

				$curr_month		= date('Y-m');
				$file 			= './barrel/counter.txt';
				$read 			= read_file($file);

				$explode 		= explode(';', $read);

				if(trim($curr_month) != trim($explode[0]))
					$inc_month	= 1;
				else
					$inc_month	= floatval($explode[2]) + 1;

				$inc_all 		= floatval($explode[1]) + 1;

				write_file($file, (string) $curr_month . ';' . $inc_all . ';' . $inc_month);
				$this->session->set_userdata('counterAccess', 1);

			}

		}


		public function index()
		{

			$this->counter_access();


			if($this->session->userdata('logged_in') == '')
				@ redirect('frontend/sign-in');
			else
				@ redirect('frontend/dashboard');

		}


		public function _currency_format($value = 0, $row = '')
		{
			return ('IDR ' . number_format($value, 0, ',', '.') . ',-');
		}


		public function _timestamp_format($value = '', $row = '')
		{
			$explode_day 		= explode($value, ' ');
			$explode_date 		= explode($explode_day[0], '/');

			# return ($explode_date[]);
		}


	    public function _convert_DSAC($value = '', $row = '')
		{
			if ($row->DSAC == '+6219567399747')
				return 'ESPAY';
			elseif ($row->DSAC == '622179187250')
				return 'METRANET';
			elseif ($row->DSAC == '6219566854003')
				return 'T-MONEY Biller';
			else
				return 'USER';
		}

		public function debug($string)
		{
			echo "<pre>";
			print_r($string);
			echo "</pre>";
		}
		public function authorize_reset_pin_inquiry()
		{

			# $this->auth_access();


			# if($this->session->userdata('accessResetPin') == 0)
			#	redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('id_tmoney', 'Akun T-MONEY Tujuan', 'required');


			if ($this->form_validation->run() == FALSE)
			{
				$this->debug(base_barrel());
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-reset-pin';
				$data['template']			= (string) FUSION_DEFAULT_THEME . '/';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Reset PIN',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$id_tmoney 					= @ sanitizer_vars($this->input->post('id_tmoney'));


				$inquiry_data 				= $this->nurina->reset_pin_inquiry($id_tmoney);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'RESET-PIN', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'step'			=> 'CHECKING',
								'resultCode'	=> $inquiry_data['resultCode'],
								'userId'		=> $this->session->userdata('user_id'),
								'idTmoney'		=> $inquiry_data['idTmoney'],
								'customerName'	=> $inquiry_data['customerName'],
								'email'			=> $inquiry_data['email']
							)
						);


				$this->user_lib->set_user_transaction($inquiry_data, $this->_uri['reset-pin']['default']);


				if(isset($inquiry_data['resultCode']) && $inquiry_data['resultCode'] == '0')
					@ redirect($this->_uri['reset-pin']['confirmation']);
				else
				if(isset($inquiry_data['resultCode']) && $inquiry_data['resultCode'] != '0')
					$this->session->set_flashdata('errors', $inquiry_data['resultDesc']);
				else
					$this->session->set_flashdata('errors', 'Terjadi kesalahan pada sistem T-MONEY, silakan menunggu beberapa saat');


				@ redirect($this->_uri['reset-pin']['default']);

			}

		}


		public function authorize_reset_pin_confirmation()
		{

			$this->auth_access();


			if($this->session->userdata('accessResetPin') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();


	    	$this->form_validation->set_rules('id_tmoney', 'Akun T-MONEY Tujuan', 'required');
	    	# $this->form_validation->set_rules('otp_code', 'Kode OTP', 'required|numeric|min_length[6]|max_length[6]');


			if ($this->form_validation->run() == FALSE)
			{

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-reset-pin-confirmation';
				$data['template']			= (string) FUSION_DEFAULT_THEME . '/';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Reset PIN',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);

				$data['transaction']		= $this->user_lib->get_user_transaction($this->_uri['reset-pin']['default']);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$id_tmoney 					= @ sanitizer_vars($this->input->post('id_tmoney'));
				# $otp 						= @ sanitizer_vars($this->session->tempdata('otp_code'));


				$configs['upload_path']  			= './uploads/';
				$configs['allowed_types']   		= 'gif|jpg|jpeg|png|tiff|svg';
				$configs['max_size']        		= 20480;
				$configs['max_width']      			= 0; # 1024
				$configs['max_height']     			= 0; # 768
				$configs['max_filename_increment']  = 100;
				$configs['file_ext_tolower']		= TRUE;
				$configs['overwrite']				= FALSE;
				$configs['encrypt_name']   			= TRUE;

				$this->load->library('upload', $configs);

				if (! $this->upload->do_upload('docKarpeg'))
				{
					$this->session->set_flashdata('errors', 'Upload dokumen Kartu Pegawai gagal diproses, silakan mencoba beberapa saat lagi');
					@ redirect($this->_uri['reset-pin']['default']);
				}
				else
					$data_karpeg 			= $this->upload->data('file_name');

				if (! $this->upload->do_upload('docKTP'))
				{
					$this->session->set_flashdata('errors', 'Upload dokumen KTP gagal diproses, silakan mencoba beberapa saat lagi');
					@ redirect($this->_uri['reset-pin']['default']);
				}
				else
					$data_ktp 				= $this->upload->data('file_name');


				$payment_data 				= $this->nurina->reset_pin_confirmation($id_tmoney, $this->session->userdata('user_id'), $data_karpeg, $data_ktp, $otp = '');


				$this->nurina->activity_recorder(
						'ACTIVITY', 'RESET-PIN', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'step'			=> 'CONFIRMATION',
								'resultCode'	=> $payment_data['resultCode'],
								'userId'		=> $this->session->userdata('user_id'),
								'idTmoney'		=> $payment_data['idTmoney'],
								'customerName'	=> $payment_data['customerName'],
								'email'			=> $payment_data['email']
							)
						);


				if(isset($payment_data['resultCode']) && $payment_data['resultCode'] == '0')
				{
					$this->user_lib->set_transaction_status($payment_data, $this->_uri['reset-pin']['default']);
					@ redirect($this->_uri['reset-pin']['final']);
				}
				else
				if(isset($payment_data['resultCode']) && $payment_data['resultCode'] != '0')
					$this->session->set_flashdata('errors', $payment_data['resultDesc']);
				else
					$this->session->set_flashdata('errors', 'Terjadi kesalahan pada sistem T-MONEY, silakan menunggu beberapa saat');


				@ redirect($this->_uri['reset-pin']['default']);

			}

		}


		public function authorize_reset_pin_status()
		{

			$this->auth_access();


			if($this->session->userdata('accessResetPin') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-reset-pin-status';
			$data['template']				= (string) FUSION_DEFAULT_THEME . '/';
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Reset PIN',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);

			$data['transaction']			= $this->user_lib->get_transaction_status($this->_uri['reset-pin']['default']);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function dashboard()
		{

			$this->auth_access();


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-dashboard';
			$data['summary_dashboard']		= $this->nurina->get_summary_dashboard();
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Selamat Datang',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function data_customer()
		{

			$this->auth_access();


			if($this->session->userdata('accessGetCustomer') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('keytype', 'Tipe Referensi', 'required');
	    	$this->form_validation->set_rules('keyword', 'Kata Kunci', 'required');


			if ($this->form_validation->run() == FALSE)
			{

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-customer-standard';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$keytype 					= @ sanitizer_vars($this->input->post('keytype'));
				$keyword 					= @ sanitizer_vars($this->input->post('keyword'));


				$inquiry_data 				= $this->nurina->get_customer($keytype, $keyword);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'GET-DATA-CUSTOMER', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'keytype'		=> $keytype,
								'keyword'		=> $keyword,
								'recordCount'	=> $inquiry_data->num_rows()
							)
						);


				$data['query']				= $inquiry_data;
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-customer-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}

		}


		public function data_customer_crud()
		{

			$this->auth_access();


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-data-customer-standard';
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'GET-DATA-CUSTOMER', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id')
						)
					);


			$crud 							= new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('f_customer');
			$crud->set_primary_key('ID_KABUPATEN', 'f_kabkota');

			$crud->set_relation('CITYID', 'f_kabkota', 'NAMA_KABUPATEN');
			$crud->columns('CUSTCODE', 'CUSTNAME', 'EMAIL', 'CUSTTYPEID', 'CUSTADDRESS', 'REGISTERDATE', 'PASSFAILEDCOUNT',
							'STATUS', 'ACTIVATIONCODE', 'ACTIVATEDON', 'CITYID', 'MERCHANTURL');
			$crud->display_as('CUSTCODE', 'ID AKUN')
						->display_as('CUSTNAME', 'NAMA')
						->display_as('EMAIL', 'EMAIL')
						->display_as('PASSFAILEDCOUNT', 'BLOCKED')
						->display_as('CUSTTYPEID', 'TIPE AKUN')
						->display_as('CUSTADDRESS', 'ADDRESS')
						->display_as('REGISTERDATE', 'TGL REGISTER')
						->display_as('STATUS', 'STATUS')
						->display_as('ACTIVATIONCODE', 'KODE AKTIVASI')
						->display_as('ACTIVATEDON', 'TGL AKTIVASI')
						->display_as('CITYID', 'CITYID')
						->display_as('MERCHANTURL', 'URL MERCHANT');
			$crud->set_subject('Customer T-MONEY');
			# $crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			# $crud->where('RCVTIME','active');
			$crud->order_by('ID', 'desc');

			$crud->unset_add()
					->unset_edit()
					->unset_delete()
					->unset_read();

			$data['output'] 				= $crud->render();

			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function data_finpay_0211()
		{

			$this->auth_access();


			if($this->session->userdata('accessGetFinpay') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('keytype', 'Tipe Referensi', 'required');
	    	$this->form_validation->set_rules('keyword', 'Kata Kunci', 'required');


			if ($this->form_validation->run() == FALSE)
			{

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-finpay-standard';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$keytype 					= @ sanitizer_vars($this->input->post('keytype'));
				$keyword 					= @ sanitizer_vars($this->input->post('keyword'));


				$inquiry_data 				= $this->nurina->get_finpay_0211($keytype, $keyword);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'GET-DATA-FINPAY-0211', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'keytype'		=> $keytype,
								'keyword'		=> $keyword,
								'recordCount'	=> $inquiry_data->num_rows()
							)
						);


				$data['query']				= $inquiry_data;
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-finpay-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}

		}


		public function data_finpay_0211_crud()
		{

			$this->auth_access();


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-data-finpay-standard';
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Finpay 0211',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'GET-DATA-FINPAY-0211', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id')
						)
					);


			$crud 							= new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('f_payment_code');
			$crud->columns('INVOICE', 'AMOUNT', 'PAYMENTCODE', 'IDTMONEY', 'IDFUSION', 'PAID', 'TERMINAL', 'TOPUPRESPONSECODE',
							'FINRESULTCODE', 'FINRESULTDESC', 'FINPAYMENTSOURCE');

			$crud->set_subject('Payment Code');

			$crud->order_by('NO', 'desc');

			$crud->unset_add()
					->unset_edit()
					->unset_delete()
					->unset_read();

			$data['output'] 				= $crud->render();

			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function data_reset_pin()
		{

			$this->auth_access();


			if($this->session->userdata('accessGetResetPin') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('keytype', 'Tipe Referensi', 'required');
	    	$this->form_validation->set_rules('keyword', 'Kata Kunci', 'required');


			if ($this->form_validation->run() == FALSE)
			{

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-reset-pin-standard';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$keytype 					= @ sanitizer_vars($this->input->post('keytype'));
				$keyword 					= @ sanitizer_vars($this->input->post('keyword'));


				$reset_pin_data 			= $this->nurina->get_reset_pin($keytype, $keyword);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'GET-DATA-RESET-PIN', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'recordCount'	=> $reset_pin_data->num_rows()
							)
						);


				$data['query']				= $reset_pin_data;

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-reset-pin-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data User',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}

		}


		public function data_transaction()
		{

			$this->auth_access();


			if($this->session->userdata('accessGetTransaction') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('keytype', 'Tipe Referensi', 'required');
	    	$this->form_validation->set_rules('keyword', 'Kata Kunci', 'required');


			if ($this->form_validation->run() == FALSE)
			{

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-transaction-standard';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$keytype 					= @ sanitizer_vars($this->input->post('keytype'));
				$keyword 					= @ sanitizer_vars($this->input->post('keyword'));


				$inquiry_data 				= $this->nurina->get_transaction($keytype, $keyword);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'GET-DATA-TRANSACTION', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'keytype'		=> $keytype,
								'keyword'		=> $keyword,
								'recordCount'	=> $inquiry_data->num_rows()
							)
						);


				$data['query']				= $inquiry_data;
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-transaction-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}

		}


		public function data_transaction_crud()
		{

			$this->auth_access();


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-data-transaction-standard';
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Transaksi',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'GET-DATA-TRANSACTION', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id')
						)
					);


			$crud 							= new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('f_trx_logheader');
			$crud->set_primary_key('CUSTCODE', 'f_customer');

			# $crud->set_relation('CUSTCODE','f_customer','{CUSTCODE} - {CUSTNAME} - {EMAIL} ');

			$crud->columns('SYSLOGNO', 'REFNO', 'TRXCODE', 'CUSTCODE', 'TRXVALUE', 'TRFCHARGES', 'LASTSTATE',
							'LASTRC', 'LASTRCFIN', 'RCVTIME', 'MERCHCODE', 'SUBMERCH', 'PRODCODE', 'INVOICENO',
							'INVOICENAME', 'DSAC');
			$crud->display_as('SYSLOGNO', 'ID TRANSAKSI')
						->display_as('REFNO', 'NO REFERENSI')
						->display_as('TRXCODE', 'TIPE TRANSAKSI')

						# ->display_as('CUSTCODE', 'ID AKUN - NAMA - EMAIL')
						->display_as('CUSTCODE', 'CUSTCODE')
						->display_as('TRXVALUE', 'NOMINAL')
						->display_as('TRFCHARGES', 'FEE')
						->display_as('LASTSTATE', 'TAHAPAN')
						->display_as('LASTRC', 'RC FUSION')
						->display_as('LASTRCFIN', 'RC PARTNER')
						->display_as('RCVTIME', 'WAKTU')
						->display_as('MERCHCODE', 'MERCHCODE')
						->display_as('SUBMERCH', 'SUBMERCH')
						->display_as('PRODCODE', 'PRODCODE')
						->display_as('INVOICENO', 'INVOICENO')
						->display_as('INVOICENAME', 'INVOICENAME');

			$crud->set_subject('Transaksi T-MONEY');
			# $crud->set_relation('salesRepEmployeeNumber','employees','lastName');
			$crud->callback_column('TRXVALUE', array($this, '_currency_format'));
			$crud->callback_column('TRFCHARGES', array($this, '_currency_format'));
			$crud->callback_column('DSAC', array($this,'_convert_DSAC'));
			# $crud->where('RCVTIME','active');
			$crud->order_by('ID', 'desc');

			$crud->unset_add()
					->unset_edit()
					->unset_delete()
					->unset_read();

			$data['output'] 				= $crud->render();

			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function data_transaction_last_day()
		{

			$this->auth_access();


			if($this->session->userdata('accessGetTransaction') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-data-transaction-last-day';
			$data['last_day']				= $this->nurina->get_transaction_last_day();
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Transaksi',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'GET-LAST-DAY-TRANSACTION', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id'),
							'recordCount'	=> $data['last_day']->num_rows()
						)
					);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function data_user()
		{

			$this->auth_access();


			if($this->session->userdata('accessGetUser') == 0)
				redirect('frontend/forbidden-access');

			if($this->uri->segment(4) != 'activate' && $this->uri->segment(4) != 'deactivate') :
				$inquiry_data 				= $this->nurina->get_user();


				$this->nurina->activity_recorder(
						'ACTIVITY', 'GET-DATA-USER', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'recordCount'	=> $inquiry_data->num_rows()
							)
						);


				$data['query']				= $inquiry_data;

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-user-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data User',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);
			else :
				$choice 					= @ sanitizer_vars(($this->uri->segment(4) == 'activate') ? 1 : 0);
				$user_id 					= @ sanitizer_vars($this->uri->segment(5));

				$change_status	 			= $this->nurina->set_user_status($user_id, $choice);


				if(isset($change_status['resultCode']) && $change_status['resultCode'] == '0')
					$this->session->set_flashdata('success', $change_status['resultDesc']);
				else
				if(isset($change_status['resultCode']) && $change_status['resultCode'] != '0')
					$this->session->set_flashdata('errors', $change_status['resultDesc']);
				else
					$this->session->set_flashdata('errors', 'Terjadi kesalahan pada proses perubahan status User, silakan menunggu beberapa saat');


				redirect('frontend/reporting/user');
			endif;

		}


		public function data_user_add()
		{

			$this->auth_access();


			if($this->session->userdata('accessGetUser') == 0)
				redirect('frontend/forbidden-access');


          	$nurina 						= $this->load->database('nurina', TRUE);


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('user_id', 'ID User', 'required|min_length[5]|max_length[100]');
	    	$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|min_length[5]|max_length[100]');
	    	$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[100]');
	    	$this->form_validation->set_rules('status', 'Status', 'required|numeric');
	    	$this->form_validation->set_rules('level_id', 'Level User', 'required|numeric');
	    	$this->form_validation->set_rules('phone_number', 'Nomor HP', 'required|numeric|min_length[8]|max_length[15]');
	    	$this->form_validation->set_rules('email_address', 'Alamat Email', 'required|valid_email');


			if ($this->form_validation->run() == FALSE)
			{
                $level_query 				= 'SELECT * FROM `' . TBL_AUTHORIZATION_LEVEL . '` WHERE `STATUS` = 1';

                $data['query']				= $nurina->query($level_query);
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-user-add';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data User',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$user_id 					= @ sanitizer_vars($this->input->post('user_id'));
				$full_name 					= @ sanitizer_vars($this->input->post('full_name'));
				$password 					= @ sanitizer_vars($this->input->post('password'));
				$email_address 				= @ sanitizer_vars($this->input->post('email_address'));
				$phone_number 				= @ sanitizer_vars($this->input->post('phone_number'));
				$status 					= @ sanitizer_vars($this->input->post('status'));
				$level_id 					= @ sanitizer_vars($this->input->post('level_id'));
				$address 					= @ sanitizer_vars($this->input->post('address'));


				$add_data 					= $this->nurina->add_user($user_id, $full_name, $password, $email_address, $phone_number, $status, $level_id, $address);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'ADD-DATA-USER', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'newUserId'		=> $user_id,
								'newFullName'	=> $full_name,
								'newEmail'		=> $email_address,
								'newPhone'		=> $phone_number,
								'newLevelId'	=> $level_id
							)
						);


				redirect('frontend/reporting/user');

				/* $user_data 					= $this->nurina->get_user();

				$data['query']				= $user_data;
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-data-user-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Customer',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data); */

			}

		}


		public function error_404()
		{

			$data['params']			= @ base_barrel();
			$data['content']		= 'v-frontend-404';
			$data['headers']		= array
								(
									'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Error 404',
									'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
										. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
									'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
									'author'	=> FUSION_AUTHOR_NAME,
									'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
								);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-404', $data);

		}


		public function forbidden_access()
		{

			$data['params']			= @ base_barrel();
			$data['content']		= 'v-frontend-forbidden-access';
			$data['headers']		= array
								(
									'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Error 404',
									'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
										. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
									'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
									'author'	=> FUSION_AUTHOR_NAME,
									'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
								);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function generate_captcha()
		{

			$captcha 				= @ captcha_generator();

			$data['captcha'] 		= $captcha;

			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-captcha-index', $data);

		}


		public function geo_ip_address()
		{

			$this->auth_access();


			if($this->session->userdata('accessGeoIp') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('ip_address', 'Alamat IP', 'required');


			if ($this->form_validation->run() == FALSE)
			{

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-geo-ip';
				$data['template']			= (string) FUSION_DEFAULT_THEME . '/';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'IP Geo Location',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$ip_address					= @ sanitizer_vars($this->input->post('ip_address'));


				$ip_data 					= $this->nurina->get_geo_ip_address($ip_address);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'GEO-IP-ADDRESS', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'ipAddress'		=> $ip_address
							)
						);


				$data['query']				= $ip_data;
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-geo-ip-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'IP Geo Location',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}

		}


		public function lock_screen()
		{

			$this->session->set_tempdata('lock_screen', TRUE, FUSION_SESS_EXPIRED);


			$this->nurina->activity_recorder(
					'AUTHENTICATION', 'LOCK-SCREEN', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id')
						)
					);


			$data['captcha']		= @ captcha_generator();

			$data['params']			= @ base_barrel();
			$data['content']		= 'v-lock-screen';
			$data['headers']		= array
								(
									'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Kunci Layar',
									'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
										. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
									'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
									'author'	=> FUSION_AUTHOR_NAME,
									'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
								);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-lockscreen', $data);

		}


		public function login()
		{

			$data['captcha']		= @ captcha_generator();

			$data['params']			= @ base_barrel();
			$data['content']		= 'v-login-form';
			$data['headers']		= array
								(
									'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Login',
									'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
										. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
									'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
									'author'	=> FUSION_AUTHOR_NAME,
									'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
								);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-login', $data);

		}


		public function my_profile()
		{

			$this->auth_access();


			$this->nurina->activity_recorder(
					'ACTIVITY', 'MY-PROFILE', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id')
						)
					);


	    	$this->form_validation->set_rules('Username', 'Username', 'trim|required|min_length[3]|max_length[50]|alpha_numeric');
	    	$this->form_validation->set_rules('UserID', 'User ID', 'trim|required|min_length[1]|max_length[50]|numeric');
	    	$this->form_validation->set_rules('FullName', 'Nama Lengkap', 'trim|required|min_length[3]|max_length[50]');
	    	$this->form_validation->set_rules('Phone', 'Nomor Telepon', 'trim|required|min_length[5]|max_length[50]');
	    	$this->form_validation->set_rules('Email', 'Alamat Email', 'trim|required|min_length[5]|max_length[50]|valid_email');
	    	$this->form_validation->set_rules('profileSubmit', 'Tombol Submit', 'trim|required|alpha');

			if($this->input->post('Password') != '' && $this->input->post('RePassword') != '')
			{
				$this->form_validation->set_rules('Password', 'Password Baru', 'required|min_length[8]|max_length[100]');
				$this->form_validation->set_rules('RePassword', 'Password Konfirmasi', 'required|matches[Password]');
			}

			if($this->input->post('AboutMe') != '')
				$this->form_validation->set_rules('AboutMe', 'Tentang Saya', 'trim|min_length[3]');


			if ($this->form_validation->run() == TRUE) # FALSE

				# $this->session->set_flashdata('profile_update', 'Profil anda GAGAL diubah - Silakan logout dan login kembali untuk melihat perubahan');

			# else
			{

				$user_name					= @ sanitizer_vars($this->input->post('Username'));
				$user_id 					= @ sanitizer_vars($this->input->post('UserID'));
				$full_name					= @ sanitizer_vars($this->input->post('FullName'));
				$phone_no					= @ sanitizer_vars($this->input->post('Phone'));
				$email_addr					= @ sanitizer_vars($this->input->post('Email'));
				$password 					= @ sanitizer_vars($this->input->post('Password'));
				$about_me					= @ sanitizer_vars($this->input->post('AboutMe'));


				$update 					= array
										(
											'EM_NAME'			=> strtoupper($full_name),
											'EM_EMAIL'			=> strtolower($email_addr),
											'EM_PHONE_NUMBER'	=> trim($phone_no)
										);


				if($password != '' && $password != NULL)
					$update['EM_PASSWORD']	= hash('ripemd256', FUSION_SALT . $password);

				if($about_me != '' && $about_me != NULL)
					$update['EM_ABOUT_ME']	= trim($about_me);


				$this->db->where('EM_ID', $user_id);
				$this->db->where('EM_USERID', $user_name);

				$this->db->update(TBL_EMPLOYEE, $update);


				$this->session->set_flashdata('profile_update', 'Profil anda telah SUKSES diubah - Silakan logout dan login kembali untuk melihat perubahan');

			}


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-profile';
			$data['profile']				= $this->nurina->get_profile(trim($this->session->tempdata('user_id')));
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Profil Saya',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);

			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function phone_send_otp()
		{

			$this->auth_access();


			if($this->session->userdata('accessPhoneVerify') == 0)
				redirect('frontend/forbidden-access');

			$record_id						= @ sanitizer_vars($this->uri->segment(4));
			$otp_send						= $this->nurina->send_otp_phone_verification($record_id);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'OTP-SEND-PHONE-VERIFICATION', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id'),
							'recId'			=> $record_id
						)
					);


			if(isset($otp_send['resultCode']) && $otp_send['resultCode'] == '0')
				$this->session->set_flashdata('success', $otp_send['resultDesc']);
			else
			if(isset($otp_send['resultCode']) && $otp_send['resultCode'] != '0')
				$this->session->set_flashdata('errors', $otp_send['resultDesc']);
			else
				$this->session->set_flashdata('errors', 'Terjadi kesalahan pada proses kirim ulang OTP, silakan menunggu beberapa saat');


			redirect('frontend/authorize/phone-verify-check');

		}


		public function phone_verification_check()
		{

			$this->auth_access();


			if($this->session->userdata('accessPhoneVerify') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();
			$data['content']				= 'v-frontend-phone-verify-check';
			$data['phone_verify']			= $this->nurina->get_phone_verification();
			$data['headers']				= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Data Verifikasi Nomor HP',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'GET-DATA-PHONE-VERIFICATION', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id'),
							'recordCount'	=> $data['phone_verify']->num_rows()
						)
					);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function phone_verification_otp()
		{

			$this->auth_access();


			if($this->session->userdata('accessPhoneVerify') == 0)
				redirect('frontend/forbidden-access');


			$id_tmoney 						= @ sanitizer_vars($this->input->post('customerCode'));
			$phone_number 					= @ sanitizer_vars($this->input->post('phoneNumber'));

			if($id_tmoney == '' OR $phone_number == '')
				redirect('frontend/authorize/phone-verify-check');


			$configs['upload_path']  			= './uploads/';
			$configs['allowed_types']   		= 'gif|jpg|jpeg|png|tiff|svg';
			$configs['max_size']        		= 20480;
			$configs['max_width']      			= 0; # 1024
			$configs['max_height']     			= 0; # 768
			$configs['max_filename_increment']  = 100;
			$configs['file_ext_tolower']		= TRUE;
			$configs['overwrite']				= FALSE;
			$configs['encrypt_name']   			= TRUE;

			$this->load->library('upload', $configs);

			if (! $this->upload->do_upload('docKarpeg'))
			{
				$this->session->set_flashdata('errors', 'Upload dokumen Kartu Pegawai gagal diproses, silakan mencoba beberapa saat lagi');
				redirect('frontend/authorize/phone-verify-check');
			}
			else
				$data_karpeg 				= $this->upload->data('file_name');

			if (! $this->upload->do_upload('docKTP'))
			{
				$this->session->set_flashdata('errors', 'Upload dokumen KTP gagal diproses, silakan mencoba beberapa saat lagi');
				redirect('frontend/authorize/phone-verify-check');
			}
			else
				$data_ktp 					= $this->upload->data('file_name');


			$phone_verify					= $this->nurina->otp_phone_verification($id_tmoney, $phone_number, $data_karpeg, $data_ktp);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'OTP-DATA-PHONE-VERIFICATION', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> $phone_verify['resultCode'],
							'userId'		=> $this->session->userdata('user_id'),
							'customerCode'	=> $id_tmoney,
							'phoneNumber'	=> $phone_number
						)
					);


			if(isset($phone_verify['resultCode']) && $phone_verify['resultCode'] == '0')
				$this->session->set_flashdata('success', $phone_verify['resultDesc']);
			else
			if(isset($phone_verify['resultCode']) && $phone_verify['resultCode'] != '0')
				$this->session->set_flashdata('errors', $phone_verify['resultDesc']);
			else
				$this->session->set_flashdata('errors', 'Terjadi kesalahan pada proses approval Nomor HP, silakan menunggu beberapa saat');


			redirect('frontend/authorize/phone-verify-check');

		}


		public function sms_gateway()
		{

			$this->auth_access();


			if($this->session->userdata('accessSMSGateway') == 0)
				redirect('frontend/forbidden-access');


			if($this->uri->segment(4) != 'activate') :
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-sms-gateway';
				$data['sms_gateway']		= $this->nurina->get_sms_gateway();
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'SMS Gateway',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'GET-SMS-GATEWAY', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'recordCount'	=> $data['sms_gateway']->num_rows()
							)
						);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);
			else :
				$gateway_id 				= @ sanitizer_vars($this->uri->segment(5));

				$change_gateway 			= $this->nurina->set_sms_gateway($gateway_id);


				if(isset($change_gateway['resultCode']) && $change_gateway['resultCode'] == '0')
					$this->session->set_flashdata('success', $change_gateway['resultDesc']);
				else
				if(isset($change_gateway['resultCode']) && $change_gateway['resultCode'] != '0')
					$this->session->set_flashdata('errors', $change_gateway['resultDesc']);
				else
					$this->session->set_flashdata('errors', 'Terjadi kesalahan pada proses perubahan SMS Gateway, silakan menunggu beberapa saat');


				redirect('frontend/setting/sms-gateway');
			endif;

		}


		public function sms_gateway_edit()
		{

			$this->auth_access();


			if($this->session->userdata('accessSMSGateway') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

			$this->form_validation->set_rules('old_phone_number', 'Nomor HP Lama', 'required|numeric|min_length[8]|max_length[15]');
	    	$this->form_validation->set_rules('new_phone_number', 'Nomor HP Baru', 'required|numeric|min_length[8]|max_length[15]');


			if ($this->form_validation->run() == FALSE)
			{

				$data['phone_number']		= @ read_file('./barrel/default-hp.txt');

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-sms-gateway-edit';
				$data['template']			= (string) FUSION_DEFAULT_THEME . '/';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Edit Nomor HP',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$old_phone_number			= @ sanitizer_vars($this->input->post('old_phone_number'));
				$new_phone_number			= @ sanitizer_vars($this->input->post('new_phone_number'));


				@ write_file('./barrel/default-hp.txt', $new_phone_number, 'w');


				$this->nurina->activity_recorder(
						'ACTIVITY', 'EDIT-TEST-PHONE-NUMBER', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'oldPhone'		=> $old_phone_number,
								'newPhone'		=> $new_phone_number
							)
						);


				$this->session->set_flashdata('success', 'Data Nomor HP testing SMS Gateway sukses diubah');


				redirect('frontend/setting/sms-gateway');

			}

		}


		public function sms_gateway_sendtest()
		{

			$this->auth_access();


			if($this->session->userdata('accessSMSGateway') == 0)
				redirect('frontend/forbidden-access');


			if($this->uri->segment(4) == 'send-test') :
				$gateway_id 				= @ sanitizer_vars($this->uri->segment(5));

				$phone_number 				= @ read_file('./barrel/default-hp.txt');
				$test_gateway 				= $this->nurina->sendtest_sms_gateway($gateway_id, $phone_number, $this->session->userdata('user_id'));


				$this->nurina->activity_recorder(
						'ACTIVITY', 'SENDTEST-SMS-GATEWAY', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id')
							)
						);


				if(isset($test_gateway['resultCode']) && $test_gateway['resultCode'] == '0')
					$this->session->set_flashdata('success', $test_gateway['resultDesc']);
				else
				if(isset($test_gateway['resultCode']) && $test_gateway['resultCode'] != '0')
					$this->session->set_flashdata('errors', $test_gateway['resultDesc']);
				else
					$this->session->set_flashdata('errors', 'Terjadi kesalahan pada proses testing kirim SMS, silakan menunggu beberapa saat');
			endif;


			redirect('frontend/setting/sms-gateway');

		}


		public function sms_gateway_sendtest_report()
		{

			$this->auth_access();


			if($this->session->userdata('accessSMSGateway') == 0)
				redirect('frontend/forbidden-access');


			$data['params']				= @ base_barrel();
			$data['content']			= 'v-frontend-sms-gateway-sendtest';
			$data['sms_gateway']		= $this->nurina->get_sms_gateway_sendtest();
			$data['headers']			= array
									(
										'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'SMS Gateway',
										'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
										'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
										'author'	=> FUSION_AUTHOR_NAME,
										'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
									);


			$this->nurina->activity_recorder(
					'ACTIVITY', 'GET-SMS-GATEWAY-SENDTEST', $this->session->userdata('user_id'),
					($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
					($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
					@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
					array
						(
							'resultCode'	=> 0,
							'userId'		=> $this->session->userdata('user_id'),
							'recordCount'	=> $data['sms_gateway']->num_rows()
						)
					);


			$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

		}


		public function user_account_activity()
		{

			$this->auth_access();


			if($this->session->userdata('accessUserActivity') == 0)
				redirect('frontend/forbidden-access');


			$data['params']					= @ base_barrel();

	    	$this->form_validation->set_rules('id_tmoney', 'Akun T-MONEY', 'required');
	    	$this->form_validation->set_rules('start_date', 'Tanggal Awal', 'required');
	    	$this->form_validation->set_rules('stop_date', 'Tanggal Akhir', 'required');


			if ($this->form_validation->run() == FALSE)
			{

				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-account-activity';
				$data['template']			= (string) FUSION_DEFAULT_THEME . '/';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Aktivitas Akun',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
												. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}
			else
			{

				$id_tmoney 					= @ sanitizer_vars($this->input->post('id_tmoney'));
				$start_date					= @ sanitizer_vars($this->input->post('start_date'));
				$stop_date 					= @ sanitizer_vars($this->input->post('stop_date'));


				$activity_data 				= $this->nurina->get_user_account_activity($id_tmoney, $start_date, $stop_date);


				$this->nurina->activity_recorder(
						'ACTIVITY', 'USER-ACCOUNT-ACTIVITY', $this->session->userdata('user_id'),
						($this->session->userdata('geo_latitude') != '') ? $this->session->userdata('geo_latitude') : '',
						($this->session->userdata('geo_longitude') != '') ? $this->session->userdata('geo_longitude') : '',
						@ get_client_ip_addr(), $this->session->userdata('uniqueSessionId'),
						array
							(
								'resultCode'	=> 0,
								'userId'		=> $this->session->userdata('user_id'),
								'idTmoney'		=> $id_tmoney,
								'startDate'		=> $start_date,
								'stopDate'		=> $stop_date,
								'recordCount'	=> $activity_data->num_rows()
							)
						);


				$data['query']				= $activity_data;
				$data['params']				= @ base_barrel();
				$data['content']			= 'v-frontend-account-activity-record';
				$data['headers']			= array
										(
											'title'		=> FUSION_PLATFORM_NAME . ' - ' . FUSION_PLATFORM_MOTTO . ' : ' . 'Aktivitas Akun',
											'meta_key'	=> 't-money, tmoney, e-money, electronic money, uang elektronik, '
											. 'pt telkom indonesia, modern payment, nfc, tmoney online, tmoney card, qr code, pay by qr',
											'meta_desc'	=> FUSION_PLATFORM_NAME . ' by PT Telkom Indonesia - ' . FUSION_PLATFORM_MOTTO,
											'author'	=> FUSION_AUTHOR_NAME,
											'codename'	=> FUSION_APP_NAME . ' ' . FUSION_APP_VERSION
										);


				$this->load->view((string) FUSION_DEFAULT_THEME . '/v-frontend-index', $data);

			}

		}

	}