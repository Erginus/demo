<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emails extends MY_Controller {

    public $public_methods = array('logo', 'track', 'view');

    function __construct() {
        parent::__construct();
        $this->load->model('Email_model');
    }

    function index() {
        $this->render_view();
    }

    function datatable() {
        $this->load->library('Datatables');
        $this->datatables->select('email_id,email_to,email_subject,email_status,email_created,email_processed,email_open_count,email_click_count')->from('emails');
        echo $this->datatables->generate();
    }

    function download() {
        parent::download_table('emails', array('email_body'));
    }

    function logo($email_hash = '') {
        header("Content-type: image/gif");
        echo file_get_contents(FCPATH . 'assets/images/email-logo.gif');
        $email_hash = substr($email_hash, 0, -4);
        $email_open_count_array = $this->Email_model->get_email_open_count_by_hash($email_hash);
        if (count($email_open_count_array) > 0) {
            $this->load->library('maxmind_geoip');
            $geolocation = $this->maxmind_geoip->get_geolocation_by_ip_address($this->input->server('REMOTE_ADDR'));
            $email_update_details_array = array(
                'email_status' => '2',
                'email_opened_ip' => $this->input->server('REMOTE_ADDR'),
                'email_opened_city' => $geolocation['city'],
                'email_opened_country' => $geolocation['country'],
                'email_opened_user_agent' => $this->input->server('HTTP_USER_AGENT'),
                'email_opened' => date('Y-m-d H:i:s'),
                'email_open_count' => $email_open_count_array['email_open_count'] + 1
            );
            $this->Email_model->update_email_status($email_hash, $email_update_details_array);
        }
    }

    function track($email_hash = '', $redirect = '') {
        if ($email_hash !== '' && $redirect !== '') {
            $email_open_count_array = $this->Email_model->get_email_click_count_by_hash($email_hash);
            if (count($email_open_count_array) > 0) {
                $this->load->library('maxmind_geoip');
                $geolocation = $this->maxmind_geoip->get_geolocation_by_ip_address($this->input->server('REMOTE_ADDR'));
                $email_update_details_array = array(
                    'email_status' => '3',
                    'email_clicked_ip' => $this->input->server('REMOTE_ADDR'),
                    'email_clicked_city' => $geolocation['city'],
                    'email_clicked_country' => $geolocation['country'],
                    'email_clicked_user_agent' => $this->input->server('HTTP_USER_AGENT'),
                    'email_clicked' => date('Y-m-d H:i:s'),
                    'email_click_count' => $email_open_count_array['email_click_count'] + 1
                );
                $this->Email_model->update_email_status($email_hash, $email_update_details_array);
                redirect(base64_decode(urldecode($redirect)), 'refresh');
            }
        }
    }

    function view($email_hash = '') {
        if ($email_hash !== '') {
            $email_body = $this->Email_model->get_email_content_by_hash($email_hash);
            if (isset($email_body['email_body'])) {
                echo $email_body['email_body'];
                die;
            }
        }
        redirect('pages/not-found');
    }
}