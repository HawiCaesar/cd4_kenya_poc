<?php

class admin_model extends MY_Model{
	public function menus($selected){
		$menus = array(
						/*array(	'num'			=>	1,
								'name'			=>	'Home Page',
								'url'			=>	base_url()."admin",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),*/
						array(	'num'			=>	2,
								'name'			=>	'Facilities',
								'url'			=>	base_url()."admin/facilities",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	3,
								'name'			=>	'Equipment',
								'url'			=>	base_url()."admin/equipment",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	4,
								'name'			=>	'Users',
								'url'			=>	base_url()."admin/users",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	5,
								'name'			=>	'Reports',
								'url'			=>	base_url()."admin/reports",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						array(	'num'			=>	6,
								'name'			=>	'CD4 Reporting',
								'url'			=>	base_url()."admin/cd4_reports",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
						/*array(	'num'			=>	7,
								'name'			=>	'Settings',
								'url'			=>	base_url()."admin/settings",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),*/
						array(	'num'			=>	7,
								'name'			=>	'Uploads',
								'url'			=>	base_url()."admin/upload",								
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
								)
						

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
	public function admin_details(){

		// $users = 	$this->get_details("user_details");

		// foreach ($users as $user) {
		// 	$users[''] = 
		// }
	}
	function deactivated_users_count()//get the number of deactivated users
	{
		$result="";

		$sql="SELECT COUNT(id) as user_count from user where status='0'";

		$count_result=$this->db->query($sql);

		foreach($count_result->result() as $value)
		{
			$result=$value->user_count;
		}

		return $result;
	}
	function deactivated_users()//get the number of deactivated users
	{
		$result="";

		$sql="SELECT 
					`usr`.`id` AS `user_id`,
					`usr`.`username`,
					`usr`.`name`,
					`usr`.`user_group_id`,
					`usr_gr`.`name` AS `user_group`,
					`usr`.`phone`,
					`usr`.`email`,
					`usr`.`status`,
					CASE WHEN `usr_gr`.`name`='County Coordinator' THEN `r`.`name` ELSE `p`.`name` END AS `Stationed At`,
					`st`.`desc` AS `status_desc` 
					FROM `user` `usr` 
					LEFT JOIN `user_group` `usr_gr` ON `usr`.`user_group_id` = `usr_gr`.`id`
					LEFT JOIN `status` `st` ON `usr`.`status`=	`st`.`id`
					LEFT JOIN `partner_user` `pu` ON `usr`.`id`=`pu`.`user_id`
					LEFT JOIN `region_user` `ru` ON `usr`.`id`=`ru`.`user_id`
					LEFT JOIN `partner` `p` ON `pu`.`partner_id`=`p`.`ID`
					LEFT JOIN `region` 	`r` ON `ru`.`region_id`=`r`.`id`
					WHERE `usr`.`status`= '0'";

		$result 	= 	R::getAll($sql);

		return $result;
	}
	function get_facilities()//get the facilities
	{
		$sql="SELECT facility_name FROM v_facility_pima_details ";

		$query=$this->db->query($sql);

		if($query->num_rows()>0)
		{
			foreach($query->result_array() as $value)
			{
				$res[]=$value;
			}
		}
		else
		{
			$res="No data";
		}

		return $res;
	}
	function get_devices()//get the devices
	{
		$sql="SELECT fp.serial_num, f.name
					FROM facility_pima fp, facility_equipment fe, facility f
					WHERE fp.facility_equipment_id = fe.id
					AND fe.facility_id = f.id ";

		$query=$this->db->query($sql);

		if($query->num_rows()>0)
		{
			foreach($query->result_array() as $value)
			{
				$res[]=$value;
			}
		}
		else
		{
			$res="No data";
		}

		return $res;
	}
	function get_countites()//get the 
	{
		$sql="SELECT name FROM county ";

		$query=$this->db->query($sql);

		if($query->num_rows()>0)
		{
			foreach($query->result_array() as $value)
			{
				$res[]=$value;
			}
		}
		else
		{
			$res="No data";
		}

		return $res;
	}

	function get_years_tested(){
		$sql="SELECT DISTINCT YEAR( result_date ) AS year
						FROM cd4_test";//WHERE  YEAR(result_date) > = 2014
		$query=$this->db->query($sql);

		if($query->num_rows()>0)
		{
			foreach ($query->result_array() as $value) 
			{
				$res[]=$value;
			}
		}
		else
		{
			$res="No data";
		}
		return $res;
	}

	function reported_details($type){

		$today =  Date("Y-m-d");

		$from 	= Date("Y-m-1" 	, strtotime($today));
		$to 	= Date("Y-m-t" 	, strtotime($today));

		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");

		$this->config->load('sql');

		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["tests_details"];

		if($type==1)// get the facilities reported
		{
			$group_by = " GROUP BY `eq_dt`.`facility`";
		}
		else if($type==2)// get the devices reported
		{
			$group_by = " GROUP BY `tst`.`facility_equipment_id` ";
		}
		else if($type==3)// get the counties reported
		{
			$group_by = " GROUP BY `eq_dt`.`region` ";
		}


		/*$user_delimiter 	= 	"";

		if($user_group==3 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 ){
			$user_delimiter 	= 	" AND `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}*/

		$sql 	=	$sql." AND `tst`.`result_date` between '$from' and '$to' ".$group_by;
		/*
		echo $sql;
		die;*/
		
		$reported_dev 	= 	R::getAll($sql);

		return $reported_dev;
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
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` < 350 THEN 1 ELSE 0 END) AS `failed`,
							SUM(CASE WHEN `valid`= '1'  AND  `cd4_count` >= 350 THEN 1 ELSE 0 END) AS `passed`
						FROM `v_pima_uploads_details`
						WHERE 1 
						$user_delimiter 
						GROUP BY `pima_upload_id`
						ORDER BY `upload_date` DESC
						LIMIT 100
					";
		return $res 	=	R::getAll($sql);


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
}
/* End of file admin_model.php */
/* Location: ./application/modules/admin/models/admin_model.php */