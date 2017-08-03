
<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * aes_decrypt()
     *
     * Decrypt the string into AES decrypted (plain) form
     * Returning the decrypted value, so can be parsed securely in the front side
     *
     * param       string $string
     *
     * return      string $dec_pin
     */
    if(! function_exists('aes_decrypt'))
    {

        function aes_decrypt($string = '')
        {

            $CI                 = & get_instance();

            $aes                = new AES(trim($string), $CI->config->item('encryption_key'), (int) FUSION_AES_BLOCKSIZE);
            $dec_pin            = $aes->decrypt();

            return ($dec_pin);

        }

    }


    if(! function_exists('aes_decrypt2'))
    {

        function aes_decrypt2($string = '')
        {

            $CI                 = & get_instance();

            $aes                = new AES(trim($string), "myindihometmoney123", (int) FUSION_AES_BLOCKSIZE);
            $dec_pin            = $aes->decrypt();

            return ($dec_pin);

        }

    }

    /**
     * aes_encrypt()
     *
     * Encrypt the string into AES encrypted form
     * Returning the encrypted value, so can be parsed securely in the front side
     *
     * param       string $string
     *
     * return      string $enc_pin
     */
    if(! function_exists('aes_encrypt'))
    {

        function aes_encrypt($string = '')
        {

            $CI                 = & get_instance();

            $aes                = new AES(trim($string), $CI->config->item('encryption_key'), (int) FUSION_AES_BLOCKSIZE);
            $enc_pin            = $aes->encrypt();

            return ($enc_pin);

        }

    }


    /**
     * array_data()
     *
     * Build a combined string from dimensional array
     *
     * param       array   $params
     *
     * return      string  $tmp
     */
    if(! function_exists('array_data'))
    {

        function array_data($params = array())
        {

            foreach ($params as $varName => $varVal)
                $tmp            .=$varName . '=' . $varVal . ' | ';

            return $tmp;

        }

    }


    /**
     * check_bank()
     *
     * Checking the bank code parameter from the client side
     * If valid then return TRUE, return FALSE if invalid
     *
     * param       string $code
     *
     * return      string $output
     */
    if(! function_exists('check_bank'))
    {

        function check_bank($code = '')
        {

            $CI                 = & get_instance();
            $CI->load->database();


            $bank_query         = 'SELECT B.BANK_CODE, B.BANK_NAME, G.GROUP_NAME FROM '
                        . TBL_BANK . ' B INNER JOIN ' . TBL_BANK_GROUP . ' G '
                        . 'ON B.BANK_GROUP = G.GROUP_ID '
                        . 'WHERE B.BANK_CODE = "' . $code . '" '
                        . 'AND B.BANK_ACTIVE = 1 AND G.GROUP_ACTIVE = 1';


            $bank_exec          = $CI->db->query($bank_query);


            if($bank_exec->num_rows() > 0)
            {

                $bank_row       = $bank_exec->row();


                $output         = array
                            (
                                'code'      => trim($bank_row->BANK_CODE),
                                'name'      => trim($bank_row->BANK_NAME),
                                'group'     => trim($bank_row->GROUP_NAME)
                            );


                return ($output);

            }
            else
                return ('GI-001');

        }

    }


    /**
     * check_email()
     *
     * Checking the email parameter from the client side
     * If valid then return TRUE, return FALSE if invalid
     *
     * param       string $email_address
     *
     * return      boolean $output
     */
    if(! function_exists('check_email'))
    {

        function check_email($email_address = '')
        {

            $validity           =  filter_var($email_address, FILTER_VALIDATE_EMAIL);


            if($validity == TRUE)
                return (1);
            else
                return (0);

        }

    }


    /**
     * check_product()
     *
     * Checking the product code parameter from the client side
     * If valid then return TRUE, return FALSE if invalid
     *
     * param       string $code
     * param       string $type
     * param       int $nominal
     *
     * return      boolean $output
     */
    if(! function_exists('check_product'))
    {

        function check_product($code = '', $type = '', $nominal = 0)
        {

            $CI                 = & get_instance();
            $CI->load->database();


            if($nominal == 0)

                $product_query  = 'SELECT T.TYPE_NAME AS `TYPE`, P.PRD_CODE AS `CODE`, '
                            . 'P.PRD_NAME AS `NAME`, P.MERCHANT_CODE AS `MRC_CODE`, '
                            . 'O.OP_ID AS `OP_CODE`, O.OP_NAME AS `OP_NAME` '
                        . 'FROM ' . TBL_PRODUCT . ' P '
                            . 'INNER JOIN ' . TBL_PRODUCT_GROUP . ' G '
                            . 'INNER JOIN ' . TBL_PRODUCT_TYPE . ' T '
                            . 'INNER JOIN ' . TBL_OPERATOR . ' O '
                        . 'ON P.PRD_GROUP = G.GROUP_ID AND G.TYPE_ID = T.TYPE_ID '
                            . 'AND P.OP_CODE = O.OP_ID '
                        . 'WHERE T.TYPE_ACTIVE = 1 AND G.GROUP_ACTIVE = 1 AND P.PRD_ACTIVE = 1 '
                            . 'AND P.PRD_CODE = "' . $code . '" AND T.TYPE_NAME = "' . $type . '" '
                        . 'ORDER BY P.PRD_ID';

            else

                $product_query  = 'SELECT T.TYPE_NAME AS `TYPE`, P.PRD_CODE AS `CODE`, '
                            . 'P.PRD_NAME AS `NAME`, P.MERCHANT_CODE AS `MRC_CODE`, '
                            . 'O.OP_ID AS `OP_CODE`, O.OP_NAME AS `OP_NAME` '
                        . 'FROM ' . TBL_PRODUCT . ' P '
                            . 'INNER JOIN ' . TBL_PRODUCT_VAL . ' V '
                            . 'INNER JOIN ' . TBL_PRODUCT_GROUP . ' G '
                            . 'INNER JOIN ' . TBL_PRODUCT_TYPE . ' T '
                            . 'INNER JOIN ' . TBL_OPERATOR . ' O '
                        . 'ON P.PRD_ID = V.PRD_ID AND P.PRD_GROUP = G.GROUP_ID '
                            . 'AND G.TYPE_ID = T.TYPE_ID AND P.OP_CODE = O.OP_ID '
                        . 'WHERE T.TYPE_ACTIVE = 1 AND G.GROUP_ACTIVE = 1 AND P.PRD_ACTIVE = 1 '
                            . 'AND P.PRD_CODE = "' . $code . '" AND T.TYPE_NAME = "' . $type . '" '
                            . 'AND V.PRD_VALUE = "' . $nominal . '" '
                        . 'ORDER BY P.PRD_ID';


            $product_exec       = $CI->db->query($product_query);


            if($product_exec->num_rows() > 0)
            {

                $product_row    = $product_exec->row();

                $val            = array
                            (
                                'prd_type'      => trim($product_row->TYPE),
                                'prd_code'      => trim($product_row->CODE),
                                'prd_name'      => trim($product_row->NAME),
                                'merchant_code' => trim($product_row->MRC_CODE),
                                'op_code'       => trim($product_row->OP_CODE),
                                'op_name'       => trim($product_row->OP_NAME)
                            );

                return($val);

            }
            else
                return (FALSE);

        }

    }


    /**
     * check_pin()
     *
     * Checking the PIN parameter from the client side
     * If valid then return TRUE, return FALSE if invalid
     *
     * param       string $id_tmoney
     * param       string $id_fusion
     * param       string $pin
     *
     * return      boolean $output
     */
    if(! function_exists('check_pin'))
    {

        function check_pin($id_tmoney = '', $id_fusion = '', $pin = '')
        {

            $CI                 = & get_instance();
            $CI->load->database();


            $pin_query          = 'SELECT CUSTCODE FROM ' . TBL_CUSTOMER
                        . ' WHERE ' .
                                '(CUSTCODE = "' . $id_tmoney . '" ' .
                                'OR EMAIL = "' . $id_tmoney . '" ' .
                                'OR CUSTPHONE = "' . $id_tmoney . '") ' .
                            'AND CONTACTPHONE = "' . $id_fusion . '" ' .
                            'AND PIN = "' . $pin . '"';


            if($CI->db->query($pin_query)->num_rows() > 0)
                return (1);
            else
                return (0);

        }

    }


    /**
     * check_recipient()
     *
     * Checking the destination account parameter from the client side
     * If valid then return TRUE, return FALSE if invalid
     *
     * param       string $dest_account
     * param       string $trans_type
     *
     * return      string $output
     */
    if(! function_exists('check_recipient'))
    {

        function check_recipient($dest_account = '', $trans_type = 'TRANSFER_P2P')
        {

            $CI                 = & get_instance();
            $CI->load->database();


            $recipient_query    = 'SELECT I_CUST.CUSTCODE AS ID_TMONEY, I_CUST.CUSTNAME, I_CUST.EMAIL, ' .
                            'I_CUST.CUSTPHONE, I_CUST.CONTACTPHONE AS ID_FUSION, ' .
                            'I_CUST.STATUS, I_CUSTLEVEL.ID AS LEVEL_ID, I_CUSTLEVEL.LEVEL_NAME ' .
                            'FROM ' . TBL_CUSTOMER . ' I_CUST ' .
                            'INNER JOIN ' . TBL_CUSTOMER_LEVEL . ' I_CUSTLEVEL ' .
                            'ON I_CUST.CUSTTYPEID = I_CUSTLEVEL.ID ' .
                            'WHERE ' .
                                '(I_CUST.CUSTCODE = "' . $dest_account . '" ' .
                                'OR I_CUST.EMAIL = "' . $dest_account . '" ' .
                                'OR I_CUST.CUSTPHONE = "' . $dest_account . '")';


            $recipient_exec     = $CI->db->query($recipient_query);


            if($recipient_exec->num_rows() > 0)
            {

                $recipient_row  = $recipient_exec->row();


                if($recipient_row->STATUS != '1')
                    return ('GL-011');

                /**
                if(($recipient_row->LEVEL_ID != '2' && strtoupper($recipient_row->LEVEL_NAME) != 'PLATINUM')
                    && $trans_type == 'TRANSFER_P2P')
                    return ('204');
                */


                $output         = array
                            (
                                'code'      => trim($recipient_row->ID_TMONEY),
                                'name'      => trim($recipient_row->CUSTNAME),
                                'email'     => trim($recipient_row->EMAIL),
                                'phone'     => trim($recipient_row->CUSTPHONE),
                                'fusCode'   => trim($recipient_row->ID_FUSION),
                                'status'    => ($row->STATUS == '1') ? 'Aktif' : 'Tidak Aktif',
                                'type'      => strtoupper($recipient_row->LEVEL_NAME)
                            );


                return ($output);

            }
            else
                return ('GL-012');

        }

    }


    /**
     * check_sender()
     *
     * Checking the sender account parameter from the client side
     * If valid then return TRUE, return FALSE if invalid
     *
     * param       string $id_tmoney
     * param       string $id_fusion
     * param       string $trans_type
     *
     * return      string $output
     */
    if(! function_exists('check_sender'))
    {

        function check_sender($id_tmoney = '', $id_fusion = '', $trans_type = 'TRANSFER_P2P')
        {

            $CI                 = & get_instance();
            $CI->load->database();


            $sender_query       = 'SELECT I_CUST.CUSTCODE AS ID_TMONEY, I_CUST.CUSTNAME, I_CUST.EMAIL, ' .
                            'I_CUST.CUSTPHONE, I_CUST.CONTACTPHONE AS ID_FUSION, I_CUST.CUSTADDRESS, ' . # I_CUST.EM_PASSWORD
                            'I_CUST.STATUS, I_CUSTLEVEL.ID AS LEVEL_ID, I_CUSTLEVEL.LEVEL_NAME ' .
                            'FROM ' . TBL_CUSTOMER . ' I_CUST ' .
                            'INNER JOIN ' . TBL_CUSTOMER_LEVEL . ' I_CUSTLEVEL ' .
                            'ON I_CUST.CUSTTYPEID = I_CUSTLEVEL.ID ' .
                            'WHERE ' .
                                '(I_CUST.CUSTCODE = "' . $id_tmoney . '" ' .
                                'OR I_CUST.EMAIL = "' . $id_tmoney . '" ' .
                                'OR I_CUST.CUSTPHONE = "' . $id_tmoney . '") ' .
                            'AND I_CUST.CONTACTPHONE = "' . $id_fusion . '"';


            $sender_exec        = $CI->db->query($sender_query);


            if($sender_exec->num_rows() > 0)
            {

                $sender_row     = $sender_exec->row();


                if($sender_row->STATUS != '1')
                    return ('GL-016');

                if(($sender_row->LEVEL_ID == '1' OR $sender_row->LEVEL_ID == '3')
                    && ($trans_type == 'TRANSFER_P2P' OR $trans_type == 'TRANSFER_P2B'))
                    return ('GL-015');


                $output         = array
                            (
                                'code'      => trim($sender_row->ID_TMONEY),
                                'name'      => trim($sender_row->CUSTNAME),
                                'email'     => trim($sender_row->EMAIL),
                                'phone'     => trim($sender_row->CUSTPHONE),
                                # 'fusPass' => trim($sender_row->EM_PASSWORD),
                                'fusCode'   => trim($sender_row->ID_FUSION),
                                'address'   => trim($sender_row->CUSTADDRESS),
                                'status'    => ($sender_row->STATUS == '1') ? 'Aktif' : 'Tidak Aktif',
                                'type'      => strtoupper($sender_row->LEVEL_NAME)
                            );


                return ($output);

            }
            else
                return ('GL-012');

        }

    }


    /**
     * check_terminal()
     *
     * Checking the terminal parameter from the client side
     * If valid & not expired then return TRUE, return FALSE if invalid
     *
     * param       string $name
     *
     * return      boolean $output
     */
    if(! function_exists('check_terminal'))
    {

        function check_terminal($name = '')
        {

            $CI                 = get_instance();
            $CI->load->database();


            $terminal_query     = 'SELECT * FROM ' . TBL_TERMINAL
                        . ' WHERE TERMINAL_NAME = "' . $name . '"'
                        . 'AND ACTIVE = 1';


            if($CI->db->query($terminal_query)->num_rows() > 0)
                return (1);
            else
                return (0);

        }

    }


    /**
     * check_token()
     *
     * Checking the token parameter from the client side
     * If valid & not expired then return TRUE, return FALSE if invalid
     *
     * param       string $id_tmoney
     * param       string $id_fusion
     * param       string $token
     *
     * return      boolean $output
     */
    if(! function_exists('check_token'))
    {

        function check_token($id_tmoney = '', $id_fusion = '', $token = '')
        {

            $CI                 = get_instance();
            $CI->load->database();


            $token_query        = 'SELECT CUSTCODE FROM ' . TBL_CUSTOMER
                        . ' WHERE ' .

                                '(CUSTCODE = "' . $id_tmoney . '" ' .
                                'OR EMAIL = "' . $id_tmoney . '" ' .
                                'OR CUSTPHONE = "' . $id_tmoney . '") ' .
                            'AND CONTACTPHONE = "' . $id_fusion . '"' .
                            'AND TOKEN = "' . $token . '"' .
                            'AND TOKENEXPIREDDATE > NOW()';


            if($CI->db->query($token_query)->num_rows() > 0)
                return (1);
            else
                return (0);

        }

    }


    /**
     * cleaner_vars()
     *
     * Clean the parameters from HTML, JS and CSS tag scripts
     * Avoid from hijacking & make it safer
     *
     * param       string $input
     *
     * return      string $output
     */
    if(! function_exists('cleaner_vars'))
    {

        function cleaner_vars($input = '')
        {

            $search             = array
                            (
                                '<script[^>]*?>.*?</script>si',   # Strip out any Javascript codes
                                '<[\/\!]*?[^<>]*?>si',            # Strip out any HTML tag codes
                                '<style[^>]*?>.*?</style>siU',    # Strip out any CSS tag codes
                                '<![\s\S]*?--[ \t\n\r]*>'
                            );

            $output             = preg_replace($search, '', $input);
            return ($output);

        }

    }


    /**
     * formatter_currency()
     *
     * Formatting the number with Country's Currency Code
     * Default currency is IDR (Indonesian Rupiah)
     *
     * param       string $input
     *
     * return      string $output
     */
    if(! function_exists('formatter_currency'))
    {

        function formatter_currency($input = 0, $currency = 'IDR')
        {

            switch ($currency)
            {
                case 'IDR' :        $code   = 'Rp';     break;
            }


            $output             = $code . ' ' . number_format($input, 0, ',', '.') . ',-';
            return ($output);

        }

    }


    /**
     * formatter_date()
     *
     * Formatting the date from [YYYY-MM-DD/DD-MM-YYYY] HH:II:SS
     * into Indonesian medium date format (example : 20-02-2016 10:15:20)
     *
     * param       string $input
     *
     * return      string $output
     */
    if(! function_exists('formatter_date'))
    {

        function formatter_date($input = '')
        {

            $chunks             =  explode(' ', $input);
            $chunk_date         =  explode('-', $chunks[0]);


            $day                = (strlen($chunk_date[0]) == 2) ? $chunk_date[0] : $chunk_date[2];
            $month              = $chunk_date[1];
            $year               = (strlen($chunk_date[2]) == 4) ? $chunk_date[2] : $chunk_date[0];


            switch ($month)
            {
                case '01' : $month = 'Januari';     break;
                case '02' : $month = 'Februari';    break;
                case '03' : $month = 'Maret';       break;
                case '04' : $month = 'April';       break;
                case '05' : $month = 'Mei';         break;
                case '06' : $month = 'Juni';        break;
                case '07' : $month = 'Juli';        break;
                case '08' : $month = 'Agustus';     break;
                case '09' : $month = 'September';   break;
                case '10' : $month = 'Oktober';     break;
                case '11' : $month = 'November';    break;
                case '12' : $month = 'Desember';    break;
            }


            return ($day . ' ' . $month . ' ' . $year . ' - ' . $chunks[1]);

        }

    }


    /**
     * formatter_phone()
     *
     * Formatting the phone number with '+' & Country Code
     * If lead by '0' remove it, else just add with '+' & Country Code
     *
     * param       string $input
     * param       string $prefix
     *
     * return      string $output
     */
    if(! function_exists('formatter_phone'))
    {

        function formatter_phone($input = '', $prefix = '+62')
        {

            $prefix                 = (isset($prefix) && $prefix != '') ? $prefix : '+62';


            if ($input <> '')
            {

                if($input[0] == '0')
                    $output         = $prefix . substr($input, 1); #  substr_replace($input, '+62', 0, ($input[0] == '0'));
                else
                if($input[0] == '+' && $input[1] == '6' && $input[2] == '2')
                    $output         = $input;
                else
                    $output         = $prefix . $input;

            }
            else
                $output             = '';


            return ($output);

        }

    }


    /**
     * func_params()
     *
     * Build a combined string from dimensional array
     *
     * param       string $this
     * param       string $f_name
     * param       string $inputVal
     *
     * return      string $tmp
     */
    if(! function_exists('func_params'))
    {

        function func_params($this = '', $f_name = '', $inputVal = '')
        {

            $ref                    = new ReflectionMethod($this, $f_name);
            $i                      = 0;

            foreach( $ref->getParameters() as $param)
            {
                $name               = $param->name;
                $tmp                .=$name . '=' . $inputVal[$i] . ' | ';

                $i++;
            }

            return $tmp;

        }

    }


    /**
     * generator_bit61()
     *
     * Generate random ID for Bit 61 [FINNET WSDL & FUSION]
     *
     * param       string $id
     *
     * return      string $gen_bit61
     */
    if(! function_exists('generator_bit61'))
    {

        function generator_bit61($id = '')
        {

            $gen_bit61          = '195' . mt_rand(3, 4) . date('ymdHis') .
                substr($id, 3) . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);


            return ($gen_bit61);

        }

    }


    /**
     * generator_custphone()
     *
     * Generate customer phone for ID Fusion [FINNET WSDL & FUSION]
     *
     * param
     *
     * return      string $gen_phone
     */
    if(! function_exists('generator_custphone'))
    {

        function generator_custphone()
        {

            $gen_phone          = '+621956';

            $gen_phone          .= substr(str_shuffle('0123456789'), mt_rand(0, 7), 3);
            $gen_phone          .= mt_rand(1000, 9999);


            return ($gen_phone);

        }

    }


    /**
     * generator_pin_number()
     *
     * Generate PIN Number for every T-MONEY customer
     *
     * param
     *
     * return      string $gen_pin
     */
    if(! function_exists('generator_pin_number'))
    {

        function generator_pin_number()
        {

            $gen_pin            =  substr(str_shuffle('01234567890123456789'), 0, 6);

            return ($gen_pin);

        }

    }


    /**
     * generator_refno()
     *
     * Generate random ID for Reference Number [FINNET WSDL & FUSION]
     *
     * param
     *
     * return      string $gen_refno
     */
    if(! function_exists('generator_refno'))
    {

        function generator_refno()
        {

            $gen_refno          =  substr(str_shuffle('0123456789'), mt_rand(0, 4), 6);
            $gen_refno          .=date('ymd');

            return ($gen_refno);

        }

    }


    /**
     * generator_traxid()
     *
     * Generate random ID for Transaction ID [FINNET WSDL & FUSION]
     *
     * param
     *
     * return      string $gen_bit61
     */
    if(! function_exists('generator_traxid'))
    {

        function generator_traxid()
        {

            $gen_traxid         = '195' . date('ymdHis') . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
            return ($gen_traxid);

        }

    }


    /**
     * get_client_ip_addr()
     *
     * Getting the IP Address of the client who hit this FUSION API
     *
     * param
     *
     * return      string $output
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
     * mail_notification()
     *
     * Send email notification to the user's email address
     *
     * param       string $id_tmoney
     * param       string $id_fusion
     * param       string $template
     * param       string $subject
     * param       array $data
     *
     * return      boolean $output
     */
    if(! function_exists('mail_notification'))
    {

        function mail_notification($id_tmoney = '', $id_fusion = '', $template = '', $subject = '', $data = array())
        {

            $CI                 = get_instance();

            $CI->load->database();
            $CI->load->helper('file');


            if($id_tmoney == 'thirdparty')
            {

                if(check_email($id_fusion) == 0)
                    return ('GL-018');

                $email_address  = trim($id_fusion);

            }
            else
            {

                $mail_query     = 'SELECT EMAIL FROM ' . TBL_CUSTOMER
                    . ' WHERE CUSTCODE = "' . $id_tmoney . '" AND CONTACTPHONE = "' . $id_fusion . '"';
                $mail_exec      = $CI->db->query($mail_query);


                if($mail_exec->num_rows() == 0)
                    return ('GL-017');


                $mail_row       = $mail_exec->row();

                $email_address  = trim($mail_row->EMAIL);

            }


            $f_name             = 'mail_tpl/' . $template . '.html';
            $content            =  read_file('application/helpers/' . $f_name);


            if($template == 'tpl_airtime')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'INSTITUSI', 'KODE_PRODUK', 'NAMA_PRODUK', 'NOMOR_HP',
                                'NOMINAL', 'TOTAL', 'NOMOR_VOUCHER', 'WAKTU', 'NOMOR_TRANSAKSI',
                                'STATUS'
                            );
            else
            if($template == 'tpl_aktifasi_akun')
                $search         = array
                            (
                                'NAMA_LENGKAP', 'EMAIL', 'ID_AKUN', 'TIPE_AKUN', 'WAKTU',
                                'STATUS','PIN'
                            );
            else
            if($template == 'tpl_billpayment')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'INSTITUSI', 'KODE_PRODUK', 'NAMA_PRODUK', 'NOMOR_TAGIHAN',
                                'NAMA_TAGIHAN', 'NOMINAL', 'FEE', 'TOTAL', 'WAKTU',
                                'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_change_password')
                $search         = array
                            (
                                'EMAIL', 'ID_AKUN', 'WAKTU', 'STATUS'
                            );
            else
            if($template == 'tpl_change_pin')
                $search         = array
                            (
                                'EMAIL', 'ID_AKUN', 'WAKTU', 'STATUS'
                            );
            else
            if($template == 'tpl_donasi')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'INSTITUSI', 'KODE_PRODUK', 'NAMA_PRODUK', 'NOMINAL',
                                'FEE', 'TOTAL', 'WAKTU', 'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_isi_saldo_receiver')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'NAMA_AKUN', 'NOMINAL', 'WAKTU', 'NOMOR_TRANSAKSI',
                                'STATUS'
                            );
            else
            if($template == 'tpl_isi_saldo_sender')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'ID_AKUN', 'NAMA_AKUN', 'NOMINAL', 'FEE',
                                'TOTAL', 'WAKTU', 'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_probasi_akun')
                $search         = array
                            (
                                'ID_AKUN', 'NAMA_LENGKAP', 'EMAIL', 'PASSWORD', 'PIN',
                                'WAKTU', 'TIPE_AKUN', 'STATUS'
                            );
            else
            if($template == 'tpl_registrasi')
                $search         = array('LINK_AKTIFASI');
            else
            if($template == 'tpl_reset_password')
                $search         = array('LINK_RESET_PASSWD');
            else
            if($template == 'tpl_reset_pin')
                $search         = array('LINK_RESET_PIN');
            else
            if($template == 'tpl_set_reset_password')
                $search         = array
                            (
                                'EMAIL', 'ID_AKUN', 'WAKTU', 'STATUS'
                            );
            else
            if($template == 'tpl_set_reset_pin')
                $search         = array
                            (
                                'EMAIL', 'ID_AKUN', 'WAKTU', 'STATUS'
                            );
            else
            if($template == 'tpl_tariktunai_cashout')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'ID_AKUN', 'NAMA_LENGKAP', 'NOMOR_HP', 'KODE_TRANSFER',
                                'NOMINAL', 'FEE', 'TOTAL', 'KODE_MERCHANT', 'NAMA_MERCHANT',
                                'KODE_OUTLET', 'WAKTU', 'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_tariktunai_reserve')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'ID_AKUN', 'NAMA_AKUN', 'KODE_TRANSFER', 'NOMINAL',
                                'FEE', 'TOTAL', 'WAKTU_CREATE', 'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_token_payment')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'KODE_MERCHANT', 'NAMA_MERCHANT', 'KODE_TOKEN', 'NOMINAL',
                                'FEE', 'TOTAL', 'WAKTU', 'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_token_reserve')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'KODE_TOKEN', 'VALIDITAS_TOKEN', 'WAKTU_CREATE', 'WAKTU_EXPIRED',
                                'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_transfer_p2b_receiver')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'KODE_BANK', 'NAMA_BANK', 'NO_REKENING', 'NAMA_REKENING',
                                'ID_AKUN', 'NAMA_AKUN', 'SYSTEM', 'NOMINAL', 'DESCRIPTION',
                                'WAKTU', 'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_transfer_p2b_sender')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'KODE_BANK', 'NAMA_BANK', 'NO_REKENING', 'NAMA_REKENING',
                                'NOMINAL', 'FEE', 'TOTAL', 'DESCRIPTION', 'WAKTU',
                                'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_transfer_p2o_receiver')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'KODE_SISTEM', 'NAMA_SISTEM', 'NO_REKENING', 'NAMA_REKENING',
                                'ID_AKUN', 'NAMA_AKUN', 'SYSTEM', 'NOMINAL', 'DESCRIPTION',
                                'WAKTU', 'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_transfer_p2o_sender')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'KODE_SISTEM', 'NAMA_SISTEM', 'NO_REKENING', 'NAMA_REKENING',
                                'NOMINAL', 'FEE', 'TOTAL', 'DESCRIPTION', 'WAKTU',
                                'NOMOR_TRANSAKSI', 'STATUS'
                            );
            else
            if($template == 'tpl_transfer_p2p_receiver')
                $search         = array
                            (
                                '@JENIS_TRANSAKSI@', '@ID_AKUN@', '@NAMA_AKUN@', '@NOMINAL@', '@WAKTU@',
                                '@NOMOR_TRANSAKSI@', '@STATUS@'
                            );
            else
            if($template == 'tpl_transfer_p2p_sender')
                $search         = array
                            (
                                '@JENIS_TRANSAKSI@', '@ID_AKUN@', '@NAMA_AKUN@', '@NOMINAL@', '@FEE@',
                                '@TOTAL@', '@WAKTU@', '@NOMOR_TRANSAKSI@', '@STATUS@'
                            );
            else
            if($template == 'tpl_upgrade_approval')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'ID_AKUN', 'NAMA_LENGKAP', 'TIPE_AKUN', 'TIPE_IDENTITAS',
                                'NO_IDENTITAS', 'ADDRESS', 'CITY', 'PROVINCE', 'WAKTU',
                                'STATUS'
                            );
            if($template == 'tpl_upgrade_request')
                $search         = array
                            (
                                'JENIS_TRANSAKSI', 'ID_AKUN', 'NAMA_LENGKAP', 'TIPE_IDENTITAS', 'NO_IDENTITAS',
                                'ADDRESS', 'CITY', 'PROVINCE', 'WAKTU', 'STATUS'
                            );


            $content            =  str_replace($search, $data, $content);


             $CI->sendgrid_mail->send_mail($email_address, FUSION_MAIL_FROM, $subject, $content);


            return (TRUE);

        }

    }


    /**
     * password_checker()
     *
     * Check the security level of password
     * Avoid from insecure password and make it safer from hacking
     *
     * param       string $input
     *
     * return      boolean $result
     */
    if(! function_exists('password_checker'))
    {

        function password_checker($input = '')
        {

            if (preg_match("#.*^(?=.{8,25})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $input))
                $result         = TRUE;
            else
                $result         = FALSE;


            return ($result);

        }

    }


    /**
     * sanitizer_int()
     *
     * Sanitize integer parameters executed in this application
     * Avoid from some strings such as comma or dot
     *
     * param       string $input
     *
     * return      string $output
     */
    if(! function_exists('sanitizer_int'))
    {

        function sanitizer_int($input = '')
        {

            if($input == '')
                return ('GL-019');


            if(substr($input, -2) == ',0' OR substr($input, -2) == '.0')
                $output         = substr($input, 0, strlen($input) - 2);
            else
            if(substr($input, -3) == ',00' OR substr($input, -3) == '.00')
                $output         = substr($input, 0, strlen($input) - 3);
            else
                $output         = $input;


            $output             =  filter_var($output, FILTER_SANITIZE_NUMBER_INT);


            return ($output);

        }

    }


    /**
     * sanitizer_vars()
     *
     * Sanitize each parameters executed in this application
     * Avoid from hijacking & make it safer
     *
     * param       string $input
     *
     * return      string $output
     */
    if(! function_exists('sanitizer_vars'))
    {

        function sanitizer_vars($input = '')
        {

            if (is_array($input))
            {

                foreach($input as $var => $val)
                    $output[$var]   = sanitizer_vars($val);

            }
            else
            {

                if (get_magic_quotes_gpc())
                    $output         =  stripslashes($input);
                else
                    $output         = $input;


                $output             = trim($output);
                $output             =  cleaner_vars($output);
                # $output           = mysql_real_escape_string($output);

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
     * param       string $input $delimiter
     * param       int $length
     *
     * return      string $output
     */
    if(! function_exists('splitter_vars'))
    {

        function splitter_vars($input = '', $length = 4, $delimiter = ' ')
        {

            $split              = str_split($input, $length);
            $output             = implode($delimiter, $split);


            return ($output);

        }

    }


    /**
     * Format uang
     *
     * Change the number of money format
     *
     * @param       int $nominal
     * @return      string
     */
    if(! function_exists('format_uang'))
    {
        function format_uang($nominal)
        {
            return 'RP '.number_format((int) $nominal,0,',','.').' ,-';
        }
    }



    /**
     * Post Curl
     *
     * Send Post curl to destination url
     *
     * @param       string $url
     * @param       array $post_data
     * @return      string
     */
    if(! function_exists('curl_post'))
    {
        function curl_post($url,$post_data,$SSL_VERIFYPEER = TRUE,$debug = FALSE)
        {
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, $SSL_VERIFYPEER);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_data);
            $response = curl_exec($curl_handle);

            if ($debug) {
                var_dump('Error: '.curl_error($curl_handle));
                var_dump('Response: '.$response);exit();
            }
            curl_close($curl_handle);

            return $response;
        }
    }
