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

public function get_county_id($county_name_value)
{
	$result_county_id="";

	$sql="SELECT id FROM county WHERE name='".$county_name_value."' ";
	$query=$this->db->query($sql);

	if($query->num_rows()>0)
	{
		foreach($query->result() as $value)
		{
			$result_county_id=$value->id;
		}
	}
	else
	{

	}
	return $result_county_id;
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

	function year_month_report($Year,$Monthly,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{
		$tests_done=0;
		$count=0;
		$errors=0;
		$less_than350=0;
		$greater_equal_to350=0;

		$county_id="";
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

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			
		}

		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			
		}

		if($all==3 || $all==4 || $all==5)//by partner, by county, all data
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			}
			
		}

		if($report_type==1)// Test Only
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
		else if($report_type==2)// Errors Only
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
		else // Both Tests and Errors
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

	function year_quarter_report($yearQ,$quarter,$q_no,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{
		$tests_done=0;
		$count=0;
		$errors=0;
		$less_than350=0;
		$greater_equal_to350=0;

		$county_id="";
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

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
				
		}

		if($device!="")//Check if a device was picked
		{
			$facility="";
			$all="";
			
			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			
		}

		if($all==3 || $all==4 || $all==5)//by parnter, by county, all data
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
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
			else if($report_type==2)// Errors Only
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
			else// Both Tests and Errors
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
					$less_than350=0;
					$greater_equal_to350=0;
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

	function year_biannual_report($yearB,$biannual,$b_no,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{
		$tests_done=0;
		$count=0;
		$errors=0;
		$less_than350=0;
		$greater_equal_to350=0;

		$county_id="";
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

		if($facility!="")// Facility Check
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			
		}

		if($device!="")// Device check
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
				
		}

		if($all==3 || $all==4 || $all==5)// by partner, by county, all data
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
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
			else if($report_type==2)// Errors Only
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
			else// Both Tests and Errors
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
							$pdf_data['table'].='<td>'./*date('d-F-Y',strtotime(*/$value['date_test']/*)).' - '.mdate($datestring,$string_unix)*/.'</td>';
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
					$less_than350=0;
					$greater_equal_to350=0;
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


	function year_report($yearo,$all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{
		$tests_done=0;
		$count=0;
		$errors=0;
		$less_than350=0;
		$greater_equal_to350=0;

		$county_id="";
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

		if($facility!="")
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
				
		}

		if($device!="")// Check by Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
								
		}
		
		if($all==3 || $all==4 || $all==5)//Check if partner or partner
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id);
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
			else if($report_type==2)// Errors Only
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
			else// Both Tests and Errors
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
					$less_than350=0;
					$greater_equal_to350=0;
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

	function customized_dates_report($fromdate,$todate,$all,$facility,$device,$report_type,$login_id,$county_name_value)
	{
		$tests_done=0;
		$count=0;
		$errors=0;
		$less_than350=0;
		$greater_equal_to350=0;

		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='1' align='center' width='880'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility-Device</th>";
		$pdf_data['table'].="<th>Date</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//check facility
		{	
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id);
			
		}

		if($device!="")// Check Device
		{	
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id);
			
		}

		if($all==3 || $all==4 || $all==5)// By partner or all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id);
			}
			else
			{	
				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id);
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
			else if($report_type==2)// Errors Only
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
			else// Both Tests and Errors
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
					$less_than350=0;
					$greater_equal_to350=0;
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

	function tests_less_than350_month($year,$monthly,$from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$count=0;
		$less_than350=0;

		$county_id="";
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

		//$the_month=$this->GetMonthName($monthly);

		if($facility!="")//By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
		}
		if($device!="")//By device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
		}
		if($all==3 || $all==4 || $all==5)//by partner,by county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
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

	function tests_less_than350_quarter($year,$quarter,$q_no,$from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$count=0;
		$less_than350=0;

		$county_id="";
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

		if($facility!="")// By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
		}
		if($device!="")//By Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
		}
		if($all==3 || $all==4 || $all==5 )//By partner, county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);		
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

	function tests_less_than350_bian($year,$bian,$b_no,$from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$count=0;
		$less_than350=0;

		$county_id="";
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

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
		}
		if($all==3 || $all==4 || $all==5)//By partner, county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
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

	function tests_less_than350_yearly($yearo,$from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$count=0;
		$less_than350=0;

		$county_id="";
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

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
		}
		if($device!="")
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
		}
		if($all==3 || $all==4 || $all==5)
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
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

	function tests_less_than350_customized($from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$count=0;
		$less_than350=0;

		$county_id="";
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

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);	
		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
	
		}
		if($all==3 || $all==4 || $all==5)//by partner, county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id);
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

		public function get_test_details($from,$to,$facility,$device,$all,$county_id)//Get all the data
		{
			$this->config->load('sql');

			$sql= $this->config->item("preset_sql");
		
			$criteria =" ";
			$tests_sql ="";

			$tests_sql= $sql["pima_test_details"];

			if(!$facility=="")
			{
				$criteria =" AND  `facility`='".$facility."' ";
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
			}
			else if($all==4)// by county
			{
				$criteria =" AND `region_id`= '".$county_id."' ";
			}
			
			$date_delimiter	=	" AND `tst_dt`.`result_date` between '".$from."' and '".$to."' ";		

			$test_details=R::getAll($tests_sql.$date_delimiter.$criteria);

			// echo $tests_sql.$date_delimiter.$criteria;
	
			// die;

			return $test_details;

		}

		/*============================ Get equipment functions =====================================================*/

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
		/*============================ Get equipment functions =====================================================*/


		
}/* End of reports_model */
?>