<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->data['css_admin'] = $this->config->item('css_admin_patch');
        $this->data['js_admin'] = $this->config->item('js_admin_patch');
    }
	public function index(){
        // get user
        $user = $this->admin_model->get_where_data('f_cms_user', array('ID' => $this->session->userdata('userId')));
        // set user level
        $level = $this->admin_model->get_where_data('f_cms_level', array(
                'ID' => $user[0]['LEVEL'],
            ));

        $this->data['user_level'] = $level[0]['LEVELNAME'];
        // $this->debug($this->menuSidebar());
		$this->data['content_page'] = 'admin/pages/dashboard';
		$this->data['title_page'] = 'Dashboard';
        $this->data['menuListData'] = $this->menuSidebar();
		$this->load->view('admin/layout', $this->data);
	}
}
