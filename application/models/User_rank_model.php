<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_rank_model extends CI_Model
{

    public $table = 'user_rank';
    public $id = 'usr_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select("usr_position, usr_points, uacc_username, uacc_id, uacc_email");
        $this->db->order_by("usr_position", $this->order);        
        $this->db->join('user_accounts', 'usr_uacc_id = uacc_id');
        return $this->db->get($this->table)->result();
    }
    
    function get_by_userid($user_id) {
        $this->db->where("usr_uacc_id", $user_id);
        return $this->db->get($this->table)->row();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
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
        $this->db->like('usr_id', $keyword);
	$this->db->or_like('usr_uacc_id', $keyword);
	$this->db->or_like('usr_position', $keyword);
	$this->db->or_like('usr_points', $keyword);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('usr_id', $keyword);
	$this->db->or_like('usr_uacc_id', $keyword);
	$this->db->or_like('usr_position', $keyword);
	$this->db->or_like('usr_points', $keyword);
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

/* End of file User_rank_model.php */
/* Location: ./application/models/User_rank_model.php */