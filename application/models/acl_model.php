<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acl_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function get_urls() {
        return $this->db->get('urls')->result_array();
    }

    function update_urls($new_urls_array) {
        if ($this->db->truncate('urls')) {
            return $this->db->insert_batch('urls', $new_urls_array);
        }
        return FALSE;
    }

    function get_group_urls() {
        $this->db->select('group_urls.groups_id, urls.url_directory, urls.url_class, urls.url_method, group_urls.group_url_permission');
        $this->db->join('urls', 'urls.url_id = group_urls.urls_id');
        return $this->db->get('group_urls')->result_array();
    }

    function get_user_urls() {
        $this->db->select('user_urls.users_id, urls.url_directory, urls.url_class, urls.url_method, user_urls.user_url_permission');
        $this->db->join('urls', 'urls.url_id = user_urls.urls_id');
        return $this->db->get('user_urls')->result_array();
    }

    function get_groups() {
        return $this->db->get('groups')->result_array();
    }

    function update_group_urls($new_group_urls_array) {
        if ($this->db->truncate('group_urls')) {
            return $this->db->insert_batch('group_urls', $new_group_urls_array);
        }
        return FALSE;
    }

    function update_user_urls($new_user_urls_array) {
        if (is_array($new_user_urls_array) && count($new_user_urls_array) > 0) {
            if ($this->db->truncate('user_urls')) {
                return $this->db->insert_batch('user_urls', $new_user_urls_array);
            }
        }
        return TRUE;
    }

    function get_user_url_permission_by_user_id($user_id, $directory, $class, $method) {
        $this->db->select('user_urls.user_url_permission');
        $this->db->join('urls', 'urls.url_id = user_urls.urls_id');
        return $this->db->get_where('user_urls', array('user_urls.users_id' => $user_id, 'urls.url_directory' => $directory, 'urls.url_class' => $class, 'urls.url_method' => $method))->row_array();
    }

    function get_group_url_permission_by_user_id($group_id, $directory, $class, $method) {
        $this->db->select('group_urls.group_url_permission');
        $this->db->join('urls', 'urls.url_id = group_urls.urls_id');
        return $this->db->get_where('group_urls', array('group_urls.groups_id' => $group_id, 'urls.url_directory' => $directory, 'urls.url_class' => $class, 'urls.url_method' => $method))->row_array();
    }

    function get_url_sets() {
        return $this->db->get('url_sets')->result_array();
    }

    function update_url_set($url_id, $url_set_id) {
        return $this->db->where('url_id', $url_id)->update('urls', array('url_sets_id' => $url_set_id));
    }

    function add_url_set($url_set_insert_array) {
        return $this->db->insert('url_sets', $url_set_insert_array);
    }

    function get_urls_by_url_set_id($url_set_id) {
        return $this->db->get_where('urls', array('url_sets_id' => $url_set_id))->result_array();
    }

    function delete_url_set($url_set_id) {
        return $this->db->delete('url_sets', array('url_set_id' => $url_set_id));
    }

    function get_group_urls_by_group_id($group_id) {
        $this->db->join('urls', 'urls.url_id = group_urls.urls_id');
        return $this->db->get_where('group_urls', array('groups_id' => $group_id))->result_array();
    }

    function update_group_url_premission($groups_id, $urls_id, $group_url_permission) {
        return $this->db->where(array('groups_id' => $groups_id, 'urls_id' => $urls_id))->update('group_urls', array('group_url_permission' => $group_url_permission));
    }

    function get_user_urls_by_user_id($user_id) {
        $this->db->join('urls', 'urls.url_id = user_urls.urls_id');
        return $this->db->get_where('user_urls', array('users_id' => $user_id))->result_array();
    }

    function update_user_url_premission($groups_id, $urls_id, $group_url_permission) {
        return $this->db->where(array('groups_id' => $groups_id, 'urls_id' => $urls_id))->update('group_urls', array('group_url_permission' => $group_url_permission));
    }

    function get_group_permission_by_url_id($group_id, $url_id) {
        return $this->db->select('group_url_permission')->get_where('group_urls', array('groups_id' => $group_id, 'urls_id' => $url_id))->row_array();
    }

    function delete_user_url_premission($user_id, $url_id) {
        return $this->db->delete('user_urls', array('users_id' => $user_id, 'urls_id' => $url_id));
    }

    function add_user_url_premission($user_id, $url_id, $permission) {
        return $this->db->insert('user_urls', array('users_id' => $user_id, 'urls_id' => $url_id, 'user_url_permission' => $permission));
    }

}