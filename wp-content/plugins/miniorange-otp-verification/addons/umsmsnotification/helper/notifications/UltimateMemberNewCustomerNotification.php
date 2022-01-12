<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4e\x65\167\40\x41\x63\x63\x6f\165\x6e\164";
        $this->page = "\x75\x6d\137\156\145\x77\x5f\x63\x75\x73\164\x6f\155\x65\x72\137\156\157\x74\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\105\127\x5f\x55\115\x5f\x43\125\x53\124\117\x4d\105\122\137\116\x4f\124\x49\106\137\110\x45\x41\104\x45\x52";
        $this->tooltipBody = "\116\105\x57\x5f\125\115\137\x43\x55\x53\x54\117\x4d\x45\122\137\116\117\x54\x49\106\x5f\102\x4f\x44\x59";
        $this->recipient = "\x6d\x6f\x62\151\154\x65\x5f\156\165\x6d\x62\145\x72";
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->availableTags = "\173\163\x69\164\x65\55\156\x61\155\145\175\54\173\x75\163\145\162\156\x61\x6d\145\x7d\54\173\141\x63\x63\x6f\165\156\164\160\141\147\145\x2d\x75\162\154\x7d\x2c\x7b\x6c\x6f\x67\151\156\55\x75\162\x6c\175\54\x7b\x65\155\x61\x69\x6c\x7d\54\x7b\x66\151\x72\164\156\x61\155\x65\x7d\54\173\154\x61\163\x74\x6e\x61\x6d\145\x7d";
        $this->pageHeader = mo_("\116\x45\127\40\101\x43\x43\117\x55\116\124\x20\116\117\124\x49\x46\111\x43\x41\124\x49\117\x4e\40\x53\105\124\x54\x49\x4e\x47\123");
        $this->pageDescription = mo_("\x53\x4d\123\x20\x6e\157\x74\x69\x66\151\143\x61\x74\151\157\x6e\163\40\163\x65\x74\x74\x69\x6e\147\163\x20\x66\157\x72\40\x4e\x65\167\40\101\143\x63\x6f\x75\156\x74\x20\x63\x72\x65\x61\164\x69\157\156\40\123\x4d\123\40\163\x65\x6e\164\x20\164\x6f\40\164\150\x65\x20\165\x73\x65\162\163");
        $this->notificationType = mo_("\103\165\163\164\157\x6d\x65\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto zV;
        }
        return;
        zV:
        $HR = um_user("\165\x73\145\162\x5f\x6c\157\x67\x69\x6e");
        $Zu = $LD[$this->recipient];
        $RK = um_user_profile_url();
        $pg = um_get_core_page("\x6c\157\147\151\156");
        $xk = um_user("\x66\x69\x72\x73\x74\x5f\x6e\141\x6d\x65");
        $Rj = um_user("\154\x61\163\x74\x5f\156\x61\155\x65");
        $h4 = um_user("\165\x73\x65\x72\137\x65\x6d\x61\151\x6c");
        $t6 = array("\163\151\x74\x65\x2d\156\x61\155\x65" => get_bloginfo(), "\165\x73\145\162\156\x61\155\x65" => $HR, "\141\143\x63\157\165\156\164\x70\141\x67\x65\55\x75\x72\154" => $RK, "\x6c\157\147\x69\x6e\x2d\165\x72\154" => $pg, "\146\x69\x72\163\164\x6e\x61\x6d\145" => $xk, "\154\x61\163\x74\156\141\x6d\145" => $Rj, "\x65\155\141\x69\x6c" => $h4);
        $t6 = apply_filters("\155\x6f\x5f\x75\155\x5f\156\145\x77\137\143\165\163\164\x6f\x6d\x65\162\x5f\x6e\x6f\164\x69\x66\137\x73\x74\162\151\156\x67\x5f\x72\145\160\x6c\x61\143\145", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto lS;
        }
        return;
        lS:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
