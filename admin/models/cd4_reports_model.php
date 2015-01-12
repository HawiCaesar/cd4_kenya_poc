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
	function excel_file_download($fromdate,$todate)
	{
		$facility_list=$this->facility_list();

		$poc_facility_list=$this->poc_facility_list();

		$cd4_reporting_results=$this->cd4_reporting($fromdate,$todate);

		$cd4_poc_results=$this->cd4poc_reporting($fromdate,$todate);

		foreach($facility_list as $facility_result) //loop through all facilites and set search key
		{
			$searchkey_array[$facility_result['name']]=$facility_result['name'];
		}

		foreach($poc_facility_list as $poc_details) // loop through cd4poc facilities and set search key
		{
			$searchkey_array_poc[$poc_details['facility_name']]=$poc_details['facility_name'];
		}

		//set new arrays
		$poc_results=array();
		$cd4_fcdrr_results=array();

		// if(!$cd4_results==0)// check if fcdrr is null
		// {
			foreach($cd4_reporting_results as $key => $cd4)
			{
				if(array_key_exists($cd4['cd4_name'], $searchkey_array))
				{
					$cd4_fcdrr_results[$cd4['cd4_name']]=$cd4['cd4_name'];
				}
				else
				{
					$cd4_fcdrr_results[$cd4['cd4_name']]="-";
				}
			}

			foreach($cd4_poc_results as $key => $cd4poc)
			{
				if($cd4poc['poc_name'] && $cd4poc['cd4_test_id']==NULL)
				{
					$poc_results[$cd4poc['poc_name']]="--";
				}
				else if($cd4poc['cd4_test_id'])
				{
					$poc_results[$cd4poc['poc_name']]=$cd4poc['poc_name'];
				}
			}

			$this->load->library('excel');

			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('CD4 Reporting');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','CD4 Reporting '.date('jS F Y',strtotime($fromdate)).' - '.date('jS F Y',strtotime($todate)).' ' );

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Facility');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:I3');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','FCDRR');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','PIMA');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J3','Reported');
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J3:K3');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L3','Results Uploaded');
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L3:M3');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


					$num=4;
					$count=1;
					foreach($facility_list as $facility_result){

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A'.$num.'',$count);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A'.$num.'')->getFont()->setSize(12);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B'.$num.'',$facility_result['name']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B'.$num.':I'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
					
					if(array_key_exists($facility_result['name'],$cd4_fcdrr_results)){ 

							$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Yes');
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
							$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}else{ 
							$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','No');
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
							$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
							$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');
					}

						if(array_key_exists($facility_result['name'],$poc_results))
						{ 
							if($poc_results[$facility_result['name']]=="--")
							{
								$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'','No');
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
								$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

							}else{
								$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'','Yes');
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
								$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFill()->getStartColor()->setRGB('006600');
							}

						}else { $PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'','N / A');
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
								$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
								$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						} 
					$num++;$count++; 
				}//end foreach

	}



}//edn of cd4_reports_model.php
?>