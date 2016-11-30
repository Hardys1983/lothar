<?php

/**
 * Created by PhpStorm.
 * User: Hardy
 * Date: 5/4/2015
 * Time: 11:20 AM
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('image_resize')) {
    require(APPPATH . '/libraries/ImageManipulator.php');

    function image_resize($src, $dst, $width, $height, $crop = 1)
    {
        $imageManipulator = new ImageManipulator();

        $imageManipulator->setImageFile($src);
        $imageManipulator->resample($width, $height, FALSE);

        try {
            $imageManipulator->save($dst);
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }
}


if (!function_exists('translate')) {

    function translate($key)
    {
        $ci = &get_instance();
        return $ci->config->item($key);
    }

}


if (!function_exists('get_image_extension')) {

    function get_image_extension($img_type)
    {
        if (empty($img_type))
            return false;

        switch ($img_type) {
            case 'image/bmp':
                return '.bmp';
            case 'image/gif':
                return '.gif';
            case 'image/jpeg':
                return '.jpg';
            case 'image/png':
                return '.png';
            case 'image/x-icon' :
                return '.ico';
            default:
                return false;
        }
    }

}

//Devuelve una tupla (TRUE | FALSE, IMAGE_PATH | ERROR_MESSAGE )
if (!function_exists('save_image_from_post')) {
    function save_image_from_post($image_control, $folder, $image_name, $width = 0, $height = 0)
    {
        if ($_FILES[$image_control]['error'] != UPLOAD_ERR_OK) {
            return [FALSE, get_upload_error_message($_FILES[$image_control]['error'])];
        }

        $img_ext = get_image_extension($_FILES[$image_control]["type"]);
        if ($img_ext) {
            if (!is_dir($folder)) {
                if (!mkdir($folder, DIR_READ_MODE, TRUE)) {
                    return [FALSE, "Folder $folder could not be created"];
                }
            }
            $image_path = $folder . "/" . $image_name . $img_ext;
            $image_path_tmp = $folder . "/" . $image_name . "temp" . $img_ext;

            if ($width != 0 && $height != 0) {
                $valid_copy = copy($_FILES[$image_control]["tmp_name"], $image_path_tmp);
                if ($valid_copy == FALSE) {
                    return array(FALSE, "The file can't be overwritten");
                }

                $result = image_resize($image_path_tmp, $image_path, $width, $height);
                if (is_bool($result)) {
                    unlink($image_path_tmp);
                    return array(TRUE, $image_path);
                }
            } else {
                $valid_copy = copy($_FILES[$image_control]["tmp_name"], $image_path);
                if ($valid_copy == FALSE) {
                    return array(FALSE, "The file can't be overwritten");
                }
                return array(TRUE, $image_path);
            }
        } else {
            $file_name = $_FILES[$image_control]['name'];
            return array(FALSE, "The file $file_name is not allowed because it's extension");
        }
    }
}


if (!function_exists('send_email')) {
    require_once(APPPATH . '/libraries/Mandrill.php');
	
    function send_email($body, $subject, $emails)
    {
    	$to_send = [];
    	if(is_array($emails)){
    		foreach($emails as $email){
    			$to_send[] = ['email' => $email, 'name' => '', 'type' => 'to'];
    		}
    	}else{
    		$to_send[] = ['email' => $emails, 'name' => '', 'type' => 'to'];
    	}
    
    	try{
    		$mandrill = new Mandrill('BOpQzKKzpCxY5Wa9UXgyMw');
    		$request = [
    				'html' => $body,
    				'subject' => $subject,
    				'from_email' => "service@gadsapp.com",
    				'from_name' => "Gadsapp",
    				'to' => $to_send,
    				'headers' => ['Reply-To' => ''],
    				'important' => false,
    				'track_opens' => null,
    				'track_clicks' => null,
    				'auto_text' => null,
    				'auto_html' => null,
    				'inline_css' => null,
    				'url_strip_qs' => null,
    				'preserve_recipients' => null,
    				'view_content_link' => null,
    				'bcc_address' => 'message.bcc_address@example.com',
    				'tracking_domain' => null,
    				'signing_domain' => null,
    				'return_path_domain' => null,
    				'merge' => true
    		];
    		return $mandrill->messages->send($request, FALSE, NULL, NULL);
    	}catch(Mandrill_Error $e){
    		echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    		die();
    	}
    }
}

//http://webdesign.about.com/od/multimedia/a/mime-types-by-content-type.htm
//image/png
//application/vnd.android.package-archive

if (!function_exists('download_file')) {

    function download_file($file_name, $content_type = 'image/png')
    {
        if (file_exists($file_name)) {
            header('Content-Description: File Transfer');
            header("Content-Type: $content_type");
            header('Content-Disposition: attachment; filename=' . basename($file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_name));

            ob_clean();
            flush();
            readfile($file_name);
            exit;
        }
    }

}

if (!function_exists('get_upload_error_message')) {

    function get_upload_error_message($code_error)
    {
        switch ($code_error) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }
}


//Example
/*
  $result = upload_from_post("imagen", "./uploads/perfil", "foto1.jpg");
  if($result[0]){
  //almacenar $result[1]
  $this->response->set_message("Todo ok", ResponseMessage::SUCCESS);
  }else{
  $this->response->set_message($result[1], ResponseMessage::ERROR);
  }
 */
