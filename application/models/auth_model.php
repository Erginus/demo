<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function login($username) {
        $where = "(users.user_login = '" . $this->db->escape_str($username) . "' OR users.user_email = '" . $this->db->escape_str($username) . "') AND users.user_status = '1'";
        $this->db->join('groups','groups.group_id = users.groups_id');
        return $this->db->where($where)->get('users')->row_array();
    }

    function update_user_login($user_id) {
        return $this->db->where('user_id', $user_id)->update('users', array('user_last_logged_in' => date('Y-m-d H:i:s')));
    }

    function get_user_by_username_or_email($user_detail) {
        return $this->db->where('user_login', $user_detail)->or_where('user_email', $user_detail)->get('users')->row_array();
    }

    function get_user_details_by_user_security_hash($user_security_hash) {
        return $this->db->get_where('users', array('user_security_hash' => $user_security_hash))->row_array();
    }

    function update_user_details_by_user_security_hash($user_security_hash, $user_array) {
        return $this->db->where('user_security_hash', $user_security_hash)->update('users', $user_array);
    }

    function create_account($user_array) {
        return $this->db->insert('users', $user_array);
    }

}