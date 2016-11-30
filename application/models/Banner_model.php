<?php
class Banner_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('sub_title', $data['sub_title']);
		$this->db->set('state', $data['state']);
		$this->db->set('title', $data['title']);
		$this->db->set('picture_id', $data['picture_id']);
		return $this->db->insert('banner');

		//return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('banner_id', $id);
		$query = $this->db->get('banner');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('banner');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('banner_id', $id);
		if($data['sub_title'])
			$this->db->set('sub_title', $data['sub_title']);
		if($data['state'])
			$this->db->set('state', $data['state']);
		if($data['title'])
			$this->db->set('title', $data['title']);
		if($data['picture_id'])
			$this->db->set('picture_id', $data['picture_id']);
		$this->db->update('banner');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('banner_id', $id);
		$this->db->delete('banner');

		return $this->db->affected_rows();
	}

}