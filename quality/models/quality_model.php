<?php

class quality_model extends MY_Model{


	public function menus($selected){
		$menus = array(
						array(	'num'			=>	1,
								'name'			=>	'Home Page',
								'url'			=>	base_url()."poc",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	2,
								'name'			=>	'POC Device Uploads',
								'url'			=>	base_url()."poc/upload",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	3,
								'name'			=>	'CD4 Tests',
								'url'			=>	base_url()."poc/tests",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						// array(	'num'			=>	4,
						// 		'name'			=>	'CD4 Access',
						// 		'url'			=>	base_url()."poc/access_mapping",
						// 		'other'			=>	"",
					 // 			'selected'		=>	false,
					 // 			'selectedString'=>	"",							
						// 		),
						array(	'num'			=>	4,
								'name'			=>	'Equipment',
								'url'			=>	base_url()."poc/Equipment",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	5,
								'name'			=>	'Reports',
								'url'			=>	base_url()."poc/Reports",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						 array(	'num'			=>	6,
								 'name'			=>	'POC Device Errors',
								 'url'			=>	base_url()."poc/errors",
								 'other'		=>	"",
					 			 'selected'		=>	false,
					 			 'selectedString'=>	"",							
								 ),
						 array(	'num'			=>	7,
								'name'			=>	'Quality Assurance & Control',
								'url'			=>	base_url()."quality/quality",								
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	8,
								'name'			=>	'Change Password',
								'url'			=>	"#changePassword",
								'other'			=>	" data-toggle='modal' class='menuitem submenuheader' ",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	9,
								'name'			=>	'User Guide',
								'url'			=>	base_url()."assets/files/CD4_UserGuide_Final.pdf",								
								'other'			=>	"  target='_blank' ",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						

				);
		$j=0;
		foreach($menus as $menu){				
			$j++;
		}	
		for($i=0;$i<=($j-1);$i++){
			if($menus[$i]['num']==$selected){
				$menus[$i]['selected']=true;
				$menus[$i]['selectedString']="class='current-tab' style='background: url(\"".base_url()."img/navigation-arrow.gif \" ) no-repeat center bottom'";		
				$menus[$i]['name']="<b style=\"font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif\">".$menus[$i]['name']."</b>";
			}
		}
		return $menus;
	}

	public function user_devices(){

		$user_delimiter 	= 	"";

		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");

		if($user_group==3 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}

		$this->config->load('sql');

		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["equipment_details"];

		$sql 	=	$sql.$user_delimiter;

		$user_device_details 	= 	R::getAll($sql);

		return $user_device_details;
	}

	public function devices_reported(){

		$today =  Date("Y-m-d");

		$from 	= Date("Y-m-1" 	, strtotime($today));
		$to 	= Date("Y-m-t" 	, strtotime($today));

		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");

		$this->config->load('sql');

		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["tests_details"];

		$user_delimiter 	= 	"";

		if($user_group==3 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}

		$sql 	=	$sql.$user_delimiter." AND `tst`.`result_date` between '$from' and '$to' GROUP BY `tst`.`facility_equipment_id` ";

		$reported_dev 	= 	R::getAll($sql);

		return $reported_dev;
	}
	public function devices_not_reported(){

		$user_device_details 	= 	$this->user_devices();	
		$devices_not_reported 	= 	$this->user_devices(); //to be trimmed
		$reported_devices		=	$this->devices_reported();

		//trim reported
		$k 	=	0;
		foreach ($user_device_details as $user_device) {
			foreach ($reported_devices as $reported_dev) {
				if($user_device["facility_equipment_id"]==$reported_dev["facility_equipment_id"]){					
					unset($devices_not_reported[$k]);
				}
			}
			$k++;
		}

		return $devices_not_reported;
	}
	public function errors_reported(){

		$today =  Date("Y-m-d");

		$from 	= Date("Y-m-1" 	, strtotime($today));
		$to 	= Date("Y-m-t" 	, strtotime($today));

		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");

		$this->config->load('sql');

		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["tests_details"];

		$user_delimiter 	= 	" ";

		if($user_group==3 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}

		$sql 	=	$sql.$user_delimiter." AND `tst`.`result_date` between '$from' and '$to' "; 

		//echo $sql;

		$reported_tests 	= 	R::getAll($sql);

		$succ_test = 0;

		$error     = 0;

		foreach ($reported_tests as $test) {
			if($test['valid']=1){
				$succ_test++;
			}else{
				$error++;
			}

		}

		$agg["succ_test"]	= $succ_test;
		$agg["error"]		= $error;
		$agg["total"]       = $succ_test	+	$error;

		return $agg;
	}

	function actual_facility_control_tests()
	{
		//picking control tests by week. So last monday and today

		//last monday
		$from=date('Y-m-d',strtotime('last monday'));

		//today
		$to 	= date("Y-m-d");

		$this->config->load('sql'); 

		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["pima_control_count_details"]; //load the pima_control_count_details preset sql

		$user_delimiter 	= 	"";
		$group_by=" GROUP BY `f`.`id` ";

		$user_group  = $this->session->userdata("user_group_id"); // the session of the user
		$user_filter= $this->session->userdata("user_filter");

		if($user_group==3 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0)
		{
			$user_delimiter 	= 	" AND  `p`.`ID` ='".$user_filter[0]['user_filter_id']."' ";
			$group_by=" GROUP BY `f`.`id` ";
		}
		elseif($user_group==6 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0 )
		{
			$user_delimiter 	= 	" AND `f`.`id` ='".$user_filter[0]['user_filter_id']."' ";
		}
		elseif($user_group==8 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0 )
		{
			$user_delimiter 	= 	" AND `d`.`id` ='".$user_filter[0]['user_filter_id']."' ";
		}
		elseif($user_group==9 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0 )
		{
			$user_delimiter 	= 	" AND `r`.`id` ='".$user_filter[0]['user_filter_id']."' ";
			$group_by=" GROUP BY `f`.`id` ";
		}

		//concatenate the sql with the delimeiter
	  	// $control_sql 	=	$sql.$user_delimiter." AND MONTH(`pima_control`.`result_date`) between '".date('m',strtotime($from))."' and '".date('m',strtotime($to))."' 
				// 									AND YEAR(`pima_control`.`result_date`) between '".date('Y',strtotime($from))."'
				// 									AND '".date('Y',strtotime($to))."' ".$group_by." ORDER BY `result_date` DESC ";

		$control_sql 	=	$sql.$user_delimiter." AND `pima_control`.`result_date` BETWEEN '".$from."' AND '".$to."' ".$group_by." 
													ORDER BY `pima_control`.`result_date` DESC ";  

		$control_results 	= 	R::getAll($control_sql);
		//print_r($control_sql);die;
		return $control_results;
	}

	function expected_facility_control_test()
	{
		//picking control tests by week. So last monday and today

		//last monday
		$from=date('Y-m-d',strtotime('last monday'));

		//today
		$to 	= date("Y-m-d");

		$sql="SELECT 
				COUNT(DISTINCT CAST(`tst`.`result_date` AS DATE)) as 'no_days_with_tests',
				`f`.`name` as `facility`,
				`fp`.`serial_num`
				FROM `pima_test` 
				LEFT JOIN `cd4_test` `tst`
				ON `tst`.`id`=`pima_test`.`cd4_test_id`
				LEFT JOIN `pima_upload` `pu` ON `pima_test`.`pima_upload_id`=`pu`.`id`
				LEFT JOIN `facility_pima` `fp` ON `pu`.`facility_pima_id`=`fp`.`id`
				LEFT JOIN `facility_equipment` `fe` ON `fp`.`facility_equipment_id`=`fe`.`id`
				LEFT JOIN `facility` `f` ON `fe`.`facility_id`=`f`.`id`
				LEFT JOIN `district` `d` ON `f`.`district`=`d`.`id`
				LEFT JOIN `region` `r` ON `d`.`region_id`=`r`.`id`
				LEFT JOIN `partner` `p` ON `f`.`partnerID`=`p`.`ID`

				WHERE `error_id`>= 0 
				AND `pima_test`.`sample_code`!='NORMAL' 
				AND `pima_test`.`sample_code` !='QC NORMAL' 
				AND `pima_test`.`sample_code`!='LOW' 
				AND `pima_test`.`sample_code` !='QC LOW'
				AND  1  AND `tst`.`result_date` BETWEEN '".$from."' AND '".$to."' GROUP BY `f`.`id`
				ORDER BY `tst`.`result_date` DESC";

		$expected_results 	= 	R::getAll($sql);
		//print_r($sql);die;
		return $expected_results;

	}


}

?>