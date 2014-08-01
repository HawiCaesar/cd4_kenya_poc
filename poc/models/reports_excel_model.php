<?php

class reports_excel_model extends MY_Model{

	/*=================== Excel: Month ===================================================*/

	function excel_year_month($YearM,$monthly,$facility,$device,$from_month,$end_month,$report_type)
	{
		$this->load->library('excel');

		$Month=$this->GetMonthName($monthly);

		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		if($facility!="")
		{	
			$device="";
			$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);
			
			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$Month.', '.$YearM.' ' );

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

			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S2:T2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{

					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S'.$num.':T'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
	 	}

	 	if($device!="")
	 	{
	 		$facility="";
	 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);// get the data

			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$Month.','.$YearM.'');

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:G2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H2','Date Of Test');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H2:J2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:U2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':G'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H'.$num.':J'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{

					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':U'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
	 	}

	return $PHPExcel;
	}
	/*=================== Excel: Month End ================================================================================================*/

	/*=================== Excel: Quarterly ================================================================================================*/

	function excel_year_quarter_report($yearQ,$quarter,$facility,$device,$from_month,$end_month,$report_type)
	{
		$this->load->library('excel');

		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if($facility!="")
		{	
			$device="";
			$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$quarter.','.$yearQ.' ');

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

			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S2:T2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{

					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S'.$num.':T'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
		}

		if($device!="")
		{
			$facility="";
			$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);// get the data

			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$quarter.','.$yearQ.'');

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:G2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H2','Date Of Test');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H2:J2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			
			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:U2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':G'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H'.$num.':J'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{

					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':U'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
		}

	return $PHPExcel;
	}
	/*=================== Excel: Quarterly End ===========================================*/

	/*=================== Excel: Biannual ===============================================*/

	function excel_year_biannual_report($yearB,$biannual_name,$facility,$device,$from_month,$end_month,$report_type)
	{
		$this->load->library('excel');
		//$this->load->model('reports_model');

		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if($facility!="")
		{
			$device="";
			$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);
			
			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$biannual_name.','.$yearB.'');

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

			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S2:T2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{

					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S'.$num.':T'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
		}

		if($device!="")
		{
			$facility="";
			$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);// get the data

			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$biannual_name.','.$yearB.'');

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:G2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H2','Date Of Test');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H2:J2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			
			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:U2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':G'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H'.$num.':J'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':U'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
		}

	return $PHPExcel;
	}
	 /*=================== Excel: Biannual End ===========================================*/

	 /*=================== Excel: Yearly  ==============================================*/

	 function excel_year_report($YearO,$facility,$device,$from_month,$end_month,$report_type)
	 {
	 	$this->load->library('excel');
	 	//$this->load->model('reports_model');

	 	$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	 	if($facility!="")
	 	{	
	 		$device="";
	 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

	 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$YearO.' ');

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

			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S2:T2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{

					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S'.$num.':T'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
	 	}

	 	if($device!="")
	 	{
	 		$facility="";
	 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);// get the data

	 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$YearO.'');

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:G2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H2','Date Of Test');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H2:J2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			
			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:U2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':G'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H'.$num.':J'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':U'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
	 	}

		return $PHPExcel;
	 
	 }
	 /*=================== Excel: Yearly End  =========================================================================================*/

	 /*=================== Excel: Customized Dates  ===================================================================================*/

	 function excel_customized_dates_report($Fromdate,$Todate,$facility,$device,$report_type)
	 {
	 	$this->load->library('excel');
	 	//$this->load->model('reports_model');

	 	$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	 	if($facility!="")
	 	{
	 		$device="";
	 		$sql_data=$this->excel_tests_details($Fromdate,$Todate,$facility,$device,$report_type);// get the data

			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - Between '.$Fromdate.' and '.$Todate.'');
			
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

			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:R2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S2:T2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{

					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':R'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('S'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('S'.$num.':T'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('S'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
	 	}

	 	if($device!="")
	 	{
	 		$facility="";
	 		$sql_data=$this->excel_tests_details($Fromdate,$Todate,$facility,$device,$report_type);// get the data

			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - Between '.$Fromdate.' and '.$Todate.' ');
			
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:G2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H2','Date Of Test');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H2:J2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			
			if($report_type==1)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else if($report_type==2)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Test Status');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:L2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M2','CD4 Count');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M2:N2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O2:P2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q2','Error Detail');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q2:S2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Type');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:U2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}


			$num=3;$count=1;

			foreach ($sql_data as $value) 
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

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':G'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('H'.$num.'',$value['date_test']);
		 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('H'.$num.':J'.$num.'');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('H'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						
				if($report_type==1)
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					}
				}
				else if($report_type==2)
				{
					if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
				}

				else
				{
					if($value['valid']==1)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Successful');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('006600');
					}
					else if($value['valid']==0)
					{
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'','Error');
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':L'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q'.$num.'',$value['error_detail']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q'.$num.':S'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_type_description']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':U'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
					}
						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('M'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('M'.$num.':N'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('M'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('O'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('O'.$num.':P'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('O'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
				}

		 		$num++;$count++;
			}//foreach end
	 	}

	 	
	 return $PHPExcel;
	 }

	 /*=================== Excel: Customized Dates End ======================================================================*/

	 /*=================== Excel: All Data, By County, By Partner function - By Month =======================================*/

	 function excel_year_month_all($YearM,$monthly,$all,$from_month,$end_month,$report_type,$login_id)
	 {
	 	$this->load->library('excel');//load excel library
	 	$this->load->model('reports_model');
	 	$Month=$this->reports_model->GetMonthName($monthly);// get the month name

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

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	 	if($all==3 || $all==4 || $all==5)//by partner, by county,all data
	 	{
	
			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

			if($all==3)
			{
				$user_filter = $this->session -> userdata("user_filter");

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$Month.', '.$YearM.' ' );
			}
			else if($all==4)
			{
				$county_name=$this->reports_model->get_county_name($login_id); //get the county name
			
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County - '.$Month.', '.$YearM.' ' );
			}
			else if($all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$Month.', '.$YearM.' ' );
			}
			
		}

		if($report_type==1)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if($report_type==2)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:T2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W2:X2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);
		
		$num=3;$count=1;

		foreach ($sql_data as $value) 
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

	 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					
			if($report_type==1)
			{
				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				}
			}
			else if($report_type==2)
			{
				if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':T'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
			}

			else
			{

				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('006600');
				}
				else if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W'.$num.':X'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


				}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}

	 		$num++;$count++;
	 	}//end foreach
	 	
 	 return $PHPExcel;
	 }
	 /*=================== Excel: All Data,By County, By Partner function - By Month End ====================================*/

	 /*=================== Excel: All Data,By County, By Parnter function - By Quarter ======================================*/

	 function excel_year_quarter_all($yearQ,$quarter,$all,$from_month,$end_month,$report_type,$login_id)
	 {
	 	$this->load->library('excel');//load excel library
	 	$this->load->model('reports_model');

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

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	 	if($all==3 || $all==4 || $all==5)//Get all data, or by  partner
	 	{
	 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

	 		if($all==3)
	 		{
	 			$user_filter = $this->session -> userdata("user_filter");

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$quarter.', '.$yearQ.' ' );
	 		}
	 		else if($all==4)
	 		{
	 			$county_name=$this->reports_model->get_county_name($login_id); //get the county name

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County - '.$quarter.', '.$yearQ.' ' );
	 		}
	 		else if($all==5)
	 		{
	 			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$quarter.', '.$yearQ.' ' );
	 		}
	 	}
		if($report_type==1)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if($report_type==2)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:T2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W2:X2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);

		$num=3;$count=1;

		foreach ($sql_data as $value) 
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

	 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					
			if($report_type==1)
			{
				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				}
			}
			else if($report_type==2)
			{
				if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':T'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
			}

			else
			{

				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('006600');
				}
				else if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W'.$num.':X'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


				}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}

	 		$num++;$count++;
	 	}//end foreach
	 		 	
 	 return $PHPExcel;
	 }

	 /*=================== Excel: All Data,By County, By Parnter function - By Quarter End ==================================*/

	 /*=================== Excel: All Data,By County, By Parnter function - By Biannual =====================================*/

	 function excel_year_biannual_all($yearB,$bian,$all,$from_month,$end_month,$report_type,$login_id)
	 {
	 	$this->load->library('excel');//load excel library
	 	$this->load->model('reports_model');

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

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	 	if($all==3 || $all==4 || $all==5)//Get all data, by Parnter
	 	{
	 		
			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

			if($all==3)
			{
				$user_filter = $this->session -> userdata("user_filter");

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$bian.', '.$yearB.' ' );
			}
			else if($all==4)
			{
				$county_name=$this->reports_model->get_county_name($login_id); //get the county name

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County - '.$bian.', '.$yearB.' ' );
			}
			else if($all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$bian.', '.$yearB.' ' );
			}
			
		}
		if($report_type==1)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if($report_type==2)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:T2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W2:X2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);

		$num=3;$count=1;

		foreach ($sql_data as $value) 
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

	 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					
			if($report_type==1)
			{
				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				}
			}
			else if($report_type==2)
			{
				if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':T'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
			}

			else
			{

				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('006600');
				}
				else if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W'.$num.':X'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


				}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}

	 		$num++;$count++;
	 	}//end foreach
	 	
	 	
 	 return $PHPExcel;
	 }

	 /*=================== Excel: All Data,By County, By Partner function - By Biannual End =================================*/
	 
	 /*=================== Excel: All Data,By County, By Partner function - By Yearly =======================================*/

	 function excel_yearly_all($year,$all,$from_month,$end_month,$report_type,$login_id)
	 {
	 	$this->load->library('excel');//load excel library
	 	$this->load->model('reports_model');

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

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	 	if($all==3 || $all==4 || $all==5)//Get by partner, by county, all data
	 	{
	 		
			$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

			if($all==3)
			{
				$user_filter = $this->session -> userdata("user_filter");

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$year.' ' );
			}
			else if($all==4)
			{
				$county_name=$this->reports_model->get_county_name($login_id); //get the county name

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County - '.$year.' ' );
			}
			else if($all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$year.' ' );
			}
			
		}
		if($report_type==1)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if($report_type==2)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:T2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W2:X2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);

		$num=3;$count=1;

		foreach ($sql_data as $value) 
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

	 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					
			if($report_type==1)
			{
				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				}
			}
			else if($report_type==2)
			{
				if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':T'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
			}

			else
			{

				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('006600');
				}
				else if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W'.$num.':X'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


				}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}

	 		$num++;$count++;
	 	}//end foreach
 	
	 	
 	 return $PHPExcel;
	 }

	 /*=================== Excel: All Data,By County, By Partner function - By Yearly End ==================================*/
	 
	 /*=================== Excel: All Data,By County, By Partner function - Customized Dates ===============================*/

	 function excel_customized_dates_all($from_month,$end_month,$all,$report_type,$login_id)
	 {
	 	$this->load->library('excel');//load excel library
	 	$this->load->model('reports_model');

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

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
		$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
	 	if($all==3 || $all==4 || $all==5)//Get all data or by parnter
	 	{
	 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

	 		if($all==3)
	 		{
	 			$user_filter = $this->session -> userdata("user_filter");

				foreach($user_filter as $filter)
				{
					$pfilter=$filter['user_filter_name'];
				}
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - Between '.$from_month.' and '.$end_month.' ' );
	 		}
	 		else if($all==4)
	 		{
	 			$county_name=$this->reports_model->get_county_name($login_id); //get the county name
	 		
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County - Between '.$from_month.' and '.$end_month.' ' );
	 		}
	 		else if($all==5)
	 		{
	 			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - Between '.$from_month.' and '.$end_month.' ' );
	 		}
	
	 	}
		if($report_type==1)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if($report_type==2)
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:T2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else
		{
			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','Test Status');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','CD4 Count');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R2','Operator');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R2:S2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T2','Error Details');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T2:V2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W2','Error Type');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W2:X2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);

		$num=3;$count=1;

		foreach ($sql_data as $value) 
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

	 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
	 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					
			if($report_type==1)
			{
				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				}
			}
			else if($report_type==2)
			{
				if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':T'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('U'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('U'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('U'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
			}

			else
			{

				if($value['valid']==1)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Successful');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('006600');
				}
				else if($value['valid']==0)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'','Error');
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//set color
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFill()->getStartColor()->setRGB('FF0000');

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('T'.$num.'',$value['error_detail']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('T'.$num.':V'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('T'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('W'.$num.'',$value['error_type_description']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('W'.$num.':X'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('W'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


				}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['cd4_count']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('R'.$num.'',$value['operator']);
			 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getFont()->setSize(12);
					$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('R'.$num.':S'.$num.'');
					$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('R'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}

	 		$num++;$count++;
	 	}//end foreach
	 	
 	 return $PHPExcel;
	 }

 	/*=================== Excel: Less than 350 - By Month =======================================*/

	function excel_tests_lessthan350_month($YearM,$monthly,$facility,$device,$from_month,$end_month,$report_type,$all,$login_id)
	{
		 	$this->load->library('excel');
			$this->load->model('reports_model');
			$sql_data="";
			$Month=$this->reports_model->GetMonthName($monthly);
		
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if($all==3 || $all==4 || $all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','CD4 Count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:I2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','CD4 count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

			if($facility!="")
			{	
				$device="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$Month.', '.$YearM.' ' );

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$num++;$count++;
		 		}
		 	}

		 	if($device!="")
		 	{
		 		$facility="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$Month.', '.$YearM.' ' );
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':F'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$num++;$count++;
		 		}
		 	}
		 	if($all==3 || $all==4 || $all==5)
		 	{
		 		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

		 		if($all==3)
		 		{
		 			$user_filter = $this->session -> userdata("user_filter");

					foreach($user_filter as $filter)
					{
						$pfilter=$filter['user_filter_name'];
					}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$Month.', '.$YearM.' ' );
		 		}
		 		else if($all==4)
		 		{
		 			$county_name=$this->reports_model->get_county_name($login_id); //get the county name

		 			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County  - '.$Month.', '.$YearM.' ' );
		 		}
		 		else if($all==5)
		 		{
		 			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$Month.', '.$YearM.' ' );
		 		}

				$num=3;$count=1;
			 		foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 			
			 			$num++;$count++;
			 		}
		 	}

	 	return $PHPExcel;
	}
	/*=================== Excel: End Less than 350 - By Month =======================================*/
	/*=================== Excel: Less than 350 - By Quarter =========================================*/

 	function excel_tests_lessthan350_quarter($yearQ,$quarter,$facility,$device,$from_month,$end_month,$report_type,$all,$login_id)
	{
		 	$this->load->library('excel');
			$this->load->model('reports_model');
			$sql_data="";
			
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if($all==3 || $all==4 || $all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','CD4 Count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:I2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','CD4 count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

			if($facility!="")
			{	
				$device="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$quarter.', '.$yearQ.' ' );

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$num++;$count++;
		 		}
		 	}

		 	if($device!="")
		 	{
		 		$facility="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$quarter.', '.$yearQ.' ' );
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':F'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$num++;$count++;
		 		}
		 	}
		 	if($all==3 || $all==4 || $all==5)
		 	{
		 		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

				if($all==3)
				{
					$user_filter=$this->session->userdata('user_filter');

					foreach($user_filter as $filter)
					{
						$pfilter=$filter['user_filter_name'];
					}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$quarter.', '.$yearQ.' ' );
				}
				else if($all==4)
				{
					$county_name=$this->reports_model->get_county_name($login_id); //get the county name

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County  - '.$quarter.', '.$yearQ.' ' );
				}
				else if($all==5)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$quarter.', '.$yearQ.' ' );
				}

				$num=3;$count=1;
			 		foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 			
			 			$num++;$count++;
			 	}
		 	}
		 	
		 return $PHPExcel;
		}
		/*=================== Excel: Less than 350 - By Quarter End =========================================*/

		/*=================== Excel: Less than 350 - By Biannual ============================================*/

		function excel_tests_lessthan350_bian($yearB,$biannual_name,$facility,$device,$from_month,$end_month,$report_type,$all,$login_id)
		 {
		 	$this->load->library('excel');
			$this->load->model('reports_model');
			$sql_data="";
			
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if($all==3 || $all==4 || $all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','CD4 Count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:I2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','CD4 count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
				

			if($facility!="")
			{	
				$device="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$biannual_name.','.$yearB.' ' );

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$num++;$count++;
		 		}
		 	}

		 	if($device!="")
		 	{
		 		$facility="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$biannual_name.','.$yearB.' ' );
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':F'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$num++;$count++;
		 		}
		 	}

		 	if($all==3 || $all==4 || $all==5)
		 	{
		 		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

				if($all==3)
				{
					$user_filter=$this->session->userdata('user_filter');

					foreach($user_filter as $filter)
					{
						$pfilter=$filter['user_filter_name'];
					}

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$biannual_name.','.$yearB.' ' );
				}
				else if($all==4)
				{
					$county_name=$this->reports_model->get_county_name($login_id); //get the county name

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County  - '.$biannual_name.','.$yearB.' ' );
				}
				else if($all==5)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$biannual_name.','.$yearB.' ' );
				}

		 		$num=3;$count=1;
			 		foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 			
			 			$num++;$count++;
			 	}
		 	}
		 	
		 	return $PHPExcel;
		}
		/*=================== Excel: End Less than 350 - By Biannual ============================================*/

		/*=================== Excel: Less than 350 - By Yearly ==================================================*/

		function excel_tests_lessthan350_yearly($YearO,$facility,$device,$from_month,$end_month,$report_type,$all,$login_id)
		 {
		 	$this->load->library('excel');
			$this->load->model('reports_model');
			$sql_data="";
			
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if($all==3 || $all==4 || $all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','CD4 Count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:I2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','CD4 count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

			if($facility!="")
			{	
				$device="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' - '.$YearO.' ' );

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$num++;$count++;
		 		}
		 	}

		 	if($device!="")
		 	{
		 		$facility="";

		 		$sql_data=$this->excel_tests_details($from_month,$end_month,$facility,$device,$report_type);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' - '.$YearO.' ' );
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':F'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$num++;$count++;
		 		}
		 	}

		 	if($all==3 || $all==4 || $all==5)
		 	{
		 		$sql_data=$this->excel_tests_details_all($from_month,$end_month,$all,$report_type,$login_id);
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

				if($all==3)
				{
					$user_filter=$this->session->userdata('user_filter');

					foreach($user_filter as $filter)
					{
						$pfilter=$filter['user_filter_name'];
					}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - '.$YearO.' ' );
				}
				else if($all==4)
				{
					$county_name=$this->reports_model->get_county_name($login_id); //get the county name

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County  - '.$YearO.' ' );
				}
				else if($all==5)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$YearO.' ' );
				}
	
		 		$num=3;$count=1;
			 		foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 			
			 			$num++;$count++;	
			 	}
		 	}
		 	
		 return $PHPExcel;
		}
		/*=================== Excel: End Less than 350 - By Yearly ==================================================*/

		/*=================== Excel: Less than 350 - By Customized dates ============================================*/

		function excel_tests_lessthan350_customized($facility,$device,$Fromdate,$Todate,$report_type,$all,$login_id)
		 {
		 	$this->load->library('excel');
			$this->load->model('reports_model');
			$sql_data="";
			
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('A1:P1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('B2','Patient ID');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('B2:C2');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('Q1','Total');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setSize(12);
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
			$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('Q1:R1');
			$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if($all==3 || $all==4 || $all==5)
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:J2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N2','CD4 Count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N2:O2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P2:Q2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else
			{
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G2','Date Of Test');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G2:I2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J2','CD4 count < 500');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J2:K2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L2','Operator');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L2:M2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

			if($facility!="")
			{	
				$device="";

		 		$sql_data=$this->excel_tests_details($Fromdate,$Todate,$facility,$device,$report_type);

				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$facility.' -  Between '.$Fromdate.' and '.$Todate.' ' );

				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Device');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$num++;$count++;
		 		}
		 	}

		 	if($device!="")
		 	{
		 		$facility="";

		 		$sql_data=$this->excel_tests_details($Fromdate,$Todate,$facility,$device,$report_type);

		 		$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$device.' -  Between '.$Fromdate.' and '.$Todate.' ' );
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D2','Facility');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
				$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D2:F2');
				$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$num=3;$count=1;

				foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('D'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('D'.$num.':F'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('D'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':I'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('J'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('J'.$num.':K'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('J'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('L'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('L'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('L'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$num++;$count++;
		 		}
		 	}
		 	if($all==3 || $all==4 || $all==5)
		 	{
		 		$sql_data=$this->excel_tests_details_all($Fromdate,$Todate,$all,$report_type,$login_id);
				
				$PHPExcel[]=$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');

				if($all==3)
				{
					$user_filter=$this->session->userdata('user_filter');

					foreach($user_filter as $filter)
					{
						$pfilter=$filter['user_filter_name'];
					}
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - '.$pfilter.' - Between '.$Fromdate.' and '.$Todate.' ' );
				}
				else if($all==4)
				{
					$county_name=$this->reports_model->get_county_name($login_id); //get the county name

					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for '.$county_name.' County  - Between '.$Fromdate.' and '.$Todate.' ' );
				}
				else if($all==5)
				{
					$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('A1','Report for all tests - Between '.$Fromdate.' and '.$Todate.' ' );
				}

				$num=3;$count=1;
			 		foreach ($sql_data as $value) 
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

				 		$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('G'.$num.'',$value['facility']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('G'.$num.':J'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('G'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('K'.$num.'',$value['date_test']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('K'.$num.':M'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('K'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('N'.$num.'',$value['cd4_count']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('N'.$num.':O'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('N'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$PHPExcel[]=$this->excel->getActiveSheet()->setCellValue('P'.$num.'',$value['operator']);
				 		$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getFont()->setSize(12);
						$PHPExcel[]=$this->excel->getActiveSheet()->mergeCells('P'.$num.':Q'.$num.'');
						$PHPExcel[]=$this->excel->getActiveSheet()->getStyle('P'.$num.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 			
			 			$num++;$count++;
		 			}
		 	}
		 	
		 return $PHPExcel;
		}
		/*=================== Excel:End Less than 350 - By Customized dates ============================================*/

		/*=================== Excel: Sql functions =====================================================================*/

	 	public function excel_tests_details($from,$to,$facility,$device,$report_type)//Get all the data by facility or device
		{
			$this->load->config("sql");

			$sql = $this->config->item('preset_sql');

			$tests_sql= $sql["pima_excel_tests_details"];

			$date_delimiter	 	=	"";
			$delimiter="";

			if($facility!="")
			{
				if($report_type==1)
				{
					$criteria =" AND  `f`.`name` ='".$facility."'";
					$report_type= " AND `tst`.`valid` ='1'";
				}
				else if($report_type==2)
				{
					$criteria =" AND  `f`.`name` ='".$facility."'";
					$report_type= " AND `tst`.`valid` ='0'";
				}
				else if($report_type==0)
				{
					$criteria =" AND  `f`.`name` ='".$facility."'";
					$report_type= " ";
				}
				else if($report_type==3)
				{
					$criteria =" AND  `f`.`name` ='".$facility."' AND `tst`.`cd4_count` < 500 ";
					$report_type= " AND `tst`.`valid` ='1' ";
				}
					
			}

			if($device!="")
			{	
				$criteria=" AND `fp`.`serial_num` ='".$device."' ";

				if($report_type==1)
				{
					$report_type= " AND `tst`.`valid` ='1'";
				}
				else if($report_type==2)
				{	
					$report_type= " AND `tst`.`valid` ='0'";
				}
				else if($report_type==0)
				{
					$report_type= " ";
				}
				else if($report_type==3)
				{
					$criteria.=' AND `tst`.`cd4_count` < 500 ';
					$report_type="  AND `tst`.`valid` ='1' ";
				}
					
			}

			$date_delimiter	=	" AND MONTH(`tst`.`result_date`) BETWEEN '".date('m',strtotime($from))."' AND '".date('m',strtotime($to))."'
								  AND YEAR(`tst`.`result_date`) BETWEEN '".date('Y',strtotime($from))."' AND '".date('Y',strtotime($to))."' ";
			
			$test_details=R::getAll($tests_sql.$criteria.$date_delimiter.$report_type);

			// echo $tests_sql.$criteria.$date_delimiter.$report_type;
	
			// die;

			return $test_details;

		}
		public function excel_tests_details_all($from,$to,$all,$report_type,$login_id)//Get all the data or by county
		{

			$this->load->config("sql");

			$sql = $this->config->item('preset_sql');

			$tests_sql= $sql["pima_excel_tests_details"];

			$date_delimiter	 	=	"";
			$delimiter="";
			$user_delimiter = "";

			$user_group_id = $this->session->userdata("user_group_id");

			$user_filter_used=$this->session->userdata("user_filter_used");

			if($user_group_id == 3){
				$user_delimiter = " AND `p`.`ID` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 9) {
				$user_delimiter = " AND `r`.`id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 8) {
				$user_delimiter = " AND `d`.`id` = '".$user_filter_used."' ";
			}elseif ($user_group_id == 6) {
				$user_delimiter = " AND `f`.`id` = '".$user_filter_used."' ";
			}

			if($all==5)// get all the data
			{
				if($report_type==1)
				{
					$report_type= " AND `tst`.`valid`='1'";
					$user_delimiter= " ";
				}
				else if($report_type==2)
				{	
					$report_type= " AND `tst`.`valid`='0'";
					$user_delimiter= " ";
				}
				else if($report_type==0)
				{	
					$report_type= " ";
					$user_delimiter= " ";
				}
				else if($report_type==3)
				{
					$delimiter=" AND `tst`.`cd4_count` < 500 ";
					$report_type="  AND `tst`.`valid`='1' ";
					$user_delimiter= " ";
				}
			}

			else if($all==4) //get data by county
			{
				if($report_type==1)
				{
					$report_type= " AND `tst`.`valid`='1'";
				}
				else if($report_type==2)
				{	
					$report_type= " AND `tst`.`valid`='0'";
				}
				else if($report_type==0)
				{

					$report_type= " ";
				}
				else if($report_type==3)
				{
					$delimiter=" AND `tst`.`cd4_count` < 500 ";
					$report_type=" AND `tst`.`valid`='1' ";
				}	
			}
			else if($all==3)
			{
				if($report_type==1)
				{
					$report_type= " AND `tst`.`valid`='1'";
				}
				else if($report_type==2)
				{	
					$report_type= " AND `tst`.`valid`='0'";
				}
				else if($report_type==0)
				{
					$report_type= " ";
				}
				else if($report_type==3)
				{
					$delimiter=" AND `tst`.`cd4_count` < 500 ";
					$report_type="  AND `tst`.`valid`='1' ";
				}
			}

			$date_delimiter	=	" AND MONTH(`tst`.`result_date`) BETWEEN '".date('m',strtotime($from))."' AND '".date('m',strtotime($to))."'
								  AND YEAR(`tst`.`result_date`) BETWEEN '".date('Y',strtotime($from))."' AND '".date('Y',strtotime($to))."' ";


			$test_details=R::getAll($tests_sql.$user_delimiter.$date_delimiter.$delimiter.$report_type);
	
			// echo $tests_sql.$user_delimiter.$date_delimiter.$delimiter.$report_type;
			// die;

			return $test_details;
			
		}

	 /*=================== Excel: Sql functions =====================================================================*/

}/*End of reports_excel_model.php */
?>