if (!function_exists('upload_from_post')) {

    function upload_from_post($control_name, $folder, $file_name, $size_bytes = 2097152)
    {
        if (!is_dir($folder)) {
            if (!mkdir($folder, DIR_READ_MODE, TRUE)) {
                return [FALSE, "Folder $folder could not be created"];
            }
        }

        if ($_FILES[$control_name]['error'] == UPLOAD_ERR_OK) {

            if (filesize($_FILES[$control_name]["tmp_name"]) > $size_bytes) {
                return [FALSE, "the file can't be bigger than $size_bytes bytes"];
            }

            $file_name = $folder . '/' . $file_name;
            if (file_exists($file_name)) {
                unlink($file_name);
            }

            if (copy($_FILES[$control_name]["tmp_name"], $file_name)) {
                return [TRUE, $file_name];
            } else {
                return [FALSE, "The file could not be written"];
            }
        } else {
            return [FALSE, get_upload_error_message($_FILES[$control_name]['error'])];
        }
    }

}

if (!function_exists('object_to_array')) {

    function object_to_array($d)
    {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return array_map(__FUNCTION__, $d);
        } else {
            // Return array
            return $d;
        }
    }

}

if (!function_exists('array_to_object')) {

    function array_to_object($d)
    {
        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return (object)array_map(__FUNCTION__, $d);
        } else {
            // Return object
            return $d;
        }
    }

}


if (!function_exists('current_page_url')) {

    function current_page_url()
    {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .=
                $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

}


if (!function_exists("random_string")) {
    function random_string($length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
    {
        return substr(str_shuffle($chars), 0, $length);
    }
}

if (!function_exists("is_real_url")) {
    function is_real_url($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return FALSE;
        }

        if (@fopen($url, "r")) {
            return TRUE;
        } else {
            return FALSE;
        }
        return FALSE;
    }
}

if (!function_exists('get_youtube_id')) {
    function get_youtube_id($url)
    {
        $parts = parse_url($url);
        if (isset($parts['query'])) {
            parse_str($parts['query'], $qs);

            if (isset($qs['v'])) {
                return $qs['v'];
            } else if (isset($qs['vi'])) {
                return $qs['vi'];
            }
        }
        
        if (isset($parts['path'])) {
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path) - 1];
        }
        return false;
    }
}

//"", android, ios
if (!function_exists('get_device_connected')) {
    function get_device_connected()
    {
        if (stripos($_SERVER['HTTP_USER_AGENT'], 'android') !== FALSE) {
            return "android";
        }

        foreach (['iphone', 'ipad', 'ipod'] as $dev) {
            if (stripos($_SERVER['HTTP_USER_AGENT'], $dev) !== FALSE) {
                return "ios";
            }
        }
        return "";
    }
}

if (!function_exists('alpha_numeric_space')) {
    function alpha_numeric_space($str)
    {
        return (preg_match("/^([a-z0-9A-Z])+$/i", $str) ? TRUE : FALSE);
    }
}

