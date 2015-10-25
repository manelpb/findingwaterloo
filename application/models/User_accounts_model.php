<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_accounts_model extends CI_Model
{

    public $table = 'user_accounts';
    public $id = 'uacc_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get data by id
    function get_by_username($username)
    {
        $this->db->where("uacc_username", $username);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit
    function index_limit($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    
    // get search total rows
    function search_total_rows($keyword = NULL) {
        $this->db->like('uacc_id', $keyword);
	$this->db->or_like('uacc_group_fk', $keyword);
	$this->db->or_like('uacc_email', $keyword);
	$this->db->or_like('uacc_username', $keyword);
	$this->db->or_like('uacc_password', $keyword);
	$this->db->or_like('uacc_ip_address', $keyword);
	$this->db->or_like('uacc_salt', $keyword);
	$this->db->or_like('uacc_activation_token', $keyword);
	$this->db->or_like('uacc_forgotten_password_token', $keyword);
	$this->db->or_like('uacc_forgotten_password_expire', $keyword);
	$this->db->or_like('uacc_update_email_token', $keyword);
	$this->db->or_like('uacc_update_email', $keyword);
	$this->db->or_like('uacc_active', $keyword);
	$this->db->or_like('uacc_suspend', $keyword);
	$this->db->or_like('uacc_fail_login_attempts', $keyword);
	$this->db->or_like('uacc_fail_login_ip_address', $keyword);
	$this->db->or_like('uacc_date_fail_login_ban', $keyword);
	$this->db->or_like('uacc_date_last_login', $keyword);
	$this->db->or_like('uacc_date_added', $keyword);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('uacc_id', $keyword);
	$this->db->or_like('uacc_group_fk', $keyword);
	$this->db->or_like('uacc_email', $keyword);
	$this->db->or_like('uacc_username', $keyword);
	$this->db->or_like('uacc_password', $keyword);
	$this->db->or_like('uacc_ip_address', $keyword);
	$this->db->or_like('uacc_salt', $keyword);
	$this->db->or_like('uacc_activation_token', $keyword);
	$this->db->or_like('uacc_forgotten_password_token', $keyword);
	$this->db->or_like('uacc_forgotten_password_expire', $keyword);
	$this->db->or_like('uacc_update_email_token', $keyword);
	$this->db->or_like('uacc_update_email', $keyword);
	$this->db->or_like('uacc_active', $keyword);
	$this->db->or_like('uacc_suspend', $keyword);
	$this->db->or_like('uacc_fail_login_attempts', $keyword);
	$this->db->or_like('uacc_fail_login_ip_address', $keyword);
	$this->db->or_like('uacc_date_fail_login_ban', $keyword);
	$this->db->or_like('uacc_date_last_login', $keyword);
	$this->db->or_like('uacc_date_added', $keyword);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file User_accounts_model.php */
/* Location: ./application/models/User_accounts_model.php */