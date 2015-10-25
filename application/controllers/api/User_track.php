<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class User_track extends REST_Controller {

    function __construct($config = 'rest') {

        parent::__construct($config);

        $this->auth = new stdClass;

        $this->load->model('user_accounts_model');
        $this->load->model('things_model');
        $this->load->model('user_walk_model');
        $this->load->model('user_walk_thing_model');
    }

    public function walk_post() {
        $user_id = $this->post("user_id");
        $geo_lat = $this->post("lat");
        $geo_lng = $this->post("lng");

        if ($user_id && $geo_lat && $geo_lng) {
            // check if this user exists
            if ($this->user_accounts_model->get_by_id($user_id)) {
                // save info
                $data = array("usw_uacc_id" => $user_id,
                    "usw_lat" => $geo_lat,
                    "usw_lng" => $geo_lng,
                    "usw_date_added" => date("Y-m-d H:i:s", time()));

                $this->user_walk_model->insert($data);

                $this->response(array("status" => true), 200);
            }
        }

        $this->response(array("status" => false), 403);
    }

    public function walk_thing_post() {
        $user_id = $this->post("user_id");
        $geo_lat = $this->post("lat");
        $geo_lng = $this->post("lng");
        $thing_id = $this->post("thing_id");

        if ($user_id && $geo_lat && $geo_lng) {
            // check if this user exists
            if ($this->user_accounts_model->get_by_id($user_id)) {
                // check if the thing exists
                if ($this->things_model->get_by_id($thing_id)) {
                    // save info
                    $data = array("uwt_uacc_id" => $user_id,
                        "uwt_lat" => $geo_lat,
                        "uwt_lng" => $geo_lng,
                        "uwt_thg_id" => $thing_id,
                        "uwt_date_added" => date("Y-m-d H:i:s", time()));

                    $this->user_walk_thing_model->insert($data);

                    $this->response(array("status" => true), 200);
                }
            }
        }

        $this->response(array("status" => false), 403);
    }

}
