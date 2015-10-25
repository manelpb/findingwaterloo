<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class User_rank extends REST_Controller {

    function __construct($config = 'rest') {

        parent::__construct($config);

        $this->auth = new stdClass;

        $this->load->model('user_rank_model');
    }
    
    public function index_get() {
        $this->response($this->user_rank_model->get_all());
    }
}
