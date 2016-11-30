<?php
class Picture_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function create($data)
	{
		$this->db->set('picture_url', $data['picture_url']);
		$this->db->insert('picture');

                $query = "SELECT MAX(picture_id) AS picture_id FROM picture";
		return $this->db->query($query)->row();
	}

	function get_by_id($id)
	{
		$this->db->where('picture_id', $id);
		$query = $this->db->get('picture');

		return $query->row();
	}

	function get_all()
	{
		$query = $this->db->get('picture');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('picture_id', $id);
		if($data['picture_url'])
			$this->db->set('picture_url', $data['picture_url']);
		$this->db->update('picture');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('picture_id', $id);
		$this->db->delete('picture');

		return $this->db->affected_rows();
	}

}