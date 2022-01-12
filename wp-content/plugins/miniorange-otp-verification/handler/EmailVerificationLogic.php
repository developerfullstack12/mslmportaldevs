<?php


namespace OTP\Handler;

if (defined("\101\x42\123\x50\x41\124\110")) {
    goto ADM;
}
die;
ADM:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class EmailVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($wB, $CG, $J9, $rI, $Wj)
    {
        if (is_email($CG)) {
            goto ISb;
        }
        $this->_handle_not_matched($CG, $rI, $Wj);
        goto yBO;
        ISb:
        $this->_handle_matched($wB, $CG, $J9, $rI, $Wj);
        yBO:
    }
    public function _handle_matched($wB, $CG, $J9, $rI, $Wj)
    {
        $SF = str_replace("\x23\43\145\155\x61\x69\x6c\43\43", $CG, $this->_get_is_blocked_message());
        if ($this->_is_blocked($CG, $J9)) {
            goto YUI;
        }
        $this->_start_otp_verification($wB, $CG, $J9, $rI, $Wj);
        goto bro;
        YUI:
        if ($this->_is_ajax_form()) {
            goto arF;
        }
        miniorange_site_otp_validation_form(null, null, null, $SF, $rI, $Wj);
        goto VGf;
        arF:
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        VGf:
        bro:
    }
    public function _handle_not_matched($CG, $rI, $Wj)
    {
        $SF = str_replace("\x23\x23\145\155\141\151\154\x23\x23", $CG, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto GBa;
        }
        miniorange_site_otp_validation_form(null, null, null, $SF, $rI, $Wj);
        goto L2n;
        GBa:
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        L2n:
    }
    public function _start_otp_verification($wB, $CG, $J9, $rI, $Wj)
    {
        $tu = GatewayFunctions::instance();
        $SC = $tu->mo_send_otp_token("\105\x4d\101\x49\x4c", $CG, '');
        switch ($SC["\x73\164\141\x74\x75\163"]) {
            case "\x53\125\103\x43\105\x53\x53":
                $this->_handle_otp_sent($wB, $CG, $J9, $rI, $Wj, $SC);
                goto Pz0;
            default:
                $this->_handle_otp_sent_failed($wB, $CG, $J9, $rI, $Wj, $SC);
                goto Pz0;
        }
        qDj:
        Pz0:
    }
    public function _handle_otp_sent($wB, $CG, $J9, $rI, $Wj, $SC)
    {
        SessionUtils::setEmailTransactionID($SC["\x74\170\x49\x64"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto bTG;
        }
        $l8 = get_mo_option("\145\x6d\141\x69\154\137\164\x72\141\x6e\163\x61\143\164\x69\x6f\x6e\x73\x5f\162\145\x6d\141\151\156\151\156\147");
        if (!($l8 > 0 && MO_TEST_MODE == false)) {
            goto W3e;
        }
        update_mo_option("\x65\155\x61\x69\x6c\x5f\164\x72\141\156\x73\141\143\164\x69\x6f\x6e\x73\137\x72\145\x6d\x61\x69\x6e\x69\x6e\147", $l8 - 1);
        W3e:
        bTG:
        $SF = str_replace("\x23\x23\x65\155\141\151\154\x23\43", $CG, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto A9h;
        }
        miniorange_site_otp_validation_form($wB, $CG, $J9, $SF, $rI, $Wj);
        goto MSk;
        A9h:
        wp_send_json(MoUtility::createJson($SF, MoConstants::SUCCESS_JSON_TYPE));
        MSk:
    }
    public function _handle_otp_sent_failed($wB, $CG, $J9, $rI, $Wj, $SC)
    {
        $SF = str_replace("\x23\x23\145\155\x61\x69\154\x23\x23", $CG, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto JuZ;
        }
        miniorange_site_otp_validation_form(null, null, null, $SF, $rI, $Wj);
        goto MBw;
        JuZ:
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        MBw:
    }
    public function _get_otp_sent_message()
    {
        $G2 = get_mo_option("\163\x75\x63\x63\145\163\x73\137\x65\x6d\141\x69\x6c\x5f\155\145\163\x73\x61\147\x65", "\x6d\x6f\x5f\x6f\x74\160\x5f");
        return $G2 ? mo_($G2) : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
    }
    public function _get_otp_sent_failed_message()
    {
        $dP = get_mo_option("\x65\162\x72\x6f\x72\137\145\155\x61\151\x6c\137\155\x65\163\163\141\x67\145", "\155\157\137\x6f\164\x70\x5f");
        return $dP ? mo_($dP) : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
    }
    public function _is_blocked($CG, $J9)
    {
        $cE = explode("\73", get_mo_option("\142\x6c\157\x63\x6b\145\144\x5f\144\157\x6d\x61\x69\156\x73"));
        $cE = apply_filters("\x6d\x6f\137\x62\x6c\157\x63\x6b\x65\144\x5f\145\155\x61\x69\x6c\137\x64\157\155\141\x69\x6e\x73", $cE);
        return in_array(MoUtility::getDomain($CG), $cE);
    }
    public function _get_is_blocked_message()
    {
        $j6 = get_mo_option("\x62\x6c\x6f\x63\153\x65\144\x5f\x65\x6d\x61\x69\x6c\x5f\155\145\163\x73\141\x67\145", "\155\x6f\x5f\x6f\164\160\137");
        return $j6 ? mo_($j6) : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
    }
    public function _get_otp_invalid_format_message()
    {
        $SF = get_mo_option("\x69\x6e\x76\141\154\151\144\137\145\155\141\151\154\x5f\x6d\x65\163\x73\141\x67\x65", "\155\x6f\137\157\164\160\137");
        return $SF ? mo_($SF) : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
    }
}
