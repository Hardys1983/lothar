<?php
class Work_order_damage_point_model extends CI_Model
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
		$this->db->set('X', $data['X']);
		$this->db->set('Y', $data['Y']);
		$this->db->set('color', $data['color']);
		
		$this->db->insert('work_order_damage_point');

		return $this->db->insert_id();
	}

	function get_by_id($id)
	{
		$this->db->where('work_order_id', $id);
		$this->db->where('picture_id', $id);
		$query = $this->db->get('work_order_damage_point');

		return $query->row();
	}

	function get_all($conditions = [])
	{
		foreach ($conditions as $key => $value ){
			$this->db->where($key, $value);
		}
		
		$query = $this->db->get('work_order_damage_point');
		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('work_order_id', $id);
		$this->db->where('picture_id', $id);
		if($data['X'])
			$this->db->set('X', $data['X']);
		if($data['Y'])
			$this->db->set('Y', $data['Y']);
		$this->db->update('work_order_damage_point');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('work_order_id', $id);
		$this->db->where('picture_id', $id);
		$this->db->delete('work_order_damage_point');

		return $this->db->affected_rows();
	}

}