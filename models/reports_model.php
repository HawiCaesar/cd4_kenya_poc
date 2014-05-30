<?php 

class reports_model extends MY_Model{

/*====================================== Partner Functions =========================================================*/
 function getyearsreported($partnerid)
  {
		$sql="SELECT DISTINCT YEAR( pt.result_date ) AS year
						FROM pima_test pt, partner p, partner_user pu
						WHERE p.id = pu.partner_id
						AND pu.user_id = '".$partnerid."' ";
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

	function year_month_report($Year,$Monthly,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
	{		
		//$the_month=$this->GetMonthName($Monthly);
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
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);

		}

		if($device!="")// By Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
					
		}

		if($all==3 || $all==4)//By Partner or By County
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
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

					if($value['valid']==1)
					{
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;	
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
					else
					{
						$count++;
					}
				}
			}
			else
			{
				$tests_done=0;
				$count=0;
				$less_than350=0;
				$greater_equal_to350=0;
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

					if($value['valid']==0)
					{
						$errors++;
						$count++;

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
					else
					{
						$count++;
					}
					
				}
				
			}else
			{
				$errors=0;
				$count=0;
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
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
						$errors++;
						$count++;

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
				$tests_done=0;
				$errors=0;
				$count=0;
				$greater_equal_to350=0;
				$less_than350=0;
			}											
		}
		$pdf_data['table'].="</table>";

		$pdf_data['tests_done']=$tests_done;
		$pdf_data['less_than350']=$less_than350;
		$pdf_data['greater_equal_to350']=$greater_equal_to350;
		$pdf_data['errors']=$errors;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;
	}

	function year_quarter_report($yearQ,$quarter,$q_no,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
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
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";
		$i=1;//counter

		if($facility!="")//Check if a facility was picked
		{	
			$all="";
			$device="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
						
		}

		if($device!="")//Check if a device was picked
		{
			$facility="";
			$all="";
			
			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
			
		}

		if($all==3 || $all==4)// Check if Partner or County was picked
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
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

					if($value['valid']==1)
					{
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;	
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
					else
					{
						$count++;
					}
				}
			}
			else
			{
				$tests_done=0;
				$count=0;
				$less_than350=0;
				$greater_equal_to350=0;
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

					if($value['valid']==0)
					{
						$errors++;
						$count++;

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
					else
					{
						$count++;
					}
				}
				
			}
			else
			{
				$errors=0;
				$count=0;
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
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
						$errors++;
						$count++;

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
				$tests_done=0;
				$errors=0;
				$count=0;
				$greater_equal_to350=0;
				$less_than350=0;
			}											
		}
		$pdf_data['table'].="</table>";

		$pdf_data['tests_done']=$tests_done;
		$pdf_data['less_than350']=$less_than350;
		$pdf_data['greater_equal_to350']=$greater_equal_to350;
		$pdf_data['errors']=$errors;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;	
	}

	function year_biannual_report($yearB,$biannual,$b_no,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
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
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")// By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
			
		}

		if($device!="")// By Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
					
		}

		if($all==3 || $all==4)// By Partner or By County respectively
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
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

					if($value['valid']==1)
					{
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;	
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
					else
					{
						$count++;
					}
				}
			}
			else
			{
				$tests_done=0;
				$count=0;
				$less_than350=0;
				$greater_equal_to350=0;
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

					if($value['valid']==0)
					{
						$errors++;
						$count++;

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
					else
					{
						$count++;
					}
				}
				
			}
			else
			{
				$errors=0;
				$count=0;
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
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
						$errors++;
						$count++;

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
				$tests_done=0;
				$errors=0;
				$count=0;
				$greater_equal_to350=0;
				$less_than350=0;
			}											
		}
		$pdf_data['table'].="</table>";

		$pdf_data['tests_done']=$tests_done;
		$pdf_data['less_than350']=$less_than350;
		$pdf_data['greater_equal_to350']=$greater_equal_to350;
		$pdf_data['errors']=$errors;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;
		
	}

	function year_report($yearo,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id)
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
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
			
		}

		if($device!="")//By device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
									
		}
		
		if($all==3 || $all==4)//By partner or by county
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$login_id);
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

					if($value['valid']==1)
					{
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;	
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
					else
					{
						$count++;
					}
				}
			}
			else
			{
				$tests_done=0;
				$count=0;
				$less_than350=0;
				$greater_equal_to350=0;
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

					if($value['valid']==0)
					{
						$errors++;
						$count++;

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
					else
					{
						$count++;
					}
				}
				
			}
			else
			{
				$errors=0;
				$count=0;
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
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
						$errors++;
						$count++;

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
				$tests_done=0;
				$errors=0;
				$count=0;
				$greater_equal_to350=0;
				$less_than350=0;
			}											
		}
		$pdf_data['table'].="</table>";

		$pdf_data['tests_done']=$tests_done;
		$pdf_data['less_than350']=$less_than350;
		$pdf_data['greater_equal_to350']=$greater_equal_to350;
		$pdf_data['errors']=$errors;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;
	}

	

	function customized_dates_report($fromdate,$todate,$all,$facility,$device,$report_type,$login_id)
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
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by Facility
		{	
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id);
			
		}

		if($device!="")//By Device
		{	
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id);
				
		}

		if($all==3 || $all==4)//By Partner or By county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$login_id);
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

					if($value['valid']==1)
					{
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;	
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
					else
					{
						$count++;
					}
				}
			}
			else
			{
				$tests_done=0;
				$count=0;
				$less_than350=0;
				$greater_equal_to350=0;
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

					if($value['valid']==0)
					{
						$errors++;
						$count++;

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
					else
					{
						$count++;
					}
				}
				
			}
			else
			{
				$errors=0;
				$count=0;
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
						$tests_done+=$value['valid'];
						$count++;

						if($value['valid']==1 && $value['cd4_count']>=350)
						{
							$greater_equal_to350++;
						}
						else if($value['valid']==1 && $value['cd4_count']<350)
						{
							$less_than350++;
						}

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
						$errors++;
						$count++;

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
				$tests_done=0;
				$errors=0;
				$count=0;
				$greater_equal_to350=0;
				$less_than350=0;
			}											
		}
		$pdf_data['table'].="</table>";

		$pdf_data['tests_done']=$tests_done;
		$pdf_data['less_than350']=$less_than350;
		$pdf_data['greater_equal_to350']=$greater_equal_to350;
		$pdf_data['errors']=$errors;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;
	}

	function tests_less_than350_month($year,$monthly,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$count=0;
		$less_than350=0;

		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
	
		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
	
		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				if($value['valid']==1 && $value['cd4_count']<350)
				{
					$less_than350++;
					$count++;

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

				$i++;
				}
				else
				{
					$count++;
				}
				
			}
		}
		else
		{
			$less_than350=0;
			$count=0;
		}

		$pdf_data['table'].="</table>";

		$pdf_data['less_than350']=$less_than350;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;
					
	}

	function tests_less_than350_quarter($year,$quarter,$q_no,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$count=0;
		$less_than350=0;

		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}

		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				if($value['valid']==1 && $value['cd4_count']<350)
				{
					$less_than350++;
					$count++;

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

				$i++;
				}
				else
				{
					$count++;
				}
				
			}
		}
		else
		{
			$less_than350=0;
			$count=0;
		}
		$pdf_data['table'].="</table>";

		$pdf_data['less_than350']=$less_than350;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;
	}

	function tests_less_than350_bian($year,$bian,$b_no,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$count=0;
		$less_than350=0;

		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

			
		}
		if($all==3 || $all==4)//by partner or county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county_name']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}
		
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				if($value['valid']==1 && $value['cd4_count']<350)
				{
					$less_than350++;
					$count++;

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

				$i++;
				}
				else
				{
					$count++;
				}
				
			}
		}
		else
		{
			$less_than350=0;
			$count=0;
		}
		$pdf_data['table'].="</table>";

		$pdf_data['less_than350']=$less_than350;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;	
	}

	function tests_less_than350_yearly($yearo,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$count=0;
		$less_than350=0;

		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$pdf_data['county']=$county_name;

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			
			
		}
		
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				if($value['valid']==1 && $value['cd4_count']<350)
				{
					$less_than350++;
					$count++;

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';

				$i++;
				}
				else
				{
					$count++;
				}
				
			}
		}
		else
		{
			$less_than350=0;
			$count=0;
		}
		$pdf_data['table'].="</table>";

		$pdf_data['less_than350']=$less_than350;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;	
	}

	function tests_less_than350_customized($from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$count=0;
		$less_than350=0;

		$county_name="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")
		{
			$device="";
			$all="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($device!="")
		{
			$facility="";
			$all="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($all==3 || $all==4)
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}	
	
		}

		
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				if($value['valid']==1 && $value['cd4_count']<350)
				{
					$less_than350++;
					$count++;

					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</td>';
					$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
					$pdf_data['table'].='</tr>';
					
				$i++;
				}
				else
				{
					$count++;
				}
				
			}
		}
		else
		{
			$less_than350=0;
			$count=0;
		}
		$pdf_data['table'].="</table>";

		$pdf_data['less_than350']=$less_than350;
		$pdf_data['count']=$count;

		// print_r($pdf_data);
		// die;
		return $pdf_data;			
	}

	function percentage_error_by_month($year,$monthly,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$img=base_url().'img/nascop.jpg';// Nascop Logo
		$the_month=$this->GetMonthName($monthly);

		$tests_done=0;
		$greater_equal_to350=0;
		$less_than350=0;
		$errors=0;
		$count=0;
		$county_name="";
		$sql="";

		if($facility!="")//by facility
		{
			$all="";
			$device="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($device!="")//by device
		{
			$all="";
			$facility="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($all==3 || $all==4)//by partner by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}

		if($sql!="")
			{
				foreach($sql as $value)
				{
					if($value['valid']==0)
					{
						$errors++;
						$count++;
					}
					else
					{
						$tests_done++;
						$count++;
					}
				}


			}
			else 
			{
				$errors=0;
			}

			$Data['img']=$img;
			$Data['report_type']=$report_type;
			$Data['tests_done']=$tests_done;
			$Data['errors']=$errors;
			$Data['less_than350']=$less_than350;
			$Data['greater_equal_to350']=$greater_equal_to350;
			$Data['count']=$count;
			$Data['facility']=$facility;
			$Data['device']=$device;
			$Data['all']=$all;
			$Data['county_name']=$county_name;
			$Data['login_id']=$login_id;				
			$Data['the_month']=$the_month;
			$Data['quarter']="";
			$Data['q_no']="";
			$Data['bian']="";
			$Data['b_no']="";
			$Data['Year']=$year;
			$Data['Year_cri']="";
			$Data['from']="";
			$Data['to']="";


			$this->load->view('report_pdf_view',$Data);
	}
	function percentage_error_by_quarter($year,$quarter,$q_no,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$img=base_url().'img/nascop.jpg';// Nascop Logo

		$tests_done=0;
		$greater_equal_to350=0;
		$less_than350=0;
		$errors=0;
		$count=0;
		$county_name="";
		$sql="";

		if($facility!="")//by facility
		{
			$all="";
			$device="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
	
		}
		if($device!="")//by device
		{
			$all="";
			$facility="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
		
		}
		if($all==3 || $all==4)//by partner by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}

		if($sql!="")
			{
				foreach($sql as $value)
				{
					if($value['valid']==0)
					{
						$errors++;
						$count++;
					}
					else
					{
						$tests_done++;
						$count++;
					}
				}


			}
			else 
			{
				$errors=0;
			}

			$Data['img']=$img;
			$Data['report_type']=$report_type;
			$Data['tests_done']=$tests_done;
			$Data['errors']=$errors;
			$Data['less_than350']=$less_than350;
			$Data['greater_equal_to350']=$greater_equal_to350;
			$Data['count']=$count;
			$Data['facility']=$facility;
			$Data['device']=$device;
			$Data['all']=$all;
			$Data['county_name']=$county_name;
			$Data['login_id']=$login_id;				
			$Data['the_month']="";
			$Data['quarter']=$quarter;
			$Data['q_no']=$q_no;
			$Data['bian']="";
			$Data['b_no']="";
			$Data['Year']=$year;
			$Data['Year_cri']="";
			$Data['from']="";
			$Data['to']="";


			$this->load->view('report_pdf_view',$Data);
	}

	function percentage_error_by_biannual($year,$bian,$b_no,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$img=base_url().'img/nascop.jpg';// Nascop Logo

		$tests_done=0;
		$greater_equal_to350=0;
		$less_than350=0;
		$errors=0;
		$count=0;
		$county_name="";
		$sql="";

		if($facility!="")//by facility
		{
			$all="";
			$device="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
	
		}
		if($device!="")//by device
		{
			$all="";
			$facility="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}

		if($sql!="")
			{
				foreach($sql as $value)
				{
					if($value['valid']==0)
					{
						$errors++;
						$count++;
					}
					else
					{
						$tests_done++;
						$count++;
					}
				}


			}
			else 
			{
				$errors=0;
			}

			$Data['img']=$img;
			$Data['report_type']=$report_type;
			$Data['tests_done']=$tests_done;
			$Data['errors']=$errors;
			$Data['less_than350']=$less_than350;
			$Data['greater_equal_to350']=$greater_equal_to350;
			$Data['count']=$count;
			$Data['facility']=$facility;
			$Data['device']=$device;
			$Data['all']=$all;
			$Data['county_name']=$county_name;
			$Data['login_id']=$login_id;				
			$Data['the_month']="";
			$Data['quarter']="";
			$Data['q_no']="";
			$Data['bian']=$bian;
			$Data['b_no']=$b_no;
			$Data['Year']=$year;
			$Data['Year_cri']="";
			$Data['from']="";
			$Data['to']="";


			$this->load->view('report_pdf_view',$Data);
	}

	function percentage_error_by_year($year,$from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$img=base_url().'img/nascop.jpg';// Nascop Logo

		$tests_done=0;
		$greater_equal_to350=0;
		$less_than350=0;
		$errors=0;
		$count=0;
		$county_name="";
		$sql="";

		if($facility!="")//by facility
		{
			$all="";
			$device="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($device!="")//by device
		{
			$all="";
			$facility="";
			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);

		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}

		if($sql!="")
			{
				foreach($sql as $value)
				{
					if($value['valid']==0)
					{
						$errors++;
						$count++;
					}
					else
					{
						$tests_done++;
						$count++;
					}
				}


			}
			else 
			{
				$errors=0;
			}

			$Data['img']=$img;
			$Data['report_type']=$report_type;
			$Data['tests_done']=$tests_done;
			$Data['errors']=$errors;
			$Data['less_than350']=$less_than350;
			$Data['greater_equal_to350']=$greater_equal_to350;
			$Data['count']=$count;
			$Data['facility']=$facility;
			$Data['device']=$device;
			$Data['all']=$all;
			$Data['county_name']=$county_name;
			$Data['login_id']=$login_id;				
			$Data['the_month']="";
			$Data['quarter']="";
			$Data['q_no']="";
			$Data['bian']="";
			$Data['b_no']="";
			$Data['Year']="";
			$Data['Year_cri']=$year;
			$Data['from']="";
			$Data['to']="";


			$this->load->view('report_pdf_view',$Data);
	}

	function percentage_errors_customized_dates($from,$to,$facility,$device,$all,$report_type,$login_id)
	{
		$img=base_url().'img/nascop.jpg';// Nascop Logo

		$tests_done=0;
		$greater_equal_to350=0;
		$less_than350=0;
		$errors=0;
		$count=0;
		$county_name="";
		$sql="";

		if($facility!="")//by facility
		{
			$all="";
			$device="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
		
		}
		if($device!="")//by device
		{
			$all="";
			$facility="";

			$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
	
		}
		if($all==3 || $all==4)//by partner or by county
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$county_name=$this->get_county_name($login_id);

				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}
			else
			{
				$sql=$this->get_test_details($from,$to,$facility,$device,$all,$login_id);
			}

		}

		if($sql!="")
			{
				foreach($sql as $value)
				{
					if($value['valid']==0)
					{
						$errors++;
						$count++;
					}
					else
					{
						$tests_done++;
						$count++;
					}
				}


			}
			else 
			{
				$errors=0;
			}

			$Data['img']=$img;
			$Data['report_type']=$report_type;
			$Data['tests_done']=$tests_done;
			$Data['errors']=$errors;
			$Data['less_than350']=$less_than350;
			$Data['greater_equal_to350']=$greater_equal_to350;
			$Data['count']=$count;
			$Data['facility']=$facility;
			$Data['device']=$device;
			$Data['all']=$all;
			$Data['county_name']=$county_name;
			$Data['login_id']=$login_id;				
			$Data['the_month']="";
			$Data['quarter']="";
			$Data['q_no']="";
			$Data['bian']="";
			$Data['b_no']="";
			$Data['Year']="";
			$Data['Year_cri']="";
			$Data['from']=$from;
			$Data['to']=$to;


			$this->load->view('report_pdf_view',$Data);

	}

	/*....................................... End of PDF Functions .................................................*/	
	 
	 function month_check($user_group,$login_id)
	 {
	 	$sql="";

	 	$monthNumber="";
	 	if($user_group==3)
	 	{
	 		$sql="SELECT DISTINCT MONTH( c.result_Date ) AS mth
									FROM cd4_test c, pima_test pt, facility f, partner_user pu,user u
									WHERE c.id=pt.cd4_test_id 
									AND c.facility_id=f.id
									AND f.partnerID=pu.partner_id
									AND pu.user_id=u.id
									AND u.id='".$login_id."' ";
	 	}
	 	else if($user_group==9)
	 	{
	 		$sql="SELECT DISTINCT MONTH( cd.result_Date ) AS mth
									FROM cd4_test cd, facility_pima fp, facility f, district d, county c, region_user r
									WHERE cd.facility_equipment_id = fp.facility_equipment_id
									AND cd.facility_id = f.id
									AND f.district = d.id
									AND d.region_id = c.id
									AND r.user_id =  '".$login_id."'";
	 	}
	 	
	 	$res=$this->db->query($sql);

	 	if($res->num_rows()>0)
	 	{
	 		foreach ($res->result_array() as $value) 
	 		{
	 			$monthNumber[]=$value['mth'];
	 		}
	 		
	 	}

	 	return $monthNumber;
	 	
	 }
	 function year_check($user_group,$login_id)
	 {
	 	$YearNumber="";

	 	if($user_group==3)
	 	{
	 		$sql="SELECT DISTINCT YEAR( c.result_Date ) AS yr
									FROM cd4_test c, pima_test pt, facility f, partner_user pu,user u
									WHERE c.id=pt.cd4_test_id 
									AND c.facility_id=f.id
									AND f.partnerID=pu.partner_id
									AND pu.user_id=u.id
									AND u.id='".$login_id."' ";
		}

		else if($user_group==9)
		{
			$sql="SELECT DISTINCT YEAR( cd.result_Date ) AS yr
									FROM cd4_test cd, facility_pima fp, facility f, district d, county c, region_user r
									WHERE cd.facility_equipment_id = fp.facility_equipment_id
									AND cd.facility_id = f.id
									AND f.district = d.id
									AND d.region_id = c.id
									AND r.user_id =  '".$login_id."'";
		}
		
	 	$res=$this->db->query($sql);

	 	if($res->num_rows()>0)
	 	{
	 		foreach ($res->result_array() as $value) 
	 		{
	 			
	 			$YearNumber[]=$value['yr'];
	 		}
	 		
	 	}
	 	return $YearNumber;
	 	
	 }

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

		public function get_test_details($from,$to,$facility,$device,$all,$login_id)//Get all the data
		{
			$this->config->load('sql');

			$sql= $this->config->item("preset_sql");
		
			$user_delimiter = "";
			$criteria =" ";
			$tests_sql ="";
			
			$tests_sql= $sql["pima_test_details"];

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
			
			$date_delimiter	=	" AND `pim_tst`.`result_date` between '".$from."' and '".$to."' ";		

			$test_details=R::getAll($tests_sql.$user_delimiter.$date_delimiter.$criteria);

			// echo $tests_sql.$user_delimiter.$date_delimiter.$criteria;
	
			// die;

			return $test_details;

		}

		/*============================PDF Database functions=====================================================*/

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
		/*============================End PDF Database functions=====================================================*/


		
}/* End of reports_model */
?>