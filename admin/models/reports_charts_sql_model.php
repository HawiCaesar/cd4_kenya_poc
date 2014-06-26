<?php

class reports_charts_sql_model extends CI_Model
{
		
	function get_test_details($facility,$device,$all,$county_id,$limit,$limit_end,$year,$year_end,$report_type)//Get all the data
	{
		$this->config->load('sql');

		$sql= $this->config->item("preset_sql");
	
		$user_delimiter = "";
		$criteria =" ";
		$tests_sql ="";
		
		$tests_sql= $sql["pima_chart_details"];

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
			$criteria =" AND `region_id`= '".$county_id."' ";
		}
		
		$delimiter=" AND MONTH( `tst_dt`.`result_date` ) 
					BETWEEN  '$limit'
					AND  '$limit_end'
					AND YEAR( `tst_dt`.`result_date` ) BETWEEN '".$year."' AND '".$year_end."'
					GROUP BY mth ";	

		$test_details=R::getAll($tests_sql.$user_delimiter.$criteria.$report_type.$delimiter);

		// echo $tests_sql.$user_delimiter.$criteria.$report_type.$delimiter;

		// die;

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