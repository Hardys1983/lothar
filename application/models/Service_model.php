<?php
class Service_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('description', $data['description']);
		$this->db->set('state', $data['state']);
		$this->db->set('title', $data['title']);
		$this->db->set('picture_id', $data['picture_id']);
		return $this->db->insert('service');

		//return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('service_id', $id);
		$query = $this->db->get('service');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('service');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('service_id', $id);
		if($data['description'])
			$this->db->set('description', $data['description']);
		if($data['state'])
			$this->db->set('state', $data['state']);
		if($data['title'])
			$this->db->set('title', $data['title']);
		if($data['picture_id'])
			$this->db->set('picture_id', $data['picture_id']);
		$this->db->update('service');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('service_id', $id);
		$this->db->delete('service');

		return $this->db->affected_rows();
	}

}