<?php
class Billing_information_model extends Model
{

	function Billing_information_model()
	{
		parent::Model();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('name', $data['name']);
		$this->db->set('ruc', $data['ruc']);
		$this->db->set('address', $data['address']);
		$this->db->set('phone', $data['phone']);
		$this->db->set('person_id', $data['person_id']);
		$this->db->insert('billing_information');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('billing_information_id', $id);
		$query = $this->db->get('billing_information');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('billing_information');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('billing_information_id', $id);
		if($data['name'])
			$this->db->set('name', $data['name']);
		if($data['ruc'])
			$this->db->set('ruc', $data['ruc']);
		if($data['address'])
			$this->db->set('address', $data['address']);
		if($data['phone'])
			$this->db->set('phone', $data['phone']);
		if($data['person_id'])
			$this->db->set('person_id', $data['person_id']);
		$this->db->update('billing_information');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('billing_information_id', $id);
		$this->db->delete('billing_information');

		return $this->db->affected_rows();
	}

}