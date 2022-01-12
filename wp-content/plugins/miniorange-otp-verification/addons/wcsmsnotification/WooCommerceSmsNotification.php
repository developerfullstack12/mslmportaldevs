<?php


namespace OTP\Addons\WcSMSNotification;

use OTP\Addons\WcSMSNotification\Handler\WooCommerceNotifications;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\x42\123\x50\101\124\x48")) {
    goto p6;
}
die;
p6:
include "\x5f\x61\x75\164\157\154\x6f\141\144\56\160\x68\x70";
final class WooCommerceSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\141\144\155\151\156\x5f\x65\x6e\161\165\145\x75\145\137\x73\143\162\x69\x70\164\163", array($this, "\155\157\x5f\163\x6d\x73\x5f\156\157\164\x69\146\137\163\x65\164\164\151\156\x67\x73\137\x73\x74\171\154\145"));
        add_action("\x61\x64\x6d\151\156\x5f\145\156\x71\165\x65\x75\x65\137\x73\143\x72\x69\x70\x74\163", array($this, "\155\157\137\163\155\163\137\156\157\164\x69\x66\x5f\x73\x65\x74\164\151\156\x67\163\137\163\143\x72\x69\x70\164"));
        add_action("\155\157\137\157\x74\x70\137\x76\145\162\x69\x66\151\x63\x61\x74\151\x6f\x6e\x5f\x64\145\154\145\x74\x65\137\141\x64\144\x6f\x6e\137\x6f\x70\x74\x69\x6f\156\163", array($this, "\x6d\x6f\137\163\x6d\x73\137\156\x6f\164\x69\146\x5f\x64\145\154\x65\164\x65\137\157\x70\164\151\157\156\x73"));
    }
    function mo_sms_notif_settings_style()
    {
        wp_enqueue_style("\x6d\x6f\x5f\x73\155\163\137\156\x6f\164\151\x66\x5f\x61\144\155\151\156\x5f\163\145\164\x74\x69\156\x67\163\x5f\163\164\x79\x6c\x65", MSN_CSS_URL);
    }
    function mo_sms_notif_settings_script()
    {
        wp_register_script("\x6d\157\x5f\x73\155\x73\137\156\x6f\164\x69\x66\x5f\x61\144\x6d\151\156\137\163\x65\164\164\x69\156\x67\x73\x5f\x73\x63\162\151\x70\x74", MSN_JS_URL, array("\152\x71\x75\145\162\171"));
        wp_localize_script("\x6d\x6f\x5f\x73\x6d\163\x5f\x6e\157\x74\x69\x66\137\x61\144\155\151\x6e\137\163\145\x74\164\151\156\147\163\137\163\x63\x72\151\160\164", "\155\x6f\x63\165\163\x74\157\x6d\155\163\147", array("\163\151\164\145\125\122\x4c" => admin_url()));
        wp_enqueue_script("\155\x6f\137\163\155\x73\137\x6e\x6f\164\151\146\137\x61\144\x6d\x69\156\x5f\x73\145\x74\164\x69\156\147\163\x5f\163\143\x72\151\160\x74");
    }
    function initializeHandlers()
    {
        $D6 = AddOnList::instance();
        $GD = WooCommerceNotifications::instance();
        $D6->add($GD->getAddOnKey(), $GD);
    }
    function initializeHelpers()
    {
        MoWcAddOnMessages::instance();
        WooCommerceNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include MSN_DIR . "\57\x63\x6f\156\164\x72\157\154\x6c\x65\x72\x73\x2f\x6d\141\151\156\x2d\143\157\156\164\162\157\154\154\145\162\56\160\150\160";
    }
    function mo_sms_notif_delete_options()
    {
        delete_site_option("\155\157\x5f\167\143\137\163\x6d\163\137\156\x6f\x74\x69\x66\x69\143\x61\164\x69\x6f\x6e\x5f\163\x65\x74\164\151\156\x67\x73");
    }
}
