<?php
class Cell_phone_company_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('company_name', $data['company_name']);
		$this->db->insert('cell_phone_company');

		return $this->db->inserted_id();
	}

	function get_by_id($id)
	{
		$this->db->where('cell_phone_company_id', $id);
		$query = $this->db->get('cell_phone_company');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('cell_phone_company');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('cell_phone_company_id', $id);
		if($data['company_name'])
			$this->db->set('company_name', $data['company_name']);
		$this->db->update('cell_phone_company');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cell_phone_company_id', $id);
		$this->db->delete('cell_phone_company');

		return $this->db->affected_rows();
	}

}