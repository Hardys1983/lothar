<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    private $client = null;

    function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $data = $this->session->userdata();
        if ($data['role_id'] == 2) {
            $this->client = $data;
            $this->load->model("Person_model", 'person');
            $this->load->model("Operation_model", 'operation');
            $this->load->model("Work_order_model", 'work_order');
            $this->load->model("Vehicle_model", 'vehicle');
            $this->load->model("Vehicle_collection_model", 'vehicle_collection');
            $this->load->model("Picture_model", "picture");
            $this->load->model("Appointment_model", "appointment");
            $this->load->model("Work_order_damage_point_model", "Work_order_damage_point");
            $this->init_form_validation();
        } else {
            redirect("Login/index");
        }
//        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        $this->load_view_client("dash");
    }

    public function appointments() {
        $appointments = $this->appointment->get_by_person($this->client['person_id']);
        foreach ($appointments as $app) {
            $app->vehicle = $this->vehicle->get_by_id($app->vehicle_id);
            $model = $this->vehicle_collection->get_by_id($app->vehicle->vehicle_model_id);
            if ($model) {
                $app->vehicle_model = $this->vehicle_collection->get_printable($model);
            } else {
                $app->vehicle_model = "Unknow model";
            }

            $app->state = $this->_get_state($app->state);
            $app->taxi_required = $this->get_taxi($app->taxi_required);
        }
        //convetir el arreg,o de citas a un json para mostrarlo en el calendario
        $this->load_view_client('client/appointments', ['appointments' => $appointments]);
    }

    //mostrar la vista de nueva cita
    function new_appointment() {
        $vehicles = $this->vehicle->get_by_owner($this->client['person_id'], false);
        if ($vehicles) {
            foreach ($vehicles as $car) {
                $model = $this->vehicle_collection->get_by_id($car->vehicle_model_id);
                if ($model) {
                    $car->vehicle_model = $this->vehicle_collection->get_printable($model);
                } else {
                    $car->vehicle_model = "Unknow model";
                }
            }
            $this->load_view_client('client/new_appointment', ['vehicles' => $vehicles]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function erase_appointment($appointment_id = 0) {
        if ($this->appointment->delete($appointment_id)) {
            $this->response->set_message(translate("appointment_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("Client/appointments");
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //mostrar el selector con los horarios disponibles en el modal de cita
    public function horarios_disponibles() {
        $date = $this->input->post('day');
        $date = explode(" ", $date);
        $inicio = gmdate("Y-m-d H:i:s", strtotime($date[2] . " " . $date[1] . " " . $date[3] . " 02:00:01"));
        $final = gmdate("Y-m-d H:i:s", strtotime($date[2] . " " . $date[1] . " " . $date[3] . " 24:59:59"));

        $appointment_datetime = $this->appointment->get_by_date($inicio, $final);
        $inicio_str = strtotime($date[2] . " " . $date[1] . " " . $date[3] . " 09:00:00");
        $select = "";
        $select .= "<select name='day' required>";
        if (!empty($appointment_datetime)) {
            for ($index = 0; $index < 15; $index++) {
                $a = true;
                foreach ($appointment_datetime as $app) {
                    $dt_app = strtotime($app->day);
                    if ($dt_app == $inicio_str) {
                        $a = false;
                    }
                }
                if ($a) {
                    $select.= "<option value='" . gmdate("Y-m-d H:i:s", $inicio_str) . "'>" . gmdate("H:i:s", $inicio_str) . "</option>";
                    $a = true;
                }
                $inicio_str = strtotime('+1 hours', $inicio_str);
            }
        } else {
            for ($index = 0; $index < 15; $index++) {
                $select.= "<option value='" . gmdate("Y-m-d H:i:s", $inicio_str) . "'>" . gmdate("H:i:s", $inicio_str) . "</option>";
                $inicio_str = strtotime('+1 hours', $inicio_str);
            }
        }
        $select .= "</select>";
        echo $select;
    }

    public function appointments_json() {
        $appointments = $this->appointment->get_by_person($this->client['person_id']);
        $a_j = array();
        foreach ($appointments as $app) {
            $vehicle = $this->vehicle->get_by_id($app->vehicle_id);
            $model = $this->vehicle_collection->get_by_id($vehicle->vehicle_model_id);
            if ($model) {
                $app->vehicle_model = $this->vehicle_collection->get_printable($model);
            } else {
                $app->vehicle_model = "Unknow model";
            }
            $app->person = $this->person->get_by_id($app->client_id)->name;
            $app->state = $this->_get_state($app->state);
            $date = explode(" ", $app->day);
            array_push($a_j, array('title' => $app->vehicle_model . " \n " . $date[1] . " - " . $app->state, 'start' => $date[0], 'end' => $date[0]));
        }
        echo json_encode($a_j);
    }

    //obtener y salvar la nueva actividad
    function new_appointment_execute() {
        $comment = $this->input->post('comment');
        $day = $this->input->post('day');
        $taxi_required = $this->input->post('taxi_required');
        if (empty($taxi_required)) {
            $taxi_required = 0;
        }
        $vehicle_id = $this->input->post('vehicle_id');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $errors = [];
        if ($vehicle_id == -1) {
            $errors[] = translate('vehicle_selected');
        }

        if (count($errors)) {
            $this->response->set_message($errors, ResponseMessage::ERROR);
            redirect("Client/new_appointment");
        } else {
            $this->form_validation->set_rules('day', translate('day'), 'required');
            $this->form_validation->set_rules('address', translate('address'), 'required');
            $this->form_validation->set_rules('vehicle_id', translate('vehicle_id'), 'required|numeric');
            $this->form_validation->set_rules('phone', translate('phone'), 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
                redirect("Client/new_appointment");
            } else {
                $data = [
                    'comment' => $comment,
                    'day' => $day,
                    'taxi_required' => $taxi_required,
                    'vehicle_id' => $vehicle_id,
                    'phone' => $phone,
                    'address' => $address,
                    'state' => 0,
                    'client_id' => $this->client['person_id']];

                $this->appointment->create($data);

                $this->response->set_message(translate("appointment_created"), ResponseMessage::SUCCESS);
                redirect("Client/new_appointment");
            }
        }
    }

    public function vehicles() {
        $vehicles = $this->vehicle->get_by_owner($this->client['person_id'], false);
        foreach ($vehicles as $car) {
            $model = $this->vehicle_collection->get_by_id($car->vehicle_model_id);
            if ($model) {
                $car->vehicle_model = $this->vehicle_collection->get_printable($model);
            } else {
                $car->vehicle_model = "Unknow model";
            }
        }
        $this->load_view_client('client/vehicles', [ 'vehicles' => $vehicles]);
    }

    public function works_by_vehicle($car_id) {
        $works_by_vehicle = $this->work_order->get_works_by_vehicle($car_id);
        foreach ($works_by_vehicle as $work_order) {
            $work_order->owner = $this->person->get_by_id($work_order->owner_id)->name;
            $work_order->received_by = $this->person->get_by_id($work_order->received_by)->name;
            $work_order->vehicle = $this->vehicle->get_by_id($work_order->vehicle_id);

            $work_order->vehicle->model = $this->vehicle_collection->get_by_id($work_order->vehicle->vehicle_model_id);
            $work_order->vehicle->model = $this->vehicle_collection->get_printable($work_order->vehicle->model);
        }
        $this->load_view_client("client/works_by_vehicle", ['work_orders' => $works_by_vehicle]);
    }

    function activities($work_order_id = 0) {
        $work_order = $this->work_order->get_by_id($work_order_id);
        if ($work_order) {
            $activities = $this->operation->get_all(['work_order_id' => $work_order_id]);
            foreach ($activities as $act) {
                $act->responsible = $this->person->get_by_id($act->person_id)->name;
                $act->state = $this->_get_state($act->state);
            }
            $this->load_view_client('client/activities', ['work_order' => $work_order, 'activities' => $activities, 'car_id' => $work_order->vehicle_id]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function show_work_order($work_order_id = 0) {
        $work_order = $this->work_order->get_by_id($work_order_id);
        if ($work_order) {
            $damage_points = $this->Work_order_damage_point->get_all(['work_order_id' => $work_order_id]);

            foreach ($damage_points as $point) {
                $point->picture = $this->picture->get_by_id($point->picture_id);
                $point->picture = base_url($point->picture->picture_url);
            }

            $work_order->owner = $this->person->get_by_id($work_order->owner_id)->name;
            $work_order->received_by = $this->person->get_by_id($work_order->received_by)->name;
            $work_order->vehicle = $this->vehicle->get_by_id($work_order->vehicle_id);

            $work_order->vehicle->model = $this->vehicle_collection->get_by_id($work_order->vehicle->vehicle_model_id);
            $work_order->vehicle->model = $this->vehicle_collection->get_printable($work_order->vehicle->model);

            $this->load_view_client('client/information', ['work_order' => $work_order, 'points' => json_encode($damage_points)]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //devuelve el estado de la actividad
    function _get_state($state) {
        switch ($state) {
            case 0:
                return translate("state_pending");
            case 1:
                return translate("state_finish");
            case 2:
                return translate("state_proposed");
            case 3:
                return translate("state_approved");
            default:
                return translate("state_pending");
        }
    }

    function get_taxi($taxi) {
        switch ($taxi) {
            case 0:
                return translate("taxi_not_required");
            case 1:
                return translate("taxi_yes_required");
        }
    }

}
