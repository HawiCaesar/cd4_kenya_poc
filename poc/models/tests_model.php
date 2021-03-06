<?php

class tests_model extends MY_Model{
	
	public function get_tests_details($from,$to){

		$date_delimiter	 	=	"";
		$user_delimiter     =   "";
		
		//DATE FILTER
		if(!$from==""||!$from==0||!$from==null){
			$date_delimiter	=	" AND `tst`.`result_date` between '$from' and '$to' ";
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
		
		
		$tests_sql	=	"SELECT 
						CONCAT(YEAR(`tst`.`result_date`),'-',MONTH(`tst`.`result_date`)) AS `yearmonth`, 
						`tst`.`result_date`,						
						MONTH(`tst`.`result_date`) AS `month`,
						COUNT(*) AS `total_tests`,
						YEAR(`tst`.`result_date`) AS `year`,
						COUNT(`tst`.`id`) AS `total_tests`,
						SUM(CASE WHEN `pima_test`.`error_id`= '0'    THEN 1 ELSE 0 END) AS `valid`,
						SUM(CASE WHEN `pima_test`.`error_id`> 0  THEN 1 ELSE 0 END) AS `errors`,
						SUM(CASE WHEN `pima_test`.`error_id` = 0  AND  `tst`.`cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
						SUM(CASE WHEN `pima_test`.`error_id` = 0  AND  `tst`.`cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`
					FROM `pima_test`
					LEFT JOIN `cd4_test` `tst`
						ON `tst`.`id`=`pima_test`.`cd4_test_id`
					LEFT JOIN 
															(SELECT `fac`.`id` AS `facility_id`,
																	`fac`.`name` AS `facility`,
																	`fac`.`email`,
																	`fac`.`rolloutstatus` AS `rollout_id`,
																	`st`.`desc` AS `facility_rollout_status`,
																	`fac`.`rolloutDate`,																	
																	`dis`.`id` AS `district_id`,
																	`dis`.`name` AS `district`,
																	`dis`.`status` AS `district_status`,
																	`dis`.`region_id`,
																	`dis`.`region`,
																	`dis`.`region_status`,
																	`par`.`ID` AS `partner_id`,
																	`par`.`name` AS `partner`,
																	COUNT(`fu`.`facility_id`) AS `users_count`
														 		FROM `facility` `fac` 
														 		LEFT JOIN 
														 			(SELECT `dis`.*,
														 					`reg`.`name` AS `region`,
		                                                             		`reg`.`status` AS `region_status`
														 				FROM `district` `dis`
														 				LEFT JOIN 
														 					(SELECT `reg`.*,
														 							`dis`.`region_id`
														 						FROM `region` `reg`
														 						LEFT JOIN `district` `dis`
																		        ON `reg`.`id` = `dis`.`region_id` 
														 						) AS `reg`
																		ON `dis`.`region_id` =	`reg`.`id` 	 
														 				) AS `dis` 
																ON `fac`.`district` =	`dis`.`id` 
																LEFT JOIN `status` `st`
																ON `fac`.`rolloutstatus`= `st`.`id` 
																LEFT JOIN `partner` `par`
																ON `fac`.`partnerID`= `par`.`ID` 
																LEFT JOIN `facility_user` `fu`
																ON `fac`.`id`=`fu`.`facility_id`
																LEFT JOIN `facility_equipment` `fac_eq`
																ON `fac`.`id` = `fac_eq`.`facility_id`
																GROUP BY `facility_id`
																) AS `fac`
													ON `tst`.`facility_id`= `fac`.`facility_id` 
					
					WHERE `error_id`>= 0 
					AND YEAR(`tst`.`result_date`) = 2014
					AND `pima_test`.`sample_code`!='NORMAL' 
					AND `pima_test`.`sample_code` !='QC NORMAL' 
					AND `pima_test`.`sample_code`!='LOW' 
					AND `pima_test`.`sample_code` !='QC LOW'
					AND  1 
					
					$date_delimiter
				    $user_delimiter
					GROUP BY `yearmonth`	
					ORDER BY 	`result_date` DESC
												  
												  ";

		//$tests_sql1 	=	$tests_sql.$user_delimiter;


		$tests_details 		=		R::getAll($tests_sql);

		return $tests_details;
	}
}
/*`region` `reg`,`district` `dist`,`region_user` `reg_user`*/
/* End of file tests_model.php */
/* Location: ./application/modules/poc/models/tests_model.php */