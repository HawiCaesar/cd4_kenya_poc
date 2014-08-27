<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class pima_report extends MY_Controller
{
	function pima_summary()
	{	
		$Format=$this->input->post('format_pima');//get radio button value

		$report_type=$this->input->post('report_type'); //get the report type
		
		$Yearo=$this->input->post('YearO');// Yearly report
			
		$Fromdate=$this->input->post('FromDate');// for customized dates
		$Todate=$this->input->post('ToDate');
		
		$monthly=$this->input->post('FieldM');// Monthly report
	 	$YearM=$this->input->post('YearM');
	 
	 	
		$quarterly=$this->input->post('quarterly');// Quarterly report
		$yearQ=$this->input->post('YearQ');

		$biannual=$this->input->post('bian');// Bi-annual report
		$yearB=$this->input->post('YearB');

		/*|========================= PDF format =====================================================================================|*/

		if($Format=="pdf")
		{
			$this->load->model('pima_report_model');

			$img=base_url().'img/nascop.jpg';// Nascop Logo

			$pdf_data="";

			$table_style='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
						table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
						table.data-table td, table th {padding: 4px;}
						table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
					</style>';

			$PDF_document="<table width='53%' border='0' align='center'>";
			$PDF_document.="<tr>";
			$PDF_document.='<td><center><img style="vertical-align: top;" src="'.$img.'" /></center></td>';
			$PDF_document.='</tr>';
			$PDF_document.='</table>';

			if($YearM!="" && $monthly!="")// Month and Year chosen
			{
				/*
					set a default start date and end date for the month selected

				*/
				$the_month=$this->pima_report_model->GetMonthName($monthly);
				$filename='PIMA Summary - Reported Devices - '.$the_month.', '.$YearM;

				$from_month=$YearM."-".$monthly.'-01';
			 	//$monthly++;
				$num_days=cal_days_in_month(CAL_GREGORIAN, $monthly,$YearM);
			 	$end_month=$YearM.'-'.$monthly.'-'.$num_days;

			 	$pdf_data=$this->pima_report_model->pima_report($YearM,$from_month,$end_month);

			 	$PDF_document.='<br /><table border="0" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<td>';
				$PDF_document.='<center><b>PIMA Summary - Reported Devices - '.$the_month.', '.$YearM.'</b></center>';
				$PDF_document.='</td>';
				$PDF_document.='</tr>';
				$PDF_document.='</table>';
			}
			if($yearQ!="" && $quarterly!="")// Quarter and Year chosen
			{
				/*
					set a default start date and end date for the month selected

				*/
				

			 	if($quarterly==1)
			 	{			 		
			 		$from_month=$yearQ.'-01-01';
			 		$end_month=$yearQ.'-04-30';
			 		$quarter="January - April";

			 	}
			 	else if($quarterly==2)
			 	{
			 		$from_month=$yearQ.'-05-01';
			 		$end_month=$yearQ.'-08-31';
			 		$quarter="May - August";

			 	}
			 	else if($quarterly==3)
			 	{
			 		$from_month=$yearQ.'-09-01';
			 		$end_month=$yearQ.'-12-31';
			 		$quarter="September - December";

			 	}
			 	$filename= 'PIMA Summary - Reported Devices - '.$quarter.', '.$yearQ;

			 	$pdf_data=$this->pima_report_model->pima_report($yearQ,$from_month,$end_month);

			 	$PDF_document.='<br /><table border="0" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<td>';
				$PDF_document.='<center><b>PIMA Summary - Reported Devices - '.$quarter.', '.$yearQ.'</b></center>';
				$PDF_document.='</td>';
				$PDF_document.='</tr>';
				$PDF_document.='</table>';
			}
			if($yearB!="" && $biannual!="")// Bi-annual and Year chosen
			{
				if($biannual==1)
				{
					$from_month=$yearB.'-01-01';
			 		$end_month=$yearB.'-06-30';
			 		$biannual_name="January - June";					
				}
				else if($biannual==2)
				{
					$from_month=$yearB.'-07-01';
			 		$end_month=$yearB.'-12-31';
			 		$biannual_name="July - December";
				}

				$filename= 'PIMA Summary - Reported Devices - '.$biannual_name.', '.$yearB;

				$pdf_data=$this->pima_report_model->pima_report($yearB,$from_month,$end_month);

				$PDF_document.='<br /><table border="0" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<td>';
				$PDF_document.='<center><b>PIMA Summary - Reported Devices - '.$biannual_name.', '.$yearB.'</b></center>';
				$PDF_document.='</td>';
				$PDF_document.='</tr>';
				$PDF_document.='</table>';
			}
			if($Yearo!="")// Yearly criteria chosen
			{	
				$from_month=$Yearo.'-01-01';
				$end_month=$Yearo.'-12-31';

				$filename='PIMA Summary - Reported Devices - '.$Yearo;

				$pdf_data=$this->pima_report_model->pima_report($Yearo,$from_month,$end_month);

				$PDF_document.='<br /><table border="0" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<td>';
				$PDF_document.='<center><b>PIMA Summary - Reported Devices - '.$Yearo.'</b></center>';
				$PDF_document.='</td>';
				$PDF_document.='</tr>';
				$PDF_document.='</table>';
			}
			if($Fromdate!="" && $Todate!="")// Custom dates chosen
			{
				$filename='PIMA Summary - Reported Devices - Between '.$Fromdate.' and '.$Todate;

				$pdf_data=$this->pima_report_model->pima_report(0,$from_month,$end_month);

				$PDF_document.='<br /><table border="0" align="center">';
				$PDF_document.='<tr>';
				$PDF_document.='<td>';
				$PDF_document.='<center><b>PIMA Summary - Reported Devices - Between '.$Fromdate.' and '.$Todate.'</b></center>';
				$PDF_document.='</td>';
				$PDF_document.='</tr>';
				$PDF_document.='</table>';
			}

			$this->load->library('mpdf/mpdf');// Load the mpdf library

			$mpdf=new mPDF();//initialize

			ini_set("memory_limit",'-1');
			ini_set('max_execution_time', 300);

			$mpdf->SetWatermarkText('NASCOP',0.09);//Water Mark Text
			$mpdf->watermark_size="0.2";
			$mpdf->showWatermarkText = true;//Water Mark set value
			$mpdf->simpleTables = true;
		
			$PDF_document.=$table_style.'<br />'.$pdf_data['table']; //place details in table

			$mpdf->AddPage('P', // L - landscape, P - portrait
					            '', '', '', '',
					            30, // margin_left
					            30, // margin right
					            10, // margin top
					            30, // margin bottom
					            18, // margin header
					            12); // margin footer

			$mpdf->WriteHTML($PDF_document);//place content in pdf		
			
			$mpdf->Output($filename,'I');//output pdf in browser
		}
		/*|========================= PDF format END ===================================================================================|*/
	}
}
?>