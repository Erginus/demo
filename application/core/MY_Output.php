<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Output extends CI_Output {

    function __construct() {
        parent::__construct();
    }

    function _display($output = '') {
        if (ENVIRONMENT !== 'development') {
            $this->final_output = str_replace('> <', '><', preg_replace("/\s+|\n+|\r/", ' ', $this->final_output));
        }
        parent::_display($output);
    }

    function _write_cache($output) {
        $CI = & get_instance();
        $path = $CI->config->item('cache_path');
        $cache_path = ($path === '') ? APPPATH . 'cache/' : $path;
        if (!is_dir($cache_path) OR !is_really_writable($cache_path)) {
            log_message('error', "Unable to write cache file: " . $cache_path);
            return;
        }
        $uri = $CI->config->item('base_url') . $CI->config->item('index_page') . $CI->uri->uri_string();
        $cache_path = $this->_cache_file_path($cache_path, md5($uri), 'W');
        if (!$fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
            log_message('error', "Unable to write cache file: " . $cache_path);
            return;
        }
        $expire = time() + ($this->cache_expiration * 60);
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $expire . 'TS--->' . $output);
            flock($fp, LOCK_UN);
        } else {
            log_message('error', "Unable to secure a file lock for file at: " . $cache_path);
            return;
        }
        fclose($fp);
        @chmod($cache_path, FILE_WRITE_MODE);
        log_message('debug', "Cache file written: " . $cache_path);
    }

    function _display_cache(&$CFG, &$URI) {
        $cache_path = ($CFG->item('cache_path') === '') ? APPPATH . 'cache/' : $CFG->item('cache_path');
        $uri = $CFG->item('base_url') . $CFG->item('index_page') . $URI->uri_string;
        $filepath = $this->_cache_file_path($cache_path, md5($uri), 'R');
        if (!@file_exists($filepath)) {
            return FALSE;
        }
        if (!$fp = @fopen($filepath, FOPEN_READ)) {
            return FALSE;
        }
        flock($fp, LOCK_SH);
        $cache = '';
        if (filesize($filepath) > 0) {
            $cache = fread($fp, filesize($filepath));
        }
        flock($fp, LOCK_UN);
        fclose($fp);
        if (!preg_match("/(\d+TS--->)/", $cache, $match)) {
            return FALSE;
        }
        if (time() >= trim(str_replace('TS--->', '', $match['1']))) {
            if (is_really_writable($cache_path)) {
                @unlink($filepath);
                log_message('debug', "Cache file has expired. File deleted");
                return FALSE;
            }
        }
        $this->_display(str_replace($match['0'], '', $cache));
        log_message('debug', "Cache file is current. Sending it to browser.");
        return TRUE;
    }

    function _cache_clear($uri) {
        $CI = & get_instance();
        $path = $CI->config->item('cache_path');
        $cache_path = ($path === '') ? APPPATH . 'cache/' : $path;
        if (!is_dir($cache_path) OR !is_really_writable($cache_path)) {
            log_message('error', "Unable to write cache file: " . $cache_path);
            return FALSE;
        }
        $cache_path = $this->_cache_file_path($cache_path, md5($uri), 'R');
        if (file_exists($cache_path)) {
            touch($cache_path);
            if (unlink($cache_path)) {
                file_get_contents($uri);
                return TRUE;
            }
        }
        return FALSE;
    }

    function _cache_file_path($path, $string, $mode) {
        $folder = '';
        for ($i = 0; $i < (strlen($string) - 2); $i++) {
            if ($i % 2 === 0) {
                $folder .= $string[$i];
            } else {
                $folder .= $string[$i] . '/';
            }
        }
        $path .= $folder;
        if (!is_dir($path) && $mode === 'W') {
            @mkdir($path, DIR_WRITE_MODE, TRUE);
        }
        return $path . $string;
    }

}