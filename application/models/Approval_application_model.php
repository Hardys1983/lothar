<?php
class Approval_application_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('description', $data['description']);
		$this->db->set('price', $data['price']);
		$this->db->set('approval_application_type_id', $data['approval_application_type_id']);
		$this->db->set('person_id', $data['person_id']);
		$this->db->set('work_order_id', $data['work_order_id']);
		$this->db->set('estimated_time_hours', $data['estimated_time_hours']);
		$this->db->insert('approval_application');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('approval_application_id', $id);
		$query = $this->db->get('approval_application');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('approval_application');
		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('approval_application_id', $id);
		if($data['description'])
			$this->db->set('description', $data['description']);
		if($data['price'])
			$this->db->set('price', $data['price']);
		if($data['approval_application_type_id'])
			$this->db->set('approval_application_type_id', $data['approval_application_type_id']);
		if($data['person_id'])
			$this->db->set('person_id', $data['person_id']);
		if($data['work_order_id'])
			$this->db->set('work_order_id', $data['work_order_id']);
		if($data['estimated_time_hours'])
			$this->db->set('estimated_time_hours', $data['estimated_time_hours']);
		$this->db->update('approval_application');

		return $this->db->affected_rows();
	}
	
	function delete($id)
	{
		$this->db->where('approval_application_id', $id);
		$this->db->delete('approval_application');

		return $this->db->affected_rows();
	}

}