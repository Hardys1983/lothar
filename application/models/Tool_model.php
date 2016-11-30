<?php
class Tool_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('tool_name', $data['tool_name']);
		$this->db->set('work_order_id', $data['work_order_id']);
		$this->db->insert('tool');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('tool_id', $id);
		$query = $this->db->get('tool');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('tool');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('tool_id', $id);
		if($data['tool_name'])
			$this->db->set('tool_name', $data['tool_name']);
		if($data['work_order_id'])
			$this->db->set('work_order_id', $data['work_order_id']);
		$this->db->update('tool');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('tool_id', $id);
		$this->db->delete('tool');

		return $this->db->affected_rows();
	}

}