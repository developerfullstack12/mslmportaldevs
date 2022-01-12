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
class WPClientRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_CLIENT_REG;
        $this->_phoneKey = "\167\160\137\143\157\x6e\x74\x61\143\164\137\x70\x68\157\156\145";
        $this->_phoneFormId = "\43\x77\160\x63\137\143\x6f\156\x74\141\143\164\x5f\160\150\157\156\145";
        $this->_formKey = "\x57\120\x5f\x43\x4c\x49\105\x4e\124\137\122\x45\107";
        $this->_typePhoneTag = "\155\157\x5f\x77\x70\137\143\x6c\151\145\x6e\x74\x5f\160\150\157\156\x65\x5f\145\156\x61\142\154\x65";
        $this->_typeEmailTag = "\x6d\157\x5f\167\x70\137\x63\x6c\x69\x65\156\x74\137\x65\155\x61\151\154\x5f\x65\x6e\141\x62\x6c\145";
        $this->_typeBothTag = "\x6d\x6f\x5f\x77\x70\x5f\143\154\151\145\156\x74\x5f\142\157\x74\x68\x5f\x65\156\x61\142\x6c\145";
        $this->_formName = mo_("\127\120\40\103\154\x69\145\156\164\x20\122\145\x67\x69\163\164\x72\x61\164\x69\157\x6e\x20\106\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\167\x70\137\x63\x6c\151\145\156\164\x5f\145\x6e\141\142\154\x65");
        $this->_formDocuments = MoOTPDocs::WP_CLIENT_FORM;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\160\x5f\x63\154\x69\x65\x6e\164\137\145\156\141\x62\154\x65\137\164\x79\x70\x65");
        $this->_restrictDuplicates = get_mo_option("\167\160\137\143\x6c\151\x65\x6e\x74\137\x72\x65\163\x74\x72\151\x63\x74\x5f\144\165\x70\154\x69\x63\141\x74\x65\x73");
        add_filter("\x77\x70\143\x5f\143\x6c\151\x65\156\164\x5f\162\145\x67\x69\163\x74\x72\141\164\151\x6f\156\x5f\146\x6f\x72\x6d\137\x76\141\x6c\x69\144\141\164\x69\x6f\156", array($this, "\x6d\151\156\151\x6f\x72\x61\156\147\145\x5f\143\x6c\x69\x65\156\x74\137\x72\x65\x67\151\163\164\x72\x61\164\151\157\156\x5f\x76\145\x72\151\146\171"), 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $lr = $this->getVerificationType();
        return $lr === VerificationType::PHONE || $lr === VerificationType::BOTH;
    }
    function miniorange_client_registration_verify($errors)
    {
        $lr = $this->getVerificationType();
        $J9 = MoUtility::sanitizeCheck("\143\157\156\x74\x61\143\x74\137\x70\150\x6f\x6e\x65", $_POST);
        $CG = MoUtility::sanitizeCheck("\x63\x6f\x6e\x74\x61\143\x74\x5f\x65\x6d\141\x69\154", $_POST);
        $Ni = MoUtility::sanitizeCheck("\143\x6f\x6e\164\141\143\164\137\165\163\145\162\156\141\x6d\x65", $_POST);
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($J9, $this->_phoneKey))) {
            goto n1;
        }
        $errors .= mo_("\x50\150\x6f\x6e\x65\40\156\x75\x6d\142\145\x72\x20\x61\154\162\145\141\144\x79\40\x69\156\x20\x75\163\x65\x2e\x20\x50\x6c\x65\141\163\145\x20\x45\156\x74\x65\x72\40\141\40\x64\x69\146\146\x65\162\x65\x6e\164\40\120\150\157\x6e\x65\x20\x6e\x75\155\x62\x65\x72\56");
        n1:
        if (MoUtility::isBlank($errors)) {
            goto II;
        }
        return $errors;
        II:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto yW;
        }
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $lr)) {
            goto Yi;
        }
        goto ai;
        yW:
        MoUtility::initialize_transaction($this->_formSessionVar);
        goto ai;
        Yi:
        $this->unsetOTPSessionVariables();
        return $errors;
        ai:
        return $this->startOTPTransaction($Ni, $CG, $errors, $J9);
    }
    function startOTPTransaction($Ni, $CG, $errors, $J9)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto XW;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto U7;
        }
        $this->sendChallenge($Ni, $CG, $errors, $J9, VerificationType::EMAIL);
        goto bM;
        U7:
        $this->sendChallenge($Ni, $CG, $errors, $J9, VerificationType::BOTH);
        bM:
        goto ql;
        XW:
        $this->sendChallenge($Ni, $CG, $errors, $J9, VerificationType::PHONE);
        ql:
        return $errors;
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
    function isPhoneNumberAlreadyInUse($fk, $Zm)
    {
        global $wpdb;
        $fk = MoUtility::processPhoneNumber($fk);
        $h8 = $wpdb->get_row("\x53\x45\x4c\105\103\x54\40\x60\x75\x73\145\x72\137\151\144\x60\40\x46\x52\x4f\115\40\x60{$wpdb->prefix}\x75\x73\x65\x72\155\145\164\x61\140\40\x57\110\105\x52\105\40\140\155\145\164\141\137\153\145\x79\x60\x20\75\40\x27{$Zm}\x27\40\101\116\104\x20\x60\155\x65\164\141\137\x76\x61\154\165\x65\140\x20\75\x20\x20\47{$fk}\47");
        return !MoUtility::isBlank($h8);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto cS;
        }
        array_push($zX, $this->_phoneFormId);
        cS:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto SI;
        }
        return;
        SI:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x70\x5f\143\x6c\x69\x65\x6e\164\x5f\x65\156\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x70\137\143\x6c\x69\x65\156\x74\x5f\x65\x6e\141\142\x6c\145\x5f\164\x79\x70\145");
        $this->_restrictDuplicates = $this->getVerificationType() === VerificationType::PHONE ? $this->sanitizeFormPOST("\167\160\x5f\143\154\151\145\156\164\137\162\x65\163\x74\162\151\143\x74\x5f\144\165\160\x6c\151\143\x61\x74\x65\163") : false;
        update_mo_option("\x77\x70\x5f\x63\154\151\145\x6e\164\x5f\x65\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x77\160\x5f\143\x6c\x69\x65\156\164\137\x65\156\x61\x62\154\x65\x5f\164\171\160\145", $this->_otpType);
        update_mo_option("\167\160\x5f\143\x6c\151\x65\156\164\x5f\162\x65\163\164\x72\x69\143\164\x5f\x64\165\x70\x6c\151\143\141\164\145\x73", $this->_restrictDuplicates);
    }
}
