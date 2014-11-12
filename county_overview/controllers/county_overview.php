<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class county_overview extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('county_model');
	}

	public function index(){
		$this->home_page();
	}

	public function home_page() {

		$data['content_view'] = "county_overview/kenyan_map";
		$data['title'] = "Poc Overview";

		$data['filter']	=	true;
		$data	=array_merge($data,$this->load_libraries(array('poc','county_home','FusionCharts','dataTables'/*,'highcharts','highmaps'*/)));
		
		$data['counties_results']=$this->county_model->county_table_breakdown($this->get_filter_start_date(),$this->get_filter_stop_date());

		$data['menus']	= 	$this->county_model->menus(2);
		$this -> template($data);

	}

	/* This is the Kenayan Maps */
	public function get_json_map_data(){
		//$this->load->model('county_model');
		echo $this->county_model->home_map_data($this->get_filter_start_date(),$this->get_filter_stop_date());
	}
	/* This function is to get the actual device serial numbers together with their facilities that are not reporting */

	
}