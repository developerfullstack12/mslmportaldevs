<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class WPFormsPlugin extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPFORM;
        $this->_phoneFormId = array();
        $this->_formKey = "\127\120\x46\117\122\x4d\x53";
        $this->_typePhoneTag = "\x6d\x6f\137\167\x70\x66\157\162\x6d\x5f\x70\x68\157\x6e\x65\137\x65\156\x61\x62\x6c\x65";
        $this->_typeEmailTag = "\x6d\157\x5f\167\160\x66\x6f\162\x6d\137\x65\155\141\x69\154\137\x65\156\x61\x62\x6c\145";
        $this->_typeBothTag = "\155\157\137\167\160\x66\157\162\155\x5f\x62\x6f\x74\150\x5f\145\x6e\x61\x62\x6c\145";
        $this->_formName = mo_("\x57\x50\x46\157\x72\x6d\163");
        $this->_isFormEnabled = get_mo_option("\x77\x70\146\157\162\x6d\137\x65\156\x61\x62\154\145");
        $this->_buttonText = get_mo_option("\x77\x70\146\157\162\155\x73\x5f\142\165\164\164\x6f\156\x5f\x74\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\123\x65\156\144\x20\117\124\120");
        $this->_generateOTPAction = "\155\151\156\x69\157\162\x61\x6e\x67\145\55\167\160\146\157\162\155\55\x73\145\x6e\144\x2d\157\x74\x70";
        $this->_validateOTPAction = "\x6d\151\x6e\151\157\162\x61\x6e\147\145\x2d\x77\160\146\157\162\155\x2d\x76\145\x72\151\146\x79\55\x63\x6f\144\x65";
        $this->_formDocuments = MoOTPDocs::WP_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\160\146\x6f\162\x6d\137\x65\x6e\141\x62\x6c\x65\x5f\x74\171\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\167\x70\146\157\x72\155\x5f\146\157\x72\155\x73"));
        if (!empty($this->_formDetails)) {
            goto sWz;
        }
        return;
        sWz:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto tY9;
        }
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\x23\x77\x70\146\x6f\162\155\x73\x2d" . $Zm . "\55\146\x69\x65\x6c\144\137" . $zs["\x70\x68\157\156\145\153\145\x79"]);
            XOD:
        }
        oKO:
        tY9:
        add_filter("\x77\160\146\x6f\162\155\163\137\160\162\157\143\x65\163\x73\137\x69\x6e\x69\x74\151\x61\x6c\137\145\162\x72\x6f\x72\x73", array($this, "\x76\x61\154\x69\144\141\x74\x65\x46\157\x72\155"), 1, 2);
        add_action("\167\160\x5f\145\x6e\161\x75\x65\x75\x65\137\163\x63\x72\151\x70\164\163", array($this, "\x6d\157\x5f\x65\156\161\x75\145\165\x65\x5f\x77\x70\146\x6f\x72\x6d\163"));
        add_action("\167\160\x5f\x61\152\141\170\x5f{$this->_generateOTPAction}", array($this, "\137\x73\x65\x6e\144\137\x6f\x74\x70"));
        add_action("\167\160\137\x61\x6a\x61\x78\x5f\156\157\x70\162\151\166\137{$this->_generateOTPAction}", array($this, "\137\163\x65\x6e\144\x5f\x6f\164\x70"));
        add_action("\167\160\x5f\141\152\141\170\137{$this->_validateOTPAction}", array($this, "\x70\x72\157\x63\145\163\x73\x46\x6f\x72\155\101\156\144\x56\141\x6c\x69\x64\141\164\x65\x4f\124\120"));
        add_action("\x77\x70\137\141\x6a\141\x78\x5f\156\157\160\162\x69\x76\137{$this->_validateOTPAction}", array($this, "\x70\x72\x6f\x63\145\163\163\x46\157\162\155\101\156\x64\126\x61\154\151\x64\x61\164\x65\x4f\x54\x50"));
    }
    function mo_enqueue_wpforms()
    {
        wp_register_script("\x6d\157\167\160\x66\157\162\x6d\x73", MOV_URL . "\x69\x6e\x63\154\x75\144\x65\163\x2f\152\163\57\155\157\x77\160\146\157\x72\x6d\x73\56\155\x69\x6e\x2e\x6a\x73", array("\152\161\x75\145\x72\x79"));
        wp_localize_script("\155\x6f\x77\160\x66\157\x72\x6d\163", "\x6d\157\167\160\146\157\162\155\x73", array("\163\151\x74\x65\125\122\114" => wp_ajax_url(), "\157\164\x70\x54\171\160\x65" => $this->ajaxProcessingFields(), "\x66\x6f\162\x6d\x44\145\x74\x61\151\x6c\163" => $this->_formDetails, "\142\x75\164\x74\x6f\156\x74\x65\170\164" => $this->_buttonText, "\166\x61\154\x69\x64\x61\164\145\144" => $this->getSessionDetails(), "\x69\155\x67\x55\122\x4c" => MOV_LOADER_URL, "\x66\151\145\x6c\x64\124\145\x78\x74" => mo_("\105\156\x74\145\x72\40\117\x54\x50\40\150\x65\x72\x65"), "\147\156\157\x6e\143\145" => wp_create_nonce($this->_nonce), "\156\x6f\156\x63\x65\x4b\x65\x79" => wp_create_nonce($this->_nonceKey), "\x76\156\x6f\x6e\x63\145" => wp_create_nonce($this->_nonce), "\x67\x61\x63\164\x69\x6f\x6e" => $this->_generateOTPAction, "\x76\141\143\164\x69\x6f\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\x6d\x6f\167\160\x66\157\162\155\x73");
    }
    function getSessionDetails()
    {
        return array(VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE));
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ("\x6d\x6f\x5f\167\160\x66\157\162\155\137" . $_POST["\157\x74\x70\124\x79\160\145"] . "\137\x65\156\x61\142\154\145" === $this->_typePhoneTag) {
            goto wuN;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto HZR;
        wuN:
        $this->_processPhoneAndSendOTP($_POST);
        HZR:
    }
    private function _processEmailAndSendOTP($pO)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\162\137\x65\x6d\141\151\154", $pO)) {
            goto ews;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\165\x73\145\162\x5f\x65\x6d\141\x69\154"]);
        $this->sendChallenge('', $pO["\165\163\x65\x72\x5f\145\155\x61\151\154"], NULL, NULL, VerificationType::EMAIL);
        goto vYe;
        ews:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        vYe:
    }
    private function _processPhoneAndSendOTP($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\x72\137\x70\150\157\x6e\145", $pO)) {
            goto XQL;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $pO["\x75\163\x65\162\x5f\x70\x68\157\156\145"]);
        $this->sendChallenge('', NULL, NULL, $pO["\165\163\145\162\137\160\150\x6f\156\x65"], VerificationType::PHONE);
        goto E0P;
        XQL:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        E0P:
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto H2K;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        H2K:
    }
    private function checkIntegrityAndValidateOTP($pO)
    {
        $this->checkIntegrity($pO);
        $this->validateChallenge($pO["\x6f\x74\160\x54\171\160\x65"], NULL, $pO["\157\164\160\x5f\164\157\x6b\x65\x6e"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $pO["\x6f\x74\160\x54\171\160\145"])) {
            goto jd0;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto SIH;
        jd0:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        SIH:
    }
    private function checkIntegrity($pO)
    {
        if ($pO["\x6f\x74\x70\x54\171\x70\x65"] === "\160\150\157\156\x65") {
            goto alT;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $pO["\165\163\145\x72\x5f\145\155\x61\x69\154"])) {
            goto H2c;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        H2c:
        goto yyy;
        alT:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $pO["\165\x73\145\162\x5f\x70\150\x6f\156\x65"])) {
            goto DhQ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        DhQ:
        yyy:
    }
    public function validateForm($errors, $VJ)
    {
        $D5 = $VJ["\151\x64"];
        if (array_key_exists($D5, $this->_formDetails)) {
            goto Xd8;
        }
        return $errors;
        Xd8:
        $VJ = $this->_formDetails[$D5];
        if (empty($errors)) {
            goto a9W;
        }
        return $errors;
        a9W:
        if (!($this->_otpType === $this->_typeEmailTag || $this->_otpType === $this->_typeBothTag)) {
            goto c0M;
        }
        $errors = $this->processEmail($VJ, $errors, $D5);
        c0M:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto AII;
        }
        $errors = $this->processPhone($VJ, $errors, $D5);
        AII:
        if (!empty($errors)) {
            goto FX5;
        }
        $this->unsetOTPSessionVariables();
        FX5:
        return $errors;
    }
    function processEmail($VJ, $errors, $D5)
    {
        $B9 = $VJ["\x65\155\x61\151\154\x6b\145\x79"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto KJ1;
        }
        $errors[$D5][$B9] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        KJ1:
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\x77\x70\x66\157\x72\155\163"]["\146\151\145\154\144\163"][$B9])) {
            goto i65;
        }
        $errors[$D5][$B9] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        i65:
        return $errors;
    }
    function processPhone($VJ, $errors, $D5)
    {
        $B9 = $VJ["\x70\x68\x6f\156\x65\x6b\145\x79"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto IvH;
        }
        $errors[$D5][$B9] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        IvH:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x77\x70\x66\x6f\162\155\x73"]["\146\151\145\154\144\163"][$B9])) {
            goto tB_;
        }
        $errors[$D5][$B9] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        tB_:
        return $errors;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
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
        if (!($this->_isFormEnabled && ($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag))) {
            goto yhi;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        yhi:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto xSN;
        }
        return;
        xSN:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x70\146\157\162\155\x5f\145\156\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\146\157\162\155\x5f\145\156\141\142\x6c\145\x5f\x74\x79\x70\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x77\x70\x66\157\x72\155\163\137\x62\x75\x74\x74\x6f\x6e\137\164\x65\170\164");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\167\x70\146\157\162\155\137\145\156\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\167\160\x66\x6f\x72\x6d\x5f\145\x6e\x61\x62\154\145\137\164\171\160\145", $this->_otpType);
        update_mo_option("\x77\x70\x66\x6f\162\x6d\x73\137\x62\165\x74\164\x6f\156\137\164\x65\x78\x74", $this->_buttonText);
        update_mo_option("\x77\160\x66\157\x72\155\x5f\x66\157\x72\x6d\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\167\x70\146\157\162\x6d\x5f\146\x6f\162\x6d", $_POST)) {
            goto ers;
        }
        return $form;
        ers:
        foreach (array_filter($_POST["\167\x70\x66\x6f\x72\x6d\x5f\x66\x6f\162\155"]["\x66\157\162\155"]) as $Zm => $zs) {
            $VJ = $this->getFormDataFromID($zs);
            if (!MoUtility::isBlank($VJ)) {
                goto dpA;
            }
            goto mRz;
            dpA:
            $tb = $this->getFieldIDs($_POST, $Zm, $VJ);
            $form[$zs] = array("\145\x6d\x61\x69\x6c\x6b\145\x79" => $tb["\145\155\x61\151\x6c\x4b\x65\x79"], "\x70\x68\157\156\145\153\x65\171" => $tb["\160\x68\157\156\145\113\x65\171"], "\x76\x65\x72\151\x66\171\113\x65\171" => $tb["\x76\x65\162\x69\x66\171\113\x65\x79"], "\x70\x68\x6f\156\x65\137\x73\150\x6f\x77" => $_POST["\x77\x70\x66\x6f\162\155\x5f\x66\157\x72\x6d"]["\x70\x68\x6f\156\145\x6b\x65\171"][$Zm], "\145\155\x61\151\x6c\x5f\163\150\157\x77" => $_POST["\x77\160\x66\157\x72\155\x5f\146\x6f\162\x6d"]["\x65\x6d\141\x69\154\153\x65\171"][$Zm], "\x76\145\162\151\x66\x79\x5f\163\150\157\167" => $_POST["\167\x70\x66\157\x72\155\137\x66\157\162\155"]["\x76\145\162\x69\146\171\x4b\x65\171"][$Zm]);
            mRz:
        }
        u0J:
        return $form;
    }
    private function getFormDataFromID($D5)
    {
        if (!Moutility::isBlank($D5)) {
            goto YL7;
        }
        return '';
        YL7:
        $form = get_post(absint($D5));
        if (!MoUtility::isBlank($D5)) {
            goto npc;
        }
        return '';
        npc:
        return wp_unslash(json_decode($form->post_content));
    }
    private function getFieldIDs($pO, $Zm, $VJ)
    {
        $tb = array("\x65\x6d\141\x69\154\x4b\145\x79" => '', "\x70\150\157\156\x65\113\x65\171" => '', "\166\x65\x72\151\x66\171\x4b\145\171" => '');
        if (!empty($pO)) {
            goto ZH9;
        }
        return $tb;
        ZH9:
        foreach ($VJ->fields as $Pj) {
            if (property_exists($Pj, "\154\x61\142\x65\154")) {
                goto Hyv;
            }
            goto cRY;
            Hyv:
            if (!(strcasecmp($Pj->label, $pO["\x77\x70\146\x6f\x72\155\137\146\157\x72\x6d"]["\x65\155\x61\151\154\153\x65\171"][$Zm]) === 0)) {
                goto GgU;
            }
            $tb["\x65\x6d\141\x69\154\x4b\x65\x79"] = $Pj->id;
            GgU:
            if (!(strcasecmp($Pj->label, $pO["\167\x70\x66\x6f\x72\155\x5f\x66\157\x72\x6d"]["\x70\150\x6f\x6e\145\x6b\145\171"][$Zm]) === 0)) {
                goto IWg;
            }
            $tb["\160\x68\x6f\156\145\113\145\x79"] = $Pj->id;
            IWg:
            if (!(strcasecmp($Pj->label, $pO["\167\x70\146\157\x72\155\x5f\x66\x6f\x72\x6d"]["\166\145\x72\x69\x66\x79\x4b\x65\171"][$Zm]) === 0)) {
                goto ukD;
            }
            $tb["\166\x65\x72\151\x66\x79\x4b\145\171"] = $Pj->id;
            ukD:
            cRY:
        }
        rxL:
        return $tb;
    }
}
