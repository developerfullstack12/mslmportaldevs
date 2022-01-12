<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCancelledNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\x64\145\x72\x20\x43\141\x6e\x63\x65\154\154\145\144";
        $this->page = "\167\x63\137\157\x72\x64\x65\x72\x5f\143\x61\x6e\143\145\154\x6c\x65\x64\137\156\157\164\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\122\104\105\122\137\x43\x41\116\103\105\114\114\x45\x44\x5f\x4e\x4f\124\111\106\137\110\105\x41\x44\105\122";
        $this->tooltipBody = "\x4f\122\104\x45\x52\137\103\101\x4e\103\x45\114\x4c\105\104\x5f\116\117\x54\111\106\x5f\102\x4f\x44\x59";
        $this->recipient = "\x63\x75\x73\164\x6f\x6d\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->defaultSmsBodsy = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->availableTags = "\173\x73\151\164\145\55\x6e\141\155\x65\175\x2c\x7b\x6f\162\x64\145\162\55\156\x75\155\x62\x65\x72\175\54\173\x75\x73\145\x72\x6e\x61\x6d\x65\175\x7b\157\162\144\x65\162\55\144\x61\x74\145\x7d";
        $this->pageHeader = mo_("\x4f\x52\104\x45\x52\x20\x43\101\116\103\105\x4c\x4c\105\x44\40\x4e\117\x54\111\106\x49\x43\101\x54\x49\x4f\x4e\40\123\x45\x54\x54\x49\x4e\107\123");
        $this->pageDescription = mo_("\123\x4d\x53\40\156\x6f\164\151\x66\151\x63\141\x74\151\157\156\163\40\x73\x65\x74\164\151\x6e\147\163\40\146\x6f\162\40\x4f\x72\144\x65\x72\40\x43\141\156\x63\x65\x6c\154\x61\x74\x69\x6f\x6e\40\x53\115\123\x20\x73\145\156\164\40\x74\157\x20\x74\x68\x65\x20\x75\x73\x65\x72\x73");
        $this->notificationType = mo_("\103\165\x73\x74\157\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto cH;
        }
        return;
        cH:
        $Qr = $LD["\x6f\x72\144\x65\162\x44\x65\x74\x61\151\x6c\x73"];
        if (!MoUtility::isBlank($Qr)) {
            goto py;
        }
        return;
        py:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\x73\151\x74\145\55\156\141\x6d\x65" => $UP, "\165\163\145\162\x6e\x61\x6d\x65" => $HR, "\x6f\162\x64\x65\x72\x2d\x64\x61\x74\x65" => $MZ, "\x6f\162\144\145\162\55\156\165\x6d\142\145\162" => $Qq);
        $t6 = apply_filters("\x6d\157\x5f\167\x63\137\143\165\x73\164\157\155\145\162\137\157\162\x64\x65\162\137\x63\x61\156\x63\x65\x6c\154\145\x64\x5f\x6e\x6f\164\x69\x66\x5f\163\x74\x72\x69\156\x67\x5f\x72\145\160\x6c\141\143\x65", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto dp;
        }
        return;
        dp:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
