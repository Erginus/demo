<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends MY_Controller {

    public $public_methods = array('create_account', 'forgot_password', 'login', 'logout', 'reset_password', 'verify_account', 'facebook', 'twitter', 'google');

    function __construct() {
        parent::__construct();
    }

    function index() {
        redirect('auth/dashboard', 'refresh');
    }

    function login() {
        $max_login_attempts = 1;
        if (!isset($_SESSION['login_attempt'])) {
            $_SESSION['login_attempt'] = 1;
        }
        $this->load->model('Auth_model');
        $userdata = $this->session->all_userdata();
        if (
                (isset($userdata['user_remember'])) &&
                ($userdata['user_remember'] === '1') &&
                (isset($userdata['user_login'])) &&
                ($userdata['user_login'] != '')
        ) {
            unset($_SESSION['login_attempt']);
            $user_details_array = $this->Auth_model->login($userdata['user_login']);
            $_SESSION['user'] = $user_details_array;
            $this->Auth_model->update_user_login($user_details_array['user_id']);
            if (isset($userdata['redirect_uri']) && $userdata['redirect_uri'] != '') {
                $this->session->unset_userdata('redirect_uri');
                redirect($userdata['redirect_uri'], 'refresh');
            }
            redirect('auth/dashboard', 'refresh');
        }
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_login', 'Username OR Email Address', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('user_login_password', 'Password', 'trim|required|min_length[5]');
            if ($_SESSION['login_attempt'] > $max_login_attempts) {
                $this->form_validation->set_rules('captcha_image', 'Image Text', 'trim|required|callback_validate_captcha');
            }
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            if ($this->form_validation->run()) {
                $user_details_array = $this->Auth_model->login(trim($this->input->post('user_login')));
                if (
                        count($user_details_array) > 0 &&
                        $user_details_array['user_login_password'] === md5(md5($user_details_array['user_login_salt'] . trim($this->input->post('user_login_password'))))
                ) {
                    unset($_SESSION['login_attempt']);
                    $_SESSION['user'] = $user_details_array;
                    if ($this->input->post('user_remember') && $this->input->post('user_remember') === '1') {
                        $this->session->set_userdata(array('user_login' => $user_details_array['user_login'], 'user_remember' => '1'));
                    }
                    $this->Auth_model->update_user_login($user_details_array['user_id']);
                    if (isset($userdata['redirect_uri']) && $userdata['redirect_uri'] != '') {
                        $this->session->unset_userdata('redirect_uri');
                        redirect($userdata['redirect_uri'], 'refresh');
                    }
                    redirect('auth/dashboard', 'refresh');
                }
            }
            $_SESSION['login_attempt'] += 1;
            $data['error'] = 'Error Processing Login !!!';
        }
        if ($_SESSION['login_attempt'] > $max_login_attempts) {
            $data['captcha_image'] = parent::create_captcha();
        }
        $this->render_view($data, 'auth');
    }

    function create_account() {
        $this->load->model('Auth_model');
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_login', 'Username', 'trim|required|min_length[5]|max_length[20]|is_unique[users.user_login]');
            $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim');
            $this->form_validation->set_rules('user_login_password', 'Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('user_confirm_password', 'Confirm Password ', 'trim|required|matches[user_login_password]');
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
                    'user_login_salt' => md5($time_now),
                    'user_login_password' => md5(md5(md5($time_now) . $this->input->post('user_login_password'))),
                    'user_password_hash' => $this->encrypt->encode($this->input->post('user_login_password'), md5(md5(md5($time_now) . $this->input->post('user_login_password')))),
                    'user_security_hash' => md5($time_now . $this->input->post('user_login_password')),
                    'groups_id' => '3',
                    'user_status' => '0',
                    'user_created' => $time_now
                );
                if ($this->input->post('newsletter_status')) {
                    $user_details_array['newsletter_status'] = $this->input->post('newsletter_status');
                } else {
                    $user_details_array['newsletter_status'] = '0';
                }
                if ($this->Auth_model->create_account($user_details_array)) {
                    $this->load->helper('string');
                    $email_hash = random_string('unique');
                    $email_body = parent::add_email_tracking($email_hash, $this->render_view(
                                            array(
                                        'email_hash' => $email_hash,
                                        'user_first_name' => $user_details_array['user_first_name'],
                                        'user_last_name' => $user_details_array['user_last_name'],
                                        'verify_account_link' => base_url() . 'auth/verify-account/' . $user_details_array['user_security_hash'],
                                            ), 'emails', 'emails/verify_account', TRUE
                                    ));
                    if (parent::send_email($email_hash, 'Verify Account Notification', $this->config->item('email_from'), $user_details_array['user_email'], $email_body)) {
                        $data['success'] = 'We have sent account verification instructions on ' . parent::mask_characters($user_details_array['user_email']);
                    } else {
                        $data['error'] = 'Error Sending Email !!!';
                    }
                } else {
                    $data['error'] = 'Error Creating User Account !!!';
                }
            } else {
                $data['error'] = 'Error Creating User Account !!!';
            }
        }
        $data['captcha_image'] = parent::create_captcha();
        $this->render_view($data, 'auth');
    }

    function verify_account($user_security_hash = '') {
        $data = array();
        if ($user_security_hash != '') {
            $this->load->model('Auth_model');
            $user_details_array = $this->Auth_model->get_user_details_by_user_security_hash($user_security_hash);
            if (count($user_details_array) > 0) {
                $this->load->library('encrypt');
                $time_now = date('Y-m-d H:i:s');
                $user_update_array = array(
                    'user_security_hash' => md5($time_now . $this->encrypt->decode($user_details_array['user_password_hash'], $user_details_array['user_login_password'])),
                    'user_status' => '1',
                    'user_modified' => $time_now,
                );
                if ($user_details_array['user_status'] === '0' && $this->Auth_model->update_user_details_by_user_security_hash($user_security_hash, $user_update_array)) {
                    $data['success'] = 'Account Verified Successfully.';
                    session_destroy();
                    $this->session->sess_destroy();
                } else {
                    $data['error'] = 'Invalid Link !!!';
                }
            } else {
                $data['error'] = 'Invalid Link !!!';
            }
        } else {
            $data['error'] = 'Invalid Link !!!';
        }
        $this->render_view($data, 'auth');
    }

    function forgot_password() {
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_detail', 'Username OR Email Address', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('captcha_image', 'Image Text', 'trim|required|callback_validate_captcha');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            if ($this->form_validation->run()) {
                $this->load->model('Auth_model');
                $user_details_array = $this->Auth_model->get_user_by_username_or_email($this->input->post('user_detail'));
                if (count($user_details_array) > 0) {
                    if ($user_details_array['user_status'] !== '-1') {
                        $this->load->helper('string');
                        $email_hash = random_string('unique');
                        $email_body = parent::add_email_tracking($email_hash, $this->render_view(
                                                array(
                                            'email_hash' => $email_hash,
                                            'user_first_name' => $user_details_array['user_first_name'],
                                            'user_last_name' => $user_details_array['user_last_name'],
                                            'password_reset_link' => base_url() . 'auth/reset-password/' . $user_details_array['user_security_hash'],
                                                ), 'emails', 'emails/forgot_password', TRUE
                                        ));
                        if (parent::send_email($email_hash, 'Forgot Password Notification', $this->config->item('email_from'), $user_details_array['user_email'], $email_body)) {
                            $data['success'] = 'We have sent password reset instructions on ' . parent::mask_characters($user_details_array['user_email']);
                        } else {
                            $data['error'] = 'Error Sending Email !!!';
                        }
                    } else {
                        $data['error'] = 'Account Suspended !!!';
                    }
                } else {
                    $data['error'] = 'Invalid User Details !!!';
                }
            } else {
                $data['error'] = 'Error Sending Email !!!';
            }
        }
        $data['captcha_image'] = parent::create_captcha();
        $this->render_view($data, 'auth');
    }

    function reset_password($user_security_hash = '') {
        $max_attempts = 3;
        if (!isset($_SESSION['reset_attempt'])) {
            $_SESSION['reset_attempt'] = 1;
        }
        $data = array();
        $data['show_form'] = TRUE;
        if ($user_security_hash != '') {
            $this->load->model('Auth_model');
            $this->load->helper('form');
            $user_details_array = $this->Auth_model->get_user_details_by_user_security_hash($user_security_hash);
            if (count($user_details_array) > 0) {
                if (!in_array($user_details_array['user_status'], array('0', '1'))) {
                    session_destroy();
                    $this->session->sess_destroy();
                    $data['error'] = 'Account Suspended !!!';
                    $data['show_form'] = FALSE;
                } else {
                    $this->load->library('form_validation');
                    if ($this->input->post()) {
                        $this->form_validation->set_rules('user_login_password', 'Password', 'trim|required|min_length[5]');
                        $this->form_validation->set_rules('user_confirm_password', 'Confirm Password', 'trim|required|matches[user_login_password]');
                        $this->form_validation->set_rules('captcha_image', 'Image Text', 'trim|required|callback_validate_captcha');
                        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
                        if ($this->form_validation->run()) {
                            $this->load->library('encrypt');
                            $time_now = date('Y-m-d H:i:s');
                            $user_array = array(
                                'user_login_salt' => md5($time_now),
                                'user_login_password' => md5(md5(md5($time_now) . $this->input->post('user_login_password'))),
                                'user_password_hash' => $this->encrypt->encode($this->input->post('user_login_password'), md5(md5(md5($time_now) . $this->input->post('user_login_password')))),
                                'user_security_hash' => md5($time_now . $this->input->post('user_login_password')),
                                'user_status' => '1',
                                'user_modified' => $time_now,
                            );
                            if ($this->Auth_model->update_user_details_by_user_security_hash($user_security_hash, $user_array)) {
                                $data['success'] = 'Password Changed Successfully.';
                                $data['show_form'] = FALSE;
                                session_destroy();
                                $this->session->sess_destroy();
                            } else {
                                session_destroy();
                                $this->session->sess_destroy();
                                $data['error'] = 'Error Resetting Password !!!';
                                $data['show_form'] = TRUE;
                            }
                        } else {
                            $_SESSION['reset_attempt'] += 1;
                            if ($_SESSION['reset_attempt'] > $max_attempts) {
                                $this->load->library('encrypt');
                                $time_now = date('Y-m-d H:i:s');
                                $user_array = array(
                                    'user_security_hash' => md5($time_now . $this->input->post('user_login_password')),
                                    'user_modified' => $time_now,
                                );
                                if ($this->Auth_model->update_user_details_by_user_security_hash($user_security_hash, $user_array)) {
                                    $data['error'] = 'Link Disabled Permanently !!!';
                                    $data['show_form'] = FALSE;
                                    session_destroy();
                                    $this->session->sess_destroy();
                                }
                            } else {
                                $data['error'] = 'Error Resetting Password !!!';
                                $data['show_form'] = TRUE;
                            }
                        }
                    }
                }
            } else {
                session_destroy();
                $this->session->sess_destroy();
                $data['error'] = 'Invalid Link !!!';
                $data['show_form'] = FALSE;
            }
        } else {
            session_destroy();
            $this->session->sess_destroy();
            $data['error'] = 'Invalid Link !!!';
            $data['show_form'] = FALSE;
        }
        $data['captcha_image'] = parent::create_captcha();
        $this->render_view($data, 'auth');
    }

    function change_password() {
        $data = array();
        $this->load->helper('form');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_old_password', 'Old Password', 'trim|required|callback__old_password_check');
            $this->form_validation->set_rules('user_login_password', 'New Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('user_confirm_password', 'Confirm Password', 'trim|required|matches[user_login_password]');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            if ($this->form_validation->run()) {
                $this->load->library('encrypt');
                $time_now = date('Y-m-d H:i:s');
                $user_array = array(
                    'user_login_salt' => md5($time_now),
                    'user_login_password' => md5(md5(md5($time_now) . $this->input->post('user_login_password'))),
                    'user_password_hash' => $this->encrypt->encode($this->input->post('user_login_password'), md5(md5(md5($time_now) . $this->input->post('user_login_password')))),
                    'user_security_hash' => md5($time_now . $this->input->post('user_login_password')),
                    'force_change_password' => '0',
                    'user_modified' => $time_now
                );
                $this->load->model('Auth_model');
                if ($this->Auth_model->update_user_details_by_user_security_hash($_SESSION['user']['user_security_hash'], $user_array)) {
                    $user_login = $_SESSION['user']['user_login'];
                    unset($_SESSION['user']);
                    $_SESSION['user'] = $this->Auth_model->login($user_login);
                    $data['success'] = 'Password Changed Successfully.';
                } else {
                    $data['error'] = 'Error in Changing Password !!!';
                }
            }
        }
        $this->render_view($data);
    }

    function _old_password_check($old_password) {
        if ($_SESSION['user']['user_login_password'] === md5(md5($_SESSION['user']['user_login_salt'] . $old_password))) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_old_password_check', 'Old Password do not match.');
        }
        return FALSE;
    }

    function dashboard() {
        $data = array();
        $this->render_view($data, '', 'auth/' . $_SESSION['user']['group_slug'] . '_dashboard');
    }

    function logout() {
        session_destroy();
        $this->session->sess_destroy();
        redirect('auth/login', 'refresh');
    }

    function facebook() {
        $this->load->library('Facebook_api');
        $user_profile = $this->facebook_api->login($this->uri->uri_string);
        if (isset($user_profile['email'])) {
            $this->load->model('Auth_model');
            $user_details_array = $this->Auth_model->login($user_profile['email']);
            if (count($user_details_array) > 0) {
                if ($user_details_array['user_facebook_id'] === '') {
                    $this->load->model('User_model');
                    $this->User_model->edit($user_details_array['user_id'], array('user_facebook_id' => $user_profile['id']));
                    $user_details_array['user_facebook_id'] = $user_profile['id'];
                }
                $userdata = $this->session->all_userdata();
                $_SESSION['user'] = $user_details_array;
                $this->Auth_model->update_user_login($user_details_array['user_id']);
                if (isset($userdata['redirect_uri']) && $userdata['redirect_uri'] != '') {
                    $this->session->unset_userdata('redirect_uri');
                    redirect($userdata['redirect_uri'], 'refresh');
                }
                redirect('auth/dashboard', 'refresh');
            } else {
                $time_now = date('Y-m-d H:i:s');
                $this->load->library('encrypt');
                $user_details_array = array(
                    'user_facebook_id' => $user_profile['id'],
                    'user_first_name' => $user_profile['first_name'],
                    'user_last_name' => $user_profile['last_name'],
                    'user_email' => $user_profile['email'],
                    'user_login' => '',
                    'user_login_salt' => md5($time_now),
                    'user_login_password' => md5(md5(md5($time_now) . $user_profile['id'])),
                    'user_password_hash' => $this->encrypt->encode($user_profile['id'], md5(md5(md5($time_now) . $user_profile['id']))),
                    'user_security_hash' => md5($time_now . $user_profile['id']),
                    'newsletter_status' => '1',
                    'groups_id' => '3',
                    'user_status' => '1',
                    'user_created' => $time_now
                );
                if ($user_profile['gender'] === 'female') {
                    $user_details_array['user_gender'] = '0';
                } else if ($user_profile['gender'] === 'male') {
                    $user_details_array['user_gender'] = '1';
                } else {
                    $user_details_array['user_gender'] = '-1';
                }
                if ($this->Auth_model->create_account($user_details_array)) {
                    $this->load->helper('string');
                    $email_hash = random_string('unique');
                    $email_body = parent::add_email_tracking($email_hash, $this->render_view(
                                            array(
                                        'email_hash' => $email_hash,
                                        'user_first_name' => $user_details_array['user_first_name'],
                                        'user_last_name' => $user_details_array['user_last_name'],
                                        'users_profile' => base_url() . 'users/profile'
                                            ), 'emails', 'emails/facebook_signup', TRUE
                                    ));
                    if (parent::send_email($email_hash, 'Welcome ' . $user_details_array['user_first_name'] . ' ' . $user_details_array['user_last_name'], $this->config->item('email_from'), $user_details_array['user_email'], $email_body)) {
                        $user_details_array = $this->Auth_model->login($user_profile['email']);
                        if (count($user_details_array) > 0 && isset($user_details_array['user_facebook_id']) && $user_details_array['user_facebook_id'] !== '') {
                            $userdata = $this->session->all_userdata();
                            $_SESSION['user'] = $user_details_array;
                            $this->Auth_model->update_user_login($user_details_array['user_id']);
                            if (isset($userdata['redirect_uri']) && $userdata['redirect_uri'] != '') {
                                $this->session->unset_userdata('redirect_uri');
                                redirect($userdata['redirect_uri'], 'refresh');
                            }
                            redirect('auth/dashboard', 'refresh');
                        }
                    }
                }
            }
        }
        redirect('auth/logout');
    }

    function google() {
        $this->load->library('Google_api');
        $user_profile = $this->google_api->login($this->uri->uri_string);
        if (isset($user_profile->email)) {
            $this->load->model('Auth_model');
            $user_details_array = $this->Auth_model->login($user_profile->email);
            if (count($user_details_array) > 0) {
                if ($user_details_array['user_google_id'] === '') {
                    $this->load->model('User_model');
                    $this->User_model->edit($user_details_array['user_id'], array('user_google_id' => $user_profile->id));
                    $user_details_array['user_facebook_id'] = $user_profile->id;
                }
                $userdata = $this->session->all_userdata();
                $_SESSION['user'] = $user_details_array;
                $this->Auth_model->update_user_login($user_details_array['user_id']);
                if (isset($userdata['redirect_uri']) && $userdata['redirect_uri'] != '') {
                    $this->session->unset_userdata('redirect_uri');
                    redirect($userdata['redirect_uri'], 'refresh');
                }
                redirect('auth/dashboard', 'refresh');
            } else {
                $time_now = date('Y-m-d H:i:s');
                $this->load->library('encrypt');
                $user_details_array = array(
                    'user_google_id' => $user_profile->id,
                    'user_first_name' => $user_profile->givenName,
                    'user_last_name' => $user_profile->familyName,
                    'user_email' => $user_profile->email,
                    'user_login' => '',
                    'user_login_salt' => md5($time_now),
                    'user_login_password' => md5(md5(md5($time_now) . $user_profile->id)),
                    'user_password_hash' => $this->encrypt->encode($user_profile->id, md5(md5(md5($time_now) . $user_profile->id))),
                    'user_security_hash' => md5($time_now . $user_profile->id),
                    'newsletter_status' => '1',
                    'groups_id' => '3',
                    'user_status' => '1',
                    'user_created' => $time_now
                );
                if ($user_profile->gender === 'female') {
                    $user_details_array['user_gender'] = '0';
                } else if ($user_profile->gender === 'male') {
                    $user_details_array['user_gender'] = '1';
                } else {
                    $user_details_array['user_gender'] = '-1';
                }
                if ($this->Auth_model->create_account($user_details_array)) {
                    $this->load->helper('string');
                    $email_hash = random_string('unique');
                    $email_body = parent::add_email_tracking($email_hash, $this->render_view(
                                            array(
                                        'email_hash' => $email_hash,
                                        'user_first_name' => $user_details_array['user_first_name'],
                                        'user_last_name' => $user_details_array['user_last_name'],
                                        'users_profile' => base_url() . 'users/profile'
                                            ), 'emails', 'emails/google_signup', TRUE
                                    ));
                    if (parent::send_email($email_hash, 'Welcome ' . $user_details_array['user_first_name'] . ' ' . $user_details_array['user_last_name'], $this->config->item('email_from'), $user_details_array['user_email'], $email_body)) {
                        $user_details_array = $this->Auth_model->login($user_profile->email);
                        if (count($user_details_array) > 0 && isset($user_details_array['user_google_id']) && $user_details_array['user_google_id'] !== '') {
                            $userdata = $this->session->all_userdata();
                            $_SESSION['user'] = $user_details_array;
                            $this->Auth_model->update_user_login($user_details_array['user_id']);
                            if (isset($userdata['redirect_uri']) && $userdata['redirect_uri'] != '') {
                                $this->session->unset_userdata('redirect_uri');
                                redirect($userdata['redirect_uri'], 'refresh');
                            }
                            redirect('auth/dashboard', 'refresh');
                        }
                    }
                }
            }
            redirect('auth/logout');
        }
    }

}