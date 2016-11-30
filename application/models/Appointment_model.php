<?php

class Appointment_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function create($data) {
        $this->db->set('comment', $data['comment']);
        $this->db->set('day', $data['day']);
        $this->db->set('taxi_required', $data['taxi_required']);
        $this->db->set('state', $data['state']);
        $this->db->set('address', $data['address']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('client_id', $data['client_id']);
        $this->db->set('vehicle_id', $data['vehicle_id']);
        return $this->db->insert('appointment');

        //return $this->db->inserted_id();
    }

    function get_by_id($id) {
        $this->db->where('appointment_id', $id);
        $query = $this->db->get('appointment');

        return $query->row();
    }

    function get_by_person($person_id) {
        $this->db->where('client_id', $person_id);
        $query = $this->db->get('appointment');

        return $query->result();
    }

    function get_all() {
        $query = $this->db->get('appointment');

        return $query->result();
    }

    function update($id, $data) {
        $this->db->where('appointment_id', $id);
        if ($data['comment'])
            $this->db->set('comment', $data['comment']);
        if ($data['day'])
            $this->db->set('day', $data['day']);
        if ($data['taxi_required'])
            $this->db->set('taxi_required', $data['taxi_required']);
        if ($data['state'])
            $this->db->set('state', $data['state']);
        if ($data['address'])
            $this->db->set('address', $data['address']);
        if ($data['phone'])
            $this->db->set('phone', $data['phone']);
        if ($data['client_id'])
            $this->db->set('client_id', $data['client_id']);
        if ($data['vehicle_id'])
            $this->db->set('vehicle_id', $data['vehicle_id']);
        $this->db->update('appointment');

        return $this->db->affected_rows();
    }

    function delete($id) {
        $this->db->where('appointment_id', $id);
        $this->db->delete('appointment');

        return $this->db->affected_rows();
    }

    function get_by_date($inicio, $final) {
        $this->db->where('day < ', "" . $final . "");
        $this->db->where('day > ', "" . $inicio . "");
        $query = $this->db->get('appointment');
        //$query = "SELECT * FROM appointment WHERE day > '2014-06-29 04:00:44' AND day < '2016-06-29 04:00:44'";
        return $query->result();
    }

    function get_between_days($desde, $hasta) {
        $this->db->where('day >=', $desde);
        $this->db->where('day <=', $hasta);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function get_pending_by_date($desde, $hasta) {
        $this->db->where('day >', $desde);
        $this->db->where('day <', $hasta);
        $this->db->where('state', 0);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function get_approved_by_date($desde, $hasta) {
        $this->db->where('day >', $desde);
        $this->db->where('day <', $hasta);
        $this->db->where('state', 3);
        $query = $this->db->get('appointment');
        return $query->result();
    }

}
