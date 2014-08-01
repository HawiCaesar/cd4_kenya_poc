<?php 

class send_mail_model extends MY_Model{

	function get_partner_email($partner_name)//get the partner email address 
	{
		$sql="SELECT  u.username,u.name,u.email 
						FROM facility f,partner p,partner_user pu, v_facility_pima_details vfp, user u
					 	WHERE vfp.partner_name=p.name
					 	AND f.partnerID=p.ID 
					 	AND p.ID=pu.partner_id
					 	AND pu.user_id=u.id 
					 	AND vfp.partner_name='".$partner_name."' AND u.status='1' GROUP BY u.username ";

	 	$query=$this->db->query($sql);

	 	if($query->num_rows()>0)
	 	{
	 		foreach($query->result_array() as $email)
	 		{
	 			$result[]=$email['email'];
	 		}
	 	}
	 	else if($query->num_rows==0)
	 	{
 			$result='tngugi@clintonhealthaccess.org';//admin email
	 	}

		return $result;		
	}

	function get_county_email($county_id)//get the county coordinator email address 
	{
		$sql="SELECT  u.username,u.name,u.email
						FROM region_user ru,region r,v_facility_pima_details vfp, user u
						WHERE vfp.region_name=r.name
						AND r.id=ru.region_id
						AND ru.user_id=u.id
						AND vfp.region_id='".$county_id."' AND u.status='1' GROUP BY u.username";

		$query=$this->db->query($sql);

	 	if($query->num_rows()>0)
	 	{
	 		foreach($query->result_array() as $email)
	 		{
	 			$result[]=$email['email'];
	 		}
	 	}
	 	else if($query->num_rows==0)
	 	{
 			$result='tngugi@clintonhealthaccess.org';
	 	}

		return $result;

	}

