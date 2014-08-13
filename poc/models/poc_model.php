<?php

class poc_model extends MY_Model{
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
	// public function devices_currently_reported()
	// {
	// 	$today =  Date("Y-m-d");

	// 	$from 	= Date("Y-m-1" 	, strtotime($today));
	// 	$to 	= Date("Y-m-t" 	, strtotime($today));

	// 	$user_delimiter 	= 	"";

	// 	$user_group  = $this->session->userdata("user_group_id");
	// 	$user_filter= $this->session->userdata("user_filter");

	// 	$sql="SELECT fp.serial_num as serial, f.name as facility
	// 				FROM facility_pima fp
	// 				LEFT JOIN facility_equipment fe ON fp.facility_equipment_id=fe.id
	// 				LEFT JOIN facility f ON fe.facility_id=f.id
	// 				LEFT JOIN cd4_test cd4 ON f.id=cd4.facility_id
	// 				LEFT JOIN district d ON f.district=d.id
	// 				LEFT JOIN region r ON d.region_id=r.id
	// 				LEFT JOIN partner p ON f.partnerID=p.ID";


	// 	if($user_group==3 && sizeof($user_filter)> 0 ){
	// 		$user_delimiter 	= 	" WHERE  p.id ='".$user_filter[0]['user_filter_id']."' ";
	// 	}elseif($user_group==6 && sizeof($user_filter)> 0 ){
	// 		$user_delimiter 	= 	" WHERE  f.id ='".$user_filter[0]['user_filter_id']."' ";
	// 	}elseif($user_group==8 && sizeof($user_filter)> 0 ){
	// 		$user_delimiter 	= 	" WHERE d.id ='".$user_filter[0]['user_filter_id']."' ";
	// 	}elseif($user_group==9 && sizeof($user_filter)> 0 ){
	// 		$user_delimiter 	= 	" WHERE  r.id ='".$user_filter[0]['user_filter_id']."' ";
	// 	}

	// 	$sql 	=	$sql.$user_delimiter." AND cd4.result_date BETWEEN '".$from."' AND '".$to."'";

	// }

	public function devices_reported(){

		$today =  Date("Y-m-d");

		$from 	= Date("Y-01-1" , strtotime($today));
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

  public function get_Upload_details($user_group_id,$user_filter_used){

		$user_delimiter =$this->sql_user_delimiter($user_group_id,$user_filter_used);

		$sql 	=	"SELECT 
							`pima_upload_id`,
							`upload_date`,
							`equipment_serial_number`,
							`facility_name`,
							`uploader_name`,
							COUNT(`pima_test_id`) AS `total_tests`,
							SUM(CASE WHEN `valid`= '1'    THEN 1 ELSE 0 END) AS `valid_tests`,
							SUM(CASE WHEN `valid`= '0'    THEN 1 ELSE 0 END) AS `errors`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`
						FROM `v_pima_uploads_details`
						WHERE 1 
						$user_delimiter 
						GROUP BY `pima_upload_id`
						ORDER BY `upload_date` DESC
						LIMIT 100
					";
		return $res 	=	R::getAll($sql);


	}

}
/* End of file poc_model.php */
/* Location: ./application/modules/poc/models/poc_model.php */