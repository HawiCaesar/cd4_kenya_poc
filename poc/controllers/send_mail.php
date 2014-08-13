<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class send_mail extends MY_Controller {

function __construct()
{
	parent::__construct();

	$this->load->config->item('email');
	$this->load->library('email');
	$this->load->model('send_mail_model');
}
/* |==================== Monthly Critical Patients Email function END =================| */

function daemon_critical_monthly_email()
{
	$month=date('m');
	$year=date('Y');

	if($month==1)
	{
		$year=date('Y')-1;
		$month=12;

		$from_month=$year.'-'.$month.'-01';
		$num_days=cal_days_in_month(CAL_GREGORIAN, $month,$year);
		$end_month=$year.'-'.$month.'-'.$num_days;

	}
	else
	{
		$month-=1;
		$from_month=$year.'-'.$month.'-01';
		$num_days=cal_days_in_month(CAL_GREGORIAN, $month,$year);
		$end_month=$year.'-'.$month.'-'.$num_days;
	}

	$pdf_results="";
	$all_data="";
	$login_id="";
	$report_type=3;
	$Device="";
	$email_receipients=array();

	//CHAI team
	$CHAI_team=array('brianhawi92@gmail.com',
					 'tngugi@clintonhealthaccess.org',
					 'skadima@clintonhealthaccess.org',
					 'onjathi@clintonhealthaccess.org',
					 'jlusike@clintonhealthaccess.org',
					 'kanyonga.nicholas@gmail.com'
					 );
	//$CHAI_team=array('brianhawi92@gmail.com','kanyonga.nicholas@gmail.com');

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

			//get all the tests < 500 for the facility 
			$pdf_results=$this->send_mail_model->tests_less_than500($from_month,$end_month,$results['facility_name']);

			//make a file name with the extension .pdf
			$title_filename=$the_month.' Report For '.$results['facility_name'].' For Patients With Outcomes Less Than 500 cp per ml';
			$file=$this->config->item('server_root').'assets/monthly_critical/'.$title_filename.'.pdf';

			//set the pdf content
			$PDF_content.='<br /><table border="0" align="center">';
			$PDF_content.='<tr>';
			$PDF_content.='<td><center><b>'.$title_filename.'</b></center></td>';						
			$PDF_content.='</tr>';
			$PDF_content.='</table><br />';

			$PDF_content.='<table width="480" border="1" align="center">';
			$PDF_content.='<tr>';
			$PDF_content.='<th bgcolor="#990000" style="color:#FFF;"># Tests < 500</th>';
			$PDF_content.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
			$PDF_content.='</tr>';
			$PDF_content.='<tr><td align="center" style="width:50%;">'.$pdf_results['less_than500'].'</td>';
			$PDF_content.='<td align="center" style="width:50%;">'.$pdf_results['count'].'</td></tr></table>';
		
			$PDF_content.='<br />'.$pdf_results['table']; //place details in table

			$mpdf->SetWatermarkText('NASCOP',0.09);//Water Mark Text
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
			$email_receipients=array();
			
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

			$this->email->from('cd4poc@gmail.com', 'CD4 PIMA Notification');
			$this->email->to($email_receipients);//send to specific receiver
			$this->email->bcc($CHAI_team);//CHAI team
			
			$this->email->subject('Tests < 500 cp/ml Monthly Report'); //subject
			$this->email->attach($file);//attach the facility pdf document

			$message="Hi.<br /><br />Please Find Attached the List of all patients with outcomes < 500cp/ml.
								<br /><br />They require a Follow Up Viral Load Test & Initiation into treatment.
								<br /><br />Many Thanks.
								<br /><br />NB: You can access the system by following link below
								<br /><br /><b>http://www.nascop.org/cd4Poc/login</b>
								<br /><br />CD4 Support Team
								<br /><br />--
								<br /><br />Please do NOT reply to this message as it is sent from an unattended mailbox.";

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
	//delete_files($this->config->item('server_root').'assets/email/');//delete the files
}
/* |==================== Monthly Critical Patients Email function END =================| */

/* |==================== Monthly Activity Email function ==============================| */

function daemon_monthly_activity_email()
{
	$month=date('m');
	$year=date('Y');

	if($month==1)
	{
		$year=date('Y')-1;
		$month=12;

		$from_month=$year.'-'.$month.'-01';
		$num_days=cal_days_in_month(CAL_GREGORIAN, $month,$year);
		$end_month=$year.'-'.$month.'-'.$num_days;

	}
	else
	{
		$month-=1;
		$from_month=$year.'-'.$month.'-01';
		$num_days=cal_days_in_month(CAL_GREGORIAN, $month,$year);
		$end_month=$year.'-'.$month.'-'.$num_days;
	}

	$pdf_results="";
	$all_data="";
	$login_id="";
	$report_type=3;
	$Device="";
	$email_receipients=array();

	//CHAI team
	$CHAI_team=array('brianhawi92@gmail.com',
					 'tngugi@clintonhealthaccess.org',
					 'skadima@clintonhealthaccess.org',
					 'onjathi@clintonhealthaccess.org',
					 'jlusike@clintonhealthaccess.org',
					 'kanyonga.nicholas@gmail.com'
					 );
	//$CHAI_team=array('brianhawi92@gmail.com','kanyonga.nicholas@gmail.com');

	$table_style='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
						table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
						table.data-table td, table th {padding: 4px;}
						table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
					</style>';

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

			//get all the tests < 500 for the facility 
			$pdf_results=$this->send_mail_model->all_tests_done($from_month,$end_month,$results['facility_name']);

			//make a file name with the extension .pdf
			$title_filename='Monthly Activity Report For '.$results['facility_name'].' - '.$the_month.','.$year;
			$file=$this->config->item('server_root').'assets/monthly_activity/'.$title_filename.'.pdf';

			//set the pdf content
			$PDF_content.='<br /><table border="0" align="center">';
			$PDF_content.='<tr>';
			$PDF_content.='<td><center><b>'.$title_filename.'</b></center></td>';						
			$PDF_content.='</tr>';
			$PDF_content.='</table><br />';

			$PDF_content.='<table width="880" border="0" align="center" class="data-table">';
			$PDF_content.='<tr>';
			$PDF_content.='<th bgcolor="#006600" style="color:#FFF;">Successful Tests Done</th>';
			$PDF_content.='<th bgcolor="#eb9316" style="color:#FFF;">Tests < 500</th>';
			$PDF_content.='<th bgcolor="#006600" style="color:#FFF;">Tests >= 500</th>';
			$PDF_content.='<th bgcolor="#CC0000" style="color:#FFF;">Tests With Errors</th>';
			$PDF_content.='<th bgcolor="#000066" style="color:#FFF;">Total Number of Tests</th>';
			$PDF_content.='</tr>';
			$PDF_content.='<tr><td align="center" style="width:24%;">'.$pdf_results['valid_tests'].'</td>';
			$PDF_content.='<td align="center" style="width:24%;">'.$pdf_results['less_than350'].'</td>';
			$PDF_content.='<td align="center" style="width:24%;">'.$pdf_results['greater_equal_to350'].'</td>';
			$PDF_content.='<td align="center" style="width:24%;">'.$pdf_results['errors'].'</td>';
			$PDF_content.='<td align="center" style="width:24%;">'.$pdf_results['count'].'</td></tr>';
			$PDF_content.='</table>';
		
			$PDF_content.=$table_style.'<br />'.$pdf_results['table']; //place details in table

			$mpdf->SetWatermarkText('NASCOP',0.09);//Water Mark Text
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
			$email_receipients=array();
			
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

			// $this->email->from('cd4poc@gmail.com', 'CD4 PIMA Notification');
			// $this->email->to($email_receipients);//send to specific receiver
			// $this->email->bcc($CHAI_team);//CHAI team
			
			// $this->email->subject('Tests < 500 cp/ml Monthly Report'); //subject
			// $this->email->attach($file);//attach the facility pdf document

			// $message="Hi.<br /><br />Please Find Attached the summary for PIMA Test uploads for the month of ".$month."
			// 					<br /><br />
			// 					<br /><br />Many Thanks.
			// 					<br /><br />NB: You can access the system by following link below
			// 					<br /><br /><b>http://www.nascop.org/cd4Poc/login</b>
			// 					<br /><br />CD4 Support Team
			// 					<br /><br />--
			// 					<br /><br />Please do NOT reply to this message as it is sent from an unattended mailbox.";

			// $this->email->message($message);// the message

			// if($this->email->send())//send email and check if the email was sent
			// {	
			// 	$this->email->clear(TRUE);//clear any attachments on the email
			// }
			// else 
			// {
			// 	show_error($this->email->print_debugger());//show error message
			// } 

		}
		break;
	}
	//delete_files($this->config->item('server_root').'assets/email/');//delete the files
}
/* |==================== Monthly Activity Email function END =================| */
 
