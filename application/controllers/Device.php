<?php
/**
 * Created by PhpStorm.
 * User: Hardy
 * Date: 5/8/2015
 * Time: 4:26 PM
 */

require_once(APPPATH . '/libraries/REST_Controller.php');

class Device extends REST_Controller{

    function set_token_get() {
        $token = $this->get('token');
        $imei  = $this->get('imei');
        $type  = $this->get('device_type');

        $this->load->model('subscribed_device_model');
        if ( $token && $imei && in_array($type , ['0', '1'])) {
            $this->subscribed_device_model->set_token($imei, $token, $type);
            $data = array('response' => 'ok');
            return $this->response(json_encode($data), NULL);
        }else{
            $data = array('response' => 'error');
            return $this->response($data, NULL);
        }
    }
}