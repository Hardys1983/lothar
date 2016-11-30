<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends CI_Controller {

    const IMAGE_WIDTH = 1024;
    const IMAGE_HEIGHT = 1024;

    private $admin = null;

    function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $data = $this->session->userdata();
        if ($data['role_id'] == 0) {
            $this->admin = $data;
            $this->load->model("Promotion_model", 'promotion');
            $this->load->model("Picture_model", 'picture');
            $this->init_form_validation();
        } else {
            redirect("Login/index");
        }
    }

    public function index() {
        $this->load_view_admin("dash");
    }

    public function promotion() {
        $promotion = $this->promotion->get_all();
        foreach ($promotion as $n) {
            $n->picture = $this->picture->get_by_id($n->picture_id)->picture_url;
        }
        $this->load_view_admin('promotion/list', ['promotion' => $promotion]);
    }

    function new_promotion() {
        $this->load_view_admin('promotion/new_promotion');
    }

    function new_promotion_execute() {
        $description = $this->input->post('description');
        $begin = $this->input->post('begin');
        $end = $this->input->post('end');

        $this->form_validation->set_rules('begin', translate('begin'), 'required');
        $this->form_validation->set_rules('end', translate('end'), 'required');
        $this->form_validation->set_rules('description', translate('description'), 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("Promotion/new_promotion");
        } else {
            $folder_name = "./uploads/promotion";
            $file_name = time();
            $result = save_image_from_post('picture_id', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

            if ($result[0]) {
                $p = $this->picture->create(array('picture_url' => $result[1]));
                $data = [
                    'description' => $description,
                    'begin' => $begin,
                    'end' => $end,
                    'picture_id' => $p->picture_id];

                $this->promotion->create($data);

                $this->response->set_message(translate("promotion_created"), ResponseMessage::SUCCESS);
                redirect("Promotion/promotion");
            } else {
                $this->response->set_message($result[1], ResponseMessage::ERROR);
                redirect("Promotion/new_promotion");
            }
        }
    }

    function update_promotion($promotion_id) {
        $promotion = $this->promotion->get_by_id($promotion_id);
        if ($promotion) {
            $promotion->picture = $this->picture->get_by_id($promotion->picture_id)->picture_url;
            $this->load_view_admin('promotion/update', ['promotion' => $promotion]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function update_promotion_execute() {
        $description = $this->input->post('description');
        $begin = $this->input->post('begin');
        $end = $this->input->post('end');
        $promotion_id = $this->input->post('promotion_id');

        $this->form_validation->set_rules('begin', translate('begin'), 'required');
        $this->form_validation->set_rules('description', translate('description'), 'required|min_length[5]');
        $this->form_validation->set_rules('end', translate('end'), 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            $this->load_view_admin('promotion/update', array('promotion' => $promotion));
        } else {
            //si el campo imagen no viene vacio insertamos la imagen
            if (!empty($_FILES['picture_id']['name'])) {
                $folder_name = "./uploads/promotion";
                $file_name = time();
                $result = save_image_from_post('picture_id', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

                if ($result[0]) {
                    $p = $this->picture->create(array('picture_url' => $result[1]));
                    $data = [
                        'description' => $description,
                        'begin' => $begin,
                        'end' => $end,
                        'picture_id' => $p->picture_id];
                    //die($state);
                    $this->promotion->update($promotion_id, $data);
                    unlink($promotion->picture_id);
                    $this->response->set_message(translate("promotion_updated"), ResponseMessage::SUCCESS);
                    redirect("Promotion/promotion");
                } else {
                    $this->response->set_message(translate("promotion_created"), ResponseMessage::SUCCESS);
                    $this->load_view_admin('promotion/update', array('promotion' => $promotion));
                }
            } else {
                $data = [
                    'description' => $description,
                    'begin' => $begin,
                    'end' => $end];
                //die($state);
                $this->promotion->update($promotion_id, $data);
                $this->response->set_message(translate("promotion_updated"), ResponseMessage::SUCCESS);
                redirect("Promotion/promotion");
            }
        }

        $this->load_view_admin('Promotion/promotion');
    }

    function erase_promotion($promotion_id = 0) {
        $promotion = $this->promotion->get_by_id($promotion_id);
        if ($this->promotion->delete($promotion_id)) {
            unlink($promotion->picture_id);
            $this->response->set_message(translate("promotion_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("Promotion/promotion");
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function save_image() {
        $folder_name = "./uploads/promotion";
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
                return translate("state_pending");
        }
    }

}
