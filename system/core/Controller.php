<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author    EllisLab Dev Team
 * @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright    Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link    http://codeigniter.com
 * @since    Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Libraries
 * @author        EllisLab Dev Team
 * @link        http://codeigniter.com/user_guide/general/controllers.html
 */
require_once APPPATH . "/libraries/ResponseMessage.php";

class CI_Controller {

    /**
     * Reference to the CI singleton
     *
     * @var    object
     */
    private static $instance;

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct() {
        self::$instance = &$this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->$var = &load_class($class);
        }

        $this->load = &load_class('Loader', 'core');
        $this->load->initialize();

        log_message('info', 'Controller Class Initialized');

        //Mabuya stuff
        $this->load->helper(['form', 'url', 'mabuya']);
        $this->load->library(["session", "form_validation", "cart"]);

        $this->response = new ResponseMessage();
        
        $this->config->load('es_lang');
    }
    
    function init_form_validation() {
        $this->form_validation->set_message('required', translate('required'));
        $this->form_validation->set_message('min_length', translate('min_length'));
        $this->form_validation->set_message('max_length', translate('max_length'));
        $this->form_validation->set_message('valid_email', translate('valid_email'));
        $this->form_validation->set_message('matches', translate('matches'));
        $this->form_validation->set_message('is_unique', translate('is_unique'));
        $this->form_validation->set_message('numeric', translate('numeric'));
        $this->form_validation->set_message('exact_length', translate('exact_length'));
        $this->form_validation->set_message('greater_than', translate('greater_than'));
        $this->form_validation->set_message('less_than', translate('less_than'));
        $this->form_validation->set_message('alpha', translate('alpha'));
        $this->form_validation->set_message('alpha_numeric', translate('alpha_numeric'));
        $this->form_validation->set_message('alpha_dash', translate('alpha_dash'));
        $this->form_validation->set_message('integer', translate('integer'));
        $this->form_validation->set_message('decimal', translate('decimal'));
        $this->form_validation->set_message('is_natural', translate('is_natural'));
        $this->form_validation->set_message('is_natural_no_zero', translate('is_natural_no_zero'));
        $this->form_validation->set_message('valid_emails', translate('valid_emails'));
        $this->form_validation->set_message('valid_ip', translate('valid_ip'));
        $this->form_validation->set_message('valid_base64', translate('valid_base64'));
        $this->form_validation->set_message('alpha_numeric_space', translate('alpha_numeric_space'));
        $this->form_validation->set_message('valid_url', translate('valid_url'));
    }

    // --------------------------------------------------------------------

    /**
     * Get the CI singleton
     *
     * @static
     * @return    object
     */
    public static function &get_instance() {
        return self::$instance;
    }

    public function load_view_admin($url = "", $data = [], $like_file = False) {
        $this->load->view("admin/header");
        $this->load->view($url, $data, $like_file);
        $this->load->view("admin/footer");
    }
    
    public function load_view_mechanic($url = "", $data = [], $like_file = False) {
        $this->load->view("mechanic/header");
        $this->load->view($url, $data, $like_file);
        $this->load->view("mechanic/footer");
    }
    
    public function load_view_client($url = "", $data = [], $like_file = False) {
        $this->load->view("client/header");
        $this->load->view($url, $data, $like_file);
        $this->load->view("client/footer");
    }

    protected function load_language() {
        if (isset($_SESSION['lang'])) {
            switch ($_SESSION['lang']) {
                case "es" : {
                        $this->config->load('es_lang'); // cargo el idioma espanniol
                        break;
                    }
                case "en": {
                        $this->config->load('en_lang');   // cargo el idioma ingles
                        break;
                    }
                case "por": {
                        $this->config->load("por_lang");
                        break;
                    }
                default : {
                        $this->config->load('es_lang'); // si me pasan otro que no sean los predefinidos, escojo espanniol por defecto
                    }
            }
        } else {
            $this->config->load('es_lang'); // si no hay ninguno seteado, tomo espanniol por defecto 
        }
    }
}

function get_from_post($key){
	$CI = &get_instance();
	return $CI->input->post($key);
}
