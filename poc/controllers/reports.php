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
			$data['yearlyReports']=$this->reports_model->getyearsreported();

			//$data['partner_option']=$user_group;

			$data['combo_box_county_option']="";// to remove error on view page source

			$data['FacilitiesList']= $this->poc_model->devices_reported();

			$user_filter = $this->session -> userdata("user_filter");

			if($user_filter)
			{ 
				foreach ($user_filter as $filter) 
				{
					$data['partner_option']='<option value="3">Show All Data For '.$filter["user_filter_name"].'</option>'; 
					$this->set_user_filter($filter["user_filter_id"]);
				} 
			}
		}
		else if($user_group==9)// county co-cordinator
		{
			$data['yearlyReports']=$this->reports_model->getyearsreported();
			
			$data['partner_option']=0; // to remove error on view page source

			$data['FacilitiesList']=$this->poc_model->devices_reported();

			$user_filter = $this->session -> userdata("user_filter");

			if($user_filter)
			{ 
				foreach ($user_filter as $filter) 
				{
					$data['combo_box_county_option']='<option value="4">Show My County</option>'; 
					$this->set_user_filter($filter["user_filter_id"]);
				} 
			}
		}

		$data['menus']	= 	$this->poc_model->menus(5);

		$data['devices_not_reported'] = $this->poc_model->devices_not_reported();
		
		$data['errors_agg'] = $this->poc_model->errors_reported();

		$data['DeviceNumberOptions'] = 	$this->poc_model->devices_reported();

		
		$this -> template($data);
		
	}

