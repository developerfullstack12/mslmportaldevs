<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderOnHoldNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\162\144\x65\x72\40\157\156\x2d\150\x6f\154\x64";
        $this->page = "\167\143\x5f\x6f\x72\144\145\x72\137\157\156\x5f\150\x6f\154\144\x5f\x6e\157\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\x52\x44\105\122\137\117\116\x5f\x48\117\x4c\x44\137\x4e\117\x54\111\x46\137\110\x45\x41\104\x45\122";
        $this->tooltipBody = "\x4f\122\104\105\122\137\x4f\x4e\x5f\x48\117\x4c\x44\x5f\116\x4f\124\x49\106\137\x42\117\104\x59";
        $this->recipient = "\x63\165\x73\x74\157\155\x65\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->availableTags = "\x7b\163\x69\x74\x65\55\x6e\141\x6d\145\175\x2c\173\157\x72\144\x65\162\x2d\x6e\165\155\142\145\162\175\54\x7b\165\x73\x65\x72\156\141\x6d\145\x7d\x7b\157\162\144\x65\x72\55\x64\141\x74\x65\175";
        $this->pageHeader = mo_("\x4f\x52\104\x45\122\x20\117\116\55\x48\x4f\114\x44\x20\116\x4f\x54\111\x46\x49\103\101\x54\111\117\x4e\40\x53\x45\124\124\111\x4e\107\x53");
        $this->pageDescription = mo_("\x53\115\x53\40\x6e\157\164\x69\x66\x69\143\x61\x74\151\x6f\x6e\163\40\163\145\x74\164\x69\156\147\163\x20\x66\157\162\40\x4f\162\x64\145\162\x20\x6f\156\55\150\157\x6c\x64\x20\123\x4d\x53\40\163\145\x6e\x74\x20\x74\157\x20\x74\150\x65\40\x75\x73\x65\x72\163");
        $this->notificationType = mo_("\x43\165\163\x74\x6f\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto On;
        }
        return;
        On:
        $Qr = $LD["\x6f\162\x64\x65\x72\x44\145\x74\x61\x69\x6c\x73"];
        if (!MoUtility::isBlank($Qr)) {
            goto H_;
        }
        return;
        H_:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\x73\151\164\145\x2d\156\x61\x6d\145" => $UP, "\165\163\x65\162\x6e\141\x6d\x65" => $HR, "\157\162\144\145\162\55\x64\x61\x74\x65" => $MZ, "\157\x72\144\145\162\x2d\x6e\x75\155\x62\145\x72" => $Qq);
        $t6 = apply_filters("\x6d\157\137\x77\x63\137\143\x75\163\164\x6f\155\145\162\137\157\x72\x64\x65\162\137\x6f\x6e\150\157\x6c\x64\137\x6e\x6f\x74\151\146\137\163\164\162\x69\x6e\147\x5f\162\x65\160\x6c\x61\143\x65", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto LM;
        }
        return;
        LM:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
