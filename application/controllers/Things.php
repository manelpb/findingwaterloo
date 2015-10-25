<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Things extends CI_Controller {

    function __construct() {
        parent::__construct();

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        $this->load->helper('date');
        $this->load->helper('geolocation');
        $this->load->model('things_model');
        $this->load->model('thing_types_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $things = $this->things_model->get_all();

        $data = array(
            'things_data' => $things
        );

        $this->load->template('things_list', $data);
    }

    public function read($id) {
        $row = $this->things_model->get_by_id($id);
        if ($row) {
            $data = array(
                'thg_id' => $row->thg_id,
                'thg_title' => $row->thg_title,
                'tgh_description' => $row->tgh_description,
                'tgh_image' => $row->tgh_image,
                'tgh_geo' => $row->tgh_geo,
                'tgh_address' => $row->tgh_address,
                'tgh_popularity' => $row->tgh_popularity,
                'tgh_tty_id' => $row->tgh_tty_id,
                'tgh_created_at' => $row->tgh_created_at,
            );
            $this->load->template('things_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('things'));
        }
    }

    public function import_opendata() {

        $address_final = "http://opendata.city-of-waterloo.opendata.arcgis.com/datasets/04a8276e6c074a6b8a2a158cc1a1d81e_0.geojson";

        $json = file_get_contents($address_final);
        $obj = json_decode($json);

        foreach ($obj->features as $item) {
            $this->import_savedata($item->properties->TYPE, $item->properties->FACILITY, null, $item->properties->ADDRESS, $item->properties->LATITUDE, $item->properties->LONGITUDE);
        }

        // import schools
        $address_final = "http://opendata.city-of-waterloo.opendata.arcgis.com/datasets/3901b3ef7f7343be8ebfe793efae8f21_0.geojson";

        $json = file_get_contents($address_final);
        $obj = json_decode($json);

        foreach ($obj->features as $item) {
            
            $this->import_savedata("Academic Institution", $item->properties->NAME, $item->properties->URL, $item->properties->ADDRESS, $item->properties->LATITUDE, $item->properties->LONGITUDE);
        }
        
        redirect("things");
    }

    private function import_savedata($typename, $facility, $description, $address, $lat, $lng) {
        $thing = $this->thing_types_model->get_by_title($typename);
        $thing_id = 0;
        $type_title = $typename;

        if ($type_title) {

            if ($thing) {
                $thing_id = $thing->tty_id;
            } else {
                $data = array("tty_title" => $type_title);
                $thing_id = $this->thing_types_model->insert($data);
            }

            // try to create the thing
            $data = array(
                'thg_title' => $facility,
                'tgh_popularity' => 1,
                'tgh_description' => $description,
                'tgh_tty_id' => $thing_id,
                'tgh_address' => $address,
                'tgh_geo' => serialize(array("location" => array("lat" => $lng, "lng" => $lat))),
                'tgh_created_at' => date("Y-m-d H:i:s", time()),
            );

            $this->things_model->insert($data);
        }
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url('things/create_action'),
            'thg_id' => set_value('thg_id'),
            'thg_title' => set_value('thg_title'),
            'tgh_description' => set_value('tgh_description'),
            'tgh_image' => set_value('tgh_image'),
            'tgh_geo' => set_value('tgh_geo'),
            'tgh_address' => set_value('tgh_address'),
            'tgh_popularity' => set_value('tgh_popularity'),
            'tgh_tty_id' => set_value('tgh_tty_id'),
            'thingsTypesOptions' => $this->thing_types_model->get_all_dropdown(),
        );

        $this->load->template('things_form', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if ($this->input->post('tgh_address', TRUE))
                $geo_location = get_geolocation($this->input->post('tgh_address', TRUE));

            $data = array(
                'thg_title' => $this->input->post('thg_title', TRUE),
                'tgh_description' => $this->input->post('tgh_description', TRUE),
                'tgh_image' => $this->input->post('tgh_image', TRUE),
                'tgh_popularity' => $this->input->post('tgh_popularity', TRUE),
                'tgh_tty_id' => $this->input->post('tgh_tty_id', TRUE),
                'tgh_created_at' => date("Y-m-d H:i:s", time()),
            );

            if ($this->upload->do_upload("tgh_image")) {
                $uploadData = $this->upload->data();
                $data['tgh_image'] = $uploadData['file_name'];
            }

            if (isset($geo_location) && $geo_location) {
                $data['tgh_geo'] = serialize($geo_location['geometry']);
                $data['tgh_address'] = $geo_location['address'];
            }

            $this->things_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('things'));
        }
    }

    public function update($id) {
        $row = $this->things_model->get_by_id($id);

        if ($row) {

            $data = array(
                'button' => 'Update',
                'action' => site_url('things/update_action'),
                'thg_id' => set_value('thg_id', $row->thg_id),
                'thg_title' => set_value('thg_title', $row->thg_title),
                'tgh_description' => set_value('tgh_description', $row->tgh_description),
                'tgh_image' => set_value('tgh_image', $row->tgh_image),
                'tgh_geo' => set_value('tgh_geo', $row->tgh_geo),
                'tgh_address' => set_value('tgh_address', $row->tgh_address),
                'tgh_popularity' => set_value('tgh_popularity', $row->tgh_popularity),
                'tgh_tty_id' => set_value('tgh_tty_id', $row->tgh_tty_id),
                'thingsTypesOptions' => $this->thing_types_model->get_all_dropdown()
            );
            $this->load->template('things_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('things'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('thg_id', TRUE));
        } else {

            if ($this->input->post('tgh_address', TRUE))
                $geo_location = get_geolocation($this->input->post('tgh_address', TRUE));

            $data = array(
                'thg_title' => $this->input->post('thg_title', TRUE),
                'tgh_description' => $this->input->post('tgh_description', TRUE),
                'tgh_address' => $this->input->post('tgh_address', TRUE),
                'tgh_popularity' => $this->input->post('tgh_popularity', TRUE),
                'tgh_tty_id' => $this->input->post('tgh_tty_id', TRUE),
            );

            if ($this->upload->do_upload("tgh_image")) {
                $uploadData = $this->upload->data();
                $data['tgh_image'] = $uploadData['file_name'];
            }

            if (isset($geo_location) && $geo_location) {
                $data['tgh_geo'] = serialize($geo_location['geometry']);
                $data['tgh_address'] = $geo_location['address'];
            }

            $this->things_model->update($this->input->post('thg_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('things'));
        }
    }

    public function delete($id) {
        $row = $this->things_model->get_by_id($id);

        if ($row) {
            $this->things_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('things'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('things'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('thg_title', ' ', 'trim|required');
        $this->form_validation->set_rules('tgh_description', ' ', 'trim');
        $this->form_validation->set_rules('tgh_image', ' ', 'trim');
        $this->form_validation->set_rules('tgh_geo', ' ', 'trim');
        $this->form_validation->set_rules('tgh_address', ' ', 'trim');
        $this->form_validation->set_rules('tgh_popularity', ' ', 'trim');
        $this->form_validation->set_rules('tgh_tty_id', ' ', 'trim|required|numeric');
        $this->form_validation->set_rules('tgh_created_at', ' ', 'trim');

        $this->form_validation->set_rules('thg_id', 'thg_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

;

/* End of file Things.php */
/* Location: ./application/controllers/Things.php */