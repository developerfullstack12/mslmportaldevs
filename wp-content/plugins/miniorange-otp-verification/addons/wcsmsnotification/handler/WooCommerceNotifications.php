<?php


namespace OTP\Addons\WcSMSNotification\Handler;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Helper\MoOTPDocs;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\SMSNotification;
use OTP\Traits\Instance;
use WC_Emails;
use WC_Order;
class WooCommerceNotifications extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto Tw;
        }
        return;
        Tw:
        $this->notificationSettings = get_wc_option("\156\x6f\x74\x69\x66\151\143\141\164\x69\157\x6e\x5f\163\145\x74\164\151\x6e\147\x73") ? get_wc_option("\x6e\x6f\x74\151\146\x69\143\141\x74\151\x6f\x6e\137\163\145\x74\x74\x69\x6e\147\163") : WooCommerceNotificationsList::instance();
        add_action("\x77\157\157\143\157\x6d\155\145\x72\x63\145\x5f\x63\x72\145\141\x74\x65\144\x5f\143\x75\x73\164\x6f\x6d\x65\162\x5f\156\x6f\164\151\x66\151\x63\141\164\x69\157\x6e", array($this, "\x6d\x6f\137\163\145\156\144\x5f\156\145\x77\137\x63\x75\x73\164\157\155\145\162\x5f\163\x6d\163\x5f\x6e\157\164\151\146"), 1, 3);
        add_action("\x77\157\157\143\157\155\x6d\x65\162\x63\145\x5f\x6e\145\167\137\143\165\x73\x74\x6f\155\145\x72\137\156\x6f\x74\x65\137\156\157\x74\151\x66\x69\x63\141\x74\x69\157\x6e", array($this, "\155\x6f\x5f\x73\x65\x6e\x64\x5f\156\x65\x77\x5f\143\165\x73\164\x6f\x6d\145\x72\137\163\155\163\137\156\157\x74\x65"), 1, 1);
        add_action("\167\157\157\143\157\155\155\x65\162\x63\145\x5f\x6f\x72\144\145\x72\x5f\163\164\141\164\x75\163\137\143\150\141\x6e\147\145\x64", array($this, "\x6d\157\x5f\163\x65\156\x64\x5f\141\x64\x6d\x69\156\137\157\162\x64\145\162\137\x73\155\x73\x5f\x6e\x6f\x74\x69\146"), 1, 3);
        add_action("\167\x6f\157\x63\x6f\x6d\x6d\x65\162\143\145\137\x6f\x72\x64\145\162\137\163\164\x61\x74\x75\x73\x5f\x63\150\141\156\147\145\x64", array($this, "\x6d\x6f\137\143\165\163\x74\x6f\x6d\x65\162\137\157\x72\x64\145\162\x5f\150\157\x6c\144\137\x73\155\x73\137\156\x6f\x74\x69\146"), 1, 3);
        add_action("\141\144\x64\137\x6d\x65\164\x61\x5f\142\157\x78\x65\163", array($this, "\x61\x64\144\x5f\143\165\x73\164\x6f\155\x5f\155\x73\147\x5f\155\x65\164\141\137\142\x6f\x78"), 1);
        add_action("\141\x64\155\151\x6e\137\151\x6e\x69\x74", array($this, "\x5f\150\141\156\144\154\145\x5f\141\144\155\151\156\137\x61\143\x74\x69\157\156\x73"));
    }
    function _handle_admin_actions()
    {
        if (current_user_can("\x6d\141\x6e\x61\147\x65\x5f\x6f\x70\164\x69\157\156\x73")) {
            goto lj;
        }
        return;
        lj:
        if (!(array_key_exists("\x6f\160\x74\151\157\156", $_GET) && $_GET["\157\160\x74\x69\x6f\156"] == "\x6d\x6f\137\163\145\156\x64\137\x6f\162\x64\145\162\137\143\165\163\x74\157\155\x5f\155\x73\147")) {
            goto Wu;
        }
        $this->_send_custom_order_msg($_POST);
        Wu:
    }
    function mo_send_new_customer_sms_notif($yx, $ep = array(), $Br = false)
    {
        $this->notificationSettings->getWcNewCustomerNotif()->sendSMS(array("\143\x75\163\x74\157\x6d\x65\x72\137\151\x64" => $yx, "\156\145\167\x5f\143\165\x73\x74\x6f\x6d\145\x72\x5f\x64\x61\x74\141" => $ep, "\160\x61\x73\163\167\157\162\144\137\x67\x65\x6e\145\x72\x61\x74\145\x64" => $Br));
    }
    function mo_send_new_customer_sms_note($LD)
    {
        $this->notificationSettings->getWcCustomerNoteNotif()->sendSMS(array("\157\162\x64\x65\x72\104\x65\164\141\x69\x6c\163" => wc_get_order($LD["\157\x72\144\145\x72\x5f\x69\x64"])));
    }
    function mo_send_admin_order_sms_notif($oJ, $J2, $pw)
    {
        $z3 = new WC_Order($oJ);
        if (is_a($z3, "\x57\x43\x5f\117\162\144\x65\x72")) {
            goto OD;
        }
        return;
        OD:
        $this->notificationSettings->getWcAdminOrderStatusNotif()->sendSMS(array("\x6f\162\x64\145\162\x44\x65\164\141\x69\x6c\x73" => $z3, "\156\x65\x77\137\163\164\x61\164\165\163" => $pw, "\x6f\x6c\144\137\163\164\x61\164\x75\x73" => $J2));
    }
    function mo_customer_order_hold_sms_notif($oJ, $J2, $pw)
    {
        $z3 = new WC_Order($oJ);
        if (is_a($z3, "\x57\103\137\117\162\x64\145\162")) {
            goto Hw;
        }
        return;
        Hw:
        if (strcasecmp($pw, WcOrderStatus::ON_HOLD) == 0) {
            goto oK;
        }
        if (strcasecmp($pw, WcOrderStatus::PROCESSING) == 0) {
            goto F9;
        }
        if (strcasecmp($pw, WcOrderStatus::COMPLETED) == 0) {
            goto vV;
        }
        if (strcasecmp($pw, WcOrderStatus::REFUNDED) == 0) {
            goto Ez;
        }
        if (strcasecmp($pw, WcOrderStatus::CANCELLED) == 0) {
            goto Iw;
        }
        if (strcasecmp($pw, WcOrderStatus::FAILED) == 0) {
            goto Dx;
        }
        if (strcasecmp($pw, WcOrderStatus::PENDING) == 0) {
            goto OQ;
        }
        return;
        goto CG;
        oK:
        $ME = $this->notificationSettings->getWcOrderOnHoldNotif();
        goto CG;
        F9:
        $ME = $this->notificationSettings->getWcOrderProcessingNotif();
        goto CG;
        vV:
        $ME = $this->notificationSettings->getWcOrderCompletedNotif();
        goto CG;
        Ez:
        $ME = $this->notificationSettings->getWcOrderRefundedNotif();
        goto CG;
        Iw:
        $ME = $this->notificationSettings->getWcOrderCancelledNotif();
        goto CG;
        Dx:
        $ME = $this->notificationSettings->getWcOrderFailedNotif();
        goto CG;
        OQ:
        $ME = $this->notificationSettings->getWcOrderPendingNotif();
        CG:
        $ME->sendSMS(array("\157\162\x64\145\162\104\145\x74\x61\x69\154\x73" => $z3));
    }
    function unhook($Y2)
    {
        $jm = array($Y2->emails["\x57\103\137\105\x6d\x61\x69\154\x5f\x4e\145\167\137\x4f\x72\144\x65\x72"], "\164\162\151\147\x67\145\162");
        $QC = array($Y2->emails["\127\x43\x5f\x45\155\x61\x69\x6c\x5f\103\165\x73\x74\x6f\x6d\x65\x72\137\x50\162\157\143\x65\x73\163\151\156\x67\x5f\117\x72\x64\145\162"], "\164\x72\151\147\x67\x65\162");
        $ID = array($Y2->emails["\x57\103\137\105\x6d\x61\x69\x6c\137\103\x75\x73\164\157\155\x65\162\x5f\103\x6f\155\x70\x6c\145\x74\x65\144\x5f\117\x72\144\145\162"], "\x74\x72\151\x67\x67\145\x72");
        $pC = array($Y2->emails["\127\x43\137\105\155\141\x69\154\x5f\103\x75\x73\x74\157\155\x65\x72\137\x4e\157\x74\x65"], "\164\162\151\x67\147\x65\x72");
        remove_action("\x77\x6f\157\143\157\155\155\x65\162\x63\145\137\154\x6f\x77\137\163\x74\157\143\x6b\137\156\157\x74\x69\x66\x69\x63\x61\164\x69\157\x6e", array($Y2, "\154\x6f\167\x5f\163\164\157\x63\153"));
        remove_action("\167\157\x6f\143\157\155\x6d\145\x72\143\x65\x5f\156\157\x5f\x73\x74\x6f\143\x6b\x5f\x6e\x6f\164\x69\x66\151\x63\141\x74\151\157\156", array($Y2, "\x6e\x6f\x5f\163\x74\157\x63\153"));
        remove_action("\167\x6f\157\x63\x6f\155\x6d\145\x72\x63\145\x5f\x70\x72\157\144\x75\143\x74\137\157\156\x5f\142\x61\x63\x6b\157\x72\x64\145\162\137\156\157\x74\151\146\x69\143\141\x74\x69\157\156", array($Y2, "\x62\x61\143\x6b\157\162\x64\x65\162"));
        remove_action("\167\x6f\157\143\x6f\155\155\145\x72\143\x65\x5f\157\x72\144\x65\162\137\163\x74\141\164\x75\163\137\x70\145\156\x64\151\x6e\x67\x5f\164\x6f\x5f\x70\162\157\143\145\163\163\151\x6e\x67\x5f\156\x6f\164\151\146\x69\143\141\164\151\157\x6e", $jm);
        remove_action("\167\x6f\157\143\x6f\x6d\x6d\x65\162\x63\x65\137\157\162\144\x65\x72\x5f\163\x74\x61\x74\165\x73\137\160\x65\x6e\144\151\156\x67\x5f\x74\157\137\143\x6f\x6d\160\x6c\x65\164\145\x64\x5f\156\157\164\151\x66\151\x63\x61\x74\x69\x6f\x6e", $jm);
        remove_action("\x77\157\157\143\157\x6d\x6d\x65\x72\x63\x65\x5f\x6f\x72\144\145\162\x5f\163\164\x61\x74\x75\x73\137\160\x65\x6e\x64\151\156\147\x5f\164\157\137\157\156\55\x68\157\154\x64\x5f\x6e\x6f\164\x69\x66\151\x63\x61\164\151\157\x6e", $jm);
        remove_action("\x77\157\x6f\143\x6f\x6d\x6d\145\x72\x63\145\137\157\x72\144\x65\x72\137\163\x74\141\164\165\163\x5f\x66\x61\x69\x6c\145\x64\137\164\157\137\160\162\x6f\x63\x65\163\x73\x69\x6e\147\137\156\157\x74\x69\x66\x69\x63\x61\164\151\x6f\x6e", $jm);
        remove_action("\167\x6f\157\143\157\x6d\155\145\x72\143\145\137\157\162\x64\x65\162\x5f\163\x74\141\164\x75\x73\x5f\x66\141\151\154\x65\144\x5f\164\157\137\x63\157\155\x70\154\145\x74\145\144\x5f\x6e\x6f\164\x69\x66\151\143\x61\164\151\157\x6e", $jm);
        remove_action("\x77\157\157\143\x6f\x6d\155\x65\x72\143\x65\137\157\162\144\x65\162\137\x73\164\x61\164\x75\x73\x5f\x66\141\151\x6c\145\144\x5f\x74\157\x5f\x6f\156\55\x68\157\154\x64\137\x6e\x6f\x74\x69\146\x69\x63\x61\164\x69\x6f\156", $jm);
        remove_action("\167\157\157\143\157\x6d\x6d\x65\162\x63\145\x5f\x6f\162\x64\x65\x72\x5f\x73\x74\141\x74\165\163\x5f\x70\145\156\144\x69\156\147\x5f\x74\x6f\137\x70\x72\x6f\143\145\163\163\x69\156\147\137\x6e\157\164\151\146\x69\143\x61\164\x69\157\156", $QC);
        remove_action("\167\157\x6f\x63\157\155\155\145\x72\143\x65\137\157\162\x64\145\162\x5f\x73\x74\x61\164\165\163\x5f\x70\145\x6e\x64\x69\x6e\147\x5f\164\157\137\x6f\x6e\x2d\x68\157\x6c\x64\137\156\157\164\x69\146\x69\x63\141\x74\x69\157\x6e", $QC);
        remove_action("\167\157\x6f\143\x6f\x6d\x6d\145\162\143\x65\x5f\157\162\144\145\162\x5f\x73\164\x61\164\165\163\137\x63\x6f\x6d\x70\154\145\164\x65\144\x5f\x6e\x6f\164\x69\x66\x69\143\x61\164\x69\157\156", $ID);
        remove_action("\167\x6f\x6f\x63\x6f\x6d\155\x65\x72\x63\x65\x5f\156\145\x77\137\143\165\163\164\157\155\x65\x72\137\x6e\x6f\x74\x65\x5f\x6e\x6f\x74\x69\x66\151\143\141\x74\151\157\156", $pC);
    }
    function add_custom_msg_meta_box()
    {
        add_meta_box("\x6d\x6f\137\167\143\x5f\x63\165\163\164\157\155\137\x73\155\x73\x5f\x6d\145\x74\x61\x5f\x62\157\x78", "\103\165\x73\164\x6f\x6d\40\123\115\123", array($this, "\x6d\157\137\163\x68\x6f\x77\x5f\163\145\156\144\137\x63\x75\163\x74\x6f\155\x5f\155\163\147\137\x62\157\170"), "\x73\150\x6f\160\x5f\157\x72\144\145\x72", "\x73\151\144\x65", "\144\145\146\x61\165\154\164");
    }
    function mo_show_send_custom_msg_box($pO)
    {
        $Qr = new WC_Order($pO->ID);
        $Hb = MoWcAddOnUtility::getCustomerNumberFromOrder($Qr);
        include MSN_DIR . "\166\151\x65\167\x73\x2f\x63\x75\163\164\157\155\55\x6f\x72\x64\145\x72\55\155\x73\147\x2e\x70\x68\160";
    }
    function _send_custom_order_msg($bi)
    {
        if (!array_key_exists("\156\165\x6d\x62\145\162\163", $bi) || MoUtility::isBlank($bi["\x6e\165\x6d\142\x65\x72\163"])) {
            goto MS;
        }
        foreach (explode("\73", $bi["\156\x75\155\142\145\x72\x73"]) as $iZ) {
            if (MoUtility::send_phone_notif($iZ, $bi["\x6d\x73\147"])) {
                goto fL;
            }
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ERROR_SENDING_SMS), MoConstants::ERROR_JSON_TYPE));
            goto Nj;
            fL:
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::SMS_SENT_SUCCESS), MoConstants::SUCCESS_JSON_TYPE));
            Nj:
            ap:
        }
        Gj:
        goto K4;
        MS:
        MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::INVALID_PHONE), MoConstants::ERROR_JSON_TYPE);
        K4:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\167\x63\x5f\x73\x6d\163\137\x6e\x6f\x74\151\146\x69\143\141\164\151\x6f\x6e\137\141\x64\144\x6f\x6e";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\101\x6c\x6c\157\167\163\40\171\157\165\162\40\x73\151\x74\x65\40\x74\x6f\x20\163\x65\x6e\x64\40\157\162\x64\145\162\x20\141\x6e\144\x20\x57\x6f\x6f\103\x6f\x6d\155\145\x72\143\x65\40\x6e\157\x74\x69\x66\151\x63\141\x74\151\157\156\163\x20\x74\x6f\x20\x62\x75\171\145\x72\x73\54\x20" . "\163\145\154\154\145\162\163\40\141\156\x64\40\x61\x64\x6d\x69\156\163\x2e\40\103\154\151\x63\x6b\x20\x6f\156\x20\x74\x68\x65\x20\x73\145\164\164\x69\156\147\x73\40\142\x75\x74\x74\157\156\40\164\x6f\40\164\x68\145\x20\x72\151\147\x68\164\x20\164\157\40\163\x65\x65\40\x74\x68\145\x20\x6c\151\163\164\x20\157\146\x20\x6e\157\164\x69\x66\151\143\x61\x74\151\157\156\163\40" . "\164\150\x61\x74\x20\x67\157\40\x6f\165\164\x2e");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\127\157\x6f\103\157\155\155\x65\x72\x63\145\x20\123\x4d\123\40\116\157\164\x69\146\151\x63\141\164\x69\x6f\x6e");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::WOCOMMERCE_SMS_NOTIFICATION_LINK["\147\165\151\x64\145\x4c\x69\x6e\x6b"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::WOCOMMERCE_SMS_NOTIFICATION_LINK["\x76\151\x64\x65\157\114\x69\156\153"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\x64\144\x6f\156" => "\167\x6f\x6f\x63\x6f\155\x6d\145\162\143\x65\x5f\x6e\157\164\x69\x66"), $_SERVER["\122\105\121\125\105\123\x54\137\x55\x52\111"]);
    }
}
