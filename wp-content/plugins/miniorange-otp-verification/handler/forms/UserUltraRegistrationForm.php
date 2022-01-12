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
use XooUserRegister;
use XooUserRegisterLite;
class UserUltraRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UULTRA_REG;
        $this->_typePhoneTag = "\155\157\137\165\165\154\x74\x72\141\137\x70\150\x6f\156\x65\137\x65\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x75\x75\x6c\164\x72\141\137\145\155\141\x69\x6c\x5f\x65\x6e\x61\x62\154\x65";
        $this->_typeBothTag = "\x6d\157\137\x75\x75\154\x74\x72\x61\137\142\157\164\x68\x5f\x65\x6e\141\x62\x6c\x65";
        $this->_formKey = "\x55\125\x4c\124\x52\101\x5f\106\x4f\122\115";
        $this->_formName = mo_("\x55\x73\145\x72\x20\x55\x6c\x74\162\141\x20\x52\x65\147\x69\x73\164\162\141\x74\151\157\x6e\40\x46\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\165\165\154\x74\162\141\137\144\145\146\141\165\154\x74\x5f\x65\156\x61\x62\154\145");
        $this->_formDocuments = MoOTPDocs::UULTRA_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\x75\165\154\164\162\x61\x5f\x70\x68\157\x6e\x65\x5f\153\x65\x79");
        $this->_otpType = get_mo_option("\165\165\x6c\x74\162\x61\x5f\x65\x6e\141\x62\154\x65\x5f\x74\171\160\145");
        $this->_phoneFormId = "\151\156\x70\x75\x74\133\156\x61\155\x65\x3d" . $this->_phoneKey . "\135";
        $HV = $this->getVerificationType();
        if (MoUtility::sanitizeCheck("\170\x6f\157\165\163\145\162\x75\154\x74\x72\x61\x2d\x72\145\147\x69\x73\164\145\162\55\146\157\162\155", $_POST)) {
            goto K9;
        }
        return;
        K9:
        $fk = $this->isPhoneVerificationEnabled() ? $_POST[$this->_phoneKey] : NULL;
        $this->_handle_uultra_form_submit($_POST["\x75\163\145\x72\137\154\x6f\x67\x69\156"], $_POST["\165\163\145\162\137\x65\155\141\x69\154"], $fk);
    }
    function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV == VerificationType::PHONE || $HV === VerificationType::BOTH;
    }
    function _handle_uultra_form_submit($UK, $CG, $fk)
    {
        $LR = class_exists("\130\x6f\x6f\125\163\x65\x72\x52\145\x67\x69\x73\x74\x65\162\114\x69\x74\145") ? new XooUserRegisterLite() : new XooUserRegister();
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto gV;
        }
        return;
        gV:
        $LR->uultra_prepare_request($_POST);
        $LR->uultra_handle_errors();
        if (!MoUtility::isBlank($LR->errors)) {
            goto ZR;
        }
        $_POST["\156\x6f\137\x63\x61\160\164\x63\150\x61"] = "\171\145\x73";
        $this->_handle_otp_verification_uultra($UK, $CG, null, $fk);
        ZR:
        return;
    }
    function _handle_otp_verification_uultra($UK, $CG, $errors, $fk)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto aj;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto dh;
        }
        $this->sendChallenge($UK, $CG, $errors, $fk, VerificationType::EMAIL);
        goto SU;
        dh:
        $this->sendChallenge($UK, $CG, $errors, $fk, VerificationType::BOTH);
        SU:
        goto Y0;
        aj:
        $this->sendChallenge($UK, $CG, $errors, $fk, VerificationType::PHONE);
        Y0:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
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
            goto CX;
        }
        array_push($zX, $this->_phoneFormId);
        CX:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Sy;
        }
        return;
        Sy:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\x75\x6c\164\162\x61\137\144\x65\146\x61\x75\154\164\x5f\145\x6e\x61\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\165\165\154\164\162\x61\137\x65\x6e\141\x62\154\x65\137\164\171\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x75\x6c\164\162\141\137\160\150\x6f\156\x65\137\x66\x69\x65\x6c\x64\x5f\153\145\x79");
        update_mo_option("\165\165\x6c\x74\x72\x61\137\x64\x65\146\141\x75\154\164\x5f\x65\156\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x75\x75\x6c\164\x72\x61\137\x65\x6e\x61\x62\154\145\x5f\164\x79\x70\145", $this->_otpType);
        update_mo_option("\165\x75\x6c\164\x72\x61\137\x70\x68\157\x6e\145\137\x6b\145\171", $this->_phoneKey);
    }
}
