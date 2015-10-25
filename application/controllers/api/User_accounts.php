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
        $this->load->model('user_accounts_model');
    }

    public function index_post() {
        $userID = $this->flexi_auth_model->insert_user($this->post('email'), $this->post('username'), $this->post('password'));
        if ($userID) {
            $this->flexi_auth_model->activate_user($userID);
            $message = true;
            $http_code = 200;
        } else {
            $message = strip_tags($this->flexi_auth_model->error_messages());
            $http_code = 403;
        }

        $this->response(array("user_id" => $userID, "message" => $message, "header" => $_SERVER["CONTENT_TYPE"]), $http_code);
    }

    public function auth_post() {
        $response = $this->flexi_auth_model->login($this->post('username'), $this->post('password'));
        
        if($response)        
            $this->response(array("status" => true, "user" => $this->user_accounts_model->get_by_username($this->post('username'))), 200);
        else
            $this->response(array("status" => false), 403);
    }

    public function check_post() {
        $response = $this->flexi_auth_model->login_remembered_user();

        $this->response(array("status" => $response));
    }

}
