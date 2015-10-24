<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Thing_types extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);
        
        $this->load->model('thing_types_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $thing_types = $this->thing_types_model->get_all();

        $data = array(
            'thing_types_data' => $thing_types
        );

        $this->load->template('thing_types_list', $data);
    }

    public function read($id) {
        $row = $this->thing_types_model->get_by_id($id);
        if ($row) {
            $data = array(
                'tty_id' => $row->tty_id,
                'tty_title' => $row->tty_title,
                'tty_icon' => $row->tty_icon,
            );
            $this->load->template('thing_types_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thing_types'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url('thing_types/create_action'),
            'tty_id' => set_value('tty_id'),
            'tty_title' => set_value('tty_title'),
            'tty_icon' => set_value('tty_icon'),
        );
        $this->load->template('thing_types_form', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            $data = array(
                'tty_title' => $this->input->post('tty_title', TRUE),
            );

            if ($this->upload->do_upload("tty_icon")) {
                $uploadData = $this->upload->data();            
                $data['tty_icon'] = $uploadData['file_name'];
            } 

            $this->thing_types_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('thing_types'));
        }
    }

    public function update($id) {
        $row = $this->thing_types_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('thing_types/update_action'),
                'tty_id' => set_value('tty_id', $row->tty_id),
                'tty_title' => set_value('tty_title', $row->tty_title),
                'tty_icon' => set_value('tty_icon', $row->tty_icon),
            );
            $this->load->template('thing_types_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thing_types'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('tty_id', TRUE));
        } else {

            $data = array(
                'tty_title' => $this->input->post('tty_title', TRUE),
            );

            if ($this->upload->do_upload("tty_icon")) {
                $uploadData = $this->upload->data();            
                $data['tty_icon'] = $uploadData['file_name'];
            } 
            
            $this->thing_types_model->update($this->input->post('tty_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('thing_types'));
        }
    }

    public function delete($id) {
        $row = $this->thing_types_model->get_by_id($id);

        if ($row) {
            $this->thing_types_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('thing_types'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thing_types'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('tty_title', ' ', 'trim|required');
        $this->form_validation->set_rules('tty_icon', ' ', 'trim');

        $this->form_validation->set_rules('tty_id', 'tty_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

;

/* End of file Thing_types.php */
/* Location: ./application/controllers/Thing_types.php */