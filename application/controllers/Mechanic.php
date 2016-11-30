<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mechanic extends CI_Controller {

    private $mechanic = null;

    function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $data = $this->session->userdata();
        if ($data['role_id'] == 1) {
            $this->mechanic = $data;
            $this->load->model("Person_model", 'person');
            $this->load->model("Work_order_model", 'work_order');
            $this->load->model("Operation_model", 'operation');
            $this->load->model("Operation_type_model", 'operation_type');
            $this->load->model("Observation_model", 'observation');
            $this->init_form_validation();
        } else {
            redirect("Login/index");
        }
    }

    public function index() {
        $this->load_view_mechanic("dash");
    }

    // CRUD ACTIVITY OPERATION ************************************************/
    function activities() {
        $activities = $this->operation->get_all(['person_id' => $this->mechanic['person_id']]);
        foreach ($activities as $act) {
            $act->responsible = $this->person->get_by_id($act->person_id)->name;
            $act->state = $this->_get_state($act->state);
        }
        $this->load_view_mechanic('activity_mechanic/activities', [ 'activities' => $activities]);
    }

    function update_activity($activity_id = 0) {
        $activity = $this->operation->get_by_id($activity_id);
        //se valida si no es una propuesta
        if ($activity AND $activity->state != 2) {
            $activity->responsible = $this->person->get_by_id($activity->person_id)->name;
            $operation_type = $this->operation_type->get_by_id($activity->operation_type_id);
            $this->load_view_mechanic('activity_mechanic/update', ['activity' => $activity, 'operation_type' => $operation_type->comment]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function update_activity_execute() {
        $description = $this->input->post('description');
        $time_used = $this->input->post('time_used');
        $state = $this->input->post('state');
        $activity_id = $this->input->post('activity_id');

        $this->form_validation->set_rules('description', translate('description'), 'trim|required|min_length[5]|max_length[256]');
        //si el estado que llega es distinto de pendiente el tiempo es obligatorio
        if ($state != 0) {
            $this->form_validation->set_rules('time_used', translate('time_used_hr'), 'required|numeric');
        }
        $this->form_validation->set_rules('state', translate('state'), 'required|numeric');
        $this->form_validation->set_rules('activity_id', translate('activity_id'), 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("Mechanic/update_activity/$activity_id");
        } else {
            $data = [
                'description' => $description,
                'state' => $state,
                'time_used' => $time_used
            ];

            $this->operation->update($activity_id, $data);
            $this->response->set_message(translate("activity_updated"), ResponseMessage::SUCCESS);
            redirect("Mechanic/activities/" . $this->mechanic['person_id']);
        }
    }

    //vista actualizar propuesta
    function update_activity_proposed($activity_id = 0) {
        $activity = $this->operation->get_by_id($activity_id);
        //se valida si no es una propuesta
        if ($activity AND $activity->state == 2) {
            $activity->responsible = $this->person->get_by_id($activity->person_id)->name;
            $operation_types = $this->operation_type->get_all();
            $work_orders = $this->work_order->get_works_by_person($this->mechanic['person_id']);
            $this->load_view_mechanic('activity_mechanic/update_proposed', ['activity' => $activity, 'operation_types' => $operation_types, 'work_orders' => $work_orders]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //obtener y actualizar la propuesta
    function update_activity_proposed_execute() {
        $operation_type = $this->input->post('operation_type');
        $description = $this->input->post('description');
        $time_estimated = $this->input->post('time_estimated');
        $activity_id = $this->input->post('activity_id');

        $errors = [];
        if ($operation_type == -1) {
            $errors[] = translate('please_select_operation_type');
        }

        if ($work_order_id == -1) {
            $errors[] = translate('work_orders_selected');
        }

        if (count($errors)) {
            $this->response->set_message($errors, ResponseMessage::ERROR);
            redirect("Mechanic/update_activity_proposed/$activity_id");
        } else {
            $this->form_validation->set_rules('description', translate('description'), 'trim|required|min_length[5]|max_length[256]');
            $this->form_validation->set_rules('time_estimated', translate('time_estimated_hr'), 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
                redirect("Mechanic/update_activity_proposed/$activity_id");
            } else {
                $data = [
                    'time_estimated_hours' => $time_estimated,
                    'description' => $description,
                    'operation_type_id' => $operation_type
                ];

                $this->operation->update($activity_id, $data);

                $this->response->set_message(translate("activity_updated"), ResponseMessage::SUCCESS);
                redirect("Mechanic/activities");
            }
        }
    }

    //mostrar la vista de nueva actividad
    function new_activity() {
        $work_orders = $this->work_order->get_works_by_person($this->mechanic['person_id']);
        if ($work_orders) {
            $operation_types = $this->operation_type->get_all();
            $this->load_view_mechanic('activity_mechanic/new_activity', ['work_orders' => $work_orders, 'operation_types' => $operation_types]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //obtener y salvar la nueva actividad
    function new_activity_execute() {
        $operation_type = $this->input->post('operation_type');
        $description = $this->input->post('description');
        $time_estimated = $this->input->post('time_estimated');
        $work_order_id = $this->input->post('work_order_id');

        $errors = [];
        if ($operation_type == -1) {
            $errors[] = translate('please_select_operation_type');
        }

        if ($work_order_id == -1) {
            $errors[] = translate('work_orders_selected');
        }

        if (count($errors)) {
            $this->response->set_message($errors, ResponseMessage::ERROR);
            redirect("Mechanic/new_activity/$work_order_id");
        } else {
            $this->form_validation->set_rules('description', translate('description'), 'trim|required|min_length[5]|max_length[256]');
            $this->form_validation->set_rules('time_estimated', translate('time_estimated_hr'), 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
                redirect("Mechanic/new_activity");
            } else {
                $data = [
                    'time_estimated_hours' => $time_estimated,
                    'description' => $description,
                    'state' => 2,
                    'price' => 0,
                    'operation_type_id' => $operation_type,
                    'work_order_id' => $work_order_id,
                    'person_id' => $this->mechanic['person_id']
                ];

                $this->operation->create($data);

                $this->response->set_message(translate("activity_created"), ResponseMessage::SUCCESS);
                redirect("Mechanic/activities");
            }
        }
    }

    /*     * ****** CRUD OBESRVATION ******** */

    function observation() {
        $observation = $this->observation->get_by_mechanic($this->mechanic['person_id']);
        foreach ($observation as $act) {
            $act->operation = $this->operation->get_by_id($act->operation_id)->description;
            $act->observation_state = $this->_get_state($act->observation_state);
        }
        $this->load_view_mechanic('observation_mechanic/observations', [ 'observations' => $observation]);
    }

    function observation_by_operation($id_operation) {
        $observation = $this->observation->get_by_mechanic_and_operation($this->mechanic['person_id'], $id_operation);
        $operation = $this->operation->get_by_id($id_operation);
        $operation->responsible = $this->person->get_by_id($operation->person_id)->name;
        $operation->state = $this->_get_state($operation->state);

        foreach ($observation as $act) {
            $act->observation_state = $this->_get_state($act->observation_state);
        }
        $this->load_view_mechanic('observation_mechanic/observations_operation', [ 'observations' => $observation, 'operation' => $operation]);
    }

    //mostrar la vista la nueva observacion
    function new_observation($operation_id = null) {
        if (!empty($operation_id)) {
            $operation = $this->operation->get_by_id($operation_id);
            $operation->responsible = $this->person->get_by_id($operation->person_id)->name;
            $operation->state = $this->_get_state($operation->state);
            $this->load_view_mechanic('observation_mechanic/new_observation', ['operation' => $operation]);
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
            redirect("Mechanic/new_observation/$operation_id");
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
            redirect("Mechanic/observation_by_operation/" . $operation_id);
        }
    }

    function update_observation($observation_id) {
        $observation = $this->observation->get_by_id($observation_id);
        $operation = $this->operation->get_by_id($observation->operation_id);
        $operation->responsible = $this->person->get_by_id($operation->person_id)->name;
        $operation->state = $this->_get_state($operation->state);

        if ($observation) {
            $this->load_view_mechanic('observation_mechanic/update', ['observation' => $observation, 'operation' => $operation]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    //obtener y actualizar la observacion
    function update_observation_execute() {
        $operation_id = $this->input->post('operation_id');
        $comment = $this->input->post('comment');
        //$observation_state = $this->input->post('observation_state');
        $observation_id = $this->input->post('observation_id');

        $this->form_validation->set_rules('comment', translate('comment'), 'trim|required|min_length[5]|max_length[1000]');
        $this->form_validation->set_rules('operation_id', translate('operation_id'), 'required|numeric');
        $this->form_validation->set_rules('observation_id', translate('observation_id'), 'required|numeric');
        //$this->form_validation->set_rules('observation_state', translate('observation_state'), 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("Mechanic/new_observation/$operation_id");
        } else {
            $data = [
                'comment' => $comment,
            ];
            //echo "<pre>";print_r($data);die;
            $this->observation->update($observation_id, $data);

            $this->response->set_message(translate("observation_updated"), ResponseMessage::SUCCESS);
            redirect("Mechanic/observation");
        }
    }

    function erase_observation($observation_id) {
        $observation = $this->observation->get_by_id($observation_id);
        //verificamos que este en estado pendiente para evitar eliminaciones via url post
        if ($observation->observation_state == 0) {
            if ($this->observation->delete($observation_id)) {
                $this->response->set_message(translate("observation_succesfully_deleted"), ResponseMessage::SUCCESS);
                redirect("Mechanic/observation");
            } else {
                $this->load->view("errors/error_404");
            }
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
            default:
                return translate("state_pending");
        }
    }

}
