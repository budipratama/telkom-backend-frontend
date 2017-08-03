<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// update budi
$config['css_admin_patch']= '//'.$_SERVER['SERVER_NAME'].str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']).'/assets/css/admin/';
$config['js_admin_patch']= '//'.$_SERVER['SERVER_NAME'].str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']).'/assets/js/admin/';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| https://codeigniter.com/user_guide/libraries/encryption.html
|
*/
$config['encryption_key'] = '#D4NR4~FEBAPP~V3.0@TMONEY~1$2%3#';


// TMONEY
defined('FUSION_AES_BLOCKSIZE')         OR define('FUSION_AES_BLOCKSIZE', 256);
