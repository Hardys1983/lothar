<?php
class Person_has_vehicle_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('person_id', $data['person_id']);
		$this->db->set('vehicle_id', $data['vehicle_id']);
		$this->db->insert('person_has_vehicle');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('person_id', $id);
		$this->db->where('vehicle_id', $id);
		$query = $this->db->get('person_has_vehicle');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('person_has_vehicle');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('person_id', $id);
		$this->db->where('vehicle_id', $id);
		$this->db->update('person_has_vehicle');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('person_id', $id);
		$this->db->where('vehicle_id', $id);
		$this->db->delete('person_has_vehicle');

		return $this->db->affected_rows();
	}

}