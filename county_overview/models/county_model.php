<?php

class county_model extends MY_Model{

		public function menus($selected){
			$menus = array(
							array(	'num'			=>	1,
									'name'			=>	'National Overview',
									'url'			=>	base_url()."home",
									'other'			=>	"",
						 			'selected'		=>	false,
						 			'selectedString'=>	"",							
									),
							array(	'num'			=>	2,
									'name'			=>	'County Overview',
									'url'			=>	base_url()."county_overview",
									'other'			=>	"",
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

	/* This function brings the sql results broken down by county */
	function national_view_data_detailed($from,$to)
	{
		$detailed_view=array();

		$sql="call detailed_reporting(".date('m',strtotime($from)).",".date('m',strtotime($to)).",
																".date('Y',strtotime($from)).",".date('Y',strtotime($to)).")";

		//$this->db->cache_on();
		$detailed_sql=$this->db->query($sql);

		foreach($detailed_sql->result_array() as $view)
		{
			$detailed_view[$view['region']]=$view;
		}

		$detailed_sql->next_result();
		$detailed_sql->free_result();

		//$detailed_view=R::getAll($sql);

		return $detailed_view;
	}

	
	function county_devices($from,$to)
	{
		$county_devices_results=array();

		$sql="call county_devices('".$from."','".$to."')";

		$county_devices_sql=$this->db->query($sql);

		foreach($county_devices_sql->result_array() as $county_view)
		{
			$county_devices_results[]=$county_view;
		}

		$county_devices_sql->next_result();
		$county_devices_sql->free_result();

		return $county_devices_results;
	}

	function county_table_breakdown($from,$to)
	{	
		$county_table_breakdown=array();

		$national_results=$this->national_view_data_detailed($from,$to); //fetch data

		foreach($national_results as $county_result)
		{
			$county_table_breakdown[]=$county_result;
		}

		return $county_table_breakdown;
	}


}