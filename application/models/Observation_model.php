<?php

class Observation_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function create($data) {
        $this->db->set('comment', $data['comment']);
        $this->db->set('day', $data['day']);
        $this->db->set('operation_id', $data['operation_id']);
        $this->db->set('observation_state', $data['observation_state']);
        $this->db->set('day_finish', $data['day_finish']);
        return $this->db->insert('observation');

        //return $this->db->inserted_id();
    }

    //obtener todas las observaciones de todas las operaciones de un mecanico
    function get_by_mechanic($id_mechanic) {
        $query = "SELECT observation.* FROM observation, operation WHERE "
                . "operation.person_id = " . $id_mechanic . " AND "
                . "operation.operation_id = observation.operation_id";
        return $this->db->query($query)->result();
    }

    function get_by_mechanic_and_operation($id_mechanic, $id_operation) {
        $query = "SELECT observation.* FROM observation, operation WHERE "
                . "operation.person_id = " . $id_mechanic . " AND "
                . "operation.operation_id = " . $id_operation . " AND "
                . "operation.operation_id = observation.operation_id";
        return $this->db->query($query)->result();
    }

    function get_by_id($id) {
        $this->db->where('observation_id', $id);
        //$this->db->where('operation_id', $id);
        $query = $this->db->get('observation');

        return $query->row();
    }

    function get_by_operation($id_operation) {
        $this->db->where('operation_id', $id_operation);
        //$this->db->where('operation_id', $id);
        $query = $this->db->get('observation');
        return $query->result();
    }

    function get_all($conditions = []) {
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }

        $query = $this->db->get('observation');
        return $query->result();
    }

    function update($id, $data) {

        $this->db->where('observation_id', $id);
        if (isset($data['comment']))
            $this->db->set('comment', $data['comment']);
        if (isset($data['day']))
            $this->db->set('day', $data['day']);
        if (isset($data['day_finish']))
            $this->db->set('day_finish', $data['day_finish']) ;
        if (isset($data['observation_state']))
            $this->db->set('observation_state', $data['observation_state']);

        $this->db->update('observation');

        return $this->db->affected_rows();
    }

    function update_2($id, $data) {
        $this->db->where('observation_id', $id);
        $this->db->set('comment', $data['comment']);
        $this->db->set('day_finish', $data['day_finish']);
        $this->db->set('observation_state', $data['observation_state']);
        $this->db->update('observation');
        return $this->db->affected_rows();
    }

    function delete($id) {
        $this->db->where('observation_id', $id);
        //$this->db->where('operation_id', $id);
        $this->db->delete('observation');

        return $this->db->affected_rows();
    }

}
