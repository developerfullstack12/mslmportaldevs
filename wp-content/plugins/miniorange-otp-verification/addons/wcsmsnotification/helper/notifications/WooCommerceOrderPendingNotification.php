<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderPendingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\x64\x65\x72\x20\x50\145\156\144\x69\156\147\x20\120\x61\x79\x6d\145\x6e\164";
        $this->page = "\x77\x63\137\157\162\x64\x65\162\137\x70\145\156\144\151\156\147\x5f\x6e\157\164\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\x52\x44\x45\x52\x5f\x50\x45\116\104\x49\x4e\x47\137\x4e\x4f\124\x49\x46\x5f\x48\105\x41\x44\x45\x52";
        $this->tooltipBody = "\x4f\x52\104\105\122\x5f\120\x45\116\104\x49\116\107\137\116\117\124\111\106\137\102\117\x44\131";
        $this->recipient = "\143\x75\x73\164\x6f\x6d\x65\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->availableTags = "\x7b\x73\x69\164\x65\55\x6e\x61\x6d\x65\x7d\54\173\x6f\162\x64\x65\162\x2d\156\165\155\142\x65\x72\175\x2c\173\x75\163\145\162\x6e\141\x6d\145\175\x7b\157\x72\144\x65\x72\55\x64\x61\x74\145\x7d";
        $this->pageHeader = mo_("\117\x52\104\x45\122\40\x50\x45\x4e\x44\111\116\107\40\120\101\131\115\x45\116\x54\40\x4e\x4f\x54\x49\106\111\x43\x41\x54\111\117\116\x20\123\x45\124\x54\x49\x4e\x47\x53");
        $this->pageDescription = mo_("\123\x4d\x53\40\x6e\157\164\x69\146\x69\143\x61\x74\151\157\x6e\x73\x20\x73\x65\x74\164\x69\156\x67\163\40\146\x6f\162\x20\117\x72\144\x65\162\40\120\x65\156\x64\151\x6e\147\40\x50\141\x79\x6d\x65\156\x74\40\x53\x4d\123\x20\163\145\x6e\x74\40\164\x6f\x20\x74\150\x65\x20\x75\163\145\162\163");
        $this->notificationType = mo_("\103\x75\163\164\x6f\x6d\x65\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto Ut;
        }
        return;
        Ut:
        $Qr = $LD["\x6f\162\144\x65\162\x44\x65\x74\141\x69\x6c\x73"];
        if (!MoUtility::isBlank($Qr)) {
            goto wr;
        }
        return;
        wr:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\163\151\164\145\55\x6e\x61\155\145" => $UP, "\x75\x73\x65\162\156\x61\x6d\x65" => $HR, "\157\x72\x64\x65\162\x2d\x64\x61\164\x65" => $MZ, "\x6f\x72\x64\145\x72\x2d\x6e\165\x6d\142\x65\x72" => $Qq);
        $t6 = apply_filters("\x6d\x6f\x5f\167\x63\137\x63\x75\x73\164\x6f\x6d\145\x72\x5f\157\x72\144\145\x72\137\160\145\x6e\x64\151\x6e\147\137\x6e\157\x74\x69\146\137\x73\x74\x72\x69\x6e\x67\137\x72\145\x70\x6c\141\143\145", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto wN;
        }
        return;
        wN:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
