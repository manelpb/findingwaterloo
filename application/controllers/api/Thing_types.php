<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';


class Thing_Types extends REST_Controller {
    
    function __construct($config = 'rest') {
        parent::__construct($config);
        
        $this->load->model('thing_types_model');
    }

    public function index_get() {
        $things = $this->thing_types_model->get_all();
        $this->response($things);
    }

}
