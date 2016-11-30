<?php

class Work_order_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function create($data) {
        $this->db->set('fuel_level', $data['fuel_level']);
        $this->db->set('what_to_do', $data['what_to_do']);
        $this->db->set('admission_day', $data['admission_day']);
        $this->db->set('received_by', $data['received_by']);
        $this->db->set('total_km', $data['total_km']);
        $this->db->set('vehicle_id', $data['vehicle_id']);
        $this->db->set('owner_id', $data['owner_id']);

        $this->db->insert('work_order');
        return $this->db->insert_id();
    }

    function get_by_id($id) {
        $this->db->where('work_order_id', $id);
        $query = $this->db->get('work_order');

        return $query->row();
    }

    function get_all($conditions = []) {
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }

        $query = $this->db->get('work_order');
        return $query->result();
    }

    function update($id, $data) {
        $this->db->where('work_order_id', $id);

        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->update('work_order');
        return $this->db->affected_rows();
    }

    function delete($id) {
        $this->db->where('work_order_id', $id);
        $this->db->delete('work_order');

        return $this->db->affected_rows();
    }

    function get_works_by_vehicle($car_id) {
        $this->db->where('vehicle_id', $car_id);
        $query = $this->db->get('work_order');
        return $query->result();
    }

    /* obtener todos los trabajos que tenga asigando una persona 
      para mostrarlo en el select de crear observaciones al mecanico */

    function get_works_by_person($person_id) {
        $query = "SELECT work_order.work_order_id, "
                . "CONCAT ( vehicle_model_year.make ,' ', vehicle_model_year.model,' ', vehicle_model_year.year, ' -> ', vehicle.plate_number) AS text "
                . "FROM operation, work_order, vehicle, vehicle_model_year WHERE "
                . "operation.person_id = " . $person_id . " AND "
                . "operation.work_order_id = work_order.work_order_id AND "
                . "work_order.vehicle_id = vehicle.vehicle_id AND "
                . "vehicle.vehicle_model_id = vehicle_model_year.id "
                . "GROUP BY vehicle.vehicle_id ";
        return $this->db->query($query)->result();
    }

    //funcion para obtener las ordenes de trabajo entre x y z fechas
    function get_between_days($desde, $hasta) {
        $this->db->where('admission_day >=', $desde);
        $this->db->where('admission_day <=', $hasta);
        $query = $this->db->get('work_order');
        return $query->result();
    }

    function get_admission_by_date($desde, $hasta) {
        $this->db->where('admission_day >', $desde);
        $this->db->where('admission_day <', $hasta);
        $this->db->where('closed', null);
        $query = $this->db->get('work_order');
        return $query->result();
    }

    function get_closed_by_date($desde, $hasta) {
        $this->db->where('admission_day >', $desde);
        $this->db->where('admission_day <', $hasta);
        $this->db->where('closed', 1);
        $query = $this->db->get('work_order');
        return $query->result();
    }

}
