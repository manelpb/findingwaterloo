<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_walk_thing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_walk_thing_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $keyword = '';
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'user_walk_thing/index/';
        $config['total_rows'] = $this->user_walk_thing_model->total_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'user_walk_thing.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $user_walk_thing = $this->user_walk_thing_model->index_limit($config['per_page'], $start);

        $data = array(
            'user_walk_thing_data' => $user_walk_thing,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->load->view('user_walk_thing_list', $data);
    }
    
    public function search() 
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');
        
        if ($this->uri->segment(2)=='search') {
            $config['base_url'] = base_url() . 'user_walk_thing/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'user_walk_thing/index/';
        }

        $config['total_rows'] = $this->user_walk_thing_model->search_total_rows($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'user_walk_thing/search/'.$keyword.'.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $user_walk_thing = $this->user_walk_thing_model->search_index_limit($config['per_page'], $start, $keyword);

        $data = array(
            'user_walk_thing_data' => $user_walk_thing,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('user_walk_thing_list', $data);
    }

    public function read($id) 
    {
        $row = $this->user_walk_thing_model->get_by_id($id);
        if ($row) {
            $data = array(
		'uwt_id' => $row->uwt_id,
		'uwt_lat' => $row->uwt_lat,
		'uwt_lng' => $row->uwt_lng,
		'uwt_date_added' => $row->uwt_date_added,
		'uwt_uacc_id' => $row->uwt_uacc_id,
		'uwt_thg_id' => $row->uwt_thg_id,
	    );
            $this->load->view('user_walk_thing_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_walk_thing'));
        }
    }
    
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('user_walk_thing/create_action'),
	    'uwt_id' => set_value('uwt_id'),
	    'uwt_lat' => set_value('uwt_lat'),
	    'uwt_lng' => set_value('uwt_lng'),
	    'uwt_date_added' => set_value('uwt_date_added'),
	    'uwt_uacc_id' => set_value('uwt_uacc_id'),
	    'uwt_thg_id' => set_value('uwt_thg_id'),
	);
        $this->load->view('user_walk_thing_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'uwt_lat' => $this->input->post('uwt_lat',TRUE),
		'uwt_lng' => $this->input->post('uwt_lng',TRUE),
		'uwt_date_added' => $this->input->post('uwt_date_added',TRUE),
		'uwt_uacc_id' => $this->input->post('uwt_uacc_id',TRUE),
		'uwt_thg_id' => $this->input->post('uwt_thg_id',TRUE),
	    );

            $this->user_walk_thing_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user_walk_thing'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->user_walk_thing_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user_walk_thing/update_action'),
		'uwt_id' => set_value('uwt_id', $row->uwt_id),
		'uwt_lat' => set_value('uwt_lat', $row->uwt_lat),
		'uwt_lng' => set_value('uwt_lng', $row->uwt_lng),
		'uwt_date_added' => set_value('uwt_date_added', $row->uwt_date_added),
		'uwt_uacc_id' => set_value('uwt_uacc_id', $row->uwt_uacc_id),
		'uwt_thg_id' => set_value('uwt_thg_id', $row->uwt_thg_id),
	    );
            $this->load->view('user_walk_thing_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_walk_thing'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('uwt_id', TRUE));
        } else {
            $data = array(
		'uwt_lat' => $this->input->post('uwt_lat',TRUE),
		'uwt_lng' => $this->input->post('uwt_lng',TRUE),
		'uwt_date_added' => $this->input->post('uwt_date_added',TRUE),
		'uwt_uacc_id' => $this->input->post('uwt_uacc_id',TRUE),
		'uwt_thg_id' => $this->input->post('uwt_thg_id',TRUE),
	    );

            $this->user_walk_thing_model->update($this->input->post('uwt_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user_walk_thing'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->user_walk_thing_model->get_by_id($id);

        if ($row) {
            $this->user_walk_thing_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user_walk_thing'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_walk_thing'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('uwt_lat', ' ', 'trim|required');
	$this->form_validation->set_rules('uwt_lng', ' ', 'trim|required');
	$this->form_validation->set_rules('uwt_date_added', ' ', 'trim|required');
	$this->form_validation->set_rules('uwt_uacc_id', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('uwt_thg_id', ' ', 'trim|required');

	$this->form_validation->set_rules('uwt_id', 'uwt_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file User_walk_thing.php */
/* Location: ./application/controllers/User_walk_thing.php */