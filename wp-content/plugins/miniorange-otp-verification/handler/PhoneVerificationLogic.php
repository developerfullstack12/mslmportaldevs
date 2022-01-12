<?php


namespace OTP\Handler;

if (defined("\x41\102\x53\120\101\124\x48")) {
    goto wD;
}
die;
wD:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormSessionData;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class PhoneVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($wB, $CG, $J9, $rI, $Wj)
    {
        $AU = MoUtility::validatePhoneNumber($J9);
        switch ($AU) {
            case 0:
                $this->_handle_not_matched($J9, $rI, $Wj);
                goto no;
            case 1:
                $this->_handle_matched($wB, $CG, $J9, $rI, $Wj);
                goto no;
        }
        FE:
        no:
    }
    public function _handle_matched($wB, $CG, $J9, $rI, $Wj)
    {
        $SF = str_replace("\x23\x23\x70\x68\x6f\156\x65\43\43", $J9, $this->_get_is_blocked_message());
        if ($this->_is_blocked($CG, $J9)) {
            goto bx;
        }
        do_action("\155\157\137\x67\154\157\x62\141\154\x6c\x79\137\142\x61\x6e\156\x65\x64\137\x70\x68\157\x6e\x65\x5f\x63\150\x65\143\x6b", $J9, $this->_is_ajax_form());
        $this->_start_otp_verification($wB, $CG, $J9, $rI, $Wj);
        goto zy;
        bx:
        if ($this->_is_ajax_form()) {
            goto Kz;
        }
        miniorange_site_otp_validation_form(null, null, null, $SF, $rI, $Wj);
        goto Nl;
        Kz:
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        Nl:
        zy:
    }
    public function _start_otp_verification($wB, $CG, $J9, $rI, $Wj)
    {
        $tu = GatewayFunctions::instance();
        $W1 = "\x53\x4d\123";
        $W1 = apply_filters("\157\164\160\137\157\x76\145\x72\137\143\x61\154\x6c\137\x61\143\x74\151\166\x61\164\x69\x6f\156", $W1);
        $SC = $tu->mo_send_otp_token($W1, '', $J9);
        switch ($SC["\x73\164\141\x74\x75\163"]) {
            case "\123\x55\x43\103\105\x53\123":
                $this->_handle_otp_sent($wB, $CG, $J9, $rI, $Wj, $SC);
                goto xm;
            default:
                $this->_handle_otp_sent_failed($wB, $CG, $J9, $rI, $Wj, $SC);
                goto xm;
        }
        QB:
        xm:
    }
    public function _handle_not_matched($J9, $rI, $Wj)
    {
        $SF = str_replace("\x23\43\160\150\157\156\x65\43\x23", $J9, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto g4;
        }
        miniorange_site_otp_validation_form(null, null, null, $SF, $rI, $Wj);
        goto Np;
        g4:
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        Np:
    }
    public function _handle_otp_sent_failed($wB, $CG, $J9, $rI, $Wj, $SC)
    {
        $SF = str_replace("\x23\43\160\150\157\156\145\x23\x23", $J9, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto nJ;
        }
        miniorange_site_otp_validation_form(null, null, null, $SF, $rI, $Wj);
        goto Xf;
        nJ:
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        Xf:
    }
    public function _handle_otp_sent($wB, $CG, $J9, $rI, $Wj, $SC)
    {
        SessionUtils::setPhoneTransactionID($SC["\164\170\111\144"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto q0;
        }
        $aw = get_mo_option("\160\150\157\156\x65\137\164\162\x61\156\163\x61\x63\164\x69\157\156\163\137\162\145\155\x61\x69\x6e\151\x6e\147");
        if (!($aw > 0 && MO_TEST_MODE == false)) {
            goto a1;
        }
        update_mo_option("\160\150\157\x6e\145\137\164\x72\x61\x6e\x73\x61\143\x74\151\x6f\x6e\163\x5f\x72\x65\x6d\141\151\x6e\x69\156\x67", $aw - 1);
        a1:
        q0:
        $SF = str_replace("\x23\43\160\150\x6f\x6e\145\x23\x23", $J9, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto Qb;
        }
        miniorange_site_otp_validation_form($wB, $CG, $J9, $SF, $rI, $Wj);
        goto Wg;
        Qb:
        wp_send_json(MoUtility::createJson($SF, MoConstants::SUCCESS_JSON_TYPE));
        Wg:
    }
    public function _get_otp_sent_message()
    {
        $Lx = get_mo_option("\163\x75\x63\143\x65\163\x73\x5f\160\x68\157\156\x65\137\155\145\x73\163\x61\x67\x65", "\155\x6f\x5f\157\x74\160\x5f");
        return $Lx ? mo_($Lx) : MoMessages::showMessage(MoMessages::OTP_SENT_PHONE);
    }
    public function _get_otp_sent_failed_message()
    {
        $dP = get_mo_option("\145\162\x72\x6f\x72\x5f\x70\150\157\156\x65\137\x6d\x65\163\163\141\x67\145", "\x6d\157\x5f\x6f\x74\160\x5f");
        return $dP ? mo_($dP) : MoMessages::showMessage(MoMessages::ERROR_OTP_PHONE);
    }
    public function _get_otp_invalid_format_message()
    {
        $KV = get_mo_option("\x69\156\166\141\154\151\x64\x5f\160\150\157\156\x65\137\155\145\163\163\x61\147\145", "\x6d\157\137\x6f\164\160\x5f");
        return $KV ? mo_($KV) : MoMessages::showMessage(MoMessages::ERROR_PHONE_FORMAT);
    }
    public function _is_blocked($CG, $J9)
    {
        $L9 = explode("\x3b", get_mo_option("\x62\154\x6f\x63\x6b\145\144\137\x70\x68\x6f\x6e\145\x5f\156\165\x6d\x62\145\162\163"));
        $L9 = apply_filters("\155\157\x5f\142\154\x6f\143\153\x65\144\x5f\160\150\157\156\145\163", $L9, $J9);
        return in_array($J9, $L9);
    }
    public function _get_is_blocked_message()
    {
        $MH = get_mo_option("\x62\x6c\157\x63\153\x65\144\x5f\160\x68\157\x6e\145\137\x6d\x65\163\x73\141\x67\145", "\155\157\137\x6f\164\x70\137");
        return $MH ? mo_($MH) : MoMessages::showMessage(MoMessages::ERROR_PHONE_BLOCKED);
    }
}
