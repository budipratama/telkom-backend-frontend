<?php
class Admin_model extends CI_Model{
    public function __construct(){
        parent::__construct();

        define('T_CUST', 'f_customer');

        // loader
        $this->load->library('upload');
    }

  	function get_all_data($tabel_name){
        $query = $this->db->get($tabel_name);
        return $query->result_array();
  	}

    public function get_user_all_level()
    {
        // get except roor
        return $this->db->where('LEVELNAME !=', 'root')
            ->get('f_cms_level')
            ->result_array();
    }

  	function get_where_data($tabel_name, $where, $orderBy = ''){
        $query = $this->db->get_where($tabel_name, $where);
        if($orderBy != ''){
          $query = $this->db->order_by($orderBy, 'ASC')->get_where($tabel_name, $where);
        }
        $result = $query->result_array();
        return $result;
  	}
    function get_all_data_order_by($table_name, $orderBy){
        $query = $this->db->order_by('id', $orderBy)->get($table_name);
        return $query->result_array();
    }
    function get_customer_where($where){
        $query = $this->db->get_where(T_CUST, $where);
        $result = $query->result_array();
        return $result;
    }
    public function get_customer($custId){
        $result = $this->db->where('ID', $custId)
            ->or_where('CUSTCODE', $custId)
            ->get(T_CUST)
            ->result_array();
        return $result;
    }

