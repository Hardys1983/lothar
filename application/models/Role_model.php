<?php
class Role_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('role_name', $data['role_name']);
		$this->db->insert('role');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('role_id', $id);
		$query = $this->db->get('role');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('role');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('role_id', $id);
		if($data['role_name'])
			$this->db->set('role_name', $data['role_name']);
		$this->db->update('role');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('role_id', $id);
		$this->db->delete('role');

		return $this->db->affected_rows();
	}

}