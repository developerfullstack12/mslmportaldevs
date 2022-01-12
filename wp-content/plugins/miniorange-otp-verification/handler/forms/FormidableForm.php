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
class FormidableForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMIDABLE_FORM;
        $this->_typePhoneTag = "\x6d\x6f\x5f\146\x72\x6d\x5f\146\x6f\x72\155\137\x70\150\x6f\156\x65\x5f\145\156\x61\x62\x6c\x65";
        $this->_typeEmailTag = "\155\157\x5f\146\x72\x6d\137\146\157\162\x6d\137\145\155\x61\151\x6c\137\145\156\141\142\154\145";
        $this->_formKey = "\x46\117\x52\115\111\x44\101\102\x4c\x45\x5f\x46\117\x52\x4d";
        $this->_formName = mo_("\x46\157\x72\x6d\151\x64\x61\x62\x6c\145\x20\106\x6f\x72\x6d\163");
        $this->_isFormEnabled = get_mo_option("\146\162\155\x5f\146\x6f\x72\155\x5f\x65\156\x61\142\154\145");
        $this->_buttonText = get_mo_option("\146\x72\155\137\142\x75\x74\x74\157\156\x5f\x74\x65\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\143\153\x20\x48\x65\162\x65\x20\164\x6f\40\x73\x65\156\144\x20\x4f\124\x50");
        $this->_generateOTPAction = "\x6d\151\x6e\x69\x6f\162\x61\x6e\147\x65\x5f\146\162\x6d\137\x67\145\x6e\x65\162\x61\164\145\137\157\x74\160";
        $this->_formDocuments = MoOTPDocs::FORMIDABLE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\146\162\155\137\x66\157\162\155\137\145\156\x61\x62\154\x65\x5f\164\171\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\162\155\x5f\x66\157\162\x6d\x5f\x6f\x74\160\x5f\x65\x6e\141\x62\x6c\145\144"));
        $this->_phoneFormId = array();
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto wF;
        }
        return;
        wF:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\43" . $zs["\x70\x68\157\x6e\145\153\145\171"] . "\40\151\156\x70\165\x74");
            TZ:
        }
        gW:
        add_filter("\x66\x72\x6d\x5f\166\141\x6c\x69\x64\141\x74\145\137\146\x69\x65\154\144\x5f\x65\156\164\162\x79", array($this, "\x6d\151\156\151\157\162\x61\156\147\x65\137\x6f\x74\160\x5f\x76\141\154\x69\x64\141\164\x69\x6f\156"), 11, 4);
        add_action("\167\160\137\141\152\141\x78\137{$this->_generateOTPAction}", array($this, "\137\163\145\x6e\144\137\x6f\x74\x70\137\x66\162\x6d\x5f\x61\x6a\141\x78"));
        add_action("\x77\160\x5f\141\x6a\x61\x78\x5f\x6e\x6f\x70\x72\x69\x76\x5f{$this->_generateOTPAction}", array($this, "\137\x73\145\x6e\144\137\157\x74\160\x5f\146\162\x6d\x5f\x61\x6a\141\x78"));
        add_action("\167\x70\x5f\x65\156\161\165\145\165\x65\137\163\x63\x72\x69\x70\x74\163", array($this, "\x6d\x69\156\x69\157\x72\x61\x6e\x67\x65\137\x72\x65\147\151\x73\x74\145\162\x5f\x66\157\162\x6d\x69\x64\141\142\154\x65\x5f\163\143\x72\151\160\164"));
    }
    function miniorange_register_formidable_script()
    {
        wp_register_script("\x6d\157\x66\x6f\x72\155\151\144\x61\142\154\x65", MOV_URL . "\151\x6e\143\x6c\165\x64\x65\x73\x2f\x6a\163\x2f\146\x6f\162\155\x69\144\x61\x62\x6c\145\x2e\x6d\x69\156\x2e\152\163", array("\152\x71\165\x65\x72\x79"));
        wp_localize_script("\155\157\146\157\162\155\151\144\x61\x62\x6c\145", "\155\x6f\x66\157\x72\x6d\x69\144\141\142\x6c\x65", array("\x73\x69\164\145\x55\x52\114" => wp_ajax_url(), "\157\164\160\x54\171\x70\145" => $this->_otpType, "\x66\157\x72\x6d\x6b\x65\171" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\160\150\157\156\x65\x6b\x65\171" : "\x65\x6d\x61\151\154\153\145\x79", "\x6e\x6f\x6e\x63\145" => wp_create_nonce($this->_nonce), "\142\x75\x74\164\157\x6e\164\x65\170\164" => mo_($this->_buttonText), "\x69\155\x67\125\122\114" => MOV_LOADER_URL, "\146\x6f\x72\155\163" => $this->_formDetails, "\147\145\x6e\145\162\141\164\x65\x55\x52\114" => $this->_generateOTPAction));
        wp_enqueue_script("\155\x6f\146\157\162\155\151\144\141\142\x6c\x65");
    }
    function _send_otp_frm_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto pV;
        }
        $this->_send_frm_otp_to_email($_POST);
        goto d9;
        pV:
        $this->_send_frm_otp_to_phone($_POST);
        d9:
    }
    function _send_frm_otp_to_phone($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\162\137\160\150\x6f\156\145", $pO)) {
            goto lD;
        }
        $this->sendOTP(trim($pO["\x75\x73\x65\162\137\x70\150\x6f\x6e\145"]), NULL, trim($pO["\x75\163\145\162\x5f\x70\150\157\156\145"]), VerificationType::PHONE);
        goto gs;
        lD:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        gs:
    }
    function _send_frm_otp_to_email($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\x65\155\x61\x69\154", $pO)) {
            goto ek;
        }
        $this->sendOTP($pO["\165\163\x65\x72\137\x65\155\141\x69\x6c"], $pO["\165\163\145\162\x5f\x65\x6d\141\151\154"], NULL, VerificationType::EMAIL);
        goto tc;
        ek:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        tc:
    }
    private function sendOTP($ZI, $TK, $Zu, $lr)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($lr === VerificationType::PHONE) {
            goto OR1;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $ZI);
        goto KS;
        OR1:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ZI);
        KS:
        $this->sendChallenge('', $TK, NULL, $Zu, $lr);
    }
    function miniorange_otp_validation($errors, $Pj, $zs, $LD)
    {
        if (!($this->getFieldId("\166\145\x72\x69\146\171\x5f\163\150\157\x77", $Pj) !== $Pj->id)) {
            goto fs;
        }
        return $errors;
        fs:
        if (MoUtility::isBlank($errors)) {
            goto nj;
        }
        return $errors;
        nj:
        if ($this->hasOTPBeenSent($errors, $Pj)) {
            goto RZ;
        }
        return $errors;
        RZ:
        if (!$this->isMisMatchEmailOrPhone($errors, $Pj)) {
            goto IT;
        }
        return $errors;
        IT:
        if ($this->isValidOTP($zs, $Pj, $errors)) {
            goto an;
        }
        return $errors;
        an:
        return $errors;
    }
    private function hasOTPBeenSent(&$errors, $Pj)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Tu;
        }
        $SF = MoMessages::showMessage(BaseMessages::ENTER_VERIFY_CODE);
        if ($this->isPhoneVerificationEnabled()) {
            goto oY;
        }
        $errors["\x66\151\145\154\144" . $this->getFieldId("\145\155\141\151\154\x5f\x73\x68\x6f\x77", $Pj)] = $SF;
        goto JO;
        oY:
        $errors["\x66\x69\x65\x6c\144" . $this->getFieldId("\160\x68\157\x6e\x65\x5f\x73\150\x6f\x77", $Pj)] = $SF;
        JO:
        return false;
        Tu:
        return true;
    }
    private function isMisMatchEmailOrPhone(&$errors, $Pj)
    {
        $QG = $this->getFieldId($this->isPhoneVerificationEnabled() ? "\160\x68\x6f\x6e\x65\x5f\163\150\157\167" : "\x65\x6d\141\151\x6c\x5f\x73\150\x6f\x77", $Pj);
        $On = $_POST["\x69\x74\x65\x6d\137\x6d\x65\x74\141"][$QG];
        if ($this->checkPhoneOrEmailIntegrity($On)) {
            goto co;
        }
        if ($this->isPhoneVerificationEnabled()) {
            goto Hx;
        }
        $errors["\x66\151\145\x6c\144" . $this->getFieldId("\145\x6d\x61\x69\x6c\137\163\150\157\x77", $Pj)] = MoMessages::showMessage(BaseMessages::EMAIL_MISMATCH);
        goto WJ;
        Hx:
        $errors["\x66\151\145\154\144" . $this->getFieldId("\x70\x68\157\x6e\145\x5f\x73\x68\157\167", $Pj)] = MoMessages::showMessage(BaseMessages::PHONE_MISMATCH);
        WJ:
        return true;
        co:
        return false;
    }
    private function isValidOTP($zs, $Pj, &$errors)
    {
        $lr = $this->getVerificationType();
        $this->validateChallenge($lr, NULL, $zs);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $lr)) {
            goto TC;
        }
        $errors["\x66\x69\x65\154\144" . $this->getFieldId("\x76\x65\162\151\146\x79\137\x73\x68\157\167", $Pj)] = MoUtility::_get_invalid_otp_method();
        return false;
        goto S5;
        TC:
        $this->unsetOTPSessionVariables();
        return true;
        S5:
    }
    private function checkPhoneOrEmailIntegrity($On)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto GF;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $On);
        goto Eh;
        GF:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $On);
        Eh:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto yu;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        yu:
        return $zX;
    }
    function isPhoneVerificationEnabled()
    {
        return $this->getVerificationType() === VerificationType::PHONE;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto SB;
        }
        return;
        SB:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\146\x72\x6d\x5f\x66\157\x72\x6d\137\x65\x6e\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\146\162\155\137\146\x6f\162\155\137\145\x6e\x61\x62\x6c\145\137\164\x79\160\145");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\146\x72\155\x5f\x62\165\x74\x74\157\x6e\137\x74\x65\170\x74");
        if (!$this->basicValidationCheck(BaseMessages::FORMIDABLE_CHOOSE)) {
            goto wH;
        }
        update_mo_option("\146\x72\155\137\x62\x75\164\x74\157\156\x5f\164\x65\170\x74", $this->_buttonText);
        update_mo_option("\x66\x72\155\x5f\x66\157\x72\x6d\x5f\x65\x6e\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\146\x72\x6d\137\146\157\162\x6d\x5f\x65\x6e\141\x62\154\145\x5f\x74\x79\x70\145", $this->_otpType);
        update_mo_option("\146\x72\155\x5f\x66\157\x72\x6d\x5f\157\164\x70\x5f\145\156\141\x62\154\145\144", maybe_serialize($this->_formDetails));
        wH:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x66\x72\155\137\x66\x6f\162\x6d", $_POST)) {
            goto Fz;
        }
        return array();
        Fz:
        foreach (array_filter($_POST["\x66\162\155\137\146\157\162\155"]["\146\157\x72\155"]) as $Zm => $zs) {
            $form[$zs] = array("\x65\155\141\x69\x6c\x6b\x65\171" => "\146\x72\155\x5f\x66\151\x65\154\144\137" . $_POST["\x66\x72\155\x5f\146\157\162\155"]["\x65\x6d\141\x69\154\153\145\171"][$Zm] . "\137\143\x6f\156\164\141\x69\156\145\x72", "\160\150\x6f\x6e\x65\x6b\145\171" => "\x66\162\x6d\137\146\151\145\154\144\137" . $_POST["\x66\x72\x6d\x5f\146\x6f\x72\x6d"]["\160\x68\157\x6e\145\153\x65\171"][$Zm] . "\x5f\x63\157\156\164\x61\151\x6e\x65\x72", "\166\145\x72\151\x66\x79\113\145\x79" => "\146\162\x6d\x5f\x66\x69\x65\154\144\137" . $_POST["\x66\x72\155\137\x66\x6f\162\155"]["\x76\x65\x72\x69\x66\171\113\x65\171"][$Zm] . "\x5f\143\x6f\156\164\x61\151\x6e\145\x72", "\160\x68\157\x6e\x65\x5f\x73\x68\x6f\167" => $_POST["\146\x72\x6d\x5f\x66\x6f\162\x6d"]["\160\x68\x6f\x6e\x65\153\145\171"][$Zm], "\145\x6d\141\x69\154\137\x73\x68\x6f\167" => $_POST["\x66\162\x6d\137\x66\157\x72\x6d"]["\145\x6d\141\151\x6c\x6b\145\x79"][$Zm], "\x76\x65\x72\x69\x66\x79\x5f\163\150\x6f\x77" => $_POST["\146\162\x6d\137\146\157\x72\x6d"]["\166\x65\162\x69\x66\x79\113\145\171"][$Zm]);
            K1:
        }
        Xo:
        return $form;
    }
    function getFieldId($Zm, $Pj)
    {
        return $this->_formDetails[$Pj->form_id][$Zm];
    }
}
