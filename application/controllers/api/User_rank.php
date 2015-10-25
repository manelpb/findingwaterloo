<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class User_rank extends REST_Controller {

    function __construct($config = 'rest') {

        parent::__construct($config);

        $this->auth = new stdClass;

        $this->load->model('user_accounts_model');
        $this->load->model('user_rank_model');
    }

    public function index_get() {
        $user_id = $this->get("user_id");

        if ($user_id) {
            // check if this user exists
            if ($this->user_accounts_model->get_by_id($user_id)) {
                $this->response($this->user_rank_model->get_by_userid($user_id));
            }
        } else {
            $this->response($this->user_rank_model->get_all());
        }
    }

}
