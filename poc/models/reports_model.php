<?php 

class reports_model extends MY_Model{

/*
	The functions(including some variables) for getting tests <500cp/ml still read tests<350. However the SQL's all fetch tests <500cp/ml
	set by World Health Organization
*/

/*====================================== Partner Functions =========================================================*/
 function getyearsreported()
  {
		/*$sql="SELECT DISTINCT YEAR( pt.result_date ) AS year
						FROM pima_test pt, partner p, partner_user pu
						WHERE p.id = pu.partner_id
						AND pu.user_id = '".$partnerid."' ";*/
		$sql="SELECT DISTINCT YEAR( pt.result_date ) AS year
						FROM pima_test pt ";
						
		$query=$this->db->query($sql);

		if($query->num_rows()>0)
		{
			foreach ($query->result_array() as $value) 
			{
				$res[]=$value;
			}
		}
		else
		{
			$res="No data";
		}
		return $res;
		
			
 }
/*====================================== End Partner Functions ========================================================*/

/*====================================== County Functions =============================================================*/

public function get_county_name($county_id)
{
	$result_county_name="";

	$sql="SELECT c.name 
				FROM county c, region_user r
				WHERE r.region_id = c.id
				AND r.user_id =  '".$county_id."'";
	$query=$this->db->query($sql);

	if($query->num_rows()>0)
	{
		foreach($query->result() as $value)
		{
			$result_county_name=$value->name;
		}
	}else
	{
		//$result_county_name="";
	}
	return $result_county_name;
}

function get_tested_years_by_county($ID)
{
	$sql="SELECT DISTINCT YEAR( cd.result_date ) AS year
				FROM cd4_test cd, facility f, district d, county c, region_user ru
				WHERE cd.facility_id = f.id
				AND f.district = d.id
				AND d.region_id = c.id
				AND ru.region_id = c.id
				AND ru.user_id =  '".$ID."'";
	$query=$this->db->query($sql);
	if($query->num_rows()>0)
	{
		foreach ($query->result_array() as $value) 
			{
				$result_years[]=$value;
			}
		
	}
	else
	{
		$result_years="No years have data";
	}
	return $result_years;
}

/*====================================== End County Functions =========================================================*/

/*...................................... Start of PDF Functions .......................................................*/

	function year_month_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
	{		

		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count

		}

