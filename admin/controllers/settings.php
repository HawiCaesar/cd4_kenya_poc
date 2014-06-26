<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class settings extends MY_Controller {

	public function index(){

		$this->home_page();
	}

	public function home_page() {
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/settings_view";
		$data['title'] = "Settings";
		$data['sidebar']	= "admin/sidebar_view";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array()));
		
		$this->load->model('admin_model');

		$data['menus']	= 	$this->admin_model->menus(7);
		$this -> template($data);
	}
}
/* End of file settings.php */
/* Location: ./application/modules/admin/controller/settings.php */