<?php

class Operation_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function create($data) {
        $this->db->set('time_estimated_hours', $data['time_estimated_hours']);
        $this->db->set('description', $data['description']);
        $this->db->set('price', $data['price']);
        $this->db->set('operation_type_id', $data['operation_type_id']);
        $this->db->set('work_order_id', $data['work_order_id']);
        $this->db->set('person_id', $data['person_id']);
        $this->db->set('state', $data['state']);

        $this->db->insert('operation');
        return $this->db->insert_id();
    }

    function get_by_id($id) {
        $this->db->where('operation_id', $id);
        $query = $this->db->get('operation');
        return $query->row();
    }

    function get_all() {
        $query = $this->db->get('operation');

        return $query->result();
    }

    function update($id, $data) {
        $this->db->where('operation_id', $id);

        if ($data['time_estimated_hours'])
            $this->db->set('time_estimated_hours', $data['time_estimated_hours']);
        if ($data['time_used'])
            $this->db->set('time_used', $data['time_used']);
        if ($data['description'])
            $this->db->set('description', $data['description']);
        if ($data['price'])
            $this->db->set('price', $data['price']);
        if ($data['operation_type_id'])
            $this->db->set('operation_type_id', $data['operation_type_id']);
        if ($data['state'])
            $this->db->set('state', $data['state']);

        $this->db->update('operation');
        return $this->db->affected_rows();
    }

    function delete($id) {
        $this->db->where('operation_id', $id);
        $this->db->where('work_order_id', $id);
        $this->db->where('person_id', $id);
        $this->db->where('person_cell_phone_company_id', $id);
        $this->db->delete('operation');

        return $this->db->affected_rows();
    }

    function get_between_days($desde, $hasta) {
        $this->db->where('date_creation >=', $desde);
        $this->db->where('date_creation <=', $hasta);
        $query = $this->db->get('operation');
        return $query->result();
    }

    function get_create_by_date($date) {
        $this->db->where('date_creation', $date);
        $query = $this->db->get('operation');
        return $query->result();
    }

    function get_finish_by_date($date) {
        $this->db->where('date_closed', $date);
        $query = $this->db->get('operation');
        return $query->result();
    }

    function get_create_by_date_by_person($date, $f, $person) {
        $this->db->where('date_creation >', $date);
        $this->db->where('date_creation <', $f);
        $this->db->where('state', 0);
        $this->db->where('person_id', $person);
        $query = $this->db->get('operation');
        return $query->result();
    }

    function get_finish_by_date_by_person($date, $f, $person) {
        $this->db->where('date_closed > ', $date);
        $this->db->where('date_closed < ', $f);
        $this->db->where('state', 1);
        $this->db->where('person_id', $person);
        $query = $this->db->get('operation');
        return $query->result();
    }

}
