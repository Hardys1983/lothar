<?php
class Vehicle_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('chassis_number', $data['chassis_number']);
		$this->db->set('engine_number', $data['engine_number']);
		$this->db->set('plate_number', $data['plate_number']);
		$this->db->set('vehicle_model_id', $data['vehicle_model_id']);
		$this->db->set('total_km', $data['total_km']);
		$this->db->set('color', $data['color']);
		
		$this->db->insert('vehicle');

		return $this->db->insert_id();
	}

	function get_by_id($id)
	{
		$this->db->where('vehicle_id', $id);
		$query = $this->db->get('vehicle');

		return $query->row();
	}

	function get_by_owner($owner_id, $accept_null = TRUE){
		
		$this->db->where("owner_id", $owner_id);
		
		if($accept_null){
			$this->db->or_where('owner_id IS NULL', null);
		}
		
		$query = $this->db->get('vehicle');
		return $query->result();
	}
	
	function get_with_owner(){
		$this->db->where('owner_id IS NOT NULL', null);
		$query = $this->db->get('vehicle');
		
		return $query->result();
	}
	
	function get_all($conditions = [])
	{
		foreach ($conditions as $key => $value ){
			$this->db->where($key, $value);
		}
		$query = $this->db->get('vehicle');
		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('vehicle_id', $id);
		foreach($data as $key => $value ){
			$this->db->set($key, $value);
		}
		
		$this->db->update('vehicle');
		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('vehicle_id', $id);
		$this->db->delete('vehicle');

		return $this->db->affected_rows();
	}

}