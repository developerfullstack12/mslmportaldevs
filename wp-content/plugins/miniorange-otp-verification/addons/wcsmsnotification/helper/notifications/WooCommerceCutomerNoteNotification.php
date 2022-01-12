<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceCutomerNoteNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x43\x75\163\164\157\155\x65\162\40\116\157\164\145";
        $this->page = "\167\x63\x5f\x63\x75\x73\164\x6f\x6d\x65\x72\137\x6e\157\x74\145\137\156\x6f\x74\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x43\x55\123\124\x4f\x4d\x45\122\137\x4e\117\x54\x45\137\116\x4f\x54\111\x46\137\x48\x45\x41\x44\x45\122";
        $this->tooltipBody = "\103\x55\x53\x54\x4f\115\105\122\x5f\x4e\117\x54\x45\137\116\117\124\x49\x46\137\x42\117\x44\x59";
        $this->recipient = "\x63\x75\x73\164\157\x6d\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->availableTags = "\173\x6f\162\x64\145\x72\55\144\x61\164\145\175\54\173\x6f\x72\144\x65\x72\55\x6e\165\155\x62\145\162\175\x2c\173\165\x73\145\x72\x6e\x61\x6d\145\175\x2c\x7b\163\x69\164\145\x2d\156\141\x6d\145\175";
        $this->pageHeader = mo_("\x43\125\123\124\117\115\x45\122\x20\x4e\x4f\124\105\40\x4e\x4f\124\x49\106\x49\x43\101\124\x49\x4f\x4e\40\x53\x45\x54\124\x49\116\107\x53");
        $this->pageDescription = mo_("\123\x4d\x53\x20\x6e\157\164\x69\146\x69\x63\x61\164\x69\157\156\163\x20\x73\x65\x74\164\151\156\147\x73\x20\146\x6f\162\x20\x43\x75\163\x74\x6f\x6d\145\162\x20\x4e\157\x74\x65\x20\x53\115\123\40\163\145\156\x74\x20\164\x6f\40\x74\x68\145\40\x75\x73\145\x72\163");
        $this->notificationType = mo_("\x43\165\163\164\157\155\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto t6;
        }
        return;
        t6:
        $Qr = $LD["\157\162\x64\x65\x72\x44\x65\164\x61\x69\154\163"];
        if (!MoUtility::isBlank($Qr)) {
            goto vA;
        }
        return;
        vA:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Zu = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\163\x69\x74\145\55\156\141\x6d\x65" => $UP, "\165\x73\x65\x72\x6e\141\155\x65" => $HR, "\x6f\162\x64\145\162\x2d\144\141\x74\145" => $MZ, "\157\x72\x64\x65\x72\55\156\x75\x6d\142\x65\x72" => $Qq);
        $t6 = apply_filters("\155\157\x5f\167\x63\x5f\x63\165\x73\x74\157\155\145\x72\137\x6e\x6f\x74\145\137\x73\x74\x72\x69\156\x67\137\x72\145\160\x6c\141\143\x65", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto ku;
        }
        return;
        ku:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
