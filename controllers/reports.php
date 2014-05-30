<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class reports extends MY_Controller {

	public function index(){

		$this->home_page();
	}

	public function home_page() {
		$this->login_reroute(array(3,8,9,6));
		$data['content_view'] = "poc/reports_view";
		$data['title'] = "Reports";
		$data['sidebar']	= "poc/sidebar_view";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('FusionCharts','poc_reports','jqueryui','dataTables')));

		 
		$this->load->model('reports_model');
		$this->load->model('poc_model');

		$user_group=$this->session->userdata('user_group_id');
 		$ID=$this->session->userdata('id'); // fetch  ID

		if($user_group==3)// partner
		{
			$data['yearlyReports']=$this->reports_model->getyearsreported($ID);

			$data['partner_option']=$user_group;

			$data['combo_box_county_option']="";// to remove error on view page source

			$data['FacilitiesList']= $this->poc_model->devices_reported();
		}
		else if($user_group==9)// county co-cordinator
		{
			$data['yearlyReports']=$this->reports_model->get_tested_years_by_county($ID);

			$data['combo_box_county_option']=$this->poc_model->get_details("equipment_details",$this->session->userdata("user_filter_used"));
			
			$data['partner_option']=0; // to remove error on view page source

			$data['FacilitiesList']=$this->poc_model->devices_reported();

			//$data['FacilitiesList']= $this->poc_model->get_details("equipment_details",$this->session->userdata("user_filter_used"));
		}

		$data['menus']	= 	$this->poc_model->menus(6);

		$data['devices_not_reported'] = $this->poc_model->devices_not_reported();
		
		$data['errors_agg'] = $this->poc_model->errors_reported();

		$data['DeviceNumberOptions'] = 	$this->poc_model->devices_reported();

		
		
		$this -> template($data);
		
	}

