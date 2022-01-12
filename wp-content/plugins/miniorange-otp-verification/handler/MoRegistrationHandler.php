<?php


namespace OTP\Handler;

if (defined("\x41\102\x53\x50\x41\x54\110")) {
    goto s7w;
}
die;
s7w:
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Traits\Instance;
class MoRegistrationHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\x6d\157\x5f\162\145\x67\137\141\143\164\151\x6f\156\163";
        add_action("\141\144\155\x69\156\137\x69\156\151\x74", array($this, "\x68\141\x6e\144\x6c\145\137\x63\165\163\x74\157\x6d\x65\162\137\162\145\x67\151\163\x74\162\141\164\x69\x6f\156"));
    }
    function handle_customer_registration()
    {
        if (current_user_can("\155\141\156\141\147\x65\x5f\x6f\x70\164\x69\157\x6e\x73")) {
            goto Zn7;
        }
        return;
        Zn7:
        if (isset($_POST["\157\160\x74\x69\157\156"])) {
            goto J_P;
        }
        return;
        J_P:
        $Xr = trim($_POST["\157\160\x74\151\157\x6e"]);
        switch ($Xr) {
            case "\155\x6f\x5f\x72\145\147\151\x73\164\x72\x61\x74\151\157\156\x5f\x72\x65\147\x69\163\x74\x65\x72\137\143\x75\x73\164\x6f\155\145\x72":
                $this->_register_customer($_POST);
                goto kGP;
            case "\x6d\157\137\x72\145\147\x69\163\164\162\x61\x74\151\x6f\x6e\x5f\143\x6f\x6e\156\145\x63\x74\x5f\166\145\x72\151\x66\171\137\143\x75\163\x74\157\x6d\x65\162":
                $this->_verify_customer($_POST);
                goto kGP;
            case "\155\x6f\x5f\162\x65\147\151\x73\x74\162\x61\164\151\x6f\x6e\137\x76\141\154\x69\x64\x61\x74\145\x5f\157\x74\x70":
                $this->_validate_otp($_POST);
                goto kGP;
            case "\155\x6f\x5f\x72\145\x67\151\163\164\162\x61\164\x69\x6f\x6e\137\x72\x65\163\145\156\144\137\x6f\164\160":
                $this->_send_otp_token(get_mo_option("\141\144\155\x69\x6e\x5f\x65\155\141\151\154"), '', "\x45\x4d\101\111\114");
                goto kGP;
            case "\155\157\x5f\x72\145\147\x69\x73\x74\x72\x61\164\151\157\x6e\137\x70\150\157\156\145\137\x76\x65\162\x69\x66\151\x63\141\x74\x69\157\156":
                $this->_send_phone_otp_token($_POST);
                goto kGP;
            case "\x6d\157\137\x72\x65\147\x69\163\164\162\x61\164\151\157\156\x5f\147\x6f\137\142\x61\143\153":
                $this->_revert_back_registration();
                goto kGP;
            case "\155\157\137\x72\x65\x67\151\x73\x74\162\x61\x74\x69\x6f\x6e\x5f\146\157\162\147\x6f\164\137\160\x61\x73\163\167\157\162\x64":
                $this->_reset_password();
                goto kGP;
            case "\155\157\x5f\147\x6f\137\x74\157\137\x6c\157\x67\151\x6e\137\160\x61\x67\145":
            case "\162\145\155\157\166\145\137\141\x63\143\157\x75\x6e\164":
                $this->removeAccount();
                goto kGP;
            case "\155\x6f\x5f\x72\145\147\151\x73\164\x72\x61\164\151\157\156\x5f\x76\145\x72\x69\x66\171\x5f\154\151\143\145\x6e\x73\x65":
                $this->_vlk($_POST);
                goto kGP;
        }
        WHX:
        kGP:
    }
    function _register_customer($post)
    {
        $this->isValidRequest();
        $h4 = sanitize_email($_POST["\145\x6d\x61\151\x6c"]);
        $Hn = sanitize_text_field($_POST["\143\x6f\x6d\x70\141\156\171"]);
        $RM = sanitize_text_field($_POST["\146\156\141\x6d\x65"]);
        $RO = sanitize_text_field($_POST["\x6c\x6e\x61\155\x65"]);
        $hs = sanitize_text_field($_POST["\x70\x61\163\163\167\157\162\x64"]);
        $sA = sanitize_text_field($_POST["\143\157\x6e\146\x69\x72\155\x50\x61\x73\163\167\x6f\x72\144"]);
        if (!(strlen($hs) < 6 || strlen($sA) < 6)) {
            goto qX0;
        }
        do_action("\155\x6f\137\x72\x65\147\151\x73\164\x72\x61\164\x69\x6f\156\137\163\150\157\167\x5f\155\145\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::PASS_LENGTH), "\105\122\x52\x4f\122");
        return;
        qX0:
        if (!($hs != $sA)) {
            goto RF5;
        }
        delete_mo_option("\166\x65\x72\x69\146\171\137\x63\x75\163\x74\x6f\x6d\145\162");
        do_action("\x6d\x6f\x5f\162\145\x67\x69\x73\x74\162\x61\x74\151\157\156\x5f\x73\x68\x6f\x77\x5f\x6d\145\163\x73\x61\x67\145", MoMessages::showMessage(MoMessages::PASS_MISMATCH), "\x45\122\x52\x4f\122");
        return;
        RF5:
        if (!(MoUtility::isBlank($h4) || MoUtility::isBlank($hs) || MoUtility::isBlank($sA))) {
            goto ATM;
        }
        do_action("\x6d\157\x5f\162\x65\147\x69\163\164\162\x61\x74\151\x6f\156\x5f\x73\150\157\167\137\155\x65\163\163\141\147\x65", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\x45\x52\x52\117\122");
        return;
        ATM:
        update_mo_option("\143\157\x6d\160\x61\156\171\137\x6e\x61\155\x65", $Hn);
        update_mo_option("\x66\x69\x72\x73\164\x5f\156\141\155\145", $RM);
        update_mo_option("\154\x61\163\164\x5f\156\x61\x6d\145", $RO);
        update_mo_option("\141\x64\155\151\156\x5f\145\155\x61\151\x6c", $h4);
        update_mo_option("\x61\x64\x6d\151\156\x5f\x70\x61\x73\163\167\x6f\x72\x64", $hs);
        $SC = json_decode(MocURLOTP::check_customer($h4), true);
        switch ($SC["\163\164\141\x74\165\163"]) {
            case "\103\x55\x53\124\117\115\105\122\137\x4e\117\x54\137\x46\x4f\x55\116\x44":
                $this->_send_otp_token($h4, '', "\105\x4d\x41\111\114");
                goto tRT;
            default:
                $this->_get_current_customer($h4, $hs);
                goto tRT;
        }
        dVs:
        tRT:
    }
    function _send_otp_token($h4, $fk, $x_)
    {
        $this->isValidRequest();
        $SC = json_decode(MocURLOTP::mo_send_otp_token($x_, $h4, $fk), true);
        if (strcasecmp($SC["\x73\x74\141\164\x75\x73"], "\123\x55\x43\103\105\x53\x53") == 0) {
            goto Y37;
        }
        update_mo_option("\x72\145\x67\x69\163\164\x72\x61\164\x69\x6f\x6e\x5f\163\164\x61\164\x75\x73", "\115\117\137\x4f\124\x50\x5f\x44\105\x4c\x49\x56\105\x52\x45\x44\x5f\x46\x41\x49\114\125\x52\x45");
        do_action("\155\157\x5f\x72\x65\x67\x69\x73\x74\162\x61\x74\151\x6f\x6e\137\x73\x68\x6f\167\x5f\155\145\163\x73\141\147\145", MoMessages::showMessage(MoMessages::ERR_OTP), "\105\x52\x52\117\x52");
        goto mq8;
        Y37:
        update_mo_option("\164\162\x61\x6e\163\x61\143\x74\x69\157\x6e\111\144", $SC["\164\x78\x49\144"]);
        update_mo_option("\x72\x65\147\151\163\164\x72\141\164\151\x6f\x6e\137\163\x74\x61\164\165\x73", "\115\x4f\137\x4f\x54\x50\x5f\104\x45\114\x49\126\105\122\x45\x44\x5f\x53\x55\x43\103\105\x53\x53");
        if ($x_ == "\105\x4d\101\x49\x4c") {
            goto H0r;
        }
        do_action("\x6d\x6f\137\162\145\147\x69\163\x74\x72\141\164\x69\157\x6e\137\x73\150\x6f\167\x5f\x6d\x65\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::OTP_SENT, array("\x6d\x65\x74\x68\x6f\144" => $fk)), "\x53\x55\103\103\105\123\x53");
        goto wUQ;
        H0r:
        do_action("\155\157\137\x72\x65\x67\151\163\164\x72\x61\164\x69\157\156\x5f\163\150\x6f\167\137\155\x65\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::OTP_SENT, array("\155\x65\164\x68\157\x64" => $h4)), "\x53\125\x43\x43\105\x53\x53");
        wUQ:
        mq8:
    }
    private function _get_current_customer($h4, $hs)
    {
        $SC = MocURLOTP::get_customer_key($h4, $hs);
        $dT = json_decode($SC, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto XID;
        }
        update_mo_option("\x61\x64\155\151\x6e\137\x65\x6d\141\x69\x6c", $h4);
        update_mo_option("\166\x65\x72\151\146\x79\137\143\165\163\164\x6f\155\x65\162", "\x74\x72\165\145");
        delete_mo_option("\156\x65\167\137\162\x65\147\151\x73\164\x72\141\x74\x69\x6f\156");
        do_action("\x6d\x6f\137\x72\145\x67\151\x73\164\162\141\164\x69\157\x6e\137\x73\x68\x6f\167\x5f\x6d\x65\163\x73\141\x67\145", MoMessages::showMessage(MoMessages::ACCOUNT_EXISTS), "\105\x52\x52\x4f\x52");
        goto jiY;
        XID:
        update_mo_option("\x61\x64\155\x69\x6e\x5f\x65\x6d\141\151\154", $h4);
        update_mo_option("\141\x64\155\151\x6e\137\x70\x68\x6f\156\x65", $dT["\160\x68\x6f\156\x65"]);
        $this->save_success_customer_config($dT["\151\x64"], $dT["\141\160\151\x4b\x65\x79"], $dT["\x74\x6f\x6b\x65\156"], $dT["\141\160\160\123\145\x63\162\x65\164"]);
        MoUtility::_handle_mo_check_ln(false, $dT["\151\144"], $dT["\141\x70\x69\x4b\x65\x79"]);
        do_action("\x6d\x6f\x5f\x72\x65\x67\151\163\x74\x72\x61\164\x69\x6f\x6e\137\x73\150\x6f\167\137\x6d\145\x73\x73\x61\147\145", MoMessages::showMessage(MoMessages::REG_SUCCESS), "\123\125\103\x43\105\x53\x53");
        jiY:
    }
    function save_success_customer_config($D5, $Ca, $w0, $dZ)
    {
        update_mo_option("\x61\x64\x6d\151\156\137\x63\165\x73\x74\x6f\155\145\x72\137\153\145\x79", $D5);
        update_mo_option("\x61\144\x6d\x69\x6e\137\x61\160\151\137\153\145\x79", $Ca);
        update_mo_option("\143\165\163\164\x6f\x6d\x65\x72\x5f\164\157\153\145\x6e", $w0);
        delete_mo_option("\166\x65\162\151\x66\x79\137\x63\165\x73\164\x6f\x6d\x65\162");
        delete_mo_option("\x6e\x65\167\137\x72\x65\147\x69\163\164\x72\x61\164\151\157\x6e");
        delete_mo_option("\x61\144\x6d\151\156\x5f\160\x61\x73\163\x77\x6f\x72\x64");
    }
    function _validate_otp($post)
    {
        $this->isValidRequest();
        $Fz = sanitize_text_field($post["\x6f\x74\x70\137\164\x6f\153\x65\x6e"]);
        $h4 = get_mo_option("\141\x64\155\151\x6e\x5f\x65\155\x61\x69\154");
        $Hn = get_mo_option("\x63\x6f\x6d\x70\x61\x6e\171\137\156\x61\155\145");
        $hs = get_mo_option("\x61\x64\x6d\151\156\x5f\160\141\x73\163\167\x6f\162\144");
        if (!MoUtility::isBlank($Fz)) {
            goto urV;
        }
        update_mo_option("\162\x65\x67\151\163\164\162\x61\164\151\x6f\156\137\163\164\141\x74\165\163", "\x4d\x4f\x5f\x4f\x54\x50\x5f\x56\101\114\x49\104\x41\124\111\117\116\x5f\x46\101\111\114\125\x52\x45");
        do_action("\x6d\157\x5f\162\x65\147\151\163\x74\162\141\164\x69\157\x6e\137\163\x68\x6f\x77\137\x6d\145\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::REQUIRED_OTP), "\x45\x52\122\x4f\122");
        return;
        urV:
        $SC = json_decode(MocURLOTP::validate_otp_token(get_mo_option("\x74\162\x61\x6e\163\x61\x63\164\151\157\156\x49\144"), $Fz), true);
        if (strcasecmp($SC["\x73\x74\x61\164\x75\x73"], "\x53\x55\103\103\105\x53\123") == 0) {
            goto CZ0;
        }
        update_mo_option("\x72\145\x67\x69\x73\164\162\x61\x74\x69\x6f\x6e\137\x73\164\x61\x74\165\x73", "\x4d\x4f\137\x4f\x54\x50\x5f\126\101\x4c\111\104\x41\x54\111\117\x4e\137\106\x41\x49\x4c\125\x52\105");
        do_action("\155\x6f\137\x72\x65\x67\x69\x73\164\x72\x61\164\151\x6f\156\137\x73\150\x6f\167\x5f\155\145\x73\x73\141\147\x65", MoUtility::_get_invalid_otp_method(), "\x45\122\x52\x4f\x52");
        goto Ob7;
        CZ0:
        $dT = json_decode(MocURLOTP::create_customer($h4, $Hn, $hs, $fk = '', $RM = '', $RO = ''), true);
        if (strcasecmp($dT["\x73\x74\141\x74\x75\163"], "\103\125\x53\x54\117\x4d\x45\x52\137\x55\123\105\122\x4e\101\115\105\x5f\x41\x4c\x52\x45\101\x44\131\137\x45\130\x49\x53\x54\x53") == 0) {
            goto wb1;
        }
        if (strcasecmp($dT["\x73\164\x61\x74\x75\x73"], "\105\x4d\101\x49\x4c\137\102\x4c\117\x43\113\x45\x44") == 0 && $dT["\x6d\x65\x73\163\141\x67\145"] == "\145\x72\162\x6f\162\56\x65\156\x74\x65\162\160\x72\151\163\145\x2e\145\x6d\141\x69\154") {
            goto eFR;
        }
        if (strcasecmp($dT["\x73\x74\141\x74\165\163"], "\106\x41\x49\114\x45\104") == 0) {
            goto YRT;
        }
        if (!(strcasecmp($dT["\163\164\x61\x74\x75\163"], "\123\125\x43\103\105\123\123") == 0)) {
            goto H3z;
        }
        $this->save_success_customer_config($dT["\151\144"], $dT["\141\x70\x69\113\x65\x79"], $dT["\164\x6f\x6b\x65\x6e"], $dT["\x61\160\160\x53\145\x63\x72\x65\x74"]);
        update_mo_option("\162\x65\147\x69\163\x74\162\x61\164\x69\x6f\x6e\137\163\164\x61\x74\x75\163", "\x4d\x4f\x5f\x43\x55\x53\124\x4f\x4d\105\x52\x5f\126\x41\x4c\111\104\101\124\111\117\x4e\137\x52\x45\107\111\123\124\x52\x41\x54\111\117\x4e\137\103\117\115\x50\x4c\x45\124\105");
        update_mo_option("\x65\x6d\x61\151\x6c\137\164\162\x61\x6e\x73\141\x63\164\x69\157\156\163\x5f\x72\145\155\x61\151\x6e\x69\156\147", MoConstants::EMAIL_TRANS_REMAINING);
        update_mo_option("\x70\150\x6f\x6e\145\x5f\x74\x72\x61\156\x73\x61\x63\164\151\157\x6e\x73\137\162\x65\x6d\x61\x69\x6e\151\156\x67", MoConstants::PHONE_TRANS_REMAINING);
        do_action("\x6d\157\x5f\162\x65\147\151\163\x74\162\x61\x74\151\157\x6e\137\163\150\157\x77\137\x6d\145\x73\163\141\x67\145", MoMessages::showMessage(MoMessages::REG_COMPLETE), "\x53\x55\103\x43\x45\x53\123");
        header("\114\157\143\x61\164\x69\x6f\156\x3a\x20\x61\144\x6d\151\156\56\160\150\x70\x3f\x70\x61\x67\145\75\x70\x72\x69\143\x69\156\x67");
        H3z:
        goto SwA;
        YRT:
        do_action("\x6d\x6f\x5f\162\145\x67\x69\x73\164\x72\x61\x74\x69\157\156\137\x73\x68\157\x77\x5f\155\x65\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::REGISTRATION_ERROR), "\x45\122\122\x4f\122");
        SwA:
        goto yru;
        eFR:
        do_action("\155\157\137\x72\145\147\x69\163\x74\162\141\x74\151\157\156\137\163\150\157\x77\x5f\x6d\x65\163\163\141\147\x65", MoMessages::showMessage(MoMessages::ENTERPRIZE_EMAIL), "\105\x52\x52\117\122");
        yru:
        goto ino;
        wb1:
        $this->_get_current_customer($h4, $hs);
        ino:
        Ob7:
    }
    function _send_phone_otp_token($post)
    {
        $this->isValidRequest();
        $fk = sanitize_text_field($_POST["\160\x68\157\156\x65\137\156\165\155\142\x65\x72"]);
        $fk = str_replace("\40", '', $fk);
        $j5 = "\x2f\x5b\x5c\53\x5d\133\60\55\71\135\x7b\61\x2c\63\x7d\x5b\x30\55\x39\x5d\x7b\x31\x30\x7d\57";
        if (preg_match($j5, $fk, $av, PREG_OFFSET_CAPTURE)) {
            goto q7N;
        }
        update_mo_option("\x72\145\x67\151\x73\x74\162\x61\164\x69\x6f\x6e\137\163\164\141\x74\x75\163", "\115\x4f\x5f\x4f\x54\120\137\x44\105\x4c\x49\126\105\x52\105\104\137\106\101\x49\114\125\122\x45");
        do_action("\x6d\157\x5f\x72\x65\147\151\163\164\x72\141\164\151\x6f\x6e\x5f\163\x68\157\x77\x5f\x6d\x65\x73\x73\141\147\x65", MoMessages::showMessage(MoMessages::INVALID_SMS_OTP), "\105\x52\x52\x4f\x52");
        goto oPQ;
        q7N:
        update_mo_option("\x61\144\x6d\151\x6e\x5f\x70\150\157\x6e\145", $fk);
        $this->_send_otp_token('', $fk, "\x53\115\x53");
        oPQ:
    }
    function _verify_customer($post)
    {
        $this->isValidRequest();
        $h4 = sanitize_email($post["\x65\155\x61\151\x6c"]);
        $hs = stripslashes($post["\x70\141\x73\x73\x77\x6f\x72\144"]);
        if (!(MoUtility::isBlank($h4) || MoUtility::isBlank($hs))) {
            goto Vxj;
        }
        do_action("\x6d\157\x5f\x72\145\x67\151\163\x74\162\x61\x74\151\157\x6e\137\163\150\157\x77\x5f\155\x65\x73\163\141\147\145", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\105\x52\x52\117\x52");
        return;
        Vxj:
        $this->_get_current_customer($h4, $hs);
    }
    function _reset_password()
    {
        $this->isValidRequest();
        $h4 = get_mo_option("\x61\x64\155\151\x6e\x5f\x65\x6d\x61\151\154");
        if (!$h4) {
            goto OwE;
        }
        $yB = json_decode(MocURLOTP::forgot_password($h4));
        if ($yB->status == "\123\125\x43\103\105\x53\123") {
            goto Ay7;
        }
        do_action("\x6d\x6f\137\x72\145\147\151\x73\164\x72\141\164\x69\157\x6e\137\x73\150\x6f\x77\x5f\155\x65\x73\x73\x61\147\145", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\105\x52\122\117\x52");
        goto cFO;
        Ay7:
        do_action("\155\x6f\x5f\162\145\147\151\x73\164\162\x61\164\x69\157\156\137\163\x68\x6f\167\137\x6d\x65\x73\163\141\147\145", MoMessages::showMessage(MoMessages::RESET_PASS), "\x53\125\103\103\105\123\x53");
        cFO:
        goto h_5;
        OwE:
        do_action("\x6d\x6f\x5f\162\x65\147\151\x73\x74\x72\x61\x74\x69\x6f\x6e\137\x73\150\157\x77\x5f\x6d\x65\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::FORGOT_PASSWORD_MESSAGE), "\x53\125\103\x43\105\123\123");
        h_5:
    }
    function _revert_back_registration()
    {
        $this->isValidRequest();
        update_mo_option("\x72\x65\x67\151\x73\164\x72\x61\x74\151\157\x6e\x5f\163\x74\141\164\165\163", '');
        delete_mo_option("\156\145\167\137\x72\x65\147\x69\x73\x74\162\x61\164\151\157\156");
        delete_mo_option("\166\145\162\151\x66\x79\x5f\143\165\163\164\157\x6d\x65\x72");
        delete_mo_option("\x61\x64\155\x69\x6e\x5f\x65\155\141\151\154");
        delete_mo_option("\x73\x6d\163\x5f\x6f\x74\x70\x5f\x63\157\x75\156\x74");
        delete_mo_option("\145\x6d\141\151\154\137\157\164\x70\137\x63\157\x75\x6e\164");
    }
    function removeAccount()
    {
        $this->isValidRequest();
        $this->flush_cache();
        wp_clear_scheduled_hook("\150\x6f\165\162\x6c\171\x53\x79\156\143");
        delete_mo_option("\164\x72\x61\156\x73\x61\x63\164\151\x6f\156\111\x64");
        delete_mo_option("\141\x64\155\151\156\x5f\160\141\x73\x73\x77\157\162\144");
        delete_mo_option("\x72\x65\147\151\163\164\162\x61\x74\x69\x6f\x6e\x5f\163\164\x61\x74\165\x73");
        delete_mo_option("\x61\x64\155\151\156\x5f\x70\150\x6f\x6e\145");
        delete_mo_option("\x6e\145\x77\x5f\162\145\147\x69\163\164\x72\141\164\151\157\x6e");
        delete_mo_option("\x61\x64\155\x69\x6e\137\143\x75\x73\x74\x6f\155\145\x72\x5f\x6b\x65\171");
        delete_mo_option("\141\x64\155\x69\x6e\137\x61\x70\151\x5f\153\x65\171");
        delete_mo_option("\143\165\163\164\157\x6d\145\162\137\x74\x6f\x6b\x65\x6e");
        delete_mo_option("\x76\145\162\151\146\x79\x5f\143\x75\163\x74\x6f\155\145\162");
        delete_mo_option("\155\x65\163\163\141\147\x65");
        delete_mo_option("\143\150\x65\x63\x6b\137\x6c\x6e");
        delete_mo_option("\x73\151\x74\x65\137\145\155\141\151\154\137\x63\x6b\154");
        delete_mo_option("\x65\155\141\x69\154\137\166\x65\162\151\x66\x69\x63\141\164\151\x6f\x6e\x5f\x6c\153");
        update_mo_option("\x76\x65\x72\151\x66\171\137\143\165\x73\164\157\x6d\145\162", true);
    }
    function flush_cache()
    {
        $tu = GatewayFunctions::instance();
        $tu->flush_cache();
    }
    function _vlk($post)
    {
        $tu = GatewayFunctions::instance();
        $tu->_vlk($post);
    }
}
