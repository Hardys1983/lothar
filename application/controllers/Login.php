<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library(array('session'));
        $this->load->helper("mabuya");
        $this->load->model('Person_model', "person");

        @session_start();
        $this->load_language();
    }

    public function index() {
        $this->load->view('login');
    }

    public function auth() {
        $username = $this->input->post('email');
        $password = $this->input->post('password');

        $session_data = $this->person->get_all(['email' => $username, 'password' => md5($password)]);

        if ($session_data != NULL) {
            unset($session_data[0]->password);
            $this->session->set_userdata(object_to_array($session_data[0]));
            //redirigir al administrador
            if ($session_data[0]->role_id == 0) {
                redirect("Welcome/index");
            } else
            //redirigir al mecanico
            if ($session_data[0]->role_id == 1) {
                redirect("Mechanic/activities");
            } else
            //redirigir al cliente
            if ($session_data[0]->role_id == 2) {
                redirect("Client/vehicles");
            }
        } else {
            redirect("Login/index");
        }
    }

    public function logout() {
        foreach ($this->session->userdata() as $key => $data) {
            $this->session->unset_userdata($key);
        }
        redirect("Login/index");
    }

}
