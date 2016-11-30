<?php
class Service_evaluation_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('description', $data['description']);
		$this->db->set('evaluation', $data['evaluation']);
		$this->db->set('day', $data['day']);
		$this->db->set('work_order_id', $data['work_order_id']);
		$this->db->insert('service_evaluation');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('service_evaluation_id', $id);
		$this->db->where('work_order_id', $id);
		$query = $this->db->get('service_evaluation');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('service_evaluation');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('service_evaluation_id', $id);
		if($data['description'])
			$this->db->set('description', $data['description']);
		if($data['evaluation'])
			$this->db->set('evaluation', $data['evaluation']);
		if($data['day'])
			$this->db->set('day', $data['day']);
		$this->db->where('work_order_id', $id);
		$this->db->update('service_evaluation');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('service_evaluation_id', $id);
		$this->db->where('work_order_id', $id);
		$this->db->delete('service_evaluation');

		return $this->db->affected_rows();
	}

}