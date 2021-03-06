<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class tests extends MY_Controller {

	public function index(){

		$this->home_page();
	}

	public function home_page() {
		$this->login_reroute(array(3,6,8,9));
		$data['content_view'] = "poc/tests_view";
		$data['title'] = "CD4 Tests";
		$data['sidebar']	= "poc/sidebar_view";
		$data['filter']	=	true;
		$data	= 	array_merge($data,$this->load_libraries(array('dataTables','poc_tests')));
		
		$this->load->model('poc_model');
		$this->load->model('tests_model');

		$data['devices_not_reported'] = $this->poc_model->devices_not_reported();
		
		$data['errors_agg'] = $this->poc_model->errors_reported();

		$data['menus']	= 	$this->poc_model->menus(3);
		$data['tests'] = 	$this->tests_model->get_tests_details($this->get_filter_start_date(),$this->get_filter_stop_date(),"tests_details",$this->session->userdata("user_filter_used"));

		$this -> template($data);
	}
}
/* End of file tests.php */
/* Location: ./application/modules/poc/controller/tests.php */