    public function get_merchant_detail($where){
        return $this->db->select('
                    C.*, P.NAMA_PROVINSI, K.NAMA_KABUPATEN,
                    CP.NAMA_PROVINSI as NAMA_PROVINSI_COMPANY,
                    CK.NAMA_KABUPATEN as NAMA_KABUPATEN_COMPANY
                ')
            ->from(T_CUST.' as C')
            ->join('f_provinsi as P','P.ID_PROVINSI = C.PROVINCEID', 'left')
            ->join('f_kabkota as K','K.ID_KABUPATEN = C.CITYID', 'left')
            // company
            ->join('f_provinsi as CP','P.ID_PROVINSI = C.COMPANYPROVINCE', 'left')
            ->join('f_kabkota as CK','K.ID_KABUPATEN = C.COMPANYCITY', 'left')
            ->where($where)
            ->where('C.CUSTTYPEID',3)
            ->get()
            ->result_array();
    }

    public function get_request_upgrade_detail($where){
        $data = $this->db->select('
                    C.*, P.NAMA_PROVINSI, K.NAMA_KABUPATEN,
                    CP.NAMA_PROVINSI as NAMA_PROVINSI_COMPANY,
                    CK.NAMA_KABUPATEN as NAMA_KABUPATEN_COMPANY,
                    CL.LEVEL_NAME,
                    CU.IDENTITYTYPE as CU_IDENTITYTYPE,
                    CU.IDENTITYCODE as CU_IDENTITYCODE,
                ')
            ->from(T_CUST.' as C')
            ->join('f_provinsi as P','P.ID_PROVINSI = C.PROVINCEID', 'left')
            ->join('f_kabkota as K','K.ID_KABUPATEN = C.CITYID', 'left')
            // upgrade
            ->join('f_cust_upgrade as CU','CU.CUSTCODE = C.CUSTCODE', 'left')
            // level
            ->join('f_cust_level as CL','CL.CUST_TYPE_ID = C.CUSTTYPEID', 'left')
            // company
            ->join('f_provinsi as CP','P.ID_PROVINSI = C.COMPANYPROVINCE', 'left')
            ->join('f_kabkota as CK','K.ID_KABUPATEN = C.COMPANYCITY', 'left')
            ->where($where)
            ->where_in('C.CUSTTYPEID',array(1,2))
            ->get()
            ->result_array();

        return $data;
    }

    function get_cust_type_where($where){
        $query = $this->db->get_where('f_cust_level', $where);
        $result = $query->result_array();
        return $result;
    }
    function updateDbMerchant($postData){
        $this->db->where('ID', $postData['custId']);
        $this->db->update(T_CUST, array('REMARKS' => $postData['remarks'], 'CUSTTYPEID' => $postData['custType']));
        $result = TRUE;
        return $result;
    }

    public function setMerchantApproval($custId,$params){
        // set default params
        $params = array_merge(array(
                'status' => NULL,
                'remarks' => NULL,
            ), $params);

        return $this->db->where('ID',$custId)
            ->update(T_CUST, array(
                    'STATUS' => $params['status'],
                    'REMARKS' => $params['remarks'],
                ));
    }

    function updateDb($tabel_name, $where, $postData){
        $this->db->where($where);
        $this->db->update($tabel_name, $postData);
        $result = TRUE;
        return $result;
    }
    function getLastCustCode(){
        $this->db->select_max('CUSTCODE');
        $query = $this->db->get(T_CUST);
        $result = $query->row_array();
        return $result;
    }
    function addDbRegistration($arrayData){
        $this->db->insert(T_CUST, $arrayData);
        return $this->db->insert_id();
    }

    public function registerUser($arrayData){
        $status = $this->db->insert(T_CUST, $arrayData);
        $insert_id = $this->db->insert_id();

        return array(
                'status' => $status,
                'insert_id' => $insert_id,
            );
    }

    function addDb($tabel_name, $postData){
        $this->db->insert($tabel_name, $postData);
        return $this->db->insert_id();
    }
    function delete_where($tabel_name, $where){
        $query = $this->db->delete($tabel_name, $where);
        return $query;
    }
    function get_cust_req_upgrade(){
        $this->db->select("f_customer.*,f_customer.EMAIL as EMAIL, f_cust_upgrade.CUSTCODE");
        $this->db->from("f_cust_upgrade");
        $this->db->join("f_customer", "f_cust_upgrade.CUSTCODE = f_customer.CUSTCODE", "LEFT");
        $this->db->where("f_cust_upgrade.USED", 0);
        $this->db->where("f_cust_upgrade.CUSTTYPEID", 2);
        $this->db->where("f_customer.CUSTTYPEID", 1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    function get_all_tarif_body(){
        $this->db->select("f_fee_body.*, f_fee_header.FH_NAME as FH_NAME, f_product.PRD_NAME as PRD_NAME, "
                          ."f_product_value.PRD_VALUE as PRD_VALUE, f_fee_refcode.REF_CODE as REF_CODE, "
                          ."f_fee_type.FT_NAME as FT_NAME");
//                . "f_fee_divide.FD_ID as FD_ID,"
//                          ."f_fee_divide.FD_VALUE as FD_VALUE, f_fee_divide.FD_TYPE as FD_TYPE, "
//                          . "f_fee_divide.FD_SOURCE_PAY as FD_SOURCE_PAY, f_fee_flow.FF_NAME as FF_NAME");
        $this->db->from("f_fee_body");
        $this->db->join("f_fee_header", "f_fee_header.FH_ID = f_fee_body.FH_ID", "LEFT");
        $this->db->join("f_product", "f_product.PRD_ID = f_fee_body.PRD_ID", "LEFT");
        $this->db->join("f_product_value", "f_product_value.ID = f_fee_body.PRD_VAL_ID", "LEFT");
        $this->db->join("f_fee_refcode", "f_fee_refcode.REF_ID = f_fee_body.REF_ID", "LEFT");
        $this->db->join("f_fee_type", "f_fee_type.FT_ID = f_fee_body.FT_ID", "LEFT");
//        $this->db->join("f_fee_divide", "f_fee_divide.FB_ID = f_fee_body.FB_ID", "LEFT");
//        $this->db->join("f_fee_flow", "f_fee_divide.FF_ID = f_fee_flow.FF_ID", "LEFT");
//        $this->db->where("f_fee_body.FB_STATUS", 1);
        $result = $this->db->get()->result_array();
        return $result;
    }

    function getReportRange($trxCode, $dateFrom, $dateTo, $additional = array()){

        $this->db->select("f_trx_logheader.*");
        $this->db->from("f_trx_logheader");
        $this->db->where('f_trx_logheader.RCVTIME >=', $dateFrom);
        $this->db->where('f_trx_logheader.RCVTIME <=', $dateTo);

        // filter code
        if ($trxCode != 'all') {
            $this->db->where('f_trx_logheader.TRXCODE =', $trxCode);
        }

        // filter tahapan
        if (isset( $additional['tahapan'] ) && ($tahapan = $additional['tahapan']) != 'all') {
            $tahapan = ($tahapan == 'complete') ? 0 : 1;

            $this->db->where('f_trx_logheader.LASTSTATE', $tahapan);
        }

        $result_array = $this->db->get()->result_array();

        return $result_array;

    }

    function getReportSearch($search_based, $search_term){
        // set search based
        switch ($search_based) {
            case 'syslog':
                $this->db->like('TL.SYSLOGNO', $search_term);
                break;
            case 'email':
                $this->db->like('C.EMAIL', $search_term);
                break;
        }

        $this->db->select("TL.*")
            ->from("f_trx_logheader as TL")
            ->join('f_customer as C', 'C.CUSTCODE = TL.CUSTCODE', 'left');

        $result_array = $this->db->get()->result_array();
        return $result_array;

    }

    function get_all_tarif_divide(){
        $this->db->select("f_fee_divide.*, f_fee_body.FB_ID, f_fee_header.FH_NAME as FH_NAME, f_product.PRD_NAME as PRD_NAME, "
                          ."f_product_value.PRD_VALUE as PRD_VALUE, f_fee_refcode.REF_CODE as REF_CODE, "
                          ."f_fee_type.FT_NAME as FT_NAME, f_fee_flow.FF_NAME as FF_NAME");
        $this->db->from("f_fee_divide");
        $this->db->join("f_fee_body", "f_fee_body.FB_ID = f_fee_divide.FB_ID", "LEFT");
        $this->db->join("f_fee_header", "f_fee_header.FH_ID = f_fee_body.FH_ID", "LEFT");
        $this->db->join("f_product", "f_product.PRD_ID = f_fee_body.PRD_ID", "LEFT");
        $this->db->join("f_product_value", "f_product_value.ID = f_fee_body.PRD_VAL_ID", "LEFT");
        $this->db->join("f_fee_refcode", "f_fee_refcode.REF_ID = f_fee_body.REF_ID", "LEFT");
        $this->db->join("f_fee_type", "f_fee_type.FT_ID = f_fee_body.FT_ID", "LEFT");
        $this->db->join("f_fee_flow", "f_fee_flow.FF_ID = f_fee_divide.FF_ID", "LEFT");
//        $this->db->where("f_fee_body.FB_STATUS", 1);
        $result = $this->db->get()->result_array();
        return $result;
    }

    function get_customer_where_in($where,$in){
        return $this->db->where_in($where,$in)
            ->get(T_CUST)
            ->result_array();
    }

    public function update_customer($id,$data){
        return $this->db->where('ID',$id)->update(T_CUST,$data);
    }

    public function update_cust_upgrade($upgradeCode, $status){
        // update status
        return $this->db->where('CUSTCODE', $upgradeCode)
            ->update('f_cust_upgrade', array(
                    'USED' => $status,
                ));
    }

    public function search_customer($params){
        // set default params
        $params = array_merge(array(
                'search_based' => NULL,
                'masukan_pencarian' => NULL,
            ), $params);

        // set false
        if(is_null($params['search_based']) && empty($params['search_based']))
            return array();
        if(is_null($params['masukan_pencarian']) && empty($params['masukan_pencarian']))
            return array();

        // set search based
        switch ($params['search_based']) {
            case 'email':
                $this->db->like('EMAIL', $params['masukan_pencarian']);
                break;
            case 'nama':
                $this->db->like('CUSTNAME', $params['masukan_pencarian']);
                break;

            default:
                return array();
                break;
        }

        // get data
        $customers = $this->db->select('
                    c.ID as cust_id,
                    c.CUSTNAME as cust_name, c.EMAIL as cust_email,
                    c.PASSFAILEDCOUNT as login_failed,
                    c.CUSTCODE as cust_code,
                    cl.LEVEL_NAME as cust_type,
                    c.STATUS as cust_status,
                    c.CREATEDON as registered_date
                ')
            ->from(sprintf('%s as c', T_CUST))
            ->join('f_cust_level as cl', 'cl.CUST_TYPE_ID = c.CUSTTYPEID')
            ->where_in('c.CUSTTYPEID', array(1,2))
            ->get()
            ->result_array();

        return $customers;
    }

    public function set_block($cust_id, $blockStatus){
        // set block
        if ((int) $blockStatus === 1) {
            $pass_failed_count = 3;
        }
        else $pass_failed_count = 0;

        return $this->db->where('ID', $cust_id)
            ->update(T_CUST, array(
                    'PASSFAILEDCOUNT' => $pass_failed_count,
                ));
    }

    public function addRegistrationApi($postData){
        // set gold data
        $register_data = array(
            'accType' => $postData['accType'],
            'fullName' => $postData['custName'],
            'userName'=>$postData['custEmail'],
            'password'=>$postData['custPassword'],
            'PIN'=>$postData['custPIN'],
            'phoneNo'=>$postData['custPhone'],
            'terminal'=>'WEB-TMONEY',
        );

        // set platinum data
        if($postData['accType'] == 2){
            $register_data = array_merge($register_data, array(
                    'province'=>$postData['custProv'],
                    'cityName'=>$postData['custCity'],
                    'address'=>$postData['custAddress'],
                    'idType'=>$postData['custIdenType'],
                    'idCitizen'=>$postData['custIdenNo']
                ));
        }
        // set platinum data
        elseif($postData['accType'] == 3){
            $register_data = array_merge($register_data, array(
                    'province'=>$postData['custProv'],
                    'cityName'=>$postData['custCity'],
                    'address'=>$postData['custAddress'],
                    'idType'=>$postData['custIdenType'],
                    'idCitizen'=>$postData['custIdenNo'],
                    'businessLicense'=>$postData['custNoNpwp'],
                    'businessType'=>$postData['custJenisUsaha'],
                    'businessName'=>$postData['custNamaUsaha'],
                    'businessProvince'=>$postData['custProvUsaha'],
                    'businessCity'=>$postData['custCityUsaha'],
                    'businessAddress'=>$postData['custAddressUsaha'],
                    'bankCode'=>$postData['custBankCode'],
                    'bankAccount'=>$postData['custBankAccount'],
                    'transactionUrl'=>$postData['custUrlUsaha']
                ));
        }

        // register to API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, TMONEY_API);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $register_data);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        // var_dump($response, $register_data, $error);exit();

        // set response
        $response = json_decode($response, TRUE);
        if (! is_null($response) && $response !== FALSE) {
            $response = array_merge($response, array(
                    'password' => $postData['custPassword'],
                    'pin' => $postData['custPIN'],
                ));
        }

        if(! $response) $response['resultDesc'] = $error;

        return $response;
    }

    public function checkDuplicatePhoneNumber($phone){
        $phone = $this->get_customer_where(array('CUSTPHONE' => $phone));
        if($phone){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function checkEmail($email){
        $url = 'https://prodapi-app.tmoney.co.id/api/email-check';
        $data = array('userName' => $email, 'terminal' => 'WEB-TMONEY');
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */
            return FALSE;
        }else{
            $res = json_decode($result);

            if($res->resultCode == 188){
                return TRUE;
            }else if($res->resultCode == 187){
                return FALSE;
            }
        }
    }

    public function get_all_group_fee()
    {
        return $this->db->get('f_fee_header')->result_array();
    }

    public function next_cust_type_id()
    {
        $level = $this->db->select('MAX(CUST_TYPE_ID) as CUST_TYPE_ID')
            ->from('f_cust_level')
            ->get()
            ->row_array();

        return (isset($level['CUST_TYPE_ID'])) ? $level['CUST_TYPE_ID'] + 1 : 1;
    }

    public function level_acl_exists($level_id)
    {
        $exists = $this->db->where('LEVELID', $level_id)
            ->get('f_cust_level_acl')
            ->num_rows();

        return ($exists > 0) ? TRUE : FALSE;
    }

    public function get_all_products()
    {
        return $this->db->select('*')
            ->from('f_product as p')
            ->join('f_product_group as pg','pg.GROUP_ID = p.PRD_GROUP')
            ->join('f_product_type as pt','pt.TYPE_ID = pg.TYPE_ID')
            ->order_by('p.PRD_ORDER','asc')
            ->get()
            ->result_array();
    }

    public function get_product($where)
    {
        return $this->db->select('*')
            ->from('f_product as p')
            ->join('f_product_group as pg','pg.GROUP_ID = p.PRD_GROUP')
            ->join('f_product_type as pt','pt.TYPE_ID = pg.TYPE_ID')
            ->where($where)
            ->get()
            ->result_array();
    }

    public function update_product_order($prdId, $prdOrder)
    {
        // get current product order
        $current_order = $this->db->where('PRD_ID', $prdId)
            ->get('f_product')->row_array();
        if(! $current_order) return FALSE;

        // is the setted order exists
        $setted_order = $this->db->where('PRD_ORDER', $prdOrder)
            ->get('f_product')->num_rows();

        // var_dump($current_order, $setted_order, $prdOrder, ($setted_order > 0 && $current_order['PRD_ORDER'] != $prdOrder));exit();

        // switch order
        if($setted_order > 0 && $current_order['PRD_ORDER'] != $prdOrder)
        {
            // target change
            $upd_target = $this->db->where('PRD_ORDER', $prdOrder)
                ->update('f_product', array(
                        'PRD_ORDER' => $current_order['PRD_ORDER'],
                    ));
            if(! $upd_target) return FALSE;

            // current
            $upd_current = $this->db->where('PRD_ID', $prdId)
                ->update('f_product', array(
                        'PRD_ORDER' => $prdOrder,
                    ));
            if(! $upd_current) return FALSE;

            return TRUE;
        }
        else
        {
            // current
            return $this->db->where('PRD_ID', $prdId)
                ->update('f_product', array(
                        'PRD_ORDER' => $prdOrder,
                    ));
        }
    }

    public function get_all_operator()
    {
        return $this->db->order_by('CREATED_ON', 'desc')
            ->get('f_operator')->result();
    }

    public function get_operator($id)
    {
        $operator = $this->db->where('OP_ID', $id)
            ->get('f_operator')->row();

        return $operator;
    }

    public function create_operator($arg)
    {
        // set date
        $arg['CREATED_ON'] = date('Y-m-d H:i:s');

        // set logo
        list($status, $result) = $this->upload_image('logo', PATH_OPERATOR_LOGO, 'operator-logo');
        if($status === FALSE) return $result;
        if(! is_null($result)) $arg['OP_LOGO'] = $result;

        $create = $this->db->insert('f_operator', $arg);

        return $create;
    }

    public function update_operator($id, $arg)
    {
        // set date
        $arg['UPDATED_ON'] = date('Y-m-d H:i:s');

        // set logo
        list($status, $result) = $this->upload_image('logo', PATH_OPERATOR_LOGO, 'operator-logo');
        if($status === FALSE) return $result;
        if(! is_null($result)) $arg['OP_LOGO'] = $result;

        $update = $this->db->where('OP_ID', $id)
            ->update('f_operator', $arg);

        return $update;
    }

    public function get_product_by_prd_type($type)
    {
        $product = $this->db->select('p.*')
            ->from('f_product as p')
            ->join('f_product_group as pg', 'pg.GROUP_ID = p.PRD_GROUP')
            ->join('f_product_type as pt', 'pt.TYPE_ID = pg.TYPE_ID')
            ->where('pt.TYPE_NAME', $type)
            ->get()->result_array();

        return $product;
    }

    protected function upload_image($name, $path, $prefix = 'image')
    {
        // set upload
        if(! empty($_FILES[$name]['name'])){
            // set file name
            $file_name = $prefix.'-'.time();

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'jpg|jpeg|png',
                'max_size' => '10000',
                'max_width' => '2048',
                'max_height' => '1536',
                'file_name' => $file_name,
            ));

            // upload
            if(! $this->upload->do_upload($name))
            {
                $error = $this->upload->display_errors();

                return array(FALSE, $error);
            }

            // set full file name
            $file_name = $file_name.$this->upload->data('file_ext');

            return array(TRUE, $file_name);
        }

        return array(NULL, NULL);
    }
}
