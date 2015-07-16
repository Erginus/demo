<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['email_cron'] = FALSE; // Set to TRUE if emails are sent via cron job.
$config['email_smtp'] = TRUE; // Set to TRUE if emails are sent via smtp.
$config['email_from'] = 'ksingh.cec@gmail.com';
$config['email_from_name'] = 'Khushal Singh';
$config['mailtype'] = "html";
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['wordwrap'] = FALSE;
$config['charset'] = "utf-8";

/**
 * SMTP Settings
 */
if ($config['email_smtp'] === TRUE) {
    $config['protocol'] = "smtp";
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = $config['email_from'];
    $config['smtp_pass'] = base64_decode(base64_decode(base64_decode('WVROT2NHSnRaRzlZZWxsNFQwUlZQUT09')));
}