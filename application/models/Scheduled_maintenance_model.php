<?php
class Scheduled_maintenance_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('vehicle_id', $data['vehicle_id']);
		$this->db->set('total_km', $data['total_km']);
		$this->db->set('last_maintenance_day', $data['last_maintenance_day']);
		$this->db->set('next_upkeep_km', $data['next_upkeep_km']);
		$this->db->set('next_maintenance_day', $data['next_maintenance_day']);
		$this->db->set('hours', $data['hours']);
		$this->db->insert('scheduled_maintenance');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('scheduled_maintenance_id', $id);
		$query = $this->db->get('scheduled_maintenance');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('scheduled_maintenance');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('scheduled_maintenance_id', $id);
		if($data['vehicle_id'])
			$this->db->set('vehicle_id', $data['vehicle_id']);
		if($data['total_km'])
			$this->db->set('total_km', $data['total_km']);
		if($data['last_maintenance_day'])
			$this->db->set('last_maintenance_day', $data['last_maintenance_day']);
		if($data['next_upkeep_km'])
			$this->db->set('next_upkeep_km', $data['next_upkeep_km']);
		if($data['next_maintenance_day'])
			$this->db->set('next_maintenance_day', $data['next_maintenance_day']);
		if($data['hours'])
			$this->db->set('hours', $data['hours']);
		$this->db->update('scheduled_maintenance');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('scheduled_maintenance_id', $id);
		$this->db->delete('scheduled_maintenance');

		return $this->db->affected_rows();
	}

}