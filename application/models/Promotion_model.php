<?php
class Promotion_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('description', $data['description']);
		$this->db->set('begin', $data['begin']);
		$this->db->set('end', $data['end']);
		$this->db->set('picture_id', $data['picture_id']);
		return $this->db->insert('promotion');

		//return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('promotion_id', $id);
		$query = $this->db->get('promotion');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('promotion');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('promotion_id', $id);
		if($data['description'])
			$this->db->set('description', $data['description']);
		if($data['begin'])
			$this->db->set('begin', $data['begin']);
		if($data['end'])
			$this->db->set('end', $data['end']);
		if($data['picture_id'])
			$this->db->set('picture_id', $data['picture_id']);
		$this->db->update('promotion');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('promotion_id', $id);
		$this->db->delete('promotion');

		return $this->db->affected_rows();
	}

}