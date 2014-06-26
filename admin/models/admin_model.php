<?php

class admin_model extends MY_Model{
	public function menus($selected){
		$menus = array(
						array(	'num'			=>	1,
								'name'			=>	'Home Page',
								'url'			=>	base_url()."admin",
								'other'			=>	"",
					 			'selected'		=>	false,
					 			'selectedString'=>	"",							
								),
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
						array(	'num'			=>	7,
								'name'			=>	'Settings',
								'url'			=>	base_url()."admin/settings",
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
	public function admin_details(){

		// $users = 	$this->get_details("user_details");

		// foreach ($users as $user) {
		// 	$users[''] = 
		// }
	}
	function get_facilities()//get the facilities
	{
		$sql="SELECT name FROM facility ";

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


}
/* End of file admin_model.php */
/* Location: ./application/modules/admin/models/admin_model.php */