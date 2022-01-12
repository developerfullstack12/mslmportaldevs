<?php
/**
 * Plugin Name: Email Verification / SMS verification / Mobile Verification
 * Plugin URI: http://miniorange.com
 * Description: Email & SMS OTP Verification for all forms. Passwordless Login. SMS Notification. Support External Gateway Provider for OTP Verification ,24/7 Support
 * Version: 77.77.77
 * Author: miniOrange
 * Author URI: http://miniorange.com
 * Text Domain: miniorange-otp-verification
 * Domain Path: /lang
 * WC requires at least: 2.0.0
 * WC tested up to: 4.3.3
 * License: GPL2
 */


use OTP\MoOTP;
if (defined("\x41\x42\123\x50\x41\124\110")) {
    goto Mn;
}
die;
Mn:
define("\x4d\x4f\126\137\120\114\125\x47\111\116\x5f\116\101\115\105", plugin_basename(__FILE__));
$fa = substr(MOV_PLUGIN_NAME, 0, strpos(MOV_PLUGIN_NAME, "\x2f"));
define("\x4d\x4f\126\x5f\x4e\x41\115\x45", $fa);
include "\x5f\141\165\x74\157\154\x6f\x61\x64\x2e\x70\150\x70";
MoOTP::instance();
