<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_accounts extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_accounts_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $user_accounts = $this->user_accounts_model->get_all();

        $data = array(
            'user_accounts_data' => $user_accounts
        );

        $this->load->template('user_accounts_list', $data);
    }

    public function read($id) 
    {
        $row = $this->user_accounts_model->get_by_id($id);
        if ($row) {
            $data = array(
		'uacc_id' => $row->uacc_id,
		'uacc_group_fk' => $row->uacc_group_fk,
		'uacc_email' => $row->uacc_email,
		'uacc_username' => $row->uacc_username,
		'uacc_password' => $row->uacc_password,
		'uacc_ip_address' => $row->uacc_ip_address,
		'uacc_salt' => $row->uacc_salt,
		'uacc_activation_token' => $row->uacc_activation_token,
		'uacc_forgotten_password_token' => $row->uacc_forgotten_password_token,
		'uacc_forgotten_password_expire' => $row->uacc_forgotten_password_expire,
		'uacc_update_email_token' => $row->uacc_update_email_token,
		'uacc_update_email' => $row->uacc_update_email,
		'uacc_active' => $row->uacc_active,
		'uacc_suspend' => $row->uacc_suspend,
		'uacc_fail_login_attempts' => $row->uacc_fail_login_attempts,
		'uacc_fail_login_ip_address' => $row->uacc_fail_login_ip_address,
		'uacc_date_fail_login_ban' => $row->uacc_date_fail_login_ban,
		'uacc_date_last_login' => $row->uacc_date_last_login,
		'uacc_date_added' => $row->uacc_date_added,
	    );
            $this->load->template('user_accounts_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_accounts'));
        }
    }
    
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('user_accounts/create_action'),
	    'uacc_id' => set_value('uacc_id'),
	    'uacc_group_fk' => set_value('uacc_group_fk'),
	    'uacc_email' => set_value('uacc_email'),
	    'uacc_username' => set_value('uacc_username'),
	    'uacc_password' => set_value('uacc_password'),
	    'uacc_ip_address' => set_value('uacc_ip_address'),
	    'uacc_salt' => set_value('uacc_salt'),
	    'uacc_activation_token' => set_value('uacc_activation_token'),
	    'uacc_forgotten_password_token' => set_value('uacc_forgotten_password_token'),
	    'uacc_forgotten_password_expire' => set_value('uacc_forgotten_password_expire'),
	    'uacc_update_email_token' => set_value('uacc_update_email_token'),
	    'uacc_update_email' => set_value('uacc_update_email'),
	    'uacc_active' => set_value('uacc_active'),
	    'uacc_suspend' => set_value('uacc_suspend'),
	    'uacc_fail_login_attempts' => set_value('uacc_fail_login_attempts'),
	    'uacc_fail_login_ip_address' => set_value('uacc_fail_login_ip_address'),
	    'uacc_date_fail_login_ban' => set_value('uacc_date_fail_login_ban'),
	    'uacc_date_last_login' => set_value('uacc_date_last_login'),
	    'uacc_date_added' => set_value('uacc_date_added'),
	);
        $this->load->template('user_accounts_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'uacc_group_fk' => $this->input->post('uacc_group_fk',TRUE),
		'uacc_email' => $this->input->post('uacc_email',TRUE),
		'uacc_username' => $this->input->post('uacc_username',TRUE),
		'uacc_password' => $this->input->post('uacc_password',TRUE),
		'uacc_ip_address' => $this->input->post('uacc_ip_address',TRUE),
		'uacc_salt' => $this->input->post('uacc_salt',TRUE),
		'uacc_activation_token' => $this->input->post('uacc_activation_token',TRUE),
		'uacc_forgotten_password_token' => $this->input->post('uacc_forgotten_password_token',TRUE),
		'uacc_forgotten_password_expire' => $this->input->post('uacc_forgotten_password_expire',TRUE),
		'uacc_update_email_token' => $this->input->post('uacc_update_email_token',TRUE),
		'uacc_update_email' => $this->input->post('uacc_update_email',TRUE),
		'uacc_active' => $this->input->post('uacc_active',TRUE),
		'uacc_suspend' => $this->input->post('uacc_suspend',TRUE),
		'uacc_fail_login_attempts' => $this->input->post('uacc_fail_login_attempts',TRUE),
		'uacc_fail_login_ip_address' => $this->input->post('uacc_fail_login_ip_address',TRUE),
		'uacc_date_fail_login_ban' => $this->input->post('uacc_date_fail_login_ban',TRUE),
		'uacc_date_last_login' => $this->input->post('uacc_date_last_login',TRUE),
		'uacc_date_added' => $this->input->post('uacc_date_added',TRUE),
	    );

            $this->user_accounts_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user_accounts'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->user_accounts_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user_accounts/update_action'),
		'uacc_id' => set_value('uacc_id', $row->uacc_id),
		'uacc_group_fk' => set_value('uacc_group_fk', $row->uacc_group_fk),
		'uacc_email' => set_value('uacc_email', $row->uacc_email),
		'uacc_username' => set_value('uacc_username', $row->uacc_username),
		'uacc_password' => set_value('uacc_password', $row->uacc_password),
		'uacc_ip_address' => set_value('uacc_ip_address', $row->uacc_ip_address),
		'uacc_salt' => set_value('uacc_salt', $row->uacc_salt),
		'uacc_activation_token' => set_value('uacc_activation_token', $row->uacc_activation_token),
		'uacc_forgotten_password_token' => set_value('uacc_forgotten_password_token', $row->uacc_forgotten_password_token),
		'uacc_forgotten_password_expire' => set_value('uacc_forgotten_password_expire', $row->uacc_forgotten_password_expire),
		'uacc_update_email_token' => set_value('uacc_update_email_token', $row->uacc_update_email_token),
		'uacc_update_email' => set_value('uacc_update_email', $row->uacc_update_email),
		'uacc_active' => set_value('uacc_active', $row->uacc_active),
		'uacc_suspend' => set_value('uacc_suspend', $row->uacc_suspend),
		'uacc_fail_login_attempts' => set_value('uacc_fail_login_attempts', $row->uacc_fail_login_attempts),
		'uacc_fail_login_ip_address' => set_value('uacc_fail_login_ip_address', $row->uacc_fail_login_ip_address),
		'uacc_date_fail_login_ban' => set_value('uacc_date_fail_login_ban', $row->uacc_date_fail_login_ban),
		'uacc_date_last_login' => set_value('uacc_date_last_login', $row->uacc_date_last_login),
		'uacc_date_added' => set_value('uacc_date_added', $row->uacc_date_added),
	    );
            $this->load->template('user_accounts_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_accounts'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('uacc_id', TRUE));
        } else {
            $data = array(
		'uacc_group_fk' => $this->input->post('uacc_group_fk',TRUE),
		'uacc_email' => $this->input->post('uacc_email',TRUE),
		'uacc_username' => $this->input->post('uacc_username',TRUE),
		'uacc_password' => $this->input->post('uacc_password',TRUE),
		'uacc_ip_address' => $this->input->post('uacc_ip_address',TRUE),
		'uacc_salt' => $this->input->post('uacc_salt',TRUE),
		'uacc_activation_token' => $this->input->post('uacc_activation_token',TRUE),
		'uacc_forgotten_password_token' => $this->input->post('uacc_forgotten_password_token',TRUE),
		'uacc_forgotten_password_expire' => $this->input->post('uacc_forgotten_password_expire',TRUE),
		'uacc_update_email_token' => $this->input->post('uacc_update_email_token',TRUE),
		'uacc_update_email' => $this->input->post('uacc_update_email',TRUE),
		'uacc_active' => $this->input->post('uacc_active',TRUE),
		'uacc_suspend' => $this->input->post('uacc_suspend',TRUE),
		'uacc_fail_login_attempts' => $this->input->post('uacc_fail_login_attempts',TRUE),
		'uacc_fail_login_ip_address' => $this->input->post('uacc_fail_login_ip_address',TRUE),
		'uacc_date_fail_login_ban' => $this->input->post('uacc_date_fail_login_ban',TRUE),
		'uacc_date_last_login' => $this->input->post('uacc_date_last_login',TRUE),
		'uacc_date_added' => $this->input->post('uacc_date_added',TRUE),
	    );

            $this->user_accounts_model->update($this->input->post('uacc_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user_accounts'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->user_accounts_model->get_by_id($id);

        if ($row) {
            $this->user_accounts_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user_accounts'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user_accounts'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('uacc_group_fk', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_email', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_username', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_password', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_ip_address', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_salt', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_activation_token', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_forgotten_password_token', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_forgotten_password_expire', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_update_email_token', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_update_email', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_active', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_suspend', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_fail_login_attempts', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_fail_login_ip_address', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_date_fail_login_ban', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_date_last_login', ' ', 'trim|required');
	$this->form_validation->set_rules('uacc_date_added', ' ', 'trim|required');

	$this->form_validation->set_rules('uacc_id', 'uacc_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file User_accounts.php */
/* Location: ./application/controllers/User_accounts.php */