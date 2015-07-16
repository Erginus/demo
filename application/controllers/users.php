<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller {

    public $public_methods = array('unsubscribe');

    function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    function index() {
        $this->render_view();
    }

    function datatable() {
        $this->load->library('Datatables');
        $this->datatables->select('user_id,user_login,user_first_name,user_last_name,user_email,group_name,user_status,user_created')->from('users')->join('groups', 'users.groups_id = groups.group_id');
        echo $this->datatables->generate();
    }

    function add() {
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('groups_id', 'User Group', 'trim|required');
            $this->form_validation->set_rules('user_login', 'Username', 'trim|required|min_length[5]|max_length[20]|is_unique[users.user_login]');
            $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim');
            $this->form_validation->set_rules('user_login_password', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('user_confirm_password', 'Confirm Password ', 'trim|required|matches[user_login_password]');
            $this->form_validation->set_rules('captcha_image', 'Image Text', 'trim|required|callback_validate_captcha');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $this->load->library('encrypt');
                $user_details_array = array(
                    'groups_id' => $this->input->post('groups_id'),
                    'user_first_name' => $this->input->post('user_first_name'),
                    'user_last_name' => $this->input->post('user_last_name'),
                    'user_email' => $this->input->post('user_email'),
                    'user_login' => $this->input->post('user_login'),
                    'user_login_salt' => md5($time_now),
                    'user_login_password' => md5(md5(md5($time_now) . $this->input->post('user_login_password'))),
                    'user_password_hash' => $this->encrypt->encode($this->input->post('user_login_password'), md5(md5(md5($time_now) . $this->input->post('user_login_password')))),
                    'user_security_hash' => md5($time_now . $this->input->post('user_login_password')),
                    'user_status' => '0',
                    'user_created' => $time_now
                );
                if ($this->User_model->add($user_details_array)) {
                    $this->load->helper('string');
                    $email_hash = random_string('unique');
                    $email_body = parent::add_email_tracking($email_hash, $this->render_view(
                                            array(
                                        'email_hash' => $email_hash,
                                        'user_first_name' => $this->input->post('user_first_name'),
                                        'user_last_name' => $this->input->post('user_last_name'),
                                        'user_login' => $this->input->post('user_login'),
                                        'user_login_password' => $this->input->post('user_login_password'),
                                        'verify_account_link' => base_url() . 'auth/verify-account/' . $user_details_array['user_security_hash'],
                                            ), 'emails', 'emails/users_add', TRUE
                                    ));
                    if (parent::send_email($email_hash, 'Verify Account Notification', $this->config->item('email_from'), $user_details_array['user_email'], $email_body)) {
                        $data['success'] = 'We have sent account verification instructions on ' . parent::mask_characters($user_details_array['user_email']);
                    } else {
                        $data['error'] = 'Error Sending Email !!!';
                    }
                } else {
                    $data['error'] = 'Error Adding User Account !!!';
                }
            } else {
                $data['error'] = 'Error Adding User Account !!!';
            }
        }
        $this->load->model('Group_model');
        $data['groups_array'] = $this->generate_dropdown_array($this->Group_model->get_all_active_groups(), 'group_id', 'group_name', 'Select User Group');
        $data['captcha_image'] = parent::create_captcha();
        $this->render_view($data);
    }

    function delete() {
        if ($this->input->post('user_id') && $this->User_model->delete($this->input->post('user_id'))) {
            die('1');
        }
        die('0');
    }

    function edit($user_id = 0) {
        if ($user_id !== 0) {
            $data = array();
            $this->load->helper('form');
            if ($this->input->post()) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('groups_id', 'User Group', 'trim|required');
                $this->form_validation->set_rules('user_login', 'Username', 'trim|required|min_length[5]|max_length[20]|edit_unique[users.user_login.user_id.' . $user_id . ']');
                $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|edit_unique[users.user_email.user_id.' . $user_id . ']');
                $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim');
                $this->form_validation->set_rules('user_status', 'User Status', 'trim|required');
                $this->form_validation->set_rules('notify_user', 'Email Notification', 'trim');
                $this->form_validation->set_rules('captcha_image', 'Image Text', 'trim|required|callback_validate_captcha');
                $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
                if ($this->form_validation->run()) {
                    $time_now = date('Y-m-d H:i:s');
                    $user_details_array = array(
                        'groups_id' => $this->input->post('groups_id'),
                        'user_first_name' => $this->input->post('user_first_name'),
                        'user_last_name' => $this->input->post('user_last_name'),
                        'user_email' => $this->input->post('user_email'),
                        'user_login' => $this->input->post('user_login'),
                        'user_security_hash' => md5($time_now . $this->input->post('user_login')),
                        'user_status' => $this->input->post('user_status'),
                        'user_modified' => $time_now
                    );
                    if ($this->User_model->edit($user_id, $user_details_array)) {
                        if ($this->input->post('notify_user') && $this->input->post('notify_user') === '1') {
                            $this->load->helper('string');
                            $email_hash = random_string('unique');
                            $email_body = parent::add_email_tracking($email_hash, $this->render_view(
                                                    array(
                                                'email_hash' => $email_hash,
                                                'user_first_name' => $this->input->post('user_first_name'),
                                                'user_last_name' => $this->input->post('user_last_name'),
                                                'user_login' => $this->input->post('user_login'),
                                                'user_email' => $this->input->post('user_email'),
                                                'login_link' => base_url() . 'auth/login',
                                                    ), 'emails', 'emails/users_edit', TRUE
                                            ));
                            if (parent::send_email($email_hash, 'Account Details Modified', $this->config->item('email_from'), $user_details_array['user_email'], $email_body)) {
                                $data['success'] = 'We have sent account detailed instructions on ' . parent::mask_characters($user_details_array['user_email']);
                            } else {
                                $data['error'] = 'Error Sending Email !!!';
                            }
                        } else {
                            $data['success'] = 'Account Edited Successfully !!!';
                        }
                    } else {
                        $data['error'] = 'Error Editing User Account !!!';
                    }
                } else {
                    $data['error'] = 'Error Editing User Account !!!';
                }
            }
            $this->load->model('Group_model');
            $data['groups_array'] = $this->generate_dropdown_array($this->Group_model->get_all_active_groups(), 'group_id', 'group_name', 'Select User Group');
            $data['user_array'] = $this->User_model->get_user_by_id($user_id);
            $data['captcha_image'] = parent::create_captcha();
            $this->render_view($data);
        } else {
            redirect('users');
        }
    }

    function change_password() {
        if ($this->input->post('user_id') && $this->input->post('user_login_password') && $this->input->post('user_confirm_password')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_login_password', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('user_confirm_password', 'Confirm Password ', 'trim|required|matches[user_login_password]');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $this->load->library('encrypt');
                $user_details_array = array(
                    'user_login_salt' => md5($time_now),
                    'user_login_password' => md5(md5(md5($time_now) . $this->input->post('user_login_password'))),
                    'user_password_hash' => $this->encrypt->encode($this->input->post('user_login_password'), md5(md5(md5($time_now) . $this->input->post('user_login_password')))),
                    'user_security_hash' => md5($time_now . $this->input->post('user_login_password')),
                    'force_change_password' => '1',
                    'user_modified' => $time_now
                );
                if ($this->User_model->edit($this->input->post('user_id'), $user_details_array)) {
                    if ($this->input->post('notify_user') && $this->input->post('notify_user') === '1') {
                        $user_array = $this->User_model->get_user_by_id($this->input->post('user_id'));
                        $this->load->helper('string');
                        $email_hash = random_string('unique');
                        $email_body = parent::add_email_tracking($email_hash, $this->render_view(
                                                array(
                                            'email_hash' => $email_hash,
                                            'user_first_name' => $user_array['user_first_name'],
                                            'user_last_name' => $user_array['user_last_name'],
                                            'user_login_password' => $this->input->post('user_login_password'),
                                            'login_link' => base_url() . 'auth/login',
                                                ), 'emails', 'emails/users_change_password', TRUE
                                        ));
                        if (parent::send_email($email_hash, 'Password Changed Notification', $this->config->item('email_from'), $user_array['user_email'], $email_body)) {
                            die('1');
                        } else {
                            die('Error Sending Email !!!');
                        }
                    } else {
                        die('1');
                    }
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

    function profile() {
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_login', 'Username', 'trim|required|min_length[5]|max_length[20]|edit_unique[users.user_login.user_id.' . $_SESSION['user']['user_id'] . ']');
            $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|edit_unique[users.user_email.user_id.' . $_SESSION['user']['user_id'] . ']');
            $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim');
            $this->form_validation->set_rules('newsletter_status', 'Optional Email Updates', 'trim');
            $this->form_validation->set_rules('captcha_image', 'Image Text', 'trim|required|callback_validate_captcha');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $this->load->library('encrypt');
                $user_details_array = array(
                    'user_first_name' => $this->input->post('user_first_name'),
                    'user_last_name' => $this->input->post('user_last_name'),
                    'user_email' => $this->input->post('user_email'),
                    'user_login' => $this->input->post('user_login'),
                    'user_modified' => $time_now
                );
                if ($this->input->post('newsletter_status')) {
                    $user_details_array['newsletter_status'] = $this->input->post('newsletter_status');
                } else {
                    $user_details_array['newsletter_status'] = '0';
                }
                if ($this->User_model->edit($_SESSION['user']['user_id'], $user_details_array)) {
                    $user_login = $this->input->post('user_login');
                    unset($_SESSION['user']);
                    $this->load->model('Auth_model');
                    $_SESSION['user'] = $this->Auth_model->login($user_login);
                    $data['success'] = 'Profile Edited Successfully !!!';
                } else {
                    $data['error'] = 'Error Editing Profile !!!';
                }
            } else {
                $data['error'] = 'Error Editing Profile !!!';
            }
        }
        $data['captcha_image'] = parent::create_captcha();
        $this->render_view($data);
    }

    function unsubscribe($email_hash) {
        if ($email_hash !== '') {
            $this->load->model('Email_model');
            $email_details_array = $this->Email_model->get_email_details_by_hash($email_hash);
            $data = array();
            $this->load->helper('form');
            if ($this->input->post()) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('captcha_image', 'Image Text', 'trim|required|callback_validate_captcha');
                $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
                if ($this->form_validation->run() && $this->input->post('user_email') === $email_details_array['email_to']) {
                    $user_details_array = $this->User_model->get_user_by_email($email_details_array['email_to']);
                    if (count($user_details_array) > 0) {
                        $time_now = date('Y-m-d H:i:s');
                        $user_update_array = array(
                            'user_security_hash' => md5($time_now . $this->input->post('user_email')),
                            'newsletter_status' => '0',
                            'user_modified' => $time_now
                        );
                        if ($this->User_model->edit($user_details_array['user_id'], $user_update_array)) {
                            $data['success'] = 'Unsubscribing Complete !!!';
                        }
                    } else {
                        $data['error'] = 'Unsubscribing Incomplete !!!';
                    }
                } else {
                    $data['error'] = 'Unsubscribing Incomplete !!!';
                }
            }
            $this->load->library('form_validation');
            $data['email_to'] = $email_details_array['email_to'];
            $data['captcha_image'] = parent::create_captcha();
            $this->render_view($data, 'auth');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

}