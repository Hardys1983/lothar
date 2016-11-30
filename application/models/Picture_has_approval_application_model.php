<?php
class Picture_has_approval_application_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('picture_picture_id', $data['picture_picture_id']);
		$this->db->set('approval_application_approval_application_id', $data['approval_application_approval_application_id']);
		$this->db->insert('picture_has_approval_application');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('picture_picture_id', $id);
		$this->db->where('approval_application_approval_application_id', $id);
		$query = $this->db->get('picture_has_approval_application');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('picture_has_approval_application');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('picture_picture_id', $id);
		$this->db->where('approval_application_approval_application_id', $id);
		$this->db->update('picture_has_approval_application');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('picture_picture_id', $id);
		$this->db->where('approval_application_approval_application_id', $id);
		$this->db->delete('picture_has_approval_application');

		return $this->db->affected_rows();
	}

}