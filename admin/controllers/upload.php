<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class upload extends MY_Controller {

	public $data = array();

	function __construct() {

		parent::__construct();
		$this -> load -> library('PHPexcel');
		ini_set('memory_size', '2048M');

		$this->data['content_view'] 	= 	"admin/upload_view";
		$this->data['title'] 			= 	"Uploads";
		$this->data['sidebar']			= 	"admin/sidebar_view";
		$this->data['posted']			=	0;
		$this->data['filter']			=	false;

		$this->data		=	array_merge($this->data,$this->load_libraries(array("dataTables", "admin_uploads")));

		$this->load->model('admin_model');

		$this->data['uploads'] = 	$this->admin_model->get_Upload_details($this->session->userdata("user_group_id"),$this->session->userdata("user_filter_used"));
		$this->data['errors_agg'] = $this->admin_model->errors_reported();
		$this->data['menus']	= 	$this->admin_model->menus(10);
		//$this->data['devices_not_reported'] = $this->admin_model->devices_not_reported();

		$this->data['sheet_data']		=	"";
		$this->data['upload_data']		=	array();

		$this->load->module('uploads');

	}
	public function index(){	

		$this -> template($this->data);
	}

	public function file_upload(){

		$this->login_reroute(array(1,2));

		$this->data['uploads'] = 	$this->admin_model->get_Upload_details($this->session->userdata("user_group_id"),$this->session->userdata("user_filter_used"));
		
		
		$arr 	=	array();

		if($_FILES['file_1']){
			if(substr($_FILES['file_1']['name'], -3) == "slk"){
			// echo "slk";
				$arr 		= 	$this->uploads->read_slk($_FILES['file_1']['tmp_name'],false);
				$this->data['upload_data']	=	$arr["upload_data"];
				$this->data['sheet_data']	=	$arr["sheet_data"];
				$this->data['posted']			=	1;
			}elseif(substr($_FILES['file_1']['name'], -3) == "csv"){
			// echo  "csv";
				$arr		=	$this->uploads->read_csv($_FILES['file_1']['tmp_name'],false);
				$this->data['upload_data']	=	$arr["upload_data"];
				$this->data['sheet_data']	=	$arr["sheet_data"];
				$this->data['posted']			=	1;
			}else{
				$this->data['message']= "<div class='error'>Format Not Allowed</div>";
			}
		}else{
			redirect("poc/upload");
		}

		$this -> template($this->data);		
	}

}