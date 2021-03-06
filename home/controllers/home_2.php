<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class home_2 extends MY_Controller {

	public function index(){
		$this->home_page();
	}

	public function home_page() {
	//	$this->login_reroute(array(3,6,8,9));
		$data['content_view'] = "home/overview_page_2";
		$data['title'] = "Poc Overview";

		$data['filter']	=	true;
		$data	=array_merge($data,$this->load_libraries(array('poc','home','FusionCharts','dataTables','highcharts','highmaps')));

		$this->load->model('overview_model_1');			
		$data['pima_statistics']= $this->overview_model_1->pima_statistics($this->get_filter_start_date(),$this->get_filter_stop_date());
		
		$resultant_graph = array();
		$resultant_pie_chart=array();

		$categories=array();

		$series_tests = array();
		$series_tests['name'] = 'Valid Tests';
		$series_tests['color']='#006600';
		
		$series_errors = array();
		$series_errors['name'] = 'Errors';
		$series_errors['color']='#FF0000';

		$categories=$this->overview_model_1->month_categories();
		$valid_results=$this->overview_model_1->yearly_pima_result_trend($this->get_date_filter_year());
		$error_results=$this->overview_model_1->yearly_pima_errors_trend($this->get_date_filter_year());

		$series_tests['data']=$valid_results['valid'];
		$series_errors['data']=$error_results['errors'];

		array_push($resultant_graph,$series_tests);
		array_push($resultant_graph,$series_errors);

		$percenatge_tests_and_errors=array();
		$percenatge_tests_and_errors['type']='pie';
		$percenatge_tests_and_errors['name']='Value';

		$tests_and_errors=$this->overview_model_1->periodic_test_error_perc($this->get_filter_start_date(),$this->get_filter_stop_date());

		$key=0;

		$array1[$key]['name']='Successful';
		$array1[$key]['y']=(int)$tests_and_errors['test_total'];
		$array1[$key]['color']='#006600';

		$array1[$key+1]['name']='Errors';
		$array1[$key+1]['y']=(int)$tests_and_errors['error_total'];
		$array1[$key+1]['color']='#FF0000';		

		$percenatge_tests_and_errors['data']=$array1;

		array_push($resultant_pie_chart,$percenatge_tests_and_errors);

				
				//echo json_encode($categories);die;


		// $error_categories=array();
		// $error_bar_graph=array();

		$error_results=$this->overview_model_1->periodic_facility_pima_errors($this->get_filter_start_date(),$this->get_filter_stop_date());

		// echo "<pre>";
		// 		echo json_encode($error_results);
		// 		echo "</pre>";die;

		$data['error_data']=$error_results;
		$data['cd4_tests_graph']=$resultant_graph;
		$data['tests_errors_pie_chart']=$resultant_pie_chart;
		$data['categories']=$categories;

		$data['menus']	= 	$this->overview_model_1->menus(1);
		$this -> template($data);
	}

	/* This is the Kenayan Maps */
	public function get_json_map_data(){
		$this->load->model('overview_model_1');
		echo $this->overview_model_1->home_map_data($this->get_filter_start_date(),$this->get_filter_stop_date());

	}
	/* Progress bar functions */
	public function national_progress_bar_reported()
	{
		$this->load->model('overview_model_1');
		echo $this->overview_model_1->national_view_progress_bar_reported($this->get_filter_start_date(),$this->get_filter_stop_date());
	}
	public function national_progress_bar_not_reported()
	{
		$this->load->model('overview_model_1');
		echo $this->overview_model_1->national_view_progress_bar_not_reported($this->get_filter_start_date(),$this->get_filter_stop_date());
	}

	/* Counties not reporting */
	public function national_breakdown_not_reported()
	{
		$this->load->model('overview_model_1');
		echo $this->overview_model_1->national_view_breakdown_not_reported($this->get_filter_start_date(),$this->get_filter_stop_date());
	}
	
}