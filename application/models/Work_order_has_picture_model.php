<?php
class Work_order_has_picture_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('work_order_id', $data['work_order_id']);
		$this->db->set('picture_id', $data['picture_id']);
		$this->db->insert('work_order_has_picture');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('work_order_id', $id);
		$this->db->where('picture_id', $id);
		$query = $this->db->get('work_order_has_picture');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('work_order_has_picture');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('work_order_id', $id);
		$this->db->where('picture_id', $id);
		$this->db->update('work_order_has_picture');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('work_order_id', $id);
		$this->db->where('picture_id', $id);
		$this->db->delete('work_order_has_picture');

		return $this->db->affected_rows();
	}

}