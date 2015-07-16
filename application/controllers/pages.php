<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends MY_Controller {

    public $public_methods = array('index', 'not_found', 'unauthorized', 'tree_test');

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->render_view(array(), 'home');
    }

    function not_found() {
        $this->output->set_status_header('404');
        $this->render_view();
    }

    function unauthorized() {
        $this->output->set_status_header('401');
        $this->render_view();
    }

}