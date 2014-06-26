<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class send_mail extends MY_Controller {

function daemon_monthly_email()
{
	$from_month=date('Y-m-01');//first day of the month
	$end_month=date('Y-m-t',strtotime('0 month'));//last day of the month

	$month=date('m');
	$year=date('Y');

	$pdf_results="";
	$all_data="";
	$login_id="";
	$report_type=3;
	$Device="";
	$email_receipients=array();

	$img=$this->config->item('server_root').'img/nascop.jpg';// Nascop Logo

	$this->load->model('reports_model');
	$the_month=$this->reports_model->GetMonthName($month);

	$this->load->model('send_mail_model');

	$uploaded_facilities=$this->send_mail_model->uploads_by_facility($from_month,$end_month);

	$this->load->library('mpdf/mpdf');// Load the mpdf library

	$PDF_document="<table width='53%' border='0' align='center'>";
	$PDF_document.="<tr>";
	$PDF_document.="<td><center><img style='vertical-align: top;' src='$img'/></center></td>";
	$PDF_document.="</tr>";
	$PDF_document.="</table>";

	foreach($uploaded_facilities as $results)//begin foreach loop counties
	{	
		$partner="";

		if($results['region_name']==NULL)
		{

		}
		else
		{
			$mpdf=new mPDF();//initialize

			$file="";
			$PDF_content="";
			$title_filename="";
			$pdf_results="";

			//get all the tests < 350 for the facility 
			$pdf_results=$this->send_mail_model->tests_less_than350_month($from_month,$end_month,$results['facility_name']);

			if(!$pdf_results['less_than350']==0)//check if facility has tests < 350 cp/ml
			{
				//make a file name with the extension .pdf
				$title_filename=$the_month.' Report For '.$results['facility_name'].' For Patients With Outcomes Less Than 350 cp per ml';
				$file=$this->config->item('server_root').'assets/email/'.$title_filename.'.pdf';

				//set the pdf content
				$PDF_content.='<br /><table border="0" align="center">';
				$PDF_content.='<tr>';
				$PDF_content.='<td><center><b>'.$title_filename.'</b></center></td>';						
				$PDF_content.='</tr>';
				$PDF_content.='</table><br />';

				$PDF_content.='<table width="480" border="1" align="center">';
				$PDF_content.='<tr>';
				$PDF_content.='<th bgcolor="#990000" style="color:#FFF;"># Tests < 350</th>';
				$PDF_content.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
				$PDF_content.='</tr>';
				$PDF_content.='<tr><td align="center">'.$pdf_results['less_than350'].'</td>';
				$PDF_content.='<td align="center">'.$pdf_results['count'].'</td></tr></table>';
			
				$PDF_content.='<br />'.$pdf_results['table']; //place details in table

				$mpdf->SetWatermarkText('NASCOP');//Water Mark Text
				$mpdf ->watermark_size="0.2";
				$mpdf->showWatermarkText = true;//Water Mark set value

				//set the layout of the page
				$mpdf->AddPage('L', // L - landscape, P - portrait
							            '', '', '', '',
							            30, // margin_left
							            30, // margin right
							            10, // margin top
							            30, // margin bottom
							            18, // margin header
							            12); // margin footer
				$mpdf->simpleTables = true;
				$mpdf->WriteHTML($PDF_document.$PDF_content);//place content in pdf

				try
				{
					$mpdf->Output($file,'F'); //Save the pdf in the $file path
				}
				catch(exception $e)
				{
					$e->getMessage();
				}
				
				$county_receipients=array();
				$partner_receipients=array();
				
				$county_coordinator_email=$this->send_mail_model->get_county_email($results['region_id']);

				foreach($county_coordinator_email as $cemail)
				{
					$county_receipients[]=$cemail;
				}
				
				$partner_email=$this->send_mail_model->get_partner_email($results['partner_name']);

				foreach($partner_email as $pemail)
				{
					$partner_receipients[]=$pemail;
				}

				$email_receipients=array_merge($partner_receipients,$county_receipients);

				$this->email->from('CD4 PIMA Notification', 'CD4Poc@nascop.org');
				//$this->email->to($email_receipients);//send to specific receiver
				$this->email->to('brian.odhiambo932@gmail.com,tngugi@gmail.com,kanyonga.nicholas@gmail.com');//send to specific receiver

				
				$this->email->subject('Tests < 350 cp/ml Monthly Report'); //subject
				$this->email->attach($file);//attach the facility pdf document

				$message="Hi.<br /><br />Please Find Attached the List of all patients with outcomes < 350cp/ml.
									<br /><br />They require a Follow Up Viral Load Test & Initiation into treatment.
									<br /><br />Many Thanks.
									<br /><br />--
									<br /><br />CD4 Support Team
									<br /><br />This email was automatically generated. Please do not respond to this email address or it will be ignored.";

				$this->email->message($message);// the message

				if($this->email->send())//send email and check if the email was sent
				{	
					$this->email->clear(TRUE);//clear any attachments on the email
				}
				else 
				{
					show_error($this->email->print_debugger());//show error message
				} 
			}
			else
			{

			}

		}
		
	}
	delete_files($this->config->item('server_root').'assets/email/');//delete the files
}

function daemon_weekly_email()
{
	$this->load->model('send_mail_model');

	$last_monday_date=date('Y-m-d',strtotime('last monday'));//last monday
	$last_sunday_date=date('Y-m-d',strtotime('last sunday'));//last sunday

	$last_monday=date('jS F Y',strtotime('last monday'));
	$last_sunday=date('jS F Y',strtotime('last sunday'));

	$month=date('m');
	$year=date('Y');

	$email_receipients=array();

	$this->load->library('mpdf/mpdf');// Load the mpdf library

	$uploaded_facilities=$this->send_mail_model->uploads_by_facility($last_monday_date,$last_sunday_date);

	foreach($uploaded_facilities as $results)//begin foreach loop for counties
	{
		if($results['region_name']==NULL)
		{

		}
		else
		{
			$partner="";
			$county="";
			$receipient="national";
			$pdf_data=$this->send_mail_model->weekly_uploads($last_monday_date,$last_sunday_date,$county,$partner,$results['facility_name'],$receipient);

			$img=$this->config->item('server_root').'img/nascop.jpg';// Nascop Logo

			$PDF_document="<table width='53%' border='0' align='center'>";
			$PDF_document.="<tr>";
			$PDF_document.="<td><center><img style='vertical-align: top;' src='$img'/></center></td>";
			$PDF_document.="</tr>";
			$PDF_document.="</table>";

			$PDF_content='<br /><table border="0" align="center">';
			$PDF_content.='<tr>';
			$PDF_content.='<td><center><b>Weekly National Activity Report beginning '.$last_monday.' to '.$last_sunday.'</b></center></td>';						
			$PDF_content.='</tr>';
			$PDF_content.='</table>';

			$PDF_content.='<br />'.$pdf_data['cumulative_table'];
			$PDF_content.='<br />';

			$PDF_content.=$pdf_data['breakdown_table'];

			$mpdf=new mPDF();//initialize
			
			$filename='Weekly National Activity Report beginning '.$last_monday.' to '.$last_sunday;
			$file=$this->config->item('server_root').'assets/weekly_email_national/'.$filename.'.pdf';

			$mpdf->SetWatermarkText('NASCOP');//Water Mark Text
			$mpdf ->watermark_size="0.2";
			$mpdf->showWatermarkText = true;//Water Mark set value

			//set the layout of the page
			$mpdf->AddPage('L', // L - landscape, P - portrait
						            '', '', '', '',
						            30, // margin_left
						            30, // margin right
						            10, // margin top
						            30, // margin bottom
						            18, // margin header
						            12); // margin footer
			$mpdf->simpleTables = true;
			$mpdf->WriteHTML($PDF_document.$PDF_content);//place content in pdf

			try
			{
				$mpdf->Output($file,'F'); //Save the pdf in the $file path
			}
			catch(exception $e)
			{
				$e->getMessage();
			}

			$this->email->from('CD4 PIMA Notification', 'CD4Poc@nascop.org');
	
			$this->email->to('brian.odhiambo932@gmail.com,tngugi@gmail.com,kanyonga.nicholas@gmail.com');//send to specific receiver

			$this->email->subject('Weekly National Activty Report'); //subject
			$this->email->attach($file);//attach the pdf document

			$message="Hi.<br /><br />Please find attached the summary for PIMA Test uploads for the week ending ".$last_monday." and ".$last_sunday."  ".$the_month." " .$year.".
								<br /><br />Many Thanks.
								<br /><br />--
								<br /><br />CD4 Support Team
								<br /><br />This email was automatically generated. Please do not respond to this email address or it will ignored.";

			$this->email->message($message);// the message
			if($this->email->send())//send email and check if the email was sent
			{	
				$this->email->clear(TRUE);//clear any attachments on the email
			}
			else 
			{
				show_error($this->email->print_debugger());//show error message
			}
		 	break;
		 }
		
	}	
	$uploaded_counties=$this->send_mail_model->uploads_by_county($last_monday_date,$last_sunday_date);

	foreach($uploaded_counties as $results)//begin foreach loop for counties
	{
		if($results['region_name']==NULL)
		{

		}
		else
		{
			$partner="";
			$facility="";
			$receipient="breakdown";
			$pdf_data=$this->send_mail_model->weekly_uploads($last_monday_date,$last_sunday_date,$results['region_name'],$partner,$facility,$receipient);
			
			$img=$this->config->item('server_root').'img/nascop.jpg';// Nascop Logo

			$PDF_document="<table width='53%' border='0' align='center'>";
			$PDF_document.="<tr>";
			$PDF_document.="<td><center><img style='vertical-align: top;' src='$img'/></center></td>";
			$PDF_document.="</tr>";
			$PDF_document.="</table>";

			$PDF_content='<br /><table border="0" align="center">';
			$PDF_content.='<tr>';
			$PDF_content.='<td><center><b>Weekly Activity Report For '.$results['region_name'].' County beginning '.$last_monday.' to '.$last_sunday.'</b></center></td>';						
			$PDF_content.='</tr>';
			$PDF_content.='</table>';

			$PDF_content.='<br />'.$pdf_data['cumulative_table'];
			$PDF_content.='<br />';

			$PDF_content.=$pdf_data['breakdown_table'].'<br />';

			$PDF_content.=$pdf_data['facility_breakdown'];

			$mpdf=new mPDF();//initialize
			
			$filename='Weekly Report for '.$results['region_name'].' beginning '.$last_monday.' to '.$last_sunday;
			$file=$this->config->item('server_root').'assets/weekly_email_county/'.$filename.'.pdf';

			$mpdf->SetWatermarkText('NASCOP');//Water Mark Text
			$mpdf ->watermark_size="0.2";
			$mpdf->showWatermarkText = true;//Water Mark set value

			//set the layout of the page
			$mpdf->AddPage('L', // L - landscape, P - portrait
						            '', '', '', '',
						            30, // margin_left
						            30, // margin right
						            10, // margin top
						            30, // margin bottom
						            18, // margin header
						            12); // margin footer
			$mpdf->simpleTables = true;
			$mpdf->WriteHTML($PDF_document.$PDF_content);//place content in pdf

			try
			{
				$mpdf->Output($file,'F'); //Save the pdf in the $file path
			}
			catch(exception $e)
			{
				$e->getMessage();
			}
			$county_receipients=array();
			
			$county_coordinator_email=$this->send_mail_model->get_county_email($results['region_id']);

			foreach($county_coordinator_email as $cemail)
			{
				$county_receipients[]=$cemail;
			}

			$this->email->from('CD4 PIMA Notification', 'CD4Poc@nascop.org');

			//$this->email->to(county_receipients);//send to specific receiver
			$this->email->to('brian.odhiambo932@gmail.com,tngugi@gmail.com,kanyonga.nicholas@gmail.com');//send to specific receiver

			$this->email->subject('Weekly Activity Report'); //subject
			$this->email->attach($file);//attach the pdf document

			$message="Hi.<br /><br />Please find attached the summary for PIMA Test uploads for the week ending ".$last_monday." and ".$last_sunday."  ".$the_month." " .$year." for ".$results['region_name']." county.
								<br /><br />These tests are for the previous week
								<br /><br />Many Thanks.
								<br /><br />--
								<br /><br />CD4 Support Team
								<br /><br />This email was automatically generated. Please do not respond to this email address or it will ignored.";

			$this->email->message($message);// the message
			if($this->email->send())//send email and check if the email was sent
			{	
				$this->email->clear(TRUE);//clear any attachments on the email
			}
			else 
			{
				show_error($this->email->print_debugger());//show error message
			}
		}
		
	}

	$uploaded_partners=$this->send_mail_model->uploads_by_partner($last_monday_date,$last_sunday_date);//get uploaded data by partner

	foreach($uploaded_partners as $results)//begin foreach loop for partners
	{
		if($results['partner_name']==NULL)
		{

		}
		else
		{
			$county="";
			$facility="";
			$receipient="breakdown";
			$pdf_data=$this->send_mail_model->weekly_uploads($last_monday_date,$last_sunday_date,$county,$results['partner_name'],$facility,$receipient);

			$img=$this->config->item('server_root').'img/nascop.jpg';// Nascop Logo

			$PDF_document="<table width='53%' border='0' align='center'>";
			$PDF_document.="<tr>";
			$PDF_document.="<td><center><img style='vertical-align: top;' src='$img'/></center></td>";
			$PDF_document.="</tr>";
			$PDF_document.="</table>";

			$PDF_content='<br /><table border="0" align="center">';
			$PDF_content.='<tr>';
			$PDF_content.='<td><center><b>Weekly Activity Report For '.$results['partner_name'].' beginning '.$last_monday.' to '.$last_sunday.'</b></center></td>';						
			$PDF_content.='</tr>';
			$PDF_content.='</table>';

			$PDF_content.='<br />'.$pdf_data['cumulative_table'];
			$PDF_content.='<br />';

			$PDF_content.=$pdf_data['breakdown_table'].'<br />';

			$PDF_content.=$pdf_data['facility_breakdown'];

			$mpdf=new mPDF();//initialize
			
			$filename='Weekly Report for '.$results['partner_name'].' beginning '.$last_monday.' to '.$last_sunday;
			$file=$this->config->item('server_root').'assets/weekly_email_partner/'.$filename.'.pdf';

			$mpdf->SetWatermarkText('NASCOP');//Water Mark Text
			$mpdf ->watermark_size="0.2";
			$mpdf->showWatermarkText = true;//Water Mark set value

			//set the layout of the page
			$mpdf->AddPage('L', // L - landscape, P - portrait
						            '', '', '', '',
						            30, // margin_left
						            30, // margin right
						            10, // margin top
						            30, // margin bottom
						            18, // margin header
						            12); // margin footer
			$mpdf->simpleTables = true;
			$mpdf->WriteHTML($PDF_document.$PDF_content);//place content in pdf

			try
			{
				$mpdf->Output($file,'F'); //Save the pdf in the $file path
			}
			catch(exception $e)
			{
				$e->getMessage();
			}

			$partner_receipients=array();

			$partner_email=$this->send_mail_model->get_partner_email($results['partner_name']);

			foreach($partner_email as $pemail)
			{
				$partner_receipients[]=$pemail;
			}
			$this->email->from('CD4 PIMA Notification', 'CD4Poc@nascop.org');
			//$this->email->to(partner_receipients);//send to specific receivers
			$this->email->to('brian.odhiambo932@gmail.com,tngugi@gmail.com,kanyonga.nicholas@gmail.com');//send to specific receiver

			$this->email->subject('Weekly Activity Report'); //subject
			$this->email->attach($file);//attach the pdf document

			$message="Hi.<br /><br />Please find attached the summary for PIMA Test uploads for the week ending ".$last_monday." and ".$last_sunday."  ".$the_month." " .$year." for ".$results['partner_name'].".
								<br /><br />Many Thanks.
								<br /><br />--
								<br /><br />CD4 Support Team
								<br /><br />This email was automatically generated. Please do not respond to this email address or it will ignored.";

			$this->email->message($message);// the message

			if($this->email->send())//send email and check if the email was sent
			{	
				$this->email->clear(TRUE);//clear any attachments on the email
			}
			else 
			{
				show_error($this->email->print_debugger());//show error message
			}
		}
	}

	
	delete_files($this->config->item('server_root').'assets/weekly_email_national/');//delete the files
	delete_files($this->config->item('server_root').'assets/weekly_email_county/');//delete the files
	delete_files($this->config->item('server_root').'assets/weekly_email_partner/');//delete the files

}
	
	
}/* End of file send_mail.php */
/* Location: ./application/modules/poc/controller/send_mail.php */