<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_walk extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_walk_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $keyword = '';
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'user_walk/index/';
        $config['total_rows'] = $this->user_walk_model->total_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'user_walk.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $user_walk = $this->user_walk_model->index_limit($config['per_page'], $start);

        $data = array(
            'user_walk_data' => $user_walk,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->load->view('user_walk_list', $data);
    }

    public function image() {
        // Set image path
        $path = './uploads/';
        
        $map_clean = file_get_contents(base_url() . "/index.php/api/user_track/map_filled?no_marks=1");
        $map_filled = file_get_contents(base_url() . "/index.php/api/user_track/map_filled");

        $dude = new Imagick();//$path . 'staticmap.png');
        $dude->readImageBlob($map_clean);
    
        $mask = new Imagick();//$path . 'staticmap_mask.png');
        $mask->readimageblob($map_filled);

        $dude->setImageMatte(1);
        $dude->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0);
        $dude->writeImage($path . 'newimage.png');

        header("Content-Type: image/png");
        
        echo $dude;
    }

    public function search() {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(2) == 'search') {
            $config['base_url'] = base_url() . 'user_walk/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'user_walk/index/';
        }

        $config['total_rows'] = $this->user_walk_model->search_total_rows($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'user_walk/search/' . $keyword . '.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $user_walk = $this->user_walk_model->search_index_limit($config['per_page'], $start, $keyword);

        $data = array(
            'user_walk_data' => $user_walk,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('user_walk_list', $data);
    }

    public function read($id) {
        $row = $this->user_walk_model->get_by_id($id);
        if ($row) {
            $data = array(
                'usw_id' => $row->usw_id,
                'usw_uacc_id' => $row->usw_uacc_id,
                'usw_lat' => $row->usw_lat,
                'usw_lng' => $row->usw_lng,
                'usw_date_added' => $row->usw_date_added,
            );
            $this->load->view('user_walk_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_walk'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url('user_walk/create_action'),
            'usw_id' => set_value('usw_id'),
            'usw_uacc_id' => set_value('usw_uacc_id'),
            'usw_lat' => set_value('usw_lat'),
            'usw_lng' => set_value('usw_lng'),
            'usw_date_added' => set_value('usw_date_added'),
        );
        $this->load->view('user_walk_form', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'usw_uacc_id' => $this->input->post('usw_uacc_id', TRUE),
                'usw_lat' => $this->input->post('usw_lat', TRUE),
                'usw_lng' => $this->input->post('usw_lng', TRUE),
                'usw_date_added' => $this->input->post('usw_date_added', TRUE),
            );

            $this->user_walk_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user_walk'));
        }
    }

    public function update($id) {
        $row = $this->user_walk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user_walk/update_action'),
                'usw_id' => set_value('usw_id', $row->usw_id),
                'usw_uacc_id' => set_value('usw_uacc_id', $row->usw_uacc_id),
                'usw_lat' => set_value('usw_lat', $row->usw_lat),
                'usw_lng' => set_value('usw_lng', $row->usw_lng),
                'usw_date_added' => set_value('usw_date_added', $row->usw_date_added),
            );
            $this->load->view('user_walk_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_walk'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('usw_id', TRUE));
        } else {
            $data = array(
                'usw_uacc_id' => $this->input->post('usw_uacc_id', TRUE),
                'usw_lat' => $this->input->post('usw_lat', TRUE),
                'usw_lng' => $this->input->post('usw_lng', TRUE),
                'usw_date_added' => $this->input->post('usw_date_added', TRUE),
            );

            $this->user_walk_model->update($this->input->post('usw_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user_walk'));
        }
    }

    public function delete($id) {
        $row = $this->user_walk_model->get_by_id($id);

        if ($row) {
            $this->user_walk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user_walk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_walk'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('usw_uacc_id', ' ', 'trim|required|numeric');
        $this->form_validation->set_rules('usw_lat', ' ', 'trim|required');
        $this->form_validation->set_rules('usw_lng', ' ', 'trim|required');
        $this->form_validation->set_rules('usw_date_added', ' ', 'trim|required');

        $this->form_validation->set_rules('usw_id', 'usw_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

;

/* End of file User_walk.php */
/* Location: ./application/controllers/User_walk.php */