<?php


defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';


class User_accounts extends REST_Controller {
    function __construct($config = 'rest') {
        parent::__construct($config);
        
        $this->auth = new stdClass;

        $this->load->library('flexi_auth');	        
        $this->load->model('flexi_auth_model');
    }
    
    public function index_post() {
        
        $userID = $this->flexi_auth_model->insert_user($this->query('email'), $this->query('username'), $this->query('password'));
        
        $this->response(array("user_id" => $userID));
    }
    
    public function auth_post() {
        
    }
}