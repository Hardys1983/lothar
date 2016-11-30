<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

    const IMAGE_WIDTH = 1920;
    const IMAGE_HEIGHT = 500;

    private $admin = null;

    function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $data = $this->session->userdata();
        if ($data['role_id'] == 0) {
            $this->admin = $data;
            $this->load->model("Banner_model", 'banner');
            $this->load->model("Picture_model", 'picture');
            $this->init_form_validation();
        } else {
            redirect("Login/index");
        }
    }

    public function index() {
        $this->load_view_admin("dash");
    }

    public function banner() {
        $banner = $this->banner->get_all();
        foreach ($banner as $n) {
            $n->picture = $this->picture->get_by_id($n->picture_id)->picture_url;
            $n->state = $this->_get_state($n->state);
        }
        $this->load_view_admin('banner/list', ['banner' => $banner]);
    }

    function new_banner() {
        $this->load_view_admin('banner/new_banner');
    }

    function new_banner_execute() {
        $sub_title = $this->input->post('sub_title');
        $state = $this->input->post('state');
        $title = $this->input->post('title');

        $this->form_validation->set_rules('state', translate('state'), 'required|is_numeric');
        $this->form_validation->set_rules('title', translate('title'), 'required|min_length[5]');
        $this->form_validation->set_rules('sub_title', translate('sub_title'), 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("Banner/new_banner");
        } else {
            $folder_name = "./uploads/banner";
            $file_name = time();
            $result = save_image_from_post('picture_id', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

            if ($result[0]) {
                $p = $this->picture->create(array('picture_url' => $result[1]));
                $data = [
                    'sub_title' => $sub_title,
                    'state' => $state,
                    'title' => $title,
                    'picture_id' => $p->picture_id];

                $this->banner->create($data);

                $this->response->set_message(translate("banner_created"), ResponseMessage::SUCCESS);
                redirect("Banner/banner");
            } else {
                $this->response->set_message($result[1], ResponseMessage::ERROR);
                redirect("Banner/new_banner");
            }
        }
    }

    function update_banner($banner_id) {
        $banner = $this->banner->get_by_id($banner_id);
        if ($banner) {
            $banner->picture = $this->picture->get_by_id($banner->picture_id)->picture_url;
            $this->load_view_admin('banner/update', ['banner' => $banner]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function update_banner_execute() {
        $sub_title = $this->input->post('sub_title');
        $state = $this->input->post('state');
        $title = $this->input->post('title');
        $banner_id = $this->input->post('banner_id');

        $this->form_validation->set_rules('state', translate('state'), 'required');
        $this->form_validation->set_rules('sub_title', translate('sub_title'), 'required|min_length[5]');
        $this->form_validation->set_rules('title', translate('title'), 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            $this->load_view_admin('banner/update', array('banner' => $banner));
        } else {
            //si el campo imagen no viene vacio insertamos la imagen
            if (!empty($_FILES['picture_id']['name'])) {
                $folder_name = "./uploads/banner";
                $file_name = time();
                $result = save_image_from_post('picture_id', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

                if ($result[0]) {
                    $p = $this->picture->create(array('picture_url' => $result[1]));
                    $data = [
                        'sub_title' => $sub_title,
                        'state' => $state,
                        'title' => $title,
                        'picture_id' => $p->picture_id];
                    //die($state);
                    $this->banner->update($banner_id, $data);
                    unlink($banner->picture_id);
                    $this->response->set_message(translate("banner_updated"), ResponseMessage::SUCCESS);
                    redirect("Banner/banner");
                } else {
                    $this->response->set_message(translate("banner_created"), ResponseMessage::SUCCESS);
                    $this->load_view_admin('banner/update', array('banner' => $banner));
                }
            } else {
                $data = [
                    'sub_title' => $sub_title,
                    'state' => $state,
                    'title' => $title];
                //die($state);
                $this->banner->update($banner_id, $data);
                $this->response->set_message(translate("banner_updated"), ResponseMessage::SUCCESS);
                redirect("Banner/banner");
            }
        }

        $this->load_view_admin('Banner/banner');
    }

    function erase_banner($banner_id = 0) {
        $banner = $this->banner->get_by_id($banner_id);
        if ($this->banner->delete($banner_id)) {
            unlink($banner->picture_id);
            $this->response->set_message(translate("banner_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("Banner/banner");
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function save_image() {
        $folder_name = "./uploads/banner";
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
