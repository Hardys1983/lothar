<?php
class Operation_type_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('comment', $data['comment']);
		$this->db->insert('operation_type');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('operation_type_id', $id);
		$query = $this->db->get('operation_type');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('operation_type');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('operation_type_id', $id);
		if($data['comment'])
			$this->db->set('comment', $data['comment']);
		$this->db->update('operation_type');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('operation_type_id', $id);
		$this->db->delete('operation_type');

		return $this->db->affected_rows();
	}

}