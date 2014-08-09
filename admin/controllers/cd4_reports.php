<?php 

class cd4_reports extends MY_Controller
{
	function index()
	{
		$this->cd4_reporting_dashboard();
	}

	function cd4_reporting_dashboard()
	{
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/cd4_reporting_view";
		$data['title'] = "CD4 Reports";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('dataTables','admin_cd4_reports','fortawesome'))); //load the dataTables plugin, fortawesome and admin_cd4_reports.js

		$this->load->model('admin_model'); //load admin_model

		$data['menus']	= 	$this->admin_model->menus(6);

		//load all the facilities
		$data['facilities'] = 	$this->admin_model->get_details("facility_details",$this->session->userdata("user_filter_used"));

		// $users=0;

		// if(!$users==1)
		// {
		// 	$data['number_of_deactivated_users']="none";
		// }
		
		$this->template($data);//load template and put data on page
	}

	function get_pima_report()
	{
		$format=$this->input->post('format');
		$facility=$this->input->post('facility_name');

		//check the format of the submit button

		/*.......................... PDF function ................................*/
		if($format=='pdf')
		{
			$pdf_data="";
			$results="";
			$empty=array();
			$datestring = "%h:%i %a";//set the timestamp

			$filename="Pima_PDF_Tests_results_".$facility.".pdf"; //file_name

			$img=base_url().'img/nascop.jpg';// Nascop Logo

			$this->load->model('cd4_reports_model'); //load the model

			$results=$this->cd4_reports_model->get_facility_details($facility);//get the data

			if($results!=$empty)
			{
				$pdf_data.="<table width='53%' border='0' align='center'>
								<tr>
									<td><center><img style='vertical-align: top;' src='$img'/></center></td>
								</tr>
						</table>";

				//column headings
				$pdf_data.='<table border="1" style="width:100%">';
				$pdf_data.='<tr>';				
				$pdf_data.='<td>#</td>';
				$pdf_data.='<td><center>Date Uploaded</center></td>';
				$pdf_data.='<td style="width:25%"><center>Facility</center></td>';
				$pdf_data.='<td><center>Uploaded by</center></td>';
				$pdf_data.='<td style="color: #2d6ca2;" ><center># of total tests</center></td>';
				$pdf_data.='<td style="color: #2aabd2;" ><center># of valid tests</center></td>';
				$pdf_data.='<td style="color: #3e8f3e; width:15%;"><center># of tests >= 350 cells/mm3</center></td>';
				$pdf_data.='<td style="color: #eb9316; width:15%;"><center># of tests < 350 cells/mm3</center></td>';
				$pdf_data.='<td style="color: #c12e2a;" ><center># of errors</center></td>';
				$pdf_data.='</tr>';
				$pdf_data.='<tbody>';
				
				$i=1;//counter
				$grand_total_tests=0;

				foreach($results as $result)
				{
					$string_unix="";
					$string_unix=mysql_to_unix($result['upload_date']);

					$pdf_data.='<tr>';

					$pdf_data.='<td>'.$i.'</td>';
					$pdf_data.='<td><center>'.date('d-F-Y',strtotime($result['upload_date'])).' - '.mdate($datestring,$string_unix).'</center></td>';
					$pdf_data.='<td style="width:25%"><center>'.$result['facility'].'</center></td>';
					$pdf_data.='<td><center>'.$result['uploaded_by_name'].'</center></td>';
					$pdf_data.='<td><center>'.$result['total_tests'].'</center></td>';
					$pdf_data.='<td><center>'.$result['valid_tests'].'</center></td>';
					$pdf_data.='<td><center>'.$result['passed'].'</center></td>';
					$pdf_data.='<td><center>'.$result['failed'].'</center></td>';
					$pdf_data.='<td><center>'.$result['errors'].'</center></td>';

					$pdf_data.='</tr>';

					$grand_total_tests+=$result['total_tests'];
					$i++;
				}
				$pdf_data.='</tbody>';
				$pdf_data.='</table>';

				$pdf_data.='<p>Grand Total Number of Tests Done <b>'.$grand_total_tests.'</b></p>';

				$this->load->library('mpdf/mpdf');// Load the mpdf library

				$this->mpdf->AddPage('L', // L - landscape, P - portrait
							            '', '', '', '',
							            30, // margin_left
							            30, // margin right
							            10, // margin top
							            30, // margin bottom
							            18, // margin header
							            12); // margin footer

				$this->mpdf->SetWatermarkText('NASCOP');//Water Mark Text
				$this->mpdf->showWatermarkText = true;//Water Mark set value

				$this->mpdf->simpleTables = true; 

				$this->mpdf->WriteHTML($pdf_data);//place content in pdf

				$this->mpdf->Output($filename,'D'); //bring up "Save as Dialog" box
			}
			else
			{
				$pdf_data.="<table width='53%' border='0' align='center'>";
				$pdf_data.="<tr>";
				$pdf_data.="<td><center><img style='vertical-align: top;' src='$img'/></center></td>";
				$pdf_data.="</tr>";
				$pdf_data.="</table>";
				$pdf_data.="<p style='text-align:center;'>The facility has not reported its PIMA Tests Yet</p>";

				$filename="NO_PIMA_TESTS.pdf";
				$this->load->library('mpdf/mpdf');// Load the mpdf library

				$this->mpdf->WriteHTML($pdf_data);//place content in pdf

				$this->mpdf->Output($filename,'D'); //Opens PDF in Browser
			}
			

		}
		/*........................ End PDF function ..............................*/

		/*........................ Excel function ................................*/
		else if($format=='excel')
		{
			$this->load->model('cd4_reports_model');

			$year=date('Y');
			$month=date('m');
			$month=$month-1;

			//set the beginning date
			$begin_date='-01';
			$begin_month='-0'.$month;
			$begin_year=$year;

			$from_date=$begin_year.$begin_month.$begin_date;

			//set the end date
			$end_date=date('Y-m-d',mktime(0,0,0,$month,31,$year));

			$PHPEXcel[]=$this->cd4_reports_model->get_excel_pima_details($facility,$from_date,$end_date,$month,$year);

			$filename="Excel_PIMA_Report_".$facility.".xls";

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');// *can use ms-excel2007
			header('Content-Disposition: attachment;filename="'.$filename.'" ');
			header('Cache-Control: max-age=0');
			$obWrite=PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$obWrite->save('php://output');

		}
		/*........................ End Excel function ............................*/
	}
 public function getfacilitiesreportingpima(){
		
		$sql 	= "SELECT * 
							FROM  `v_facility_pima_details` 
							WHERE  `facility_pima_serial_num` !=  '0'";
	    $data=R::getAll($sql);;
		
		return $data;
	    }

}//end of cd4_reports.php