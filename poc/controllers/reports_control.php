<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class reports_control extends MY_Controller{

function index()
{
		$this->load->model('login_model');
		$this->load->model('reports_model');
		$this->load->model('sidebar_model');

		$currentmonth=date('m');
		$currentyear=date("Y");
		$todate = date("Y-m-d");
		$fromdate = date('Y-m-d', strtotime('-3 month'));
		/*$fromfilter;
		$tofilter;*/
		$filter=3;

		$patID=$this->session->userdata('PartnerID');

		$Reports_Page['DeviceNumberOptions']=$this->reports_model->DeviceNumberOptions($patID);
		
		$Facilities[]=$this->reports_model->getFacilityTested($patID,$filter,$currentmonth,$currentyear,/*$fromfilter,$tofilter,*/$fromdate,$todate);
		
		$az=array_pop(array_keys($Facilities));

		$no=1;
		for($num=0;$num<=$az;$num++)
		{
			if($Facilities)
			{
				$Reports_Page['FacilityList']=$this->reports_model->tblFacRpt($Facilities[$num],$patID,$filter,$currentmonth,$currentyear,/*$fromfilter,$tofilter,*/$fromdate,$todate);
				$no++;
			}else{

				echo "No Faciliy Tested";
			}


		}
		
	//die;
		$Reports_Page['yearlyReports']=$this->reports_model->getyearsreported($patID);
		$Reports_Page['sidebarErrors']=$this->sidebar_model->totalErr($patID,$filter,$currentmonth,$currentyear,/*$fromfilter,$tofilter,*/$fromdate,$todate);
		$Reports_Page['sidebarError2']=$this->sidebar_model->totalErrDet($patID,$filter,$currentmonth,$currentyear,/*$fromfilter,$tofilter,*/$fromdate,$todate);
		//die;

		$Reports_Page['menus']=$this->login_model->menus(7);
		$Reports_Page['page']='reports_view';
		$Reports_Page=array_merge($Reports_Page,$this->cd4Libraries->facilityFcdrr());

		$this->load->view('template',$Reports_Page);
	}


	function reportSpecs()
	{	
		
		$Format=$this->input->post('format');

		if($Format=="pdf")// Check if PDF is selected
		{	
			$this->load->library('mpdf/mpdf');// Load the library
			$img=img_url().'nascop.jpg';// Nascop Logo

			//Data
			$GraphPDF='<table width="100%" border="1">
							<tr>
							<td>
							<center>Graphical Summary</center>
							</td>
							</tr>
							<tr>
							<td><img style="vertical-align: top;" src="'.$img.'"/></td>
							</tr>
						</table>';

			

			
			$this->mpdf->WriteHTML($GraphPDF);
			$this->mpdf->Output();// Output the results in the browser
		}
		else if($Format=="excel")// Else Excel is selected
		{
			$this->load->library('excel');

			$this->excel->getActiveSheet()->setTitle('REPORT FOR CD4 SAMPLES TESTED');
			$this->excel->getActiveSheet()->setCellValue('A1','This is just some text value');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

			//$this->excel->getActiveSheet()->mergeCells('A1:D1');
			//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$filename="TEST OUTCOME REPORT FOR CD4 Count.xls";
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'" ');
			header('Cache-Control: max-age=0');
			$obWrite=PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$obWrite->save('php://output');



			/*$data['format']=$Format;

			$this->load->view('ReportsVersion_view',$data);*/

		}


	}



 }