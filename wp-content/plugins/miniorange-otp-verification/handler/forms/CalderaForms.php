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
use WP_Error;
class CalderaForms extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CALDERA;
        $this->_typePhoneTag = "\x6d\x6f\137\143\141\x6c\144\145\162\141\137\x70\150\157\x6e\145\x5f\145\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\x5f\143\141\154\144\x65\x72\141\x5f\x65\155\x61\x69\x6c\137\145\x6e\141\142\154\145";
        $this->_formKey = "\103\101\114\104\105\x52\x41";
        $this->_formName = mo_("\x43\x61\154\x64\145\x72\x61\x20\x46\157\x72\x6d\163");
        $this->_isFormEnabled = get_mo_option("\x63\x61\154\x64\x65\x72\141\x5f\x65\156\x61\x62\x6c\145");
        $this->_buttonText = get_mo_option("\x63\141\154\144\145\x72\141\x5f\142\165\164\x74\157\x6e\x5f\164\x65\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\x69\143\x6b\x20\x48\145\x72\x65\x20\164\157\40\163\145\156\144\40\117\x54\x50");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CALDERA_FORMS_LINK;
        $this->_generateOTPAction = "\155\151\x6e\151\x6f\162\x61\x6e\147\x65\x5f\143\x61\x6c\x64\145\162\141\x5f\147\145\x6e\x65\x72\141\164\x65\x5f\x6f\x74\x70";
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\141\x6c\x64\x65\x72\141\137\x65\156\141\142\x6c\145\x5f\164\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\x61\154\x64\145\162\x61\137\x66\157\x72\155\163"));
        if (!empty($this->_formDetails)) {
            goto Sf;
        }
        return;
        Sf:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\151\x6e\160\x75\x74\x5b\x6e\x61\155\145\x3d" . $zs["\x70\150\x6f\156\x65\153\145\171"]);
            add_filter("\143\x61\x6c\144\145\162\x61\137\146\x6f\x72\x6d\x73\x5f\x76\141\x6c\151\x64\x61\x74\145\137\x66\151\x65\154\x64\x5f" . $zs["\x70\x68\x6f\156\145\x6b\x65\171"], array($this, "\166\x61\154\151\144\141\x74\x65\x46\x6f\x72\155"), 99, 3);
            add_filter("\143\141\154\x64\145\162\141\137\146\x6f\x72\155\x73\x5f\166\x61\x6c\151\x64\141\x74\x65\x5f\x66\151\145\x6c\144\137" . $zs["\x65\x6d\141\151\x6c\x6b\x65\171"], array($this, "\166\141\154\151\x64\141\164\145\106\x6f\162\155"), 99, 3);
            add_filter("\x63\141\154\144\145\x72\141\x5f\146\157\x72\155\163\x5f\x76\x61\x6c\151\x64\141\164\x65\137\146\151\145\154\144\x5f" . $zs["\x76\145\162\x69\x66\x79\x4b\x65\171"], array($this, "\166\141\154\x69\x64\141\x74\x65\x46\157\162\x6d"), 99, 3);
            add_filter("\143\141\x6c\x64\145\162\x61\137\146\157\162\x6d\163\137\163\x75\x62\155\x69\164\137\162\145\x74\165\162\x6e\137\164\162\x61\x6e\x73\x69\x65\x6e\x74", array($this, "\x75\x6e\163\x65\x74\x53\x65\x73\163\x69\x6f\x6e\126\141\x72\x69\x61\x62\154\145"), 99, 1);
            gu:
        }
        cy:
        add_action("\x77\x70\137\141\x6a\x61\x78\x5f{$this->_generateOTPAction}", array($this, "\137\163\145\x6e\x64\137\157\164\160"));
        add_action("\167\x70\137\x61\x6a\141\x78\x5f\156\157\x70\x72\x69\x76\137{$this->_generateOTPAction}", array($this, "\x5f\x73\145\156\x64\x5f\157\x74\160"));
        add_action("\167\160\137\x65\x6e\161\165\x65\x75\x65\137\163\x63\x72\x69\x70\164\163", array($this, "\155\151\x6e\x69\157\x72\141\x6e\x67\145\137\162\145\x67\x69\x73\164\145\x72\x5f\x63\x61\x6c\144\145\162\x61\x5f\163\143\x72\151\160\x74"));
    }
    function unsetSessionVariable($Ym)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto WE;
        }
        $this->unsetOTPSessionVariables();
        WE:
        return $Ym;
    }
    function miniorange_register_caldera_script()
    {
        wp_register_script("\155\x6f\x63\141\154\x64\145\x72\x61", MOV_URL . "\151\x6e\x63\x6c\x75\144\x65\163\57\x6a\163\57\143\141\154\144\x65\162\141\56\x6d\151\156\x2e\x6a\x73", array("\152\x71\165\145\162\171"));
        wp_localize_script("\155\x6f\143\x61\x6c\x64\x65\162\141", "\155\157\143\141\154\144\x65\162\141", array("\x73\x69\164\x65\125\122\114" => wp_ajax_url(), "\157\x74\x70\124\x79\160\x65" => $this->_otpType, "\146\157\162\x6d\153\x65\171" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\160\150\x6f\x6e\145\153\145\171" : "\x65\155\x61\151\x6c\x6b\x65\x79", "\x6e\x6f\156\x63\145" => wp_create_nonce($this->_nonce), "\142\x75\164\164\157\x6e\164\145\x78\164" => mo_($this->_buttonText), "\x69\155\x67\125\x52\x4c" => MOV_LOADER_URL, "\x66\157\162\x6d\x73" => $this->_formDetails, "\147\145\156\145\162\141\164\x65\x55\x52\114" => $this->_generateOTPAction));
        wp_enqueue_script("\155\x6f\x63\x61\x6c\x64\x65\x72\141");
    }
    function _send_otp()
    {
        $pO = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Bf;
        }
        $this->_processEmailAndStartOTPVerificationProcess($pO);
        goto Nb;
        Bf:
        $this->_processPhoneAndStartOTPVerificationProcess($pO);
        Nb:
    }
    private function _processEmailAndStartOTPVerificationProcess($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\x65\x72\x5f\x65\155\x61\151\x6c", $pO)) {
            goto iP;
        }
        $this->setSessionAndStartOTPVerification($pO["\x75\163\145\x72\137\x65\155\141\151\154"], $pO["\165\x73\145\x72\x5f\x65\155\141\x69\154"], NULL, VerificationType::EMAIL);
        goto xE;
        iP:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        xE:
    }
    private function _processPhoneAndStartOTPVerificationProcess($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\x65\162\x5f\160\x68\x6f\156\x65", $pO)) {
            goto OH;
        }
        $this->setSessionAndStartOTPVerification(trim($pO["\165\x73\145\x72\137\x70\150\x6f\x6e\x65"]), NULL, trim($pO["\x75\x73\145\162\x5f\x70\150\157\156\x65"]), VerificationType::PHONE);
        goto Ri;
        OH:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Ri:
    }
    private function setSessionAndStartOTPVerification($ZI, $TK, $Zu, $AX)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar, $ZI, $AX);
        $this->sendChallenge('', $TK, NULL, $Zu, $AX);
    }
    public function validateForm($w8, $Pj, $form)
    {
        if (!is_wp_error($w8)) {
            goto TI;
        }
        return $w8;
        TI:
        $D5 = $form["\111\x44"];
        if (array_key_exists($D5, $this->_formDetails)) {
            goto Jo;
        }
        return $w8;
        Jo:
        $VJ = $this->_formDetails[$D5];
        $w8 = $this->checkIfOtpVerificationStarted($w8);
        if (!is_wp_error($w8)) {
            goto Db;
        }
        return $w8;
        Db:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 && strcasecmp($Pj["\111\x44"], $VJ["\145\x6d\x61\x69\x6c\153\145\x79"]) == 0) {
            goto Ha;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && strcasecmp($Pj["\x49\x44"], $VJ["\x70\x68\x6f\x6e\145\153\145\171"]) == 0) {
            goto qe;
        }
        if (empty($errors) && strcasecmp($Pj["\111\x44"], $VJ["\x76\145\162\x69\x66\171\113\x65\171"]) == 0) {
            goto Dm;
        }
        goto sM;
        Ha:
        $w8 = $this->processEmail($w8);
        goto sM;
        qe:
        $w8 = $this->processPhone($w8);
        goto sM;
        Dm:
        $w8 = $this->processOTPEntered($w8);
        sM:
        return $w8;
    }
    function processOTPEntered($w8)
    {
        $HV = $this->getVerificationType();
        $this->validateChallenge($HV, NULL, $w8);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto HA;
        }
        $w8 = new WP_Error("\111\116\x56\101\114\x49\x44\137\x4f\x54\x50", MoUtility::_get_invalid_otp_method());
        HA:
        return $w8;
    }
    function checkIfOtpVerificationStarted($w8)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $w8 : new WP_Error("\105\x4e\x54\x45\122\137\x56\x45\x52\111\106\131\137\103\117\104\x45", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
    }
    function processEmail($w8)
    {
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $w8) ? $w8 : new WP_Error("\105\x4d\x41\x49\114\x5f\115\x49\x53\115\101\124\x43\110", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
    }
    function processPhone($w8)
    {
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $w8) ? $w8 : new WP_Error("\120\x48\117\x4e\x45\137\115\x49\x53\x4d\x41\x54\x43\x48", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
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
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto vL;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        vL:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto nn;
        }
        return;
        nn:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\141\x6c\x64\x65\162\x61\137\145\x6e\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\143\x61\x6c\144\x65\x72\x61\x5f\x65\x6e\x61\x62\x6c\x65\x5f\x74\x79\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x63\141\154\x64\145\162\x61\x5f\x62\x75\164\164\157\156\137\164\145\170\x74");
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x63\x61\x6c\x64\x65\x72\x61\137\x65\x6e\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\143\141\x6c\x64\145\x72\141\x5f\145\x6e\141\x62\x6c\x65\137\x74\171\160\145", $this->_otpType);
        update_mo_option("\143\141\154\144\145\162\x61\x5f\x62\165\x74\x74\157\156\137\x74\145\170\164", $this->_buttonText);
        update_mo_option("\143\x61\154\x64\145\x72\x61\137\x66\x6f\162\155\x73", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (!(!array_key_exists("\x63\141\154\144\145\x72\141\137\146\x6f\162\x6d", $_POST) || !$this->_isFormEnabled)) {
            goto CR;
        }
        return $form;
        CR:
        foreach (array_filter($_POST["\x63\x61\154\x64\x65\162\141\137\x66\157\162\155"]["\x66\157\x72\x6d"]) as $Zm => $zs) {
            $form[$zs] = array("\x65\x6d\141\x69\154\x6b\x65\x79" => $_POST["\143\141\154\144\145\162\141\137\x66\157\162\155"]["\x65\x6d\x61\151\x6c\x6b\x65\171"][$Zm], "\x70\x68\x6f\x6e\145\x6b\x65\171" => $_POST["\x63\x61\154\144\x65\162\141\137\x66\x6f\162\155"]["\160\x68\x6f\x6e\x65\x6b\x65\x79"][$Zm], "\166\145\162\151\x66\171\x4b\145\171" => $_POST["\143\141\x6c\144\145\x72\141\137\146\x6f\162\155"]["\166\x65\x72\151\x66\171\x4b\x65\171"][$Zm], "\x70\150\x6f\x6e\145\137\163\150\x6f\167" => $_POST["\x63\x61\154\144\145\162\141\x5f\x66\x6f\162\x6d"]["\160\150\157\156\x65\153\x65\x79"][$Zm], "\145\x6d\x61\x69\x6c\137\163\150\x6f\167" => $_POST["\x63\x61\x6c\144\x65\x72\141\x5f\x66\x6f\x72\155"]["\145\155\141\x69\x6c\x6b\145\171"][$Zm], "\x76\145\162\151\x66\x79\x5f\163\150\157\167" => $_POST["\x63\141\154\x64\x65\x72\141\137\146\157\162\x6d"]["\166\145\x72\151\x66\x79\113\145\171"][$Zm]);
            Ea:
        }
        Ic:
        return $form;
    }
}
