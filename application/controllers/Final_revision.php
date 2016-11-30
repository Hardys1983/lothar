<?php

class Final_revision extends CI_Controller{
	public function __construct(){
		
		parent::__construct();
		if($this->session->userdata("role_id") != '0'){
			redirect("Login/index");
			return;
		}

		$this->load->model("Person_model", 'person');
		$this->load->model("Operation_model" , 'operation');
		$this->load->model("Operation_type_model" , 'operation_type');
		$this->load->model("Vehicle_model", 'vehicle');
		$this->load->model("Vehicle_collection_model", 'vehicle_collection');
		$this->load->model("Work_order_model", "work_order");
		$this->load->model("Picture_model", "picture");
		$this->load->model("Work_order_damage_point_model", "Work_order_damage_point");
		$this->load->model('Final_revision_model', 'Final_revision');
		
		$this->init_form_validation();
	}
	
	function add($work_order_id = 0){
		$work_order = $this->work_order->get_by_id($work_order_id);
		if($work_order){
			$person 	= $this->person->get_by_id($this->session->userdata('person_id'));
			$revision 	= $this->Final_revision->get_all(['work_order_id' => $work_order_id], TRUE);
			
			$this->load_view_admin('final_revision/add', ['person' => $person->name,  'work_order' => $work_order, 'revision' => $revision]);
		}else{
			$this->load->view("errors/error_404");
		}
	}
	
	function add_execute(){
		$km   			= $this->input->post('km');
		$fuel 			= $this->input->post('fuel_level');
		$abc  			= $this->input->post('abc');
		$day  			= date("Y-m-d");
		$person_id 		= $this->session->userdata('person_id');
		$work_order_id 	= $this->input->post("work_order_id");
		
		$errors = [];
		if($fuel == '-1'){
			$errors[] = translate('select_fuel_level');
		}
		
		if($km < 0){
			$errors[] = translate('invalid_km');
		}
		
		if( count($errors) ){
			$this->response->set_message( $errors, ResponseMessage::ERROR);
			redirect("Final_revision/add/$work_order_id");
		}else{
			if( $abc ){
				$abc = '1';
			}else{
				$abc = '0';
			}
			
			$data = [	'total_km' 			=> $km,
						'fuel_level' 		=> $fuel,
						'day' 				=> $day,
						'abc' 				=> $abc,
						'person_person_id' 	=> $person_id,
						'work_order_id' 	=> $work_order_id ];
			
			$revision 	= $this->Final_revision->get_all(['work_order_id' => $work_order_id], TRUE);
			if($revision){
				$this->Final_revision->update($revision->final_revision_id, $data);
			}else{
				$this->Final_revision->create($data);
			}
			
			$this->work_order->update($work_order_id, ['closed' => '1']);
			
			$this->response->set_message( translate('final_revision_finished'), ResponseMessage::SUCCESS);
			redirect('Vehicular_reception/index');
		}
	}
}