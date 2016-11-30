<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    const IMAGE_WIDTH = 1024;
    const IMAGE_HEIGHT = 1024;

    private $admin = null;

    function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $data = $this->session->userdata();
        if ($data['role_id'] == 0) {
            $this->admin = $data;
            $this->load->model("Service_model", 'service');
            $this->load->model("Picture_model", 'picture');
            $this->init_form_validation();
        } else {
            redirect("Login/index");
        }
    }

    public function index() {
        $this->load_view_admin("dash");
    }

    public function service() {
        $service = $this->service->get_all();
        foreach ($service as $n) {
            $n->picture = $this->picture->get_by_id($n->picture_id)->picture_url;
            $n->state = $this->_get_state($n->state);
        }
        $this->load_view_admin('service/list', ['service' => $service]);
    }

    function new_service() {
        $this->load_view_admin('service/new_service');
    }

    function new_service_execute() {
        $description = $this->input->post('description');
        $state = $this->input->post('state');
        $title = $this->input->post('title');

        $this->form_validation->set_rules('state', translate('state'), 'required|is_numeric');
        $this->form_validation->set_rules('title', translate('title'), 'required|min_length[5]');
        $this->form_validation->set_rules('description', translate('description'), 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("Service/new_service");
        } else {
            $folder_name = "./uploads/service";
            $file_name = time();
            $result = save_image_from_post('picture_id', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

            if ($result[0]) {
                $p = $this->picture->create(array('picture_url' => $result[1]));
                $data = [
                    'description' => $description,
                    'state' => $state,
                    'title' => $title,
                    'picture_id' => $p->picture_id];

                $this->service->create($data);

                $this->response->set_message(translate("service_created"), ResponseMessage::SUCCESS);
                redirect("Service/service");
            } else {
                $this->response->set_message($result[1], ResponseMessage::ERROR);
                redirect("Service/new_service");
            }
        }
    }

    function update_service($service_id) {
        $service = $this->service->get_by_id($service_id);
        if ($service) {
            $service->picture = $this->picture->get_by_id($service->picture_id)->picture_url;
            $this->load_view_admin('service/update', ['service' => $service]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function update_service_execute() {
        $description = $this->input->post('description');
        $state = $this->input->post('state');
        $title = $this->input->post('title');
        $service_id = $this->input->post('service_id');

        $this->form_validation->set_rules('state', translate('state'), 'required');
        $this->form_validation->set_rules('description', translate('description'), 'required|min_length[5]');
        $this->form_validation->set_rules('title', translate('title'), 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            $this->load_view_admin('service/update', array('service' => $service));
        } else {
            //si el campo imagen no viene vacio insertamos la imagen
            if (!empty($_FILES['picture_id']['name'])) {
                $folder_name = "./uploads/service";
                $file_name = time();
                $result = save_image_from_post('picture_id', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

                if ($result[0]) {
                    $p = $this->picture->create(array('picture_url' => $result[1]));
                    $data = [
                        'description' => $description,
                        'state' => $state,
                        'title' => $title,
                        'picture_id' => $p->picture_id];
                    //die($state);
                    $this->service->update($service_id, $data);
                    unlink($service->picture_id);
                    $this->response->set_message(translate("service_updated"), ResponseMessage::SUCCESS);
                    redirect("Service/service");
                } else {
                    $this->response->set_message(translate("service_created"), ResponseMessage::SUCCESS);
                    $this->load_view_admin('service/update', array('service' => $service));
                }
            } else {
                $data = [
                    'description' => $description,
                    'state' => $state,
                    'title' => $title];
                //die($state);
                $this->service->update($service_id, $data);
                $this->response->set_message(translate("service_updated"), ResponseMessage::SUCCESS);
                redirect("Service/service");
            }
        }

        $this->load_view_admin('Service/service');
    }

    function erase_service($service_id = 0) {
        $service = $this->service->get_by_id($service_id);
        if ($this->service->delete($service_id)) {
            unlink($service->picture_id);
            $this->response->set_message(translate("service_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("Service/service");
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function save_image() {
        $folder_name = "./uploads/service";
        $file_name = random_string('unique', 8);
        $result = save_image_from_post('picture_id', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
        echo $result;
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
                return translate("state_ptitleing");
        }
    }

}
