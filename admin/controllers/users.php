<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class users extends MY_Controller {

	public function index(){

		$this->home_page();
	}

	public function home_page() {
		$data['fac']=$this->getfacilitydetails();
		$data['subcounty']=$this->getsubcountydetails();
		$data['county']=$this->getcountydetails();
		$data['partner']=$this->getpartnerdetails();
		$data['usertype']=$this->getusertype();
		//$data['userlog']=$this->getuseraccesslog();
		
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/users_view";
		$data['title'] = "Users";
		$data['sidebar']	= "admin/sidebar_view";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('dataTables','admin_users','user_profile')));
		
		$this->load->model('admin_model');

		$users=1;

		if($users==1)
		{
			$data['number_of_deactivated_users']=$this->admin_model->deactivated_users_count(); //get the number of deactivated users
		}else
		{
			$data['number_of_deactivated_users']="none";
		}


        //$data['facility'] = $this->poc_model->get_details("fac_details");
		$data['menus']	= 	$this->admin_model->menus(4);		
		$data['users'] = 	$this->admin_model->get_details("user_details",$this->session->userdata("user_filter_used"));
		
		
		$this -> template($data);
	}

	function deactivated_users_page()
	{
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/deactivated_users_view";
		$data['title'] = "Deactivated Users";
		$data['sidebar']	= "admin/sidebar_view";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('dataTables','admin_users')));
		
		$this->load->model('admin_model');

		$users=1;

		if($users==1)
		{
			$data['number_of_deactivated_users']=$this->admin_model->deactivated_users_count(); //get the number of deactivated users
		}else
		{
			$data['number_of_deactivated_users']="none";
		}

		$data['menus']	= 	$this->admin_model->menus(4);		
		$data['users'] = 	$this->admin_model->deactivated_users();
		
		
		$this -> template($data);
	}
	function deactivate() //deactivate user
	{
		$id=$this->input->post('user_id');
		$users_name=$this->input->post('users_name');

		$deactive_value=array('status'=>0);

		$this->db->where('id',$id);
		$this->db->update('user',$deactive_value);

		echo '<div class="success">You have successfully Deactivated '.$users_name.'</div>';
	}
	function activate() //deactivate user
	{
		$id=$this->input->post('user_id');
		$users_name=$this->input->post('users_name');

		$Active_value=array('status'=>1);

		$this->db->where('id',$id);
		$this->db->update('user',$Active_value);

		echo '<div class="success">You have successfully Activated '.$users_name.'</div>';
	}
	function reset_password() //reset password
	{
		$id=$this->input->post('user_id');
		$users_name=$this->input->post('users_name');

		$pass=$this->encrypt(123456);
		$reset=array('password'=>$pass);

		$this->db->where('id',$id);
		$this->db->update('user',$reset);
		
		echo '<div class="success">You have successfully reset the password for '.$users_name.'</div>';

	}
	function update_profile()
	{
		$this->form_validation->set_rules('name','Full Names','trim|required|xss_clean|');
		$this->form_validation->set_rules('phone','Telephone Number','trim|required|alpha_dash|xss_clean');		
		$this->form_validation->set_rules('email','E-mail Address','trim|required|valid_email|xss_clean');		

		if($this->form_validation->run()==FALSE){
			$this->home_page();
		}else{
			$user['id']	=	$this->input->post('user_id');
			$user['name']=$this->input->post('name');
			$user['phone']=$this->input->post('phone');
			$user['email']=$this->input->post('email');
			$this->profile_update($user);
			echo '<div class="success" style="margin:3px;border-radius:2px;">The details for '.$user['name'].' have been updated</div>';
		}
	}
	private function profile_update($user = array()){
		$sql = "UPDATE `user` SET 
					`name`	=	'".$user['name']."',
					`phone`	=	'".$user['phone']."',
					`email`	=	'".$user['email']."'

					WHERE `id`	=	'".$user['id']."'
				";
		$this->db->query($sql);
	}
	
	public function getfacilitydetails(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["fac"];
	    $data=R::getAll($sql);
		
		return $data;
	    }
	
	public function getsubcountydetails(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["subcounty"];
	    $data=R::getAll($sql);
		
		return $data;
	    }
	public function getcountydetails(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["county"];
	    $data=R::getAll($sql);;
		
		return $data;
	    }
	public function getpartnerdetails(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["partner"];
	    $data=R::getAll($sql);
		
		return $data;
	    }
	public function getusertype(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["usertype"];
	    $data=R::getAll($sql);
		
		return $data;
	    }
	/*public function getuseraccesslog(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["userlog"];
	    $data=R::getAll($sql);;
		
		return $data;
	    }*/
	
	public function save_user_details(){
		
		$last_user_auto_id_res	=	R::getAll("SELECT `id` FROM `user` ORDER BY `id` DESC LIMIT 1");
		$next_user_auto_id=1;
		
		if(sizeof($last_user_auto_id_res)>0){
				$next_user_auto_id		=	$last_user_auto_id_res[0]['id']+1;
			}else{
				$next_user_auto_id=1;
			}
		
		$this->db->trans_begin();
		
		$name=$this->input->post('name');
		$username=$this->input->post('username');
		$email=$this->input->post('email');
		$phone=$this->input->post('phone');
		$usertype=$this->input->post('usertype');
		
		if($usertype==2){
			$password=$this->config->item('default_admin_password');
		}else{
			$password=$this->config->item('default_user_password');	
		}
		$passwordfinal=$this->encrypt($password);
		$facility=$this->input->post('fac');
		$partner=$this->input->post('partn');
		$county=$this->input->post('county');
		$user_log=$this->input->post('userlog');
		$status="1";
		
		if($usertype==2){
			$user_access_log="2";
		}else{
			$user_access_log="3";
		}
		$this->db->query("INSERT INTO `user` 
										(
											`id`,
											`username`,
											`name`,
											`password`,
											`phone`,
											`email`,
											`user_group_id`,
											`user_access_level_id`,
											`status`
											) 
										VALUES
											(
												'$next_user_auto_id',
												'$username',
												'$name',
												'$passwordfinal',
												'$phone',
												'$email',
												'$usertype',
												'$user_access_log',
												'$status'
												
											)");
		if($usertype==3){
			$this->db->query("INSERT INTO `partner_user`(`user_id`,`partner_id`)VALUES
											(
											    '$next_user_auto_id',
												'$partner'
												
											)");	
			
		}elseif($usertype==9){
			$this->db->query("INSERT INTO `region_user`(`region_id`,`user_id`)VALUES
											(
												'$county',
												'$next_user_auto_id'
											)");
				
				
		}elseif($usertype==6){
			$this->db->query("INSERT INTO `facility_user`(`user_id`,`facility_id`)VALUES
											(
											    '$next_user_auto_id',
											    '$facility'	
											)");
				
		}
		
		if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				}
				else{
				    $this->db->trans_commit();
				    $this->home_page();
				    //$view_data['message']= "<div class='success'>You have SUCCESSFULLY added a New User</div>";
		}
	    }
}

/* End of file users.php */
/* Location: ./application/modules/admin/controller/users.php */