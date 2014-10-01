<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class home extends MY_Controller {

	public function index(){
		$this->home_page();
	}

	public function home_page() {
	//	$this->login_reroute(array(3,6,8,9));
		$data['content_view'] = "home/overview_page";
		$data['title'] = "POC Home";		
		
		$data['filter']	=	true;
		$data	=array_merge($data,$this->load_libraries(array('poc','FusionMaps','FusionCharts','dataTables')));
		
		$this->load->model('overview_model');			
		//$data['devices_tests_totals']= $this->overview_model->devices_tests_totals($this->get_filter_start_date(),$this->get_filter_stop_date(),$this->session->userdata("user_filter_used"));
		$data['pima_statistics']= $this->overview_model->pima_statistics($this->get_filter_start_date(),$this->get_filter_stop_date(),$this->session->userdata("user_filter_used"));
		
		$data['menus']	= 	$this->overview_model->menus(1);
		$this -> template($data);
	}
	public function national_progress_bar_reported()
	{
		$this->load->model('overview_model');
		echo $this->overview_model->national_view_progress_bar_reported($this->get_filter_start_date(),$this->get_filter_stop_date());
	}
	public function national_progress_bar_not_reported()
	{
		$this->load->model('overview_model');
		echo $this->overview_model->national_view_progress_bar_not_reported($this->get_filter_start_date(),$this->get_filter_stop_date());
	}
	public function get_xml_map_data(){
		$this->load->model('overview_model');
		echo $this->overview_model->home_map_data($this->get_filter_start_date(),$this->get_filter_stop_date());

	}
}