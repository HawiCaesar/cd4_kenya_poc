<?php 

class cd4_reports extends MY_Controller
{
	function index()
	{
		$this->cd4_reporting_dashboard();
	}

	function cd4_reporting_dashboard()
	{
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/cd4_reporting_view";
		$data['title'] = "CD4 Reports";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('dataTables','admin_cd4_reports','fortawesome'))); //load the dataTables plugin, fortawesome and admin_cd4_reports.js

		$this->load->model('admin_model'); //load admin_model
		$this->load->model('cd4_reports_model');

		$data['menus']	= 	$this->admin_model->menus(6);

		$facility_results = $this->cd4_reports_model->facility_list();
		$poc_facility_list = $this->cd4_reports_model->poc_facility_list();

		if($this->get_start())
		{
			$start=$this->get_start();
			$stop=$this->get_stop();
		}else
		{	
			$start = date('Y-m-d', strtotime("first day of -1 months"));
			$stop = $stop=date('Y-m-d',strtotime('last day of -1 months'));
		}

		$cd4_results = $this->cd4_reports_model->cd4_reporting($start,$stop);
		$cd4poc_results = $this->cd4_reports_model->cd4poc_reporting($start,$stop);

		if(!$cd4_results)
		{
			$data['percentage_cd4_reported']=0;
		}
		else
		{
			$fcdrr_reported=sizeof($cd4_results);
			$all_facilities=sizeof($facility_results);

			$data['percentage_cd4_reported']=floor(($fcdrr_reported/$all_facilities)*100);
		}
		if(!$cd4poc_results)
		{
			$data['percentage_cd4poc_reported']=0;
		}
		else
		{
			foreach($cd4poc_results as $key => $cd4poc)
			{
				if(!$cd4poc['cd4_test_id']==NULL)
				{
					$poc[$cd4poc['poc_name']]=$cd4poc['cd4_test_id'];
				}
			}
			$poc_reported=sizeof($poc);
			$all_poc_facilities=sizeof($poc_facility_list);

			$data['percentage_cd4poc_reported']=floor(($poc_reported/$all_poc_facilities)*100);	
		}
		
		$data['facility_results']=$facility_results;
		$data['poc_facility_list']=$poc_facility_list;

		$data['cd4_results']=$cd4_results;
		$data['cd4poc_results']=$cd4poc_results;

		$this->template($data);//load template and put data on page
	}
	function excel_file()
	{
		$this->load->model('cd4_reports_model'); //load cd4_reports_model

		if($this->get_start())
		{
			$start=$this->get_start();
			$stop=$this->get_stop();
		}else
		{	
			$start = date('Y-m-d', strtotime("first day of -1 months"));
			$stop = $stop=date('Y-m-d',strtotime('last day of -1 months'));
		}

		$PHPExcel[]=$this->cd4_reports_model->excel_file_download($start,$stop);

		$filename="CD4 Reporting_".date('jS F Y',strtotime($start))."-".date('jS F Y',strtotime($stop)).".xlsx";
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');// *can use ms-excel2007
		header('Content-Disposition: attachment;filename="'.$filename.'" ');
		header('Cache-Control: max-age=0');
		$obWrite=PHPExcel_IOFactory::createWriter($this->excel,'Excel2007');
		$obWrite->save('php://output');	
		
	}
 	public function getfacilitiesreportingpima(){
		
		$sql 	= "SELECT * 
							FROM  `v_facility_pima_details` 
							WHERE  `facility_pima_serial_num` !=  '0'";
	    $data=R::getAll($sql);;
		
		return $data;
	    }

	function get_start()
	{
		if($this-> session-> userdata('cd4_start_date')){
			return date("Y-m-d",strtotime($this-> session-> userdata('cd4_start_date')));
		}else{
			
			return 0;
		}
	}
	function get_stop()
	{
		if($this-> session-> userdata('cd4_stop_date')){
			return date("Y-m-d",strtotime($this-> session-> userdata('cd4_stop_date')));
		}else{
			return 0;
		}
	}
	public function cd4poc_date_filter_post(){
		$type 	= 	$this->input->post('type');
		$value 	=	$this->input->post('value');
		$this->cd4_poc_date_filter($type,$value);
	}
	public function cd4_poc_date_filter($type,$value){		
		$today = date('Y-m-d');

		$start;
		$stop;
		$filter_desc;
		$filter_used;
		if($type=="Default"){
			$filter_used ="Default";
			$year 	=	date('Y',strtotime($today));
			$start	=	date('Y-m-d',strtotime("$year-01-01"));
			$stop	=	$today;
			$filter_desc= "this Year";

		}elseif ($type=="All") {
			$filter_used 	=	"All";
			$year 	=	$this->config->item('starting_year');
			$start	=	date('Y-m-d',strtotime("$year-01-01"));
			$stop	=	$today;
			$filter_desc= "All Results";
		}elseif ($type=="Periodic") {
			$filter_used 	=	"Periodic";
			$year 	=	date('Y',strtotime($today));
			$month 	=	date('m',strtotime($today));

			$period=0;

			if(!$value || $value==1 || $value==0){
				$period="-0 months";
				$filter_desc= "This Month";
			}elseif($value==3){
				$period="-2 months";
				$filter_desc= "The Last 3 Calendar Months";
			}elseif($value==6){
				$period="-5 months";
				$filter_desc= "The Last 6 Calendar Months";
			}	

			$start	=	date('Y-m-1',strtotime($period));
			$stop	=	$today;

			
		}elseif ($type=="Custom") {
			$filter_used 	=	"Custom";
			$dates=json_decode($value,true);
			if($dates["from"]){
				$start 	= 	$dates["from"];
				$stop 	= 	$dates["to"];
				$filter_desc= "From $start to $stop";
			}else{
				$this->cd4_poc_date_filter("Default",NULL);
			}
			
		}elseif ($type=="Yearly") {
			$filter_used 	=	"Yearly";
			if($value>=1990 && $value <= 3000){
				$start	=	date('Y-m-d',strtotime("$value-01-01"));
				$stop	=	date('Y-m-d',strtotime("$value-12-31"));

				$filter_desc= "The Year $value";

				// if($value==$this->get_date_filter_year()){
				// 	$stop= $today;
				// }
			}else{
				$this->cd4_poc_date_filter("Default",NULL);
			}
		}elseif ($type=="Monthly") {
			$filter_used 	=	"Monthly";
			if($value>=1 && $value <= 12){	
				$year 	= 	$this->cd4_poc_get_date_filter_year();		
				$start	=	date('Y-m-d',strtotime("$year-$value-01"));
				$stop	=	$this->get_last_day_of_month($start);

				$month_desc =	$this->get_month_name($value);
				
				$filter_desc= 	"$month_desc , $year";
			}
		}

		$this -> session -> set_userdata('cd4_filter_used', $filter_used);	
		$this -> session -> set_userdata('cd4_start_date', $start);			
		$this -> session -> set_userdata('cd4_stop_date', $stop);				
		$this -> session -> set_userdata('cd4_filter_desc', $filter_desc);
	}
	public function cd4_poc_get_date_filter_year(){
		if($this-> session-> userdata('cd4_start_date')){
			return date("Y",strtotime($this-> session-> userdata('cd4_start_date')));
		}else{
			return $today=date('Y');
		}
	}
}//end of cd4_reports.php