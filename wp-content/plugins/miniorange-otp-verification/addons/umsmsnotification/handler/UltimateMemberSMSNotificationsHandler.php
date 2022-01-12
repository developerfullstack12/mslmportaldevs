<?php


namespace OTP\Addons\UmSMSNotification\Handler;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;
class UltimateMemberSMSNotificationsHandler extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto VX;
        }
        return;
        VX:
        $this->notificationSettings = get_umsn_option("\x6e\x6f\164\151\x66\151\143\x61\164\x69\x6f\x6e\x5f\x73\145\164\164\151\156\147\x73") ? get_umsn_option("\x6e\157\x74\151\146\x69\x63\x61\x74\x69\x6f\x6e\137\x73\x65\164\x74\x69\x6e\x67\x73") : UltimateMemberNotificationsList::instance();
        add_action("\165\155\137\162\x65\x67\x69\x73\x74\162\141\164\x69\157\x6e\137\x63\157\155\x70\154\145\164\145", array($this, "\155\157\x5f\x73\145\x6e\x64\137\156\x65\x77\x5f\x63\165\x73\164\x6f\x6d\x65\x72\x5f\163\155\x73\137\156\x6f\x74\x69\x66"), 1, 2);
    }
    function mo_send_new_customer_sms_notif($ZS, array $LD)
    {
        $this->notificationSettings->getUmNewCustomerNotif()->sendSMS(array_merge(array("\143\x75\163\164\x6f\x6d\x65\x72\137\151\x64" => $ZS), $LD));
        $this->notificationSettings->getUmNewUserAdminNotif()->sendSMS(array_merge(array("\143\x75\x73\164\x6f\x6d\x65\162\137\151\144" => $ZS), $LD));
    }
    function unhook()
    {
        remove_action("\x75\x6d\x5f\162\x65\x67\x69\x73\164\x72\141\x74\151\x6f\156\137\143\x6f\x6d\160\x6c\x65\x74\145", "\165\155\x5f\x73\145\x6e\x64\x5f\x72\x65\x67\151\x73\x74\x72\x61\x74\151\x6f\156\137\156\157\164\151\x66\x69\143\141\164\x69\x6f\x6e");
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x75\x6d\x5f\163\x6d\x73\x5f\156\157\x74\x69\x66\151\x63\141\x74\151\x6f\156\137\141\x64\144\x6f\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\101\x6c\x6c\157\167\x73\x20\171\x6f\x75\162\40\x73\151\x74\145\40\164\x6f\40\x73\x65\156\x64\x20\143\x75\x73\164\x6f\155\40\123\x4d\x53\x20\x6e\157\x74\151\x66\151\x63\141\164\x69\x6f\x6e\163\x20\x74\x6f\x20\171\157\x75\x72\x20\x63\x75\x73\164\157\x6d\145\x72\163\x2e" . "\x43\x6c\x69\143\x6b\40\157\x6e\x20\x74\150\x65\x20\x73\x65\x74\164\151\x6e\x67\163\x20\142\x75\x74\x74\x6f\x6e\x20\x74\x6f\x20\164\150\x65\40\x72\x69\147\150\164\x20\x74\157\x20\163\x65\x65\x20\x74\x68\145\x20\154\x69\163\x74\x20\157\146\x20\156\x6f\x74\151\x66\x69\143\141\164\x69\157\156\x73\x20\164\150\141\x74\x20\x67\x6f\x20\157\x75\x74\x2e");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x55\154\x74\x69\x6d\141\x74\145\40\115\145\x6d\x62\x65\x72\x20\x53\x4d\123\x20\x4e\157\164\x69\146\x69\143\141\x74\151\157\x6e");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::ULTIMATEMEMBER_SMS_NOTIFICATION_LINK["\147\165\151\x64\145\114\151\156\153"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::ULTIMATEMEMBER_SMS_NOTIFICATION_LINK["\x76\x69\x64\145\x6f\x4c\x69\156\153"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\144\x64\x6f\156" => "\165\x6d\137\x6e\x6f\164\x69\x66"), $_SERVER["\x52\x45\x51\x55\x45\123\124\137\x55\122\111"]);
    }
}
