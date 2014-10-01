<?php

class reports_charts_sql_model extends CI_Model
{
		
	function get_test_details($facility,$device,$all,$county_id,$limit,$limit_end,$year,$year_end,$report_type,$custom)//Get all the data
	{
		$this->config->load('sql');

		$sql= $this->config->item("preset_sql");
	
		$user_delimiter = "";
		$criteria =" ";
		$tests_sql ="";
		
		$tests_sql= $sql["pima_chart_details"];

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
		else if($all==5)// all data
		{
			$criteria =" AND 1 ";
			$user_delimiter = " AND 1 ";
		}
		else if($all==4)// by county
		{
			$criteria =" AND `r`.`id`= '".$county_id."' ";
		}
		if($custom==0)// if customized dates are not chosen
		{
			$delimiter=" AND MONTH( `tst`.`result_date` ) 
					BETWEEN  '$limit'
					AND  '$limit_end'
					AND YEAR( `tst`.`result_date` ) BETWEEN '".$year."' AND '".$year_end."'
					GROUP BY mth ";	
		}
		else if($custom==1)// if customized dates are chosen
		{
			$delimiter=" AND `tst`.`result_date` BETWEEN '".$limit."' AND  '".$limit_end."' GROUP BY mth ";	
		}
		
		$test_details=R::getAll($tests_sql.$user_delimiter.$criteria.$report_type.$delimiter);

		// echo $tests_sql.$user_delimiter.$criteria.$report_type.$delimiter;

		// die;
		return $test_details;
	}
}//End of reports_charts_sql_model
?>