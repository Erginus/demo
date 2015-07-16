<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maxmind_geoip {

    public $gi;

    function __construct() {
        include(FCPATH . 'application/third_party/maxmind_geoip/geoipcity.inc.php');
        include(FCPATH . 'application/third_party/maxmind_geoip/geoipregionvars.php');
        $this->gi = geoip_open(FCPATH . 'application/third_party/maxmind_geoip/GeoLiteCity.dat', GEOIP_STANDARD);
    }

    function get_geolocation_by_ip_address($ip_address) {
        $record = geoip_record_by_addr($this->gi, $ip_address);
        return array(
            'country' => $record->country_name,
            'city' => $record->city
        );
    }

    function __destruct() {
        geoip_close($this->gi);
    }

}