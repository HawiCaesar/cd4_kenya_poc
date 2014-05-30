<?php

class reports_charts_sql_model extends CI_Model
{
		
		// Get both
		function get_test_details_both($facility,$device,$all,$limit,$year)//Get all the data
		{
			$this->config->load('sql');

			$sql= $this->config->item("preset_sql");
		
			$user_delimiter = "";
			$criteria =" ";
			$tests_sql ="";
			$report_type= " ";
			
			$tests_sql= $sql["pima_chart_details"];

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");

			if($user_group_id == 3){
				$user_delimiter = " AND `partner_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 9) {
				$user_delimiter = " AND `region_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 8) {
				$user_delimiter = " AND `district_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 6) {
				$user_delimiter = " AND `facility_id` = '".$user_filter_used."' ";
			}

			if(!$facility=="")
			{
				$criteria =" AND  `facility`='".$facility."'";
			}
			if(!$device=="")
			{
				$facility_equipment=$this->get_equipment_id($device);

				foreach ($facility_equipment as $value) 
				{	
					
					$criteria=" AND `tst_dt`.`facility_equipment_id`='".$value['facility_equipment_id']."' ";
				}
			}
			if($all==3)// by partner 
			{
				$criteria =" AND 1 ";
			}
			else if($all==5)// all data
			{
				$criteria =" AND 1 ";
				$user_delimiter = " AND 1 ";
			}
			else if($all==4)// by county
			{
				$criteria =" AND 1 ";
			}
			
			//$date_delimiter	=	" AND `pim_tst`.`result_date` between '".$from."' and '".$to."' ";
			$delimiter="AND MONTH( `pim_tst`.`result_date` ) 
							BETWEEN  '$limit'
							AND  '$limit'
							AND YEAR( `pim_tst`.`result_date` ) =  '".$year."'
							GROUP BY mth ";		

			$test_details=R::getAll($tests_sql.$user_delimiter.$criteria.$report_type.$delimiter);

			/*echo $tests_sql.$user_delimiter.$criteria.$report_type.$delimiter;
	
			die;*/

			return $test_details;

		}

		// Get the tests only 
		function get_test_details_tests_only($facility,$device,$all,$limit,$year)//Get all the data
		{
			$this->config->load('sql');

			$sql= $this->config->item("preset_sql");
		
			$user_delimiter = "";
			$criteria =" ";
			$tests_sql ="";
			$report_type= " AND `tst_dt`.`valid`='1' ";
			
			$tests_sql= $sql["pima_chart_details"];

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");

			if($user_group_id == 3){
				$user_delimiter = " AND `partner_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 9) {
				$user_delimiter = " AND `region_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 8) {
				$user_delimiter = " AND `district_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 6) {
				$user_delimiter = " AND `facility_id` = '".$user_filter_used."' ";
			}

			if(!$facility=="")
			{
				$criteria =" AND  `facility`='".$facility."'";
			}
			if(!$device=="")
			{
				$facility_equipment=$this->get_equipment_id($device);

				foreach ($facility_equipment as $value) 
				{	
					
					$criteria=" AND `tst_dt`.`facility_equipment_id`='".$value['facility_equipment_id']."' ";
				}
			}
			if($all==3)// by partner 
			{
				$criteria =" AND 1 ";
			}
			else if($all==5)// all data
			{
				$criteria =" AND 1 ";
				$user_delimiter = " AND 1 ";
			}
			else if($all==4)// by county
			{
				$criteria =" AND 1 ";
			}
			
			//$date_delimiter	=	" AND `pim_tst`.`result_date` between '".$from."' and '".$to."' ";
			$delimiter="AND MONTH( `pim_tst`.`result_date` ) 
							BETWEEN  '$limit'
							AND  '$limit'
							AND YEAR( `pim_tst`.`result_date` ) =  '".$year."'
							GROUP BY mth ";		

			$test_details=R::getAll($tests_sql.$user_delimiter.$criteria.$report_type.$delimiter);

			/*echo $tests_sql.$user_delimiter.$criteria.$report_type.$delimiter;
	
			die;*/

			return $test_details;

		}

