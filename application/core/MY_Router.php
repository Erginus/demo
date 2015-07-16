<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Router extends CI_Router {

    function __construct() {
        parent::__construct();
    }

    function _parse_routes() {
        foreach ($this->uri->segments as $seg) {
            if (strpos($seg, '_') !== FALSE) {
                $this->output = & load_class('Output', 'core');
                $this->output->set_status_header('301');
                header('Location: ' . $this->config->item('base_url') . $this->config->item('index_page') . str_replace('_', '-', $this->uri->uri_string));
            }
        }
        $uri = implode('/', $this->uri->segments);
        if (isset($this->routes[$uri])) {
            return $this->_set_request(explode('/', $this->routes[$uri]));
        }
        foreach ($this->routes as $key => $val) {
            $key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));
            if (preg_match('#^' . $key . '$#', $uri)) {
                if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE) {
                    $val = preg_replace('#^' . $key . '$#', $val, $uri);
                }
                return $this->_set_request(explode('/', $val));
            }
        }
        $uri_segments = array();
        foreach ($this->uri->segments as $seg) {
            array_push($uri_segments, str_replace('-', '_', $seg));
        }
        $this->_set_request($uri_segments);
    }

}