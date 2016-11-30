<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    const IMAGE_WIDTH = 1024;
    const IMAGE_HEIGHT = 1024;

    private $admin = null;

    function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $data = $this->session->userdata();
        if ($data['role_id'] == 0) {
            $this->admin = $data;
            $this->load->model("News_model", 'news');
            $this->init_form_validation();
        } else {
            redirect("Login/index");
        }
    }

    public function index() {
        $this->load_view_admin("dash");
    }

    public function news() {
        $news = $this->news->get_all();
        foreach ($news as $n) {
            $n->state = $this->_get_state($n->state);
        }
        $this->load_view_admin('news/list', ['news' => $news]);
    }

    function new_news() {
        $this->load_view_admin('news/new_news');
    }

    function new_news_execute() {
        $content = $this->input->post('content');
        $date = $this->input->post('date');
        $title = $this->input->post('title');
        $state = $this->input->post('state');

        $this->form_validation->set_rules('date', translate('date'), 'required');
        $this->form_validation->set_rules('content', translate('content'), 'required|min_length[5]');
        $this->form_validation->set_rules('title', translate('title'), 'required|min_length[5]');
        $this->form_validation->set_rules('state', translate('state'), 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            redirect("News/new_news");
        } else {
            $folder_name = "./uploads/news";
            $file_name = time();
            $result = save_image_from_post('main_image', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

            if ($result[0]) {
                $data = [
                    'content' => $content,
                    'date' => $date,
                    'title' => $title,
                    'state' => $state,
                    'main_image' => $result[1]];

                $this->news->create($data);

                $this->response->set_message(translate("news_created"), ResponseMessage::SUCCESS);
                redirect("News/news");
            } else {
                $this->response->set_message($result[1], ResponseMessage::ERROR);
                redirect("News/new_news");
            }
        }
    }

    function update_news($news_id) {
        $news = $this->news->get_by_id($news_id);
        if ($news) {
            $this->load_view_admin('news/update', ['news' => $news]);
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function update_news_execute() {
        $content = $this->input->post('content');
        $date = $this->input->post('date');
        $title = $this->input->post('title');
        $state = $this->input->post('state');
        $news_id = $this->input->post('news_id');
        
        $this->form_validation->set_rules('date', translate('date'), 'required');
        $this->form_validation->set_rules('content', translate('content'), 'required|min_length[5]');
        $this->form_validation->set_rules('title', translate('title'), 'required|min_length[5]');
        $this->form_validation->set_rules('state', translate('state'), 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->response->set_message(validation_errors(), ResponseMessage::ERROR);
            $this->load_view_admin('news/update', array('news' => $news));
        } else {
            //si el campo imagen no viene vacio insertamos la imagen
            if (!empty($_FILES['main_image']['name'])) {
                //print_r($_FILES['main_image']);die('entro');
                $folder_name = "./uploads/news";
                $file_name = time();
                $result = save_image_from_post('main_image', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

                if ($result[0]) {
                    $data = [
                        'content' => $content,
                        'date' => $date,
                        'title' => $title,
                        'state' => $state,
                        'main_image' => $result[1]];
                    //die($state);
                    $this->news->update($news_id,$data);
                    unlink($news->main_image);
                    $this->response->set_message(translate("news_updated"), ResponseMessage::SUCCESS);
                    redirect("News/news");
                } else {
                    $this->response->set_message(translate("news_created"), ResponseMessage::SUCCESS);
                    $this->load_view_admin('news/update', array('news' => $news));
                }
            } else {
                $data = [
                    'content' => $content,
                    'date' => $date,
                    'title' => $title,
                    'state' => $state];
                    //die($state);
                $this->news->update($news_id,$data);
                $this->response->set_message(translate("news_updated"), ResponseMessage::SUCCESS);
                redirect("News/news");
            }
        }

        $this->load_view_admin('News/news');
    }

    function erase_news($news_id = 0) {
        $news = $this->news->get_by_id($news_id);
        if ($this->news->delete($news_id)) {
            unlink($news->main_image);
            $this->response->set_message(translate("news_succesfully_deleted"), ResponseMessage::SUCCESS);
            redirect("News/news");
        } else {
            $this->load->view("errors/error_404");
        }
    }

    function save_image() {
        $folder_name = "./uploads/news";
        $file_name = random_string('unique', 8);
        $result = save_image_from_post('main_image', $folder_name, $file_name, self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
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
