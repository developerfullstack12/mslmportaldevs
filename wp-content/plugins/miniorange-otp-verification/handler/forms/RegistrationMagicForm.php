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
class RegistrationMagicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CRF_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\157\137\x63\x72\146\137\160\x68\x6f\x6e\145\x5f\x65\156\x61\x62\x6c\x65";
        $this->_typeEmailTag = "\155\157\x5f\143\162\146\x5f\145\x6d\x61\x69\154\137\145\156\141\142\x6c\145";
        $this->_typeBothTag = "\155\x6f\x5f\x63\x72\146\x5f\x62\157\164\x68\x5f\145\156\x61\142\154\145";
        $this->_formKey = "\103\122\106\x5f\106\x4f\x52\115";
        $this->_formName = mo_("\x43\165\163\x74\157\155\40\125\x73\145\x72\40\122\145\147\151\x73\x74\162\x61\x74\x69\x6f\x6e\40\x46\x6f\x72\155\x20\102\165\x69\x6c\x64\x65\x72\40\x28\122\145\147\151\163\164\x72\x61\164\151\x6f\156\x20\x4d\x61\x67\151\x63\51");
        $this->_isFormEnabled = get_mo_option("\143\x72\146\x5f\x64\x65\x66\x61\x75\x6c\x74\x5f\x65\x6e\x61\x62\154\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CRF_FORM_ENABLE;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\x72\x66\137\145\x6e\141\142\154\x65\x5f\164\171\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\162\x66\137\157\164\160\137\145\156\141\142\154\145\x64"));
        if (!empty($this->_formDetails)) {
            goto hYc;
        }
        return;
        hYc:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\x69\156\x70\165\x74\x5b\x6e\141\x6d\145\x3d" . $this->getFieldID($zs["\160\x68\157\x6e\x65\153\x65\171"], $Zm) . "\x5d");
            c0e:
        }
        qIw:
        if ($this->checkIfPromptForOTP()) {
            goto Ucs;
        }
        return;
        Ucs:
        $this->_handle_crf_form_submit($_REQUEST);
    }
    private function checkIfPromptForOTP()
    {
        if (!(array_key_exists("\x6f\160\164\x69\157\156", $_POST) || !array_key_exists("\x72\x6d\x5f\146\157\162\x6d\x5f\x73\165\142\x5f\151\x64", $_POST))) {
            goto jNp;
        }
        return FALSE;
        jNp:
        foreach ($this->_formDetails as $Zm => $zs) {
            if (!(strpos($_POST["\162\x6d\x5f\x66\157\162\x6d\x5f\x73\165\142\x5f\x69\x64"], "\146\x6f\162\155\137" . $Zm . "\x5f") !== FALSE)) {
                goto zEO;
            }
            MoUtility::initialize_transaction($this->_formSessionVar);
            SessionUtils::setFormOrFieldId($this->_formSessionVar, $Zm);
            return TRUE;
            zEO:
            jve:
        }
        GQE:
        return FALSE;
    }
    private function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV === VerificationType::PHONE || $HV === VerificationType::BOTH;
    }
    private function isEmailVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV === VerificationType::EMAIL || $HV === VerificationType::BOTH;
    }
    private function _handle_crf_form_submit($GC)
    {
        $h4 = $this->isEmailVerificationEnabled() ? $this->getCRFEmailFromRequest($GC) : '';
        $fk = $this->isPhoneVerificationEnabled() ? $this->getCRFPhoneFromRequest($GC) : '';
        $this->miniorange_crf_user($h4, isset($GC["\165\x73\145\x72\x5f\x6e\x61\155\145"]) ? $GC["\165\163\x65\162\137\x6e\141\x6d\145"] : NULL, $fk);
        $this->checkIfValidated();
    }
    private function checkIfValidated()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto AXq;
        }
        $this->unsetOTPSessionVariables();
        AXq:
    }
    private function getCRFEmailFromRequest($GC)
    {
        $Z9 = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $kk = $this->_formDetails[$Z9]["\145\155\141\x69\x6c\x6b\x65\171"];
        return $this->getFormPostSubmittedValue($this->getFieldID($kk, $Z9), $GC);
    }
    private function getCRFPhoneFromRequest($GC)
    {
        $Z9 = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $ZK = $this->_formDetails[$Z9]["\160\x68\157\x6e\145\x6b\145\171"];
        return $this->getFormPostSubmittedValue($this->getFieldID($ZK, $Z9), $GC);
    }
    private function getFormPostSubmittedValue($bP, $GC)
    {
        return isset($GC[$bP]) ? $GC[$bP] : '';
    }
    private function getFieldID($Zm, $a8)
    {
        global $wpdb;
        $WS = $wpdb->prefix . "\x72\x6d\x5f\146\151\145\x6c\x64\x73";
        $sV = $wpdb->get_row("\123\x45\114\105\103\x54\40\x2a\40\x46\122\x4f\115\x20{$WS}\40\167\x68\145\x72\x65\x20\146\x6f\162\155\137\151\x64\40\75\x20\47" . $a8 . "\47\40\141\x6e\x64\40\146\151\x65\154\144\137\x6c\141\x62\145\154\x20\x3d\47" . $Zm . "\x27");
        return isset($sV) ? ($sV->field_type == "\x4d\x6f\142\151\x6c\145" ? "\x54\145\170\164\x62\157\170" : $sV->field_type) . "\137" . $sV->field_id : "\156\165\x6c\x6c";
    }
    private function miniorange_crf_user($CG, $UK, $J9)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Vec;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto nzl;
        }
        $this->sendChallenge($UK, $CG, $errors, $J9, VerificationType::EMAIL);
        goto CE0;
        nzl:
        $this->sendChallenge($UK, $CG, $errors, $J9, VerificationType::BOTH);
        CE0:
        goto xUV;
        Vec:
        $this->sendChallenge($UK, $CG, $errors, $J9, VerificationType::PHONE);
        xUV:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Poi;
        }
        return;
        Poi:
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
            goto QMu;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        QMu:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto vBh;
        }
        return;
        vBh:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\162\x66\x5f\144\x65\146\x61\165\154\164\x5f\145\156\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\143\162\146\137\x65\156\x61\142\x6c\x65\137\x74\171\160\145");
        update_mo_option("\143\162\x66\137\144\x65\x66\141\x75\154\x74\137\x65\x6e\141\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x63\x72\x66\x5f\145\x6e\141\x62\x6c\145\137\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\x63\162\146\137\157\x74\x70\x5f\145\x6e\x61\x62\154\145\x64", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (!(!array_key_exists("\143\x72\x66\137\146\x6f\162\x6d", $_POST) && empty($_POST["\143\162\x66\137\146\x6f\162\155"]["\x66\x6f\162\155"]))) {
            goto PkM;
        }
        return $form;
        PkM:
        foreach (array_filter($_POST["\x63\x72\x66\x5f\146\157\x72\155"]["\146\157\162\155"]) as $Zm => $zs) {
            $form[$zs] = array("\145\155\x61\151\154\153\145\171" => $_POST["\143\162\146\x5f\146\x6f\162\155"]["\145\x6d\141\x69\x6c\153\145\x79"][$Zm], "\x70\x68\157\156\x65\153\145\x79" => $_POST["\x63\x72\146\x5f\146\x6f\162\x6d"]["\x70\150\x6f\156\145\x6b\x65\171"][$Zm], "\x65\155\141\151\x6c\x5f\x73\150\x6f\167" => $_POST["\143\x72\146\x5f\x66\157\x72\155"]["\x65\x6d\x61\151\154\x6b\x65\x79"][$Zm], "\x70\x68\157\156\145\x5f\163\150\157\167" => $_POST["\143\x72\146\137\146\x6f\x72\155"]["\160\150\x6f\156\x65\153\145\x79"][$Zm]);
            Spe:
        }
        MCs:
        return $form;
    }
}
