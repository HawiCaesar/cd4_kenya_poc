<?php

class overview_model extends MY_Model{

public function devices_tests_totals($from,$to,$user_filter_used){

		$date_delimiter	 	=	"";
		$user_delimiter	 	=	"";

		//if date is set
		if(!$from==""||!$from==0||!$from==null){
			$date_delimiter	=	"AND `cd4_test`.`result_date` between '$from' and '$to'";
		}
		//USER FILTER
		//$user_delimiter=$this->get_user_sql_where_delimiter();
		
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
					       WHERE `cd4_test`.`equipment_id`=`equipment`.`id` AND `cd4_test`.`valid`=1 AND `cd4_test`.`cd4_count`>= 350
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
						        WHERE `cd4_test`.`equipment_id`=`equipment`.`id` AND `cd4_test`.`valid`=1 AND `cd4_test`.`cd4_count`< 350
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
	
	public function pima_statistics($from,$to){

		$date_delimiter	 	=	"";

		//if date is set
		if(!$from==""||!$from==0||!$from==null){
			$date_delimiter	=	"AND `cd4_test`.`result_date` between '$from' and '$to'";
		}
		//USER FILTER
		//$user_delimiter=$this->get_user_sql_where_delimiter();
		
		/*$user_delimiter 	= 	"";

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
		}*/

		$pima_test_sql	=	"SELECT 	`totals_res`.`totals` ,
								        `fails_res`.`fails`,
								        `success_res`.`success`,
								        `errors_res`.`errors`
								        FROM 
											    (SELECT count(*) as `totals`
											        FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											            AND  1 
											     	$date_delimiter 
											    ) as `totals_res`,
											    (SELECT count(*) as `fails`
											         FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											        AND  `cd4_test`.`cd4_count` < 350  
											        AND  `pima_test`.`error_id` = 0 
											        $date_delimiter  
											    ) as `fails_res`,
											    (SELECT count(*) as `success`
											         FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											        AND  `cd4_test`.`cd4_count` >= 350   
											        AND  `pima_test`.`error_id` = 0 
											        $date_delimiter
											    ) as `success_res`,
											    (SELECT count(*) as `errors`
											        FROM  `pima_test`,`cd4_test`
											     		WHERE `pima_test`.`cd4_test_id`=`cd4_test`.`id`
											        AND  `pima_test`.`error_id` > 0 
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
										'caption'	=>	"CD4 Tests < 350 cells/mm3",
										'data'		=>	$pima_test_res[0]['fails']
										),
									array(
										'caption'	=>	"CD4 Tests > 350 cells/mm3",
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

}
?>