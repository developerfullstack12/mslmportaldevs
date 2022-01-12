<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class WooCommerceBilling extends FormHandler implements IFormHandler
{
    use Instance;
    function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_BILLING;
        $this->_typePhoneTag = "\155\157\137\167\x63\142\137\x70\150\157\x6e\x65\x5f\x65\156\x61\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x77\143\142\x5f\145\x6d\141\151\x6c\137\145\156\141\x62\x6c\145";
        $this->_phoneFormId = "\x23\x62\151\x6c\x6c\x69\156\x67\137\x70\150\x6f\156\145";
        $this->_formKey = "\127\103\137\x42\111\x4c\114\x49\116\107\137\x46\x4f\122\x4d";
        $this->_formName = mo_("\x57\157\157\143\x6f\155\155\x65\x72\x63\x65\x20\102\x69\x6c\x6c\x69\156\x67\40\x41\144\144\x72\x65\x73\163\x20\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\167\143\x5f\142\151\154\x6c\x69\156\147\x5f\x65\156\x61\142\x6c\145");
        $this->_buttonText = get_mo_option("\x77\143\x5f\x62\x69\x6c\154\x69\x6e\x67\137\x62\165\164\164\157\x6e\137\x74\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\143\153\x20\110\x65\x72\145\40\164\x6f\x20\163\145\156\x64\x20\x4f\124\120");
        $this->_formDocuments = MoOTPDocs::WC_BILLING_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_restrictDuplicates = get_mo_option("\167\x63\137\142\x69\154\x6c\x69\x6e\147\x5f\162\x65\x73\164\x72\151\143\164\137\144\165\x70\154\151\143\141\x74\145\x73");
        $this->_otpType = get_mo_option("\167\x63\x5f\142\151\154\x6c\x69\x6e\147\137\164\171\160\x65\137\145\x6e\141\x62\x6c\145\x64");
        if ($this->_otpType === $this->_typeEmailTag) {
            goto CO;
        }
        add_filter("\x77\x6f\x6f\143\x6f\155\x6d\x65\162\x63\145\x5f\x70\x72\157\x63\x65\163\x73\137\155\x79\141\x63\143\x6f\165\156\x74\x5f\x66\x69\145\x6c\144\x5f\x62\x69\x6c\x6c\151\x6e\147\137\160\150\157\x6e\x65", array($this, "\x5f\167\143\x5f\165\x73\145\162\137\x61\x63\x63\x6f\x75\156\164\137\x75\160\144\x61\x74\145"), 99, 1);
        goto Z7;
        CO:
        add_filter("\167\157\x6f\x63\157\155\x6d\x65\162\x63\x65\137\x70\162\x6f\x63\145\x73\163\137\155\171\141\x63\x63\x6f\x75\156\164\137\146\151\x65\154\x64\137\142\151\x6c\154\x69\x6e\147\x5f\145\155\x61\151\x6c", array($this, "\x5f\x77\x63\x5f\x75\x73\145\162\x5f\x61\143\143\157\165\156\164\137\165\x70\x64\141\164\x65"), 99, 1);
        Z7:
    }
    function _wc_user_account_update($zs)
    {
        $zs = $this->_otpType === $this->_typePhoneTag ? MoUtility::processPhoneNumber($zs) : $zs;
        $QH = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $QH)) {
            goto ra;
        }
        $this->unsetOTPSessionVariables();
        return $zs;
        ra:
        if (!$this->userHasNotChangeData($zs)) {
            goto oc;
        }
        return $zs;
        oc:
        if (!($this->_restrictDuplicates && $this->isDuplicate($zs, $QH))) {
            goto Is;
        }
        return $zs;
        Is:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(null, $_POST["\x62\151\x6c\x6c\x69\156\147\x5f\x65\x6d\141\x69\154"], null, $_POST["\142\151\154\154\x69\156\x67\137\x70\x68\157\156\145"], $QH);
        return $zs;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    private function userHasNotChangeData($zs)
    {
        $pO = $this->getUserData();
        return strcasecmp($pO, $zs) == 0;
    }
    private function getUserData()
    {
        global $wpdb;
        $current_user = wp_get_current_user();
        $Zm = $this->_otpType === $this->_typePhoneTag ? "\x62\151\x6c\154\151\x6e\x67\x5f\160\x68\157\156\145" : "\142\151\x6c\154\151\x6e\x67\x5f\x65\155\x61\x69\154";
        $V_ = "\123\105\x4c\105\x43\124\x20\155\145\164\x61\x5f\166\141\154\x75\x65\40\x46\122\117\x4d\x20\x60{$wpdb->prefix}\x75\163\145\x72\x6d\x65\164\x61\x60\40\x57\110\x45\x52\x45\x20\x60\x6d\145\x74\x61\137\x6b\145\171\x60\x20\x3d\40\x27{$Zm}\47\x20\x41\116\x44\x20\140\165\x73\x65\x72\x5f\x69\144\140\x20\75\x20{$current_user->ID}";
        $h8 = $wpdb->get_row($V_);
        return isset($h8) ? $h8->meta_value : '';
    }
    private function isDuplicate($zs, $QH)
    {
        global $wpdb;
        $Zm = "\x62\151\154\x6c\151\156\x67\137" . $QH;
        $h8 = $wpdb->get_row("\x53\x45\114\105\x43\124\40\x60\x75\163\x65\x72\137\x69\144\140\x20\x46\x52\117\115\40\140{$wpdb->prefix}\x75\163\x65\162\x6d\145\x74\x61\140\40\127\110\x45\122\105\x20\x60\x6d\145\x74\141\x5f\153\x65\x79\x60\x20\x3d\x20\x27{$Zm}\47\x20\101\116\104\x20\x60\155\145\164\x61\137\166\x61\154\x75\145\140\x20\75\x20\x20\x27{$zs}\x27");
        if (!isset($h8)) {
            goto rQ;
        }
        if ($QH === VerificationType::PHONE) {
            goto kw;
        }
        if (!($QH === VerificationType::EMAIL)) {
            goto UQ;
        }
        wc_add_notice(MoMessages::showMessage(MoMessages::EMAIL_EXISTS), MoConstants::ERROR_JSON_TYPE);
        UQ:
        goto jB;
        kw:
        wc_add_notice(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE);
        jB:
        return TRUE;
        rQ:
        return FALSE;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto kx;
        }
        array_push($zX, $this->_phoneFormId);
        kx:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto EJ;
        }
        return;
        EJ:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\143\x5f\142\x69\x6c\x6c\151\x6e\147\x5f\x65\156\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\x5f\142\151\154\x6c\151\x6e\147\x5f\x74\171\160\145\137\145\156\141\142\x6c\145\x64");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\143\x5f\142\151\154\154\151\156\147\137\162\x65\x73\164\162\x69\x63\x74\137\x64\x75\x70\x6c\151\143\x61\164\145\x73");
        if (!$this->basicValidationCheck(BaseMessages::WC_BILLING_CHOOSE)) {
            goto Ed;
        }
        update_mo_option("\167\x63\137\x62\x69\154\x6c\x69\x6e\x67\x5f\145\x6e\141\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\167\x63\x5f\142\151\x6c\x6c\x69\x6e\147\x5f\x74\x79\x70\x65\137\x65\156\141\x62\154\x65\x64", $this->_otpType);
        update_mo_option("\167\143\x5f\x62\151\154\x6c\151\x6e\x67\137\x72\x65\x73\x74\x72\x69\x63\x74\137\x64\165\160\x6c\151\x63\x61\164\x65\x73", $this->_restrictDuplicates);
        Ed:
    }
}
