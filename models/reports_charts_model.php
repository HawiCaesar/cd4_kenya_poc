<?php

class reports_charts_model extends CI_Model{

	/*$new_device = str_replace("%20", " ",$device);*/
	
	/*====================== Facility by month =====================================================================*/
	public function year_month_facility_chart($facility,$test,$errors,$total,$monthname,$the_year,$report_type)
	{
		$Chart="";
		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);

		$file_name=$new_facility.'_'.$monthname.'_'.$the_year;

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		$Chart.="<category label='$monthname'/>";
		$Chart.= '</categories>';

		if($report_type==1)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==2)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==0)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==3)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF00000" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;


	}
/*============================= Facility by month End ============================================================*/

/*============================= Device by month ==================================================================*/

	function year_month_device_chart($device,$test,$errors,$total,$monthname,$the_year,$report_type)
	{
		$Chart="";
		$export_handler='http://export.api3.fusioncharts.com/';

		$file_name=$device.'_'.$monthname.'_'.$the_year;

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.', '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		$Chart.="<category label='$monthname'/>";
		$Chart.= '</categories>';

		if($report_type==1)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==2)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==0)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==3)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests &lt; 350 " color="FF00000" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}	
/*================================================ Device by month End ==============================================*/

/*========================================== All by month ===========================================================*/

	function year_month_chart($test,$errors,$total,$monthname,$the_year,$report_type,$all)
	{
		$Chart="";

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Tests_'.$filter['user_filter_name'].'_'.$monthname.'_'.$the_year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Report for all tests '.$filter['user_filter_name'].', '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
		}
		else if($all==5)
		{
			$file_name='All_Tests_'.$monthname.'_'.$the_year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Report for all tests, '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}

		
		$Chart.='<categories>';
		$Chart.="<category label='$monthname'/>";
		$Chart.= '</categories>';

		if($report_type==1)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==2)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==0)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==3)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests &lt; 350 " color="FF00000" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}	

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
/*================================ All by month End ================================================================*/