/*================================= Report Specs Function ======================================================*/
	function get_report()
	{	
		ini_set('max_execution_time', 1600);

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

		$table_style='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
						table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
						table.data-table td, table th {padding: 4px;}
						table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
					</style>';

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

			if($YearM!="" && $monthly!="")// Month and Year chosen
			{
				/*
					set a default start date and end date for the month selected

				*/
				$month_from_date="-01";
				$from_month=$YearM."-".$monthly.$month_from_date;
			 	//$monthly++;
			 	$num_days=cal_days_in_month(CAL_GREGORIAN, $monthly,$YearM);
	 			$end_month=$YearM.'-'.$monthly.'-'.$num_days;
		 	
			 	if($report_type==3)// Tests < 350 
			 	{
			 		$pdf_data=$this->reports_model->tests_less_than350_month($from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
			 		
			 	}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_month_report($all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
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
			}// Month and Year chosen END

			if($yearQ!="" && $quarterly!="")// Quarter and Year chosen
			{
				/*
					set a default start date and end date for the month selected

				*/
			 	if($quarterly==1)
			 	{		 		
			 		$from_month=$yearQ.'-01-01';
				 	$end_month=$yearQ.'-03-31';
			 		$quarter="January - March";

			 	}
			 	else if($quarterly==2)
			 	{
			 		$from_month=$yearQ.'-04-01';
				 	$end_month=$yearQ.'-06-30';
			 		$quarter="April - June";
			 	}
			 	else if($quarterly==3)
			 	{
			 		$from_month=$yearQ.'-07-01';
				 	$end_month=$yearQ.'-09-30';
			 		$quarter="July - September";
			 	}
			 	else if($quarterly==4)
			 	{
			 		$from_month=$yearQ.'-10-01';
			 		$end_month=$yearQ.'-12-31';
			 		$quarter="October - December";
			 	}	

			 	if($report_type==3)// Tests < 350 
		 		{
		 			$pdf_data=$this->reports_model->tests_less_than350_quarter($from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
		 		}
		 		
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{	
					$pdf_data=$this->reports_model->year_quarter_report($all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
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
							$PDF_document.='<center><b>Report for all tests for '.$filter['user_filter_name'].' - '.$quarter.', '.$yearQ.' </b></center>';
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
		 			$pdf_data=$this->reports_model->tests_less_than350_bian($from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);
		 		}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_biannual_report($all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
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
					$pdf_data=$this->reports_model->tests_less_than350_yearly($from_month,$end_month,$Facility,$Device,$all_data,$report_type,$login_id);				

				}
				else if($report_type==1 || $report_type==2 || $report_type==0)// Tests, Errors, Both Tests and Errors
				{
					$pdf_data=$this->reports_model->year_report($all_data,$Facility,$Device,$from_month,$end_month,$report_type,$login_id);
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
				$PDF_document.='<table border="0" align="center" width="680" class="data-table">';
				$PDF_document.='<tr>';
				$PDF_document.='<th bgcolor="#006600" style="color:#FFF;">Successful Tests Done</th>';
				$PDF_document.='<th bgcolor="#990000" style="color:#FFF;">Tests < 500</th>';
				$PDF_document.='<th bgcolor="#eb9316" style="color:#FFF;">Tests >= 500</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_document.='</tr>';
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
				$PDF_document.='<th bgcolor="#eb9316" style="color:#FFF;"># Tests < 500</th>';
				$PDF_document.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
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
			$PDF_document.=$table_style.'<br />'.$pdf_data['table']; //place details in table
			// echo $PDF_document;
			// die;
			$this->load->library('mpdf/mpdf');// Load the mpdf library

			$mpdf=new mPDF();//initialize

			$mpdf->AddPage('L', // L - landscape, P - portrait
						            '', '', '', '',
						            30, // margin_left
						            30, // margin right
						            10, // margin top
						            30, // margin bottom
						            18, // margin header
						            12); // margin footer

			$mpdf->SetWatermarkText('NASCOP',0.09);//Water Mark Text
			$mpdf->watermark_size="0.2";
			$mpdf->showWatermarkText = true;//Water Mark set value

			$mpdf->simpleTables = true;
			$mpdf->WriteHTML($PDF_document);//place content in pdf

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
					
				 	$num_days=cal_days_in_month(CAL_GREGORIAN, $monthly,$YearM);
		 			$end_month=$YearM.'-'.$monthly.'-'.$num_days;

				 	$month_name=$this->reports_model->GetMonthName($monthly);

					if($all_data>2)
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_less_than500_".$month_name."_".$YearM.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_month($YearM,$monthly,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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
								$county_name=$this->reports_model->get_county_name($login_id);

								$filename="Excel_Report_".$county_name."_".$month_name."_".$YearM.".xlsx";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_".$month_name."_".$YearM.".xlsx";
							}
							
							$PHPExcel[] = $this->reports_excel_model->excel_year_month_all($YearM,$monthly,$all_data,$from_month,$end_month,$report_type,$login_id);
						}
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than500_".$month_name."_".$YearM.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_month($YearM,$monthly,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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
				 		$end_month=$yearQ.'-03-31';
				 		$quarter="January - March";
				 	}
				 	else if($quarterly==2)
					{
						$from_month=$yearQ.'-04-01';
				 		$end_month=$yearQ.'-06-30';
				 		$quarter="April - June";

				 	}
				 	else if($quarterly==3)
					{
						$from_month=$yearQ.'-07-01';
				 		$end_month=$yearQ.'-09-30';
				 		$quarter="July - September";

				 	}
				 	else if($quarterly==4)
					{
						$from_month=$yearQ.'-10-01';
				 		$end_month=$yearQ.'-12-31';
				 		$quarter="October - December";

				 	}	

				 		if($all_data>2)
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_less_than500_Quarter_".$quarterly."_".$yearQ.".xlsx";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_quarter($yearQ,$quarter,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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
									$county_name=$this->reports_model->get_county_name($login_id);

									$filename="Excel_Report_".$county_name."_Quarter".$quarterly."_".$yearQ.".xlsx";
								}
								else if($all_data==5)
								{
									$filename="Excel_Report_All_Tests_Quarter".$quarterly."_".$yearQ.".xlsx";
								}
				 				$PHPExcel[] = $this->reports_excel_model->excel_year_quarter_all($yearQ,$quarter,$all_data,$from_month,$end_month,$report_type,$login_id);
				 			}
				 		}
				 		else
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_Facility_Device_less_than500_Quarter".$quarterly."_".$yearQ.".xlsx";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_quarter($yearQ,$quarter,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_bian($yearB,$biannual_name,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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
									$county_name=$this->reports_model->get_county_name($login_id);

									$filename="Excel_Report_".$county_name."_Biannual".$biannual."_".$yearB.".xlsx";
								}
								else if($all_data==5)
								{
									$filename="Excel_Report_All_Tests_Biannual".$biannual."_".$yearB.".xlsx";
								}
				 				$PHPExcel[] = $this->reports_excel_model->excel_year_biannual_all($yearB,$biannual_name,$all_data,$from_month,$end_month,$report_type,$login_id);
				 			}
				 		}
				 		else
				 		{
				 			if($report_type==3)// Tests < 350 
							{
								$filename="Excel_Report_Facility_Device_less_than500_Biannual".$biannual."_".$yearB.".xlsx";

								$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_bian($yearB,$biannual_name,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_yearly($Yearo,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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
								$county_name=$this->reports_model->get_county_name($login_id);

								$filename="Excel_Report_".$county_name."_".$Yearo.".xlsx";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_".$Yearo.".xlsx";
							}
							$PHPExcel[] = $this->reports_excel_model->excel_yearly_all($Yearo,$all_data,$from_month,$end_month,$report_type,$login_id);
						}
						
					}
					else
					{
						if($report_type==3)// Tests < 350 
						{
							$filename="Excel_Report_Facility_Device_less_than500_".$Yearo.".xlsx";

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_yearly($Yearo,$Facility,$Device,$from_month,$end_month,$report_type,$all_data,$login_id);
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

							$PHPExcel[] = $this->reports_excel_model->excel_tests_lessthan350_customized($Facility,$Device,$Fromdate,$Todate,$report_type,$all_data,$login_id);
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
								$county_name=$this->reports_model->get_county_name($login_id);

								$filename="Excel_Report_".$county_name."_Custom_Dates_".$Fromdate."_".$Todate.".xlsx";
							}
							else if($all_data==5)
							{
								$filename="Excel_Report_All_Tests_Custom_Dates_".$FromDate."_".$Todate.".xlsx";
							}
							$PHPExcel[] = $this->reports_excel_model->excel_customized_dates_all($Fromdate,$Todate,$all_data,$report_type,$login_id);
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


			}/*..................................... Format: Excel is selected End ..........................................*/

			/*..................................... Format: Excel is selected End ..........................................*/

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
				$series_lessthan350['color']='#eb9316';

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

				 	$test_results=$this->reports_charts_model->month_graph_view($YearM,$monthly,$Facility,$Device,$all_data,$login_id,$report_type);

				 	$category[]=$this->reports_model->GetMonthName($monthly);

				}//Monthly Graph END

				if($yearQ!="" && $quarterly!="")//Quarterly Graph
				{
					$data['customized']=0;
					if($quarterly==1)
				 	{			 		
				 		$from_month=$yearQ.'-01-01';
				 		$end_month=$yearQ.'-03-31';

				 	}
				 	else if($quarterly==2)
				 	{
				 		$from_month=$yearQ.'-04-01';
				 		$end_month=$yearQ.'-06-30';
				 	}
				 	else if($quarterly==3)
				 	{
				 		$from_month=$yearQ.'-07-01';
				 		$end_month=$yearQ.'-09-30';
				 	}
				 	else if($quarterly==4)
				 	{
				 		$from_month=$yearQ.'-09-01';
				 		$end_month=$yearQ.'-12-31';

				 	}
				 	for($i=1; $i< $end;$i++)
				 	{
				 		$category[]=$this->reports_model->GetMonthName($i);
				 	}

				 	$test_results=$this->reports_charts_model->quarter_graph_view($yearQ,$quarterly,$Facility,$Device,$all_data,$login_id,$report_type);
					
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
				 	
				 	$test_results=$this->reports_charts_model->biannual_graph_view($yearB,$biannual,$Facility,$Device,$all_data,$login_id,$report_type);
				
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

				 	$test_results=$this->reports_charts_model->year_graph_view($Yearo,$Facility,$Device,$all_data,$login_id,$report_type);
				
				}//Yearly Graph End

				if($Fromdate!="" && $Todate!="")// Custom dates Graph
				{
					$month_limit_begin=date('m',strtotime($Fromdate));//month limit
					$month_limit_end=date('m',strtotime($Todate));

					$new_from_date=date('d-F-Y',strtotime($Fromdate));
					$new_to_date=date('d-F-Y',strtotime($Todate));

					$category[]=$this->reports_model->GetMonthName($month_limit_begin);
					$category[]=$this->reports_model->GetMonthName($month_limit_end);

					$test_results=$this->reports_charts_model->customized_graph_view($Fromdate,$Todate,$Facility,$Device,$all_data,$login_id,$report_type);
					
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
			 	else if($report_type==3)//Tests < 350
			 	{
			 		$data['percentage_flag']=0;
			 		$series_tests_and_errors['data']=$test_results['both_results'];//Fetch

			 		$series_lessthan350['data']=$test_results['tests'];

			 		array_push($result,$series_tests_and_errors);
		 			array_push($result,$series_lessthan350);

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


				$data['content_view'] = "poc/report_graph_view";
				$data['title'] = "Reports - Graphs";
				$data['sidebar']	= "poc/sidebar_view";
				$data['filter']	=	false;
				$data	=array_merge($data,$this->load_libraries(array('highcharts')));
				
				$this->load->model('poc_model');

				$data['menus']	= 	$this->poc_model->menus(5);

				$data['devices_not_reported'] = $this->poc_model->devices_not_reported();
		
				$data['errors_agg'] = $this->poc_model->errors_reported();

				$this -> template($data);
			}
			/*..................................... Format: Excel is selected End ..........................................*/

	}/*================================= End get report Function ==========================================================*/
		
	}
/* End of file reports.php */
/* Location: ./application/modules/poc/controller/reports.php */