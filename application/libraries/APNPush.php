<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppleNotifications
 *
 * @author Hardy
 */
class APNPush {

    public function __construct() {
        
    }

    public function push($deviceTokens, $message, $enterprise_id, $product_id, $device_notification_id) {
        $passphrase = 'VZ12015Ecuador';
        $pemFile = './certificates/VZOne_prod.pem';
        ////////////////////////////////////////////////////////////////////////////////
        
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $pemFile);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp) {
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        }
        
        // Create the payload body
        $body['aps']  = [ 'alert' => $message, 'sound' => 'default' ];
        $body['data'] = ['enterprise_id' => $enterprise_id, 'product_id' => $product_id, 'device_notification_id' => $device_notification_id];

        $payload = json_encode($body);

        if(is_array($deviceTokens)){
            foreach($deviceTokens as $deviceToken){
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                $result = fwrite($fp, $msg, strlen($msg));
            }
        }else {
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceTokens) . pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));
        }
        //Send it to the server
        fclose($fp);
        return (!$result) ? FALSE : TRUE;
    }
}
