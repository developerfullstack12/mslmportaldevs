<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WpEmemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::EMEMBER;
        $this->_typePhoneTag = "\x6d\157\137\145\x6d\145\x6d\142\x65\x72\x5f\160\x68\x6f\x6e\145\x5f\145\156\141\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\x5f\145\155\x65\155\x62\145\162\137\x65\x6d\141\151\154\137\x65\x6e\x61\142\154\145";
        $this->_typeBothTag = "\x6d\157\137\x65\x6d\145\155\142\145\162\x5f\142\157\164\x68\137\145\156\x61\142\x6c\145";
        $this->_formKey = "\x57\x50\x5f\x45\x4d\105\115\102\105\x52";
        $this->_formName = mo_("\x57\x50\40\x65\x4d\145\155\x62\x65\x72");
        $this->_isFormEnabled = get_mo_option("\145\155\x65\x6d\x62\x65\162\137\x64\x65\x66\x61\165\154\164\137\x65\x6e\141\x62\x6c\145");
        $this->_phoneKey = "\167\160\137\x65\155\145\155\x62\x65\x72\x5f\160\150\x6f\x6e\145";
        $this->_phoneFormId = "\151\x6e\160\165\x74\x5b\156\x61\155\x65\x3d" . $this->_phoneKey . "\x5d";
        $this->_formDocuments = MoOTPDocs::EMEMBER_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x65\155\145\155\142\x65\162\x5f\x65\x6e\x61\142\154\x65\137\x74\171\x70\x65");
        if (!(array_key_exists("\x65\155\145\x6d\142\x65\x72\137\x64\163\143\x5f\x6e\157\156\143\145", $_POST) && !array_key_exists("\157\x70\164\151\157\x6e", $_POST))) {
            goto tL;
        }
        $this->miniorange_emember_user_registration();
        tL:
    }
    function isPhoneVerificationEnabled()
    {
        $lr = $this->getVerificationType();
        return $lr === VerificationType::PHONE || $lr === VerificationType::BOTH;
    }
    function miniorange_emember_user_registration()
    {
        if (!$this->validatePostFields()) {
            goto SE;
        }
        $fk = array_key_exists($this->_phoneKey, $_POST) ? $_POST[$this->_phoneKey] : NULL;
        $this->startTheOTPVerificationProcess($_POST["\x77\160\137\145\155\x65\155\142\145\x72\x5f\x75\163\145\x72\137\x6e\141\155\145"], $_POST["\167\x70\x5f\x65\x6d\145\x6d\142\145\x72\137\145\x6d\141\x69\154"], $fk);
        SE:
    }
    function startTheOTPVerificationProcess($HR, $TK, $fk)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto qC;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto uR;
        }
        $this->sendChallenge($HR, $TK, $errors, $fk, VerificationType::EMAIL);
        goto kK;
        uR:
        $this->sendChallenge($HR, $TK, $errors, $fk, VerificationType::BOTH);
        kK:
        goto f2;
        qC:
        $this->sendChallenge($HR, $TK, $errors, $fk, VerificationType::PHONE);
        f2:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    function validatePostFields()
    {
        if (!is_blocked_ip(get_real_ip_addr())) {
            goto C3;
        }
        return FALSE;
        C3:
        if (!(emember_wp_username_exists($_POST["\167\x70\137\145\x6d\145\155\x62\145\x72\137\165\x73\145\x72\x5f\x6e\141\x6d\145"]) || emember_username_exists($_POST["\167\160\x5f\145\155\145\155\142\x65\x72\x5f\x75\163\145\162\137\156\x61\x6d\x65"]))) {
            goto TO;
        }
        return FALSE;
        TO:
        if (!(is_blocked_email($_POST["\167\x70\x5f\x65\155\145\x6d\x62\x65\162\x5f\145\x6d\x61\151\154"]) || emember_registered_email_exists($_POST["\x77\x70\137\145\x6d\145\x6d\x62\145\x72\137\145\155\141\x69\154"]) || emember_wp_email_exists($_POST["\x77\160\x5f\x65\155\145\155\142\x65\x72\x5f\x65\x6d\x61\x69\x6c"]))) {
            goto Ca;
        }
        return FALSE;
        Ca:
        if (!(isset($_POST["\x65\x4d\145\155\x62\x65\x72\137\x52\145\x67\x69\x73\x74\145\162"]) && array_key_exists("\167\x70\x5f\x65\155\x65\155\142\x65\162\137\160\x77\144\137\162\145", $_POST) && $_POST["\x77\x70\x5f\145\155\x65\x6d\x62\x65\x72\137\x70\167\x64"] != $_POST["\x77\160\137\x65\155\x65\x6d\142\145\162\x5f\160\x77\x64\137\162\145"])) {
            goto la;
        }
        return FALSE;
        la:
        return TRUE;
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto Nr;
        }
        array_push($zX, $this->_phoneFormId);
        Nr:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto AC;
        }
        return;
        AC:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\145\x6d\x65\x6d\x62\145\x72\137\x64\x65\x66\141\165\154\164\137\145\x6e\141\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\145\155\x65\x6d\x62\145\x72\x5f\x65\156\x61\142\x6c\145\137\x74\x79\160\x65");
        update_mo_option("\145\155\145\x6d\x62\145\x72\137\144\x65\x66\x61\x75\x6c\x74\x5f\145\156\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x65\155\x65\x6d\142\x65\x72\137\x65\x6e\141\142\x6c\x65\137\164\x79\160\145", $this->_otpType);
    }
}
