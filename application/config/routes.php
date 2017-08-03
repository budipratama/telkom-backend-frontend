<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;




$route['frontend/forbidden-access']						= 'frontend/forbidden_access';
$route['frontend/generate-captcha']						= 'frontend/generate_captcha';
$route['frontend/dashboard']							= 'frontend/dashboard';
$route['frontend/lock-screen']							= 'frontend/lock_screen';
$route['frontend/authorize/phone-send-otp/(:num)']		= 'frontend/phone_send_otp';
$route['frontend/authorize/phone-verify-check']			= 'frontend/phone_verification_check';
$route['frontend/authorize/phone-verify-otp']			= 'frontend/phone_verification_otp';
$route['frontend/authorize/reset-pin-inquiry']			= 'frontend/authorize_reset_pin_inquiry';
$route['frontend/authorize/reset-pin-confirmation']		= 'frontend/authorize_reset_pin_confirmation';
$route['frontend/authorize/reset-pin-status']			= 'frontend/authorize_reset_pin_status';
$route['frontend/checking/geo-ip-address']				= 'frontend/geo_ip_address';
$route['frontend/monitoring/sms-gateway-send-test']		= 'frontend/sms_gateway_sendtest_report';
$route['frontend/monitoring/last-day-transaction']		= 'frontend/data_transaction_last_day';
$route['frontend/monitoring/user-account-activity']		= 'frontend/user_account_activity';
$route['frontend/reporting/customer']					= 'frontend/data_customer';
$route['frontend/reporting/customer-record']			= 'frontend/data_customer';
$route['frontend/reporting/finpay']						= 'frontend/data_finpay_0211';
$route['frontend/reporting/finpay-record']				= 'frontend/data_finpay_0211';
$route['frontend/reporting/reset-pin']					= 'frontend/data_reset_pin';
$route['frontend/reporting/reset-pin-record']			= 'frontend/data_reset_pin';
$route['frontend/reporting/transaction']				= 'frontend/data_transaction';
$route['frontend/reporting/transaction-record']			= 'frontend/data_transaction';
$route['frontend/reporting/user']						= 'frontend/data_user';
$route['frontend/reporting/user/activate/(:any)']		= 'frontend/data_user';
$route['frontend/reporting/user/add']					= 'frontend/data_user_add';
$route['frontend/reporting/user/deactivate/(:any)']		= 'frontend/data_user';
$route['frontend/setting/sms-gateway']					= 'frontend/sms_gateway';
$route['frontend/setting/sms-gateway/activate/(:any)']	= 'frontend/sms_gateway';
$route['frontend/setting/sms-gateway/edit-hp']			= 'frontend/sms_gateway_edit';
$route['frontend/setting/sms-gateway/send-test/(:any)']	= 'frontend/sms_gateway_sendtest';
$route['frontend/sign-in'] 								= 'frontend/login';
$route['frontend/sign-out']								= 'frontend/logout';
$route['frontend/user/my-profile'] 						= 'frontend/my_profile';
