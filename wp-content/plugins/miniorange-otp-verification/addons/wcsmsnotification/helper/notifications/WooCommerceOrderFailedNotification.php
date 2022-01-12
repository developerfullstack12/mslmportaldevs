<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderFailedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\162\144\x65\162\x20\x46\141\x69\x6c\x65\144";
        $this->page = "\x77\143\137\x6f\x72\x64\x65\x72\137\146\141\151\154\x65\x64\137\x6e\x6f\164\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\x52\x44\x45\x52\x5f\x46\x41\111\114\105\104\x5f\x4e\x4f\x54\111\106\137\110\x45\101\x44\x45\x52";
        $this->tooltipBody = "\x4f\122\x44\105\122\137\106\x41\x49\x4c\105\x44\x5f\116\117\124\x49\x46\137\x42\117\104\x59";
        $this->recipient = "\143\x75\163\164\x6f\155\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->availableTags = "\x7b\163\151\164\x65\55\156\x61\155\145\175\x2c\173\x6f\x72\x64\x65\x72\55\x6e\x75\155\x62\x65\x72\175\x2c\173\x75\163\145\162\x6e\141\x6d\x65\175\173\157\162\144\145\x72\55\144\x61\164\x65\175";
        $this->pageHeader = mo_("\117\x52\x44\x45\122\x20\x46\x41\111\114\x45\x44\40\116\117\x54\x49\x46\111\103\x41\x54\111\117\116\x20\123\105\124\x54\x49\x4e\107\123");
        $this->pageDescription = mo_("\x53\115\123\x20\x6e\157\164\x69\x66\x69\x63\141\164\151\x6f\x6e\x73\x20\x73\x65\x74\x74\151\156\147\163\40\x66\157\162\40\x4f\x72\x64\145\x72\x20\146\141\151\154\x75\162\x65\40\x53\x4d\x53\x20\x73\x65\x6e\x74\40\164\x6f\40\164\150\x65\x20\165\163\x65\162\163");
        $this->notificationType = mo_("\x43\x75\x73\x74\157\x6d\x65\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto s_;
        }
        return;
        s_:
        $Qr = $LD["\x6f\x72\x64\145\162\x44\145\x74\141\151\x6c\163"];
        if (!MoUtility::isBlank($Qr)) {
            goto PC;
        }
        return;
        PC:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\x73\x69\164\x65\x2d\x6e\x61\x6d\145" => $UP, "\x75\163\x65\162\156\x61\155\x65" => $HR, "\x6f\x72\144\x65\x72\x2d\x64\141\x74\145" => $MZ, "\x6f\162\x64\x65\x72\x2d\156\165\155\142\x65\162" => $Qq);
        $t6 = apply_filters("\155\157\137\x77\x63\x5f\143\165\x73\164\x6f\155\x65\162\x5f\x6f\x72\x64\145\x72\137\146\x61\151\154\x65\x64\x5f\156\157\164\151\146\137\x73\164\x72\x69\156\147\x5f\162\x65\x70\154\141\143\x65", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto g1;
        }
        return;
        g1:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
