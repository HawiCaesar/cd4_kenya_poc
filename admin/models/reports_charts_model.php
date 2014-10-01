<?php 

class reports_charts_model extends MY_Model{

 	function __construct()// default load
    {
        parent::__construct();

        $this->load->model('reports_charts_sql_model');
		$this->load->model('reports_model');

		$tests_results=array();

		$the_total[]=array();
		
    }

	/*------------------------ month graph--------------------------------------------------------*/

	function month_graph_view($year,$monthly,$facility,$device,$all,$county_name_value,$report_type)
	{
		$custom=0;
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
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type,$custom);
			
			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$tests_results['both_results'][] = (int)$value['data'];
					$tests_results['tests'][] = (int)$value['valid'];
				}
			}
			else
			{
				$tests_results['tests'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}

		}
		else if($report_type==2)//Errors Only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$tests_results['both_results'][] = (int)$value['data'];
					$tests_results['errors'][] = (int)$value['errors'];
				}
			}
			else
			{
				$tests_results['errors'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}
		}
		else if($report_type==0)//Tests and Errors
		{	
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{	
					$tests_results['both_results'][] = (int)$value['data'];
					$tests_results['tests'][] = (int)$value['valid'];
					$tests_results['errors'][] = (int)$value['errors'];
				}
			}
			else
			{
				$tests_results['tests'][]=0;
				$tests_results['errors'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}
		}
		else if($report_type==3)// Tests Less than 350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$tests_results['both_results'][] = (int)$value['data'];
					$tests_results['tests'][] = (int)$value['failed'];
				}

			}
			else
			{
				$tests_results['tests'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}
		}
		else if($report_type==4)//Errors by percentage
		{
			$percentage_successful=0;
			$percentage_error=0;

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$monthly,$monthly,$year,$year,$report_type,$custom);
			
			if(!empty($the_total))
			{				
				foreach($the_total as $key => $value)
				{
					$percentage_successful=round(($value['valid']/$value['data'])*100,1);
					$percentage_error=round(($value['errors']/$value['data'])*100,1);
				}
				$tests_results['tests'][]=$percentage_successful;
				$tests_results['errors'][]=$percentage_error;
			}else
			{
				$tests_results['tests'][]=0;
				$tests_results['errors'][]=0;

				return $tests_results;
			}
			
		}

		return $tests_results;
	}
	/*---------------------- End month graph -------------------------------------------------------*/

	/*------------------------ quarter graph ------------------------------------------------------*/

	function quarter_graph_view($year,$quarter,$facility,$device,$all,$county_name_value,$report_type)
	{
		$my_array1= array(0,0,0,0);
		$my_array2= array(0,0,0,0);
		$my_array3= array(0,0,0,0);

		$custom=0;

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
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{	
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['valid'];
				}
				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);
			
			if(!empty($the_total))
			{	
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['errors'];
				}
				$tests_results['both_results']=$my_array1;
				$tests_results['errors']=$my_array2;
			}else
			{
				$tests_results['errors']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);
			
			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['valid'];
					$my_array3[($value['mth']-1)]= (int)$value['errors'];
				}
				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
				$tests_results['errors']=$my_array3;
			}
			else
			{
				$tests_results['errors']=0;
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==3)//Tests < 350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['failed'];
				}

				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==4)//Error Percenatge
		{
			$percentage_successful=0;
			$percentage_error=0;

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$percentage_successful=round( ($value['valid']/$value['data'])*100,1);
					$percentage_error=round(($value['errors']/$value['data'])*100,1);

					$my_array1[($value['mth']-1)]=$percentage_successful;
					$my_array2[($value['mth']-1)]=$percentage_error;
				}

				$tests_results['tests']=$my_array1;
				$tests_results['errors']=$my_array2;
			}else
			{

				$tests_results['tests']=0;
				$tests_results['errors']=0;

				return $tests_results;
			}
		}

	return $tests_results;	
	}
	/*--------------------- End quarter graph ------------------------------------------------------*/

	/*----------------------- biannual graph ------------------------------------------------------*/

	function biannual_graph_view($year,$biannual,$facility,$device,$all,$county_name_value,$report_type)
	{
		$my_array1= array(0,0,0,0,0,0);
		$my_array2= array(0,0,0,0,0,0);
		$my_array3= array(0,0,0,0,0,0);

		$custom=0;

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
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);
			
			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['valid'];
				}
				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['valid'];
				}
				
				$tests_results['both_results']=$my_array1;
				$tests_results['errors']=$my_array2;
			}else
			{
				$tests_results['errors']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['valid'];
					$my_array3[($value['mth']-1)]= (int)$value['errors'];
				}

				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
				$tests_results['errors']=$my_array3;
			}else
			{
				$tests_results['errors']=0;
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==3)
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['failed'];
				}

				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==4)//Error Percenatge
		{
			$percentage_successful=0;
			$percentage_error=0;

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$percentage_successful=round( ($value['valid']/$value['data'])*100,1);
					$percentage_error=round(($value['errors']/$value['data'])*100,1);

					$my_array1[($value['mth']-1)]=$percentage_successful;
					$my_array2[($value['mth']-1)]=$percentage_error;
				}

				$tests_results['tests']=$my_array1;
				$tests_results['errors']=$my_array2;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['errors']=0;

				return $tests_results;
			}
		}

	return $tests_results;
	}

	/*----------------------- End biannual graph --------------------------------------------------*/

	/*----------------------- Yearly graph --------------------------------------------------------*/

	function year_graph_view($year,$facility,$device,$all,$county_name_value,$report_type)
	{
		$my_array1 = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$my_array2 = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$my_array3 = array(0,0,0,0,0,0,0,0,0,0,0,0);

		$custom=0;

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
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['valid'];
				}

				$tests_results['both_results']=$my_array;
				$tests_results['tests']=$my_array;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['errors'];
				}

				$tests_results['both_results']=$my_array1;
				$tests_results['errors']=$my_array2;
			}else
			{
				$tests_results['errors']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);
			
			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['valid'];
					$my_array3[($value['mth']-1)]= (int)$value['errors'];
				}

				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
				$tests_results['errors']=$my_array3;
			}else
			{
				$tests_results['errors']=0;
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==3)//Tests < 350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$my_array1[($value['mth']-1)]= (int)$value['data'];
					$my_array2[($value['mth']-1)]= (int)$value['failed'];
				}
				$tests_results['both_results']=$my_array1;
				$tests_results['tests']=$my_array2;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['both_results']=0;

				return $tests_results;
			}
		}
		else if($report_type==4)//Error Percenatge
		{
			$percentage_successful=0;
			$percentage_error=0;

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$start_limit,$end_limit,$year,$year,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$percentage_successful=round( ($value['valid']/$value['data'])*100,1);
					$percentage_error=round(($value['errors']/$value['data'])*100,1);

					$my_array1[($value['mth']-1)]=$percentage_successful;
					$my_array2[($value['mth']-1)]=$percentage_error;
				}

				$tests_results['tests']=$my_array1;
				$tests_results['errors']=$my_array2;
			}else
			{
				$tests_results['tests']=0;
				$tests_results['errors']=0;

				return $tests_results;
			}
		}
			
	return $tests_results;	
	}

	/*----------------------- Yearly graph --------------------------------------------------------*/

	/*----------------------- Customized graph --------------------------------------------------------*/

	function customized_graph_view($from,$to,$facility,$device,$all,$county_name_value,$report_type)
	{
		$custom=1;
		$total=0;
		$tests=0;
		$errors=0;
		$year=0;
		$year_end=0;

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
			
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$total+=(int)$value['data'];
					$tests+=(int)$value['valid'];
				}
				$tests_results['both_results'][]=$total;
				$tests_results['tests'][]=$tests;
			}else
			{
				$tests_results['tests'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}

		}
		else if($report_type==2)//Errors only
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$total+=(int)$value['data'];
					$errors+=(int)$value['errors'];
				}
				$tests_results['both_results'][]=$total;
				$tests_results['errors'][]=$errors;
			}else
			{
				$tests_results['errors'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}
		}
		else if($report_type==0)//Both Tests and Errors
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$total+=(int)$value['data'];
					$tests+=(int)$value['valid'];
					$errors+=(int)$value['errors'];
				}

				$tests_results['both_results'][]=$total;
				$tests_results['tests'][]=$tests;
				$tests_results['errors'][]=$errors;
			}else
			{
				$tests_results['errors'][]=0;
				$tests_results['tests'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}
		}
		else if($report_type==3)// Tests <350
		{
			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type,$custom);

			if(!empty($the_total))
			{
				foreach ($the_total as $key => $value) 
				{
					$total+=(int)$value['data'];
					$tests+=(int)$value['failed'];
				}
				$tests_results['both_results'][]=$total;
				$tests_results['tests'][]=$tests;
			}else
			{
				$tests_results['tests'][]=0;
				$tests_results['both_results'][]=0;

				return $tests_results;
			}
		}
		else if($report_type==4)//Errors by percentage
		{
			$percentage_successful=0;
			$percentage_error=0;
			$total_successful=0;
			$total_errors=0;
			$grand_total=0;

			$report_type= " ";
			$the_total=$this->reports_charts_sql_model->get_test_details($facility,$device,$all,$county_id,$from,$to,$year,$year_end,$report_type,$custom);
			if(!empty($the_total))
			{
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
			}else
			{
				$tests_results['tests'][]=0;
				$tests_results['errors'][]=0;

				return $tests_results;
			}
			
		}

			
	return $tests_results;	
	}

	/*----------------------- Customized graph --------------------------------------------------------*/

}
?>