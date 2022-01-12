<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderProcessingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x50\162\x6f\143\x65\163\163\151\x6e\x67\40\117\x72\144\145\162";
        $this->page = "\167\x63\x5f\157\162\x64\x65\x72\137\x70\x72\157\x63\145\163\x73\x69\x6e\147\137\156\x6f\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\x52\104\105\x52\x5f\x50\x52\117\x43\x45\123\x53\x49\x4e\x47\x5f\116\x4f\x54\111\106\137\110\x45\x41\x44\105\x52";
        $this->tooltipBody = "\x4f\122\104\x45\122\x5f\x50\x52\x4f\x43\x45\x53\x53\111\x4e\107\x5f\116\117\124\x49\x46\x5f\102\x4f\x44\x59";
        $this->recipient = "\x63\165\163\164\x6f\x6d\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->availableTags = "\x7b\163\151\x74\x65\x2d\x6e\141\x6d\145\x7d\x2c\x7b\157\162\144\145\162\55\156\x75\x6d\x62\145\x72\175\54\x7b\x75\x73\x65\162\x6e\x61\x6d\145\175\173\x6f\162\x64\x65\x72\x2d\x64\x61\164\x65\175";
        $this->pageHeader = mo_("\117\122\x44\105\122\x20\x50\x52\x4f\103\x45\123\x53\111\116\x47\40\x4e\117\x54\111\x46\x49\103\x41\x54\x49\x4f\116\x20\x53\105\x54\124\111\116\x47\123");
        $this->pageDescription = mo_("\123\x4d\x53\x20\x6e\157\x74\151\146\x69\143\141\164\151\157\156\163\x20\163\145\164\164\151\x6e\x67\163\x20\146\157\162\x20\x4f\162\144\145\x72\40\120\x72\x6f\x63\145\x73\x73\x69\156\147\40\x53\x4d\123\x20\x73\145\156\x74\40\x74\157\x20\164\x68\145\40\x75\x73\x65\162\x73");
        $this->notificationType = mo_("\103\x75\x73\x74\157\155\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto QX;
        }
        return;
        QX:
        $Qr = $LD["\x6f\x72\144\x65\x72\104\145\x74\141\151\x6c\x73"];
        if (!MoUtility::isBlank($Qr)) {
            goto KH;
        }
        return;
        KH:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\x73\x69\x74\x65\55\156\x61\x6d\x65" => $UP, "\x75\x73\x65\x72\156\141\x6d\145" => $HR, "\157\162\144\x65\x72\x2d\144\x61\x74\145" => $MZ, "\x6f\162\144\145\x72\55\x6e\165\x6d\x62\x65\x72" => $Qq);
        $t6 = apply_filters("\x6d\157\x5f\x77\143\137\x63\165\163\x74\157\x6d\145\162\137\157\x72\144\145\162\x5f\x70\162\x6f\143\145\163\163\x69\156\x67\x5f\x6e\x6f\x74\x69\146\137\163\164\x72\x69\156\147\137\162\x65\x70\154\x61\x63\145", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto kq;
        }
        return;
        kq:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
