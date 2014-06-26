<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class reports_charts extends MY_Controller {


	function chart_functions($test,$errors,$total,$less_than350,$report_type,$facility,$device,$all,$month_name,$q_no,$b_no,$year,$the_year,$from,$to,$county_name,$login_id)
	{
		$this->load->model('reports_charts_model');
		
		$graph_tests="";
		
		if($month_name!="0")// check if month was selected
		{
			
			if($facility!="0")
			{
				
				$graph_tests=$this->reports_charts_model->year_month_facility_chart($facility,$test,$errors,$total,$month_name,$the_year,$report_type);
				
			}

			if($device!="0")
			{
				
				$graph_tests=$this->reports_charts_model->year_month_device_chart($device,$test,$errors,$total,$month_name,$the_year,$report_type);
			
			}
			if($all!="0")
			{
				if($county_name!="0")
				{
					$graph_tests=$this->reports_charts_model->year_month_county_chart($county_name,$test,$errors,$total,$month_name,$the_year,$report_type);
				}
				else
				{
					
					$graph_tests=$this->reports_charts_model->year_month_chart($test,$errors,$total,$month_name,$the_year,$report_type,$all);
				}
			}

			
		}
		if($q_no!="0")// check if Quarter was selected
		{
			if($facility!="0")
			{
				if($report_type==1)
				{
					$graph_tests=$this->reports_charts_model->year_quarter_facility_tests_chart($facility,$q_no,$the_year,$report_type);
				}
				else if($report_type==2)
				{
					$graph_tests=$this->reports_charts_model->year_quarter_facility_errors_chart($facility,$q_no,$the_year);
				}
				else if($report_type==0)
				{					
					$graph_tests=$this->reports_charts_model->year_quarter_facility_chart($facility,$q_no,$the_year);
				}
				else if($report_type==3)
				{
					$graph_tests=$this->reports_charts_model->quarter_tests_less_than350($q_no,$facility,$device,$the_year,$all,$county_name,$login_id);
				}
			}

			if($device!="0")
			{
				if($report_type==1)
				{
					
					$graph_tests=$this->reports_charts_model->year_quarter_device_tests_chart($device,$q_no,$the_year);

				}
				else if($report_type==2)
				{
					$graph_tests=$this->reports_charts_model->year_quarter_device_errors_chart($device,$q_no,$the_year);
				}
				else if($report_type==0)
				{
					
					$graph_tests=$this->reports_charts_model->year_quarter_device_chart($device,$q_no,$the_year);
				}
				else if($report_type==3)
				{
					$graph_tests=$this->reports_charts_model->quarter_tests_less_than350($q_no,$facility,$device,$the_year,$all,$county_name,$login_id);
				}
			}

			if($all!="0")
			{
				if($county_name!="0")
				{
					if($report_type==1)
					{
						$graph_tests=$this->reports_charts_model->year_quarter_county_tests($county_name,$q_no,$the_year,$all,$login_id);
					}
					else if($report_type==2)
					{
						$graph_tests=$this->reports_charts_model->year_quarter_county_errors($county_name,$q_no,$the_year,$all,$login_id);
					}
					else if($report_type==0)
					{
						$graph_tests=$this->reports_charts_model->year_quarter_county_all($county_name,$q_no,$the_year,$all,$login_id);
					}
					else if($report_type==3)
					{
						$graph_tests=$this->reports_charts_model->quarter_tests_less_than350($q_no,$facility,$device,$the_year,$all,$county_name,$login_id);
					}
				}
				else
				{
					if($report_type==1)
					{
						$graph_tests=$this->reports_charts_model->year_quarter_all_tests_chart($all,$q_no,$the_year);
					}
					else if($report_type==2)
					{
						$graph_tests=$this->reports_charts_model->year_quarter_all_errors_chart($all,$q_no,$the_year);
					}
					else if($report_type==0)
					{
						$graph_tests=$this->reports_charts_model->year_quarter_all_chart($all,$q_no,$the_year);
					}
					else if($report_type==3)
					{
						$graph_tests=$this->reports_charts_model->quarter_tests_less_than350($q_no,$facility,$device,$the_year,$all,$county_name,$login_id);
					}
				}
			}
			
				
		}

		if($b_no!="0")// check if the biannual criteria is chosen
		{
			if($facility!="0")
			{
				if($report_type==1)
				{
					$graph_tests=$this->reports_charts_model->year_bian_facility_tests_chart($facility,$b_no,$the_year);
				}
				else if($report_type==2)
				{
					$graph_tests=$this->reports_charts_model->year_bian_facility_errors_chart($facility,$b_no,$the_year);
				}
				else if($report_type==0)
				{
					$graph_tests=$this->reports_charts_model->year_bian_facility_chart($facility,$b_no,$the_year);
				}
				else if($report_type==3)
				{
					$graph_tests=$this->reports_charts_model->bian_tests_less_than350($b_no,$facility,$device,$the_year,$all,$county_name,$login_id);
				}
			}

			if($device!="0")
			{
				if($report_type==1)
				{
					$graph_tests=$this->reports_charts_model->year_bian_device_tests_chart($device,$b_no,$the_year);
				}
				else if($report_type==2)
				{
					$graph_tests=$this->reports_charts_model->year_bian_device_errors_chart($device,$b_no,$the_year);
				}
				else if($report_type==0)
				{
					$graph_tests=$this->reports_charts_model->year_bian_device_chart($device,$b_no,$the_year);
				}
				else if($report_type==3)
				{
					$graph_tests=$this->reports_charts_model->bian_tests_less_than350($b_no,$facility,$device,$the_year,$all,$county_name,$login_id);
				}

			}
			if($all!="0")
			{
				if($county_name!="0")
				{
					if($report_type==1)
					{
						$graph_tests=$this->reports_charts_model->year_bian_county_tests($county_name,$b_no,$the_year,$all,$login_id);
					}
					else if($report_type==2)
					{
						$graph_tests=$this->reports_charts_model->year_bian_county_errors($county_name,$b_no,$the_year,$all,$login_id);
					}
					else if($report_type==0)
					{
						$graph_tests=$this->reports_charts_model->year_bian_county_all($county_name,$b_no,$the_year,$all,$login_id);	
					}
					else if($report_type==3)
					{
						$graph_tests=$this->reports_charts_model->bian_tests_less_than350($b_no,$facility,$device,$the_year,$all,$county_name,$login_id);
					}
				}
				else
				{
					if($report_type==1)
					{
						$graph_tests=$this->reports_charts_model->year_bian_all_tests_chart($all,$b_no,$the_year);
					}
					else if($report_type==2)
					{
						$graph_tests=$this->reports_charts_model->year_bian_all_errors_chart($all,$b_no,$the_year);
					}
					else if($report_type==0)
					{
						$graph_tests=$this->reports_charts_model->year_bian_all_chart($all,$b_no,$the_year);
					}
					else if($report_type==3)
					{
						$graph_tests=$this->reports_charts_model->bian_tests_less_than350($b_no,$facility,$device,$the_year,$all,$county_name,$login_id);
					}
				}

			}
		}

		if($year!="0")// check if the yearly criteria is chosen
		{
			if($facility!="0")
			{
				if($report_type==1)
				{
					$graph_tests=$this->reports_charts_model->yearly_facility_tests_chart($facility,$year);
				}
				else if($report_type==2)
				{
					$graph_tests=$this->reports_charts_model->yearly_facility_errors_chart($facility,$year);
				}
				else if($report_type==0)
				{
					$graph_tests=$this->reports_charts_model->yearly_facility_chart($facility,$year);
				}
				else if($report_type==3)
				{
					$graph_tests=$this->reports_charts_model->yearly_tests_less_than350($year,$facility,$device,$all,$county_name,$login_id);
				}
			}
			if($device!="0")
			{
				if($report_type==1)
				{
					$graph_tests=$this->reports_charts_model->yearly_device_tests_chart($device,$year);
				}
				else if($report_type==2)
				{
					$graph_tests=$this->reports_charts_model->yearly_device_errors_chart($device,$year);
				}
				else if($report_type==0)
				{
					$graph_tests=$this->reports_charts_model->yearly_device_chart($device,$year);
				}
				else if($report_type==3)
				{
					$graph_tests=$this->reports_charts_model->yearly_tests_less_than350($year,$facility,$device,$all,$county_name,$login_id);
				}

			}
			if($all!="0")
			{
				if($county_name!="0")
				{
					if($report_type==1)
					{
						$graph_tests=$this->reports_charts_model->yearly_county_tests($county_name,$year,$all,$login_id);
					}
					else if($report_type==2)
					{
						$graph_tests=$this->reports_charts_model->yearly_county_errors($county_name,$year,$all,$login_id);
					}
					else if($report_type==0)
					{
						$graph_tests=$this->reports_charts_model->yearly_county_all($county_name,$year,$all,$login_id);
					}
					else if($report_type==3)
					{
						$graph_tests=$this->reports_charts_model->yearly_tests_less_than350($year,$facility,$device,$all,$county_name,$login_id);
					}
				}
				else
				{
					if($report_type==1)
					{
						$graph_tests=$this->reports_charts_model->yearly_all_tests_chart($all,$year);
					}
					else if($report_type==2)
					{
						$graph_tests=$this->reports_charts_model->yearly_all_errors_chart($all,$year);
					}
					else if($report_type==0)
					{
						$graph_tests=$this->reports_charts_model->yearly_all_chart($all,$year);
					}
					else if($report_type==3)
					{
						$graph_tests=$this->reports_charts_model->yearly_tests_less_than350($year,$facility,$device,$all,$county_name,$login_id);
					}
				}
			}
		}

		if($from!="0" && $to!="0")
		{
			if($facility!="0")
			{
				$graph_tests=$this->reports_charts_model->customized_dates_facility_chart($facility,$test,$errors,$total,$from,$to,$report_type);
			}
			if($device!="0")
			{
				$graph_tests=$this->reports_charts_model->customized_dates_device_chart($device,$test,$errors,$total,$from,$to,$report_type);		
			}
			
			if($all!="0")
			{
				if($county_name!="0")
				{
					$graph_tests=$this->reports_charts_model->customized_dates_county($county_name,$test,$errors,$total,$less_than350,$from,$to,$report_type,$year);
				}
				else
				{
					/*echo $test;die;*/
					$graph_tests=$this->reports_charts_model->customized_dates_all_chart($test,$errors,$total,$less_than350,$from,$to,$report_type,$all);			
				}
				
			}
		}

	echo $graph_tests;	
	}

	function percentage_error_chart($tests,$errors,$total,$facility,$device,$all,$month_name,$q_no,$b_no,$year,$the_year,$from,$to,$county_name,$login_id)
	{
		$this->load->model('reports_charts_model');

		if($month_name!="0")
		{
			
			$graph_results=$this->reports_charts_model->percentage_errors_monthly($tests,$errors,$total,$the_year,$facility,$device,$all,$month_name,$county_name);
		}
		if($q_no!="0")
		{
			$graph_results=$this->reports_charts_model->percentage_errors_quarter($tests,$errors,$total,$the_year,$facility,$device,$all,$q_no,$county_name);
		}
		if($b_no!="0")
		{
			$graph_results=$this->reports_charts_model->percentage_errors_biannual($tests,$errors,$total,$the_year,$facility,$device,$all,$b_no,$county_name);
		}
		if($year!="0")
		{
			$graph_results=$this->reports_charts_model->percentage_errors_yearly($tests,$errors,$total,$year,$facility,$device,$all,$county_name);
		}
		if($from!="0" && $to!="0")
		{
			$graph_results=$this->reports_charts_model->percentage_errors_customized_dates($tests,$errors,$total,$facility,$device,$all,$county_name,$from,$to);
		}
	
	echo $graph_results;	
	}

}