	function uploads_by_facility($from,$to)//get uploads by facility
	{
		$sql	=	"SELECT 
							`pima_upload_id`,
							`upload_date`,
							`result_date`,
							`equipment_serial_number`,
							`facility_name`,
							`uploader_name`,
							COUNT(`pima_test_id`) AS `total_tests`,
							SUM(CASE WHEN `valid`= '1'    THEN 1 ELSE 0 END) AS `valid_tests`,
							SUM(CASE WHEN `valid`= '0'    THEN 1 ELSE 0 END) AS `errors`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`,
							`district_name`,
							`district_id`,
							`region_id`,
							`region_name`,
							`partner_id`,
							`partner_name`
						FROM `v_pima_uploads_details`
						WHERE `result_date` BETWEEN '".$from."' AND '".$to."'
						GROUP BY `facility_name`
						ORDER BY `facility_name` ASC ";
		return $res 	=	R::getAll($sql);

	}
	function uploads_by_county($from,$to)//uploads by county
	{
		$sql	=	"SELECT 
							`pima_upload_id`,
							`upload_date`,
							`equipment_serial_number`,
							`facility_name`,
							`uploader_name`,
							COUNT(`pima_test_id`) AS `total_tests`,
							SUM(CASE WHEN `valid`= '1'    THEN 1 ELSE 0 END) AS `valid_tests`,
							SUM(CASE WHEN `valid`= '0'    THEN 1 ELSE 0 END) AS `errors`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`,
							`district_name`,
							`district_id`,
							`region_id`,
							`region_name`,
							`partner_name`
						FROM `v_pima_uploads_details`
						WHERE `result_date` BETWEEN '".$from."' AND '".$to."'
						GROUP BY `region_name`
						ORDER BY `facility_name` ASC ";
		return $res 	=	R::getAll($sql);
	}
	function uploads_by_partner($from,$to)//uploads by partner
	{
		$sql	=	"SELECT 
							`pima_upload_id`,
							`upload_date`,
							`equipment_serial_number`,
							`facility_name`,
							`uploader_name`,
							COUNT(`pima_test_id`) AS `total_tests`,
							SUM(CASE WHEN `valid`= '1'    THEN 1 ELSE 0 END) AS `valid_tests`,
							SUM(CASE WHEN `valid`= '0'    THEN 1 ELSE 0 END) AS `errors`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`,
							`district_name`,
							`district_id`,
							`region_id`,
							`region_name`,
							`partner_id`,
							`partner_name`
						FROM `v_pima_uploads_details`
						WHERE `result_date` BETWEEN '".$from."' AND '".$to."'
						GROUP BY `partner_name`
						ORDER BY `facility_name` ASC ";
		return $res 	=	R::getAll($sql);
	}

	function tests_less_than500($from,$to,$facility)//tests less than 500
	{
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();
		$i=1;//counter

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th style='width:3%'>#</th>";
		$pdf_data['table'].="<th style='width:10%'>Patient ID</th>";
		$pdf_data['table'].="<th style='width:25%'>Facility</th>";
		$pdf_data['table'].="<th style='width:20%'>Device Serial Number</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th style='width:10%'>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		if($facility!="")//By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility);

			$pdf_count=$this->get_count_test_details($from,$to,$facility);
		}
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td style="width:3%">'.$i.'</td>';
				$pdf_data['table'].='<td style="width:10%">'.$value['sample_code'].'</td>';
				$pdf_data['table'].='<td style="width:25%"><center>'.$value['facility'].'</center></td>';
				$pdf_data['table'].='<td style="width:20%"><center>'.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
				$pdf_data['table'].='<td style="width:10%"><center>'.$value['cd4_count'].'</center></td>';
				$pdf_data['table'].='</tr>';

				$i++;
			}
		}
		else
		{
			$pdf_data['less_than350']=0;
			$pdf_data['count']=0;
		}

		$pdf_data['table'].="</table>";

		if($pdf_count!="")
		{
			foreach($pdf_count as $test_count)
			{
				$pdf_data['less_than350']=$test_count['failed'];
				$pdf_data['count']=$test_count['total_tests'];
			}
		}

		// print_r($pdf_data);
		// die;
		return $pdf_data;	
	}

	public function get_test_details($from,$to,$facility)/*,$device,$all,$county_id)//Get all the data*/
	{
		$sql="SELECT * FROM v_pima_tests_only";
	
		$criteria =" ";

		if(!$facility=="")
		{
			$criteria =" AND facility ='".$facility."' AND cd4_count < 500 AND valid='1' ";
		}
		
		$date_delimiter	=	" WHERE date_test BETWEEN '".$from."' AND '".$to."' ";		

		$test_details=R::getAll($sql.$date_delimiter.$criteria);

		// echo $sql.$date_delimiter.$criteria;

		// die;

		return $test_details;

	}

	public function get_count_test_details($from,$to,$facility)
	{
		$sql_count="SELECT COUNT(test_id) AS total_tests,
						SUM(CASE WHEN valid= '1'    THEN 1 ELSE 0 END) AS valid_tests,
						SUM(CASE WHEN valid= '0'    THEN 1 ELSE 0 END) AS `errors`,
						SUM(CASE WHEN valid= '1'  AND  cd4_count < 500 THEN 1 ELSE 0 END) AS failed,
						SUM(CASE WHEN valid= '1'  AND  cd4_count >= 500 THEN 1 ELSE 0 END) AS passed
						FROM v_pima_tests_only ";	

		if(!$facility=="")
		{
			$criteria =" AND facility='".$facility."' ";
		}
		
		$date_delimiter	=	"  WHERE date_test BETWEEN '".$from."' AND '".$to."' ";		

		$test_details=R::getAll($sql_count.$date_delimiter.$criteria);

		// echo $sql_count.$date_delimiter.$criteria;

		// die;

		return $test_details;
	}
	function weekly_uploads($last_monday,$last_sunday,$county,$partner,$facility,$receipient)//weekly uploads
	{
		$pdf_data=array();
		$total_number_of_records=0;
		$total_tests=0;
		$errors=0;
		$tests_less_than350=0;
		$tests_greater_than350=0;
		$percentage_errors=0;
		$delimiter="";
		$group_by="";

		//cumulative table headings
		$pdf_data['cumulative_table']='<table border="1" align="center" width="880">';
		$pdf_data['cumulative_table'].='<tr>';
		$pdf_data['cumulative_table'].='<th><center># PIMAs Reported</center></th>';
		$pdf_data['cumulative_table'].='<th bgcolor="#000066" style="color:#FFF;"><center>Total Tests</center></th>';
		$pdf_data['cumulative_table'].='<th bgcolor="#eb9316" style="color:#FFF;"><center>Total Tests < 500</center></th>';
		$pdf_data['cumulative_table'].='<th bgcolor="#CC0000" style="color:#FFF;"><center>Total Errors</center></th>';
		//$pdf_data['cumulative_table'].='<th bgcolor="#CC0000" style="color:#FFF;"><center>Errors by %</center></th>';
		$pdf_data['cumulative_table'].='</tr>';

		$pdf_data['breakdown_table']='<table border="1" align="center" width="880">';
		$pdf_data['breakdown_table'].='<tr>';
		$pdf_data['breakdown_table'].='<th><center>#</center></th>';
		$pdf_data['breakdown_table'].='<th><center>Device Serial Number</center></th>';
		$pdf_data['breakdown_table'].='<th><center>Facility</center></th>';
		$pdf_data['breakdown_table'].='<th bgcolor="#000066" style="color:#FFF;width:15%"><center>Total Tests</center></th>';
		$pdf_data['breakdown_table'].='<th bgcolor="#eb9316" style="color:#FFF;width:15%"><center>Tests < 500</center></th>';
		$pdf_data['breakdown_table'].='<th bgcolor="#CC0000" style="color:#FFF;width:15%"><center>Errors</center></th>';
		$pdf_data['breakdown_table'].='</tr>';

		$pdf_data['facility_breakdown']="";

		if(!$county=="")//check if county parameter is set
		{
			$delimiter=" AND `region_name`='".$county."' ";
			$group_by=" `facility_name` ";
			$total_pima_sql="SELECT DISTINCT COUNT(  'serial_number' ) AS total_pimas
								FROM v_facility_pima_details
								WHERE  `region_name`='".$county."'"; 
		}
		if(!$partner=="")//check if partner parameter is set
		{
			$delimiter=" AND `partner_name`='".$partner."' ";
			$group_by=" `facility_name` ";
			$total_pima_sql="SELECT DISTINCT COUNT(  'serial_number' ) AS total_pimas
								FROM v_facility_pima_details
								WHERE  `partner_name`='".$partner."'";
		}
		if(!$facility=="")//check if facility parameter is set
		{
			$delimiter=" ";
			$group_by=" `facility_name` ";
			$total_pima_sql="SELECT COUNT(  'facility_id' ) AS total_pimas
								FROM facility_equipment";
		}
		$sql	=	"SELECT 
							`pima_upload_id`,
							`upload_date`,
							`equipment_serial_number`,
							`facility_name`,
							`uploader_name`,
							`district_id`,
							`district_name`,
							`region_id`,
							`region_name`,
							`partner_name`,
							COUNT(`pima_test_id`) AS `total_tests`,
							SUM(CASE WHEN `valid`= '1'    THEN 1 ELSE 0 END) AS `valid_tests`,
							SUM(CASE WHEN `valid`= '0'    THEN 1 ELSE 0 END) AS `errors`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`,
							`district_name`,
							`district_id`,
							`region_id`,
							`region_name`,
							`partner_name`
						FROM `v_pima_uploads_details`
						WHERE `result_date` BETWEEN '".$last_monday."' AND '".$last_sunday."' ".$delimiter."
						GROUP BY ".$group_by."
						ORDER BY `facility_name` ASC";
		
		$query=$this->db->query($sql);

		if($query->num_rows()>0)
		{
			$total_number_of_records=$query->num_rows();
			$i=1;
			foreach($query->result_array() as $value)
			{
				if($value['facility_name']==NULL || $value['equipment_serial_number']==NULL)
				{
					//should i still pick these results despite them having no facility and equipment?
				}
				else
				{
					$total_tests+=$value['total_tests'];
					//$tests_greater_than350+=$value['passed'];
					$tests_less_than350+=$value['failed'];
					$errors+=$value['errors'];

					
				}
			}
			//$percentage_errors=round(($errors/$total_tests)*100,1);

			$total_pima_query=$this->db->query($total_pima_sql);

			foreach($total_pima_query->result() as $value)
			{
				$total_pimas=$value->total_pimas;
			}
			//cumulative table data
			$pdf_data['cumulative_table'].='<tr>';
			$pdf_data['cumulative_table'].='<td><center>'.$total_number_of_records.' / '.$total_pimas.'</center></td>';
			$pdf_data['cumulative_table'].='<td><center>'.$total_tests.'</center></td>';
			$pdf_data['cumulative_table'].='<td><center>'.$tests_less_than350.'</center></td>';
			$pdf_data['cumulative_table'].='<td><center>'.$errors.'</center></td>';
			//$pdf_data['cumulative_table'].='<td><center>'.$percentage_errors.'</center></td>';
			$pdf_data['cumulative_table'].='</tr></table>';

			foreach($query->result_array() as $value)
			{
				if($value['facility_name']==NULL || $value['equipment_serial_number']==NULL)
				{
					//should i still pick these results despite them having no facility and equipment?
				}
				else
				{
					//break down table
					$pdf_data['breakdown_table'].='<tr>';
					$pdf_data['breakdown_table'].='<td><center>'.$i.'</center></td>';
					$pdf_data['breakdown_table'].='<td><center>'.$value['equipment_serial_number'].'</center></td>';
					$pdf_data['breakdown_table'].='<td><center>'.$value['facility_name'].'</center></td>';
					$pdf_data['breakdown_table'].='<td><center>'.$value['total_tests'].'</center></td>';
					$pdf_data['breakdown_table'].='<td><center>'.$value['failed'].'</center></td>';
					$pdf_data['breakdown_table'].='<td><center>'.$value['errors'].'</center></td>';
					$pdf_data['breakdown_table'].='</tr>';

					$i++;
				}
			}
			$pdf_data['breakdown_table'].='</table>';

			if($receipient=="breakdown")
			{
				foreach($query->result_array() as $value)
				{
					if($value['facility_name']==NULL || $value['equipment_serial_number']==NULL)
					{
						//should i still pick these results despite them having no facility and equipment?
					}
					else
					{

						$facility_results=$this->tests_less_than500($last_monday,$last_sunday,$value['facility_name']);

						$pdf_data['facility_breakdown'].=$facility_results['table'].'<br />';
					}
				}

			}

		}
		else
		{
			//no records code here
		}

	return $pdf_data;
	}
	

}

?>