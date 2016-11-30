<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicular_reception extends CI_Controller {

    const IMAGE_WIDTH = 400;
    const IMAGE_HEIGHT = 400;

    function __construct() {
        parent::__construct();

        if ($this->session->userdata("role_id") != '0') {
            redirect("Login/index");
        } else {
            $this->load->model("Person_model", 'person');
            $this->load->model("Operation_model", 'operation');
            $this->load->model("Operation_type_model", 'operation_type');
            $this->load->model("Vehicle_model", 'vehicle');
            $this->load->model("Observation_model", 'observation');
            $this->load->model("Vehicle_collection_model", 'vehicle_collection');
            $this->load->model("Work_order_model", "work_order");
            $this->load->model("Picture_model", "picture");
            $this->load->model("Work_order_damage_point_model", "Work_order_damage_point");

            $this->init_form_validation();
        }
    }

    function index() {
        $work_orders = $this->work_order->get_all();
        foreach ($work_orders as $work_order) {
            $work_order->owner = $this->person->get_by_id($work_order->owner_id)->name;
            $work_order->received_by = $this->person->get_by_id($work_order->received_by)->name;
            $work_order->vehicle = $this->vehicle->get_by_id($work_order->vehicle_id);

            $work_order->vehicle->model = $this->vehicle_collection->get_by_id($work_order->vehicle->vehicle_model_id);
            $work_order->vehicle->model = $this->vehicle_collection->get_printable($work_order->vehicle->model);
        }
        $this->load_view_admin("vehicular_reception/index", ['work_orders' => $work_orders]);
    }

    function new_work_order() {
        $owners = $this->person->get_by_role(2);
        $this->load_view_admin('vehicular_reception/new_order', ['owners' => $owners, 'dummy_order_id' => uniqid("work_order")]);
    }

    function save_image() {
        $folder_name = "./uploads/work_order";
        $file_name = $this->input->post("work_order_id") . $this->input->post("point_id");

        $result = save_image_from_post('file', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
        echo $result[0];
    }

    function erase_image() {
        $folder_name = "./uploads/work_order";
        $file_name = $this->input->post("work_order_id") . $this->input->post("point_id");

        $files = glob($folder_name . "/" . $file_name . "*");
        foreach ($files as $file) {
            $info = pathinfo($file);
            unlink($info['dirname'] . "/" . $info['basename']);
        }
    }

    function get_image_path($dummy_work_order, $point_id) {
        $folder_name = "./uploads/work_order";
        $file_name = $dummy_work_order . $point_id;

        $files = glob($folder_name . "/" . $file_name . "*");
        foreach ($files as $file) {
            $info = pathinfo($file);
            return $info['dirname'] . "/" . $info['basename'];
        }
        return "";
    }

    function erase_all_images($prefix) {
        $folder_name = "./uploads/work_order";
        $file_name = $prefix;

        $files = glob($folder_name . "/" . $file_name . "*");
        foreach ($files as $file) {
            $info = pathinfo($file);
            unlink($info['dirname'] . "/" . $info['basename']);
        }

        echo $prefix;
    }

    function save_positions($work_order_id, $dummy_work_order_id, $positions) {
        $positions = explode("|", $positions);
        foreach ($positions as $position) {
            if (strlen($position)) {
                list($ID, $X, $Y, $color) = explode(";", $position);

                $file_name = $this->get_image_path($dummy_work_order_id, $ID);
                if (file_exists($file_name)) {
                    $picture_id = $this->picture->create(['picture_url' => $file_name]);
                    $data = ['work_order_id' => $work_order_id, 'X' => $X, 'Y' => $Y, 'picture_id' => $picture_id, 'color' => $color];
                    $this->Work_order_damage_point->create($data);
                }
            }
        }
    }

    function new_work_order_execute() {

        $owner = $this->input->post('owner');
        $vehicle_id = $this->input->post('vehicle_id');
        $km = intval($this->input->post('km'));
        $fuel_level = $this->input->post('fuel_level');
        $reason = $this->input->post('reason');

        $messages = [];
        if ($owner <= 0) {
            $messages[] = translate("select_valid_owner");
        }

        if (!isset($vehicle_id)) {
            $messages[] = translate("select_vehicle");
        }

        if ($fuel_level == -1) {
            $messages[] = translate("select_fuel_level");
        }

        if (!is_integer($km) || $km < 0 || $km > 10000000) {
            $messages[] = translate("invalid_km");
        }

        if (strlen(trim($reason)) < 5) {
            $messages[] = translate("incorrect_reason");
            $error = TRUE;
        }

        if (count($messages)) {
            $this->response->set_message($messages, ResponseMessage::ERROR);
            redirect("Vehicular_reception/new_work_order");
        } else {
            $items = [ 'fuel_level' => $fuel_level,
                'what_to_do' => $reason,
                'admission_day' => date("Y-m-d H:i:s"),
                'received_by' => $this->session->userdata("person_id"),
                'total_km' => $km,
                'vehicle_id' => $vehicle_id,
                'owner_id' => $owner];

            $work_order_id = $this->work_order->create($items);
            $dummy_order_id = $this->input->post('dummy_order_id');

            $this->save_positions($work_order_id, $dummy_order_id, $this->input->post("positions"));

            $this->response->set_message(translate('work_order_created'), ResponseMessage::SUCCESS);
            redirect("Vehicular_reception/index");
        }
    }

    function get_owned_cars() {
        $owner_id = $this->input->post('owner_id');
        $cars = $this->vehicle->get_by_owner($owner_id, FALSE);

        foreach ($cars as $car) {
            $model = $this->vehicle_collection->get_by_id($car->vehicle_model_id);
            if ($model) {
                $car->vehicle_model = $this->vehicle_collection->get_printable($model);
            } else {
                $car->vehicle_model = "Unknow model";
            }
        }
        echo json_encode($cars);
    }

    function erase($work_order_id = 0) {
        if ($this->work_order->delete($work_order_id)) {
            $this->response->set_message(translate("work_order_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("Vehicular_reception/index");
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

            $this->load_view_admin('vehicular_reception/information', ['work_order' => $work_order, 'points' => json_encode($damage_points)]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function activities($work_order_id = 0) {
        $work_order = $this->work_order->get_by_id($work_order_id);
        if ($work_order) {
            $activities = $this->operation->get_all(['work_order_id' => $work_order_id]);
            foreach ($activities as $act) {
                $act->responsible = $this->person->get_by_id($act->person_id)->name;
                $act->state = $this->_get_state($act->state);
            }
            $this->load_view_admin('activity/activities', [ 'work_order' => $work_order, 'activities' => $activities]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function update_activity($activity_id = 0) {
        $activity = $this->operation->get_by_id($activity_id);
        if ($activity) {
            $activity->responsible = $this->person->get_by_id($activity->person_id)->name;
            $mechanics = $this->person->get_all(['role_id' => 1]);
            $operation_types = $this->operation_type->get_all();
            $this->load_view_admin('activity/update', ['activity' => $activity, 'mechanics' => $mechanics, 'operation_types' => $operation_types]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function update_activity_execute() {
        $operation_type = $this->input->post('operation_type');
        $mechanic = $this->input->post('mechanic');
        $description = $this->input->post('description');
        $time_estimated = $this->input->post('time_estimated');
        $price = $this->input->post('price');
        $activity_id = $this->input->post('activity_id');
        $work_order_id = $this->input->post('work_order_id');
        $state = $this->input->post('state');

        $errors = [];
        if ($operation_type == -1) {
            $errors[] = translate('please_select_operation_type');
        }

        if ($mechanic == -1) {
            $errors[] = translate('please_select_mechanic');
        }

        if (count($errors)) {
            $this->response->set_message($errors, ResponseMessage::ERROR);
            redirect("Vehicular_reception/update_activity/$activity_id");
        } else {
            $this->form_validation->set_rules('description', translate('description'), 'trim|required|min_length[5]|max_length[256]');
            $this->form_validation->set_rules('time_estimated', translate('time_estimated_hr'), 'required|numeric');
            $this->form_validation->set_rules('price', translate('price'), 'required|numeric');
            $this->form_validation->set_rules('state', translate('state'), 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->response->set_message(validation_errors(), ResponseMessage::ERROR);

                redirect("Vehicular_reception/update_activity/$activity_id");
            } else {
                //si se termino se actualiza la fecha de closed
                if ($state == 1) {
                    $data = ['time_estimated_hours' => $time_estimated,
                        'description' => $description,
                        'price' => $price,
                        'state' => $state,
                        'operation_type_id' => $operation_type,
                        'date_closed' => date('Y-m-d'),
                        'person_id' => $mechanic];
                } else {
                    $data = ['time_estimated_hours' => $time_estimated,
                        'description' => $description,
                        'price' => $price,
                        'state' => $state,
                        'date_closed' => $this->operation->get_by_id($activity_id)->date_creation,
                        'operation_type_id' => $operation_type,
                        'person_id' => $mechanic];
                }

                $this->operation->update($activity_id, $data);

                $this->response->set_message(translate("activity_updated"), ResponseMessage::SUCCESS);
                redirect("Vehicular_reception/activities/$work_order_id");
            }
        }
    }

    //mostrar la vista de nueva actividad
    function new_activity($work_order_id = 0) {
        $work_order = $this->work_order->get_by_id($work_order_id);
        if ($work_order) {
            $mechanics = $this->person->get_all(['role_id' => 1]);
            $operation_types = $this->operation_type->get_all();
            $this->load_view_admin('activity/new_activity', ['work_order' => $work_order, 'operation_types' => $operation_types, 'mechanics' => $mechanics]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //obtener y salvar la nueva actividad
    function new_activity_execute() {
        $operation_type = $this->input->post('operation_type');
        $mechanic = $this->input->post('mechanic');
        $description = $this->input->post('description');
        $time_estimated = $this->input->post('time_estimated');
        $price = $this->input->post('price');
        $work_order_id = $this->input->post('work_order_id');
        $state = $this->input->post('state');

        $errors = [];
        if ($operation_type == -1) {
            $errors[] = translate('please_select_operation_type');
        }

        if ($mechanic == -1) {
            $errors[] = translate('please_select_mechanic');
        }

        if (count($errors)) {
            $this->response->set_message($errors, ResponseMessage::ERROR);
            redirect("Vehicular_reception/new_activity/$work_order_id");
        } else {
            $this->form_validation->set_rules('description', translate('description'), 'trim|required|min_length[5]|max_length[256]');
            $this->form_validation->set_rules('time_estimated', translate('time_estimated_hr'), 'required|numeric');
            $this->form_validation->set_rules('price', translate('price'), 'required|numeric');
            $this->form_validation->set_rules('state', translate('state'), 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
                redirect("Vehicular_reception/new_activity/$work_order_id");
            } else {
                $data = ['time_estimated_hours' => $time_estimated,
                    'description' => $description,
                    'price' => $price,
                    'state' => $state,
                    'operation_type_id' => $operation_type,
                    'work_order_id' => $work_order_id,
                    'date_creation' => date('Y-m-d'),
                    'person_id' => $mechanic];

                $this->operation->create($data);

                $this->response->set_message(translate("activity_created"), ResponseMessage::SUCCESS);
                redirect("Vehicular_reception/activities/$work_order_id");
            }
        }
    }

    function observation_by_activity($id_operation) {
        $observation = $this->observation->get_by_operation($id_operation);
        //echo "<pre>";print_r($observation);die;
        $operation = $this->operation->get_by_id($id_operation);
        $operation->responsible = $this->person->get_by_id($operation->person_id)->name;
        $operation->state = $this->_get_state($operation->state);

        foreach ($observation as $act) {
            $act->observation_state = $this->_get_state($act->observation_state);
        }
        $this->load_view_admin('observation/observations_operation', [ 'observations' => $observation, 'operation' => $operation]);
    }

    function new_observation($operation_id = null) {
        if (!empty($operation_id)) {
            $operation = $this->operation->get_by_id($operation_id);
            $operation->responsible = $this->person->get_by_id($operation->person_id)->name;
            $operation->state = $this->_get_state($operation->state);
            $this->load_view_admin('observation/new_observation', ['operation' => $operation]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //obtener y salvar la nueva observacion
    function new_observation_execute() {
        $operation_id = $this->input->post('operation_id');
        $comment = $this->input->post('comment');
        //$observation_state = $this->input->post('observation_state');

        $this->form_validation->set_rules('comment', translate('comment'), 'trim|required|min_length[5]|max_length[1000]');
        $this->form_validation->set_rules('operation_id', translate('operation_id'), 'required|numeric');
        //$this->form_validation->set_rules('observation_state', translate('observation_state'), 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("Vehicular_reception/new_observation/$operation_id");
        } else {
            $data = [
                'operation_id' => $operation_id,
                'day' => date("Y-m-d h:i:s"),
                'comment' => $comment,
                'observation_state' => 0,
                'day_finish' => null
            ];
            //echo "<pre>";print_r($data);die;
            $this->observation->create($data);

            $this->response->set_message(translate("observation_created"), ResponseMessage::SUCCESS);
            redirect("Vehicular_reception/observation_by_operation/" . $operation_id);
        }
    }

    function update_observation($observation_id) {
        $observation = $this->observation->get_by_id($observation_id);
        $operation = $this->operation->get_by_id($observation->operation_id);
        $operation->responsible = $this->person->get_by_id($operation->person_id)->name;
        $operation->state = $this->_get_state($operation->state);

        if ($observation) {
            $this->load_view_admin('observation/update', ['observation' => $observation, 'operation' => $operation]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //obtener y actualizar la observacion
    function update_observation_execute() {
        $operation_id = $this->input->post('operation_id');
        $comment = $this->input->post('comment');
        $observation_state = $this->input->post('observation_state');
        $observation_id = $this->input->post('observation_id');

        $this->form_validation->set_rules('comment', translate('comment'), 'trim|required|min_length[5]|max_length[1000]');
        $this->form_validation->set_rules('operation_id', translate('operation_id'), 'required|numeric');
        $this->form_validation->set_rules('observation_id', translate('observation_id'), 'required|numeric');
        //$this->form_validation->set_rules('observation_state', translate('observation_state'), 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("Vehicular_reception/update_observation/$observation_id");
        } else {
            if ($observation_state == 1) {
                $data = [
                    'day_finish' => date("Y-m-d h:i:s"),
                    'comment' => $comment,
                    'observation_state' => 1,
                ];
            } else {
                $data = [
                    'comment' => $comment,
                    'observation_state' => 0,
                ];
            }

            $this->observation->update($observation_id, $data);

            $this->response->set_message(translate("observation_updated"), ResponseMessage::SUCCESS);
            redirect("Vehicular_reception/observation_by_activity/$operation_id");
        }
    }

    function erase_observation($observation_id) {
        $observation = $this->observation->get_by_id($observation_id);
        if ($this->observation->delete($observation_id)) {
            $this->response->set_message(translate("observation_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("Vehicular_reception/observation_by_activity/$observation->operation_id");
        } else {
            $this->load->view("errors/error_404");
        }
    }
    
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

    /* METODOS DEL MUCHANIC     */
}
