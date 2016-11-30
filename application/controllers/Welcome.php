<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("role_id") != '0') {
            redirect("Login/index");
        } else {
            $this->load->helper(['url', 'form']);
            $this->load->model("Work_order_model", "work_order");
            $this->load->model("Operation_model", "operation");
            $this->load->model("Appointment_model", "appointment");
            $this->load->model("Person_model", "person");
        }
    }

    public function index() {
        $data = array();
        $f = date('Y-m-d');
        $nuevafecha = strtotime('-7 days', strtotime($f));
        $fecha = date('Y-m-d', $nuevafecha);

        $operations = array();
        $work_orders = array();
        $appointments = array();
        $mechanics = array();

        $m = $this->person->get_by_role(1);
        for ($index1 = 0; $index1 < count($m); $index1++) {
            //insertando las operaciones por mecanico
            $mechanic = array(
                'name' => $m[$index1]->name,
                'assigned' => count($this->operation->get_create_by_date_by_person($fecha, $f, $m[$index1]->person_id)),
                'finish' => count($this->operation->get_finish_by_date_by_person($fecha, $f, $m[$index1]->person_id))
            );
            array_push($mechanics, $mechanic);
        }

        for ($index = 0; $index < 7; $index++) {
            $desde = gmdate("Y-m-d H:i:s", strtotime($fecha . " 02:00:01"));
            $hasta = gmdate("Y-m-d H:i:s", strtotime($fecha . " 24:59:59"));
            //insertando las operaciones
            $operation = array(
                'create' => count($this->operation->get_create_by_date($fecha)),
                'finish' => count($this->operation->get_finish_by_date($fecha)),
                'date' => $fecha
            );
            array_push($operations, $operation);

            //insertando las ordenes de trabajo
            $work_order = array(
                'addmision' => count($this->work_order->get_admission_by_date($desde, $hasta)),
                'closed' => count($this->work_order->get_closed_by_date($desde, $hasta)),
                'date' => $fecha
            );
            array_push($work_orders, $work_order);

            //insertando las citas
            $appointment = array(
                'reserved' => count($this->appointment->get_pending_by_date($desde, $hasta)),
                'approved' => count($this->appointment->get_approved_by_date($desde, $hasta)),
                'date' => $fecha
            );
            array_push($appointments, $appointment);

            //aumentado la fecha
            $nuevafecha = strtotime('+1 day', strtotime($fecha));
            $fecha = date('Y-m-d', $nuevafecha);
        }

        $data['operations'] = $operations;
        $data['work_orders'] = $work_orders;
        $data['appointments'] = $appointments;
        $data['mechanics'] = $mechanics;

        //echo "<pre>";print_r($data);die;

        $this->load_view_admin("admin/dashboard", $data);
    }

}
