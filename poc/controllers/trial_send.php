<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class trial_send extends MY_Controller {

		function trial()
		{
			$this->load->config->item('email');

			$this->email->from('Server', 'CD4Poc@nascop.org');
			$this->email->to('brianhawi92@gmail.com');//send to specific receiver
			//$this->email->bcc($CHAI_team);//CHAI team
			
			$this->email->subject('Server Has Sent Email'); //subject


			$message="Trial From the server";

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

}

?>