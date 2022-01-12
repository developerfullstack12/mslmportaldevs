<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCompletedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\144\x65\x72\x20\103\x6f\155\x70\154\x65\x74\x65\x64";
        $this->page = "\x77\x63\137\x6f\x72\144\x65\162\137\143\x6f\x6d\160\154\x65\164\x65\x64\137\x6e\x6f\164\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\x52\104\105\122\137\x43\x41\116\x43\x45\x4c\x4c\105\x44\137\x4e\117\124\111\106\137\x48\105\101\x44\105\x52";
        $this->tooltipBody = "\117\122\x44\x45\122\x5f\103\101\116\103\x45\114\114\105\104\137\x4e\x4f\124\x49\106\x5f\x42\117\x44\x59";
        $this->recipient = "\x63\165\163\164\x6f\x6d\x65\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->availableTags = "\x7b\x73\151\x74\x65\x2d\x6e\x61\x6d\x65\175\54\173\157\162\144\145\x72\55\x6e\165\155\x62\145\x72\x7d\54\x7b\165\163\145\162\x6e\141\x6d\145\x7d\x7b\x6f\162\144\145\x72\x2d\x64\141\164\x65\x7d";
        $this->pageHeader = mo_("\117\x52\x44\105\x52\40\103\x4f\115\x50\114\105\124\x45\104\40\116\x4f\x54\x49\106\x49\103\101\x54\111\x4f\116\40\123\105\124\124\111\x4e\x47\123");
        $this->pageDescription = mo_("\x53\x4d\x53\x20\x6e\157\164\x69\x66\151\x63\x61\x74\x69\x6f\x6e\x73\x20\x73\145\x74\164\151\156\x67\163\x20\146\157\x72\x20\117\162\144\x65\162\40\103\157\155\160\x6c\145\x74\151\x6f\156\x20\x53\x4d\123\x20\x73\145\156\x74\x20\164\157\x20\164\150\x65\x20\165\163\145\x72\163");
        $this->notificationType = mo_("\x43\165\x73\x74\x6f\155\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto Vy;
        }
        return;
        Vy:
        $Qr = $LD["\x6f\x72\x64\x65\162\104\145\x74\141\151\x6c\x73"];
        if (!MoUtility::isBlank($Qr)) {
            goto vB;
        }
        return;
        vB:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\163\151\x74\145\x2d\156\141\155\145" => $UP, "\x75\x73\x65\x72\x6e\x61\155\145" => $HR, "\x6f\162\x64\145\x72\x2d\x64\x61\x74\145" => $MZ, "\157\162\x64\x65\162\x2d\x6e\x75\155\x62\145\162" => $Qq);
        $t6 = apply_filters("\x6d\157\x5f\167\143\x5f\143\165\163\x74\x6f\155\145\162\x5f\x6f\x72\144\145\162\137\143\157\x6d\x70\x6c\x65\x74\x65\144\x5f\156\157\x74\151\146\x5f\163\164\162\151\x6e\147\x5f\162\145\x70\x6c\x61\x63\145", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto kr;
        }
        return;
        kr:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
