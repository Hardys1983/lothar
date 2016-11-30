<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {

    private $admin = null;

    function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $data = $this->session->userdata();
        if ($data['role_id'] == 0) {
            $this->admin = $data;
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
        //date_default_timezone_set('America/Bogota');
    }

    public function index() {
        $this->load_view_admin("dash");
    }

    public function appointments() {
        $appointments = $this->appointment->get_all();
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
            $app->taxi_required = $this->get_taxi($app->taxi_required);
        }

        $a = json_encode($appointments);
        //convetir el arreglo de citas a un json para mostrarlo en el calendario
        $this->load_view_admin('appointment/appointments', ['appointments' => $appointments, 'a_j' => $a]);
    }

    public function appointments_json() {
        $appointments = $this->appointment->get_all();
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

    //mostrar la vista de nueva cita
    function new_appointment() {
        $owners = $this->person->get_all_with_vehicles();

        //$vehicles = $this->vehicle->get_by_owner($this->client['person_id'], false);
        if ($owners) {
            $this->load_view_admin('appointment/new_appointment', ['owners' => $owners]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //mostrar el selector con los autmoviles del cliente seleccionado
    public function vehicles_by_owner() {
        $client_id = $this->input->post('client_id');
        $vehicles = $this->vehicle->get_by_owner($client_id, false);
        $select = "<select name='vehicle_id'>";
        if ($vehicles) {
            foreach ($vehicles as $car) {
                $model = $this->vehicle_collection->get_by_id($car->vehicle_model_id);
                if ($model) {
                    $car->vehicle_model = $this->vehicle_collection->get_printable($model);
                    $select .= "<option value='" . $car->vehicle_id . "'>" . $car->vehicle_model . "</option>";
                } else {
                    $select .= "<option value='-1'>Unknow model</option>";
                    //$car->vehicle_model = "Unknow model";
                }
            }
        }
        $select .= "</select>";
        echo $select;
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

    //obtener y salvar la nueva actividad
    function new_appointment_execute() {
        $comment = $this->input->post('comment');
        $day = $this->input->post('day');
        $taxi_required = $this->input->post('taxi_required');
        if (empty($taxi_required)) {
            $taxi_required = 0;
        }
        $client_id = $this->input->post('client_id');
        $vehicle_id = $this->input->post('vehicle_id');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $state = $this->input->post('state');

        $errors = [];
        if ($vehicle_id == -1) {
            $errors[] = translate('vehicle_selected');
        }

        if ($client_id == -1) {
            $errors[] = translate('owner_selected');
        }

        if (count($errors)) {
            $this->response->set_message($errors, ResponseMessage::ERROR);
            redirect("Appointment/new_appointment");
        } else {
            $this->form_validation->set_rules('day', translate('day'), 'required');
            $this->form_validation->set_rules('address', translate('address'), 'required');
            $this->form_validation->set_rules('vehicle_id', translate('vehicle_id'), 'required|numeric');
            $this->form_validation->set_rules('phone', translate('phone'), 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
                redirect("Appointment/new_appointment");
            } else {
                $data = [
                    'comment' => $comment,
                    'day' => $day,
                    'taxi_required' => $taxi_required,
                    'vehicle_id' => $vehicle_id,
                    'phone' => $phone,
                    'address' => $address,
                    'state' => $state,
                    'client_id' => $client_id];

                $this->appointment->create($data);

                $this->response->set_message(translate("appointment_created"), ResponseMessage::SUCCESS);
                redirect("Appointment/new_appointment");
            }
        }
    }

    function update_appointment($appointment_id = 0) {
        $appointment = $this->appointment->get_by_id($appointment_id);
        $date = explode(" ", $appointment->day);
        if ($appointment) {
//            $appointment->responsible = $this->person->get_by_id($appointment->person_id)->name;
            $clients = $this->person->get_all_with_vehicles();
            $vehicles = $this->vehicle->get_by_owner($appointment->client_id, false);
            if ($vehicles) {
                foreach ($vehicles as $car) {
                    $model = $this->vehicle_collection->get_by_id($car->vehicle_model_id);
                    if ($model) {
                        $car->vehicle_model = $this->vehicle_collection->get_printable($model);
                        //$select .= "<option value='" . $car->vehicle_id . "'>" . $car->vehicle_model . "</option>";
                    } else {
                        //$select .= "<option value='-1'>Unknow model</option>";
                        $car->vehicle_model = "Unknow model";
                    }
                }
            }

            $this->load_view_admin('appointment/update', ['appointment' => $appointment, 'clients' => $clients, 'vehicles' => $vehicles, 'date' => $date[0]]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function erase_appointment($appointment_id = 0) {
        if ($this->appointment->delete($appointment_id)) {
            $this->response->set_message(translate("appointment_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("Appointment/appointments");
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
