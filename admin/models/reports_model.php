<?php 

class reports_model extends MY_Model{
/*
	The functions(including some variables) for getting tests <500cp/ml still read tests<350. However the SQL's all fetch tests <500cp/ml
	set by World Health Organization
*/

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

/*====================================== End County Functions =========================================================*/

/*...................................... Start of PDF Functions .......................................................*/

	function year_month_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{

		$county_id="";
		$custom="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//by facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			
		}

		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			
		}

		if($all==3 || $all==4 || $all==5)//by partner, by county, all data
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
					
					$pdf_data['table'].='<tr>';
					$pdf_data['table'].='<td>'.$i.'</td>';
					$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
					$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
					$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
		else if($report_type==2)// Errors Only
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
					$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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

		return $pdf_data;

	}

	function year_quarter_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{
		$custom="";
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
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

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
				
		}

		if($device!="")//Check if a device was picked
		{
			$facility="";
			$all="";
			
			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			
		}

		if($all==3 || $all==4 || $all==5)//by parnter, by county, all data
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
			else if($report_type==2)// Errors Only
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
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
							
							$pdf_data['table'].='<tr>';
							$pdf_data['table'].='<td>'.$i.'</td>';
							$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
							$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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

	function year_biannual_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{
		$custom="";
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")// Facility Check
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			
		}

		if($device!="")// Device check
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
				
		}

		if($all==3 || $all==4 || $all==5)// by partner, by county, all data
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);
			
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
					$pdf_data['errors']=0;
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


						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
					$pdf_data['errors']=0;
					
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
							
							$pdf_data['table'].='<tr>';
							$pdf_data['table'].='<td>'.$i.'</td>';
							$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
							$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
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


	function year_report($all,$facility,$device,$from_month,$end_month,$report_type,$login_id,$county_name_value)
	{
		$custom="";
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
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

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
				
		}

		if($device!="")// Check by Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
								
		}
		
		if($all==3 || $all==4 || $all==5)//Check if partner or partner
		{
			$device="";
			$facility="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from_month,$end_month,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
					$pdf_data['errors']=0;
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

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
						$pdf_data['table'].='<td><center>Error</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';

						$i++;
					}
				}else
				{
					$pdf_data['less_than350']=0;
					$pdf_data['count']=0;
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
					$pdf_data['errors']=0;
					
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
						
							$pdf_data['table'].='<tr>';
							$pdf_data['table'].='<td>'.$i.'</td>';
							$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
							$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
					$pdf_data['count']=0;
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

	function customized_dates_report($fromdate,$todate,$all,$facility,$device,$report_type,$login_id,$county_name_value,$custom)
	{
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility-Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>Test Status</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//check facility
		{	
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$custom);	// get summation and count
			
		}

		if($device!="")// Check Device
		{	
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$custom);	// get summation and count
		}

		if($all==3 || $all==4 || $all==5)// By partner or all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{	
				$pdf_results=$this->get_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($fromdate,$todate,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
					$pdf_data['errors']=0;
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

						$pdf_data['table'].='<tr>';
						$pdf_data['table'].='<td>'.$i.'</td>';
						$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
						$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
						$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
						$pdf_data['table'].='<td><center>Error</center></td>';
						$pdf_data['table'].='<td><center>'.$value['cd4_count'].'</center></td>';
						$pdf_data['table'].='</tr>';

						$i++;
						
					}
				}else
				{
					$pdf_data['less_than350']=0;
					$pdf_data['count']=0;
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
					$pdf_data['errors']=0;
					
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
							$pdf_data['table'].='<tr>';
							$pdf_data['table'].='<td>'.$i.'</td>';
							$pdf_data['table'].='<td>'.$value['sample_code'].'</td>';
							$pdf_data['table'].='<td><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
							$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
					$pdf_data['greater_equal_to350']=0;
					$pdf_data['valid_tests']=0;
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

	function tests_less_than350_month($monthly,$from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$custom="";
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")//By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
		}
		if($device!="")//By device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
		}
		if($all==3 || $all==4 || $all==5)//by partner,by county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}		
		}
		if($pdf_results!="")
		{
			foreach ($pdf_results as $value) 
			{
				$string_unix="";
				$string_unix=mysql_to_unix($value['date_test']);

				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td style="width:3%">'.$i.'</td>';
				$pdf_data['table'].='<td style="width:15%">'.$value['sample_code'].'</td>';
				$pdf_data['table'].='<td style="width:25%"><center>'.$value['facility'].' - '.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td style="width:25%"><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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

	function tests_less_than350_quarter($from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$custom="";
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th>Patient ID</th>";
		$pdf_data['table'].="<th>Facility - Device</th>";
		$pdf_data['table'].="<th>Date Run</th>";
		$pdf_data['table'].="<th>CD4 Count</th>";
		$pdf_data['table'].="</tr>";

		$i=1;//counter

		if($facility!="")// By facility
		{
			$device="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);	

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
		}
		if($device!="")//By Device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count	
		}
		if($all==3 || $all==4 || $all==5 )//By partner, county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count	
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);	

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count	
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
				$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
	return $pdf_data;			
	}

	function tests_less_than350_bian($bian,$b_no,$from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$custom="";
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
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

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count

		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);	

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
		}
		if($all==3 || $all==4 || $all==5)//By partner, county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
				$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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

	return $pdf_data;	
	}

	function tests_less_than350_yearly($from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value)
	{
		$custom="";
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
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

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count	
		}
		if($device!="")
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count	
		}
		if($all==3 || $all==4 || $all==5)
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
				$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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
		
	return $pdf_data;		
	}

	function tests_less_than350_customized($from,$to,$facility,$device,$all,$report_type,$login_id,$county_name_value,$custom)
	{
		$county_id="";
		$datestring = "%h:%i %a";//set the timestamp

		$pdf_results="";
		$pdf_data=array();

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
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

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count	
		}
		if($device!="")//by device
		{
			$facility="";
			$all="";

			$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

			$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
	
		}
		if($all==3 || $all==4 || $all==5)//by partner, county, all data
		{
			$facility="";
			$device="";

			if($all==4)
			{
				$pdf_data['county_name']=$county_name_value;

				$county_id=$this->get_county_id($county_name_value);

				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
			}
			else
			{
				$pdf_results=$this->get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom);

				$pdf_count=$this->get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom);	// get summation and count
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
				$pdf_data['table'].='<td><center>'.date('d-F-Y',strtotime($value['date_test'])).' - '.mdate($datestring,$string_unix).'</center></td>';
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

	public function get_test_details($from,$to,$facility,$device,$all,$county_id,$report_type,$custom)//Get all the data
	{
		$sql="SELECT * FROM v_pima_tests_only";

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

		if(!$facility=="")
		{
			$criteria =" AND  facility='".$facility."' ";
		}
		if(!$device=="")
		{	
			$criteria=" AND serial_num='".$device."' ";
		}
		if($all==3 || $all==5)// by partner 
		{
			$criteria =" AND 1 ";
		}
		else if($all==4)// by county
		{
			$criteria =" AND region_id= '".$county_id."' ";
		}
		if($custom==1)//custom dates chosen by user
		{
			$date_delimiter	=	" WHERE date_test BETWEEN '".$from."' AND '".$to."' ";
		}
		else if($custom==0)//other user filters
		{
			$date_delimiter	=	" WHERE MONTH(date_test) BETWEEN '".date('m',strtotime($from))."' AND '".date('m',strtotime($to))."'
								  AND YEAR(date_test) BETWEEN '".date('Y',strtotime($from))."' AND '".date('Y',strtotime($to))."' ";	
		}
				
		$test_details=R::getAll($sql.$date_delimiter.$criteria.$report);

		// echo $sql.$date_delimiter.$criteria.$report;

		// die;

		return $test_details;
		

	}
	public function get_count_test_details($from,$to,$facility,$device,$all,$county_id,$custom)
	{
		$sql_count="SELECT COUNT(test_id) AS total_tests,
						SUM(CASE WHEN valid= '1'    THEN 1 ELSE 0 END) AS valid_tests,
						SUM(CASE WHEN valid= '0'    THEN 1 ELSE 0 END) AS `errors`,
						SUM(CASE WHEN valid= '1'  AND  cd4_count < 500 THEN 1 ELSE 0 END) AS failed,
						SUM(CASE WHEN valid= '1'  AND  cd4_count >= 500 THEN 1 ELSE 0 END) AS passed
						FROM v_pima_tests_only ";		

		if(!$facility=="")
		{
			$criteria =" AND  facility='".$facility."' ";
		}
		if(!$device=="")
		{	
			$criteria=" AND serial_num='".$device."' ";
		}
		if($all==3 || $all==5)// by partner or by all tests
		{
			$criteria =" AND 1 ";
		}
		else if($all==4)// by county
		{
			$criteria =" AND region_id= '".$county_id."' ";
		}
		
		if($custom==1)//custom dates chosen by user
		{
			$date_delimiter	=	" WHERE date_test BETWEEN '".$from."' AND '".$to."' ";
		}
		else if($custom==0)//other user filters
		{
			$date_delimiter	=	" WHERE MONTH(date_test) BETWEEN '".date('m',strtotime($from))."' AND '".date('m',strtotime($to))."'
								  AND YEAR(date_test) BETWEEN '".date('Y',strtotime($from))."' AND '".date('Y',strtotime($to))."' ";	
		}		

		$test_details=R::getAll($sql_count.$date_delimiter.$criteria);

		// echo $sql_count.$date_delimiter.$criteria;

		// die;

		return $test_details;
	}
		
}/* End of reports_model */
?>