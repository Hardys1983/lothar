<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	const IMAGE_WIDTH 	= 128;
	const IMAGE_HEIGHT 	= 128;
	
	function __construct(){
        parent::__construct();
        
        if($this->session->userdata("role_id") != '0'){
        	redirect("Login/index");
        }else{
	        $this->load->model("Cell_phone_company_model", 'cell_phone_company');
	        $this->load->model("Picture_model", 'picture');
	        $this->load->model("Person_model" , 'person');
	        $this->load->model("Role_model"   , 'role');
	        
	        
	        $this->init_form_validation();
        }
    }
	
    function index(){
    	$users = $this->person->get_all();
    	foreach ($users as $user){
    		$user->cell_phone_co = $this->cell_phone_company->get_by_id($user->cell_phone_company_id)->company_name;	
    		$user->image = $this->picture->get_by_id($user->picture_id);
    		
    		if($user->image != NULL){
    			$user->image = base_url($user->image->picture_url);
    		}else{
    			$user->image = "No Image"; //TODO: Poner imagen por defecto
    		}
    	}
    	
    	$this->load_view_admin("user/index", ['users' => $users]);
    }
    
    function add(){
    	$roles        = [];
    	$current_role = $this->session->userdata('role_id') ?: 0; //TODO: Por defecto escojo 0
    	
    	foreach ($this->role->get_all() as $role){
    		if( $current_role == 0 ){
    			$roles[] = $role;
    		}
    		else
    		if( $current_role < $role->role_id ){
    			$roles[] = $role;
    		}	
    	}
    	
    	$this->load_view_admin("user/add", ['cell_companies' => $this->cell_phone_company->get_all(), 'roles' => $roles]);
    }
    
    function update($user_id = 0){
    	//if($user_id == "assets")return;
    	$user = $this->person->get_by_id($user_id);
    	if($user){
    		$this->load_view_admin("user/update", ['user' => $user, 'cell_companies' => $this->cell_phone_company->get_all()]);
    		return;
    	}else{
    		$this->load->view("errors/error_404");
    		return;
    	}
    }
    
    function update_execute(){
    	$user_id 	= $this->input->post('user_id');
    	
    	$name  		= $this->input->post('name');
    	$ci    		= $this->input->post('ci');
    	$addr  		= $this->input->post('address');
    	$email 		= $this->input->post('email');
    	$phone 		= $this->input->post('phone');
    	$cell_co 	= $this->input->post('cell_phone_company');
    	$cell_ph    = $this->input->post('cell_phone');
    	
    	$this->form_validation->set_rules('name'		, translate('name')		 , 'trim|required|min_length[5]|max_length[64]');
    	$this->form_validation->set_rules('ci'			, translate('ci')		 , 'required|numeric|exact_length[10]');
    	$this->form_validation->set_rules('address'		, translate('address')	 , 'trim|required|min_length[5]|max_length[128]');
    	$this->form_validation->set_rules('email'		, translate('email')	 , 'required|valid_email');
    	$this->form_validation->set_rules('phone'		, translate('phone')	 , 'required|numeric|min_length[5]|max_length[24]');
    	$this->form_validation->set_rules('cell_phone'	, translate('cell_phone'), 'required|numeric|min_length[5]|max_length[24]');
    
    	
    	$emails = $this->person->get_all(['email' => $email]);
    	if( $emails && $emails[0]->person_id != $user_id ){
    		$this->response->set_message(translate('user_email_duplicated'), ResponseMessage::ERROR);
    		redirect("user/update/$user_id");
    		return;
    	}
    	
    	$cis = $this->person->get_all(['ci' => $ci]);
    	if( $cis && $cis[0]->person_id != $user_id ){
    		$this->response->set_message(translate('ci_duplicated'), ResponseMessage::ERROR);
    		redirect("user/update/$user_id");
    		return;
    	}
    	
    	$picture_id = 0;
    	if( $_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE ){
    		$result = save_image_from_post('picture', './uploads/user', time(), self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
    		if($result[0]){
    			$picture_id = $this->picture->create(['picture_url' => $result[1]]); 
    		}else{
    			$this->response->set_message($result[1], ResponseMessage::ERROR);
    			redirect("user/update/$user_id");
    		}		
    	}
    		
    	
    	if($cell_co == -1){
    		$this->response->set_message(translate('select_telephone_co'), ResponseMessage::ERROR);
    		redirect("user/update/$user_id");
    		return;
    	}else
    	if ($this->form_validation->run() == FALSE) {
    		$this->response->set_message(validation_errors(), ResponseMessage::ERROR);
    		redirect("user/update/$user_id");
    		return;
    	}
    	
    	$data = [	'name'  	 => $name,
			    	'ci'  		 => $ci,
			    	'address' 	 => $addr,
			    	'email' 	 => $email,
			    	'phone' 	 => $phone,
			    	'cell_phone' => $cell_ph,
			    	'cell_phone_company_id' => $cell_co, 'role_id' => 2];    
    	
    	if($picture_id){
    		$data['picture_id'] = $picture_id; 
    	}

    	$this->person->update($user_id, $data);
    	$this->response->set_message( translate('user_updated'), ResponseMessage::SUCCESS);
    	redirect("user/index", "location", 301);
    }
    
    function add_execute(){
    	$name  		= $this->input->post('name');
    	$ci    		= $this->input->post('ci');
    	$addr  		= $this->input->post('address');
    	$email 		= $this->input->post('email');
    	$phone 		= $this->input->post('phone');
    	$cell_co 	= $this->input->post('cell_phone_company');
    	$cell_ph    = $this->input->post('cell_phone');
    	$user_role  = $this->input->post('user_role');
    	$password   = $this->input->post('password');
    	
    	$this->form_validation->set_rules('name'		, translate('name')		 , 'trim|required|min_length[5]|max_length[64]');
    	$this->form_validation->set_rules('ci'			, translate('ci')		 , 'required|numeric|exact_length[10]');
    	$this->form_validation->set_rules('address'		, translate('address')	 , 'trim|required|min_length[5]|max_length[128]');
    	$this->form_validation->set_rules('email'		, translate('email')	 , 'required|valid_email');
    	$this->form_validation->set_rules('phone'		, translate('phone')	 , 'required|numeric|min_length[5]|max_length[24]');
    	$this->form_validation->set_rules('cell_phone'	, translate('cell_phone'), 'required|numeric|min_length[5]|max_length[24]');
    	$this->form_validation->set_rules('password'		, translate('password'), 'required');
    	$this->form_validation->set_rules('repeat_password'	, translate('repeat_password'), 'required|matches[password]');
    	
    	$result = save_image_from_post('picture', './uploads/user', time(), self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
    	
    	if($result[0] == FALSE){
    		$this->response->set_message($result[1], ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}else
    	if($cell_co == -1){
    		$this->response->set_message(translate('select_telephone_co'), ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}else
    	if($user_role == -1){
    		$this->response->set_message(translate('select_role'), ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}
    	else
    	if ($this->form_validation->run() == FALSE) {
    		$this->response->set_message(validation_errors(), ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}else
    	if( $this->person->get_all(['email' => $email])){
    		$this->response->set_message(translate('user_email_duplicated'), ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}
    	else
    	if( $this->person->get_all( ['ci' => $ci] ) ){
    		$this->response->set_message(translate('ci_duplicated'), ResponseMessage::ERROR);
    		$this->add();
    		return;
    	}
    	
    	$data = [	'name'  	 => $name,  
    				'ci'  		 => $ci,  
    				'address' 	 => $addr,  
    				'email' 	 => $email, 
    				'phone' 	 => $phone, 
	    	 		'cell_phone' => $cell_ph, 
	    	 		'role_id'    => $user_role,
	   				'admission_date' 		=> date('Y-m-d'), 
	   				'cell_phone_company_id' => $cell_co, 
	   				'role_id' => $user_role,
	    			'picture_id' 			=> $this->picture->create(['picture_url' => $result[1]]),
    				'password' => md5($password)
    			];
	    
    	$this->person->create($data);
    	$this->response->set_message( translate('user_added'), ResponseMessage::SUCCESS);
    	redirect("user/index", "location", 301);
    }
    
    function erase($user_id = 0){
    	$user = $this->person->get_by_id($user_id);
    	if($user){
    		$affected_rows = $this->person->delete($user_id);
    		if($affected_rows){
    			$this->response->set_message( sprintf( translate('client_success_erased'), $user->name), ResponseMessage::SUCCESS);
    			redirect("user/index");
    			return;
    		}
    	}
    	$this->load->view("errors/error_404");		
    }
}
