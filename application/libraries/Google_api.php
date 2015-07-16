<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require FCPATH . 'application/third_party/Google/Client.php';
require FCPATH . 'application/third_party/Google/Service/Oauth2.php';

class Google_api {

    private $ci;
    private $google;

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->config('social');
        $this->google = new Google_Client();
        $this->google->setClientId($this->ci->config->item('google_client_id'));
        $this->google->setClientSecret($this->ci->config->item('google_client_secret'));
    }

    public function login($redirect_uri) {
        $this->google->setRedirectUri(base_url() . $redirect_uri);
        $this->google->addScope(array('email'));
        if (isset($_GET['code'])) {
            $this->google->authenticate($_GET['code']);
            $_SESSION['google_access_token'] = $this->google->getAccessToken();
            redirect($redirect_uri);
        }
        if (isset($_SESSION['google_access_token']) && $_SESSION['google_access_token']) {
            $this->google->setAccessToken($_SESSION['google_access_token']);
            $oauth2Service = new Google_Service_Oauth2($this->google);
            $user_profile = $oauth2Service->userinfo->get();
            return $user_profile;
        } else {
            $loginUrl = $this->google->createAuthUrl();
            redirect($loginUrl);
        }
    }

}