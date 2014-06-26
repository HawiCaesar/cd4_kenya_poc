<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class equipment extends MY_Controller {

	public function index(){

		$this->home_page();
	}

	public function home_page() {
		$this->login_reroute(array(1,2));
		$data['content_view'] = "admin/equipment_view";
		$data['title'] = "Equipment";
		$data['sidebar']	= "admin/sidebar_view";
		$data['filter']	=	false;
		$data	=array_merge($data,$this->load_libraries(array('dataTables','admin_equipment')));		
		$this->load->model('admin_model');
		$data['menus']	= 	$this->admin_model->menus(3);
		//$data['devices_not_reported'] = $this->admin_model->devices_not_reported();		
		//$data['errors_agg'] = $this->admin_model->errors_reported();		
		$data['equipments'] = 	$this->admin_model->get_details("equipment_details",$this->session->userdata("user_filter_used"));
		//$data['failed_uploads']	=	$this->admin_model->failed_upload();
		$data['equipment_1']	=	R::getAll("SELECT `equipment`.*,`equipment_category`.`description` AS `category_desc`, `equipment_category`.`id` AS `equipment_category_id` FROM `equipment` LEFT JOIN `equipment_category` ON `equipment_category`.`id`=`equipment`.`category` ");
		//$data['partnerfac']=R::getAll("SELECT f.name,p.* FROM facility f, partner p WHERE f.partnerID = p.ID");
		$data['equipment_category']	=	R::getAll("SELECT * FROM `equipment_category` ");	
		$data['facilities'] = 	$this->admin_model->get_details("facility_details",0);
		//$data['county']=$this->getcountydetails();
		//$data['partner']=$this->getpartnerdetails();
		$this -> template($data);
	}
	public function save_fac_equip(){

		$cat 			=	$this->input->post("cat");
		$eq 			=	(int) $this->input->post("equipment");
		$fac 			=	(int) $this->input->post("fac");
		$partner    	=	(int) $this->input->post("partners");
		$assgn      	=	$this->input->post("assign");
		$county     	=	(int) $this->input->post("cnty");
		$equipmentsrl   =	$this->input->post("equipserial");
		$printersrl     =	$this->input->post("prtserial");
		
		$last_eq_auto_id_res	=	R::getAll("SELECT `id` FROM `facility_equipment` ORDER BY `id` DESC LIMIT 1");		
		$next_eq_auto_id=1;
		if(sizeof($last_eq_auto_id_res)>0){
			$next_eq_auto_id		=	$last_eq_auto_id_res[0]['id']+1;
		}else{
			$next_eq_auto_id=1;
		}

		$this->db->trans_begin();
		$this->db->query("INSERT INTO `facility_equipment` 
								(
									`id`,
									`facility_id`,
									`equipment_id`,
									`status`
								) 
								VALUES(
										'$next_eq_auto_id',
										'$fac',
										'$eq',
										'1'
									)
								"
			);

		if($eq==4){
			$this->db->query("INSERT INTO `facility_pima` 
									(
										`facility_equipment_id`,
										`serial_num`,
										`printer_serial`
									) 
									VALUES(
											'$next_eq_auto_id',
											'$equipmentsrl',
											'$printersrl'	
										)
									"
				);

		}
		if ($this->db->trans_status() === FALSE ){
		    $this->db->trans_rollback();
		}
		else{
		    $this->db->trans_commit();
		}

		$this->home_page();
	}
	public function save_equip(){

		$cat 		=	(int) $this->input->post("cat1");
		$eq 		=	$this->input->post("eq1");

		$this->db->query("INSERT INTO `equipment` 
								(
									`description`,
									`category`,
									`status`
								) 
								VALUES(
										'$eq',
										'$cat',
										'0'
									)
								"
			);

		$this->home_page();
	}
	public function save_cat(){

		$cat 		=	$this->input->post("cat2");

		$this->db->query("INSERT INTO `equipment_category` 
								(
									`description`,
									`flag`
								) 
								VALUES(
										'$cat',
										'0'
									)
								"
			);

		$this->home_page();
	}
	public function getpimadetails(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["pimadetails"];
	    $data=R::getAll($sql);;
		
		return $data;
	    }
	/*public function getpartnerdetails(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["partner"];
	    $data=R::getAll($sql);;
		
		return $data;
	    }
	public function getcountydetails(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["county"];
	    $data=R::getAll($sql);;
		
		return $data;
	    }*/
	  public function getpartnerfacility(){
		
		$preset_sql = $this->config->item("preset_sql");

		$sql 	=	$preset_sql["county"];
	    $data=R::getAll($sql);;
		
		return $data;
	    }  
}

/* End of file equipment.php */
/* Location: ./application/modules/admin/controller/equipment.php */