<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acl extends MY_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Acl_model');
    }

    function index() {
        $this->render_view();
    }

//    function rat(){
//        
//    }

    function refresh() {
        set_time_limit(0);
        $this->load->helper('file');
//        @write_file(FCPATH . 'down', '');
//        @unlink(FCPATH . 'up');
        $new_urls_array = array();
        foreach (glob(APPPATH . 'controllers/*') as $controller) {
            if (is_dir($controller)) {
                $dir_name = basename($controller, EXT);
                foreach (glob(APPPATH . 'controllers/' . $dir_name . '/*') as $sub_dir_controller) {
                    $sub_dir_controller_name = basename($sub_dir_controller, EXT);
                    if (!class_exists($sub_dir_controller_name)) {
                        $this->load->file($sub_dir_controller);
                    }
                    $sub_dir_controller_name_class = new ReflectionClass($sub_dir_controller_name);
                    foreach ($sub_dir_controller_name_class->getMethods() as $sub_dir_controller_name_methods) {
                        if ($sub_dir_controller_name_methods->class === $sub_dir_controller_name_class->name && $sub_dir_controller_name !== $sub_dir_controller_name_methods->name && substr($sub_dir_controller_name_methods->name, 0, 1) !== '_') {
                            array_push($new_urls_array, array(
                                'url_directory' => $dir_name,
                                'url_class' => $sub_dir_controller_name,
                                'url_method' => $sub_dir_controller_name_methods->name,
                            ));
                        }
                    }
                }
            } else if (pathinfo($controller, PATHINFO_EXTENSION) === "php") {
                $controller_name = basename($controller, EXT);
                if (!class_exists($controller_name)) {
                    $this->load->file($controller);
                }
                $controller_name_class = new ReflectionClass($controller_name);
                foreach ($controller_name_class->getMethods() as $controller_name_methods) {
                    if ($controller_name_methods->class === $controller_name_class->name && $controller_name !== $controller_name_methods->name && substr($controller_name_methods->name, 0, 1) !== '_') {
                        array_push($new_urls_array, array(
                            'url_directory' => NULL,
                            'url_class' => $controller_name,
                            'url_method' => $controller_name_methods->name,
                        ));
                    }
                }
            }
        }
        $old_group_urls_array = $this->Acl_model->get_group_urls();
        $old_user_urls_array = $this->Acl_model->get_user_urls();
        $old_urls_array = $this->Acl_model->get_urls();
        foreach ($new_urls_array as $key => $new_url) {
            $index = parent::array_search_by_value($old_urls_array, array('url_directory' => $new_url['url_directory'], 'url_class' => $new_url['url_class'], 'url_method' => $new_url['url_method']));
            if (count($index) === 1) {
                $new_urls_array[$key]['url_sets_id'] = $old_urls_array[$index[0]]['url_sets_id'];
            } else {
                $new_urls_array[$key]['url_sets_id'] = '0';
            }
        }
        $this->Acl_model->update_urls($new_urls_array);
        $urls_array = $this->Acl_model->get_urls();
        $groups_array = $this->Acl_model->get_groups();
        $new_group_urls_array = array();
        $new_user_urls_array = array();
        foreach ($groups_array as $group) {
            foreach ($urls_array as $url) {
                $group_url_permission = '0';
                foreach ($old_group_urls_array as $old_group_urls) {
                    if (
                            $old_group_urls['groups_id'] === $group['group_id'] &&
                            $old_group_urls['url_directory'] === $url['url_directory'] &&
                            $old_group_urls['url_class'] === $url['url_class'] &&
                            $old_group_urls['url_method'] === $url['url_method']
                    ) {
                        $group_url_permission = $old_group_urls['group_url_permission'];
                    }
                }
                array_push($new_group_urls_array, array(
                    'groups_id' => $group['group_id'],
                    'urls_id' => $url['url_id'],
                    'group_url_permission' => $group_url_permission
                ));
            }
        }
        $old_users = array();
        foreach ($old_user_urls_array as $old_user_urls) {
            if (!in_array($old_user_urls['users_id'], $old_users)) {
                array_push($old_users, $old_user_urls['users_id']);
            }
        }
        foreach ($old_users as $user) {
            foreach ($urls_array as $url) {
                $user_url_permission = '0';
                foreach ($old_user_urls_array as $old_user_urls) {
                    if (
                            $old_user_urls['users_id'] === $user &&
                            $old_user_urls['url_directory'] === $url['url_directory'] &&
                            $old_user_urls['url_class'] === $url['url_class'] &&
                            $old_user_urls['url_method'] === $url['url_method']
                    ) {
                        $user_url_permission = $old_user_urls['user_url_permission'];
                        array_push($new_user_urls_array, array(
                            'users_id' => $user,
                            'urls_id' => $url['url_id'],
                            'user_url_permission' => $user_url_permission
                        ));
                    }
                }
            }
        }
        if ($this->Acl_model->update_group_urls($new_group_urls_array) &&
                $this->Acl_model->update_user_urls($new_user_urls_array)) {
            redirect('acl/url-sets');
        }
//        @write_file(FCPATH . 'up', '');
//        @unlink(FCPATH . 'down');
    }

    function url_sets() {
        $data = array();
        $data['url_sets'] = $this->Acl_model->get_url_sets();
        $data['urls'] = $this->Acl_model->get_urls();
        $this->render_view($data);
    }

    function update_url_set() {
        if ($this->input->post('url_id') && $this->input->post('url_set_id')) {
            if ($this->Acl_model->update_url_set(str_replace('url_', '', $this->input->post('url_id')), str_replace('url_set_', '', $this->input->post('url_set_id')))) {
                die('1');
            }
        }
        die('0');
    }

    function add_url_set() {
        if ($this->input->post('url_set_name')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('url_set_name', 'URL Set Name', 'trim|required|is_unique[url_sets.url_set_name]');
            if ($this->form_validation->run()) {
                $url_set_insert_array = array(
                    'url_set_name' => $this->input->post('url_set_name'),
                    'url_set_slug' => url_title($this->input->post('url_set_name'), '-', TRUE),
                    'url_set_created' => date('Y-m-d H:i:s')
                );
                if ($this->Acl_model->add_url_set($url_set_insert_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

    function delete_url_set() {
        if ($this->input->post('url_set_id')) {
            $urls_array = $this->Acl_model->get_urls_by_url_set_id($this->input->post('url_set_id'));
            if (count($urls_array) === 0 && $this->Acl_model->delete_url_set($this->input->post('url_set_id'))) {
                die('1');
            }
        }
        die('0');
    }

    function group($group_id = 0) {
        if ($group_id !== 0) {
            $data = array();
            $data['url_sets'] = $this->Acl_model->get_url_sets();
            $data['urls'] = $this->Acl_model->get_group_urls_by_group_id($group_id);
            $this->load->model('Group_model');
            $data['group'] = $this->Group_model->get_group_by_id($group_id);
            $this->render_view($data);
        } else {
            redirect('groups');
        }
    }

    function update_group_url_premission() {
        if ($this->Acl_model->update_group_url_premission(end(explode('/', $this->input->server('HTTP_REFERER'))), $this->input->post('urls_id'), $this->input->post('group_url_permission'))) {
            die('1');
        }
        die('0');
    }

    function user($user_id = 0) {
        if ($user_id !== 0) {
            $data = array();
            $data['url_sets'] = $this->Acl_model->get_url_sets();
            $this->load->model('User_model');
            $data['user'] = $this->User_model->get_user_by_id($user_id);
            $group_urls_array = $this->Acl_model->get_group_urls_by_group_id($data['user']['groups_id']);
            $user_urls_array = $this->Acl_model->get_user_urls_by_user_id($user_id);
            $urls = array();
            if (count($user_urls_array) === 0) {
                foreach ($group_urls_array as $group_url) {
                    $urls[] = array(
                        'users_id' => $user_id,
                        'urls_id' => $group_url['urls_id'],
                        'user_url_permission' => $group_url['group_url_permission'],
                        'url_id' => $group_url['url_id'],
                        'url_sets_id' => $group_url['url_sets_id'],
                        'url_directory' => $group_url['url_directory'],
                        'url_class' => $group_url['url_class'],
                        'url_method' => $group_url['url_method']
                    );
                }
            } else {
                $merged_array = array_merge($group_urls_array, $user_urls_array);
                unset($group_urls_array, $user_urls_array);
                foreach ($merged_array as $array) {
                    $urls[$array['url_id']] = array(
                        'users_id' => $user_id,
                        'urls_id' => $array['urls_id'],
                        'user_url_permission' => isset($array['group_url_permission']) ? $array['group_url_permission'] : $array['user_url_permission'],
                        'url_id' => $array['url_id'],
                        'url_sets_id' => $array['url_sets_id'],
                        'url_directory' => $array['url_directory'],
                        'url_class' => $array['url_class'],
                        'url_method' => $array['url_method']
                    );
                }
                unset($merged_array);
            }
            $data['urls'] = $urls;
            $this->render_view($data);
        } else {
            redirect('users');
        }
    }

    function update_user_url_premission() {
        $this->load->model('User_model');
        $user_array = $this->User_model->get_user_by_id(end(explode('/', $this->input->server('HTTP_REFERER'))));
        $group_permission = $this->Acl_model->get_group_permission_by_url_id($user_array['groups_id'], $this->input->post('urls_id'));
        if ($group_permission['group_url_permission'] === $this->input->post('user_url_permission')) {
            if ($this->Acl_model->delete_user_url_premission(end(explode('/', $this->input->server('HTTP_REFERER'))), $this->input->post('urls_id'))) {
                die('1');
            }
        } else {
            if ($this->Acl_model->add_user_url_premission(end(explode('/', $this->input->server('HTTP_REFERER'))), $this->input->post('urls_id'), $this->input->post('user_url_permission'))) {
                die('1');
            }
        }
        die('0');
    }

}