<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {
	
	function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->helper('mabuya');
        
        if($this->session->userdata("role_id") != '0'){
        	redirect("Login/index");
        }else{
	        $this->load->model("Person_model", "person");
	        $this->load->model("Vehicle_model", "vehicle");
	        $this->load->model("Vehicle_collection_model", "vehicle_collection");
        }
	}
	
    function index(){
    	$data = ['users' => $this->person->get_all(['role_id' => '2'])];
    	$this->load_view_admin("owner/index", $data);
    }
    
    function get_by_owner(){
    	$owner_id   = $this->input->post('owner_id');
    	$cars 		= $this->vehicle->get_by_owner($owner_id);
		
		foreach($cars as $car){
			$model = $this->vehicle_collection->get_by_id($car->vehicle_model_id);
			if($model){
				$car->vehicle_model = $this->vehicle_collection->get_printable($model);
			}else{
				$car->vehicle_model = "Unknow model";
			}
    	}
    	
    	$data = ['users' => $this->person->get_all(), 'cars' => $cars, 'owner_id' => $owner_id];
    	$this->load_view_admin("owner/index", $data);
    }
    
    function toggle(){
    	$vehicle_id = $this->input->post('vehicle_id');
    	$owner_id   = $this->input->post('owner_id');
    	
    	$vehicle = $this->vehicle->get_by_id($vehicle_id);
    	
    	if($vehicle){
    		if( $vehicle->owner_id != NULL ){
    			$owner_id = NULL;
    		}
    		$this->vehicle->update( $vehicle_id, ['owner_id' => $owner_id] );
    	}
    }
}
