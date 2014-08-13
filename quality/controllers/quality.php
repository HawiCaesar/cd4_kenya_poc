<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class quality extends MY_Controller
{
	public function index()
	{
		$this->quality_control_page();
	}

	function quality_control_page()
	{
		$this->login_reroute(array(3,6,8,9)); //login reroute

		$data['content_view'] = "quality/quality_control_view";
		$data['title'] = "Quality Assurance & Control";

		$data['filter']		=	false;
		//$data['sidebar']	= "poc/sidebar_view";
		$data	=array_merge($data,$this->load_libraries(array('dataTables','quality_assurance','fortawesome')));

		$this->load->model('quality_model'); //load quality model

		$user_filter = $this->session -> userdata("user_filter");

		/*if($user_filter)
		{ 
			foreach ($user_filter as $filter) 
			{
				//$data['partner_option']='<option value="3">Show All Data For '.$filter["user_filter_name"].'</option>'; 
				$this->set_user_filter($filter["user_filter_id"]);
			} 
		}*/

		$data['control_count_list']=$this->quality_model->facility_control_tests();

		if($data['control_count_list'])
		{
			$data['check_value']=1;
		}
		else
		{
			$data['check_value']=0;
		}

		$data['menus']	= 	$this->quality_model->menus(7);
		$this -> template($data);
	}
}


?>