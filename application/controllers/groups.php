<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Groups extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->render_view();
    }

    function datatable() {
        $this->load->model('Group_model');
        $this->load->library('Datatables');
        $this->datatables->select('groups.group_id,groups.group_name,groups.group_status,groups.group_created, COUNT(users.user_id) AS users_count')->from('groups');
        $this->datatables->join('users', 'users.groups_id = groups.group_id', 'left');
        $this->datatables->group_by('groups.group_id');
        echo $this->datatables->generate();
    }

}