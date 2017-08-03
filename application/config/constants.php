<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code













defined('FUSION_ENVIRONMENT')			OR define('FUSION_ENVIRONMENT', 'development');

defined('FUSION_AUTHOR_NAME')			OR define('FUSION_AUTHOR_NAME', 'DANRA'); # RAVI VENDRA R
defined('FUSION_AUTHOR_QUOTE')			OR define('FUSION_AUTHOR_QUOTE', 'Spread your ideas, code it into the canvas');
defined('FUSION_APP_NAME')				OR define('FUSION_APP_NAME', 'NURINA - Nested and Unified Report In a Narrow Application');
defined('FUSION_APP_VERSION')			OR define('FUSION_APP_VERSION', '1.0');
defined('FUSION_PLATFORM_NAME')			OR define('FUSION_PLATFORM_NAME', 'T-MONEY');
defined('FUSION_PLATFORM_MOTTO')		OR define('FUSION_PLATFORM_MOTTO', 'Your Digital Payment Solution');
defined('FUSION_NOTIFICATION_SENDER')	OR define('FUSION_NOTIFICATION_SENDER', 'noreply@tmoney.co.id');

defined('FUSION_SESS_EXPIRED')			OR define('FUSION_SESS_EXPIRED', 3600);
defined('FUSION_SALT')					OR define('FUSION_SALT', 'D4nr4-23072016');
defined('FUSION_TERMINAL')     			OR define('FUSION_TERMINAL', 'CS-TMONEY');
defined('FUSION_UNIQUE_TOKEN')			OR define('FUSION_UNIQUE_TOKEN', 'D4nr4f91ef9b5a46dN80bbae33e4Ef863cb4V56a6571c3Abc0337b4fDef680cf67A5e801b9023072016');

if(FUSION_ENVIRONMENT == 'development')
{
	$api_url				= 'https://api-sandbox.tmoney.co.id';
}
else
if(FUSION_ENVIRONMENT == 'deployment')
{
	$api_url				= 'https://api-qa.tmoney.co.id';
}
else
if(FUSION_ENVIRONMENT == 'production')
{
	$api_url				= 'https://prodapi-app.tmoney.co.id';
}

defined('FUSION_BASE_API')     			OR define('FUSION_BASE_API', $api_url . '/');
defined('FUSION_API')     				OR define('FUSION_API', FUSION_BASE_API . 'api/');

defined('FUSION_DEFAULT_THEME')     	OR define('FUSION_DEFAULT_THEME', 'moltran');

defined('MAIN_API_KEY')     			OR define('MAIN_API_KEY', '7d783fd74652b02d53f6672ced4a98c7');
defined('MAIN_API_URL')     			OR define('MAIN_API_URL', 'https://api.mainapi.net/smsnotification/1.0.0/messages');

defined('RAJA_SMS_KEY')     			OR define('RAJA_SMS_KEY', '34737f4758aac7be09e908f1db82a8df');
defined('RAJA_SMS_URL')     			OR define('RAJA_SMS_URL', 'http://45.76.156.114');

defined('ZENZIVA_USER_KEY')     		OR define('ZENZIVA_USER_KEY', 'wke58c');
defined('ZENZIVA_PASS_KEY')     		OR define('ZENZIVA_PASS_KEY', '0ld-tr4fford');
defined('ZENZIVA_API_URL')				OR define('ZENZIVA_API_URL', 'https://reguler.zenziva.net/apps/smsapi.php?userkey=' . ZENZIVA_USER_KEY . '&passkey=' . ZENZIVA_PASS_KEY);

defined('TBL_ALL_ACTIVITY')     		OR define('TBL_ALL_ACTIVITY', strtolower('F_ALL_ACTIVITY'));
defined('TBL_AUTHORIZATION')			OR define('TBL_AUTHORIZATION', strtolower('F_AUTHORIZATION'));
defined('TBL_AUTHORIZATION_LEVEL')		OR define('TBL_AUTHORIZATION_LEVEL', strtolower('F_AUTHORIZATION_LEVEL'));
defined('TBL_USER_AGENT')     			OR define('TBL_USER_AGENT', strtolower('F_USER_AGENT'));
defined('TBL_CUSTOMER')     			OR define('TBL_CUSTOMER', strtolower('F_CUSTOMER'));
defined('TBL_FINPAY')     				OR define('TBL_FINPAY', strtolower('F_PAYMENT_CODE'));
defined('TBL_CITY')     				OR define('TBL_CITY', strtolower('F_KABKOTA'));
# defined('TBL_OTP_PHONE')     			OR define('TBL_OTP_PHONE', strtolower('F_OTP_PHONE_NUMBER'));
defined('TBL_PROVINCE')     			OR define('TBL_PROVINCE', strtolower('F_PROVINSI'));
defined('TBL_RESET_PIN')     			OR define('TBL_RESET_PIN', strtolower('F_RESET_PIN_RECORD'));
defined('TBL_SMS_GATEWAY')     			OR define('TBL_SMS_GATEWAY', strtolower('F_SMS_GATEWAY'));
defined('TBL_SMS_GATEWAY_SENDTEST')		OR define('TBL_SMS_GATEWAY_SENDTEST', strtolower('F_SMS_GATEWAY_SENDTEST'));
defined('TBL_TRANSACTION')     			OR define('TBL_TRANSACTION', strtolower('F_TRX_LOGHEADER'));

defined('TBL_IV_ALL_ACTIVITY')     		OR define('TBL_IV_ALL_ACTIVITY', strtolower('F_ALL_ACTIVITY'));
defined('TBL_IV_GEO_IP')     			OR define('TBL_IV_GEO_IP', strtolower('F_GEO_LOCATION_IP'));
defined('TBL_IV_PHONE_VERIFY') 			OR define('TBL_IV_PHONE_VERIFY', strtolower('F_VERIFY_PHONE_NUMBER'));
defined('TBL_IV_PHONE_VERIFY_RETRY')	OR define('TBL_IV_PHONE_VERIFY_RETRY', strtolower('F_VERIFY_PHONE_NUMBER_RETRY'));