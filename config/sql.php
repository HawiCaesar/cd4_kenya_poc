<?php
/*
|--------------------------------------------------------------------------
| PRESET CD4 SQL LIBRARY
|--------------------------------------------------------------------------
|
| Path to the script directory.  Relative to the CI front controller.
 * @package		sql
 * @usage 		-load config ->item("preset_sql");
 *				-returns a predefines resultset
*/
$sql["facility_details"] = $sql["facilities"] 	= 	"SELECT `fac`.`id` AS `facility_id`,
															`fac`.`name` AS `facility`,
															`fac`.`rolloutstatus` AS `rollout_id`,
															`st`.`desc` AS `facility_rollout_status`,
															`fac`.`rolloutDate`,
															`dis`.`id` AS `district_id`,
															`dis`.`name` AS `district`,
															`dis`.`status` AS `district_status`,
															`dis`.`regionid`,
															`dis`.`region`,
															`dis`.`region_status`,
															`par`.`ID` AS `partner_id`,
															`par`.`name` AS `partner`,
															COUNT(`fac_eq`.`facility_id`) AS `equipment_count`,
															COUNT(`fu`.`facility_id`) AS `users_count`
												 		FROM `facility` `fac` 
												 		LEFT JOIN 
												 			(SELECT `dis`.*,
															        `reg`.`id` AS `regionid`,
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
														LEFT JOIN `facility_user` `fu`
														ON `fac`.`id`=`fu`.`facility_id`
														LEFT JOIN `partner` `par`
														ON `fac`.`partnerID` = `par`.`ID`
														LEFT JOIN `facility_equipment` `fac_eq`
														ON `fac`.`id` = `fac_eq`.`facility_id` 
														
														WHERE `fac_eq`.`status`=1
														GROUP BY `facility` ASC
														" ;
														

$sql["equipment_details"] = $sql["equipment"] 	= 	"SELECT `fac_eq`.`id` AS `facility_equipment_id`,
															`eq_cat`.`description` AS `equipment_category`,
															`eq`.`id` AS `equipment_id`,
															`eq`.`description` AS `equipment`,
															`fac_eq`.`status` AS `equipment_status`,
															`fac_eq`.`deactivation_reason` ,															
															`fac_eq`.`date_added` ,													
															`fac_eq`.`date_removed` ,
															`fac`.*,
															`fac_pima`.`serial_num` AS serial 
														FROM `facility_equipment` `fac_eq` 
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
																ON `fac`.`partnerID`=`par`.`ID`
																LEFT JOIN `facility_user` `fu`
																ON `fac`.`id`=`fu`.`facility_id`
																LEFT JOIN `facility_equipment` `fac_eq`
																ON `fac`.`id` = `fac_eq`.`facility_id`
																GROUP BY `facility_id`
																) AS `fac`
														ON 	`fac_eq`.`facility_id` = `fac`.`facility_id`
														LEFT JOIN `equipment` `eq`
														ON `fac_eq`.`equipment_id`= `eq`.`id`
														LEFT JOIN `equipment_category` `eq_cat`
														ON `eq`.`category`= `eq_cat`.`id`
														LEFT JOIN `facility_pima` `fac_pima`
														ON `fac_eq`.`id`= `fac_pima`.`facility_equipment_id`
															
														WHERE 1 
														
														" ;
$sql["user_details"] = $sql["user"] = 	"SELECT 
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
												WHERE `usr`.`status`= '1' 
												";