		if($device!="")// By Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
					
		}

		if($all==3 || $all==4)//By Partner or By County
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			}

		}

		if($report_type==1)// Tests Only
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Successful</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;

				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}	
		}
		else if($report_type==2)//Errors Only
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Error</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;		
				}
				
			}else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}
						
		}
		else //Both Tests and Errors
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					if($value['valid']==1)
					{

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Successful</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';

					}
					else
					{

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Error</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';
					}
				$i++;	
				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}											
		}
		$pdf_data['table'].="</table>";

		if($pdf_count!="")
		{
			foreach($pdf_count as $test_count)
			{
				$pdf_data['less_than350']=$test_count['failed'];
				$pdf_data['count']=$test_count['total_tests'];
				$pdf_data['valid_tests']=$test_count['valid_tests'];
				$pdf_data['greater_equal_to350']=$test_count['passed'];
				$pdf_data['errors']=$test_count['errors'];
			}
		}

		// print_r($pdf_data);
		// die;
		return $pdf_data;
	}

	function year_quarter_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
	{
		$tests_done=0;
		$count=0;
		$errors=0;
		$less_than350=0;
		$greater_equal_to350=0;

		$county_name="";

		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";
		$i=1;//counter

		if($facility!="")//Check if a facility was picked
		{	
			$all="";
			$device="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
						
		}

		if($device!="")//Check if a device was picked
		{
			$facility="";
			$all="";
			
			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			
		}

		if($all==3 || $all==4)// Check if Partner or County was picked
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			}
			
		}

		if($report_type==1)// Tests Only
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Successful</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;

				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}	
		}
		else if($report_type==2)//Errors Only
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Error</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;
				}
				
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}
						
		}
		else //Both Tests and Errors
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					if($value['valid']==1)
					{
						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Successful</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';

					}
					else
					{

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Error</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';
					}
				$i++;	
				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}											
		}
		$pdf_data['table'].="</table>";

		if($pdf_count!="")
		{
			foreach($pdf_count as $test_count)
			{
				$pdf_data['less_than350']=$test_count['failed'];
				$pdf_data['count']=$test_count['total_tests'];
				$pdf_data['valid_tests']=$test_count['valid_tests'];
				$pdf_data['greater_equal_to350']=$test_count['passed'];
				$pdf_data['errors']=$test_count['errors'];
			}
		}

		// print_r($pdf_data);
		// die;
		return $pdf_data;	
	}

	function year_biannual_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
	{

		$county_name="";

		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")// By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			
		}

		if($device!="")// By Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
					
		}

		if($all==3 || $all==4)// By Partner or By County respectively
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			}
				
		}

		if($report_type==1)// Tests Only
		{
			if($pdf_results!="")
			{	
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Successful</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;

				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}	
		}
		else if($report_type==2)//Errors Only
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Error</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;

				}
				
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}
						
		}
		else //Both Tests and Errors
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					if($value['valid']==1)
					{

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Successful</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';

					}
					else
					{

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Error</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';
					}
				$i++;	
				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}											
		}
		$pdf_data['table'].="</table>";

		if($pdf_count!="")
		{
			foreach($pdf_count as $test_count)
			{
				$pdf_data['less_than350']=$test_count['failed'];
				$pdf_data['count']=$test_count['total_tests'];
				$pdf_data['valid_tests']=$test_count['valid_tests'];
				$pdf_data['greater_equal_to350']=$test_count['passed'];
				$pdf_data['errors']=$test_count['errors'];
			}
		}

		// print_r($pdf_data);
		// die;
		return $pdf_data;
		
	}

	function year_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
	{
		$county_name="";

		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			
		}

		if($device!="")//By device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
									
		}
		
		if($all==3 || $all==4)//By partner or by county
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$login_id);	// get summation and count
			} 

		}

		if($report_type==1)// Tests Only
		{
			if($pdf_results!="")
			{	
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Successful</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;
					
				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}	
		}
		else if($report_type==2)//Errors Only
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Error</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;

				}
				
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}
						
		}
		else //Both Tests and Errors
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					if($value['valid']==1)
					{

						$pdf_data['table'].='<tr>
										<td>'.$i.'</td>
										<td>'.$value['sample_code'].'</td>
										<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>
										<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>
										<td><center>Successful</center></td>
										<td><center>'.$value['cd4_count'].'</center></td>
									</tr>';

					}
					else
					{

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Error</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';
					}
				$i++;	
				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}											
		}
		$pdf_data['table'].="</table>";

		if($pdf_count!="")
		{
			foreach($pdf_count as $test_count)
			{
				$pdf_data['less_than350']=$test_count['failed'];
				$pdf_data['count']=$test_count['total_tests'];
				$pdf_data['valid_tests']=$test_count['valid_tests'];
				$pdf_data['greater_equal_to350']=$test_count['passed'];
				$pdf_data['errors']=$test_count['errors'];
			}
		}

		// print_r($pdf_data);
		// die;
		return $pdf_data;
	}

	

	function customized_dates_report($fromdate,$todate,$all,$facility,$device,$report_type,$login_id)
	{
		$county_name="";

		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by Facility
		{	
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$login_id);	// get summation and count
			
		}

		if($device!="")//By Device
		{	
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$login_id);	// get summation and count
				
		}

		if($all==3 || $all==4)//By Partner or By county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$login_id);	// get summation and count
			}
		
		}

		if($report_type==1)// Tests Only
		{
			if($pdf_results!="")
			{	
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Successful</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;
				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}	
		}
		else if($report_type==2)//Errors Only
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>Error</center></td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

					$i++;
				}
				
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}
						
		}
		else //Both Tests and Errors
		{
			if($pdf_results!="")
			{
				foreach ($pdf_results as $value) 
				{
					$string_unix="";
					$string_unix=mysql_to_unix($value['date_test']);

					if($value['valid']==1)
					{
						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Successful</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';

					}
					else
					{
						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
						$pdf_data['table'].='<td><center>Error</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';
					}
				$i++;	
				}
			}
			else
			{
				$pdf_data['less_than350']=0;
				$pdf_data['count']=0;
				$pdf_data['valid_tests']=0;
				$pdf_data['greater_equal_to350']=0;
				$pdf_data['errors']=0;
			}											
		}
		$pdf_data['table'].="</table>";

		if($pdf_count!="")
		{
			foreach($pdf_count as $test_count)
			{
				$pdf_data['less_than350']=$test_count['failed'];
				$pdf_data['count']=$test_count['total_tests'];
				$pdf_data['valid_tests']=$test_count['valid_tests'];
				$pdf_data['greater_equal_to350']=$test_count['passed'];
				$pdf_data['errors']=$test_count['errors'];
			}
		}

		// print_r($pdf_data);
		// die;
		return $pdf_data;
	}

	function tests_less_than350_month($from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
	
		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
	
		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}

			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}

		}
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td>'.$i.'</td>';
				$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
				$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
				$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
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

	function tests_less_than350_quarter($from,$to,$facility,$device,$all,$report_type,$login_id)
	{

		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}

		}

		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td>'.$i.'</td>';
				$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
				$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
				$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
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

	function tests_less_than350_bian($from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($all==3 || $all==4)//by partner or county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}

		}
		
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td>'.$i.'</td>';
				$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
				$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
				$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
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

	function tests_less_than350_yearly($from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}
			
			
		}
		
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td>'.$i.'</td>';
				$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
				$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
				$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
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

	function tests_less_than350_customized($from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")
		{
			$device="";
			$all="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($device!="")
		{
			$facility="";
			$all="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count

		}
		if($all==3 || $all==4)
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}
			else
			{
				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$login_id);	// get summation and count
			}	
	
		}

		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td>'.$i.'</td>';
				$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
				$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
				$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
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
	/*....................................... End of PDF Functions .................................................*/	
	 	public function GetMonthName($month)
		{
			$monthname="";

			 if ($month==1)
			 {
			     $monthname="January";
			 }
			  else if ($month==2)
			 {
			     $monthname="February";
			 }else if ($month==3)
			 {
			     $monthname="March";
			 }else if ($month==4)
			 {
			     $monthname="April";
			 }else if ($month==5)
			 {
			     $monthname="May";
			 }else if ($month==6)
			 {
			     $monthname="June";
			 }else if ($month==7)
			 {
			     $monthname="July";
			 }else if ($month==8)
			 {
			     $monthname="August";
			 }else if ($month==9)
			 {
			     $monthname="September";
			 }else if ($month==10)
			 {
			     $monthname="October";
			 }else if ($month==11)
			 {
			     $monthname="November";
			 }
			  else if ($month==12)
			 {
			     $monthname="December";
			 }
			  else if ($month==13)
			 {
			     $monthname=" Jan - Sep  ";
			 }
			return $monthname;
		}

		public function get_test_details($from,$to,$facility,$device,$all,$login_id,$report_type)//Get all the data
		{
			$sql="SELECT * FROM v_pima_tests_only";

			$criteria=" ";

			// $fmonth=date('m',strtotime($from));
			// $tmonth=date('m',strtotime($to));

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");

			if($user_group_id == 3){
				$user_delimiter = " AND partner_id = '".$user_filter_used."' ";
			}elseif ($user_group_id == 9) {
				$user_delimiter = " AND region_id = '".$user_filter_used."' ";
			}elseif ($user_group_id == 8) {
				$user_delimiter = " AND district_id = '".$user_filter_used."' ";
			}elseif ($user_group_id == 6) {
				$user_delimiter = " AND facility_id = '".$user_filter_used."' ";
			}

			if($facility!="")
			{
				$criteria =" AND facility='".$facility."'";
			}
			if($device!="")
			{
				$criteria=" AND fp.serial_num='".$device."' ";	
			}
			if($report_type==1)//tests only
			{
				$report="AND valid='1' ";
			}
			else if($report_type==2)//errors only
			{
				$report="AND valid='0' ";
			}
			else if($report_type==3)//tests < 350
			{
				$report="AND valid='1' AND cd4_count < 500";
			}
			else if($report_type==0)//both tests and errors
			{
				$report=" ";
			}
			
			$date_delimiter	=	" WHERE MONTH(date_test) BETWEEN '".date('m',strtotime($from))."' AND '".date('m',strtotime($to))."'
								  AND YEAR(date_test) BETWEEN '".date('Y',strtotime($from))."' AND '".date('Y',strtotime($to))."' ";		

			$test_details=R::getAll($sql.$date_delimiter.$user_delimiter.$criteria.$report);

			// echo $sql.$date_delimiter.$user_delimiter.$criteria.$report;
	
			// die;

			return $test_details;

		}

		public function get_count_test_details($from,$to,$facility,$device,$all,$login_id)
		{
			$sql_count="SELECT COUNT(test_id) AS total_tests,
							SUM(CASE WHEN valid= '1'    THEN 1 ELSE 0 END) AS valid_tests,
							SUM(CASE WHEN valid= '0'    THEN 1 ELSE 0 END) AS `errors`,
							SUM(CASE WHEN valid= '1'  AND  cd4_count < 500 THEN 1 ELSE 0 END) AS failed,
							SUM(CASE WHEN valid= '1'  AND  cd4_count >= 500 THEN 1 ELSE 0 END) AS passed
							FROM v_pima_tests_only ";

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");		

			if(!$facility=="")
			{
				$criteria =" AND facility='".$facility."' ";
			}
			if(!$device=="")
			{	
				$criteria=" AND serial_num='".$device."' ";
			}
			if($all==3)// by partner or by all tests
			{
				$criteria =" AND partner_id = '".$user_filter_used."' ";
			}
			else if($all==4)// by county
			{
				$criteria =" AND region_id= '".$user_filter_used."' ";
			}
			
			$date_delimiter	=	" WHERE MONTH(date_test) BETWEEN '".date('m',strtotime($from))."' AND '".date('m',strtotime($to))."'
								  AND YEAR(date_test) BETWEEN '".date('Y',strtotime($from))."' AND '".date('Y',strtotime($to))."' ";		

			$test_details=R::getAll($sql_count.$date_delimiter.$criteria);

			// echo $sql_count.$date_delimiter.$criteria;

			// die;

			return $test_details;
		}


		
}/* End of reports_model */
?>