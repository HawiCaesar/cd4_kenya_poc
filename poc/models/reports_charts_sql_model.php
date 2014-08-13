<?php

class reports_charts_sql_model extends MY_Model
{
		
		// Get both
		function get_test_details($facility,$device,$all,$county_id,$limit,$limit_end,$year,$year_end,$report_type)//Get all the data
		{
			$this->config->load('sql');

			$sql= $this->config->item("preset_sql");
		
			$user_delimiter = "";
			$criteria =" ";
			$tests_sql ="";
			
			$tests_sql= $sql["pima_chart_details"];

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");

			if($user_group_id == 3){
				$user_delimiter = " AND `p`.`ID` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 9) {
				$user_delimiter = " AND `r`.`id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 8) {
				$user_delimiter = " AND `d`.`id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 6) {
				$user_delimiter = " AND `f`.`id` = '".$user_filter_used."' ";
			}

			if(!$facility=="")
			{
				$criteria =" AND  `f`.`name`='".$facility."'";
			}
			if(!$device=="")
			{
				$criteria=" AND `fp`.`serial_num`='".$device."' ";

			}
			if($all==3)// by partner 
			{
				$criteria =" AND 1 ";
			}
			else if($all==4)// by county
			{
				$criteria =" AND 1 ";
			}
			
			$delimiter=" AND MONTH( `tst`.`result_date` ) 
							BETWEEN  '$limit'
							AND  '$limit_end'
							AND YEAR( `tst`.`result_date` ) BETWEEN '".$year."' AND '".$year_end."'
							GROUP BY mth ";	

			$test_details=R::getAll($tests_sql.$user_delimiter.$criteria.$report_type.$delimiter);

			// echo $tests_sql.$user_delimiter.$criteria.$report_type.$delimiter;
	
			// die;

			return $test_details;

		}
}//End of reports_charts_sql_model


?>