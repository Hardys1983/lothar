<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include( APPPATH.'/libraries/phpqrcode/qrlib.php');

class Vehicle extends CI_Controller {

    const IMAGE_WIDTH 	= 600;
    const IMAGE_HEIGHT 	= 400;

	function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->helper('mabuya');
        
        if($this->session->userdata("role_id") != '0'){
        	redirect("Login/index");
        }else{
	        $this->load->model("Vehicle_collection_model", "Vehicle_collection");
	        $this->load->model("Vehicle_model", "vehicle");
	        
	        $this->init_form_validation();
        }
    }
    
    function index(){
    	
    	$vehicles =  $this->vehicle->get_all();
    	foreach($vehicles as $vehicle){
    		$model = $this->Vehicle_collection->get_by_id( $vehicle->vehicle_model_id );
    		$vehicle->vehicle_model = $this->Vehicle_collection->get_printable($model);
    	}
    	
    	$this->load_view_admin("car/index", ['vehicles' => $vehicles]);
    }
    
    function add(){
		$this->load_view_admin("car/add", []);
    }
    
    function update($car_id = 0){
    	$vehicle = $this->vehicle->get_by_id($car_id);
    	if($vehicle){
    		$vehicle->vehicle_model = $this->Vehicle_collection->get_by_id($vehicle->vehicle_model_id);
    		$vehicle->vehicle_model = $this->Vehicle_collection->get_printable($vehicle->vehicle_model);
    		$this->load_view_admin("car/update", ['car' => $vehicle ]);
    	}else{
    		$this->load->view("errors/error_404");
    	}
    }
    
    function update_execute(){
    	$vehicle_model 		= $this->input->post('vehicle_model');
    	$chassis_number 	= $this->input->post('chassis_number');
    	$engine_number 		= $this->input->post('engine_number');
    	$plate_number		= $this->input->post('plate_number');
    	$total_km 			= $this->input->post('total_km');
    	$color 				= $this->input->post('color');
    	$vehicle_id			= $this->input->post('vehicle_id');

    	//$this->form_validation->set_rules('chassis_number'	, translate('chassis_number'), 'required|numeric|exact_length[10]|is_unique[vehicle.chassis_number]');
    	$this->form_validation->set_rules('engine_number'	, translate('engine_number') , 'trim|required|min_length[5]|max_length[24]');
    	$this->form_validation->set_rules('plate_number'	, translate('plate_number')	 , 'trim|required|min_length[5]|max_length[24]');
    	$this->form_validation->set_rules('total_km'		, translate('total_km')	 	 , 'required|numeric');

		foreach($this->vehicle->get_all(['plate_number' => $plate_number]) as $p){
			if($p->plate_number == $plate_number && $p->vehicle_id != $vehicle_id){
				$this->response->set_message(translate("plate_number_duplicated"), ResponseMessage::ERROR);
				redirect("Vehicle/update/$vehicle_id");
			}
		}
    	
		foreach($this->vehicle->get_all(['engine_number' => $engine_number]) as $v){
			if($v->engine_number == $engine_number && $v->vehicle_id != $vehicle_id){
				$this->response->set_message(translate("engine_number_duplicated"), ResponseMessage::ERROR);
				redirect("Vehicle/update/$vehicle_id");
			}
		}
		
    	$tokens = explode('-', $vehicle_model);
    	if( count($tokens) < 3 ){
    		$this->response->set_message(translate("please_select_car_model"), ResponseMessage::ERROR);
    		redirect("Vehicle/update/$vehicle_id");
    		return;
    	}
    	
    	$maker = $tokens[0];
    	$year  = $tokens[ count($tokens) - 1];
    	$model = "";
    	
    	for($i = 1; $i < count($tokens) - 1; ++$i){
    		if($i > 1){
    			$model.= '-'.$tokens[$i];
    		}else{
    			$model.= ''.$tokens[$i];
    		}
    	}
    	 
    	$vehicle_model_id = $this->Vehicle_collection->find($maker, $model, $year);
    	if( $vehicle_model_id == FALSE){
    		$this->response->set_message(translate("please_select_car_model"), ResponseMessage::ERROR);
    		redirect("Vehicle/update/$vehicle_id");
    		return;
    	}
    	 
    	if ($this->form_validation->run() == FALSE) {
    		$this->response->set_message(validation_errors(), ResponseMessage::ERROR);
    		redirect("Vehicle/update/$vehicle_id");
    		return;
    	}
    	
    	$data = [	'chassis_number' 	=> $chassis_number,
			    	'engine_number'	 	=> $engine_number,
			    	'plate_number'	 	=> $plate_number,
			    	'color'			 	=> $color,
			    	'total_km'		 	=> $total_km,
			    	'vehicle_model_id' 	=> $vehicle_model_id,
    	];
    	
    	$this->vehicle->update($vehicle_id, $data);
    	$this->response->set_message(translate("vehicle_updated"), ResponseMessage::SUCCESS);
    	redirect("Vehicle/index");
    	
    }
    
    function erase($car_id = 0){
    	$vehicle = $this->vehicle->get_by_id($car_id);
    	if($vehicle){
    		$affected_rows = $this->vehicle->delete($car_id);
    		if($affected_rows){
    			$this->response->set_message( translate('vehicle_success_erased'), ResponseMessage::SUCCESS);
    			redirect("vehicle/index");
    			return;
    		}
    	}else{
    		$this->load->view("errors/error_404");
    	}
    }
    
    function get_car_model($vehicle_model){
    	$tokens = explode('-', $vehicle_model);
    	if( count($tokens) < 3 ){
    		return FALSE;
    	}

    	$maker = $tokens[0];
    	$year  = $tokens[ count($tokens) - 1];
    	$model = "";
    	 
    	for($i = 1; $i < count($tokens) - 1; ++$i){
    		if($i > 1){
    			$model.= '-'.$tokens[$i];
    		}else{
    			$model.= ''.$tokens[$i];
    		}
    	}
	
    	return [$maker, $model, $year];
    }
    
    function add_execute(){
    	$vehicle_model 		= $this->input->post('vehicle_model');
    	$chassis_number 	= $this->input->post('chassis_number');
    	$engine_number 		= $this->input->post('engine_number');
    	$plate_number		= $this->input->post('plate_number');
    	$total_km 			= $this->input->post('total_km');
    	$color 				= $this->input->post('color');
    	
    	
    	$this->form_validation->set_rules('chassis_number'	, translate('chassis_number'), 'required|numeric|exact_length[10]|is_unique[vehicle.chassis_number]');
    	$this->form_validation->set_rules('engine_number'	, translate('engine_number') , 'trim|required|min_length[5]|max_length[24]|is_unique[vehicle.engine_number]');
    	$this->form_validation->set_rules('plate_number'	, translate('plate_number')	 , 'trim|required|min_length[5]|max_length[24]|is_unique[vehicle.plate_number]');
    	$this->form_validation->set_rules('total_km'		, translate('total_km')	 	 , 'required|numeric');

    	$result =  $this->get_car_model($vehicle_model);
    	$maker  = "";
    	$model  = "";
    	$year   = "";
    	
    	if($result == FALSE){
    		$this->response->set_message(translate("please_select_car_model"), ResponseMessage::ERROR);
    		return;
    	}else{
    		list($maker, $model, $year) = $result;
    	}
    	
    	$vehicle_model_id = $this->Vehicle_collection->find($maker, $model, $year);
    	if( $vehicle_model_id == FALSE){
    		$this->response->set_message(translate("please_select_car_model"), ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}
    	
    	if ($this->form_validation->run() == FALSE) {
    		$this->response->set_message(validation_errors(), ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}

    	$data = [	'chassis_number' 	=> $chassis_number,
			    	'engine_number'	 	=> $engine_number,
			    	'plate_number'	 	=> $plate_number,
			    	'color'			 	=> $color,
			    	'total_km'		 	=> $total_km,
			    	'vehicle_model_id' 	=> $vehicle_model_id,		
			    ];

    	$vehicle_id = $this->vehicle->create($data);
    	$file_name = "./uploads/car/".time().'.png';
    	QRcode::png($vehicle_id, $file_name);
    	$this->vehicle->update($vehicle_id, ['url_qr' => $file_name]);
    	
    	$this->response->set_message(translate("vehicle_created"), ResponseMessage::SUCCESS);
    	redirect("Vehicle/index");
    }
    
    function get_models(){
    	$all_models = $this->Vehicle_collection->get_all();
    	$models = [];
    	foreach($all_models as $model){
    		$models[] = $this->Vehicle_collection->get_printable($model);
    	}
    	echo json_encode($models);
    }
}
