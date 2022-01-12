<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\116\145\167\x20\x41\x63\x63\157\165\156\164";
        $this->page = "\167\143\x5f\156\x65\167\x5f\x63\x75\x73\x74\x6f\x6d\x65\x72\x5f\156\x6f\164\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\x45\127\137\103\x55\x53\x54\x4f\x4d\105\122\137\x4e\117\x54\x49\x46\x5f\x48\105\x41\x44\105\x52";
        $this->tooltipBody = "\x4e\x45\127\x5f\x43\125\x53\x54\117\115\x45\122\x5f\x4e\117\124\111\x46\137\x42\117\104\x59";
        $this->recipient = "\143\165\163\164\x6f\x6d\x65\162";
        $this->smsBody = get_wc_option("\x77\157\x6f\x63\x6f\155\155\x65\x72\143\145\x5f\162\145\x67\x69\163\x74\x72\x61\x74\151\157\156\x5f\x67\145\156\x65\x72\141\x74\x65\x5f\160\141\x73\163\x77\x6f\x72\x64", '') === "\x79\145\163" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->defaultSmsBody = get_wc_option("\167\157\157\x63\x6f\x6d\155\x65\162\x63\x65\x5f\162\145\x67\151\x73\x74\162\x61\x74\x69\157\156\x5f\147\x65\x6e\145\x72\x61\164\145\137\x70\141\x73\163\x77\x6f\162\x64", '') === "\x79\x65\163" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->availableTags = "\x7b\x73\151\164\x65\55\156\141\155\145\175\x2c\x7b\165\x73\x65\162\156\x61\x6d\145\175\54\173\x61\x63\143\157\x75\156\164\x70\141\147\145\55\x75\x72\x6c\175";
        $this->pageHeader = mo_("\x4e\105\127\x20\x41\103\103\x4f\x55\116\x54\x20\116\x4f\x54\111\106\x49\103\101\124\x49\x4f\x4e\40\x53\105\124\x54\111\x4e\x47\x53");
        $this->pageDescription = mo_("\x53\x4d\x53\40\x6e\157\x74\151\146\151\x63\x61\x74\151\x6f\x6e\163\40\163\x65\x74\x74\151\x6e\147\x73\40\146\x6f\162\40\116\x65\x77\x20\x41\143\143\157\165\x6e\x74\40\x63\162\x65\x61\x74\x69\x6f\156\40\x53\115\x53\x20\163\145\156\164\x20\164\x6f\40\x74\x68\x65\x20\x75\x73\145\x72\163");
        $this->notificationType = mo_("\103\x75\x73\164\x6f\x6d\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $LD)
    {
        if ($this->isEnabled) {
            goto G2;
        }
        return;
        G2:
        $yx = $LD["\143\x75\x73\164\x6f\x6d\x65\x72\137\151\144"];
        $ba = $LD["\156\145\x77\x5f\x63\165\163\164\x6f\155\x65\162\x5f\144\x61\x74\x61"];
        $UP = get_bloginfo();
        $HR = get_userdata($yx)->user_login;
        $Zu = get_user_meta($yx, "\142\x69\x6c\154\151\156\147\137\160\150\157\156\145", TRUE);
        $AI = MoUtility::sanitizeCheck("\142\x69\154\x6c\x69\156\147\137\x70\150\157\156\x65", $_POST);
        $Zu = MoUtility::isBlank($Zu) && $AI ? $AI : $Zu;
        $cB = wc_get_page_permalink("\155\x79\141\x63\143\157\x75\156\x74");
        $t6 = array("\163\151\164\145\x2d\x6e\141\x6d\x65" => get_bloginfo(), "\x75\163\145\x72\x6e\141\x6d\x65" => $HR, "\x61\143\x63\157\x75\156\x74\160\x61\x67\145\x2d\x75\162\154" => $cB);
        $t6 = apply_filters("\x6d\x6f\137\x77\143\137\156\x65\x77\137\143\165\163\x74\157\155\145\x72\x5f\156\x6f\164\151\146\x5f\x73\x74\162\x69\x6e\147\137\162\145\x70\154\x61\143\145", $t6);
        $p6 = MoUtility::replaceString($t6, $this->smsBody);
        if (!MoUtility::isBlank($Zu)) {
            goto tv;
        }
        return;
        tv:
        MoUtility::send_phone_notif($Zu, $p6);
    }
}
