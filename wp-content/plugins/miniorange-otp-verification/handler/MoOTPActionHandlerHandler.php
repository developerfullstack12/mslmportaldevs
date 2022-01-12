<?php


namespace OTP\Handler;

if (defined("\x41\102\x53\x50\x41\x54\110")) {
    goto rfI;
}
die;
rfI:
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
class MoOTPActionHandlerHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\157\137\x61\144\155\151\x6e\137\141\x63\x74\x69\x6f\x6e\x73";
        add_action("\141\x64\155\x69\156\x5f\151\x6e\151\164", array($this, "\x5f\150\x61\156\x64\154\145\137\x61\x64\x6d\151\x6e\137\141\143\164\x69\157\x6e\x73"), 1);
        add_action("\141\144\x6d\151\x6e\x5f\x69\x6e\151\x74", array($this, "\155\x6f\x53\x63\x68\145\x64\165\154\145\x54\162\141\x6e\x73\x61\143\164\x69\x6f\156\123\171\x6e\143"), 1);
        add_action("\x61\144\x6d\151\156\137\x69\x6e\x69\164", array($this, "\x63\150\x65\143\x6b\x49\146\120\x6f\160\x75\160\x54\x65\x6d\x70\154\x61\164\x65\101\162\x65\123\x65\x74"), 1);
        add_filter("\144\x61\163\150\x62\157\141\162\144\137\147\154\141\156\143\145\x5f\151\164\145\155\x73", array($this, "\x6f\164\x70\x5f\164\162\x61\x6e\x73\141\x63\164\x69\157\x6e\x73\137\x67\154\x61\156\143\x65\137\143\157\x75\x6e\164\145\x72"), 10, 1);
        add_action("\141\x64\155\151\156\x5f\x70\x6f\x73\x74\137\155\x69\x6e\151\157\162\141\x6e\147\x65\x5f\147\145\x74\137\x66\157\x72\x6d\x5f\144\145\164\141\151\x6c\x73", array($this, "\163\x68\x6f\x77\x46\157\x72\x6d\x48\x54\x4d\x4c\104\x61\x74\141"));
        add_action("\x61\144\x6d\151\156\x5f\x70\x6f\163\x74\137\155\x69\x6e\151\157\162\141\156\147\x65\137\147\145\x74\x5f\x67\x61\164\145\167\141\171\x5f\x63\157\156\146\151\147", array($this, "\x73\150\157\167\107\141\x74\145\x77\141\x79\x43\x6f\156\x66\151\x67"));
    }
    function _handle_admin_actions()
    {
        if (isset($_POST["\x6f\x70\164\x69\x6f\156"])) {
            goto SsV;
        }
        return;
        SsV:
        switch ($_POST["\157\160\164\151\x6f\156"]) {
            case "\155\x6f\137\143\x75\x73\164\x6f\x6d\x65\162\137\166\x61\x6c\x69\144\x61\164\151\157\x6e\x5f\163\145\x74\164\x69\156\147\x73":
                $this->_save_settings($_POST);
                goto Abt;
            case "\155\157\x5f\143\165\x73\164\x6f\155\x65\x72\137\166\x61\x6c\x69\144\x61\164\x69\x6f\156\x5f\155\145\163\x73\141\x67\x65\163":
                $this->_handle_custom_messages_form_submit($_POST);
                goto Abt;
            case "\155\x6f\137\x76\141\x6c\x69\x64\141\x74\151\157\156\x5f\143\x6f\156\x74\x61\x63\x74\137\165\163\x5f\161\x75\145\x72\171\x5f\x6f\x70\x74\x69\x6f\x6e":
                $this->_mo_validation_support_query($_POST);
                goto Abt;
            case "\155\157\x5f\x6f\164\160\x5f\x65\x78\164\x72\141\x5f\x73\145\x74\x74\151\x6e\x67\x73":
                $this->_save_extra_settings($_POST);
                goto Abt;
            case "\155\x6f\x5f\x6f\164\x70\x5f\146\145\x65\x64\142\x61\143\153\x5f\157\x70\x74\x69\157\x6e":
                $this->_mo_validation_feedback_query();
                goto Abt;
            case "\x63\150\145\143\x6b\137\x6d\157\137\x6c\x6e":
                $this->_mo_check_l();
                goto Abt;
            case "\x6d\157\137\143\150\x65\x63\153\x5f\x74\x72\x61\x6e\163\141\143\x74\151\157\x6e\163":
                $this->_mo_check_transactions();
                goto Abt;
            case "\155\x6f\137\x63\165\x73\164\157\x6d\145\162\137\x76\x61\154\x69\x64\x61\x74\151\157\x6e\137\163\155\163\x5f\x63\157\156\146\151\x67\x75\x72\x61\164\151\157\156":
                $this->_mo_configure_sms_template($_POST);
                goto Abt;
            case "\x6d\x6f\137\143\165\163\x74\157\155\145\x72\x5f\x76\x61\154\x69\x64\x61\x74\x69\x6f\x6e\x5f\145\x6d\x61\x69\154\x5f\x63\157\156\146\x69\147\x75\x72\141\164\151\x6f\156":
                $this->_mo_configure_email_template($_POST);
                goto Abt;
            case "\155\157\137\143\x75\x73\x74\x6f\x6d\145\x72\x5f\143\165\x73\x74\x6f\x6d\x69\172\x61\x74\x69\157\156\137\x66\157\162\155":
                $this->_mo_configure_custom_form($_POST);
                goto Abt;
        }
        f91:
        Abt:
    }
    function _mo_configure_custom_form($post)
    {
        $this->isValidRequest();
        update_mo_option("\143\146\137\x73\165\142\155\x69\x74\x5f\151\144", MoUtility::sanitizeCheck("\x63\x66\137\163\165\142\x6d\151\x74\137\x69\144", $post), "\155\157\x5f\x6f\x74\x70\137");
        update_mo_option("\143\x66\x5f\146\151\145\154\x64\x5f\x69\144", MoUtility::sanitizeCheck("\143\x66\x5f\146\151\x65\154\x64\x5f\151\144", $post), "\155\157\x5f\157\x74\160\137");
        update_mo_option("\x63\x66\137\145\x6e\141\x62\x6c\x65\x5f\164\171\160\x65", MoUtility::sanitizeCheck("\x63\146\137\145\x6e\x61\142\154\x65\x5f\x74\171\160\x65", $post), "\x6d\x6f\137\x6f\164\x70\x5f");
        update_mo_option("\x63\x66\137\x62\x75\164\164\x6f\x6e\x5f\x74\145\x78\164", MoUtility::sanitizeCheck("\143\x66\137\x62\165\164\x74\x6f\156\x5f\x74\x65\170\164", $post), "\155\157\x5f\x6f\x74\x70\x5f");
    }
    function _handle_custom_messages_form_submit($post)
    {
        $this->isValidRequest();
        update_mo_option("\x73\x75\x63\143\x65\163\163\x5f\x65\x6d\x61\151\154\137\x6d\x65\163\163\x61\x67\x65", MoUtility::sanitizeCheck("\157\x74\160\x5f\163\x75\143\x63\x65\163\163\x5f\145\x6d\141\151\154", $post), "\155\x6f\137\157\x74\160\137");
        update_mo_option("\163\165\143\x63\x65\163\x73\x5f\160\150\x6f\x6e\x65\137\x6d\145\163\163\141\x67\145", MoUtility::sanitizeCheck("\x6f\x74\x70\x5f\x73\165\143\x63\145\163\x73\137\160\x68\x6f\156\x65", $post), "\155\157\x5f\157\164\x70\x5f");
        update_mo_option("\145\162\162\x6f\162\137\x70\150\157\x6e\x65\x5f\155\x65\x73\163\141\x67\145", MoUtility::sanitizeCheck("\157\x74\160\137\145\162\162\x6f\162\137\160\x68\157\x6e\x65", $post), "\x6d\157\137\x6f\x74\160\137");
        update_mo_option("\145\x72\162\x6f\162\x5f\x65\x6d\x61\x69\154\137\155\145\163\x73\x61\147\x65", MoUtility::sanitizeCheck("\x6f\x74\x70\x5f\145\162\x72\x6f\x72\x5f\145\155\141\x69\x6c", $post), "\x6d\x6f\137\157\x74\x70\137");
        update_mo_option("\151\156\x76\x61\154\151\144\x5f\160\x68\x6f\x6e\x65\137\x6d\x65\x73\x73\141\147\x65", MoUtility::sanitizeCheck("\x6f\x74\160\137\151\x6e\x76\141\154\x69\x64\x5f\x70\150\157\156\145", $post), "\x6d\x6f\137\157\x74\x70\137");
        update_mo_option("\x69\x6e\x76\x61\154\x69\144\137\x65\x6d\141\151\x6c\137\x6d\x65\163\x73\141\147\x65", MoUtility::sanitizeCheck("\157\x74\160\137\x69\x6e\x76\x61\154\x69\x64\137\145\x6d\x61\x69\x6c", $post), "\x6d\x6f\137\157\x74\x70\137");
        update_mo_option("\151\156\x76\x61\154\151\144\x5f\x6d\145\x73\x73\141\147\x65", MoUtility::sanitizeCheck("\x69\x6e\x76\x61\154\x69\x64\137\x6f\164\x70", $post), "\155\157\x5f\157\164\x70\x5f");
        update_mo_option("\142\x6c\x6f\143\x6b\145\144\x5f\x65\x6d\x61\151\154\137\x6d\145\163\x73\141\147\145", MoUtility::sanitizeCheck("\157\x74\160\137\x62\x6c\157\143\x6b\x65\144\137\x65\x6d\141\151\154", $post), "\x6d\157\x5f\x6f\164\160\137");
        update_mo_option("\x62\x6c\157\x63\x6b\145\144\137\160\x68\x6f\x6e\x65\x5f\155\145\x73\x73\141\147\145", MoUtility::sanitizeCheck("\157\164\160\137\x62\x6c\157\143\153\x65\x64\137\160\x68\157\x6e\145", $post), "\x6d\x6f\x5f\x6f\164\x70\137");
        do_action("\155\157\x5f\x72\145\x67\151\163\x74\x72\x61\164\x69\157\x6e\137\x73\150\157\167\137\155\x65\x73\163\141\x67\x65", MoMessages::showMessage(MoMessages::MSG_TEMPLATE_SAVED), "\123\125\103\x43\105\x53\x53");
    }
    function _save_settings($zy)
    {
        $qZ = TabDetails::instance();
        $lq = $qZ->_tabDetails[Tabs::FORMS];
        $this->isValidRequest();
        if (!(MoUtility::sanitizeCheck("\160\141\x67\x65", $_GET) !== $lq->_menuSlug && $zy["\x65\x72\x72\x6f\162\x5f\155\145\163\x73\141\147\145"])) {
            goto ZU1;
        }
        do_action("\155\x6f\x5f\162\x65\147\151\163\164\x72\141\x74\x69\157\x6e\x5f\x73\150\157\x77\x5f\x6d\x65\163\x73\x61\x67\x65", MoMessages::showMessage($zy["\x65\x72\162\157\162\137\155\x65\x73\x73\x61\x67\145"]), "\105\x52\x52\x4f\122");
        ZU1:
    }
    function _save_extra_settings($zy)
    {
        $this->isValidRequest();
        delete_site_option("\x64\x65\x66\141\x75\x6c\164\137\143\157\x75\156\164\x72\x79\x5f\x63\x6f\x64\145");
        $t4 = isset($zy["\x64\145\146\141\165\x6c\164\137\143\x6f\165\x6e\164\x72\171\x5f\x63\157\x64\x65"]) ? $zy["\144\x65\x66\x61\x75\x6c\x74\x5f\x63\x6f\x75\x6e\164\x72\x79\x5f\x63\157\x64\145"] : '';
        update_mo_option("\144\x65\x66\141\x75\154\x74\x5f\143\x6f\165\156\164\162\171", maybe_serialize(CountryList::$countries[$t4]));
        update_mo_option("\142\x6c\x6f\x63\153\145\144\x5f\144\x6f\x6d\x61\151\x6e\163", MoUtility::sanitizeCheck("\155\157\137\x6f\164\160\x5f\x62\x6c\x6f\143\153\x65\144\x5f\145\155\x61\x69\x6c\x5f\x64\157\x6d\141\x69\156\x73", $zy));
        update_mo_option("\142\154\x6f\143\153\x65\x64\x5f\160\x68\x6f\x6e\x65\x5f\x6e\165\x6d\142\x65\162\163", MoUtility::sanitizeCheck("\x6d\x6f\x5f\x6f\164\x70\x5f\x62\154\x6f\x63\x6b\145\144\137\x70\150\157\x6e\x65\x5f\x6e\x75\x6d\x62\145\162\163", $zy));
        update_mo_option("\x73\150\157\167\137\162\x65\x6d\x61\151\156\x69\156\x67\137\x74\x72\141\x6e\163", MoUtility::sanitizeCheck("\155\x6f\x5f\x73\x68\157\167\x5f\x72\145\x6d\141\x69\x6e\x69\x6e\147\137\x74\162\141\x6e\x73", $zy));
        update_mo_option("\163\x68\x6f\x77\137\144\162\x6f\x70\144\157\x77\156\x5f\157\x6e\x5f\146\x6f\162\x6d", MoUtility::sanitizeCheck("\x73\x68\x6f\167\137\144\x72\x6f\x70\x64\157\x77\x6e\137\157\x6e\x5f\146\157\162\155", $zy));
        update_mo_option("\157\164\160\x5f\x6c\x65\156\x67\x74\x68", MoUtility::sanitizeCheck("\x6d\157\137\x6f\164\x70\137\x6c\x65\x6e\147\x74\x68", $zy));
        update_mo_option("\157\164\x70\x5f\x76\141\x6c\151\x64\151\x74\x79", MoUtility::sanitizeCheck("\x6d\x6f\137\157\164\x70\x5f\166\x61\154\x69\144\151\164\171", $zy));
        update_mo_option("\147\x65\x6e\145\162\141\x74\x65\137\x61\x6c\x70\150\141\x6e\165\x6d\x65\x72\x69\x63\137\157\164\160", MoUtility::sanitizeCheck("\155\x6f\x5f\x67\145\156\145\162\x61\164\x65\x5f\x61\154\160\x68\x61\156\x75\155\145\x72\x69\143\x5f\x6f\x74\x70", $zy));
        update_mo_option("\x67\154\x6f\142\x61\x6c\x6c\171\x5f\x62\x61\x6e\x6e\145\144\137\x70\x68\157\156\x65", MoUtility::sanitizeCheck("\x6d\x6f\x5f\147\x6c\157\142\141\154\154\171\x5f\142\141\x6e\x6e\x65\144\x5f\x70\150\x6f\156\x65", $zy));
        do_action("\x6d\x6f\x5f\162\x65\147\151\163\x74\x72\141\x74\151\157\x6e\137\163\150\157\x77\137\x6d\x65\163\163\141\x67\x65", MoMessages::showMessage(MoMessages::EXTRA_SETTINGS_SAVED), "\123\125\x43\103\x45\x53\x53");
    }
    function _mo_validation_support_query($AA)
    {
        $h4 = MoUtility::sanitizeCheck("\x71\x75\145\162\171\x5f\x65\155\x61\x69\x6c", $AA);
        $qn = MoUtility::sanitizeCheck("\161\x75\145\x72\171", $AA);
        $fk = MoUtility::sanitizeCheck("\x71\165\145\162\171\137\160\x68\x6f\x6e\x65", $AA);
        if (!(!$h4 || !$qn)) {
            goto fkt;
        }
        do_action("\155\x6f\x5f\162\x65\x67\x69\163\164\x72\x61\x74\151\x6f\156\137\163\x68\x6f\167\x5f\x6d\145\x73\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_VALUES), "\x45\x52\122\x4f\x52");
        return;
        fkt:
        $Dc = MocURLOTP::submit_contact_us($h4, $fk, $qn);
        if (!(json_last_error() == JSON_ERROR_NONE && $Dc)) {
            goto U13;
        }
        do_action("\155\x6f\x5f\162\145\x67\x69\163\x74\162\x61\164\151\157\156\x5f\x73\150\x6f\167\x5f\x6d\145\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_SENT), "\x53\125\103\103\105\123\123");
        return;
        U13:
        do_action("\155\x6f\x5f\162\x65\x67\151\x73\164\162\x61\x74\151\x6f\x6e\137\x73\150\x6f\167\x5f\x6d\x65\163\x73\141\x67\145", MoMessages::showMessage(MoMessages::SUPPORT_FORM_ERROR), "\105\x52\122\x4f\x52");
    }
    public function otp_transactions_glance_counter()
    {
        if (!(!MoUtility::micr() || !MoUtility::isMG())) {
            goto qKT;
        }
        return;
        qKT:
        $h4 = get_mo_option("\x65\x6d\141\151\x6c\137\164\x72\141\x6e\x73\141\143\164\x69\x6f\156\163\x5f\162\x65\x6d\x61\x69\156\x69\156\147");
        $fk = get_mo_option("\160\150\x6f\x6e\x65\x5f\164\162\x61\156\x73\x61\x63\164\x69\157\156\163\x5f\162\145\x6d\141\x69\156\x69\156\147");
        echo "\x3c\x6c\151\x20\143\154\x61\163\163\75\47\x6d\157\55\x74\162\141\156\163\55\143\157\x75\156\x74\47\76\74\x61\40\x68\x72\x65\x66\x3d\47" . admin_url() . "\141\x64\155\151\x6e\56\x70\x68\x70\x3f\x70\x61\147\x65\75\x6d\157\x73\145\164\x74\x69\156\x67\163\47\x3e" . MoMessages::showMessage(MoMessages::TRANS_LEFT_MSG, array("\x65\x6d\141\x69\154" => $h4, "\160\x68\x6f\x6e\145" => $fk)) . "\x3c\x2f\x61\x3e\x3c\57\154\151\x3e";
    }
    public function checkIfPopupTemplateAreSet()
    {
        $nY = maybe_unserialize(get_mo_option("\x63\x75\x73\x74\157\155\x5f\160\x6f\160\x75\x70\163"));
        if (!empty($nY)) {
            goto BYr;
        }
        $xC = apply_filters("\x6d\x6f\x5f\164\145\x6d\x70\154\x61\x74\x65\137\144\x65\146\x61\x75\x6c\x74\x73", array());
        update_mo_option("\x63\x75\x73\x74\x6f\155\137\160\157\160\x75\x70\x73", maybe_serialize($xC));
        BYr:
    }
    public function showFormHTMLData()
    {
        $this->isValidRequest();
        $sb = $_POST["\x66\x6f\162\x6d\137\x6e\141\155\x65"];
        $XJ = MOV_DIR . "\143\157\156\x74\162\157\154\x6c\x65\x72\x73\x2f";
        $GZ = !MoUtility::micr() ? "\x64\151\x73\141\142\154\145\144" : '';
        $rp = admin_url() . "\145\x64\151\x74\56\160\150\x70\x3f\x70\x6f\x73\164\x5f\x74\x79\160\x65\75\x70\x61\x67\x65";
        ob_start();
        include $XJ . "\x66\x6f\x72\x6d\x73\x2f" . $sb . "\56\x70\150\x70";
        $iz = ob_get_clean();
        wp_send_json(MoUtility::createJson($iz, MoConstants::SUCCESS_JSON_TYPE));
    }
    public function showGatewayConfig()
    {
        $this->isValidRequest();
        $wQ = $_POST["\147\141\164\x65\167\141\x79\x5f\x74\171\160\145"];
        $Q4 = "\x4f\x54\x50\x5c\110\x65\154\160\x65\x72\134\107\141\x74\145\x77\141\171\x5c" . $wQ;
        $GZ = !MoUtility::micr() ? "\x64\x69\x73\141\142\154\145\x64" : '';
        $RR = get_mo_option("\x63\165\163\164\157\155\137\163\155\163\137\147\x61\164\x65\167\x61\x79") ? get_mo_option("\x63\165\x73\x74\x6f\x6d\x5f\163\x6d\163\137\147\x61\x74\x65\x77\x61\x79") : '';
        $M5 = $Q4::instance()->getGatewayConfigView($GZ, $RR);
        wp_send_json(MoUtility::createJson($M5, MoConstants::SUCCESS_JSON_TYPE));
    }
    function moScheduleTransactionSync()
    {
        if (!(!wp_next_scheduled("\x68\x6f\165\x72\x6c\171\123\171\156\143") && MoUtility::micr())) {
            goto uAY;
        }
        wp_schedule_event(time(), "\x64\141\151\x6c\x79", "\150\157\x75\162\154\x79\x53\x79\x6e\x63");
        uAY:
    }
    function _mo_validation_feedback_query()
    {
        $this->isValidRequest();
        $U8 = $_POST["\155\151\156\x69\157\x72\141\156\x67\145\137\x66\145\145\x64\x62\x61\143\153\137\163\165\x62\x6d\x69\x74"];
        if (!($U8 === "\x53\x6b\151\160\x20\46\40\104\145\141\143\x74\151\166\141\x74\145")) {
            goto yEr;
        }
        deactivate_plugins(array(MOV_PLUGIN_NAME));
        return;
        yEr:
        $bO = strcasecmp($_POST["\x70\x6c\x75\147\151\156\x5f\x64\x65\x61\143\x74\151\166\x61\x74\145\x64"], "\164\162\x75\145") == 0;
        $QH = !$bO ? mo_("\x5b\x20\120\154\165\x67\x69\156\x20\106\145\x65\144\x62\x61\x63\x6b\x20\135\40\x3a\x20") : mo_("\x5b\x20\120\x6c\x75\x67\x69\x6e\40\x44\x65\x61\x63\164\151\166\141\164\145\144\x20\135");
        $pr = sanitize_text_field($_POST["\x71\165\x65\162\x79\137\x66\x65\x65\144\x62\x61\143\x6b"]);
        $Ks = file_get_contents(MOV_DIR . "\151\x6e\x63\154\x75\144\x65\x73\x2f\x68\x74\x6d\x6c\57\146\x65\x65\x64\x62\x61\143\x6b\x2e\155\151\156\x2e\150\x74\155\154");
        $current_user = wp_get_current_user();
        $N6 = MoUtility::micv() ? "\120\162\145\155\x69\x75\x6d" : "\x46\162\145\x65";
        $h4 = get_mo_option("\x61\x64\x6d\151\x6e\x5f\x65\x6d\x61\x69\154");
        $Ks = str_replace("\173\173\x46\x49\122\x53\124\x5f\116\101\x4d\105\x7d\x7d", $current_user->first_name, $Ks);
        $Ks = str_replace("\x7b\173\x4c\101\x53\124\x5f\x4e\101\115\x45\175\175", $current_user->last_name, $Ks);
        $Ks = str_replace("\173\x7b\x50\x4c\125\107\x49\x4e\137\x54\x59\120\x45\175\x7d", MOV_TYPE . "\x3a" . $N6, $Ks);
        $Ks = str_replace("\x7b\173\x53\x45\122\x56\105\x52\x7d\175", $_SERVER["\123\105\x52\x56\105\x52\137\116\x41\115\105"], $Ks);
        $Ks = str_replace("\x7b\173\x45\115\x41\111\114\175\x7d", $h4, $Ks);
        $Ks = str_replace("\173\x7b\x50\114\x55\107\111\x4e\175\175", MoConstants::AREA_OF_INTEREST, $Ks);
        $Ks = str_replace("\173\x7b\x56\x45\x52\x53\x49\x4f\x4e\175\175", MOV_VERSION, $Ks);
        $Ks = str_replace("\173\x7b\x54\x59\x50\105\175\175", $QH, $Ks);
        $Ks = str_replace("\173\x7b\106\105\105\104\x42\101\103\113\x7d\x7d", $pr, $Ks);
        $ZF = MoUtility::send_email_notif($h4, "\130\145\143\x75\x72\151\x66\171", MoConstants::FEEDBACK_EMAIL, "\127\x6f\162\x64\120\x72\145\x73\163\x20\117\x54\x50\x20\126\145\162\x69\x66\x69\x63\141\x74\x69\157\156\40\120\154\x75\147\x69\x6e\40\x46\145\145\x64\x62\141\x63\153", $Ks);
        if ($ZF) {
            goto Qnd;
        }
        do_action("\x6d\157\x5f\162\x65\147\x69\163\164\x72\141\x74\151\157\156\137\x73\150\x6f\167\137\155\145\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::FEEDBACK_ERROR), "\x45\122\x52\117\122");
        goto ZGc;
        Qnd:
        do_action("\155\157\137\162\x65\x67\x69\163\164\162\141\x74\151\157\156\x5f\163\x68\157\167\137\155\x65\163\x73\141\x67\145", MoMessages::showMessage(MoMessages::FEEDBACK_SENT), "\123\x55\x43\103\x45\x53\123");
        ZGc:
        if (!$bO) {
            goto TVQ;
        }
        deactivate_plugins(array(MOV_PLUGIN_NAME));
        TVQ:
    }
    function _mo_check_transactions()
    {
        if (!(!empty($_POST) && check_admin_referer("\155\157\137\x63\x68\145\x63\153\137\x74\162\x61\156\x73\141\143\x74\x69\157\x6e\x73\x5f\146\x6f\162\155", "\137\156\x6f\156\143\145"))) {
            goto SKQ;
        }
        MoUtility::_handle_mo_check_ln(true, get_mo_option("\x61\144\x6d\151\x6e\x5f\143\x75\163\x74\x6f\155\x65\162\137\153\145\171"), get_mo_option("\x61\144\155\x69\156\137\x61\160\151\137\x6b\145\171"));
        SKQ:
    }
    function _mo_check_l()
    {
        $this->isValidRequest();
        MoUtility::_handle_mo_check_ln(true, get_mo_option("\x61\x64\x6d\151\x6e\x5f\x63\x75\x73\164\157\x6d\145\x72\137\x6b\145\x79"), get_mo_option("\x61\x64\155\151\156\137\141\160\151\137\x6b\x65\x79"));
    }
    function _mo_configure_sms_template($zy)
    {
        if (isset($zy["\155\x6f\137\143\x75\x73\x74\157\x6d\x65\x72\137\x76\141\154\151\144\x61\164\x69\x6f\156\x5f\143\165\163\164\x6f\155\137\163\x6d\x73\x5f\x67\141\164\145\x77\x61\x79"]) && empty($zy["\x6d\157\137\x63\x75\163\164\157\155\x65\x72\x5f\x76\141\x6c\151\x64\141\x74\151\x6f\156\x5f\143\x75\163\x74\x6f\155\x5f\163\x6d\x73\137\x67\x61\164\145\x77\141\x79"])) {
            goto Ls2;
        }
        do_action("\x6d\157\x5f\162\x65\147\x69\x73\x74\x72\x61\164\x69\157\x6e\137\163\150\x6f\167\137\155\x65\x73\163\x61\x67\x65", MoMessages::showMessage(MoMessages::SMS_TEMPLATE_SAVED), "\x53\x55\103\103\105\123\123");
        goto DXa;
        Ls2:
        do_action("\155\157\x5f\162\145\147\151\163\x74\x72\x61\164\x69\157\x6e\x5f\163\x68\157\167\137\x6d\145\163\x73\141\x67\145", MoMessages::showMessage(MoMessages::SMS_TEMPLATE_ERROR), "\x45\x52\x52\x4f\122");
        DXa:
        $tu = GatewayFunctions::instance();
        $tu->_mo_configure_sms_template($zy);
    }
    function _mo_configure_email_template($zy)
    {
        $tu = GatewayFunctions::instance();
        $tu->_mo_configure_email_template($zy);
    }
}
