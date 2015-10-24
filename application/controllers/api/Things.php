<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Things extends REST_Controller {
    
    function __construct($config = 'rest') {
        parent::__construct($config);
        
        $this->load->model('things_model');
    }

    public function index_get() {
        $things = $this->things_model->get_all();
        
        $arInfo = array();
        
        foreach($things as $thing) {
            $thing->tgh_geo = unserialize($thing->tgh_geo);
        }
        
        $this->response($things);
    }

}
