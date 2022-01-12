<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceAdminOrderstatusNotification extends SMSNotification
{
    public static $instance;
    public static $statuses;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\162\x64\145\162\x20\123\x74\x61\164\x75\163";
        $this->page = "\167\143\x5f\141\x64\x6d\x69\x6e\x5f\157\x72\144\x65\162\137\163\x74\x61\x74\165\163\x5f\156\x6f\164\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\105\x57\x5f\117\x52\x44\105\x52\137\x4e\x4f\124\111\106\137\x48\x45\x41\x44\105\x52";
        $this->tooltipBody = "\x4e\105\x57\x5f\117\122\x44\105\x52\137\x4e\x4f\124\111\106\x5f\x42\x4f\104\x59";
        $this->recipient = MoWcAddOnUtility::getAdminPhoneNumber();
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->availableTags = "\173\x73\151\164\x65\55\x6e\141\x6d\x65\175\x2c\173\x6f\162\x64\145\162\55\x6e\x75\x6d\x62\145\x72\175\54\173\157\162\x64\145\x72\55\x73\x74\x61\x74\x75\163\175\54\173\165\163\x65\x72\x6e\141\x6d\x65\x7d\x7b\x6f\162\x64\x65\x72\55\x64\x61\164\x65\175";
        $this->pageHeader = mo_("\x4f\122\x44\105\122\x20\101\104\115\111\116\40\x53\x54\101\124\x55\123\40\116\117\124\x49\106\x49\x43\101\124\111\x4f\x4e\x20\x53\x45\124\124\111\116\x47\x53");
        $this->pageDescription = mo_("\x53\115\x53\40\x6e\157\164\151\146\151\143\141\x74\x69\157\156\x73\40\163\145\x74\164\x69\x6e\147\x73\x20\146\157\162\x20\x4f\162\x64\x65\162\40\123\x74\141\x74\165\x73\40\x53\x4d\x53\x20\x73\x65\156\x74\x20\x74\157\x20\164\x68\x65\x20\x61\x64\155\x69\x6e\x73");
        $this->notificationType = mo_("\101\144\x6d\x69\x6e\151\x73\x74\x72\141\x74\157\162");
        self::$instance = $this;
        self::$statuses = WcOrderStatus::getAllStatus();
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto i2;
        }
        return;
        i2:
        $Qr = $LD["\157\162\144\x65\x72\x44\145\164\x61\151\154\x73"];
        $pw = $LD["\x6e\145\167\x5f\163\164\x61\x74\165\163"];
        if (!MoUtility::isBlank($Qr)) {
            goto T7;
        }
        return;
        T7:
        if (in_array($pw, self::$statuses)) {
            goto UZ;
        }
        return;
        UZ:
        $ns = get_userdata($Qr->get_customer_id());
        $UP = get_bloginfo();
        $HR = MoUtility::isBlank($ns) ? '' : $ns->user_login;
        $Xu = maybe_unserialize($this->recipient);
        $MZ = $Qr->get_date_created()->date_i18n();
        $Qq = $Qr->get_order_number();
        $t6 = array("\163\151\x74\145\x2d\156\x61\155\145" => $UP, "\165\163\145\162\156\x61\155\145" => $HR, "\x6f\162\144\145\162\x2d\144\x61\x74\x65" => $MZ, "\x6f\162\144\145\x72\55\156\165\155\142\145\162" => $Qq, "\x6f\x72\144\x65\x72\x2d\x73\164\141\x74\165\x73" => $pw);
        $t6 = apply_filters("\155\x6f\x5f\167\x63\137\x61\144\155\151\x6e\137\x6f\162\x64\145\162\137\156\x6f\x74\151\146\x5f\163\x74\162\x69\156\x67\x5f\x72\145\160\154\x61\x63\x65", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Xu)) {
            goto Cz;
        }
        return;
        Cz:
        foreach ($Xu as $Zu) {
            MoUtility::send_phone_notif($Zu, $p6);
            rp:
        }
        A9:
    }
}
