<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class facilities extends MY_Controller {

	public function index(){

		$this->home_page();
	}

	public function home_page() {
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/facilities_view";
		$data['title'] = "Facilities";
		$data['sidebar']	= "admin/sidebar_view";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('dataTables','admin_facilities')));
		
		$this->load->model('admin_model');

		$data['menus']	= 	$this->admin_model->menus(2);
		$data['facilities'] = 	$this->admin_model->get_details("facility_details",$this->session->userdata("user_filter_used"));
		$this -> template($data);
	}
}
/* End of file facilities.php */
/* Location: ./application/modules/admin/controller/facilities.php */