<?php


namespace OTP\Addons\UmSMSNotification;

use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\x42\x53\x50\x41\124\x48")) {
    goto zt;
}
die;
zt:
include "\137\x61\x75\164\x6f\x6c\x6f\x61\x64\56\x70\x68\x70";
final class UltimateMemberSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\141\144\x6d\151\156\137\145\156\161\x75\145\x75\145\137\x73\x63\x72\151\160\164\x73", array($this, "\165\x6d\137\163\155\163\x5f\x6e\157\x74\151\146\137\x73\145\164\164\151\156\147\163\137\163\164\x79\154\x65"));
        add_action("\155\157\x5f\x6f\x74\x70\137\x76\145\x72\151\146\x69\143\x61\x74\151\157\156\137\x64\x65\154\145\x74\145\x5f\x61\x64\x64\157\156\137\x6f\160\x74\151\x6f\156\x73", array($this, "\x75\155\x5f\x73\x6d\x73\137\156\157\164\151\x66\x5f\144\x65\154\145\x74\x65\137\157\160\164\151\x6f\156\x73"));
    }
    function um_sms_notif_settings_style()
    {
        wp_enqueue_style("\165\155\x5f\x73\155\163\137\156\x6f\164\x69\146\x5f\141\x64\155\151\156\137\x73\145\x74\x74\x69\156\x67\163\137\x73\164\171\x6c\145", UMSN_CSS_URL);
    }
    function initializeHandlers()
    {
        $D6 = AddOnList::instance();
        $GD = UltimateMemberSMSNotificationsHandler::instance();
        $D6->add($GD->getAddOnKey(), $GD);
    }
    function initializeHelpers()
    {
        UltimateMemberSMSNotificationMessages::instance();
        UltimateMemberNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include UMSN_DIR . "\57\x63\x6f\156\x74\162\157\x6c\154\x65\162\163\x2f\x6d\x61\x69\x6e\55\143\157\x6e\164\162\157\154\154\x65\x72\x2e\x70\x68\160";
    }
    function um_sms_notif_delete_options()
    {
        delete_site_option("\x6d\157\137\165\155\137\x73\x6d\163\137\x6e\157\164\151\146\151\x63\x61\164\151\x6f\x6e\x5f\x73\145\x74\x74\151\156\147\x73");
    }
}
