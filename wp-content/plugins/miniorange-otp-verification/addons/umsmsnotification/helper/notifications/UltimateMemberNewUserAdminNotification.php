<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewUserAdminNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4e\145\167\x20\101\x63\143\x6f\165\156\x74";
        $this->page = "\x75\x6d\x5f\x6e\145\167\137\x63\165\x73\164\x6f\x6d\x65\x72\x5f\x61\144\x6d\151\x6e\137\156\x6f\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\116\105\x57\x5f\x55\x4d\x5f\103\125\123\124\x4f\115\x45\x52\x5f\x4e\117\x54\111\106\137\110\x45\101\104\x45\122";
        $this->tooltipBody = "\x4e\x45\127\137\x55\x4d\x5f\x43\125\x53\124\x4f\115\105\x52\137\x41\104\115\111\116\137\116\x4f\124\111\x46\137\x42\x4f\104\131";
        $this->recipient = UltimateMemberSMSNotificationUtility::getAdminPhoneNumber();
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->availableTags = "\173\163\151\x74\x65\x2d\156\141\x6d\x65\x7d\x2c\173\165\x73\x65\x72\x6e\x61\x6d\x65\x7d\x2c\173\x61\x63\x63\x6f\165\x6e\x74\x70\141\147\145\55\x75\x72\154\175\x2c\x7b\145\x6d\141\151\x6c\175\x2c\x7b\146\x69\x72\x74\x6e\141\x6d\145\x7d\x2c\x7b\x6c\141\x73\164\x6e\141\x6d\145\175";
        $this->pageHeader = mo_("\116\105\x57\40\x41\x43\x43\x4f\125\x4e\124\40\x41\104\x4d\111\116\x20\x4e\117\124\111\x46\111\x43\101\x54\111\117\x4e\40\123\x45\x54\x54\111\x4e\x47\x53");
        $this->pageDescription = mo_("\123\x4d\x53\x20\156\157\164\151\146\x69\x63\x61\164\x69\157\x6e\163\40\163\x65\164\164\x69\156\147\x73\40\146\x6f\162\x20\x4e\145\167\40\101\x63\143\x6f\x75\156\x74\x20\143\162\x65\x61\164\x69\x6f\x6e\x20\123\115\123\x20\x73\145\156\164\40\164\x6f\x20\164\x68\x65\x20\141\x64\155\x69\156\163");
        $this->notificationType = mo_("\x41\144\155\151\x6e\151\163\x74\x72\x61\x74\x6f\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto yr;
        }
        return;
        yr:
        $Xu = maybe_unserialize($this->recipient);
        $HR = um_user("\165\163\x65\x72\x5f\154\157\147\x69\x6e");
        $RK = um_user_profile_url();
        $xk = um_user("\x66\151\162\163\164\x5f\x6e\x61\155\x65");
        $Rj = um_user("\154\141\163\164\x5f\156\x61\155\x65");
        $h4 = um_user("\x75\163\x65\162\137\x65\x6d\x61\x69\x6c");
        $t6 = array("\x73\x69\x74\x65\55\x6e\141\155\145" => get_bloginfo(), "\x75\163\x65\162\x6e\141\x6d\x65" => $HR, "\x61\143\x63\x6f\165\x6e\164\x70\141\147\145\x2d\165\x72\154" => $RK, "\x66\x69\x72\163\x74\x6e\x61\x6d\x65" => $xk, "\x6c\141\x73\x74\x6e\x61\x6d\x65" => $Rj, "\145\x6d\x61\x69\154" => $h4);
        $t6 = apply_filters("\x6d\157\137\165\155\x5f\156\x65\167\x5f\143\165\163\x74\157\x6d\145\162\137\x61\144\155\x69\156\x5f\x6e\157\164\x69\146\137\163\x74\x72\x69\156\147\x5f\x72\x65\x70\154\x61\x63\145", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Xu)) {
            goto Zh;
        }
        return;
        Zh:
        foreach ($Xu as $Zu) {
            MoUtility::send_phone_notif($Zu, $p6);
            TM:
        }
        VN:
    }
}
