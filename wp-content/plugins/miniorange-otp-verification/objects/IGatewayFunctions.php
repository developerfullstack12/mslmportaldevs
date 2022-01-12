<?php


namespace OTP\Objects;

interface IGatewayFunctions
{
    public function registerAddOns();
    public function showAddOnList();
    public function flush_cache();
    public function _vlk($post);
    public function hourlySync();
    public function mclv();
    public function isGatewayConfig();
    public function isMG();
    public function getApplicationName();
    public function custom_wp_mail_from_name($Wk);
    public function _mo_configure_sms_template($zy);
    public function _mo_configure_email_template($zy);
    public function showConfigurationPage($GZ);
    public function mo_send_otp_token($Vi, $h4, $fk);
    public function mo_send_notif(NotificationSettings $nZ);
    public function mo_validate_otp_token($Mc, $Fz);
    public function getConfigPagePointers();
}
