<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function add_email_to_queue($email_array) {
        $this->db->delete('emails', array('email_created <' => date('Y-m-d H:i:s', strtotime('-1 month'))));
        return $this->db->insert('emails', $email_array);
    }

    function get_email_details_by_hash($email_hash) {
        return $this->db->get_where('emails', array('email_hash' => $email_hash))->row_array();
    }

    function get_email_open_count_by_hash($email_hash) {
        return $this->db->select('email_open_count')->get_where('emails', array('email_hash' => $email_hash))->row_array();
    }

    function get_email_click_count_by_hash($email_hash) {
        return $this->db->select('email_click_count')->get_where('emails', array('email_hash' => $email_hash))->row_array();
    }

    function update_email_status($email_hash, $email_update_details_array) {
        return $this->db->where('email_hash', $email_hash)->update('emails', $email_update_details_array);
    }

    function get_email_content_by_hash($email_hash) {
        return $this->db->select('email_body')->get_where('emails', array('email_hash' => $email_hash))->row_array();
    }

}