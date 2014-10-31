<?php

class overview_model_1 extends MY_Model{

		public function menus($selected){
			$menus = array(
							array(	'num'			=>	1,
									'name'			=>	'National Overview',
									'url'			=>	base_url()."home",
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

		public function devices_tests_totals($from,$to,$user_filter_used){

		$date_delimiter	 	=	"";
		$user_delimiter	 	=	"";

		//if date is set
		if(!$from==""||!$from==0||!$from==null){
			$date_delimiter	=	"AND `cd4_test`.`result_date` between '$from' and '$to'";
		}
		//USER FILTER
		$user_delimiter ="";
		
		
		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");
		
		if($user_group==3 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" AND `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" AND `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" AND `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" AND `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}

		$sql =	"SELECT `success`.`description`,
							(`success`.`total`+`fails`.`total`) AS `total`,
							`success`.`total` AS `success`,
							`fails`.`total` AS `fails`,
							((`fails`.`total`/(`success`.`total`+`fails`.`total`))*100) AS `fails_perc`
						FROM	
						(SELECT  
						         `equipment`.`description`,
						         `equipment`.`id` AS `equip_id`,
						         `fac`.`partnerID`,
						         `fac`.`id` AS `fac_id`,
						         `partner_user`.`id` AS pat_id,
						         `partner_user`.`partner_id`,
						         `region_user`.`region_id`,
								 `district_user`.`district_id`,
							     `facility_user`.`facility_id`,
					            COUNT(`cd4_test`.`cd4_count`)AS `total`
					       FROM `equipment`,`cd4_test`, `facility` `fac`,`partner_user`,`region_user`,`facility_user`,`district_user`
					       WHERE `cd4_test`.`equipment_id`=`equipment`.`id` AND `cd4_test`.`valid`=1 AND `cd4_test`.`cd4_count`>= 500
					       AND `fac`.`id`= `cd4_test`.`facility_id`
					       AND `partner_user`.`partner_id`=`fac`.`partnerID` 
					       AND `district_user`.`district_id`=`fac`.`district` 
					       AND `facility_user`.`facility_id`=`fac`.`id`
					       AND `partner_user`.`partner_id`=`fac`.`partnerID` 
					       AND  `equipment`.`status`=1
					        $date_delimiter
					        $user_delimiter
					    GROUP BY `equipment`.`description`) AS `success`
					LEFT JOIN 
						    (SELECT  `equipment`.`description`,
						             `equipment`.`id` AS `equip_id`,
						             `fac`.`partnerID`,
						             `fac`.`id` AS `fac_id`,
						             `partner_user`.`id` AS pat_id,
						             `partner_user`.`partner_id`,
						             `region_user`.`region_id`,
									 `district_user`.`district_id`,
									 `facility_user`.`facility_id`,
						            COUNT(`cd4_test`.`cd4_count`)AS `total`
						        FROM `equipment`,`cd4_test`, `facility` `fac`,`partner_user`,`region_user`,`facility_user`,`district_user`
						        WHERE `cd4_test`.`equipment_id`=`equipment`.`id` AND `cd4_test`.`valid`=1 AND `cd4_test`.`cd4_count`< 500
						        AND `fac`.`id`= `cd4_test`.`facility_id`
					            AND  `partner_user`.`partner_id`=`fac`.`partnerID`
					            AND `district_user`.`district_id`=`fac`.`district` 
					            AND `facility_user`.`facility_id`=`fac`.`id`
					            AND `partner_user`.`partner_id`=`fac`.`partnerID`  
						        AND  `equipment`.`status`=1
						        $date_delimiter
						        $user_delimiter
						    GROUP BY `equipment`.`description`) AS `fails`
						ON `fails`.`description`=`success`.`description` 
					WHERE (`success`.`total`+`fails`.`total`) <> 0
					GROUP BY `success`.`description`
			";
		$stat_assoc	=	R::getAll($sql);
		$total['description']= "Total";
		$total['total']=0;
		$total['success']=0;
		$total['fails']=0;
		

		$i=0;
		foreach ($stat_assoc as $stat) {
			$stat_assoc[$i]['fails_perc']= round($stat['fails_perc'],2)."%";

			$total['total']+=$stat['total'];
			$total['success']+=$stat['success'];
			$total['fails']+=$stat['fails'];
			$i++;			
		}
		if($total['total']>0){
			$total['fails_perc']= round(($total['fails']/$total['total'])*100,2)."%";
		}else{$total['fails_perc']=0;}
		$stat_assoc[]=$total;

		return $stat_assoc;
	}
	
	public function pima_statistics($from,$to,$user_filter_used){

		$date_delimiter	 	=	"";

		//if date is set
		if(!$from==""||!$from==0||!$from==null){
			$date_delimiter	=	"AND `cd4_test`.`result_date` between '$from' and '$to'";
		}
		//USER FILTER
		$user_delimiter=$this->get_user_sql_where_delimiter();

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

		$pima_test_sql	=	"SELECT 	`totals_res`.`totals` ,
								        `fails_res`.`fails`,
								        `success_res`.`success`,
								        `errors_res`.`errors`,
								        `valid_res`.`valid`
								        FROM 
											    (SELECT count(*) as `totals`
											        FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											     		AND `pima_test`.`sample_code`!='NORMAL' 
														AND `pima_test`.`sample_code` !='QC NORMAL' 
														AND `pima_test`.`sample_code`!='LOW' 
														AND `pima_test`.`sample_code` !='QC LOW'
											            AND  1 
											     	$date_delimiter
											     	
											    ) as `totals_res`,
											    (SELECT count(*) as `valid`
											        FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											     		AND  `pima_test`.`error_id` = 0 
											     		AND `pima_test`.`sample_code`!='NORMAL' 
														AND `pima_test`.`sample_code` !='QC NORMAL' 
														AND `pima_test`.`sample_code`!='LOW' 
														AND `pima_test`.`sample_code` !='QC LOW'
											            AND  1 
											     	$date_delimiter
											     	
											    ) as `valid_res`,
											    (SELECT count(*) as `fails`
											         FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											        AND  `cd4_test`.`cd4_count` < 500  
											        AND  `pima_test`.`error_id` = 0 
											        AND `pima_test`.`sample_code`!='NORMAL' 
													AND `pima_test`.`sample_code` !='QC NORMAL' 
													AND `pima_test`.`sample_code`!='LOW' 
													AND `pima_test`.`sample_code` !='QC LOW'
											        $date_delimiter
											      
											    ) as `fails_res`,
											    (SELECT count(*) as `success`
											         FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											        AND  `cd4_test`.`cd4_count` >= 500   
											        AND  `pima_test`.`error_id` = 0
											        AND `pima_test`.`sample_code`!='NORMAL' 
													AND `pima_test`.`sample_code` !='QC NORMAL' 
													AND `pima_test`.`sample_code`!='LOW' 
													AND `pima_test`.`sample_code` !='QC LOW' 
											        $date_delimiter
											       
											    ) as `success_res`,
											    (SELECT count(*) as `errors`
											        FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											        AND  `pima_test`.`error_id` > 0 
											        AND `pima_test`.`sample_code`!='NORMAL' 
													AND `pima_test`.`sample_code` !='QC NORMAL' 
													AND `pima_test`.`sample_code`!='LOW' 
													AND `pima_test`.`sample_code` !='QC LOW'
											        $date_delimiter
											        
											    ) as `errors_res`
									";
		$pima_test_res	=	R::getAll($pima_test_sql);
		
		//catching division by zero error
		if($pima_test_res[0]['totals']==0){
			$pima_perc_fails	= 0 ;
		}else{
			$pima_perc_fails =(($pima_test_res[0]['fails']/$pima_test_res[0]['totals'])*100);
		}
		$pima_array		=	array(	
									array(
										'caption'	=>	"# of CD4 Tests Performed",
										'data'		=>	$pima_test_res[0]['totals']
										),
									array(
										'caption'	=>	"# of CD4 Valid Tests Performed",
										'data'		=>	$pima_test_res[0]['valid']
										),
									array(
										'caption'	=>	"CD4 Tests < 500 cells/mm3",
										'data'		=>	$pima_test_res[0]['fails']
										),
									array(
										'caption'	=>	"CD4 Tests > 500 cells/mm3",
										'data'		=>	$pima_test_res[0]['success']
										),
									array(
										'caption'	=>	"# of Failed/error Tests",
										'data'		=>	$pima_test_res[0]['errors']
										),
									// array(
									// 	'caption'	=>	"# of Devices Reported during last upload",
									// 	'data'		=>	""
									// 	),
									// array(
									// 	'caption'	=>	"% Reporting",
									// 	'data'		=>	""
									// 	)
								);
		return $pima_array;
	}

	/* This function brings the sql results broken down by county */
	function national_view_data_detailed($from,$to)
	{
		$sql="SELECT vfp.region_id,vfp.region_name as region_name,
					COUNT(DISTINCT(vfp.facility_pima_serial_num)) as number_of_devices,
					COUNT(DISTINCT(cd4t.facility_id)) as reported_devices,
					(COUNT(DISTINCT(cd4t.facility_id))/COUNT(DISTINCT(vfp.facility_pima_serial_num))*100) as percentage_reported,
					COUNT(cd4t.id)as total_tests,
					SUM(CASE WHEN `p_t`.`error_id`= '0' THEN 1 ELSE 0 END) AS `valid`,
					SUM(CASE WHEN `p_t`.`error_id`> '0' THEN 1 ELSE 0 END) AS `errors`,
					SUM(CASE WHEN `cd4t`.`cd4_count` < 500 AND `p_t`.`error_id`= '0' THEN 1 ELSE 0 END) AS `failed`,
					SUM(CASE WHEN `cd4t`.`cd4_count` >= 500 AND `p_t`.`error_id`= '0' THEN 1 ELSE 0 END) AS `passed`
					from v_facility_pima_details vfp
										LEFT JOIN (SELECT cd4.id,cd4.facility_id,cd4.cd4_count,cd4.valid
													FROM cd4_test cd4 
													WHERE `cd4`.`result_date` BETWEEN '".$from."' AND '".$to."' ) 
										as `cd4t` ON vfp.facility_id=`cd4t`.facility_id
										LEFT JOIN(SELECT pt.cd4_test_id,pt.error_id from pima_test pt
													WHERE `pt`.`sample_code`!='NORMAL' 
													AND `pt`.`sample_code` !='QC NORMAL' 
													AND `pt`.`sample_code`!='LOW' 
													AND `pt`.`sample_code` !='QC LOW'
													) as p_t
										ON cd4t.id=p_t.cd4_test_id
					WHERE vfp.facility_equipment_status='Functional' AND p_t.error_id>=0
					GROUP BY vfp.region_name";
		//$sql="call map_procedure('".$from."','".$to."')";

		return $results=R::getAll($sql);
	}
	/* This function brings sql results as a summary */
	function national_view_data_summary($from,$to)
	{
		$sql_summary="SELECT
						COUNT(DISTINCT(vfp.facility_pima_serial_num)) as number_of_devices,
						COUNT(DISTINCT(cd4t.facility_id)) as reported_devices,
						(COUNT(DISTINCT(vfp.facility_pima_serial_num))-COUNT(DISTINCT(cd4t.facility_id))) as not_reported,
						(COUNT(DISTINCT(cd4t.facility_id))/COUNT(DISTINCT(vfp.facility_pima_serial_num))*100) as percentage_reported,
						(100-COUNT(DISTINCT(cd4t.facility_id))/COUNT(DISTINCT(vfp.facility_pima_serial_num))*100) as percentage_not
						from v_facility_pima_details vfp
											LEFT JOIN (SELECT cd4.id,cd4.facility_id,cd4.cd4_count,cd4.valid
														FROM cd4_test cd4 
														WHERE `cd4`.`result_date` BETWEEN '".$from."' AND '".$to."' ) 
											as `cd4t` ON vfp.facility_id=`cd4t`.facility_id
											LEFT JOIN(SELECT pt.cd4_test_id,pt.error_id from pima_test pt
															WHERE pt.sample_code!='NORMAL' 
															AND pt.sample_code !='QC NORMAL' 
															AND pt.sample_code!='LOW' 
															AND pt.sample_code !='QC LOW') as p_t
											ON cd4t.id=p_t.cd4_test_id
						WHERE vfp.facility_equipment_status='Functional'";

		return $summary=R::getAll($sql_summary);
	}
	/* This is a progress bar function to show percentage reported */
	function national_view_progress_bar_reported($from,$to)
	{
		$summary_results=$this->national_view_data_summary($from,$to);

		foreach($summary_results as $summary_report)
		{
			$reported_summary=(int)$summary_report['percentage_reported'];
		}

		$progress_bar='<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$reported_summary.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$reported_summary.'%;">
						    <b>'.$reported_summary.'%</b>
						  </div>';

		return $progress_bar;
	}
	/* This function shows counties that have not reported */
	function national_view_breakdown_not_reported($from,$to)
	{
		$summary_results=$this->national_view_data_detailed($from,$to);
		$number_not_reporting=$this->national_view_data_summary($from,$to);

		foreach($number_not_reporting as $nor)
		{
			$not_reporting_devices=$nor['not_reported'];
			$total_devices=$nor['number_of_devices'];
		}
		$datatables='<script type="text/javascript">
						$(document).ready(function () {
					    $("#data-table_not").dataTable({
					    	"bProcessing": true,
							"iDisplayLength": 5,
						 	"bJQueryUI":true,
							"bSort":true,
						  	"bPaginate":true,
							});
					} );
		</script>';
		$not_reported_counties=$datatables."<center><b style='font-size:16px;'>$not_reporting_devices / $total_devices Devices Have Not Reported</b></center><br />
		<table id='data-table_not' class='data-table-not'>
										<thead>
												<td><b>County</b></td>
												<td><center><b># Devices in County</b></center></td>
												<td><center><b># Not Reporting in County</b></center></td>
										</thead>
										<tbody>";

		

		foreach($summary_results as $summary_report)
		{
			if($summary_report['percentage_reported']<100)
			{
				$not_reported_counties.="<tr>
											<td>".$summary_report['region_name']."</td>
											<td><center>".$summary_report['number_of_devices']."</center></td>
											<td><center>".($summary_report['number_of_devices']-$summary_report['reported_devices'])."</center></td>
										</tr>";
			}
		}
		$not_reported_counties.="</tbody></table>";
		return $not_reported_counties;
	}
	/* This is a progress bar function to show percentage not reported */
	function national_view_progress_bar_not_reported($from,$to)
	{
		$summary_results=$this->national_view_data_summary($from,$to);

		foreach($summary_results as $summary_report)
		{
			$reported_summary=(int)$summary_report['percentage_not'];
		}

		$progress_bar='<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'.$reported_summary.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$reported_summary.'%;">
						    <a href="#nrep" data-toggle="modal"><b style="color:black;">'.$reported_summary.'%</b></a>
						  </div>';

		return $progress_bar;
	}
	/* This is the Kenyan map */
	function home_map_data($from,$to)
	{
		$map = array();
        $datas = array();

		$national_results=$this->national_view_data_detailed($from,$to); //fetch map data

		foreach($national_results as $row)
		{
			$region_id	=	(int)$row["region_id"];
			$region_name=	$row["region_name"];
			$total_tests = (int)$row["total_tests"];
			$less_than500 = (int)$row["failed"];
			$greater_than500 = (int)$row["passed"];
			$errors = (int)$row["errors"];
			$percentage=floor((int)$row['percentage_reported']);
			$no_of_devices=(int)$row['number_of_devices'];
			$reported_devices=(int)$row['reported_devices'];

			switch ($percentage) {
                case ($percentage < 25):
                    $status = '#FFCC99';
                    break;

                case ($percentage ==25 || $percentage < 49):
                    $status = '#FFCCCC';
                    break;

                case ($percentage == 50 || $percentage < 75):
                    $status = '#FFFFCC';
                    break;

                case ($percentage ==75 || $percentage < 99):
                    $status = '#CBCB96';
                    break;
               case ($percentage == 100):
                    $status = '#B3D7FF';
                    break;
             }

			$datas[]=array('id' => $region_id, 'value' => $region_name, 'color' => $status, 
							'tooltext' => $region_name.' County{br}Percentage Reported: '.$percentage.' %{br}Total No. of Devices: '.$no_of_devices.'{br}Reported Devices: '.$reported_devices.'{br}Total Tests: '.$total_tests.'{br}Total Tests < 500cp/ml: '.$less_than500.'{br}Total Tests >=500cp/ml: '.$greater_than500.'{br}Total Errors: '.$errors);

		}
		/* Map settings and aesthetics */
		$map[]=array("showBevel" => "0",
					 "showLegend"=>"1",
					 "showMarkerLabels" => "1",
					 "fillColor"=> "F7F7F7",
					 "baseFontColor"=>"000000",
					 "borderColor"=> "000000",
					 "toolTipBgColor"=>"FEFEFE",/*21232E*/
					 "hoverColor"=> "535666",
					 "canvasBorderColor"=>"FFFFFF",
					 "bgColor"=>"e9e9e9",
					 "baseFont"=>"Verdana",
					 "baseFontSize"=>"10" ,
					 "markerBorderColor"=>"000000",
					 "markerBgColor"=>"FF5904",
					 "markerRadius"=>"6",
					 "legendPosition"=>"RIGHT",
					 "legendIconScale"=>'3',
					 "useHoverColor"=>"1",
					 "showMarkerToolTip"=>"0",
					 "showExportDataMenuItem"=>"1");
		$styles[] = array("name"=>"myShadow", "type"=>"Shadow","distance"=>"1");
		$finalMap = array('map' => $map, 'data' => $datas, 'styles' => $styles);
		$finalMap = json_encode($finalMap);
        
       echo $finalMap;die;
	}


	 function yearly_pima_result_trend($year){
		//USER FILTER
		//$user_delimiter=$this->get_user_sql_where_delimiter();
		
		$user_delimiter ="";
		
		
		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");
		
		if($user_group==3 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}

		if(!$user_delimiter)
		{
			$user_delimiter='1';
		}
	
		$sql="call yearly_pima_result_trend($year,'".$user_delimiter."')";

		$tests_assoc	=	$this->db->query($sql);

		$tests_array	= array(0,0,0,0,0,0,0,0,0,0,0,0);
		
		$data = array();

		if($tests_assoc->num_rows()>0)
		{
			foreach ($tests_assoc->result_array() as $test) {
				$tests_array[($test['month']-1)] = (int)$test['reported'];			
			}
		}

		$data['valid']=$tests_array;

		$tests_assoc->next_result();
		$tests_assoc->free_result();
		return $data;
	}
	function yearly_pima_errors_trend($year){
			
		$user_delimiter ="";
		
		
		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");
		
		if($user_group==3 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}

		if(!$user_delimiter)
		{
			$user_delimiter='1';
		}

		$sql="call yearly_pima_errors_trend($year,'".$user_delimiter."')";

		$errors_assoc	=	$this->db->query($sql);

		$errors_array	= array(0,0,0,0,0,0,0,0,0,0,0,0);
		$data = array();

		if($errors_assoc->num_rows()>0)
		{
			foreach ($errors_assoc->result_array() as $error) {
				$errors_array[($error['month']-1)] = (int)$error['errors'];	
			}
		}

		$data['errors']=$errors_array;

		$errors_assoc->next_result();
		$errors_assoc->free_result();

		return $data;
	}
	public function periodic_test_error_perc($from,$to){
		$date_delimiter	 	=	"";
		
		if(!$from==""||!$from==0||!$from==null){

			$sql="call periodic_test_error_perc('$from','$to')";
		}

		$tests=$this->db->query($sql);

		$tests_results=$tests->row_array();

		$tests->next_result();
		$tests->free_result();

		return $tests_results;
		// $tests 	=		R::getAll($sql);

		//print_r($tests);die;

	}
	public function periodic_facility_pima_errors($from,$to){
		
        $user_delimiter ="";
		$error_results=array();

		$user_group  = $this->session->userdata("user_group_id");
		$user_filter= $this->session->userdata("user_filter");
		
		if($user_group==3 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `partner_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==6 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `facility_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==8 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `district_id` ='".$user_filter[0]['user_filter_id']."' ";
		}elseif($user_group==9 && sizeof($user_filter)> 0 && $this->session->userdata("user_filter_used")!=0  ){
			$user_delimiter 	= 	" `region_id` ='".$user_filter[0]['user_filter_id']."' ";
		}

		if(!$from==""||!$from==0||!$from==null){

			if($user_delimiter)
			{
				$sql="call periodic_facility_pima_errors('$from','$to','$user_delimiter')";
			}else
			{
				$sql="call periodic_facility_pima_errors('$from','$to','1')";
			}
			
		}
		$errors_reported_assoc 	=	$this->db->query($sql);

		if($errors_reported_assoc->num_rows()>0)
		{
			foreach($errors_reported_assoc->result_array() as $key => $error_reported)
			{
				$error_results[$key]["name"][0]=$error_reported['error_detail'].'(Code '.$error_reported['error_code'].')';
				$error_results[$key]["data"][0]=(int)$error_reported['total'];
			}
		}
		
		$errors_reported_assoc->next_result();
		$errors_reported_assoc->free_result();

		return $error_results;
	}
	function month_categories(){
		$cat = array();
		for($i=1;$i<=12;$i++){
			$cat[]=$this->get_month_name($i);
		}
		return $cat;
	}

}
?>