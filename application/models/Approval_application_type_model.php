<?php
class Approval_application_type_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('state', $data['state']);
		$this->db->insert('approval_application_type');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('approval_application_type', $id);
		$query = $this->db->get('approval_application_type');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('approval_application_type');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('approval_application_type', $id);
		if($data['state'])
			$this->db->set('state', $data['state']);
		$this->db->update('approval_application_type');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('approval_application_type', $id);
		$this->db->delete('approval_application_type');

		return $this->db->affected_rows();
	}

}