/*================================= Report Specs Function ======================================================*/
	function get_report()
	{	
		$login_id=$this->session->userdata('id');//login session
		$user_group=$this->session->userdata('user_group_id');//user access level session

		$Format=$this->input->post('format');//get radio button value

		$report_type=$this->input->post('report_type');
		
		$Yearo=$this->input->post('YearO');// Yearly report
			
		$Device=$this->input->post('device');// get the facility and the device
		$Facility=$this->input->post('facility');
		$all_data=$this->input->post('the_criteria');

		$Fromdate=$this->input->post('FromDate');// for customized dates
		$Todate=$this->input->post('ToDate');
		
		$monthly=$this->input->post('FieldM');// Monthly report
	 	$YearM=$this->input->post('YearM');
	 
	 	
		$quarterly=$this->input->post('quarterly');// Quarterly report
		$yearQ=$this->input->post('YearQ');

		$biannual=$this->input->post('bian');// Bi-annual report
		$yearB=$this->input->post('YearB');

		$month_flag="";
		$year_flag="";

		$this->load->model('reports_model');//load reports_model

		/*..................... Format: PDF is selected Start if....................................................*/
		if($Format=="pdf")//
		{	
			$img=base_url().'img/nascop.jpg';// Nascop Logo

			$pdf_data="";

			$PDF_document="<table width='53%' border='0' align='center'>";
			$PDF_document.="<tr>";
			$PDF_document.="<td><center><img style='vertical-align: top;' src='$img'/></center></td>";
			$PDF_document.="</tr>";
			$PDF_document.="</table>";

			$month_number_check=$this->reports_model->month_check($user_group,$login_id);//check if month exists in the database
			$year_number_check=$this->reports_model->year_check($user_group,$login_id);// check if year exits in the database

			if($YearM!="" && $monthly!="")// Month and Year chosen
			{
					foreach ($month_number_check as $key=> $m_value) 
					{
						
						if($m_value==$monthly)
						{
							$month_flag=1;//set  month flag
							
						}
						else
						{
							
						}

					}

					foreach ($year_number_check as $y_value)
					{
						if($y_value==$YearM)
						{
							$year_flag=1; //set year flag
						}
						else 
						{
							
						}
					}

					if($month_flag==1 && $year_flag==1)//check the flags set
					{
						/*
							set a default start date and end date for the month selected

						*/
						$month_from_date="-01";
						$from_month=$YearM."-".$monthly.$month_from_date;
					 	//$monthly++;
					 	$end_month=date('Y-m-d',mktime(0,0,0,$monthly,31,$YearM));
				 	
					 	if($report_type==3)// Tests < 350 
					 	{
					 		$pdf_data=$this->reports_model->tests_less_than350_month($YearM,$monthly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
					 		
					 	}
					 	else if($report_type==4)// Errors by percentage
					 	{
					 		$this->reports_model->percentage_error_by_month($YearM,$monthly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
					 	}
						else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
						{
							$pdf_data=$this->reports_model->year_month_report($YearM,$monthly,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
						}

						$the_month=$this->reports_model->GetMonthName($monthly);

						if($Facility!="")// check if the facility was selected
						{
							$filename='PDF for '.$Facility.' - '.$the_month.', '.$YearM;

							$PDF_document.='<br /><table border="0" align="center">';
							$PDF_document.='<tr>';
							$PDF_document.='<td><center><b>Report for '.$Facility.' - '.$the_month.', '.$YearM.'</b></center></td>';						
							$PDF_document.='</tr>';
							$PDF_document.='</table>';
						}
						if($Device!="")// check if device was selected
						{
							$filename='PDF for the '.$Device.' Device - '.$the_month.', '.$YearM;

							$PDF_document.='<br /><table border="0" align="center">';
							$PDF_document.='<tr>';
							$PDF_document.='<td>';
							$PDF_document.='<center><b>Report for the '.$Device.' Device - '.$the_month.', '.$YearM.' </b></center>';
							$PDF_document.='</td>';
							$PDF_document.='</tr>';
							$PDF_document.='</table>';
						}
						if($all_data==3 || $all_data==4)//By Parnter or By County respectively
						{
							if($all_data==4)
							{
								$filename = 'PDF for '.$pdf_data['county_name'].' County - '.$the_month.', '.$YearM;

								$PDF_document.='<br />';
								$PDF_document.='<table border="0" align="center">';
								$PDF_document.='<tr>';
								$PDF_document.='<td>';
								$PDF_document.='<center><b>Report for '.$pdf_data['county_name'].' County - '.$the_month.', '.$YearM.' </b></center>';
								$PDF_document.='</td>';
								$PDF_document.='</tr>';
								$PDF_document.='</table>';
							}
							else if($all_data==3)
							{
								$user_filter = $this->session -> userdata("user_filter");

								foreach($user_filter as $filter)
								{
									$filename='PDF for all tests '.$filter['user_filter_name'].' - '.$the_month.', '.$YearM;

									$PDF_document.='<br />';
									$PDF_document.='<table border="0" align="center">';
									$PDF_document.='<tr>';
									$PDF_document.='<td>';
									$PDF_document.='<center><b>Report for all tests '.$filter['user_filter_name'].' - '.$the_month.', '.$YearM.' </b></center>';
									$PDF_document.='</td>';
									$PDF_document.='</tr>';
									$PDF_document.='</table>';
								}
							}					
						}				
					}//check the flags set END
					else 
					{	
						if($year_flag==null || $year_flag="")
						{
							
							$img=base_url().'img/nascop.jpg';// Nascop Logo
							$NoData='<table width="100%" border="0">';
							$NoData.='<tr>';
							$NoData.='<td><center><img style="vertical-align: top;" src="'.$img.'"/></center></td>';
							$NoData.='</tr>';
							$NoData.='<tr>';
							$NoData.='<td>';
							$NoData.='<center>';
							$NoData.='<b>The data for the year you have selected does not existed or has not been collected yet</b>';
							$NoData.='</center>';
							$NoData.='</td>';
							$NoData.='</tr>';
							$NoData.='</table>';


							$this->load->library('mpdf/mpdf');// Load the library
							//echo $NoData;die;
							$filename="CD4 Report.pdf";
							$this->mpdf->WriteHTML($NoData);
							$this->mpdf->Output();// Output the results in the browser
						}
						else if($month_flag==null || $month_flag=="")
						{

							$img=base_url().'img/nascop.jpg';// Nascop Logo
							$NoData='<table width="100%" border="0">';
							$NoData.='<tr>';
							$NoData.='<td><center><img style="vertical-align: top;" src="'.$img.'"/></center></td>';
							$NoData.='</tr>';
							$NoData.='<tr>';
							$NoData.='<td>';
							$NoData.='<center>';
							$NoData.='<b>The data for the month you have selected does not existed or has not been collected yet</b>';
							$NoData.='</center>';
							$NoData.='</td>';
							$NoData.='</tr>';
							$NoData.='</table>';


							$this->load->library('mpdf/mpdf');// Load the library
							//echo $NoData;die;
							$filename="CD4 Report.pdf";
							$this->mpdf->WriteHTML($NoData);
							$this->mpdf->Output();// Output the results in the browser
						}
					}			
			}// Month and Year chosen END

			if($yearQ!="" && $quarterly!="")// Quarter and Year chosen
			{
				/*
					set a default start date and end date for the month selected

				*/
			 	if($quarterly==1)
			 	{		 		
			 		$from_month=$yearQ.'-01-01';
			 		$end_month=$yearQ.'-04-30';
			 		$quarter="January - April";

			 	}
			 	else if($quarterly==2)
			 	{
			 		$from_month=$yearQ.'-05-01';
			 		$end_month=$yearQ.'-08-31';
			 		$quarter="May - August";
			 	}
			 	else if($quarterly==3)
			 	{
			 		$from_month=$yearQ.'-09-01';
			 		$end_month=$yearQ.'-12-31';
			 		$quarter="September - December";
			 	}

			 	if($report_type==3)// Tests < 350 
		 		{
		 			$pdf_data=$this->reports_model->tests_less_than350_quarter($yearQ,$quarter,$quarterly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
		 		}
		 		else if($report_type==4)// Errors by percentage
		 		{
		 			$this->reports_model->percentage_error_by_quarter($yearQ,$quarter,$quarterly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
		 		}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{	
					$pdf_data=$this->reports_model->year_quarter_report($yearQ,$quarter,$quarterly,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
				}

				if($Facility!="")//check if facility was selected
				{
					$filename= 'PDF for '.$Facility.' - '.$quarter.', '.$yearQ;

					$PDF_document.='<br /><table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Facility.' - '.$quarter.', '.$yearQ.'</b></center></td>';							
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($Device!="")//check if device was selected
				{
					$filename='PDF for '.$Device.' - '.$quarter.' ,'.$yearQ;

					$PDF_document.='<br /><table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Device.' - '.$quarter.' ,'.$yearQ.'</b></center></td>';						
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($all_data==3 || $all_data==4)//check if partner or county was selected respectively
				{
					
					if($all_data==4)
					{
						$filename='PDF for '.$pdf_data['county_name'].' County - '.$quarter.', '.$yearQ; 

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td>';
						$PDF_document.='<center><b>Report for '.$pdf_data['county_name'].' County - '.$quarter.', '.$yearQ.' </b></center>';
						$PDF_document.='</td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}
					else if($all_data==3)
					{
						$user_filter = $this->session -> userdata("user_filter");
						foreach($user_filter as $filter)
						{
							$filename='PDF for all tests for '.$filter['user_filter_name'].' - '.$quarter.', '.$yearQ;

							$PDF_document.='<br />';
							$PDF_document.='<table border="0" align="center">';
							$PDF_document.='<tr>';
							$PDF_document.='<td>';
							$PDF_document.='<center><b>Report for all tests for '.$filter['user_filter_name'].' - '.$quarter.', '.$year.' </b></center>';
							$PDF_document.='</td>';
							$PDF_document.='</tr>';
							$PDF_document.='</table>';

						}
					}
					
				}
				
			}// Check if quarter was selected END

			if($yearB!="" && $biannual!="")// Bi-annual and Year chosen
			{
				if($biannual==1)
				{
					$from_month=$yearB.'-01-01';
			 		$end_month=$yearB.'-06-30';
			 		$biannual_name="January - June";		 						
				}
				else if($biannual==2)
				{
					$from_month=$yearB.'-07-01';
			 		$end_month=$yearB.'-12-31';
			 		$biannual_name="July - December";			 		
				}

				if($report_type==3)// Tests < 350 
		 		{
		 			$pdf_data=$this->reports_model->tests_less_than350_bian($yearB,$biannual_name,$biannual,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
		 		}
		 		else if($report_type==4)// Errors by percentage
		 		{
		 			$this->reports_model->percentage_error_by_biannual($yearB,$biannual_name,$biannual,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
		 		}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_biannual_report($yearB,$biannual_name,$biannual,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
				}

							
				if($Facility!="")//Check if facility was selected
				{
					$filename= 'PDF for '.$Facility.' - '.$biannual_name.', '.$yearB;

					$PDF_document.='<br /><table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Facility.' - '.$biannual_name.', '.$yearB.'</b></center></td>';						
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($Device!="")// Check if device was selected
				{
					$filename='PDF for '.$Device.' - '.$biannual_name.', '.$yearB;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Device.' - '.$biannual_name.', '.$yearB.'</b></center></td>';							
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($all_data==3 || $all_data==4)// check if partner or county was selected respectively
				{
					if($all_data==4)
					{
						$filename='PDF for '.$pdf_data['county_name'].' County - '.$biannual_name.', '.$yearB;

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td>';
						$PDF_document.='<center><b>Report for '.$pdf_data['county_name'].' County - '.$biannual_name.', '.$yearB.' </b></center>';
						$PDF_document.='</td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}
					else if($all_data==3)
					{
						$user_filter = $this->session -> userdata("user_filter");

						foreach($user_filter as $filter)
						{
							$filename='PDF for all tests '.$filter['user_filter_name'].' - '.$biannual_name.' '.$yearB;

							$PDF_document.='<br /><table border="0" align="center">';
							$PDF_document.='<tr>';
							$PDF_document.='<td>';
							$PDF_document.='<center><b>Report for all tests '.$filter['user_filter_name'].' - '.$biannual_name.' '.$yearB.' </b></center>';
							$PDF_document.='</td>';
							$PDF_document.='</tr>';
							$PDF_document.='</table>';
						}
						
					}
					
				}
					
			}// Bi-annual and Year chosen END

			if($Yearo!="")// Yearly criteria chosen
			{	
				$from_month=$Yearo.'-01-01';
				$end_month=$Yearo.'-12-31';

				if($report_type==3)// Tests < 350 
				{
					$pdf_data=$this->reports_model->tests_less_than350_yearly($Yearo,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);				

				}
				if($report_type==4)// Errors by percentage
				{
					$this->reports_model->percentage_error_by_year($Yearo,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
				}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_report($Yearo,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
				}
				
				if($Facility!="")//check by facility
				{
					$filename='PDF: Yearly Report for '.$Facility.' - '.$Yearo;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Yearly Report for '.$Facility.' - '.$Yearo.'</b></center></td>';							
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($Device!="")//check by device
				{
					$filename='PDF: Yearly Report for '.$Device.' - '.$Yearo;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Yearly Report for '.$Device.' - '.$Yearo.'</b></center></td>';								
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($all_data==3 || $all_data==4)//check by partner or by county respectively
				{
					if($all_data==4)
					{
						$filename='PDF: Report for '.$pdf_data['county_name'].' County - '.$Yearo;

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td><center><b>Report for '.$pdf_data['county_name'].' County - '.$Yearo.' </b></center></td>';	
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}
					else if($all_data==3)
					{
						$user_filter= $this->session ->userdata('user_filter');

						foreach($user_filter as $filter)
						{
							$filename='PDF: All Tests, '.$filter['user_filter_name'].' Yearly Report - '.$Yearo;

							$PDF_document.='<br />';
							$PDF_document.='<table border="0" align="center">';
							$PDF_document.='<tr>';
							$PDF_document.='<td><center><b>Yearly Report, '.$filter['user_filter_name'].' - '.$Yearo.' </b></center></td>';
							$PDF_document.='</tr>';
							$PDF_document.='</table>';
						}
					}
					
				}
				
				
			}// Yearly criteria chosen END

			if($Fromdate!="" && $Todate!="")// Custom dates chosen
			{
				if($report_type==3)// Tests < 350 
				{
					$pdf_data=$this->reports_model->tests_less_than350_customized($Fromdate,$Todate,$Facility,$Device,$all_data,$report_type,$login_id);
				}
				if($report_type==4)// Errors by percentage
				{
					$this->reports_model->percentage_errors_customized_dates($Fromdate,$Todate,$Facility,$Device,$all_data,$report_type,$login_id);
				}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{
					$pdf_data=$this->reports_model->customized_dates_report($Fromdate,$Todate,$all_data,$Facility,$Device,$report_type,$login_id);
				}

				if($Facility!="")//Check by facility
				{	
					$filename='PDF for '.$Facility.' - Between '.$Fromdate.' and '.$Todate;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Facility.' - Between '.$Fromdate.' and '.$Todate.'</b></center></td>';
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($Device!="")//check by device
				{
					$filename='PDF for '.$Device.' - Between '.$Fromdate.' and '.$Todate;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Device.' - Between '.$Fromdate.' and '.$Todate.'</b></center></td>';
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($all_data==3 || $all_data==4)//check by partner or by county respectively
				{
					if($all_data==4)
					{
						$filename='PDF: Between '.$Fromdate.' and '.$Todate.', '.$pdf_data['county_name'];

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td><center><b>Report - Between '.$Fromdate.' and '.$Todate.', '.$pdf_data['county_name'].' </b></center></td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}
					else if($all_data==3)
					{
						$user_filter=$this->session ->userdata('user_filter');

						foreach($user_filter as $filter)
						{
							$filename='PDF: All Tests for '.$filter['user_filter_name'].' Between '.$Fromdate.' and '.$Todate;

							$PDF_document.='<br />';
							$PDF_document.='<table border="0" align="center">';
							$PDF_document.='<tr>';
							$PDF_document.='<td><center><b>Report for '.$filter['user_filter_name'].' - Between '.$Fromdate.' and '.$Todate.'</b></center></td>';
							$PDF_document.='</tr>';
							$PDF_document.='</table>';
						}
					}
				}
			
			}// Custom dates chosen END	

			if($report_type==1)//tests 
			{
				$PDF_document.='<table border="1" align="center" width="680">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Successful Tests Done</th>';
				$PDF_document.='<th bgcolor="#990000" style="color:#FFF;">Tests < 350</th>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Tests >= 350</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_document.='</tr>';
				$PDF_document.='<tr><td align="center">'.$pdf_data['tests_done'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['less_than350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['greater_equal_to350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['count'].'</td></tr>';
				$PDF_document.='</table>';

			}
			else if($report_type==2)//errors
			{
				$PDF_document.='<table width="480" border="1" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#CC0000" style="color:#FFF;">Tests with Errors</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_document.='</tr>';
				$PDF_document.='<tr><td align="center">'.$pdf_data['errors'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['count'].'</td></tr>';
				$PDF_document.='</table>';

			}
			else if($report_type==3)//Tests < 350
			{
				$PDF_document.='<table width="480" border="1" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#990000" style="color:#FFF;"># Tests < 350</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_document.='</tr>';
				$PDF_document.='<tr><td align="center">'.$pdf_data['less_than350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['count'].'</td></tr></table>';

			}
			else if($report_type==0)// All Tests
			{
				$PDF_document.='<table width="680" border="1" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Successful Tests Done</th>';
				$PDF_document.='<th bgcolor="#990000" style="color:#FFF;">Tests < 350</th>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Tests >= 350</th>';
				$PDF_document.='<th bgcolor="#CC0000" style="color:#FFF;">Tests With Errors</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_document.='</tr>';
				$PDF_document.='<tr><td align="center">'.$pdf_data['tests_done'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['less_than350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['greater_equal_to350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['errors'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['count'].'</td></tr>';
				$PDF_document.='</table>';

			}
			// echo $PDF_document;
			// die;
			$PDF_document.='<br />'.$pdf_data['table']; //place details in table

			$this->load->library('mpdf/mpdf');// Load the mpdf library

			$this->mpdf->AddPage('L', // L - landscape, P - portrait
						            '', '', '', '',
						            30, // margin_left
						            30, // margin right
						            10, // margin top
						            30, // margin bottom
						            18, // margin header
						            12); // margin footer

			// $this->mpdf->SetWatermarkText('NASCOP');//Water Mark Text
			// $this->mpdf->showWatermarkText = true;//Water Mark set value

			$this->mpdf->simpleTables = true;
			$this->mpdf->WriteHTML($PDF_document);//place content in pdf

			$this->mpdf->Output($filename,'D'); //bring up "Save as Dialog" box

			

		}
		/*..................................... End Format: PDF End if.............................................*/



		/*..................................... Format: Excel is selected..........................................*/
			else if($Format=="excel")
			{
				$this->load->model('reports_excel_model');//load reports_excel_model

				$filename="";
				if($YearM!="" && $monthly!="")// Month and Year chosen
				{
					$month_from_date="-01";
					$from_month=$YearM."-".$monthly.$month_from_date;
				 	$monthly+1;
				 	$end_month=date('Y-m-d',mktime(0,0,0,$monthly,31,$YearM));

				 	$month_name=$this->reports_model->GetMonthName($monthly);

					if($all_data>2)
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_less_than350_".$month_name."_".$YearM.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_month($YearM,$monthly,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
						}
						else
						{

							if($all_data==3)
							{
								$user_filter = $this->session -> userdata("user_filter");

								foreach($user_filter as $filter)
								{
									$filename="Excel_Report_".$filter['user_filter_name']."_".$month_name."_".$YearM.".xls";
								}
								
							}
							else if($all_data==4)
							{
								$county_name=$this->reports_model->get_county_name($login_id);

								$filename="Excel_Report_".$county_name."_".$month_name."_".$YearM.".xls";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_".$month_name."_".$YearM.".xls";
							}
							
							$PHPExcel[] = $this->reports_excel_model->excel_year_month_all($YearM,$monthly,$all_data,$from_month,$end_month,$report_type,$login_id);
						}
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than350_".$month_name."_".$YearM.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_month($YearM,$monthly,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
						}
						else
						{
							$filename="Excel_Report_Facility_Device_".$month_name."_".$YearM.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_year_month($YearM,$monthly,$Facility,$Device,$from_month,$end_month,$report_type);
						}
					}
					
		
				}

				if($yearQ!="" && $quarterly!="")// Quarter and Year chosen
				{
					if($quarterly==1)
					{
						$from_month=$yearQ.'-01-01';
				 		$end_month=$yearQ.'-04-30';
				 		$quarter="January - April";
				 	}
				 	else if($quarterly==2)
					{
						$from_month=$yearQ.'-05-01';
				 		$end_month=$yearQ.'-08-31';
				 		$quarter="May - August";

				 	}
				 	else if($quarterly==3)
					{
						$from_month=$yearQ.'-09-01';
				 		$end_month=$yearQ.'-12-31';
				 		$quarter="September - December";

				 	}	

				 		if($all_data>2)
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_less_than350_Quarter_".$quarterly."_".$yearQ.".xls";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_quarter($yearQ,$quarter,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
							}
				 			else
				 			{
				 				if($all_data==3)
								{
									$user_filter = $this->session -> userdata("user_filter");

									foreach($user_filter as $filter)
									{
										$filename="Excel_Report_".$filter['user_filter_name']."_Quarter".$quarterly."_".$yearQ.".xls";
									}
								}
								else if($all_data==4)
								{
									$county_name=$this->reports_model->get_county_name($login_id);

									$filename="Excel_Report_".$county_name."_Quarter".$quarterly."_".$yearQ.".xls";
								}
								else if($all_data==5)
								{
									$filename="Excel_Report_All_Tests_Quarter".$quarterly."_".$yearQ.".xls";
								}
				 				$PHPExcel[] = $this->reports_excel_model->excel_year_quarter_all($yearQ,$quarter,$all_data,$from_month,$end_month,$report_type,$login_id);
				 			}
				 		}
				 		else
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_Facility_Device_less_than350_Quarter".$quarterly."_".$yearQ.".xls";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_quarter($yearQ,$quarter,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
							}
				 			else
				 			{
				 				$filename="Excel_Report_Facility_Device_Quarter".$quarterly."_".$yearQ.".xls";

				 				$PHPExcel[] = $this->reports_excel_model->excel_year_quarter_report($yearQ,$quarter,$Facility,$Device,$from_month,$end_month,$report_type);
				 			}
			 			}
	
				}
				if($yearB!="" && $biannual!="")
				{
					if($biannual==1)
					{
						$from_month=$yearB.'-01-01';
						$end_month=$yearB.'-06-30';
						$biannual_name="January - June";
					}
					else if($biannual==2)
					{
						$from_month=$Yearo.'-07-01';
						$end_month=$Yearo.'-12-31';
						$biannual_name="July - December";	
					}

					if($all_data>2)
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_less_than350_Biannual_".$biannual."_".$yearB.".xls";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_bian($yearB,$biannual_name,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
							}
				 			else
				 			{
				 				if($all_data==3)
								{
									$user_filter = $this->session -> userdata("user_filter");

									foreach($user_filter as $filter)
									{
										$filename="Excel_Report_".$filter['user_filter_name']."_Biannual".$biannual."_".$yearB.".xls";
									}
								}
								else if($all_data==4)
								{
									$county_name=$this->reports_model->get_county_name($login_id);

									$filename="Excel_Report_".$county_name."_Biannual".$biannual."_".$yearB.".xls";
								}
								else if($all_data==5)
								{
									$filename="Excel_Report_All_Tests_Biannual".$biannual."_".$yearB.".xls";
								}
				 				$PHPExcel[] = $this->reports_excel_model->excel_year_biannual_all($yearB,$biannual_name,$all_data,$from_month,$end_month,$report_type,$login_id);
				 			}
				 		}
				 		else
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_Facility_Device_less_than350_Biannual".$biannual."_".$yearB.".xls";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_bian($yearB,$biannual_name,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
							}
				 			else
				 			{
				 				$filename="Excel_Report_Facility_Device_Biannual".$biannual."_".$yearB.".xls";

				 				$PHPExcel[] = $this->reports_excel_model->excel_year_biannual_report($yearB,$biannual_name,$Facility,$Device,$from_month,$end_month,$report_type);
				 			}
			 			}
				}

				if($Yearo!="")// Yearly criteria chosen
				{
					$from_month=$Yearo.'-01-01';
					$end_month=$Yearo.'-12-01';

					if($all_data>2)
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_less_than350_".$Yearo.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_yearly($Yearo,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
						}
						else
						{
							if($all_data==3)
							{
								$user_filter = $this->session -> userdata("user_filter");

								foreach($user_filter as $filter)
								{
									$filename="Excel_Report_".$filter['user_filter_name']."_".$Yearo.".xls";
								}
							}
							else if($all_data==4)
							{
								$county_name=$this->reports_model->get_county_name($login_id);

								$filename="Excel_Report_".$county_name."_".$Yearo.".xls";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_".$Yearo.".xls";
							}
							$PHPExcel[] = $this->reports_excel_model->excel_yearly_all($Yearo,$all_data,$from_month,$end_month,$report_type,$login_id);
						}
						
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than350_".$Yearo.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_yearly($Yearo,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
						}
						else
						{
							$filename="Excel_Report_Facility_Device_".$Yearo.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_year_report($Yearo,$Facility,$Device,$from_month,$end_month,$report_type);
						}
					}
				}
				if($Fromdate!="" && $Todate!="")
				{
					if($all_data>2)
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_less_than350_Custom_Dates_".$Fromdate."_".$Todate.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_customized($Facility,$Device,$Fromdate,$Todate,$report_type,$all_data,$login_id);
						}
						else
						{ 
							if($all_data==3)
							{
								$user_filter = $this->session -> userdata("user_filter");

								foreach($user_filter as $filter)
								{
									$filename="Excel_Report_".$filter['user_filter_name']."_Custom_Dates_".$Fromdate."_".$Todate.".xls";
								}
							}
							else if($all_data==4)
							{
								$county_name=$this->reports_model->get_county_name($login_id);

								$filename="Excel_Report_".$county_name."_Custom_Dates_".$Fromdate."_".$Todate.".xls";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_Custom_Dates_".$FromDate."_".$Todate.".xls";
							}
							$PHPExcel[] = $this->reports_excel_model->excel_customized_dates_all($Fromdate,$Todate,$all_data,$report_type,$login_id);
						}
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than350_Custom_Dates_".$Fromdate."_".$Todate.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_customized($Facility,$Device,$Fromdate,$Todate,$report_type,$all_data,$login_id);
						}
						else
						{
							$filename="Excel_Report_Facility_Device_Custom_Dates_".$Fromdate."_".$Todate.".xls";

							$PHPExcel[] = $this->reports_excel_model->excel_customized_dates_report($Fromdate,$Todate,$Facility,$Device,$report_type);
						}
						
					}
					
				}

				//http://filext.com/faq/office_mime_types.php for the header mime types

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');// *can use ms-excel2007
				header('Content-Disposition: attachment;filename="'.$filename.'" ');
				header('Cache-Control: max-age=0');
				$obWrite=PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
				$obWrite->save('php://output');


			}/*..................................... Format: Excel is selected End ..........................................*/

			/*..................................... Format: Excel is selected End ..........................................*/
			else if($Format=="graph")
			{

			}
			/*..................................... Format: Excel is selected End ..........................................*/

	}/*================================= End get report Function ==========================================================*/
		
	}
/* End of file reports.php */
/* Location: ./application/modules/poc/controller/reports.php */