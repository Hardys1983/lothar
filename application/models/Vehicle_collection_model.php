<?php
class Vehicle_collection_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_all()
	{
		$query = $this->db->get('vehicle_model_year');
		return $query->result();
	}
	
	function find($maker, $model, $year){
		$query = $this->db->get_where('vehicle_model_year', ['make' => $maker, 'model' => $model, 'year' => $year] );

		if($query->num_rows() == 0){
			return FALSE;
		}else{
			return $query->row()->id;
		}
	}
	
	function get_by_id($vehicle_model_id){
		$query = $this->db->get_where('vehicle_model_year', ['id' => $vehicle_model_id] );
		
		if($query->num_rows() == 0){
			return FALSE;
		}else{
			return $query->row();
		}
	}
	
	function get_printable($vehicle_model){
		return $vehicle_model->make."-".$vehicle_model->model."-".$vehicle_model->year;
	}
	
	
}