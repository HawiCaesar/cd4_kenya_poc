<?php 
class cd4_reports_model extends MY_Model{

	function get_facility_details($facility)
	{
		$tests_results="";

		/*
			load the preset sql
			specifically the pima_uploads_details
		*/

		$this->config->load('sql'); 

		$sql= $this->config->item("preset_sql");

		$tests_sql= $sql["pima_uploads_details"];

		$facility_delimiter = "";
		$date_delimiter = "";

		$facility_delimiter= "AND `upl_summary`.`facility`='".$facility."' ";

		$tests_results=R::getAll($tests_sql.$facility_delimiter.$date_delimiter);

		// echo $tests_sql.$facility_delimiter.$date_delimiter;
		// die;

		return $tests_results;

	}

	function get_excel_pima_details($facility_name,$from,$end,$month,$year)
	{
		//load preset sql
		$this->load->config("sql");

		$sql = $this->config->item('preset_sql');

		$tests_sql= $sql["pima_test_details"];

		//limit by the facility
		$criteria =" AND `facility`='".$facility_name."'";

		//date limit per month
		$date_delimiter	=	" AND `pim_tst`.`result_date` between '".$from."' and '".$end."' "; 

		$month_name=$this->GetMonthName($month);//get the month name

		$this->load->library('excel');//load excel library

		//place report title and column headings

		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility_name.' - '.$month_name.', '.$year.' ' );
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Date Of Test');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:I2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Successful Tests');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Errors');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','CD4 Count');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Detail');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:T2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U2','Error Type');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U2:V2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$test_details=R::getAll($tests_sql.$criteria.$date_delimiter);//concatenate limits and execute sql
		
		$num=3;//row number
		$count=1;//record count

			foreach ($test_details as $value) 
		 	{
		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A'.$num.'',$count);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A'.$num.'')->getFont()->setSize(12);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S1',$count);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S1')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B'.$num.'',$value['sample_code']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B'.$num.':C'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['serial_num']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':F'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['result_date']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				if($value['valid']==1)//tests only
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Valid');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('006600');
				}
				else if($value['valid']==0)//Errors only
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'','Invalid');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':T'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				
		 		$num++;$count++;
			}//foreach end


		return $PHPExcel;
	}



}//edn of cd4_reports_model.php
?>