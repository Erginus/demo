<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require FCPATH . 'application/third_party/Facebook/facebook.php';

class Facebook_api extends Facebook {

    private $ci;

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->config('social');
        parent::__construct(array('appId' => $this->ci->config->item('facebook_app_id'), 'secret' => $this->ci->config->item('facebook_app_secret')));
    }

    public function login($redirect_uri) {
        $user = $this->getUser();
        if ($user) {
            try {
                $user_profile = $this->api('/me');
                return $user_profile;
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }
        if (!$user) {
            $loginUrl = $this->getLoginUrl(array('scope' => 'email', 'redirect_uri' => base_url() . 'index.php/' . $redirect_uri . '/'));
            redirect($loginUrl);
        }
    }

}