<?php
class Final_revision_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('total_km', $data['total_km']);
		$this->db->set('fuel_level', $data['fuel_level']);
		$this->db->set('day', $data['day']);
		$this->db->set('abc', $data['abc']);
		$this->db->set('person_person_id', $data['person_person_id']);
		$this->db->set('work_order_id', $data['work_order_id']);
		
		$this->db->insert('final_revision');

		return $this->db->insert_id();
	}

	function get_by_id($id)
	{
		$this->db->where('final_revision_id', $id);
		$query = $this->db->get('final_revision');

		return $query->row();
	}

	function get_all($conditions = [], $as_row = FALSE)
	{
		foreach ($conditions as $key => $value ){
			$this->db->where($key, $value);
		}
		
		$query = $this->db->get('final_revision');
		if($as_row){
			return $query->row();
		}else{
			return $query->result();
		}
	}

	function update($id, $data)
	{
		$this->db->where('final_revision_id', $id);
		if($data['total_km'])
			$this->db->set('total_km', $data['total_km']);
		if($data['fuel_level'])
			$this->db->set('fuel_level', $data['fuel_level']);
		if($data['close_order'])
			$this->db->set('close_order', $data['close_order']);
		if($data['day'])
			$this->db->set('day', $data['day']);
		if($data['abc'])
			$this->db->set('abc', $data['abc']);
		if($data['person_person_id'])
			$this->db->set('person_person_id', $data['person_person_id']);
		$this->db->update('final_revision');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('final_revision_id', $id);
		$this->db->delete('final_revision');

		return $this->db->affected_rows();
	}

}