/* |==================== Weekly Email function ===============================| */

function daemon_weekly_email()
{
	ini_set('max_execution_time', 600);

	$last_monday_date=date('Y-m-d',strtotime('last monday'));//last monday
	$last_sunday_date=date('Y-m-d',strtotime('last sunday'));//last sunday

	$last_monday=date('jS F Y',strtotime('last monday'));
	$last_sunday=date('jS F Y',strtotime('last sunday'));

	$month=date('m');
	$year=date('Y');

	//CHAI team
	$CHAI_team=array('brianhawi92@gmail.com',
					 'tngugi@clintonhealthaccess.org',
					 'skadima@clintonhealthaccess.org',
					 'onjathi@clintonhealthaccess.org',
					 'jlusike@clintonhealthaccess.org',
					 'kanyonga.nicholas@gmail.com'
					 );
	$National_team=array('jbatuka@usaid.gov',
						 'Uys0@cdc.gov',
						 'mamoumuro@gmail.com',
						 'njebungei@yahoo.com',
						 'hoy4@cdc.gov');
	$table_style='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
						table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
						table.data-table td, table th {padding: 4px;}
						table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
					</style>';
	
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

			$PDF_content.=$table_style.'<br />'.$pdf_data['cumulative_table'];
			$PDF_content.='<br />';

			$PDF_content.=$pdf_data['breakdown_table'];

			$mpdf=new mPDF();//initialize
			
			$filename='Weekly National Activity Report beginning '.$last_monday.' to '.$last_sunday;
			$file=$this->config->item('server_root').'assets/weekly_email_national/'.$filename.'.pdf';

			$mpdf->SetWatermarkText('NASCOP',0.09);//Water Mark Text
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

			$this->email->from('cd4poc@gmail.com', 'CD4 PIMA Notification');
	
			$this->email->to($National_team);//send to CHAI team
			$this->email->bcc($CHAI_team);//send to CHAI team
			//$this->email->to('brianhawi92@gmail.com');

			$this->email->subject('Weekly National Activty Report'); //subject
			$this->email->attach($file);//attach the pdf document

			$message="Hi.<br /><br />Please find attached the summary for PIMA Test uploads for the week ending ".$last_monday." and ".$last_sunday.".
								<br /><br />Many Thanks.
								<br /><br />NB: You can access the system by following link below
								<br /><br /><b>http://www.nascop.org/cd4Poc/login</b>
								<br /><br />CD4 Support Team
								<br /><br />--
								<br /><br />Please do NOT reply to this message as it is sent from an unattended mailbox.";
			

			$this->email->message($message);// the message
			if($this->email->send())//send email and check if the email was sent
			{	
				$this->email->clear(TRUE);//clear any attachments on the email
			}
			else 
			{
				show_error($this->email->print_debugger());//show error message
			}
		  	break;//break to not loop again
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

			$PDF_content.=$table_style.'<br />'.$pdf_data['cumulative_table'];
			$PDF_content.='<br />';

			$PDF_content.=$pdf_data['breakdown_table'].'<br />';

			$PDF_content.=$pdf_data['facility_breakdown'];

			$mpdf=new mPDF();//initialize
			
			$filename='Weekly Report for '.$results['region_name'].' beginning '.$last_monday.' to '.$last_sunday;
			$file=$this->config->item('server_root').'assets/weekly_email_county/'.$filename.'.pdf';

			$mpdf->SetWatermarkText('NASCOP',0.09);//Water Mark Text
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
			echo "...".$results['region_name'];
			echo "<pre>";
			print_r($county_receipients);
			 echo "</pre>";
			echo "<br />";
			$this->email->from('cd4poc@gmail.com', 'CD4 PIMA Notification');
			
			$this->email->to($county_receipients); //send to specific receiver
			$this->email->bcc($CHAI_team); //CHAI team

			//$this->email->to('brianhawi92@gmail.com');

			$this->email->subject('Weekly Activity Report'); //subject
			$this->email->attach($file);//attach the pdf document

			$message="Hi.<br /><br />Please find attached the summary for PIMA Test uploads for the week ending ".$last_monday." and ".$last_sunday." for ".$results['region_name']." county.
								<br /><br />These tests are for the previous week
								<br /><br />Many Thanks.
								<br /><br />NB: You can access the system by following link below
								<br /><br /><b>http://www.nascop.org/cd4Poc/login</b>
								<br /><br />CD4 Support Team
								<br /><br />--
								<br /><br />Please do NOT reply to this message as it is sent from an unattended mailbox.";

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

			$PDF_content.=$table_style.'<br />'.$pdf_data['cumulative_table'];
			$PDF_content.='<br />';

			$PDF_content.=$pdf_data['breakdown_table'].'<br />';

			$PDF_content.=$pdf_data['facility_breakdown'];

			$mpdf=new mPDF();//initialize
			
			$filename='Weekly Report for '.$results['partner_name'].' beginning '.$last_monday.' to '.$last_sunday;
			$file=$this->config->item('server_root').'assets/weekly_email_partner/'.$filename.'.pdf';

			$mpdf->SetWatermarkText('NASCOP',0.09);//Water Mark Text
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
			echo "...".$results['partner_name']."...";
			echo "<pre>";
			print_r($partner_receipients);
			echo "</pre>";
			echo "...<br />";
			$this->email->from('cd4poc@gmail.com', 'CD4 PIMA Notification');
			// $this->email->to($partner_receipients); //send to specific receivers
			// $this->email->bcc($CHAI_team); //CHAI team

			$this->email->to('brianhawi92@gmail.com');

			$this->email->subject('Weekly Activity Report'); //subject
			$this->email->attach($file);//attach the pdf document

			$message="Hi.<br /><br />Please find attached the summary for PIMA Test uploads for the week ending ".$last_monday." and ".$last_sunday." for ".$results['partner_name'].".
								<br /><br />Many Thanks.
								<br /><br />NB: You can access the system by following link below
								<br /><br /><b>http://www.nascop.org/cd4Poc/login</b>
								<br /><br />CD4 Support Team
								<br /><br />--
								<br /><br />Please do NOT reply to this message as it is sent from an unattended mailbox.";

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

	die;
	// delete_files($this->config->item('server_root').'assets/weekly_email_national/');//delete the files
	// delete_files($this->config->item('server_root').'assets/weekly_email_county/');//delete the files
	// delete_files($this->config->item('server_root').'assets/weekly_email_partner/');//delete the files

}
/* |==================== Weekly Email function END =================| */	
	
}/* End of file send_mail.php */
/* Location: ./application/modules/poc/controller/send_mail.php */