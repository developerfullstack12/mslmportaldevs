<?php


namespace OTP\Helper;

if (defined("\x41\x42\x53\x50\x41\x54\110")) {
    goto aU;
}
die;
aU:
use OTP\Objects\IGatewayFunctions;
use OTP\Objects\NotificationSettings;
use OTP\Traits\Instance;
class GatewayFunctions implements IGatewayFunctions
{
    use Instance;
    private $gateway;
    private $pluginTypeToClass = array("\115\151\x6e\x69\117\162\x61\x6e\147\145\107\x61\x74\145\x77\141\171" => "\117\124\x50\x5c\x48\145\154\160\145\x72\134\115\151\156\151\117\162\141\x6e\x67\x65\x47\141\x74\x65\x77\x61\x79", "\103\x75\x73\164\157\155\x47\141\x74\x65\x77\141\171\x57\x69\x74\150\101\x64\x64\157\x6e\x73" => "\117\124\120\x5c\x48\x65\x6c\x70\x65\162\134\103\x75\x73\x74\157\x6d\x47\x61\x74\x65\x77\141\x79\127\151\164\x68\x41\x64\144\157\156\163", "\x43\165\x73\x74\x6f\155\x47\x61\164\145\x77\x61\171\127\x69\164\150\157\x75\164\x41\144\x64\157\156\x73" => "\x4f\124\120\134\110\145\154\x70\145\x72\x5c\103\165\x73\164\157\155\x47\141\164\145\167\141\171\x57\151\164\150\157\165\164\101\x64\144\x6f\156\163", "\124\x77\151\154\x69\157\x47\x61\x74\x65\x77\x61\x79\127\x69\164\150\101\144\144\x6f\156\x73" => "\117\x54\x50\x5c\x48\x65\x6c\x70\145\x72\134\x54\167\151\154\x69\x6f\x47\141\164\x65\x77\141\171\127\x69\164\150\x41\144\144\x6f\x6e\x73", "\x45\x6e\164\x65\162\x70\x72\x69\x73\145\107\x61\164\x65\167\x61\171\127\151\x74\150\x41\144\144\157\156\163" => "\117\x54\120\x5c\110\x65\154\x70\145\162\134\x45\x6e\x74\145\x72\160\162\x69\x73\145\x47\x61\x74\145\167\x61\171\x57\x69\x74\x68\101\144\x64\157\156\x73");
    public function __construct()
    {
        $ou = $this->pluginTypeToClass[MOV_TYPE];
        $this->gateway = $ou::instance();
    }
    public function isMG()
    {
        return $this->gateway->isMG();
    }
    public function loadAddons($j9)
    {
        $this->gateway->loadAddons($j9);
    }
    function registerAddOns()
    {
        $this->gateway->registerAddOns();
    }
    public function showAddOnList()
    {
        $this->gateway->showAddOnList();
    }
    function hourlySync()
    {
        $this->gateway->hourlySync();
    }
    public function custom_wp_mail_from_name($Wk)
    {
        return $this->gateway->custom_wp_mail_from_name($Wk);
    }
    public function flush_cache()
    {
        $this->gateway->flush_cache();
    }
    public function _vlk($post)
    {
        $this->gateway->_vlk($post);
    }
    public function _mo_configure_sms_template($zy)
    {
        $this->gateway->_mo_configure_sms_template($zy);
    }
    public function _mo_configure_email_template($zy)
    {
        $this->gateway->_mo_configure_email_template($zy);
    }
    public function mo_send_otp_token($Vi, $h4, $fk)
    {
        return $this->gateway->mo_send_otp_token($Vi, $h4, $fk);
    }
    public function mclv()
    {
        return $this->gateway->mclv();
    }
    public function isGatewayConfig()
    {
        return $this->gateway->isGatewayConfig();
    }
    public function showConfigurationPage($GZ)
    {
        $this->gateway->showConfigurationPage($GZ);
    }
    public function mo_validate_otp_token($Mc, $Fz)
    {
        return $this->gateway->mo_validate_otp_token($Mc, $Fz);
    }
    public function mo_send_notif(NotificationSettings $nZ)
    {
        return $this->gateway->mo_send_notif($nZ);
    }
    public function getApplicationName()
    {
        return $this->gateway->getApplicationName();
    }
    public function getConfigPagePointers()
    {
        return $this->gateway->getConfigPagePointers();
    }
}
