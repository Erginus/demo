<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Asia/Calcutta');
session_start();

function pr($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die;
}

class MY_Controller extends CI_Controller {

    public $public_methods = array();

    function __construct() {
        parent::__construct();
        if (!is_file(FCPATH . 'up')) {
            die;
        }
        if (isset($_SESSION['user']['force_change_password']) && $_SESSION['user']['force_change_password'] === '1' && $this->uri->uri_string != 'auth/change-password' && $this->uri->uri_string != 'auth/logout') {
            redirect('auth/change-password', 'refresh');
        }
        if (!in_array($this->router->method, $this->public_methods) && !$this->check_auth()) {
            $method_exists = FALSE;
            $controller_name_class = new ReflectionClass($this->router->class);
            foreach ($controller_name_class->getMethods() as $controller_name_methods) {
                if ($controller_name_methods->class === $controller_name_class->name && $controller_name_methods->name === $this->router->method) {
                    $method_exists = TRUE;
                }
            }
            if ($method_exists) {
                redirect('pages/unauthorized', 'refresh');
            } else {
                redirect('pages/not-found', 'refresh');
            }
        }
        if (ENVIRONMENT === 'development' && !$this->input->is_ajax_request() && !$this->input->is_cli_request()) {
//            $this->output->enable_profiler(TRUE);
        }
    }

    function render_view($data = array(), $template = '', $view = '', $get_string = FALSE) {
        if ($template === '') {
            $template = 'common';
            if (isset($_SESSION['user']['group_slug'])) {
                $template = $_SESSION['user']['group_slug'];
            }
        }
        if ($view === '' && $this->router->directory === '') {
            $view = $this->router->class . '/' . $this->router->method;
        } else {
            if ($view === '') {
                $view = $this->router->class . '/' . $this->router->method;
            }
        }
        if ($get_string) {
            $return = $this->load->view('templates/' . $template . '/header', $data, TRUE);
            $return .= $this->load->view($view, $data, TRUE);
            $return .= $this->load->view('templates/' . $template . '/footer', $data, TRUE);
            return $return;
        }
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/common/noscript');
        $this->load->view($view, $data);
        $this->load->view('templates/' . $template . '/footer', $data);
        return;
    }

