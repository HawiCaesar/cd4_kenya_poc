<?php 

class reports_charts_model extends MY_Model{

 	function __construct()// default load
    {
        parent::__construct();

        $this->load->model('reports_charts_sql_model');
		$this->load->model('reports_model');

		$tests_results=array();

		$the_total[]=array();
		$the_tests[]=array();
		$the_error[]=array();
    }

	/*------------------------ month graph--------------------------------------------------------*/

	function month_graph_view($year,$monthly,$facility,$device,$all,$county_name_value,$report_type)
	{
		if(!$facility=="")//By Facility
		{
			$device="";
			$all="";
			$county_id="";
		}
		if(!$device=="")//By Device
		{
			$facility="";
			$all="";
			$county_id="";
		}
		if($all==4)//By County
		{	
			$facility="";
			$device="";
			$county_id=$this->reports_model->get_county_id($county_name_value);
		}
		else if($all==5)//All data
		{
			$facility="";
			$device="";
			$county_id="";
		}
		
		if($report_type==1)//Tests only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$tests_results['both_results'][] = $value['data'];
			}

			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$tests_results['tests'][] = $value['data'];
			}

		}
		else if($report_type==2)//Errors Only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$tests_results['both_results'][] = $value['data'];
			}

			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$tests_results['errors'][] = $value['data'];
			}
		}
		else if($report_type==0)//Tests and Errors
		{	
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$tests_results['both_results'][] = $value['data'];
			}

			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$tests_results['tests'][] = $value['data'];
			}

			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$tests_results['errors'][] = $value['data'];
			}	
		}
		else if($report_type==3)// Tests Less than 350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$tests_results['both_results'][] = $value['data'];
			}

			$report_type= " AND `tst_dt`.`valid`='1'  AND `tst_dt`.`cd4_count` < 350  ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$tests_results['tests'][] = $value['data'];
			}
		}
		else if($report_type==4)//Errors by percentage
		{
			$percentage_successful=0;
			$percentage_error=0;

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type);

			foreach($the_total as $key => $value)
			{
				$percentage_successful=round(($value['valid']/$value['data'])*100,1);
				$percentage_error=round(($value['errors']/$value['data'])*100,1);
			}
			$tests_results['tests'][]=$percentage_successful;
			$tests_results['errors'][]=$percentage_error;
			
		}

	return $tests_results;
	

	}
	/*---------------------- End month graph -------------------------------------------------------*/

	/*------------------------ quarter graph ------------------------------------------------------*/

	function quarter_graph_view($year,$quarter,$facility,$device,$all,$county_name_value,$report_type)
	{
		$my_array= array(0,0,0,0);

		if(!$facility=="")//By Facility
		{
			$device="";
			$all="";
			$county_id="";
		}
		if(!$device=="")//By Device
		{
			$facility="";
			$all="";
			$county_id="";
		}
		if($all==4)//By County
		{	
			$facility="";
			$device="";
			$county_id=$this->reports_model->get_county_id($county_name_value);
		}
		else if($all==5)//All data
		{
			$facility="";
			$device="";
			$county_id="";
		}

		if($quarter==1)
		{
			$start_limit=1;
			$end_limit=4;
		}
		else if($quarter==2)
		{
			$start_limit=5;
			$end_limit=8;
		}
		else if($quarter==3)
		{
			$start_limit=9;
			$end_limit=12;
		}

		if($report_type==1)//Tests only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['errors']=$my_array;
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;

			$my_array = array(0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['errors']=$my_array;
		}
		else if($report_type==3)//Tests < 350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' AND `tst_dt`.`cd4_count` < 350 ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;
		}
		else if($report_type==4)//Error Percenatge
		{
			$percentage_successful=0;
			$percentage_error=0;

			$my_array2 = array(0,0,0,0);

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$percentage_successful=round( ($value['valid']/$value['data'])*100,1);
				$percentage_error=round(($value['errors']/$value['data'])*100,1);

				$my_array[($value['mth']-1)]=$percentage_successful;
				$my_array2[($value['mth']-1)]=$percentage_error;
			}

			$tests_results['tests']=$my_array;
			$tests_results['errors']=$my_array2;
		}

	return $tests_results;	
	}
	/*--------------------- End quarter graph ------------------------------------------------------*/

	/*----------------------- biannual graph ------------------------------------------------------*/

	function biannual_graph_view($year,$biannual,$facility,$device,$all,$county_name_value,$report_type)
	{
		$my_array= array(0,0,0,0,0,0);

		if(!$facility=="")//By Facility
		{
			$device="";
			$all="";
			$county_id="";
		}
		if(!$device=="")//By Device
		{
			$facility="";
			$all="";
			$county_id="";
		}
		if($all==4)//By County
		{	
			$facility="";
			$device="";
			$county_id=$this->reports_model->get_county_id($county_name_value);
		}
		else if($all==5)//All data
		{
			$facility="";
			$device="";
			$county_id="";
		}

		if($biannual==1)
		{
			$start_limit=1;
			$end_limit=6;
		}
		else if($biannual==2)
		{
			$start_limit=7;
			$end_limit=12;
		}

		if($report_type==1)//Tests only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['errors']=$my_array;
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;

			$my_array = array(0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['errors']=$my_array;
		}
		else if($report_type==3)
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' AND `tst_dt`.`cd4_count` < 350 ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;
		}
		else if($report_type==4)//Error Percenatge
		{
			$percentage_successful=0;
			$percentage_error=0;

			$my_array2 = array(0,0,0,0,0,0);

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$percentage_successful=round( ($value['valid']/$value['data'])*100,1);
				$percentage_error=round(($value['errors']/$value['data'])*100,1);

				$my_array[($value['mth']-1)]=$percentage_successful;
				$my_array2[($value['mth']-1)]=$percentage_error;
			}

			$tests_results['tests']=$my_array;
			$tests_results['errors']=$my_array2;
		}

			
	return $tests_results;	
	}

	/*----------------------- End biannual graph --------------------------------------------------*/

	/*----------------------- Yearly graph --------------------------------------------------------*/

	function year_graph_view($year,$facility,$device,$all,$county_name_value,$report_type)
	{
		$my_array = array(0,0,0,0,0,0,0,0,0,0,0,0);

		if(!$facility=="")//By Facility
		{
			$device="";
			$all="";
			$county_id="";
		}
		if(!$device=="")//By Device
		{
			$facility="";
			$all="";
			$county_id="";
		}
		if($all==4)//By County
		{	
			$facility="";
			$device="";
			$county_id=$this->reports_model->get_county_id($county_name_value);
		}
		else if($all==5)//All data
		{
			$facility="";
			$device="";
			$county_id="";
		}

		$start_limit=1;
		$end_limit=12;

		if($report_type==1)//Tests only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['errors']=$my_array;
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;

			$my_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['errors']=$my_array;
		}
		else if($report_type==3)//Tests < 350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['both_results']=$my_array;

			$my_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
			$report_type= " AND `tst_dt`.`valid`='1' AND `tst_dt`.`cd4_count` < 350 ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$my_array[($value['mth']-1)]= $value['data'];
			}

			$tests_results['tests']=$my_array;
		}
		else if($report_type==4)//Error Percenatge
		{
			$percentage_successful=0;
			$percentage_error=0;

			$my_array2 = array(0,0,0,0,0,0,0,0,0,0,0,0);

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$percentage_successful=round( ($value['valid']/$value['data'])*100,1);
				$percentage_error=round(($value['errors']/$value['data'])*100,1);

				$my_array[($value['mth']-1)]=$percentage_successful;
				$my_array2[($value['mth']-1)]=$percentage_error;
			}

			$tests_results['tests']=$my_array;
			$tests_results['errors']=$my_array2;
		}
			
	return $tests_results;	
	}

	/*----------------------- Yearly graph --------------------------------------------------------*/

	/*----------------------- Customized graph --------------------------------------------------------*/

	function customized_graph_view($from,$to,$year,$year_end,$facility,$device,$all,$county_name_value,$report_type)
	{
		$total=0;
		$tests=0;
		$errors=0;

		if(!$facility=="")//By Facility
		{
			$device="";
			$all="";
			$county_id="";
		}
		if(!$device=="")//By Device
		{
			$facility="";
			$all="";
			$county_id="";
		}
		if($all==4)//By County
		{	
			$facility="";
			$device="";
			$county_id=$this->reports_model->get_county_id($county_name_value);
		}
		else if($all==5)//All data
		{
			$facility="";
			$device="";
			$county_id="";
		}

		if($report_type==1)//Tests only
		{
			$report_type= " ";
			
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$total+=$value['data'];
			}

			$tests_results['both_results'][]=$total;

			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$tests+=$value['data'];
			}

			$tests_results['tests'][]=$tests;

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$total+=$value['data'];
			}

			$tests_results['both_results'][]=$total;

			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$errors+=$value['data'];
			}

			$tests_results['errors'][]=$errors;
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$total+=$value['data'];
			}

			$tests_results['both_results'][]=$total;

			$report_type= " AND `tst_dt`.`valid`='1' ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$tests+=$value['data'];
			}

			$tests_results['tests'][]=$tests;

			$report_type= " AND `tst_dt`.`valid`='0' ";
			$the_errors=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_errors as $key => $value) 
			{
				$errors+=$value['data'];
			}

			$tests_results['errors'][]=$errors;
		}
		else if($report_type==3)// Tests <350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_total as $key => $value) 
			{
				$total+=$value['data'];
			}

			$tests_results['both_results'][]=$total;

			$report_type= " AND `tst_dt`.`valid`='1' AND `tst_dt`.`cd4_count` < 350 ";
			$the_tests=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach ($the_tests as $key => $value) 
			{
				$tests+=$value['data'];
			}

			$tests_results['tests'][]=$tests;
		}
		else if($report_type==4)//Errors by percentage
		{
			$percentage_successful=0;
			$percentage_error=0;
			$total_successful=0;
			$total_errors=0;
			$grand_total=0;

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type);

			foreach($the_total as $key => $value)
			{
				$total_successful+=$value['valid'];
				$total_errors+=$value['errors'];
				$grand_total+=$value['data'];		
			}

			$percentage_successful=round(($total_successful/$grand_total)*100,1);
			$percentage_error=round(($total_errors/$grand_total)*100,1);

			$tests_results['tests'][]=$percentage_successful;
			$tests_results['errors'][]=$percentage_error;
			
		}

			
	return $tests_results;	
	}

	/*----------------------- Customized graph --------------------------------------------------------*/

}
?>