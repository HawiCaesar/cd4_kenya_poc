<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class quality extends MY_Controller
{
	public function index()
	{
		$this->quality_control_page();
	}

	function quality_control_page()
	{
		$this->login_reroute(array(3,6,8,9)); //login reroute

		$data['content_view'] = "quality/quality_control_view";
		$data['title'] = "Quality Assurance & Control";

		$data['filter']		=	false;
		//$data['sidebar']	= "poc/sidebar_view";
		$data	=array_merge($data,$this->load_libraries(array('dataTables','quality_assurance','fortawesome')));

		$this->load->model('quality_model'); //load quality model

		//$user_filter = $this->session -> userdata("user_filter");

		/*if($user_filter)
		{ 
			foreach ($user_filter as $filter) 
			{
				//$data['partner_option']='<option value="3">Show All Data For '.$filter["user_filter_name"].'</option>'; 
				$this->set_user_filter($filter["user_filter_id"]);
			} 
		}*/
		// $start=	date('Y-m-d',strtotime('this week'));
		// $stop =  date('Y-m-d');

		// $this -> session -> set_userdata('quality_date_filter_start', $start);			
		// $this -> session -> set_userdata('quality_date_filter_stop', $stop);

		$data['control_count_list']=$this->quality_model->actual_facility_control_tests($this->get_start(),$this->get_stop());
		$data['expected_count_lists']=$this->quality_model->expected_facility_control_test($this->get_start(),$this->get_stop());

		if($data['control_count_list'])
		{
			$data['check_value']=1;
		}
		else
		{
			$data['check_value']=0;
		}

		$data['menus']	= 	$this->quality_model->menus(7);
		$this -> template($data);
	}
	public function quality_date_filter_post(){
		$type 	= 	$this->input->post('type');
		$value 	=	$this->input->post('value');
		$this->quality_date_filter($type,$value);
	}

	 function quality_date_filter($type,$value){		
		$today = date('Y-m-d');

		// echo "ded";
		// die;
		$start;
		$stop;
		$filter_desc;
		$filter_used;
		if($type=="Default"){
			$filter_used ="Default";
			$filter_desc= "This week";
			$period="this week";
			$start	=	date('Y-m-d',strtotime($period));
			$stop	=	$today;
			
		}elseif ($type=="All") {
			$filter_used 	=	"All";
			$year 	=	$this->config->item('starting_year');
			$start	=	date('Y-m-d',strtotime("$year-02-01"));
			$stop	=	$today;
			$filter_desc= "All Results";
		}elseif ($type=="Periodic") {
			$filter_used 	=	"Periodic";
			$year 	=	date('Y');
			$month 	=	date('m');

			$period=0;

			if(!$value || $value==1 || $value==0){
				$period="this week";
			}elseif($value==2){
				$period="last week";
				$period2="this week";
				$filter_desc= "Last Week";
			}
			elseif($value==3){
				$period="-1 months";
				$filter_desc= "The Last 1 Calendar Month";
			}elseif($value==6){
				$period="-2 months";
				$filter_desc= "The Last 2 Calendar Months";
			}	
			if($value==2)
			{
				$start	=	date('Y-m-d',strtotime($period));
				$stop	=	date('Y-m-d',strtotime($period2));
			}else
			{
				$start	=	date('Y-m-d',strtotime($period));
				$stop	=	$today;
			}
			

			
		}elseif ($type=="Custom") {
			$filter_used 	=	"Custom";
			$dates=json_decode($value,true);
			if($dates["from"]){
				$start 	= 	$dates["from"];
				$stop 	= 	$dates["to"];
				$filter_desc= "From $start to $stop";
			}else{
				$this->date_filter("Default",NULL);
			}
		}
		// }elseif ($type=="Yearly") {
		// 	$filter_used 	=	"Yearly";
		// 	if($value>=1990 && $value <= 3000){
		// 		$start	=	date('Y-m-d',strtotime("$value-01-01"));
		// 		$stop	=	date('Y-m-d',strtotime("$value-12-31"));

		// 		$filter_desc= "The Year $value";

		// 		// if($value==$this->get_date_filter_year()){
		// 		// 	$stop= $today;
		// 		// }
		// 	}else{
		// 		$this->date_filter("Default",NULL);
		// 	}
		// }elseif ($type=="Monthly") {
		// 	$filter_used 	=	"Monthly";
		// 	if($value>=1 && $value <= 12){	
		// 		$year 	= 	$this->get_date_filter_year($start);		
		// 		$start	=	date('Y-m-d',strtotime("$year-$value-01"));
		// 		$stop	=	$this->get_last_day_of_month($start);

		// 		$month_desc =	$this->get_month_name($value);
				
		// 		$filter_desc= 	"$month_desc , $year";
		// 	}
		// }

		// echo $start.'<br />';
		// echo $stop;
		// die;
		$this -> session -> set_userdata('quality_filter_used', $filter_used);	
		$this -> session -> set_userdata('quality_date_filter_start', $start);			
		$this -> session -> set_userdata('quality_date_filter_stop', $stop);				
		$this -> session -> set_userdata('quality_filter_desc', $filter_desc);
	}

	function get_start()
	{
		if($this-> session-> userdata('quality_date_filter_start')){
			return date("Y-m-d",strtotime($this-> session-> userdata('quality_date_filter_start')));
		}else{
			return $start =	date('Y-m-d',strtotime('this week'));
		}
	}
	function get_stop()
	{
		if($this-> session-> userdata('quality_date_filter_stop')){
			return date("Y-m-d",strtotime($this-> session-> userdata('quality_date_filter_stop')));
		}else{
			return $stop =  date('Y-m-d');
		}
	}

}


?>