		//Get the errors only 
		function get_test_details_errors_only($facility,$device,$all,$limit,$year)//Get all the data
		{
			$this->config->load('sql');

			$sql= $this->config->item("preset_sql");
		
			$user_delimiter = "";
			$criteria =" ";
			$tests_sql ="";
			$report_type= " AND `tst_dt`.`valid`='0' ";
			
			$tests_sql= $sql["pima_chart_details"];

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");

			if($user_group_id == 3){
				$user_delimiter = " AND `partner_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 9) {
				$user_delimiter = " AND `region_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 8) {
				$user_delimiter = " AND `district_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 6) {
				$user_delimiter = " AND `facility_id` = '".$user_filter_used."' ";
			}

			if(!$facility=="")
			{
				$criteria =" AND  `facility`='".$facility."'";
			}
			if(!$device=="")
			{
				$facility_equipment=$this->get_equipment_id($device);

				foreach ($facility_equipment as $value) 
				{	
					
					$criteria=" AND `tst_dt`.`facility_equipment_id`='".$value['facility_equipment_id']."' ";
				}
			}
			if($all==3)// by partner 
			{
				$criteria =" AND 1 ";
			}
			else if($all==5)// all data
			{
				$criteria =" AND 1 ";
				$user_delimiter = " AND 1 ";
			}
			else if($all==4)// by county
			{
				$criteria =" AND 1 ";
			}
			
			//$date_delimiter	=	" AND `pim_tst`.`result_date` between '".$from."' and '".$to."' ";
			$delimiter="AND MONTH( `pim_tst`.`result_date` ) 
							BETWEEN  '$limit'
							AND  '$limit'
							AND YEAR( `pim_tst`.`result_date` ) =  '".$year."'
							GROUP BY mth ";		

			$test_details=R::getAll($tests_sql.$user_delimiter.$criteria.$report_type.$delimiter);

			/*echo $tests_sql.$user_delimiter.$criteria.$report_type.$delimiter;
	
			die;*/

			return $test_details;

		}
		//Get less than 350
		function get_test_details_less_than350($facility,$device,$all,$limit,$year)//Get all the data
		{
			$this->config->load('sql');

			$sql= $this->config->item("preset_sql");
		
			$user_delimiter = "";
			$criteria =" ";
			$tests_sql ="";
			$report_type= " AND `tst_dt`.`valid`='1' AND `tst_dt`.`cd4_count` < 350  ";
			
			$tests_sql= $sql["pima_chart_details"];

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");

			if($user_group_id == 3){
				$user_delimiter = " AND `partner_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 9) {
				$user_delimiter = " AND `region_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 8) {
				$user_delimiter = " AND `district_id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 6) {
				$user_delimiter = " AND `facility_id` = '".$user_filter_used."' ";
			}

			if($facility!="")
			{
				$criteria =" AND  `facility`='".$facility."'";
			}
			if($device!="")
			{
				$facility_equipment=$this->get_equipment_id($device);

				foreach ($facility_equipment as $value) 
				{	
					
					$criteria=" AND `tst_dt`.`facility_equipment_id`='".$value['facility_equipment_id']."' ";
				}
			}
			if($all==3)// by partner 
			{
				$criteria =" AND 1 ";
			}
			else if($all==5)// all data
			{
				$criteria =" AND 1 ";
				$user_delimiter = " AND 1 ";
			}
			else if($all==4)// by county
			{
				$criteria =" AND 1 ";
			}
			
			//$date_delimiter	=	" AND `pim_tst`.`result_date` between '".$from."' and '".$to."' ";
			$delimiter="AND MONTH( `pim_tst`.`result_date` ) 
							BETWEEN  '$limit'
							AND  '$limit'
							AND YEAR( `pim_tst`.`result_date` ) =  '".$year."'
							GROUP BY mth ";		

			$test_details=R::getAll($tests_sql.$user_delimiter.$criteria.$report_type.$delimiter);

			/*echo $tests_sql.$user_delimiter.$criteria.$report_type.$delimiter;
	
			die;*/

			return $test_details;

		}

		public function get_equipment_id($serial)
		{
			$sql="SELECT facility_equipment_id from facility_pima where serial_num='".$serial."' ";

			$equipment=$this->db->query($sql);

			$result_id="";
			if($equipment->num_rows()>0)
			{
				foreach ($equipment->result_array() as $value) 
				{
					$result_id[]=$value;
				}
			}
			else
			{
				$result_id="";
			}
			return $result_id;
		}



}//End of reports_charts_sql_model


?>