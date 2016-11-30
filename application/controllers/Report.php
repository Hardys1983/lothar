<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(['url','form']);
		$this->load->helper('mabuya');
		
		$this->load->model("Operation_model", "operation");
		$this->load->model("Operation_type_model", "operation_type");
		$this->load->model("Person_model", "person");
		$this->load->model("Work_order_model", "work_order");
		
	}

	function add_operation_data($operations){
		foreach($operations as $op){
			$type 	= $this->operation_type->get_by_id($op->operation_type_id);
			$work 	= $this->work_order->get_by_id($op->work_order_id); 
			$person = $this->person->get_by_id($op->person_id);
			
			$op->operation_type = $type->comment;
			$op->person 		= $person->name;
		}
	}
	
	function open_activities(){
		$operations = $this->operation->get_all(['time_user' => 'is NULL']);
		$this->add_operation_data($operations);
		$this->load_view_admin("report/open_activities", ['activities' => $operations]);
	}
}