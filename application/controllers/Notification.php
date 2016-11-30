<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notification
 *
 * @author Hardy
 */

require_once APPPATH . "./libraries/GCMPush.php";
        
class Notification extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->helper(['url','form']);
        $this->load->helper('mabuya');
    }
    
    public function index(){
        $this->load_view_admin("notification/index");
    }
    
    public function send(){
        $this->load->model("subscribed_device_model", "subscribed_device");
        $devices = $this->subscribed_device->get_all();
        
        
        if ($devices) {
            $tokens = [];
            foreach ($devices as $device) {
                if ($device->device_type == 0) {
                    $tokens[] = $device->subscribed_device_token;
                }
            }
            
            if (count($tokens) > 0) {
                $gcm = new GCMPushMessage("AIzaSyCMkJ7eNY-CAbKcEW6_2AZUERaQ70O694s");
                $gcm->setDevices($tokens);
                
                $header      = $this->input->post("header");
                $description = $this->input->post("description");
                
                $gcm->send( "", ['title' => $header, 'data' => $description ] );
            }
        }
        redirect("notification/index", "location", 301);
    }
}
