<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PieRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PIE_REG;
        $this->_typePhoneTag = "\x6d\x6f\x5f\160\x69\x65\x5f\x70\x68\157\156\145\137\x65\156\x61\142\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\160\x69\x65\x5f\x65\155\141\x69\154\137\145\156\141\x62\x6c\145";
        $this->_typeBothTag = "\x6d\x6f\x5f\160\x69\145\137\x62\157\164\x68\x5f\145\x6e\x61\x62\154\145";
        $this->_formKey = "\x50\111\x45\137\x46\117\122\x4d";
        $this->_formName = mo_("\120\x49\x45\40\x52\x65\x67\x69\163\164\x72\x61\x74\151\157\x6e\40\106\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\160\151\x65\x5f\x64\145\146\141\165\x6c\x74\x5f\145\x6e\141\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::PIE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x70\x69\145\137\x65\156\x61\142\154\145\x5f\x74\171\x70\x65");
        $this->_phoneKey = get_mo_option("\x70\151\145\x5f\x70\x68\x6f\x6e\145\137\153\145\171");
        $this->_phoneFormId = $this->getPhoneFieldKey();
        add_action("\x70\151\x65\x5f\x72\x65\x67\151\163\164\145\x72\137\x62\x65\146\x6f\162\x65\x5f\162\145\147\151\x73\x74\x65\162\x5f\166\141\154\151\144\x61\x74\x65", array($this, "\155\x69\x6e\x69\x6f\x72\x61\x6e\x67\x65\x5f\160\151\x65\137\x75\x73\145\162\137\162\x65\x67\151\x73\x74\x72\x61\164\151\157\x6e"), 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV === VerificationType::PHONE || $HV === VerificationType::BOTH;
    }
    function miniorange_pie_user_registration()
    {
        global $errors;
        if (empty($errors->errors)) {
            goto lp;
        }
        return;
        lp:
        if (!$this->checkIfVerificationIsComplete()) {
            goto XX;
        }
        return;
        XX:
        if (!(empty($_POST[$this->_phoneFormId]) && $this->isPhoneVerificationEnabled())) {
            goto AX;
        }
        $errors->add("\155\x6f\x5f\x6f\x74\x70\137\x76\x65\162\x69\146\171", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        return;
        AX:
        $this->startTheOTPVerificationProcess($_POST["\145\137\155\141\151\154"], $_POST[$this->_phoneFormId]);
        if ($this->checkIfVerificationIsComplete()) {
            goto Nv;
        }
        $errors->add("\155\157\x5f\x6f\164\160\137\x76\x65\x72\151\x66\171", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        Nv:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto JX;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        JX:
        return FALSE;
    }
    function startTheOTPVerificationProcess($TK, $fk)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto fG;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto LW;
        }
        $this->sendChallenge('', $TK, null, $fk, VerificationType::EMAIL);
        goto TE;
        LW:
        $this->sendChallenge('', $TK, null, $fk, VerificationType::BOTH);
        TE:
        goto vb;
        fG:
        $this->sendChallenge('', $TK, null, $fk, VerificationType::PHONE);
        vb:
    }
    function getPhoneFieldKey()
    {
        $qJ = get_option("\x70\151\x65\x5f\146\x69\145\x6c\x64\163");
        if (!empty($qJ)) {
            goto nM;
        }
        return '';
        nM:
        $KB = maybe_unserialize($qJ);
        foreach ($KB as $Zm) {
            if (!(strcasecmp(trim($Zm["\154\x61\142\x65\x6c"]), $this->_phoneKey) == 0)) {
                goto Q4;
            }
            return str_replace("\55", "\137", sanitize_title($Zm["\164\171\160\145"] . "\x5f" . (isset($Zm["\x69\x64"]) ? $Zm["\151\144"] : '')));
            Q4:
            WU:
        }
        RC:
        return '';
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
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto hc;
        }
        array_push($zX, "\151\156\160\x75\x74\x23" . $this->_phoneFormId);
        hc:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto YI;
        }
        return;
        YI:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\160\x69\x65\x5f\x64\145\x66\141\x75\154\164\x5f\145\x6e\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\160\x69\x65\x5f\x65\156\x61\142\154\x65\x5f\164\x79\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x70\x69\x65\x5f\160\x68\157\x6e\145\x5f\146\x69\145\x6c\x64\137\153\x65\171");
        update_mo_option("\x70\151\x65\137\144\x65\146\141\165\x6c\164\137\x65\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\160\151\145\137\x65\x6e\141\x62\x6c\x65\x5f\x74\x79\160\145", $this->_otpType);
        update_mo_option("\x70\x69\x65\x5f\x70\150\x6f\156\x65\137\153\145\x79", $this->_phoneKey);
    }
}