    function json_output($data) {
        $this->output->enable_profiler(FALSE);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function check_auth() {
        if (isset($_SESSION['user'])) {
            $this->load->model('Acl_model');
            $user_urls_array = $this->Acl_model->get_user_url_permission_by_user_id($_SESSION['user']['user_id'], $this->router->directory, $this->router->class, $this->router->method);
            if (isset($user_urls_array['user_url_permission']) && $user_urls_array['user_url_permission'] === '1') {
                return TRUE;
            } else if (isset($user_urls_array['user_url_permission']) && $user_urls_array['user_url_permission'] === '0') {
                return FALSE;
            } else {
                $group_urls_array = $this->Acl_model->get_group_url_permission_by_user_id($_SESSION['user']['groups_id'], $this->router->directory, $this->router->class, $this->router->method);
                if (isset($group_urls_array['group_url_permission']) && $group_urls_array['group_url_permission'] === '1') {
                    return TRUE;
                }
            }
        } else {
            if ($this->uri->uri_string != 'auth/login') {
                $this->session->set_userdata('redirect_uri', $this->uri->uri_string);
                redirect('auth/login', 'refresh');
            }
        }
        return FALSE;
    }

    function generate_dropdown_array($array, $key, $value, $default = '') {
        $return = array();
        $return[''] = $default;
        foreach ($array as $result) {
            $return[$result[$key]] = $result[$value];
        }
        return $return;
    }

    function send_email($email_hash, $email_subject, $email_from, $email_to, $email_body, $attachments_array = array()) {
        $this->load->config('email');
        $email_details_array = array(
            'email_hash' => $email_hash,
            'email_from' => $email_from ? $email_from : $this->config->item('email_from'),
            'email_from_name' => $this->config->item('email_from_name'),
            'email_to' => $email_to,
            'email_subject' => $email_subject,
            'email_body' => $email_body,
            'email_priority' => '5',
            'email_status' => '0',
            'email_created' => date('Y-m-d H:i:s'),
        );
        if ($this->config->item('email_cron') === FALSE) {
            $this->load->library('email');
            $config['mailtype'] = $this->config->item('mailtype');
            $config['crlf'] = $this->config->item('crlf');
            $config['newline'] = $this->config->item('newline');
            $config['wordwrap'] = $this->config->item('wordwrap');
            if ($this->config->item('email_smtp') === TRUE) {
                $config['protocol'] = $this->config->item('protocol');
                $config['smtp_host'] = $this->config->item('smtp_host');
                $config['smtp_port'] = $this->config->item('smtp_port');
                $config['smtp_user'] = $this->config->item('smtp_user');
                $config['smtp_pass'] = $this->config->item('smtp_pass');
            }
            $this->email->initialize($config);
            $this->email->from($this->config->item('email_from'), $this->config->item('email_from_name'));
            $this->email->to($email_to);
            $this->email->subject($email_subject);
            $this->email->message($email_body);
            foreach ($attachments_array as $attachment) {
                $this->email->attach($attachment);
            }
            if ($this->email->send()) {
                $email_details_array['email_status'] = '1';
            } else {
                $email_details_array['email_status'] = '4';
            }
            $email_details_array['email_processed'] = date('Y-m-d H:i:s');
        }
        $this->load->model('Email_model');
        return $this->Email_model->add_email_to_queue($email_details_array);
    }

    function get_pagination($base_url, $counter_position, $total_rows, $per_page = NULL, $is_ajax = FALSE, $div_id = '', $show_count = FALSE, $additional_param = '') {
        if ($is_ajax === TRUE) {
            $this->load->library('Jquery_pagination');
            $config['div'] = '#' . $div_id;
            $config['show_count'] = $show_count;
            $config['additional_param'] = $additional_param;
        } else {
            $this->load->library('pagination');
        }
        $config['base_url'] = $base_url;
        $config['uri_segment'] = $counter_position;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';
        $config['first_tag_open'] = '';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_close'] = '';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '';
        $config['last_tag_close'] = '';
        $config['cur_tag_open'] = '<a class="number current" href="javascript:;">';
        $config['cur_tag_close'] = '</a>';
        $config['next_tag_open'] = '';
        $config['next_link'] = 'Next &raquo;';
        $config['next_tag_close'] = '';
        $config['prev_tag_open'] = '';
        $config['prev_link'] = '&laquo; Previous';
        $config['prev_tag_close'] = '';
        $config['total_rows'] = $total_rows;
        $config['anchor_class'] = 'class=""';
        if ($per_page != NULL) {
            $config['per_page'] = $per_page;
        } else {
            $config['per_page'] = '10';
        }
        if ($is_ajax === TRUE) {
            $this->jquery_pagination->initialize($config);
            if ($this->jquery_pagination->create_links() != '') {
                return $this->jquery_pagination->create_links();
            }
        } else {
            $this->pagination->initialize($config);
            if ($this->pagination->create_links() != '') {
                return $this->pagination->create_links();
            }
        }
        return;
    }

    function mask_characters($string, $length = 6) {
        return substr_replace($string, str_repeat('*', $length), 0, $length);
    }

    function create_captcha() {
        $this->load->helper('captcha');
        $this->load->helper('string');
        $random_string = random_string('numeric', 6);
        $random_font_array = glob(FCPATH . 'googlefonts/*.ttf');
        shuffle($random_font_array);
        $captcha_array = array(
            'word' => $random_string,
            'img_path' => FCPATH . 'captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => $random_font_array[0],
            'img_width' => '150',
            'img_height' => '30',
            'expiration' => 300
        );
        $captcha = create_captcha($captcha_array);
        $_SESSION['captcha_image'] = $random_string;
        return $captcha['image'];
    }

    function validate_captcha($captcha_image) {
        if (isset($_SESSION['captcha_image']) && $captcha_image === $_SESSION['captcha_image']) {
            unset($_SESSION['captcha_image']);
            return TRUE;
        }
        $this->form_validation->set_message('validate_captcha', 'The %s is not correct.');
        unset($_SESSION['captcha_image']);
        return FALSE;
    }

    function add_email_tracking($email_hash, $email_body) {
        $dom = new DOMDocument();
        @$dom->loadHTML($email_body);
        $xpath = new DOMXPath($dom);
        $hrefs = $xpath->evaluate("/html/body//a");
        $urls_array = array();
        for ($i = 0; $i < $hrefs->length; $i++) {
            $href = $hrefs->item($i);
            $url = $href->getAttribute('href');
            if (!in_array($url, $urls_array)) {
                array_push($urls_array, $url);
            }
        }
        foreach ($urls_array as $url) {
            $email_body = str_replace($url, base_url() . 'emails/track/' . $email_hash . '/' . urlencode(base64_encode($url)), $email_body);
        }
        return $email_body;
    }

    function download_table($table, $skip_column_array) {
        set_time_limit(0);
        $this->load->database();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $table . '_' . date('d-M-Y-h-i-s-a') . '.xls');
        $columns_array = $this->db->query("SHOW COLUMNS FROM " . $table . ";")->result_array();
        $headers_columns_array = array();
        foreach ($columns_array as $column) {
            if (!in_array($column['Field'], $skip_column_array)) {
                $headers_columns_array[] = $column['Field'];
            }
        }
        $fp = fopen('php://output', 'w');
        fputcsv($fp, $headers_columns_array, "\t");
        $result = mysqli_query($this->db->conn_id, "SELECT " . implode(',', $headers_columns_array) . " FROM " . $table . ";", MYSQLI_USE_RESULT);
        while ($row = $result->fetch_row()) {
            fputcsv($fp, $row, "\t");
        }
        fclose($fp);
    }

    function array_search_by_value($array, $search) {
        $result = array();
        foreach ($array as $key => $value) {
            foreach ($search as $k => $v) {
                if (!isset($value[$k]) || $value[$k] != $v) {
                    continue 2;
                }
            }
            $result[] = $key;
        }
        return $result;
    }

}