/*================================ facility by quarter =============================================================*/

	function year_quarter_facility_tests_chart($facility,$quarter,$the_year,$report_type)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);

		$file_name=$new_facility.'_Tests_Quarter'.$quarter.'_'.$the_year;
		$device="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			$device="";
			$all="";

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";
									
					}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
				for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{
			  			$tests_done=0;

			  			$test_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);

			  			if($test_results!="")
			  			{
			  				foreach($test_results as $res)
							{
								$tests_done=$res['data'];
							}
			  			}
			  			else
			  			{
			  				$tests_done=0;
			  			}
			  			$Chart.= "<set value='$tests_done'/>";
									
					}
			$Chart.= '</dataset>';
				

		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$test_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($test_results!="")
						{
							foreach($test_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_quarter_facility_errors_chart($facility,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);

		$file_name=$new_facility.'_Errors_Quarter'.$quarter.'_'.$the_year;

		$all="";
		$device="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		
		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
	function year_quarter_facility_chart($facility,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);

		$file_name=$new_facility.'_Tests_and_Errors_Quarter'.$quarter.'_'.$the_year;
		$all="";
		$device="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		
		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
/*================================ facility by quarter End =========================================================*/

/*================================ device by quarter ===============================================================*/

	function year_quarter_device_tests_chart($device,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Tests_Quarter'.$quarter.'_'.$the_year;
		$all="";
		$facility="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_quarter_device_errors_chart($device,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Errors_Quarter'.$quarter.'_'.$the_year;

		$facility="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_quarter_device_chart($device,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Tests_and_Errors_Quarter'.$quarter.'_'.$the_year;

		$all="";
		$facility="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		
		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
/*========================================= device by quarter End ===================================================*/

/*========================================= All by quarter =========================================================*/

	function year_quarter_all_tests_chart($all,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");
		$facility="";
		$device="";


		if($all==3)
		{	
			foreach($user_filter as $filter)
			{
				$file_name='All_Tests_'.$filter['user_filter_name'].'_Quarter_'.$quarter.'_'.$the_year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data - '.$filter['user_filter_name'].'- Successful Tests,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
			
		}
		else if($all==5)
		{
			$file_name='All_Tests_Quarter'.$quarter.'_'.$the_year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data - Successful Tests,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
		
		
		$Chart.='<categories>';

		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_quarter_all_errors_chart($all,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Errors_'.$filter['user_filter_name'].'_Quarter'.$quarter.'_'.$the_year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].' - Errors,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'"  >';
			}
		}
		else if($all==5)
		{
			$file_name='All_Errors_Quarter'.$quarter.'_'.$the_year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data - Errors,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
		
		
		$Chart.='<categories>';

		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_quarter_all_chart($all,$quarter,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Tests_and_Errors_'.$filter['user_filter_name'].'_Quarter'.$quarter.'_'.$the_year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].', '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
		}
		else if($all==5)
		{
			$file_name='All_Tests_and_Errors_Quarter'.$quarter.'_'.$the_year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}

		
		$Chart.='<categories>';

		if($quarter==1)
		{
			$startmonth=1;
			$endmonth=4;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}

		else if($quarter==2)
		{
			$start=5;
			$endmonth=8;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=5;$startmonth< 9;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		else if($quarter==3)
		{
			$startmonth=9;
			$endmonth=12;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=9;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}


/*=============================================== All by quarter End===============================================*/

/*=============================================== facility by biannual=============================================*/

	function year_bian_facility_tests_chart($facility,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);
		$file_name=$new_facility.'_Tests_Biannual'.$bian.'_'.$the_year;

		$device="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		
		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_bian_facility_errors_chart($facility,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);
		$file_name=$new_facility.'_Errors_Biannual'.$bian.'_'.$the_year;

		$device="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		
		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}


	function year_bian_facility_chart($facility,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);
		$file_name=$new_facility.'Tests_and_Errors_Biannual'.$bian.'_'.$the_year;

		$device="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		
		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

/*====================== facility by biannual End=============================================*/

/*====================== device by biannual==================================================*/

	function year_bian_device_tests_chart($device,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Tests_Biannual'.$bian.'_'.$the_year;

		$facility="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_bian_device_errors_chart($device,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Errors_Biannual'.$bian.'_'.$the_year;

		$facility="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}


	function year_bian_device_chart($device,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Tests_and_Errors_Biannual'.$bian.'_'.$the_year;

		$facility="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
/*============================================= device by biannual End =============================================*/

/*====================== ====================== All by biannual End ===============================================*/

	function year_bian_all_tests_chart($all,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Tests_'.$filter['user_filter_name'].'_Biannual'.$bian.'_'.$the_year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].', '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
			
		}
		else if($all==5)
		{
			$file_name='All_Tests_Biannual'.$bian.'_'.$the_year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
	
		$Chart.='<categories>';

		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";;

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function year_bian_all_errors_chart($all,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Errors_'.$filter['user_filter_name'].'_Biannual'.$bian.'_'.$the_year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].', '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
			
		}
		else if($all==5)
		{
			$file_name='All_Errors_Biannual'.$bian.'_'.$the_year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data, '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
		
		
		$Chart.='<categories>';

		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";
				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}


	function year_bian_all_chart($all,$bian,$the_year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Tests_and_Errors_'.$filter['user_filter_name'].'_Biannual'.$bian.'_'.$the_year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].', '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
			
		}
		else if($all==5)
		{
			$file_name='All_Tests_and_Errors_Biannual'.$bian.'_'.$the_year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
		
		
		$Chart.='<categories>';

		if($bian==1)
		{
			$startmonth=1;
			$endmonth=6;

			for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
		  		{  

			  		$monthname=$this->GetMonthName($startmonth);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';

		}

		else if($bian==2)
		{
			$start=7;
			$endmonth=12;

			for($start;  $start<=$endmonth;  $start++)
		  		{  

			  		$monthname=$this->GetMonthName($start);

					$Chart.="<category label='$monthname'/>";

				}
			$Chart.= '</categories>';
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			for ( $startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";
				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			for ( $startmonth=1;$startmonth< 7;  $startmonth++)
			  		{ 
				  		$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

				  	}
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
			for ($startmonth=7;$startmonth< 13;  $startmonth++)
			  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

				  	}
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

/*=============================================== All by biannual End===============================================*/

/*=============================================== facility by year==================================================*/

	function yearly_facility_tests_chart($facility,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);
		$file_name=$new_facility.'_Tests_'.$year;

		$device="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="CD4 Chart">';
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function yearly_facility_errors_chart($facility,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);
		$file_name=$new_facility.'_Errors_'.$year;

		$device="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function yearly_facility_chart($facility,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);
		$file_name=$new_facility.'_Tests_and_Errors_'.$year;

		$device="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($new_facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
				  		$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($new_facility,$device,$all,$startmonth,$year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

/*================================================ facility by year End =============================================*/

/*================================================ device by year ===================================================*/

	function yearly_device_tests_chart($device,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Tests_'.$year;

		$facility="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function yearly_device_errors_chart($device,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Errors_'.$year;

		$facility="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  		$tests_done=0;

					$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$year);						
					
					if($tests_results!="")
					{
						foreach($tests_results as $res)
						{
							$tests_done=$res['data'];
	
						}
					}
					else
					{
						$tests_done=0;
					}
					$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

	function yearly_device_chart($device,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'Tests_and_Errors_'.$year;

		$facility="";
		$all="";

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

/*=============================================== device by year End ===============================================*/

/*=============================================== All by year ======================================================*/

	function yearly_all_tests_chart($all,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Tests_'.$filter['user_filter_name'].'_'.$year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].' - Successful Tests,'.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
		}
		else if($all==5)
		{
			$file_name='All_Tests_'.$year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data - Successful Tests,'.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}

		
		
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
	function yearly_all_errors_chart($all,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');
		$export_handler='http://export.api3.fusioncharts.com/';

		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Errors_'.$filter['user_filter_name'].'_'.$year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].' - Errors,'.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
			
		}
		else if($all==5)
		{
			$file_name='All_Errors_'.$year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data - Errors,'.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
		
		
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
	function yearly_all_chart($all,$year)
	{
		$Chart="";
		$this->load->model('reports_charts_sql_model');

		$export_handler='http://export.api3.fusioncharts.com/';

		$user_filter = $this->session -> userdata("user_filter");

		$facility="";
		$device="";

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Tests_and_Errors_'.$filter['user_filter_name'].'_'.$year;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data '.$filter['user_filter_name'].', '.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
		}
		else if($all==5)
		{
			$file_name='All_Tests_and_Errors_'.$year;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all data,'.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
		
		
		
		$Chart.='<categories>';

		$startmonth=1;
		$endmonth=12;

		for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
	  		{  

		  		$monthname=$this->GetMonthName($startmonth);

				$Chart.="<category label='$monthname'/>";

			}
		$Chart.= '</categories>';
		$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$all_done=0;

						$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
						
						if($all_results!="")
						{
							foreach($all_results as $res)
							{
								$all_done=$res['data'];
		
							}
						}
						else
						{
							$all_done=0;
						}
						$Chart.= "<set value='$all_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$tests_done=0;

						$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$year);						
						
						if($tests_results!="")
						{
							foreach($tests_results as $res)
							{
								$tests_done=$res['data'];
		
							}
						}
						else
						{
							$tests_done=0;
						}
						$Chart.= "<set value='$tests_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
		for ( $startmonth=1;$startmonth< 13;  $startmonth++)
		  		{ 
			  			$errors_done=0;

						$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$year);						
						
						if($error_results!="")
						{
							foreach($error_results as $res)
							{
								$errors_done=$res['data'];
		
							}
						}
						else
						{
							$errors_done=0;
						}
						$Chart.= "<set value='$errors_done'/>";

			  	}
		$Chart.= '</dataset>';

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}

/*================================================ All by year End =================================================*/

/*================================================ facility customized dates =======================================*/

	function customized_dates_facility_chart($facility,$test,$errors,$total,$from,$to,$report_type)
	{
		$Chart="";

		$export_handler='http://export.api3.fusioncharts.com/';
		$new_facility = str_replace("%20", " ",$facility);
		$file_name=$new_facility.'_Customized_dates_'.$from.'_to_'.$to;

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		$Chart.="<category label=' Between $from and $to '/>";
		$Chart.= '</categories>';

		if($report_type==1)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==2)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==0)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==3)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests &lt; 350 " color="FF0000" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;


	}
/*=============================================== facility customized dates End ===================================*/

/*=============================================== device customized dates =========================================*/

	function customized_dates_device_chart($device,$test,$errors,$total,$from,$to,$report_type)
	{
		$Chart="";

		$export_handler='http://export.api3.fusioncharts.com/';
		$file_name=$device.'_Customized_dates_'.$from.'_to_'.$to;

		$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		$Chart.='<categories>';
		$Chart.="<category label=' Between $from and $to '/>";
		$Chart.= '</categories>';

		if($report_type==1)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==2)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==0)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==3)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests &lt; 350 " color="FF0000" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}

		

		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;


	}


	
/*================================================ device customized dates End =====================================*/

/*================================================= all customized dates ===========================================*/

	function customized_dates_all_chart($test,$errors,$total,$less_than350,$from,$to,$report_type,$all)
	{
		$Chart="";

		$export_handler='http://export.api3.fusioncharts.com/';
		$user_filter = $this->session -> userdata("user_filter");

		if($all==3)
		{
			foreach($user_filter as $filter)
			{
				$file_name='All_Data_Customized_dates_'.$filter['user_filter_name'].'_'.$from.'_to_'.$to;
				$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests '.$filter['user_filter_name'].' " exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			}
		}
		else if($all==5)
		{
			$file_name='All_Data_Customized_dates'.$from.'_to_'.$to;
			$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
		}
		
		$Chart.='<categories>';
		$Chart.="<category label=' Between $from and $to '/>";
		$Chart.= '</categories>';

		if($report_type==1)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==2)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==0)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
			$Chart.= "<set value='$test'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
			$Chart.= "<set value='$errors'/>";
			$Chart.= '</dataset>';
		}
		else if($report_type==3)
		{
			$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
			$Chart.= "<set value='$total'/>";
			$Chart.= '</dataset>';

			$Chart.= '<dataset seriesName="Tests &lt; 350 " color="FF0000" >';
			$Chart.= "<set value='$less_than350'/>";
			$Chart.= '</dataset>';

		}
		
		$Chart.='<styles>
							<definition>
								<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
								<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
								<style name="DataShadow" type="Shadow" alpha="40"/>
							</definition>
							-
							<application>
								<apply toObject="DIVLINES" styles="Anim1"/>
								<apply toObject="HGRID" styles="Anim2"/>
								<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
							</application>
						</styles>
						</chart>';
		return $Chart;
	}
/*====================== all customized dates End =======================================*/

		public function GetMonthName($month)
		{
			 if ($month==1)
			 {
			     $monthname=" Jan ";
			 }
			  else if ($month==2)
			 {
			     $monthname=" Feb ";
			 }else if ($month==3)
			 {
			     $monthname=" Mar ";
			 }else if ($month==4)
			 {
			     $monthname=" Apr ";
			 }else if ($month==5)
			 {
			     $monthname=" May ";
			 }else if ($month==6)
			 {
			     $monthname=" Jun ";
			 }else if ($month==7)
			 {
			     $monthname=" Jul ";
			 }else if ($month==8)
			 {
			     $monthname=" Aug ";
			 }else if ($month==9)
			 {
			     $monthname=" Sep ";
			 }else if ($month==10)
			 {
			     $monthname=" Oct ";
			 }else if ($month==11)
			 {
			     $monthname=" Nov ";
			 }
			  else if ($month==12)
			 {
			     $monthname=" Dec ";
			 }
			  else if ($month==13)
			 {
			     $monthname=" Jan - Sep  ";
			 }
		return $monthname;
		}

/*================================Facility Functions=================================================*/
		


		function year_month_county_chart($county_name,$test,$errors,$total,$monthname,$the_year,$report_type)
		{
				$Chart="";

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_'.$monthname.'_'.$the_year;

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';
				$Chart.="<category label='$monthname'/>";
				$Chart.= '</categories>';

				if($report_type==1)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					$Chart.= "<set value='$test'/>";
					$Chart.= '</dataset>';
				}
				else if($report_type==2)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
					$Chart.= "<set value='$errors'/>";
					$Chart.= '</dataset>';
				}
				else if($report_type==0)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					$Chart.= "<set value='$test'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
					$Chart.= "<set value='$errors'/>";
					$Chart.= '</dataset>';
				}
				else if($report_type==3)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests &lt; 350 " color="FF0000" >';
					$Chart.= "<set value='$test'/>";
					$Chart.= '</dataset>';
				}
				

				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;


		}

		/*========================= County: Quarterly ============================================================*/

		function year_quarter_county_tests($county_name,$quarter,$the_year,$all)
		{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Tests_Quarter'.$quarter.'_'.$the_year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';
				
				if($quarter==1)
				{
					$startmonth=1;
					$endmonth=4;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=1;$startmonth< 5;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=1;$startmonth< 5;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
				}

				else if($quarter==2)
				{
					$start=5;
					$endmonth=8;

					for($start;  $start<=$endmonth;  $start++)
				  		{  

					  		$monthname=$this->GetMonthName($start);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=5;$startmonth< 9;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=5;$startmonth< 9;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				else if($quarter==3)
				{
					$startmonth=9;
					$endmonth=12;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=9;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=9;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
					
				}
				
				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
		}

		function year_quarter_county_errors($county_name,$quarter,$the_year,$all)
		{
			$Chart="";
			$this->load->model('reports_charts_sql_model');

			$export_handler='http://export.api3.fusioncharts.com/';
			$new_county_name = str_replace("%20", " ",$county_name);
			$file_name=$new_county_name.'_Errors_Quarter'.$quarter.'_'.$the_year;

			$facility="";
			$device="";

			$Chart.='<chart yAxisName="Tests" xAxisName="'.$county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			$Chart.='<categories>';
			
			if($quarter==1)
			{
				$startmonth=1;
				$endmonth=4;

				for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
			  		{  

				  		$monthname=$this->GetMonthName($startmonth);

						$Chart.="<category label='$monthname'/>";

					}
				$Chart.= '</categories>';
				$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ( $startmonth=1;$startmonth< 5;  $startmonth++)
				  		{ 
					  		$all_done=0;

							$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
							
							if($all_results!="")
							{
								foreach($all_results as $res)
								{
									$all_done=$res['data'];
			
								}
							}
							else
							{
								$all_done=0;
							}
							$Chart.= "<set value='$all_done'/>";

					  	}
				$Chart.= '</dataset>';
				$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
				for ($startmonth=1;$startmonth< 5;  $startmonth++)
				  		{ 
					  		$tests_done=0;

							$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
							
							if($tests_results!="")
							{
								foreach($tests_results as $res)
								{
									$tests_done=$res['data'];
			
								}
							}
							else
							{
								$tests_done=0;
							}
							$Chart.= "<set value='$tests_done'/>";

					  	}
				$Chart.= '</dataset>';
			}

			else if($quarter==2)
			{
				$start=5;
				$endmonth=8;

				for($start;  $start<=$endmonth;  $start++)
			  		{  

				  		$monthname=$this->GetMonthName($start);

						$Chart.="<category label='$monthname'/>";

					}
				$Chart.= '</categories>';
				$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ( $startmonth=5;$startmonth< 9;  $startmonth++)
				  		{ 
					  		$all_done=0;

							$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
							
							if($all_results!="")
							{
								foreach($all_results as $res)
								{
									$all_done=$res['data'];
			
								}
							}
							else
							{
								$all_done=0;
							}
							$Chart.= "<set value='$all_done'/>";

					  	}
				$Chart.= '</dataset>';
				$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
				for ($startmonth=5;$startmonth< 9;  $startmonth++)
				  		{ 
					  		$tests_done=0;

							$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
							
							if($tests_results!="")
							{
								foreach($tests_results as $res)
								{
									$tests_done=$res['data'];
			
								}
							}
							else
							{
								$tests_done=0;
							}
							$Chart.= "<set value='$tests_done'/>";

					  	}
				$Chart.= '</dataset>';
			}
			
			else if($quarter==3)
			{
				$startmonth=9;
				$endmonth=12;

				for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
			  		{  

				  		$monthname=$this->GetMonthName($startmonth);

						$Chart.="<category label='$monthname'/>";

					}
				$Chart.= '</categories>';
				$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ( $startmonth=9;$startmonth< 13;  $startmonth++)
				  		{ 
					  		$all_done=0;

							$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
							
							if($all_results!="")
							{
								foreach($all_results as $res)
								{
									$all_done=$res['data'];
			
								}
							}
							else
							{
								$all_done=0;
							}
							$Chart.= "<set value='$all_done'/>";

					  	}
				$Chart.= '</dataset>';
				$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
				for ($startmonth=9;$startmonth< 13;  $startmonth++)
				  		{ 
					  		$tests_done=0;

							$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
							
							if($tests_results!="")
							{
								foreach($tests_results as $res)
								{
									$tests_done=$res['data'];
			
								}
							}
							else
							{
								$tests_done=0;
							}
							$Chart.= "<set value='$tests_done'/>";

					  	}
				$Chart.= '</dataset>';
			}
			
			$Chart.='<styles>
								<definition>
									<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
									<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
									<style name="DataShadow" type="Shadow" alpha="40"/>
								</definition>
								-
								<application>
									<apply toObject="DIVLINES" styles="Anim1"/>
									<apply toObject="HGRID" styles="Anim2"/>
									<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
								</application>
							</styles>
							</chart>';
			return $Chart;
		}

		function year_quarter_county_all($county_name,$quarter,$the_year,$all)
		{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Tests_and_Errors_Quarter'.$quarter.'_'.$the_year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';
				
				if($quarter==1)
				{
					$startmonth=1;
					$endmonth=4;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=1;$startmonth< 5;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=1;$startmonth< 5;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
					$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
					for ($startmonth=1;$startmonth< 5;  $startmonth++)
					  		{ 
						  		$errors_done=0;

								$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($error_results!="")
								{
									foreach($error_results as $res)
									{
										$errors_done=$res['data'];
				
									}
								}
								else
								{
									$errors_done=0;
								}
								$Chart.= "<set value='$errors_done'/>";

						  	}
					$Chart.= '</dataset>';
				}

				else if($quarter==2)
				{
					$start=5;
					$endmonth=8;

					for($start;  $start<=$endmonth;  $start++)
				  		{  

					  		$monthname=$this->GetMonthName($start);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=5;$startmonth< 9;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=5;$startmonth< 9;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
					$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
					for ($startmonth=5;$startmonth< 9;  $startmonth++)
					  		{ 
						  		$errors_done=0;

								$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($error_results!="")
								{
									foreach($error_results as $res)
									{
										$errors_done=$res['data'];
				
									}
								}
								else
								{
									$errors_done=0;
								}
								$Chart.= "<set value='$errors_done'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				else if($quarter==3)
				{
					$startmonth=9;
					$endmonth=12;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=9;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=9;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
					$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
					for ($startmonth=9;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function year_bian_county_tests($county_name,$bian,$the_year,$all)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Tests_Biannual'.$bian.'_'.$the_year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="CD4 Chart">';
				$Chart.='<categories>';

				if($bian==1)
				{
					$startmonth=1;
					$endmonth=6;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';

				}

				else if($bian==2)
				{
					$start=7;
					$endmonth=12;

					for($start;  $start<=$endmonth;  $start++)
				  		{  

					  		$monthname=$this->GetMonthName($start);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function year_bian_county_errors($county_name,$bian,$the_year,$all)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Errors_Biannual'.$bian.'_'.$the_year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';
				
				if($bian==1)
				{
					$startmonth=1;
					$endmonth=6;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
					for ($startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';

				}

				else if($bian==2)
				{
					$start=7;
					$endmonth=12;

					for($start;  $start<=$endmonth;  $start++)
				  		{  

					  		$monthname=$this->GetMonthName($start);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
					for ($startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function year_bian_county_all($county_name,$bian,$the_year,$all)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Tests_and_Errors_Biannual'.$bian.'_'.$the_year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';
				
				if($bian==1)
				{
					$startmonth=1;
					$endmonth=6;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
					for ($startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$errors_done=0;

								$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($error_results!="")
								{
									foreach($error_results as $res)
									{
										$errors_done=$res['data'];
				
									}
								}
								else
								{
									$errors_done=0;
								}
								$Chart.= "<set value='$errors_done'/>";

						  	}
					$Chart.= '</dataset>';

				}

				else if($bian==2)
				{
					$start=7;
					$endmonth=12;

					for($start;  $start<=$endmonth;  $start++)
				  		{  

					  		$monthname=$this->GetMonthName($start);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$the_year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
						  		$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF00000" >';
					for ($startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$errors_done=0;

								$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$the_year);						
								
								if($error_results!="")
								{
									foreach($error_results as $res)
									{
										$errors_done=$res['data'];
				
									}
								}
								else
								{
									$errors_done=0;
								}
								$Chart.= "<set value='$errors_done'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function yearly_county_tests($county_name,$year,$all)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Tests_'.$year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$county_name.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';

				$startmonth=1;
				$endmonth=12;

				for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
			  		{  

				  		$monthname=$this->GetMonthName($startmonth);

						$Chart.="<category label='$monthname'/>";

					}
				$Chart.= '</categories>';
				$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function yearly_county_errors($county_name,$year,$all)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Errors_'.$year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';

				$startmonth=1;
				$endmonth=12;

				for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
			  		{  

				  		$monthname=$this->GetMonthName($startmonth);

						$Chart.="<category label='$monthname'/>";

					}
				$Chart.= '</categories>';
				$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function yearly_county_all($county_name,$year,$all)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Tests_and_Errors_'.$year;

				$facility="";
				$device="";

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';

				$startmonth=1;
				$endmonth=12;

				for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
			  		{  

				  		$monthname=$this->GetMonthName($startmonth);

						$Chart.="<category label='$monthname'/>";

					}
				$Chart.= '</categories>';
				$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$all_done=0;

								$all_results=$this->reports_charts_sql_model->get_test_details_both($facility,$device,$all,$startmonth,$year);						
								
								if($all_results!="")
								{
									foreach($all_results as $res)
									{
										$all_done=$res['data'];
				
									}
								}
								else
								{
									$all_done=0;
								}
								$Chart.= "<set value='$all_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$tests_done=0;

								$tests_results=$this->reports_charts_sql_model->get_test_details_tests_only($facility,$device,$all,$startmonth,$year);						
								
								if($tests_results!="")
								{
									foreach($tests_results as $res)
									{
										$tests_done=$res['data'];
				
									}
								}
								else
								{
									$tests_done=0;
								}
								$Chart.= "<set value='$tests_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$errors_done=0;

								$error_results=$this->reports_charts_sql_model->get_test_details_errors_only($facility,$device,$all,$startmonth,$year);						
								
								if($error_results!="")
								{
									foreach($error_results as $res)
									{
										$errors_done=$res['data'];
				
									}
								}
								else
								{
									$errors_done=0;
								}
								$Chart.= "<set value='$errors_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function customized_dates_county($county_name,$test,$errors,$total,$less_than350,$from,$to,$report_type,$year)
			{
				$Chart="";

				$export_handler='http://export.api3.fusioncharts.com/';
				$new_county_name = str_replace("%20", " ",$county_name);
				$file_name=$new_county_name.'_Customized_dates_'.$from.'_to_'.$to.'_'.$year;

				$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				$Chart.='<categories>';
				$Chart.="<category label='Between $from and $to'/>";
				$Chart.= '</categories>';

				if($report_type==1)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					$Chart.= "<set value='$test'/>";
					$Chart.= '</dataset>';
				}
				else if($report_type==2)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
					$Chart.= "<set value='$errors'/>";
					$Chart.= '</dataset>';
				}
				else if($report_type==0)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Successful Tests" color="006600" >';
					$Chart.= "<set value='$test'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests with Errors" color="FF0000" >';
					$Chart.= "<set value='$errors'/>";
					$Chart.= '</dataset>';
				}
				else if($report_type==3)
				{
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					$Chart.= "<set value='$total'/>";
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF0000" >';
					$Chart.= "<set value='$less_than350'/>";
					$Chart.= '</dataset>';
				}
				

				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}
		
/*============================ End of County Functions =======================================================*/

/*============================ < 350 chart functions =========================================================*/


			function quarter_tests_less_than350($quarter,$facility,$device,$the_year,$all,$county_name,$login_id)
			{
				$Chart="";
				$new_facility="";
				$new_county_name="";
				$test_results="";
	  			
				$this->load->model('reports_charts_sql_model');

				$export_handler='http://export.api3.fusioncharts.com/';

				$user_filter=$this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				if(!$facility=="0")
				{	
					$device="";
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$new_facility.'_Tests_Less_Than350'.$quarter.'_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if(!$device=="0")
				{	
					$file_name=$device.'_Tests_Less_Than350'.$quarter.'_'.$the_year;
					$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if(!$county_name=="0")
				{
					$device="";
					$new_county_name = str_replace("%20", " ",$county_name);
					$file_name=$new_county_name.'_Tests_Less_Than350'.$quarter.'_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if($all==3 || $all==5)
				{
					$device="";
					if($all==3)
					{
						
						$file_name='All_Tests_Less_Than350_'.$pfilter.'_'.$quarter.'_'.$the_year;
						$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests '.$pfilter.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
			
					}
					else if($all==5)
					{
						$file_name='All_Tests_Less_Than350'.$quarter.'_'.$the_year;
						$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
					}
					
				}
				
				$Chart.='<categories>';
				if($quarter==1)
				{
					$startmonth=1;
					$endmonth=4;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=1;$startmonth< 5;  $startmonth++)
					  		{ 
					  			$all_done=0;

					  			$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($all_results!="")
					  			{
						  			foreach ($all_results as $value) 
						  			{
							  			$all_done=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$all_done=0;
					  			}

					  			$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';
					$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF0000" >';
					for ( $startmonth=1;$startmonth< 5;  $startmonth++)
			  		{ 
			  			$less_than350=0;

			  			$test_results=$this->reports_charts_sql_model->get_test_details_less_than350($new_facility,$device,$all,$startmonth,$the_year);
				  		

			  			if($test_results!="")
			  			{
				  			foreach ($test_results as $value) 
				  			{
					  			$less_than350=$value['data'];
				  			}
			  			}
			  			else
			  			{
			  				$less_than350=0;
			  			}

			  			$Chart.= "<set value='$less_than350'/>";

				  	}
					$Chart.= '</dataset>';
				}

				else if($quarter==2)
				{
					$startmonth=5;
					$endmonth=8;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=5;$startmonth< 9;  $startmonth++)
					  		{ 
						  		$all_done=0;

					  			$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);
						  		 
					  			if(!$all_results=="")
					  			{
						  			foreach ($all_results as $value) 
						  			{
							  			$all_done=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$all_done=0;
					  			}

					  			$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF0000" >';
					for ( $startmonth=5;$startmonth< 9;  $startmonth++)
					  		{ 
					  			$less_than350=0;

					  			$test_results=$this->reports_charts_sql_model->get_test_details_less_than350($new_facility,$device,$startmonth,$the_year);

					  			if($test_results!="")
					  			{
						  			foreach ($test_results as $value) 
						  			{
							  			$less_than350=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$less_than350=0;
					  			}

					  			$Chart.= "<set value='$less_than350'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				else if($quarter==3)
				{
					$startmonth=9;
					$endmonth=12;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=9;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$all_done=0;

					  			$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($all_results!="")
					  			{
						  			foreach ($all_results as $value) 
						  			{
							  			$all_done=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$all_done=0;
					  			}

					  			$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';
					
					$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF0000" >';
					for ( $startmonth=9;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$less_than350=0;

					  			$test_results=$this->reports_charts_sql_model->get_test_details_less_than350($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($test_results!="")
					  			{
						  			foreach ($test_results as $value) 
						  			{
							  			$less_than350=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$less_than350=0;
					  			}

					  			$Chart.= "<set value='$less_than350'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';

				return $Chart;
				
			}
			function bian_tests_less_than350($bian,$facility,$device,$the_year,$all,$county_name,$login_id)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');
				$test_results="";
				$new_county_name="";
				$new_facility="";

				$export_handler='http://export.api3.fusioncharts.com/';

				$user_filter=$this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				if(!$facility=="0")
				{
					$device="";
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$new_facility.'_Tests_Less_Than350'.$bian.'_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if(!$device=="0")
				{	
					$file_name=$device.'_Tests_Less_Than350'.$bian.'_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if(!$county_name=="0")
				{	
					$device="";
					$new_county_name = str_replace("%20", " ",$county_name);
					$file_name=$new_county_name.'_Tests_Less_Than350'.$bian.'_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if($all==3 || $all==5)
				{
					$device="";
					if($all==3)
					{
						$file_name='All_Tests_Less_Than350_'.$pfilter.'_'.$bian.'_'.$the_year;
						$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests '.$pfilter.', '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
					}
					else if($all==5)
					{
						$file_name='All_Tests_Less_Than350'.$bian.'_'.$the_year;
						$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests, '.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
					}	
					
				}
				$Chart.='<categories>';
				if($bian==1)
				{
					$startmonth=1;
					$endmonth=6;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
					  			$all_done=0;

					  			$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($all_results!="")
					  			{
						  			foreach ($all_results as $value) 
						  			{
							  			$all_done=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$all_done=0;
					  			}

					  			$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF00000" >';
					for ( $startmonth=1;$startmonth< 7;  $startmonth++)
					  		{ 
								$less_than350=0;

					  			$tests_results=$this->reports_charts_sql_model->get_test_details_less_than350($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($tests_results!="")
					  			{
						  			foreach ($tests_results as $value) 
						  			{
							  			$less_than350=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$less_than350=0;
					  			}

					  			$Chart.= "<set value='$less_than350'/>";

						  	}
					$Chart.= '</dataset>';

				}

				else if($bian==2)
				{
					$startmonth=7;
					$endmonth=12;

					for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
				  		{  

					  		$monthname=$this->GetMonthName($startmonth);

							$Chart.="<category label='$monthname'/>";

						}
					$Chart.= '</categories>';
					$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
					for ( $startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$all_done=0;

					  			$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($all_results!="")
					  			{
						  			foreach ($all_results as $value) 
						  			{
							  			$all_done=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$all_done=0;
					  			}

					  			$Chart.= "<set value='$all_done'/>";

						  	}
					$Chart.= '</dataset>';

					$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF0000" >';
					for ( $startmonth=7;$startmonth< 13;  $startmonth++)
					  		{ 
						  		$less_than350=0;

					  			$tests_results=$this->reports_charts_sql_model->get_test_details_less_than350($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($tests_results!="")
					  			{
						  			foreach ($tests_results as $value) 
						  			{
							  			$less_than350=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$less_than350=0;
					  			}

					  			$Chart.= "<set value='$less_than350'/>";

						  	}
					$Chart.= '</dataset>';
				}
				
				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

			function yearly_tests_less_than350($the_year,$facility,$device,$all,$county_name,$login_id)
			{
				$Chart="";
				$this->load->model('reports_charts_sql_model');
				$test_results="";
				$new_county_name="";
				$new_facility="";

				$export_handler='http://export.api3.fusioncharts.com/';

				$user_filter=$this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				if(!$facility=="0")
				{
					$device="";
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$new_facility.'_Tests_Less_Than350_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_facility.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if(!$device=="0")
				{
					$file_name=$device.'_Tests_Less_Than350_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$device.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if(!$county_name=="0")
				{
					$device="";
					$new_county_name = str_replace("%20", " ",$county_name);
					$file_name=$new_county_name.'_Tests_Less_Than350_'.$the_year;

					$Chart.='<chart yAxisName="Tests" xAxisName="'.$new_county_name.','.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
				}
				if($all==3 || $all==5)
				{
					$device="";
					if($all==3)
					{
						$file_name='All_Tests_Less_Than350_'.$pfilter.'_'.$the_year;
						$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
					}
					else if($all==5)
					{
						$file_name='All_Tests_Less_Than350_'.$the_year;
						$Chart.='<chart yAxisName="Tests" xAxisName="Chart for all tests,'.$the_year.'" exportHandler="'.$export_handler.'" exportEnabled="1" exportAtClient="1" exportFileName="'.$file_name.'">';
					}
					
				}
				
				$Chart.='<categories>';

				$startmonth=1;
				$endmonth=12;

				for($startmonth;  $startmonth<=$endmonth;  $startmonth++)
			  		{  

				  		$monthname=$this->GetMonthName($startmonth);

						$Chart.="<category label='$monthname'/>";

					}
				$Chart.= '</categories>';
				$Chart.= '<dataset seriesName="Tests Done" color="A666EDD" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
					  			$all_done=0;

					  			$all_results=$this->reports_charts_sql_model->get_test_details_both($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($all_results!="")
					  			{
						  			foreach ($all_results as $value) 
						  			{
							  			$all_done=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$all_done=0;
					  			}

					  			$Chart.= "<set value='$all_done'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.= '<dataset seriesName="Tests &lt; 350" color="FF0000" >';
				for ( $startmonth=1;$startmonth< 13;  $startmonth++)
				  		{ 
				  				$less_than350=0;

					  			$tests_results=$this->reports_charts_sql_model->get_test_details_less_than350($new_facility,$device,$all,$startmonth,$the_year);
						  		
					  			if($tests_results!="")
					  			{
						  			foreach ($tests_results as $value) 
						  			{
							  			$less_than350=$value['data'];
						  			}
					  			}
					  			else
					  			{
					  				$less_than350=0;
					  			}

					  			$Chart.= "<set value='$less_than350'/>";

					  	}
				$Chart.= '</dataset>';

				$Chart.='<styles>
									<definition>
										<style name="Anim1" type="animation" param="_xscale" start="0" duration="1"/>
										<style name="Anim2" type="animation" param="_alpha" start="0" duration="0.6"/>
										<style name="DataShadow" type="Shadow" alpha="40"/>
									</definition>
									-
									<application>
										<apply toObject="DIVLINES" styles="Anim1"/>
										<apply toObject="HGRID" styles="Anim2"/>
										<apply toObject="DATALABELS" styles="DataShadow,Anim2"/>
									</application>
								</styles>
								</chart>';
				return $Chart;
			}

/*============================ < 350 chart functions =========================================================*/

/*============================ Percentage > 5 % functions ====================================================*/

			function percentage_errors_monthly($tests,$errors,$total,$year,$facility,$device,$all,$month_name,$county_name)
			{
				$EChart="";
				$export_handler='http://export.api3.fusioncharts.com/';

				$user_filter=$this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				if(!$facility=="0")
				{
					$device="";
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$new_facility.'_Error_Percentage_'.$month_name.'_'.$year;
					
					$EChart.="<chart caption='$new_facility, $month_name, $year ' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if(!$device=="0")
				{	
					$new_facility="";
					$file_name=$device.'_Error_Percentage_'.$month_name.'_'.$year;

					$EChart.="<chart caption='$device, $month_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if($all==3 || $all==5)
				{
					$device="";
					if($all==3)
					{
						$file_name='All_Error_Percentage_'.$pfilter.'_'.$month_name.'_'.$year;

						$EChart.="<chart caption='All errors by %, $pfilter, $month_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}
					else if($all==5)
					{
						$file_name='All_Error_Percentage_'.$month_name.'_'.$year;

						$EChart.="<chart caption='All errors by %, $month_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}
					
				}
				if($all==4)
				{
					$new_county = str_replace("%20", " ",$county_name);
					$file_name=$new_county.'_Error_Percentage_'.$month_name.'_'.$year;

					$EChart.="<chart caption='$new_county, $month_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				
				$percentage_errors=0;
				$percentage_successful=0;
               
                if($total==0 && $errors==0 && $tests==0)
                {
                	$total=0;
                	$tests=0;
                	$errors=0;
                }	
                else
                {
                	$percentage_errors=($errors/$total)*100;
                	$percentage_successful=($tests/$total)*100;

                }
                $EChart.="<set label='Errors' value='$percentage_errors' color='FF0000'  isSliced='0'  />";
                $EChart.="<set label='Successful Tests' value='$percentage_successful' color='006600'  isSliced='0'  />";
				$EChart.='<styles>
						        <definition>
						          <style name="Font_0" type="font" font="Calibri" size="14" bold="1" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Font_1" type="font" size="15" color="000080" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Glow_0" type="Glow" color="0080FF" alpha="43" quality="3"/>
						        </definition>
						        <application>
						          <apply toObject="DATALABELS" styles="Font_0"/>
						          <apply toObject="CAPTION" styles="Font_1"/>
						          <apply toObject="DATAPLOT" styles="Glow_0"/>
						        </application>
				        </styles>
						</chart>';

                return $EChart;
			}

			function percentage_errors_quarter($tests,$errors,$total,$year,$facility,$device,$all,$quarter,$county_name)
			{
				$EChart="";
				$export_handler='http://export.api3.fusioncharts.com/';

				$user_filter =$this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				$quarter_name="";

				if($quarter==1)
				{
					$quarter_name="January - April";
				}
				else if($quarter==2)
				{
					$quarter_name="May - August";
				}
				else
				{
					$quarter_name="September - December";
				}

				if(!$facility=="0")
				{
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$device.'_Error_Percentage_'.$quarter_name.'_'.$year;

					$EChart.="<chart caption='$new_facility, $quarter_name, $year ' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if(!$device=="0")
				{
					$file_name=$device.'_Error_Percentage_'.$quarter_name.'_'.$year;

					$EChart.="<chart caption='$device, $quarter_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if($all==3 || $all==5)
				{
					if($all==3)
					{
						$file_name='All_Error_Percentage_'.$pfilter.'_'.$quarter_name.'_'.$year;

						$EChart.="<chart caption='All errors by %, $pfilter, $quarter_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}
					else if($all==5)
					{
						$file_name='All_Error_Percentage_'.$quarter_name.'_'.$year;

						$EChart.="<chart caption='All errors by %, $quarter_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}
					
				}
				if($all==4)
				{
					$new_county = str_replace("%20", " ",$county_name);
					$file_name=$new_county.'_Error_Percentage_'.$quarter_name.'_'.$year;

					$EChart.="<chart caption='$new_county, $quarter_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}

				$percentage_errors=0;
				$percentage_successful=0;
               
                if($total==0 && $errors==0 && $tests==0)
                {
                	$total=0;
                	$tests=0;
                	$errors=0;
                	$percentage_errors=0;
                	$percentage_successful=0;
                }	
                else
                {
                	$percentage_errors=($errors/$total)*100;
                	$percentage_successful=($tests/$total)*100;

                }
                $EChart.="<set label='Errors' value='$percentage_errors' color='FF0000'  isSliced='0'  />";
                $EChart.="<set label='Successful Tests' value='$percentage_successful' color='006600'  isSliced='0'  />";
				$EChart.='<styles>
						        <definition>
						          <style name="Font_0" type="font" font="Calibri" size="14" bold="1" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Font_1" type="font" size="15" color="000080" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Glow_0" type="Glow" color="0080FF" alpha="43" quality="3"/>
						        </definition>
						        <application>
						          <apply toObject="DATALABELS" styles="Font_0"/>
						          <apply toObject="CAPTION" styles="Font_1"/>
						          <apply toObject="DATAPLOT" styles="Glow_0"/>
						        </application>
				        </styles>
						</chart>';

                return $EChart;
			}

			function percentage_errors_biannual($tests,$errors,$total,$year,$facility,$device,$all,$bian,$county_name)
			{
				$EChart="";
				$export_handler='http://export.api3.fusioncharts.com/';
				$bian_name="";

				$user_filter=$this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter = $filter['user_filter_name'];
				}

				if($bian==1)
				{
					$bian_name="January - June";
				}
				else if($bian==2)
				{
					$bian_name="July - December";
				}

				if(!$facility=="0")
				{
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$new_facility.'_Error_Percentage_'.$bian_name.'_'.$year;

					$EChart.="<chart caption='$new_facility, $bian_name $year ' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if(!$device=="0")
				{
					$file_name=$device.'_Error_Percentage_'.$bian_name.'_'.$year;

					$EChart.="<chart caption='$device, $bian_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if($all==3 || $all==5)
				{
					if($all==3)
					{
						$file_name='All_Error_Percentage_'.$pfilter.'_'.$bian_name.'_'.$year;

						$EChart.="<chart caption='All errors by %, $pfilter, $bian_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}

					else if($all==5)
					{
						$file_name='All_Error_Percentage_'.$bian_name.'_'.$year;

						$EChart.="<chart caption='All errors by %, $bian, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}
				}
				if($all==4)
				{
					$new_county = str_replace("%20", " ",$county_name);
					$file_name=$new_county.'_Error_Percentage_'.$bian_name.'_'.$year;

					$EChart.="<chart caption='$new_county, $bian_name, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}

				$percentage_errors=0;
				$percentage_successful=0;
               
                if($total==0 && $errors==0 && $tests==0)
                {
                	$total=0;
                	$tests=0;
                	$errors=0;
                	$percentage_errors=0;
                	$percentage_successful=0;
                }	
                else
                {
                	$percentage_errors=($errors/$total)*100;
                	$percentage_successful=($tests/$total)*100;

                }
                $EChart.="<set label='Errors' value='$percentage_errors' color='FF0000'  isSliced='0'  />";
                $EChart.="<set label='Successful Tests' value='$percentage_successful' color='006600'  isSliced='0'  />";
				$EChart.='<styles>
						        <definition>
						          <style name="Font_0" type="font" font="Calibri" size="14" bold="1" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Font_1" type="font" size="15" color="000080" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Glow_0" type="Glow" color="0080FF" alpha="43" quality="3"/>
						        </definition>
						        <application>
						          <apply toObject="DATALABELS" styles="Font_0"/>
						          <apply toObject="CAPTION" styles="Font_1"/>
						          <apply toObject="DATAPLOT" styles="Glow_0"/>
						        </application>
				        </styles>
						</chart>';

                return $EChart;
			}

			function percentage_errors_yearly($tests,$errors,$total,$year,$facility,$device,$all,$county_name)
			{
				$EChart="";
				$export_handler='http://export.api3.fusioncharts.com/';

				$user_filter = $this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter = $filter['user_filter_name'];
				}

				if(!$facility=="0")
				{
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$new_facility.'_Error_Percentage_'.$year;

					$EChart.="<chart caption='$new_facility, $year ' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if(!$device=="0")
				{
					$file_name=$device.'_Error_Percentage_'.$year;

					$EChart.="<chart caption='$device, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}
				if($all==3 || $all==5)
				{
					if($all==3)
					{
						$file_name='All_Error_Percentage_'.$pfilter.'_'.$year;

						$EChart.="<chart caption='All errors by %, $pfilter, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}
					else if($all==5)
					{
						$file_name='All_Error_Percentage_'.$year;

						$EChart.="<chart caption='All errors by %, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
					}
					
				}
				if($all==4)
				{
					$new_county = str_replace("%20", " ",$county_name);
					$file_name=$new_county.'_Error_Percentage_'.$year;

					$EChart.="<chart caption='$new_county, $year' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportEnabled='1' exportFileName='$file_name'>";
				}

				$percentage_errors=0;
				$percentage_successful=0;
               
                if($total==0 && $errors==0 && $tests==0)
                {
                	$total=0;
                	$tests=0;
                	$errors=0;
                	$percentage_errors=0;
                	$percentage_successful=0;
                }	
                else
                {
                	$percentage_errors=($errors/$total)*100;
                	$percentage_successful=($tests/$total)*100;

                }
                $EChart.="<set label='Errors' value='$percentage_errors' color='FF0000'  isSliced='0'  />";
                $EChart.="<set label='Successful Tests' value='$percentage_successful' color='006600'  isSliced='0'  />";
				$EChart.='<styles>
						        <definition>
						          <style name="Font_0" type="font" font="Calibri" size="14" bold="1" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Font_1" type="font" size="15" color="000080" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Glow_0" type="Glow" color="0080FF" alpha="43" quality="3"/>
						        </definition>
						        <application>
						          <apply toObject="DATALABELS" styles="Font_0"/>
						          <apply toObject="CAPTION" styles="Font_1"/>
						          <apply toObject="DATAPLOT" styles="Glow_0"/>
						        </application>
				        </styles>
						</chart>';

                return $EChart;

			}

			function percentage_errors_customized_dates($tests,$errors,$total,$facility,$device,$all,$county_name,$from,$to)
			{
				$EChart="";
				$export_handler='http://export.api3.fusioncharts.com/';

				$user_filter = $this->session->userdata('user_filter');

				foreach($user_filter as $filter)
				{
					$pfilter = $filter['user_filter_name'];
				}

				if(!$facility=="0")
				{
					$new_facility = str_replace("%20", " ",$facility);
					$file_name=$new_facility.'_Error_Percentage_'.$from.'_to_'.$to;

					$EChart.="<chart caption='$new_facility, Between $from and $to' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportFileName='$file_name'>";
				}
				if(!$device=="0")
				{
					$file_name=$device.'_Error_Percentage_'.$from.'_to_'.$to;

					$EChart.="<chart caption='$device, Between $from and $to' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportFileName='$file_name'>";
				}
				if($all==3 || $all==5)
				{
					if($all==3)
					{
						$file_name='All_Error_Percentage_'.$pfilter.'_'.$from.'_to_'.$to;

						$EChart.="<chart caption='All errors by %, $pfilter, Between $from and $to' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportFileName='$file_name'>";
					}
					else if($all==5)
					{
						$file_name='All_Error_Percentage_'.$from.'_to_'.$to;

						$EChart.="<chart caption='All errors by %, Between $from and $to' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
	                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportFileName='$file_name'>";
					}
					
				}
				if($all==4)
				{
					$new_county = str_replace("%20", " ",$county_name);
					$file_name=$new_county.'_Error_Percentage_'.$from.'_to_'.$to;

					$EChart.="<chart caption='$new_county, Between $from and $to' palette='9' showborder='0' bgcolor='FFFFFF' showAboutMenuItem='1' showShadow='1' slicingDistance='15' showLegend='1' baseFontSize ='12' showPercentValues='1'  decimals='1' formatNumberScale='0' 
                       smartLineThickness='2' smartLineColor='333333' isSmartLineSlanted='1' enableSmartLabels='1' enableRotation='1' startingAngle='160' exportHandler='$export_handler' exportFileName='$file_name'>";
				}

				$percentage_errors=0;
				$percentage_successful=0;
               
                if($total==0 && $errors==0 && $tests==0)
                {
                	$total=0;
                	$tests=0;
                	$errors=0;
                	$percentage_errors=0;
                	$percentage_successful=0;
                }	
                else
                {
                	$percentage_errors=($errors/$total)*100;
                	$percentage_successful=($tests/$total)*100;

                }
                $EChart.="<set label='Errors' value='$percentage_errors' color='FF0000'  isSliced='0'  />";
                $EChart.="<set label='Successful Tests' value='$percentage_successful' color='006600'  isSliced='0'  />";
				$EChart.='<styles>
						        <definition>
						          <style name="Font_0" type="font" font="Calibri" size="14" bold="1" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Font_1" type="font" size="15" color="000080" bgcolor="FFFFFF" bordercolor="FFFFFF" isHTML="0"/>
						          <style name="Glow_0" type="Glow" color="0080FF" alpha="43" quality="3"/>
						        </definition>
						        <application>
						          <apply toObject="DATALABELS" styles="Font_0"/>
						          <apply toObject="CAPTION" styles="Font_1"/>
						          <apply toObject="DATAPLOT" styles="Glow_0"/>
						        </application>
				        </styles>
						</chart>';

                return $EChart;
			}


}/*End of reports_charts_model*/

	