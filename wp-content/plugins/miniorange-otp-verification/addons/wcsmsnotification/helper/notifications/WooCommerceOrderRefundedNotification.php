<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderRefundedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\144\x65\x72\x20\x52\x65\x66\165\156\144\x65\144";
        $this->page = "\x77\143\137\x6f\x72\x64\x65\162\137\x72\145\146\165\156\144\145\144\137\x6e\157\164\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\122\x44\x45\122\137\x52\105\106\x55\x4e\x44\105\104\137\x4e\x4f\x54\x49\106\x5f\110\105\x41\x44\105\122";
        $this->tooltipBody = "\x4f\x52\104\x45\x52\x5f\122\x45\x55\x4e\x44\105\x44\137\116\x4f\124\111\106\137\102\117\104\131";
        $this->recipient = "\x63\165\163\164\x6f\155\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->availableTags = "\173\163\x69\164\145\x2d\x6e\141\x6d\x65\x7d\54\173\x6f\x72\144\x65\x72\55\156\x75\155\142\145\x72\175\54\x7b\x75\163\x65\x72\156\x61\x6d\x65\175\x7b\157\162\144\145\162\55\x64\x61\164\145\x7d";
        $this->pageHeader = mo_("\117\x52\x44\x45\122\x20\x52\105\106\x55\116\x44\105\x44\x20\116\117\x54\x49\x46\x49\103\101\x54\x49\x4f\x4e\x20\x53\x45\x54\124\x49\116\107\123");
        $this->pageDescription = mo_("\123\x4d\123\x20\x6e\157\x74\151\x66\x69\x63\x61\x74\151\x6f\156\x73\40\x73\145\x74\x74\x69\x6e\x67\x73\x20\x66\157\162\x20\x4f\162\144\145\162\x20\x52\145\146\x75\156\x64\x65\144\x20\x53\115\123\x20\x73\x65\156\164\x20\x74\157\40\164\x68\145\40\165\163\145\162\163");
        $this->notificationType = mo_("\103\165\163\x74\x6f\155\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto BT;
        }
        return;
        BT:
        $Qr = $LD["\x6f\162\144\x65\x72\104\x65\164\141\x69\x6c\163"];
        if (!MoUtility::isBlank($Qr)) {
            goto R0;
        }
        return;
        R0:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\x73\x69\x74\145\55\156\x61\155\145" => $UP, "\165\x73\145\162\156\141\155\x65" => $HR, "\157\162\x64\145\162\55\144\x61\x74\145" => $MZ, "\x6f\x72\x64\145\x72\x2d\x6e\x75\155\142\145\x72" => $Qq);
        $t6 = apply_filters("\x6d\157\137\x77\143\137\x63\165\x73\164\157\x6d\145\162\137\x6f\162\x64\145\162\x5f\162\x65\x66\x75\x6e\x64\x65\144\x5f\156\x6f\164\x69\146\137\x73\x74\x72\x69\156\147\x5f\162\x65\x70\154\141\x63\x65", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto YR;
        }
        return;
        YR:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
