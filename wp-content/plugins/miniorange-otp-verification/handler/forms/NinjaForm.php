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
class NinjaForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::NINJA_FORM;
        $this->_typePhoneTag = "\155\x6f\137\156\151\x6e\152\141\x5f\x66\157\x72\155\x5f\160\150\157\156\x65\137\x65\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\155\x6f\137\156\151\x6e\x6a\141\137\x66\157\162\155\x5f\145\155\x61\151\154\137\145\156\141\x62\x6c\x65";
        $this->_typeBothTag = "\x6d\157\x5f\x6e\x69\156\152\141\x5f\x66\157\162\155\x5f\142\157\164\150\x5f\x65\156\141\x62\x6c\145";
        $this->_formKey = "\116\111\116\x4a\x41\x5f\106\117\x52\115";
        $this->_formName = mo_("\116\x69\x6e\x6a\141\x20\106\x6f\x72\x6d\x73\x20\x28\x20\x42\145\154\x6f\167\40\166\x65\162\x73\x69\157\x6e\40\x33\56\60\x20\51");
        $this->_isFormEnabled = get_mo_option("\156\151\x6e\152\x61\x5f\x66\x6f\162\x6d\x5f\x65\156\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::NINJA_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x6e\x69\x6e\x6a\x61\x5f\x66\x6f\162\x6d\x5f\145\x6e\x61\x62\154\x65\137\164\x79\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x6e\151\x6e\152\141\x5f\146\157\162\155\137\157\164\x70\137\x65\156\x61\x62\x6c\x65\x64"));
        if (!empty($this->_formDetails)) {
            goto EM;
        }
        return;
        EM:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\x69\x6e\160\165\164\133\156\141\x6d\145\75\156\x69\x6e\x6a\141\137\146\x6f\x72\155\163\137\146\x69\x65\x6c\x64\137" . $zs["\160\x68\157\x6e\145\153\x65\x79"] . "\x5d");
            ii:
        }
        nF:
        if (!$this->checkIfOTPOptions()) {
            goto BH;
        }
        return;
        BH:
        if (!$this->checkIfNinjaFormSubmitted()) {
            goto w2;
        }
        $this->_handle_ninja_form_submit($_REQUEST);
        w2:
    }
    function checkIfOTPOptions()
    {
        return array_key_exists("\157\160\164\151\157\x6e", $_POST) && (strpos($_POST["\x6f\x70\164\x69\157\156"], "\x76\145\162\x69\146\x69\143\141\164\x69\x6f\x6e\137\162\145\x73\145\x6e\144\137\x6f\x74\x70") || $_POST["\157\x70\x74\x69\x6f\156"] == "\155\151\x6e\151\157\x72\141\x6e\147\x65\x2d\166\141\x6c\x69\144\141\164\x65\55\x6f\x74\160\55\x66\157\162\x6d" || $_POST["\x6f\160\164\151\157\156"] == "\x6d\151\x6e\x69\x6f\x72\141\x6e\x67\x65\x2d\x76\x61\154\151\x64\141\164\145\x2d\x6f\164\x70\x2d\143\150\x6f\x69\143\x65\55\x66\157\162\155");
    }
    function checkIfNinjaFormSubmitted()
    {
        return array_key_exists("\x5f\156\x69\x6e\x6a\141\137\x66\157\162\155\x73\137\x64\151\163\x70\154\x61\171\137\x73\x75\x62\155\x69\x74", $_REQUEST) && array_key_exists("\137\146\x6f\x72\155\137\151\x64", $_REQUEST);
    }
    function isPhoneVerificationEnabled()
    {
        $lr = $this->getVerificationType();
        return $lr === VerificationType::PHONE || $lr === VerificationType::BOTH;
    }
    function isEmailVerificationEnabled()
    {
        $lr = $this->getVerificationType();
        return $lr === VerificationType::EMAIL || $lr === VerificationType::BOTH;
    }
    function _handle_ninja_form_submit($GC)
    {
        if (array_key_exists($GC["\137\x66\157\x72\155\137\151\x64"], $this->_formDetails)) {
            goto Ff;
        }
        return;
        Ff:
        $VJ = $this->_formDetails[$GC["\x5f\146\x6f\x72\x6d\x5f\151\144"]];
        $h4 = $this->processEmail($VJ, $GC);
        $fk = $this->processPhone($VJ, $GC);
        $this->miniorange_ninja_form_user($h4, null, $fk);
    }
    function processPhone($VJ, $GC)
    {
        if (!$this->isPhoneVerificationEnabled()) {
            goto FS;
        }
        $Pj = "\x6e\151\x6e\152\141\137\x66\157\x72\x6d\x73\137\x66\x69\145\x6c\x64\137" . $VJ["\x70\150\157\x6e\145\x6b\x65\x79"];
        return array_key_exists($Pj, $GC) ? $GC[$Pj] : NULL;
        FS:
        return null;
    }
    function processEmail($VJ, $GC)
    {
        if (!$this->isEmailVerificationEnabled()) {
            goto ms;
        }
        $Pj = "\x6e\x69\156\152\x61\137\146\x6f\x72\155\163\x5f\x66\151\x65\154\x64\137" . $VJ["\x65\x6d\141\151\154\153\x65\x79"];
        return array_key_exists($Pj, $GC) ? $GC[$Pj] : NULL;
        ms:
        return null;
    }
    function miniorange_ninja_form_user($CG, $UK, $J9)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto XS;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto JZ;
        }
        $this->sendChallenge($UK, $CG, $errors, $J9, VerificationType::EMAIL);
        goto fa;
        JZ:
        $this->sendChallenge($UK, $CG, $errors, $J9, VerificationType::BOTH);
        fa:
        goto ox;
        XS:
        $this->sendChallenge($UK, $CG, $errors, $J9, VerificationType::PHONE);
        ox:
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
            goto cM;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        cM:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Dn9;
        }
        return;
        Dn9:
        if (!isset($_POST["\155\x6f\x5f\143\165\x73\x74\157\x6d\x65\162\x5f\x76\141\154\x69\x64\141\164\151\x6f\156\137\x6e\x6a\141\137\145\x6e\141\142\154\145"])) {
            goto xV6;
        }
        return;
        xV6:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6e\x69\156\x6a\141\x5f\x66\x6f\x72\x6d\x5f\145\x6e\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x6e\x69\x6e\152\x61\x5f\x66\x6f\x72\x6d\x5f\x65\x6e\x61\142\154\x65\137\164\171\160\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x6e\x69\156\152\x61\x5f\x66\157\162\x6d\x5f\x65\156\141\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\156\x6a\141\137\x65\x6e\141\142\154\x65", 0);
        update_mo_option("\x6e\151\x6e\x6a\141\137\x66\x6f\162\x6d\x5f\145\x6e\x61\x62\x6c\145\x5f\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\x6e\x69\156\152\141\x5f\x66\x6f\162\155\137\157\164\160\137\145\x6e\141\142\x6c\x65\x64", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\156\151\156\152\141\137\146\157\162\155", $_POST)) {
            goto wKD;
        }
        return array();
        wKD:
        foreach (array_filter($_POST["\x6e\x69\x6e\x6a\x61\x5f\146\157\162\155"]["\x66\x6f\162\x6d"]) as $Zm => $zs) {
            $form[$zs] = array("\145\x6d\141\151\x6c\x6b\x65\x79" => $_POST["\x6e\151\x6e\x6a\x61\x5f\146\x6f\x72\155"]["\x65\155\x61\x69\154\x6b\x65\171"][$Zm], "\x70\x68\x6f\x6e\145\153\x65\x79" => $_POST["\x6e\x69\156\x6a\141\x5f\x66\x6f\162\x6d"]["\160\150\157\x6e\145\153\145\171"][$Zm]);
            rlg:
        }
        uwg:
        return $form;
    }
}
