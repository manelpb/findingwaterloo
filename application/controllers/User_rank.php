<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_rank extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_rank_model');
        $this->load->model('user_accounts_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $user_rank = $this->user_rank_model->get_all();

        $data = array(
            'user_rank_data' => $user_rank
        );

        $this->load->template('user_rank_list', $data);
    }

    public function read($id) {
        $row = $this->user_rank_model->get_by_id($id);
        if ($row) {
            $data = array(
                'usr_id' => $row->usr_id,
                'usr_uacc_id' => $row->usr_uacc_id,
                'usr_position' => $row->usr_position,
                'usr_points' => $row->usr_points,
            );
            $this->load->template('user_rank_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_rank'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url('user_rank/create_action'),
            'usr_id' => set_value('usr_id'),
            'usr_uacc_id' => set_value('usr_uacc_id'),
            'usr_position' => set_value('usr_position'),
            'usr_points' => set_value('usr_points'),
            'usersList' => $this->user_accounts_model->get_all_dropdown()
        );
        $this->load->template('user_rank_form', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'usr_uacc_id' => $this->input->post('usr_uacc_id', TRUE),
                'usr_position' => $this->input->post('usr_position', TRUE),
                'usr_points' => $this->input->post('usr_points', TRUE)
            );

            $this->user_rank_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user_rank'));
        }
    }

    public function update($id) {
        $row = $this->user_rank_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user_rank/update_action'),
                'usr_id' => set_value('usr_id', $row->usr_id),
                'usr_uacc_id' => set_value('usr_uacc_id', $row->usr_uacc_id),
                'usr_position' => set_value('usr_position', $row->usr_position),
                'usr_points' => set_value('usr_points', $row->usr_points),
                'usersList' => $this->user_accounts_model->get_all_dropdown()
            );
            $this->load->template('user_rank_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_rank'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('usr_id', TRUE));
        } else {
            $data = array(
                'usr_uacc_id' => $this->input->post('usr_uacc_id', TRUE),
                'usr_position' => $this->input->post('usr_position', TRUE),
                'usr_points' => $this->input->post('usr_points', TRUE),
            );

            $this->user_rank_model->update($this->input->post('usr_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user_rank'));
        }
    }

    public function delete($id) {
        $row = $this->user_rank_model->get_by_id($id);

        if ($row) {
            $this->user_rank_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user_rank'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_rank'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('usr_uacc_id', ' ', 'trim|required|numeric');
        $this->form_validation->set_rules('usr_position', ' ', 'trim|required|numeric');
        $this->form_validation->set_rules('usr_points', ' ', 'trim');

        $this->form_validation->set_rules('usr_id', 'usr_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

;

/* End of file User_rank.php */
/* Location: ./application/controllers/User_rank.php */