$sql["pima_uploads_details"] = $sql["pima_uploads"] = 	"SELECT  
																`upl`.`id` AS `upload_id`,
																`upl`.`upload_date`,
																`upl`.`facility_pima_id`,
																`upl`.`uploaded_by` AS `uploaded_by_id`,
																`usr`.`username` AS `uploaded_by_username`,
																`usr`.`name` AS `uploaded_by_name`,
																`fac_pim`.`serial_num`,
																`fac_pim`.`printer_serial`,
																`upl_summary`.*																										
															FROM `pima_upload` `upl`
															LEFT JOIN `user` `usr`
															ON `upl`.`uploaded_by` = `usr`.`id`
															LEFT JOIN `facility_pima` `fac_pim`
															ON `upl`.`facility_pima_id` = `fac_pim`.`id`	
																LEFT JOIN `facility_equipment` `fac_eq`
																ON `fac_pim`.`facility_equipment_id` = `fac_eq`.`id`																
															LEFT JOIN 
																(SELECT 																		
																		`pim_tst`.`pima_upload_id`,
																		COUNT(`tst`.`id`) AS `total_tests`,
																		SUM(CASE WHEN `tst`.`valid`= '1'    THEN 1 ELSE 0 END) AS `valid_tests`,
																		SUM(CASE WHEN `tst`.`valid`= '0'    THEN 1 ELSE 0 END) AS `errors`,
																		SUM(CASE WHEN `tst`.`valid`= '1'  AND  `tst`.`cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
																		SUM(CASE WHEN `tst`.`valid`= '1'  AND  `tst`.`cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`,
																		`tst`.* 
																	FROM (SELECT 
																				`tst`.`id` AS `cd4_test_id`,
																				`tst`.`cd4_count`,
																				`tst`.`result_date`,
																				`tst`.`valid`,
																				`tst`.`id`,
																				`eq_dt`.*
																			FROM `cd4_test`  `tst`
																			LEFT JOIN 
																				(SELECT `fac_eq`.`id` AS `facility_equipment_id`,
																					`eq_cat`.`description` AS `equipment_category`,
																					`eq`.`id` AS `equipment_id`,
																					`eq`.`description` AS `equipment`,
																					`fac_eq`.`status` AS `equipment_status`,
																					`fac_eq`.`deactivation_reason` ,															
																					`fac_eq`.`date_added` ,													
																					`fac_eq`.`date_removed` ,
																					`fac`.*
																				FROM `facility_equipment` `fac_eq` 
																				LEFT JOIN 
																					(SELECT `fac`.`id` AS `facility_id`,
																							`fac`.`name` AS `facility`,
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
																                        ON `fac`.`partnerID`=`par`.`ID`																						
																						LEFT JOIN `facility_user` `fu`
																						ON `fac`.`id`=`fu`.`facility_id`
																						LEFT JOIN `facility_equipment` `fac_eq`
																						ON `fac`.`id` = `fac_eq`.`facility_id`
																						GROUP BY `facility_id`
																						) AS `fac`
																				ON 	`fac_eq`.`facility_id` = `fac`.`facility_id`
																				LEFT JOIN `equipment` `eq`
																				ON `fac_eq`.`equipment_id`= `eq`.`id`
																					LEFT JOIN `equipment_category` `eq_cat`
																					ON `eq`.`category`= `eq_cat`.`id`
																					) AS `eq_dt`
																			ON `tst`.`facility_equipment_id`= `eq_dt`.`facility_equipment_id`
																			) `tst`
																	LEFT JOIN `pima_test` `pim_tst`
																	ON `tst`.`id` = `pim_tst`.`cd4_test_id`
																	
																	GROUP BY `pim_tst`.`pima_upload_id`
																	) AS `upl_summary`
															ON `upl`.`id`= `upl_summary`.`pima_upload_id`
															 

															WHERE 1
													";
$sql["delimiter_details"] = $sql["delimiter"] = "SELECT 
														``.``
												
												";
$sql["tests_aggregates"] = 				 "SELECT 
												`tst`.`result_date`,
												MONTH(`tst`.`result_date`) AS `month`,
												YEAR(`tst`.`result_date`) AS `year`,
												COUNT(DISTINCT `fac`.`name`) AS `facilities_reported`,												
												COUNT(`tst`.`id`) AS `total_tests`,
												SUM(CASE WHEN `tst`.`valid`= '1'    THEN 1 ELSE 0 END) AS `valid`,
												SUM(CASE WHEN `tst`.`valid`= '0'    THEN 1 ELSE 0 END) AS `errors`,
												SUM(CASE WHEN `tst`.`valid`= '1'  AND  `tst`.`cd4_count` < 500 THEN 1 ELSE 0 END) AS `failed`,
												SUM(CASE WHEN `tst`.`valid`= '1'  AND  `tst`.`cd4_count` >= 500 THEN 1 ELSE 0 END) AS `passed`,
												CONCAT(YEAR(`tst`.`result_date`),'-',MONTH(`tst`.`result_date`)) AS `yearmonth`											
											FROM `cd4_test` `tst`
											LEFT JOIN `facility` `fac`
											ON `tst`.`facility_id`= `fac`.`id`

											WHERE 1 

											GROUP BY  	`yearmonth`	
											ORDER BY 	`result_date` DESC																			
									";
$sql["tests_details"] = $sql["tests"] = 		"SELECT 
														`tst`.`id` AS `cd4_test_id`,
														`tst`.`cd4_count`,
														`tst`.`facility_equipment_id`,
														`tst`.`result_date`,
														`tst`.`valid`,
														`fps`.`serial_num` as `serial`,
														`tst`.`id`,
														`eq_dt`.*
													FROM `cd4_test`  `tst`
													LEFT JOIN 
														(SELECT `fac_eq`.`id` AS `facility_equipment_id`,
															`eq_cat`.`description` AS `equipment_category`,
															`eq`.`id` AS `equipment_id`,
															`eq`.`description` AS `equipment`,
															`fac_eq`.`status` AS `equipment_status`,
															`fac_eq`.`deactivation_reason` ,															
															`fac_eq`.`date_added` ,													
															`fac_eq`.`date_removed` ,
															`fac`.*
														FROM `facility_equipment` `fac_eq` 
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
														ON 	`fac_eq`.`facility_id` = `fac`.`facility_id`
														LEFT JOIN `equipment` `eq`
														ON `fac_eq`.`equipment_id`= `eq`.`id`
															LEFT JOIN `equipment_category` `eq_cat`
															ON `eq`.`category`= `eq_cat`.`id`
															) AS `eq_dt`
													ON `tst`.`facility_equipment_id`= `eq_dt`.`facility_equipment_id`
													LEFT JOIN (SELECT `fp`.`serial_num`,`fp`.`facility_equipment_id` FROM `facility_pima` `fp`) as `fps`
													ON `tst`.`facility_equipment_id`=`fps`.`facility_equipment_id`
													LEFT JOIN (SELECT `pim`.`sample_code`, `pim`.`cd4_test_id` FROM `pima_test` `pim`) as `pimt`
													ON `tst`.`id`=`pimt`.`cd4_test_id`
													WHERE `pimt`.`sample_code`!='NORMAL' 
													AND `pimt`.`sample_code` !='QC NORMAL' 
													AND `pimt`.`sample_code`!='LOW' 
													AND `pimt`.`sample_code` !='QC LOW' AND 1
													
													
														";

$sql["partner_details"] = $sql["partner"] = "SELECT `partner`.`ID`,`partner`.`name` AS `des` FROM `partner` ORDER BY `des`";
$sql["county_details"] = $sql["county"] ="SELECT `region`.`id`, `region`.`name` AS `des` FROM `region` ORDER BY `des`";
$sql["subcounty_details"]=$sql["subcounty"]="SELECT `district`.`id`, `district`.`name` AS `des` FROM `district` ORDER BY `des`";
$sql["fac_details"]=$sql["fac"]="SELECT `facility`.`id`, `facility`.`name` AS `des` FROM `facility` ORDER BY `des`";
$sql["user_type"] = $sql["usertype"] = "SELECT `user_group`.`id`,`user_group`.`name` AS `des` FROM `user_group` ORDER BY `des`";
//$sql["user_access_log"] = $sql["userlog"] = "SELECT `user_access_level`.`id` AS `des` FROM `user_access_level` ORDER BY `des`";
//$sql["pima_details"] = $sql["pimadetails"] = "SELECT `facility_pima`.`id`,`facility_pima`.`serial_num` AS `des` FROM `facility_pima` ORDER BY `des`";

$sql["pima_test_details"] = $sql["pima_test"] = 	"SELECT 
															`pim_tst`.`id` AS `pima_test_id`,
															`pim_tst`.`device_test_id`,
															`pim_tst`.`assay_id`,
															`pim_tst`.`sample_code`,
															`pim_tst`.`error_id` AS `pima_error_id`,
															`pim_tst`.`operator`,
															`pim_tst`.`result_date` as `date_test`,
															`pim_tst`.`barcode`,
															`pim_tst`.`expiry_date`,
															`pim_tst`.`volume`,
															`pim_tst`.`device`,
															`pim_tst`.`reagent`,
															`pim_tst`.`software_version`,
															`pim_err`.`error_code`,
															`pim_err`.`error_detail`,
															`pim_err`.`pima_error_type`,
															`err_typ`.`description` AS `error_type_description`,
															`err_typ`.`action`,
															`fps`.`serial_num`,
															`tst_dt`.*
														FROM `pima_test` `pim_tst`
														LEFT JOIN 
															(SELECT 
																	`tst`.`id` AS `cd4_test_id`,
																	`tst`.`cd4_count`,
																	`tst`.`result_date`,
																	`tst`.`valid`,
																	`tst`.`id`,
																	`eq_dt`.*
																FROM `cd4_test`  `tst`
																LEFT JOIN 
																	(SELECT `fac_eq`.`id` AS `facility_equipment_id`,
																		`eq_cat`.`description` AS `equipment_category`,
																		`eq`.`id` AS `equipment_id`,
																		`eq`.`description` AS `equipment`,
																		`fac_eq`.`status` AS `equipment_status`,
																		`fac_eq`.`deactivation_reason` ,															
																		`fac_eq`.`date_added` ,													
																		`fac_eq`.`date_removed` ,
																		`fac`.*
																	FROM `facility_equipment` `fac_eq` 
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
																            ON `fac`.`partnerID`=`par`.`ID`
																			LEFT JOIN `facility_user` `fu`
																			ON `fac`.`id`=`fu`.`facility_id`
																			LEFT JOIN `facility_equipment` `fac_eq`
																			ON `fac`.`id` = `fac_eq`.`facility_id`
																			GROUP BY `facility_id`
																			) AS `fac`
																	ON 	`fac_eq`.`facility_id` = `fac`.`facility_id`
																	LEFT JOIN `equipment` `eq`
																	ON `fac_eq`.`equipment_id`= `eq`.`id`
																		LEFT JOIN `equipment_category` `eq_cat`
																		ON `eq`.`category`= `eq_cat`.`id`
																		) AS `eq_dt`
																ON `tst`.`facility_equipment_id`= `eq_dt`.`facility_equipment_id`	
																) AS `tst_dt`
															ON `pim_tst`.`cd4_test_id`=`tst_dt`.`cd4_test_id`
															LEFT JOIN `pima_error` `pim_err`
															ON 	`pim_tst`.`error_id` = `pim_err`.`id`
																LEFT JOIN `pima_error_type` `err_typ`
																ON `pim_err`.`pima_error_type` = `err_typ`.`id` 
															LEFT JOIN (SELECT `fp`.`serial_num`,`fp`.`facility_equipment_id` FROM `facility_pima` `fp`) as `fps`
																ON `tst_dt`.`facility_equipment_id`=`fps`.`facility_equipment_id`
															WHERE `pim_tst`.`sample_code`!='NORMAL' 
															AND `pim_tst`.`sample_code` !='QC NORMAL' 
															AND `pim_tst`.`sample_code`!='LOW' 
															AND `pim_tst`.`sample_code` !='QC LOW' AND 1												
														";
														
$sql["pima_error_details"] = $sql["pima_error"] = 	"SELECT 
															`pim_tst`.`id` AS `pima_test_id`,
															`pim_tst`.`device_test_id`,
															`pim_tst`.`assay_id`,
															`pim_tst`.`sample_code`,
															`pim_tst`.`error_id` AS `pima_error_id`,
															`pim_tst`.`operator`,
															`pim_tst`.`barcode`,
															`pim_tst`.`expiry_date`,
															`pim_tst`.`volume`,
															`pim_tst`.`device`,
															`pim_tst`.`reagent`,
															`pim_tst`.`software_version`,
															`pim_err`.`error_code`,
															`pim_err`.`error_detail`,
															`pim_err`.`pima_error_type`,
															`err_typ`.`description` AS `error_type_description`,
															`err_typ`.`action`,
															`tst_dt`.*
														FROM `pima_test` `pim_tst`
														LEFT JOIN 
															(SELECT 
																	`tst`.`id` AS `cd4_test_id`,
																	`tst`.`cd4_count`,
																	`tst`.`result_date`,
																	`tst`.`valid`,
																	`tst`.`id`,
																	`eq_dt`.*
																FROM `cd4_test`  `tst`
																LEFT JOIN 
																	(SELECT `fac_eq`.`id` AS `facility_equipment_id`,
																		`eq_cat`.`description` AS `equipment_category`,
																		`eq`.`id` AS `equipment_id`,
																		`eq`.`description` AS `equipment`,
																		`fac_eq`.`status` AS `equipment_status`,
																		`fac_eq`.`deactivation_reason` ,															
																		`fac_eq`.`date_added` ,													
																		`fac_eq`.`date_removed` ,
																		`fac`.*
																	FROM `facility_equipment` `fac_eq` 
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
																            ON `fac`.`partnerID`=`par`.`ID`
																			LEFT JOIN `facility_user` `fu`
																			ON `fac`.`id`=`fu`.`facility_id`
																			LEFT JOIN `facility_equipment` `fac_eq`
																			ON `fac`.`id` = `fac_eq`.`facility_id`
																			GROUP BY `facility_id`
																			) AS `fac`
																	ON 	`fac_eq`.`facility_id` = `fac`.`facility_id`
																	LEFT JOIN `equipment` `eq`
																	ON `fac_eq`.`equipment_id`= `eq`.`id`
																		LEFT JOIN `equipment_category` `eq_cat`
																		ON `eq`.`category`= `eq_cat`.`id`
																		) AS `eq_dt`
																ON `tst`.`facility_equipment_id`= `eq_dt`.`facility_equipment_id`	
																) AS `tst_dt`
															ON `pim_tst`.`cd4_test_id`=`tst_dt`.`cd4_test_id`
															LEFT JOIN `pima_error` `pim_err`
															ON 	`pim_tst`.`error_id` = `pim_err`.`id`
																LEFT JOIN `pima_error_type` `err_typ`
																ON `pim_err`.`pima_error_type` = `err_typ`.`id`
															WHERE `tst_dt`.`valid` = 0 												
														";	
	
$sql["pima_chart_details"] = $sql["chart_tests_details"] ="SELECT 
																MONTH(`tst`.`result_date`) as mth,
																COUNT(`tst`.`valid`) as `data`,
																SUM(CASE WHEN `tst`.`valid`= '1' AND `pima_test`.`error_id`= '0' THEN 1 ELSE 0 END) AS `valid`,
																SUM(CASE WHEN `tst`.`valid`= '0' AND `pima_test`.`error_id`> '0' THEN 1 ELSE 0 END) AS `errors`,
																SUM(CASE WHEN `tst`.`cd4_count` < 500 AND `pima_test`.`error_id`= '0' THEN 1 ELSE 0 END) AS `failed`,
																SUM(CASE WHEN `tst`.`cd4_count` >= 500 AND `pima_test`.`error_id`= '0' THEN 1 ELSE 0 END) AS `passed`
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
																AND  1 
																";
																	
$sql["pima_excel_tests_details"] = $sql["pima_test"] ="SELECT 
															`tst`.`id` as `test_id`, 
															`tst`.`result_date` as `date_test`,						
															`pima_test`.`sample_code`,
															`tst`.`cd4_count`,
															`fp`.`serial_num`,
															CASE WHEN `pima_test`.`error_id`= '0' THEN 1 ELSE 0 END AS `valid`,
															CASE WHEN `pima_test`.`error_id`> 0  THEN 1 ELSE 0 END AS `errors`,
															CASE WHEN `pima_test`.`error_id`= '0'  AND  `tst`.`cd4_count` < 500 THEN 1 ELSE 0 END AS `failed`,
															CASE WHEN `pima_test`.`error_id`= '0'  AND  `tst`.`cd4_count` >= 500 THEN 1 ELSE 0 END AS `passed`,
															`pima_test`.`operator`,
															`pe`.`error_detail`,
															`pet`.`description` as `error_type_description`,
															`f`.`id` as `facility_id`,
															`f`.`name` as `facility`,
															`d`.`id` as `district_id`,
															`d`.`name` as `district`,
															`r`.`id` as `region_id`,
															`r`.`name` as `region`,
															`p`.`ID` as `partner_id`,
															`p`.`name` as `partner`
														FROM `pima_test` 
														LEFT JOIN `cd4_test` `tst` ON `tst`.`id`=`pima_test`.`cd4_test_id`
														LEFT JOIN `pima_upload` `pu` ON `pima_test`.`pima_upload_id`=`pu`.`id`
														LEFT JOIN `facility_pima` `fp` ON `pu`.`facility_pima_id`=`fp`.`id`
														LEFT JOIN `facility_equipment` `fe` ON `fp`.`facility_equipment_id`=`fe`.`id`
														LEFT JOIN `facility` `f` ON `fe`.`facility_id`=`f`.`id`
														LEFT JOIN `district` `d` ON `f`.`district`=`d`.`id`
														LEFT JOIN `region` `r` ON `d`.`region_id`=`r`.`id`
														LEFT JOIN `partner` `p` ON `f`.`partnerID`=`p`.`ID`
														LEFT JOIN `pima_error` `pe` ON `pima_test`.`error_id`=`pe`.`id`
														LEFT JOIN `pima_error_type` `pet` ON `pe`.`pima_error_type`=`pet`.`id`

														WHERE `error_id`>= 0 
														
														AND `pima_test`.`sample_code`!='NORMAL' 
														AND `pima_test`.`sample_code` !='QC NORMAL' 
														AND `pima_test`.`sample_code`!='LOW' 
														AND `pima_test`.`sample_code` !='QC LOW'
														AND  1 ";
$sql["pima_control_test_details"] = $sql["pima_control"] = "SELECT 
																`pima_control`.`id` as `test_id`, 
																`pima_control`.`result_date` as `date_test`,						
																`pima_control`.`sample_code`,
																`fp`.`serial_num`,
																CASE WHEN `pima_control`.`error_id`= '0' THEN 1 ELSE 0 END AS `valid`,
																CASE WHEN `pima_control`.`error_id`> 0  THEN 1 ELSE 0 END AS `errors`,

																`pima_control`.`operator`,
																`pe`.`error_detail`,
																`pet`.`description` as `error_type_description`,
																`f`.`id` as `facility_id`,
																`f`.`name` as `facility`,
																`d`.`id` as `district_id`,
																`d`.`name` as `district`,
																`r`.`id` as `region_id`,
																`r`.`name` as `region`,
																`p`.`ID` as `partner_id`,
																`p`.`name` as `partner`
																FROM `pima_control` 

																LEFT JOIN `pima_upload` `pu` ON `pima_control`.`pima_upload_id`=`pu`.`id`
																LEFT JOIN `facility_pima` `fp` ON `pu`.`facility_pima_id`=`fp`.`id`
																LEFT JOIN `facility_equipment` `fe` ON `fp`.`facility_equipment_id`=`fe`.`id`
																LEFT JOIN `facility` `f` ON `fe`.`facility_id`=`f`.`id`
																LEFT JOIN `district` `d` ON `f`.`district`=`d`.`id`
																LEFT JOIN `region` `r` ON `d`.`region_id`=`r`.`id`
																LEFT JOIN `partner` `p` ON `f`.`partnerID`=`p`.`ID`
																LEFT JOIN `pima_error` `pe` ON `pima_control`.`error_id`=`pe`.`id`
																LEFT JOIN `pima_error_type` `pet` ON `pe`.`pima_error_type`=`pet`.`id`

																WHERE `pima_control`.`error_id`>= 0 
																AND 1";

$sql["pima_control_count_details"] = $sql["pima_control"] = "SELECT 
															CONCAT(YEAR(`pima_control`.`result_date`),'-',MONTH(`pima_control`.`result_date`)) AS `yearmonth`,
															`pima_control`.`result_date`,				
															COUNT(`pima_control`.`sample_code`) as `total_tests`,
															`fp`.`serial_num`,
															CASE WHEN `pima_control`.`error_id`= '0' THEN 1 ELSE 0 END AS `valid`,
															CASE WHEN `pima_control`.`error_id`> 0  THEN 1 ELSE 0 END AS `errors`,														
															`f`.`id` as `facility_id`,
															`f`.`name` as `facility`,
															`d`.`id` as `district_id`,
															`d`.`name` as `district`,
															`r`.`id` as `region_id`,
															`r`.`name` as `region`,
															`p`.`ID` as `partner_id`,
															`p`.`name` as `partner`
														FROM `pima_control` 
														LEFT JOIN `pima_upload` `pu` ON `pima_control`.`pima_upload_id`=`pu`.`id`
														LEFT JOIN `facility_pima` `fp` ON `pu`.`facility_pima_id`=`fp`.`id`
														LEFT JOIN `facility_equipment` `fe` ON `fp`.`facility_equipment_id`=`fe`.`id`
														LEFT JOIN `facility` `f` ON `fe`.`facility_id`=`f`.`id`
														LEFT JOIN `district` `d` ON `f`.`district`=`d`.`id`
														LEFT JOIN `region` `r` ON `d`.`region_id`=`r`.`id`
														LEFT JOIN `partner` `p` ON `f`.`partnerID`=`p`.`ID`
														LEFT JOIN `pima_error` `pe` ON `pima_control`.`error_id`=`pe`.`id`
														LEFT JOIN `pima_error_type` `pet` ON `pe`.`pima_error_type`=`pet`.`id`

														WHERE `pima_control`.`error_id`>= 0 
														AND 1 ";
																	
																	
																	
$config["preset_sql"] =$sql;

/* End of file sql.php */
/* Location: ./application/config/sql.php */