<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
/*
	The functions(including some variables) for getting tests <500cp/ml still read tests<350. However the SQL's all fetch tests <500cp/ml
	set by World Health Organization
*/
class reports extends MY_Controller {

	public function index(){

		$this->home_page();
	}

	public function home_page() {
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/reports_view";
		$data['title'] = "Reports";
		$data['sidebar']	= "admin/sidebar_view";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('admin_reports')));
		
		$this->load->model('admin_model');
		$this->load->model('reports_model');

		$data['menus']	= 	$this->admin_model->menus(5);

		$data['yearlyReports'] = $this->admin_model->get_years_tested();

		$users=0;

		if(!$users==1)
		{
			$data['number_of_deactivated_users']="none";
		}

		$this -> template($data);
	}

	function ajax_facility_call()// ajax call to populate reports page, specifically the facility reporting tab
	{
		$this->load->model('admin_model');
		
		$empty=array();
		$facilities_list=$this->admin_model->get_facilities();

		if($facilities_list!=$empty)// compare empty array with returned result of $facilities_list
		{
			echo '<option value="" >*Select Facility*</option>';

			foreach($facilities_list as $facility)
			{
				echo '<option value="'.$facility['name'].'">'.$facility['name'].'</option>';
				echo '<optgroup></optgroup label="">';// space out
			}
		}
		else
		{
			echo '<option value="">*Search Facility*</option>';
			echo '<option value="">*Facilites Have Not Reported Yet*</option>';
		}
			
	}
	function ajax_equipment_call()// ajax call to populate reports page, specifically the equipment reporting tab
	{
		$this->load->model('admin_model');

		$empty=array();
		$device_list=$this->admin_model->get_devices();

		if($device_list!=$empty)// compare empty array with returned result of $facilities_list
		{
			echo '<option value="" selected="selected">*Select Device*</option>';

			foreach($device_list as $device)
			{
				echo '<option value="'.$device['serial_num'].'">'.$device['name'].' ---- '.$device['serial_num'].'</option>';
				echo '<optgroup></optgroup label="">';// space out
			}
			
		}
		else
		{
			echo '<option value="" selected="selected">*Select Device*</option>';
			echo '<option value="">*Devices Have Not Reported Yet*</option>';
		}
	}
	function ajax_county_call()
	{
		$this->load->model('admin_model');

		$empty=array();
		$county_list=$this->admin_model->get_countites();

		if($county_list!=$empty)
		{
			echo '<option value="" selected="selected">*Search County*</option>';

			foreach($county_list as $county)
			{
				echo '<option value="'.$county['name'].'">'.$county['name'].'</option>';
			}
		}
		else
		{
			echo '<option value="" selected="selected">*Select County*</option>';
			echo '<option value="">*Counties Have Not Reported Yet*</option>';
		}
	}

	function get_reports()
	{
		
		$this->load->model('reports_model');//load reports_model
		
		$login_id=$this->session->userdata('id');//login session
		$user_group=$this->session->userdata('user_group_id');//user access level session

		$Format="";
		$all_data="";
		$Facility="";
		$Device="";
		$county_name_value="";

		$tab_name=$this->input->post('tab_name');

		if($tab_name=="facility_tab")
		{
			$Format=$this->input->post('format_facility');//get radio button value
			$Facility=$this->input->post('facility');
			
		}
		else if($tab_name=="equipment_tab")
		{
			$Format=$this->input->post('format_equipment');//get radio button value
			$Device=$this->input->post('device');// get the facility and the device

		}
		else if($tab_name=="county_tab")
		{
			$Format=$this->input->post('format_county');//get radio button value
			$county_name_value=$this->input->post('county_value');
			$all_data=$this->input->post('bigger_criteria');
		}
		else if($tab_name=="all_tab")
		{
			$Format=$this->input->post('format_all');//get radio button value
			$all_data=$this->input->post('bigger_criteria');
		}

		$report_type=$this->input->post('report_type'); //get the report type
		
		$Yearo=$this->input->post('YearO');// Yearly report
			
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

		/*..................... Format: PDF is selected Start if....................................................*/

		if($Format=="pdf")
		{	
			$img=base_url().'img/nascop.jpg';// Nascop Logo

			$pdf_data="";

			$table_style='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
						table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
						table.data-table td, table th {padding: 4px;}
						table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
					</style>';

			$PDF_document="<table width='53%' border='0' align='center'>";
			$PDF_document.="<tr>";
			$PDF_document.='<td><center><img style="vertical-align: top;" src="'.$img.'" /></center></td>';
			$PDF_document.='</tr>';
			$PDF_document.='</table>';

			if($YearM!="" && $monthly!="")// Month and Year chosen
			{
				/*
					set a default start date and end date for the month selected

				*/
				$from_month=$YearM."-".$monthly.'-01';
			 	//$monthly++;
				$num_days=cal_days_in_month(CAL_GREGORIAN, $monthly,$YearM);
			 	$end_month=$YearM.'-'.$monthly.'-'.$num_days;
		 	
			 	if($report_type==3)// Tests < 350 
			 	{
			 		$pdf_data=$this->reports_model->tests_less_than350_month($YearM,$monthly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);	
			 	}
			 	else if($report_type==4)//Percentage Errors
			 	{
			 		$this->reports_model->percentage_error_by_month($YearM,$monthly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
			 	}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_month_report($YearM,$monthly,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id,$county_name_value);
				}

				$the_month=$this->reports_model->GetMonthName($monthly);

				if($the_month!="")// Check if month was selected
				{
					if($Facility!="")// check if the facility was selected
					{
						$filename='PDF for '.$Facility.' - '.$the_month.', '.$YearM;

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td><center><b>Report for '.$Facility.' - '.$the_month.', '.$YearM.'</b></center></td>';							
						$PDF_document.='</tr>';
						$PDF_document.='</table>';		
					}

					if($Device!="")// Check if device was selected
					{
						$filename='PDF for the '.$Device.' Device - '.$the_month.', '.$YearM;

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td>';
						$PDF_document.='<center><b>Report for the '.$Device.' Device - '.$the_month.', '.$YearM.' </b></center>';
						$PDF_document.='</td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}

					if($all_data==3 || $all_data==4 || $all_data==5 )// check if partner, county or all data
					{
						if($all_data==5)
						{
							$filename='PDF for all tests - '.$the_month.', '.$YearM;

							$PDF_document.='<br />';
							$PDF_document.='<table border="0" align="center">';
							$PDF_document.='<tr>';
							$PDF_document.='<td>';
							$PDF_document.='<center><b>Report for all tests - '.$the_month.', '.$YearM.' </b></center>';
							$PDF_document.='</td>';
							$PDF_document.='</tr>';
							$PDF_document.='</table>';
						}
						else if($all_data==3)
						{
							// $user_filter = $this->session -> userdata("user_filter");

							// foreach($user_filter as $filter)
							// {
							// 	$filename='PDF for all tests '.$filter['user_filter_name'].' - '.$the_month.', '.$YearM;

							// 	$PDF_document.='<br />
							// 					<table border="0" align="center">
							// 						<tr>
							// 							<td>
							// 								<center><b>Report for all tests '.$filter['user_filter_name'].' - '.$the_month.', '.$year.' </b></center>
							// 							</td>
							// 						</tr>
							// 					</table>';
							// }
						}
						else if($all_data==4)
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
		 			$pdf_data=$this->reports_model->tests_less_than350_quarter($yearQ,$quarter,$quarterly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
		 		}
		 		else if($report_type==4)
		 		{
		 			$this->reports_model->percentage_error_by_quarter($yearQ,$quarter,$quarterly,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
		 		}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests or Errors or Both Tests and Errors
				{	
					$pdf_data=$this->reports_model->year_quarter_report($yearQ,$quarter,$quarterly,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id,$county_name_value);
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
				if($all_data==3 || $all_data==4 || $all_data==5)//check if partner, county or all data reporting was selected
				{
					
					if($all_data==5)
					{
						$filename='PDF for all tests - '.$quarter.', '.$yearQ;

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td>';
						$PDF_document.='<center><b>Report for all tests - '.$quarter.', '.$yearQ.' </b></center>';
						$PDF_document.='</td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';

					}
					else if($all_data==4)
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
						// $user_filter = $this->session -> userdata("user_filter");
						// foreach($user_filter as $filter)
						// {
						// 	$filename='PDF for all tests for '.$filter['user_filter_name'].' - '.$quarter.', '.$yearQ;

						// 	$PDF_document.='<br />
						// 		<table border="0" align="center">
						// 			<tr>
						// 				<td>
						// 					<center><b>Report for all tests for '.$filter['user_filter_name'].' - '.$quarter.', '.$yearQ.' </b></center>
						// 				</td>
						// 			</tr>
						// 		</table>';

						// }
					}
					
				}
				
			}// Quarter and Year chosen END

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
		 			$pdf_data=$this->reports_model->tests_less_than350_bian($yearB,$biannual_name,$biannual,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
		 		}
		 		else if($report_type==4)
		 		{
		 			$this->reports_model->percentage_error_by_biannual($yearB,$biannual_name,$biannual,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
		 		}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests or Errors or Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_biannual_report($yearB,$biannual_name,$biannual,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id,$county_name_value);
				}

				if($Facility!="")// check if facility selected
				{
					$filename= 'PDF for '.$Facility.' - '.$biannual_name.', '.$yearB;

					$PDF_document.='<br /><table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Facility.' - '.$biannual_name.', '.$yearB.'</b></center></td>';							
					$PDF_document.='</tr>';
					$PDF_document.='</table>';

				}
				if($Device!="")//check if device was selected
				{
					$filename='PDF for '.$Device.' - '.$biannual_name.', '.$yearB;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Device.' - '.$biannual_name.', '.$yearB.'</b></center></td>';							
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($all_data==3 || $all_data==4 || $all_data==5)//check if partner, county or all data reporting was selected
				{
					if($all_data==5)
					{
						$filename='PDF for all tests - '.$biannual_name.' '.$yearB;

						$PDF_document.='<br /><table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td>';
						$PDF_document.='<center><b>Report for all tests - '.$biannual_name.' '.$yearB.' </b></center>';
						$PDF_document.='</td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}
					else if($all_data==4)
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
						// $user_filter = $this->session -> userdata("user_filter");

						// foreach($user_filter as $filter)
						// {
						// 	$filename='PDF for all tests '.$filter['user_filter_name'].' - '.$biannual_name.' '.$yearB;

						// 	$GraphPDF.='<br /><table border="0" align="center">
						// 					<tr>
						// 						<td>
						// 							<center><b>Report for all tests '.$filter['user_filter_name'].' - '.$biannual_name.' '.$year.' </b></center>
						// 						</td>
						// 					</tr>
						// 				</table>';
						// }
						
					}
					
				}
										
			}// Bi-annual and Year chosen END

			if($Yearo!="")// Yearly criteria chosen
			{	
				$from_month=$Yearo.'-01-01';
				$end_month=$Yearo.'-12-31';

				if($report_type==3)// Tests < 350 
				{
					$pdf_data=$this->reports_model->tests_less_than350_yearly($Yearo,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
				}
				if($report_type==4)
				{
					$this->reports_model->percentage_error_by_year($Yearo,$from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
				}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests or Errors or Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_report($Yearo,$all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id,$county_name_value);
				}

				if($Facility!="")
				{
					$filename='PDF: Yearly Report for '.$Facility.' - '.$Yearo;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Yearly Report for '.$Facility.' - '.$Yearo.'</b></center></td>';						
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($Device!="")
				{
					$filename='PDF: Yearly Report for '.$Device.' - '.$Yearo;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Yearly Report for '.$Device.' - '.$Yearo.'</b></center></td>';						
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($all_data==3 || $all_data==4 || $all_data==5)
				{
					if($all_data==5)
					{
						$filename='PDF: All Tests, Yearly Report - '.$Yearo;

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td><center><b>Yearly Report - '.$Yearo.' </b></center></td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}
					else if($all_data==4)
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
						// $user_filter= $this->session ->userdata('user_filter');

						// foreach($user_filter as $filter)
						// {
						// 	$filename='PDF: All Tests, '.$filter['user_filter_name'].' Yearly Report - '.$Yearo;

						// 	$PDF_document.='<br />
						// 					<table border="0" align="center">
						// 						<tr>
						// 							<td><center><b>Yearly Report, '.$filter['user_filter_name'].' - '.$Yearo.' </b></center></td>
						// 						</tr>
						// 					</table>';
						// }
					}
					
				}
	
			}// Yearly criteria chosen END


			if($Fromdate!="" && $Todate!="")// Custom dates chosen
			{
				if($report_type==3)// Tests < 350 
				{
					$pdf_data=$this->reports_model->tests_less_than350_customized($Fromdate,$Todate,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
				}
				if($report_type==4)
				{
					$this->reports_model->percentage_errors_customized_dates($Fromdate,$Todate,$Facility,$Device,$all_data,$report_type,$login_id,$county_name_value);
				}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests or Errors or Both Tests and Errors
				{
					$pdf_data=$this->reports_model->customized_dates_report($Fromdate,$Todate,$all_data,$Facility,$Device,$report_type,$login_id,$county_name_value);
				}

				if($Facility!="")//check if facility was selected
				{	
					$filename='PDF for '.$Facility.' - Between '.$Fromdate.' and '.$Todate;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Facility.' - Between '.$Fromdate.' and '.$Todate.'</b></center></td>';
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($Device!="")//check if device was selected
				{
					$filename='PDF for '.$Device.' - Between '.$Fromdate.' and '.$Todate;

					$PDF_document.='<br />';
					$PDF_document.='<table align="center">';
					$PDF_document.='<tr>';
					$PDF_document.='<td><center><b>Report for '.$Device.' - Between '.$Fromdate.' and '.$Todate.'</b></center></td>';
					$PDF_document.='</tr>';
					$PDF_document.='</table>';
				}
				if($all_data==3 || $all_data==4 || $all_data==5)//check if partner, county or all data
				{
					if($all_data==5)
					{
						$filename='PDF: All Tests Between '.$Fromdate.' and '.$Todate;

						$PDF_document.='<br />';
						$PDF_document.='<table border="0" align="center">';
						$PDF_document.='<tr>';
						$PDF_document.='<td><center><b>Report - Between '.$Fromdate.' and '.$Todate.'</b></center></td>';
						$PDF_document.='</tr>';
						$PDF_document.='</table>';
					}
					else if($all_data==4)
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
						// $user_filter=$this->session ->userdata('user_filter');

						// foreach($user_filter as $filter)
						// {
						// 	$filename='PDF: All Tests for '.$filter['user_filter_name'].' Between '.$customized_from.' and '.$customized_end;

						// 	$PDF_document.='<br />
						// 					<table border="0" align="center">
						// 						<tr>
						// 							<td><center><b>Report for '.$filter['user_filter_name'].' - Between '.$customized_from.' and '.$customized_end.'</b></center></td>
						// 						</tr>
						// 					</table>';
						// }
					}
				}
				
			}// Custom dates chosen END



			if($report_type==1)//tests 
			{
				$PDF_document.='<table border="0" align="center" width="680" class="data-table">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Successful Tests Done</th>';
				$PDF_document.='<th bgcolor="#eb9316" style="color:#FFF;">Tests < 500</th>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Tests >= 500</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_document.'</tr>';
				$PDF_document.='<tr><td align="center">'.$pdf_data['valid_tests'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['less_than350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['greater_equal_to350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['count'].'</td></tr>';
				$PDF_document.='</table>';

			}
			else if($report_type==2)//errors
			{
				$PDF_document.='<table width="480" border="0" align="center" class="data-table">';
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
				$PDF_document.='<table width="480" border="0" align="center" class="data-table">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#eb9316" style="color:#FFF;width:50%;"># Tests < 500</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;width:50%;">Total Number of Tests</th>';
				$PDF_document.='</tr>';
				$PDF_document.='<tr><td align="center">'.$pdf_data['less_than350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['count'].'</td></tr></table>';

			}
			else if($report_type==0)// All Tests
			{
				$PDF_document.='<table width="880" border="0" align="center" class="data-table">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Successful Tests Done</th>';
				$PDF_document.='<th bgcolor="#eb9316" style="color:#FFF;">Tests < 500</th>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Tests >= 500</th>';
				$PDF_document.='<th bgcolor="#CC0000" style="color:#FFF;">Tests With Errors</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_document.='</tr>';
				$PDF_document.='<tr><td align="center">'.$pdf_data['valid_tests'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['less_than350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['greater_equal_to350'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['errors'].'</td>';
				$PDF_document.='<td align="center">'.$pdf_data['count'].'</td></tr>';
				$PDF_document.='</table>';

			}
		
			

			$this->load->library('mpdf/mpdf');// Load the mpdf library

			$mpdf=new mPDF();//initialize

			ini_set("memory_limit",'-1');
			//ini_set("maximum_time_out",'');

			$mpdf->SetWatermarkText('NASCOP');//Water Mark Text
			$mpdf->watermark_size="0.2";
			$mpdf->showWatermarkText = true;//Water Mark set value
			$mpdf->simpleTables = true;

			if($all_data==5) //only for all data reporting
			{
				$mpdf->WriteHTML($PDF_document);//place content in pdf
			}
			else
			{	
				$PDF_document.=$table_style.'<br />'.$pdf_data['table']; //place details in table

				$mpdf->AddPage('L', // L - landscape, P - portrait
						            '', '', '', '',
						            30, // margin_left
						            30, // margin right
						            10, // margin top
						            30, // margin bottom
						            18, // margin header
						            12); // margin footer

				$mpdf->WriteHTML($PDF_document);//place content in pdf		
			}
			//$mpdf->Output($filename,'D'); //bring up "Save as Dialog" box
			$mpdf->Output($filename,'I');

			

		}
		/*..................................... End Format: PDF End if.............................................*/



		/*..................................... Format: Excel is selected..........................................*/
			else if($Format=="excel")
			{
				$this->load->model('reports_excel_model');//load reports_excel_model

				$filename="";
				if($YearM!="" && $monthly!="")// Month and Year chosen
				{
					$from_month=$YearM."-".$monthly.'-01';
				 	//$monthly+1;
				 	$num_days=cal_days_in_month(CAL_GREGORIAN, $monthly,$YearM);
		 			$end_month=$YearM.'-'.$monthly.'-'.$num_days;

				 	$month_name=$this->reports_model->GetMonthName($monthly);

					if($all_data>2)
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_less_than500_".$month_name."_".$YearM.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_month($YearM,$monthly,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
						}
						else
						{

							if($all_data==3)
							{
								$user_filter = $this->session -> userdata("user_filter");

								foreach($user_filter as $filter)
								{
									$filename="Excel_Report_".$filter['user_filter_name']."_".$month_name."_".$YearM.".xlsx";
								}
								
							}
							else if($all_data==4)
							{
								$county_id=$this->reports_model->get_county_id($county_name_value);

								$filename="Excel_Report_".$county_name_value."_".$month_name."_".$YearM.".xlsx";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_".$month_name."_".$YearM.".xlsx";
							}
							
							$PHPExcel[] = $this->reports_excel_model->excel_year_month_all($YearM,$monthly,$all_data,$from_month,$end_month,$report_type,$county_name_value);
						}
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than500_".$month_name."_".$YearM.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_month($YearM,$monthly,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
						}
						else
						{
							$filename="Excel_Report_Facility_Device_".$month_name."_".$YearM.".xlsx";

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
								$filename="Excel_Report_less_than500_Quarter_".$quarterly."_".$yearQ.".xlsx";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_quarter($yearQ,$quarter,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
							}
				 			else
				 			{
				 				if($all_data==3)
								{
									$user_filter = $this->session -> userdata("user_filter");

									foreach($user_filter as $filter)
									{
										$filename="Excel_Report_".$filter['user_filter_name']."_Quarter".$quarterly."_".$yearQ.".xlsx";
									}
								}
								else if($all_data==4)
								{
									$county_id=$this->reports_model->get_county_id($county_name_value);

									$filename="Excel_Report_".$county_name_value."_Quarter".$quarterly."_".$yearQ.".xlsx";
								}
								else if($all_data==5)
								{
									$filename="Excel_Report_All_Tests_Quarter".$quarterly."_".$yearQ.".xlsx";
								}
				 				$PHPExcel[] = $this->reports_excel_model->excel_year_quarter_all($yearQ,$quarter,$all_data,$from_month,$end_month,$report_type,$county_name_value);
				 			}
				 		}
				 		else
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_Facility_Device_less_than500_Quarter".$quarterly."_".$yearQ.".xlsx";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_quarter($yearQ,$quarter,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
							}
				 			else
				 			{
				 				$filename="Excel_Report_Facility_Device_Quarter".$quarterly."_".$yearQ.".xlsx";

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
								$filename="Excel_Report_less_than500_Biannual_".$biannual."_".$yearB.".xlsx";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_bian($yearB,$biannual_name,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
							}
				 			else
				 			{
				 				if($all_data==3)
								{
									$user_filter = $this->session -> userdata("user_filter");

									foreach($user_filter as $filter)
									{
										$filename="Excel_Report_".$filter['user_filter_name']."_Biannual".$biannual."_".$yearB.".xlsx";
									}
								}
								else if($all_data==4)
								{
									$county_id=$this->reports_model->get_county_id($county_name_value);

									$filename="Excel_Report_".$county_name_value."_Biannual".$biannual."_".$yearB.".xlsx";
								}
								else if($all_data==5)
								{
									$filename="Excel_Report_All_Tests_Biannual".$biannual."_".$yearB.".xlsx";
								}
				 				$PHPExcel[] = $this->reports_excel_model->excel_year_biannual_all($yearB,$biannual_name,$all_data,$from_month,$end_month,$report_type,$county_name_value);
				 			}
				 		}
				 		else
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_Facility_Device_less_than500_Biannual".$biannual."_".$yearB.".xlsx";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_bian($yearB,$biannual_name,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
							}
				 			else
				 			{
				 				$filename="Excel_Report_Facility_Device_Biannual".$biannual."_".$yearB.".xlsx";

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
							$filename="Excel_Report_less_than500_".$Yearo.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_yearly($Yearo,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
						}
						else
						{
							if($all_data==3)
							{
								$user_filter = $this->session -> userdata("user_filter");

								foreach($user_filter as $filter)
								{
									$filename="Excel_Report_".$filter['user_filter_name']."_".$Yearo.".xlsx";
								}
							}
							else if($all_data==4)
							{
								$county_id=$this->reports_model->get_county_id($county_name_value);

								$filename="Excel_Report_".$county_name_value."_".$Yearo.".xlsx";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_".$Yearo.".xlsx";
							}
							$PHPExcel[] = $this->reports_excel_model->excel_yearly_all($Yearo,$all_data,$from_month,$end_month,$report_type,$county_name_value);
						}
						
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than500_".$Yearo.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_yearly($Yearo,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$county_name_value);
						}
						else
						{
							$filename="Excel_Report_Facility_Device_".$Yearo.".xlsx";

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
							$filename="Excel_Report_less_than500_Custom_Dates_".$Fromdate."_".$Todate.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_customized($Facility,$Device,$Fromdate,$Todate,$report_type,$all_data,$county_name_value);
						}
						else
						{
							if($all_data==3)
							{
								$user_filter = $this->session -> userdata("user_filter");

								foreach($user_filter as $filter)
								{
									$filename="Excel_Report_".$filter['user_filter_name']."_Custom_Dates_".$Fromdate."_".$Todate.".xlsx";
								}
							}
							else if($all_data==4)
							{
								$county_id=$this->reports_model->get_county_id($county_name_value);

								$filename="Excel_Report_".$county_name_value."_Custom_Dates_".$Fromdate."_".$Todate.".xlsx";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_Custom_Dates_".$Fromdate."_".$Todate.".xlsx";
							}
							$PHPExcel[] = $this->reports_excel_model->excel_customized_dates_all($Fromdate,$Todate,$all_data,$report_type,$county_name_value);
						}
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than500_Custom_Dates_".$Fromdate."_".$Todate.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_customized($Facility,$Device,$Fromdate,$Todate,$report_type,$all_data,$login_id);
						}
						else
						{
							$filename="Excel_Report_Facility_Device_Custom_Dates_".$Fromdate."_".$Todate.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_customized_dates_report($Fromdate,$Todate,$Facility,$Device,$report_type);
						}
						
					}
					
				}

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');// *can use ms-excel2007
				header('Content-Disposition: attachment;filename="'.$filename.'" ');
				header('Cache-Control: max-age=0');
				$obWrite=PHPExcel_IOFactory::createWriter($this->excel,'Excel2007');
				$obWrite->save('php://output');
				
			}
			/*..................................... Format: Excel is selected End ..........................................*/

			/*..................................... Format: Graph is selected ..............................................*/

			else if($Format=="graph")
			{
				$this->load->model('reports_charts_model');//load model

				$category = array();
				
				$series_tests_and_errors = array();
				$series_tests_and_errors['name'] = 'Tests and Errors';
				$series_tests_and_errors['color']='#070B80';
				
				$series_tests = array();
				$series_tests['name'] = 'Tests';
				$series_tests['color']='#006600';
				
				$series_errors = array();
				$series_errors['name'] = 'Errors';
				$series_errors['color']='#FF0000';

				$series_lessthan350 = array();
				$series_lessthan350['name']='Tests < 500';
				$series_lessthan350['color']='#990000';

				$series_percentage_errors= array();
				$series_percentage_errors['name']='Errors';
				$series_percentage_errors['color']='#FF0000';

				$series_percentage_successful= array();
				$series_percentage_successful['name']='Successful Tests';
				$series_percentage_successful['color']='#006600';

				$result = array();

				if($YearM!="" && $monthly!="")//Monthly Graph
				{
					$data['customized']=0;

					$month_from_date="-01";
					$from_month=$YearM."-".$monthly.'-01';

				 	$num_days=cal_days_in_month(CAL_GREGORIAN, $monthly,$YearM);
		 			$end_month=$YearM.'-'.$monthly.'-'.$num_days;

				 	$test_results=$this->reports_charts_model->month_graph_view($YearM,$monthly,$Facility,$Device,$all_data,$county_name_value,$report_type);

				 	$category[]=$this->reports_model->GetMonthName($monthly);

				}//Monthly Graph END

				if($yearQ!="" && $quarterly!="")//Quarterly Graph
				{
					$data['customized']=0;
					if($quarterly==1)
				 	{			 		
				 		$from_month=$yearQ.'-01-01';
				 		$end_month=$yearQ.'-04-30';
				 		$quarter="January - April";
				 		$end=5;

				 	}
				 	else if($quarterly==2)
				 	{
				 		$from_month=$yearQ.'-05-01';
				 		$end_month=$yearQ.'-08-31';
				 		$quarter="May - August";
				 		$end=9;
				 	}
				 	else if($quarterly==3)
				 	{
				 		$from_month=$yearQ.'-09-01';
				 		$end_month=$yearQ.'-12-31';
				 		$quarter="September - December";
				 		$end=13;

				 	}
				 	for($i=1; $i< $end;$i++)
				 	{
				 		$category[]=$this->reports_model->GetMonthName($i);
				 	}

				 	$test_results=$this->reports_charts_model->quarter_graph_view($yearQ,$quarterly,$Facility,$Device,$all_data,$county_name_value,$report_type);
					
				}//Quarterly Graph End

				if($yearB!="" && $biannual!="")//Biannual Graph
				{
					$data['customized']=0;

					if($biannual==1)
					{
						$from_month=$yearB.'-01-01';
				 		$end_month=$yearB.'-06-30';
				 		$biannual_name="January - June";
				 		$end=7;					
					}
					else if($biannual==2)
					{
						$from_month=$yearB.'-07-01';
				 		$end_month=$yearB.'-12-31';
				 		$biannual_name="July - December";
				 		$end=13;
					}

					for($i=1; $i< $end;$i++)
				 	{
				 		$category[]=$this->reports_model->GetMonthName($i);
				 	}

				 	$test_results=$this->reports_charts_model->biannual_graph_view($yearB,$biannual,$Facility,$Device,$all_data,$county_name_value,$report_type);
				
				}//Biannual Graph End

				if($Yearo!="")//Yearly Graph 
				{
					$data['customized']=0;

					$from_month=$Yearo.'-01-01';
					$end_month=$Yearo.'-12-31';
					$end=13;

					for($i=1; $i< $end;$i++)
				 	{
				 		$category[]=$this->reports_model->GetMonthName($i);
				 	}

				 	$test_results=$this->reports_charts_model->year_graph_view($Yearo,$Facility,$Device,$all_data,$county_name_value,$report_type);
				
				}//Yearly Graph End

				if($Fromdate!="" && $Todate!="")// Custom dates Graph
				{
					$month_limit_begin=date('m',strtotime($Fromdate));//month limit
					$month_limit_end=date('m',strtotime($Todate));

					$year_begin=date('Y',strtotime($Fromdate));//year limit
					$year_end=date('Y',strtotime($Todate));

					$new_from_date=date('d-F-Y',strtotime($Fromdate));
					$new_to_date=date('d-F-Y',strtotime($Todate));

					$category[]=$new_from_date;
					$category[]=$new_to_date;
					$c="Customized_Dates";

					$test_results=$this->reports_charts_model->customized_graph_view($month_limit_begin,$month_limit_end,$year_begin,$year_end,$Facility,$Device,$all_data,$county_name_value,$report_type);
					
					$data['customized']=1;//set a subtitle
					$data['customized_value']=$new_from_date;

				}// Custom dates Graph End

			 	if($report_type==1 || $report_type==2 || $report_type==0)//Tests only or Errors only or Both Tests and Errors
			 	{
			 		$data['percentage_flag']=0;
			 		$series_tests_and_errors['data']=$test_results['both_results'];//Fetch
			 		
			 		if($report_type==1)
			 		{
			 			$series_tests['data']=$test_results['tests'];
			 			
			 			array_push($result,$series_tests_and_errors);
			 			array_push($result,$series_tests);

			 		}
			 		else if($report_type==2)
			 		{
			 			$series_errors['data']=$test_results['errors'];
			 			
			 			array_push($result,$series_tests_and_errors);
			 			array_push($result,$series_errors);
			 		}
			 		else if($report_type==0)
			 		{
			 			$series_tests['data']=$test_results['tests'];

			 			$series_errors['data']=$test_results['errors'];

			 			array_push($result,$series_tests_and_errors);
			 			array_push($result,$series_tests);
			 			array_push($result,$series_errors);
			 		}
			 		
			 	}
			 	else if($report_type==3)//Tests < 500
			 	{
			 		$data['percentage_flag']=0;
			 		$series_tests_and_errors['data']=$test_results['both_results'];//Fetch

			 		$series_lessthan350['data']=$test_results['tests'];

			 		array_push($result,$series_tests_and_errors);
		 			array_push($result,$series_lessthan350);

		 			// print_r($result);
		 			// die;

			 	}
			 	else if($report_type==4)//Errors By Percentage
			 	{
			 		$data['percentage_flag']=1;
			 		$series_percentage_successful['data']=$test_results['tests'];//Fetch

			 		$series_percentage_errors['data']=$test_results['errors'];

			 		array_push($result,$series_percentage_successful);
		 			array_push($result,$series_percentage_errors);
			 	}

				$data['graph_data']=$result;
				$data['categories']=$category;


				$data['content_view'] = "admin/report_graph_view";
				$data['title'] = "Reports - Graphs";
				$data['sidebar']	= "admin/sidebar_view";
				$data['filter']	=	false;
				$data	=array_merge($data,$this->load_libraries(array('highcharts')));
				
				$this->load->model('admin_model');

				$data['menus']	= 	$this->admin_model->menus(5);

				$this -> template($data);
				
			}

			/*..................................... Format: Graph is selected ..............................................*/
	}
	/*======================================== End of get_reports function report ========================================*/

}
/* End of file reports.php */
/* Location: ./application/modules/admin/controller/reports.php */