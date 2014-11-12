<?php

/*Pima errors****************************************************************** */
DROP PROCEDURE IF EXISTS `periodic_facility_pima_errors`;
DELIMITER $$

CREATE PROCEDURE `periodic_facility_pima_errors`(fromdate date,enddate date,user_delimiter varchar(255))
BEGIN
SELECT 
`pima_error`.`error_code`, 
`pima_error`.`error_detail`, 
COUNT(`pima_test`.`error_id`) as `total` 
FROM `pima_error` 
LEFT JOIN `pima_test` 
ON `pima_test`.`error_id`=`pima_error`.`id`
AND `pima_test`.`sample_code`!='NORMAL' 
AND `pima_test`.`sample_code` !='QC NORMAL' 
AND `pima_test`.`sample_code`!='LOW' 
AND `pima_test`.`sample_code` !='QC LOW'
AND  1 	
LEFT JOIN `cd4_test` ON `pima_test`.`cd4_test_id`=`cd4_test`.`id` 
WHERE `cd4_test`.`result_date` between fromdate and enddate 
AND user_delimiter 
GROUP BY `error_code`;
END;

/* Test error percentage************************************************************ */
DROP PROCEDURE IF EXISTS `periodic_test_error_perc`;

DELIMITER $$
CREATE PROCEDURE `periodic_test_error_perc`(fromdate date,enddate date)
BEGIN
SELECT `test`.`total` AS `test_total`,`error`.`total` AS `error_total`
FROM (SELECT count(*) AS `total` 
FROM `pima_test` RIGHT JOIN `cd4_test` ON `pima_test`.`cd4_test_id`=`cd4_test`.`id`
WHERE `error_id` = 0 
AND `pima_test`.`sample_code` !='NORMAL' 
AND `pima_test`.`sample_code` !='QC NORMAL' 
AND `pima_test`.`sample_code` !='LOW' 
AND `pima_test`.`sample_code` !='QC LOW' 
AND `cd4_test`.`result_date` BETWEEN fromdate AND enddate ) AS `test`,(SELECT count(*) AS `total`
FROM `pima_test` RIGHT JOIN `cd4_test` ON `pima_test`.`cd4_test_id`=`cd4_test`.`id` 
WHERE `error_id` > 0 
AND `pima_test`.`sample_code`!='NORMAL' 
AND `pima_test`.`sample_code` !='QC NORMAL' 
AND `pima_test`.`sample_code`!='LOW' 
AND `pima_test`.`sample_code` !='QC LOW' 
AND 1 AND `cd4_test`.`result_date` BETWEEN fromdate AND enddate ) AS `error`;
	END;

/* Yearly pima error trend**************************************************************** */
DROP PROCEDURE IF EXISTS `yearly_pima_errors_trend`;
DELIMITER $$

CREATE PROCEDURE `yearly_pima_errors_trend`(from_month int(2),end_month int(2),from_year int(4),end_year int(4),user_delimiter varchar(50))
BEGIN
SELECT 
CONCAT(YEAR(`cd4_test`.`result_date`),'-',MONTH(`cd4_test`.`result_date`)) AS `yearmonth`, 
`cd4_test`.`result_date`, 
MONTH(`cd4_test`.`result_date`) AS `month`, 
COUNT(*) AS `errors` 
FROM `pima_test` 
LEFT JOIN `cd4_test`
ON `pima_test`.`cd4_test_id`=`cd4_test`.`id` 
WHERE `error_id`> 0 
AND MONTH(`cd4_test`.`result_date`) BETWEEN from_month AND end_month AND YEAR(`cd4_test`.`result_date`) BETWEEN from_year AND end_year
AND `pima_test`.`sample_code`!='NORMAL' 
AND `pima_test`.`sample_code` !='QC NORMAL' 
AND `pima_test`.`sample_code`!='LOW' 
AND `pima_test`.`sample_code` !='QC LOW'
AND  1 
AND user_delimiter
GROUP BY `yearmonth`
ORDER BY MONTH(`cd4_test`.`result_date`);
END;
/* Yearly pima test trend************************************************************** */
DROP PROCEDURE IF EXISTS `yearly_pima_result_trend`;
DELIMITER $$

CREATE PROCEDURE `yearly_pima_result_trend`(from_month int(2),end_month int(2),from_year int(4),end_year int(4),user_delimiter varchar(50))
BEGIN
SELECT 
CONCAT(YEAR(`cd4_test`.`result_date`),'-',MONTH(`cd4_test`.`result_date`)) AS `yearmonth`, 
`cd4_test`.`result_date`, 
MONTH(`cd4_test`.`result_date`) AS `month`, 
COUNT(*) AS `reported` 
FROM `pima_test` 
RIGHT JOIN `cd4_test`
ON `pima_test`.`cd4_test_id`=`cd4_test`.`id`
WHERE `error_id`= 0 
AND MONTH(`cd4_test`.`result_date`) BETWEEN from_month AND end_month AND YEAR(`cd4_test`.`result_date`) BETWEEN from_year AND end_year
AND `pima_test`.`sample_code`!='NORMAL' 
AND `pima_test`.`sample_code` !='QC NORMAL' 
AND `pima_test`.`sample_code`!='LOW' 
AND `pima_test`.`sample_code` !='QC LOW'
AND  1
AND user_delimiter 
GROUP BY `yearmonth`
ORDER BY MONTH(`cd4_test`.`result_date`);
END;
/********************* county devices *********************/
DROP PROCEDURE IF EXISTS `county_devices`;
DELIMITER $$

