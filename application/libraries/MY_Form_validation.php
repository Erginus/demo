<?php

class MY_Form_validation extends CI_Form_validation {

	function __construct() {
		parent::__construct();
	}

	function edit_unique($value, $params) {
		$CI = &get_instance();
		$CI->load->database();
		$CI->form_validation->set_message('edit_unique', "%s is already being used.");
		list($table, $field, $primary_key, $current_id) = explode(".", $params);
		$query = $CI->db->select($primary_key)->from($table)->where($field, $value)->limit(1)->get();
		if ($query->row() && $query->row()->$primary_key != $current_id) {
			return FALSE;
		}
		return TRUE;
	}

}