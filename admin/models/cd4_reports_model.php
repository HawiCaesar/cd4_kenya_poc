<?php 
class cd4_reports_model extends MY_Model{

	function cd4_reporting($fromdate,$todate)
	{
		$sql="SELECT cd4.facility.name as cd4_name, cd4.fcdrrlists.pimatests FROM cd4.facility
					LEFT JOIN cd4.fcdrrlists ON cd4.facility.MFLCode=cd4.fcdrrlists.mflcode
					WHERE cd4.fcdrrlists.fromdate BETWEEN '".$fromdate."' AND '".$todate."' AND cd4.fcdrrlists.todate 
												  BETWEEN '".$fromdate."' AND '".$todate."'
					GROUP BY cd4.fcdrrlists.mflcode ORDER BY cd4.facility.name ASC";
		// $sql="SELECT cd4.facility.name as cd4_name, cd4.pimatests FROM cd4.facility
		// 			LEFT JOIN (SELECT cd4.fcdrrlists.fcdrrlistID, cd4.fcdrrlists.pimatests FROM cd4.fcdrrlists 
		// 			WHERE cd4.fcdrrlists.fromdate BETWEEN '".$fromdate."' AND '".$todate."' AND cd4.fcdrrlists.todate 
		// 										  BETWEEN '".$fromdate."' AND '".$todate."' ) as cd4 ON 
		// 			cd4.facility.MFLCode=cd4.cd4.mflcode GROUP BY cd4.facility.AutoID ORDER BY cd4.facility.name ASC ";
		//print_r($sql);die;

		$cd4_results=R::getAll($sql);

		return $cd4_results;
	}

	function cd4poc_reporting($fromdate,$todate)
	{
		$sql="SELECT vfp.facility_name as poc_name, cd4t.id as cd4_test_id from v_facility_pima_details vfp
					LEFT JOIN (SELECT cd4.id,cd4.facility_id
								FROM cd4_test cd4 
								WHERE `cd4`.`result_date` BETWEEN '".$fromdate."' AND '".$todate."' ) 
					as `cd4t` ON vfp.facility_id=`cd4t`.facility_id
					GROUP BY vfp.facility_name ";	

		$cd4poc_results=R::getAll($sql);

		// print_r($sql);
		// die;
		return $cd4poc_results;
	}
	function facility_list()
	{
		$sql="SELECT * from cd4.facility where rolloutstatus='1' order by name ASC ";

		$facility_results=R::getAll($sql);

		return $facility_results;
	}
	function poc_facility_list()
	{
		$sql="SELECT facility_name from v_facility_pima_details order by facility_name ASC ";

		$poc_facility_results=R::getAll($sql);

		return $poc_facility_results;
	}



}//edn of cd4_reports_model.php
?>