CREATE PROCEDURE `county_devices`(fromdate date,enddate date)
BEGIN
SELECT
vfp.region_id, 
vfp.region_name,
COUNT(DISTINCT(vfp.facility_pima_serial_num)) as number_of_devices,
COUNT(DISTINCT(cd4t.facility_equipment_id)) as reported_devices,
(COUNT(DISTINCT(vfp.facility_pima_serial_num))-COUNT(DISTINCT(cd4t.facility_id))) as not_reported,
(COUNT(DISTINCT(cd4t.facility_id))/COUNT(DISTINCT(vfp.facility_pima_serial_num))*100) as percentage_reported,
(100-COUNT(DISTINCT(cd4t.facility_id))/COUNT(DISTINCT(vfp.facility_pima_serial_num))*100) as percentage_not
from v_facility_pima_details vfp
LEFT JOIN (SELECT * FROM cd4_test cd4 WHERE `cd4`.`result_date` BETWEEN fromdate AND enddate ) 
as `cd4t` ON vfp.facility_id=`cd4t`.facility_id
WHERE vfp.facility_equipment_status='Functional'
GROUP BY vfp.region_id;
END;
/******************** summary reporting ***************************/

DROP PROCEDURE IF EXISTS `summary_reporting`;
DELIMITER $$
CREATE PROCEDURE `summary_reporting`(fromdate date,enddate date)
BEGIN
SELECT 
COUNT(DISTINCT(vfp.facility_pima_serial_num)) as number_of_devices,
COUNT(DISTINCT(cd4t.facility_equipment_id)) as reported_devices,
(COUNT(DISTINCT(vfp.facility_pima_serial_num))-COUNT(DISTINCT(cd4t.facility_id))) as not_reported,
(COUNT(DISTINCT(cd4t.facility_id))/COUNT(DISTINCT(vfp.facility_pima_serial_num))*100) as percentage_reported,
(100-COUNT(DISTINCT(cd4t.facility_id))/COUNT(DISTINCT(vfp.facility_pima_serial_num))*100) as percentage_not
from v_facility_pima_details vfp
LEFT JOIN (SELECT * FROM cd4_test cd4 WHERE `cd4`.`result_date` BETWEEN fromdate AND enddate ) 
as `cd4t` ON vfp.facility_id=`cd4t`.facility_id
WHERE vfp.facility_equipment_status='Functional';
END;
/**************** detialed reporting *****************************/

DROP PROCEDURE IF EXISTS `detailed_reporting`;
DELIMITER $$
CREATE PROCEDURE `detailed_reporting`(from_month int(2),end_month int(2),from_year int(4),end_year int(4))
BEGIN
SELECT region_id,
region,COUNT(test_id) AS total_tests,
SUM(CASE WHEN valid= '1'  THEN 1 ELSE 0 END) AS valid,
SUM(CASE WHEN valid= '0'  THEN 1 ELSE 0 END) AS `errors`,
SUM(CASE WHEN valid= '1'  AND  cd4_count < 500 THEN 1 ELSE 0 END) AS failed,
SUM(CASE WHEN valid= '1'  AND  cd4_count >= 500 THEN 1 ELSE 0 END) AS passed 
from v_pima_tests_only where  MONTH(date_test) BETWEEN from_month AND end_month AND YEAR(date_test) BETWEEN from_year AND end_year
GROUP BY region_id
ORDER BY region;
END;

/************** Devices not reporting *****************************/
DROP PROCEDURE IF EXISTS `devices_not_repoting`;
DELIMITER $$
CREATE PROCEDURE `devices_not_repoting`(fromdate date,enddate date)
BEGIN
SELECT COUNT(cd4.id) as total_tests,
vfp.facility_id,vfp.facility_name,
vfp.facility_pima_serial_num,
vfp.region_name
from v_facility_pima_details vfp
LEFT JOIN (SELECT * FROM cd4_test where result_date BETWEEN fromdate AND enddate ) as cd4 ON vfp.facility_id=cd4.facility_id
LEFT JOIN facility_equipment fe ON cd4.facility_equipment_id=fe.id
LEFT JOIN facility_pima fp ON fe.id=fp.facility_equipment_id
GROUP BY vfp.facility_equipment_id;
END;
