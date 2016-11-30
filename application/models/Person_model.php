<?php
class Person_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('name', $data['name']);
		$this->db->set('ci', $data['ci']);
		$this->db->set('address', $data['address']);
		$this->db->set('email', $data['email']);
		$this->db->set('phone', $data['phone']);
		$this->db->set('cell_phone', $data['cell_phone']);
		$this->db->set('admission_date', $data['admission_date']);
		$this->db->set('cell_phone_company_id', $data['cell_phone_company_id']);
		$this->db->set('role_id', $data['role_id']);
		$this->db->set('picture_id', $data['picture_id']);
		$this->db->set('password', $data['password']);

		$this->db->insert('person');

		return $this->db->insert_id();
	}

	function get_by_role($role_id){
		$this->db->where('role_id', $role_id);
		$query = $this->db->get('person');
		
		return $query->result();
	}
	
	function get_by_id($id)
	{
		$this->db->where('person_id', $id);
		$query = $this->db->get('person');

		return $query->row();
	}

	function get_all($conditions = [])
	{
		foreach ($conditions as $key => $value ){
			$this->db->where($key, $value);
		}
		
		$query = $this->db->get('person');
		return $query->result();
	}
        
        function get_all_with_vehicles()
	{
		$query = "SELECT * FROM person, vehicle WHERE "
                        . "person.person_id = vehicle.owner_id GROUP BY person.person_id";
		return $this->db->query($query)->result();
	}

	function update($id, $data)
	{
		$this->db->where('person_id', $id);

		foreach($data as $key => $value ){
			$this->db->set($key, $value);
		}
		
		$this->db->update('person');
		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('person_id', $id);
		$this->db->delete('person');

		return $this->db->affected_rows();
	}

}