<?php
/**
 * Created by PhpStorm.
 * User: Hardy
 * Date: 5/6/2015
 * Time: 5:31 PM
 */

class ResponseMessage {

    private $success_prefix;
    private $success_suffix;

    private $error_prefix;
    private $error_suffix;

    const ERROR   = 0;
    const SUCCESS = 1;

    private $message_mode = self::ERROR;
    private $messages     = [];

    private static $instance = NULL;

    public function __construct(){
        $this->success_prefix = "<div class='alert alert-success'>";
        $this->success_suffix = '</div>';

        $this->error_prefix = "<div class='alert alert-warning'>";
        $this->error_suffix = '</div>';
    }

    public  function set_success_delimiters($prefix, $suffix){
        $this->success_prefix = $prefix;
        $this->success_suffix = $suffix;
    }

    public  function set_error_delimiters($prefix, $suffix){
        $this->error_prefix = $prefix;
        $this->error_suffix = $suffix;
    }

    public  function set_message($messages, $error_type = self::SUCCESS){
        $this->message_mode = ( $error_type === self::ERROR ? self::ERROR : self::SUCCESS );
        if(is_array($messages)){
            $this->messages = $messages;
        }else{
            $this->messages   = [];
            $this->messages[] = $messages;
        }

        $ci = &get_instance();
        $ci->session->set_flashdata("response_message_validation", $this->get_formatted_message());
    }

    private  function get_formatted_message(){
        if(count($this->messages) == 0){
            return '';
        }
        $prefix =  $this->message_mode == self::ERROR ? $this->error_prefix : $this->success_prefix;
        $suffix =  $this->message_mode == self::ERROR ? $this->error_suffix : $this->success_suffix;

        $result = "";
        foreach($this->messages as $message){
            $result.= $prefix.$message.$suffix;
        }
        return $result;
    }
}

function get_message_from_operation(){
    $ci = &get_instance();
    return $ci->session->flashdata("response_message_validation");
}
