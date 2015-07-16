<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function get_user_by_id($user_id) {
        return $this->db->get_where('users', array('user_id' => $user_id))->row_array();
    }

    function get_user_by_email($user_email) {
        return $this->db->get_where('users', array('user_email' => $user_email))->row_array();
    }

    function delete($user_id) {
        return $this->db->where('user_id', $user_id)->update('users', array('user_status' => '-1', 'user_modified' => date('Y-m-d H:i:s')));
    }

    function add($user_array) {
        return $this->db->insert('users', $user_array);
    }

    function edit($user_id, $user_array) {
        return $this->db->where('user_id', $user_id)->update('users', $user_array);
    }

}