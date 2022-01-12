<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class YourOwnForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formKey = "\131\x4f\125\x52\x5f\x4f\x57\116\x5f\106\117\122\115";
        $this->_formName = mo_("\74\x73\x70\141\x6e\40\x73\164\x79\154\x65\x3d\x27\x63\157\154\157\162\x3a\147\x72\x65\x65\x6e\47\40\x3e\74\142\x3e\x43\x61\156\47\164\40\106\151\156\144\x20\x79\x6f\165\162\x20\106\157\162\x6d\77\40\x54\162\x79\x20\155\x65\41\74\x2f\x62\x3e\x3c\x2f\x73\x70\x61\156\76");
        $this->_formSessionVar = FormSessionVars::CUSTOMFORM;
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\x75\x73\164\157\x6d\137\x66\x6f\x72\155\137\157\164\160\x5f\145\x6e\x61\x62\154\145\x64"));
        $this->_typePhoneTag = "\x6d\x6f\137\x63\165\163\x74\157\x6d\x46\157\x72\155\x5f\160\x68\x6f\x6e\145\x5f\145\x6e\x61\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\x5f\x63\x75\163\164\157\155\106\157\x72\155\x5f\x65\x6d\x61\x69\154\137\x65\x6e\141\x62\154\x65";
        $this->_isFormEnabled = get_mo_option("\x63\x75\x73\164\x6f\155\137\x66\157\162\x6d\137\143\157\156\164\141\x63\164\x5f\145\156\141\142\154\x65");
        $this->_generateOTPAction = "\155\151\x6e\151\157\x72\141\x6e\147\x65\x2d\x63\x75\163\164\157\x6d\x46\157\x72\155\55\163\145\x6e\144\x2d\x6f\x74\160";
        $this->_validateOTPAction = "\155\x69\156\151\157\162\x61\x6e\147\145\x2d\143\165\163\164\157\155\106\x6f\x72\155\55\166\145\x72\x69\146\x79\x2d\143\x6f\144\145";
        $this->_checkValidatedOnSubmit = "\155\x69\x6e\x69\157\162\x61\156\147\x65\x2d\143\x75\163\x74\157\x6d\106\157\162\x6d\55\x76\145\162\x69\x66\171\55\163\165\142\155\151\x74";
        $this->_otpType = get_mo_option("\x63\x75\163\x74\x6f\155\x5f\x66\x6f\162\155\x5f\x65\156\x61\142\154\145\137\164\x79\160\145");
        $this->_buttonText = get_mo_option("\143\x75\163\164\157\155\x5f\x66\157\x72\155\x5f\142\165\x74\164\157\x6e\x5f\x74\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\x6b\x20\110\145\162\145\40\x74\157\x20\163\x65\x6e\144\40\117\124\x50");
        $this->validated = FALSE;
        parent::__construct();
        $this->handleForm();
    }
    function handleForm()
    {
        MoPHPSessions::checkSession();
        if ($this->_isFormEnabled) {
            goto Fa;
        }
        return;
        Fa:
        $this->_formFieldId = $this->getFieldKeyDetails();
        $this->_formSubmitId = $this->getSubmitKeyDetails();
        add_action("\x77\160\x5f\x65\156\x71\x75\145\x75\x65\x5f\163\143\x72\151\x70\x74\x73", array($this, "\155\157\137\x65\x6e\x71\x75\145\x75\145\x5f\146\x6f\x72\x6d\x5f\x73\x63\x72\151\160\164"));
        add_action("\x6c\x6f\x67\151\156\x5f\145\156\x71\165\145\x75\x65\x5f\163\x63\162\x69\x70\164\163", array($this, "\155\x6f\x5f\145\x6e\x71\165\x65\x75\145\137\146\x6f\x72\155\137\x73\x63\x72\151\x70\164"));
        add_action("\x77\160\137\x61\x6a\x61\x78\x5f{$this->_generateOTPAction}", array($this, "\x5f\163\145\x6e\144\x5f\x6f\164\160"));
        add_action("\x77\x70\137\x61\152\x61\170\137\x6e\157\160\x72\x69\166\137{$this->_generateOTPAction}", array($this, "\137\x73\145\x6e\x64\x5f\157\x74\x70"));
        add_action("\x77\x70\137\x61\x6a\x61\x78\137{$this->_validateOTPAction}", array($this, "\160\x72\x6f\x63\x65\163\x73\106\x6f\162\155\x41\x6e\144\126\141\154\x69\144\141\164\x65\x4f\124\120"));
        add_action("\x77\x70\137\x61\x6a\x61\x78\x5f\x6e\x6f\x70\162\151\x76\x5f{$this->_validateOTPAction}", array($this, "\x70\x72\157\143\x65\x73\163\x46\x6f\162\x6d\x41\156\144\x56\x61\x6c\x69\144\x61\x74\145\x4f\x54\x50"));
        add_action("\167\160\x5f\x61\x6a\141\170\x5f{$this->_checkValidatedOnSubmit}", array($this, "\137\143\x68\145\143\x6b\x56\141\154\x69\x64\141\x74\x65\144\x4f\156\x53\x75\142\x6d\151\164"));
        add_action("\167\x70\137\141\x6a\x61\x78\x5f\x6e\x6f\x70\162\x69\166\x5f{$this->_checkValidatedOnSubmit}", array($this, "\137\x63\x68\145\x63\153\x56\141\x6c\x69\x64\141\x74\x65\144\x4f\x6e\x53\x75\142\x6d\x69\164"));
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Dw;
        }
        $this->validated = TRUE;
        $this->unsetOTPSessionVariables();
        return;
        Dw:
    }
    function mo_enqueue_form_script()
    {
        wp_register_script($this->_formSessionVar, MOV_URL . "\x69\156\x63\x6c\165\x64\145\x73\57\152\x73\x2f" . $this->_formSessionVar . "\56\152\163", array("\x6a\x71\x75\x65\x72\171"));
        wp_localize_script($this->_formSessionVar, $this->_formSessionVar, array("\x73\151\164\x65\125\x52\114" => wp_ajax_url(), "\x6f\164\x70\124\x79\x70\145" => $this->getVerificationType(), "\146\x6f\x72\x6d\104\x65\164\x61\151\x6c\x73" => $this->_formDetails, "\x62\x75\x74\x74\x6f\x6e\x74\145\x78\164" => $this->_buttonText, "\151\155\147\x55\122\114" => MOV_LOADER_URL, "\146\151\x65\154\x64\x54\x65\x78\x74" => mo_("\x45\156\164\x65\162\x20\117\124\120\x20\150\x65\162\145"), "\147\x6e\157\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\x6e\x6f\x6e\143\145\x4b\x65\x79" => wp_create_nonce($this->_nonceKey), "\x76\x6e\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\147\x61\143\164\151\157\x6e" => $this->_generateOTPAction, "\x76\x61\x63\x74\151\157\156" => $this->_validateOTPAction, "\163\141\x63\164\151\x6f\x6e" => $this->_checkValidatedOnSubmit, "\x66\151\x65\x6c\x64\x53\x65\154\x65\x63\164\157\x72" => $this->_formFieldId, "\x73\x75\142\x6d\151\164\x53\145\154\x65\143\x74\x6f\162" => $this->_formSubmitId));
        wp_enqueue_script($this->_formSessionVar);
        wp_enqueue_style("\x6d\157\x5f\x66\x6f\x72\x6d\x73\x5f\143\x73\x73", MOV_FORM_CSS);
    }
    function _send_otp()
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto k0;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        k0:
        if (!(MoUtility::sanitizeCheck("\157\164\x70\124\x79\x70\145", $_POST) === VerificationType::PHONE)) {
            goto zd;
        }
        $this->_processPhoneAndSendOTP($_POST);
        zd:
        if (!(MoUtility::sanitizeCheck("\x6f\x74\x70\x54\x79\x70\x65", $_POST) === VerificationType::EMAIL)) {
            goto uH;
        }
        $this->_processEmailAndSendOTP($_POST);
        uH:
    }
    public function _checkValidatedOnSubmit()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar) || $this->validated) {
            goto Xe;
        }
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) && !$this->validated)) {
            goto eJ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        eJ:
        goto C7;
        Xe:
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        C7:
    }
    private function _processEmailAndSendOTP($pO)
    {
        MoPHPSessions::checkSession();
        if (!MoUtility::sanitizeCheck("\x75\x73\145\x72\137\145\x6d\141\x69\154", $pO)) {
            goto sa;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\165\x73\x65\x72\137\145\x6d\x61\x69\x6c"]);
        $this->sendChallenge('', $pO["\165\x73\x65\x72\137\x65\155\141\151\x6c"], NULL, NULL, VerificationType::EMAIL);
        goto ur;
        sa:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        ur:
    }
    private function _processPhoneAndSendOTP($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\162\x5f\160\x68\157\x6e\145", $pO)) {
            goto tG;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $pO["\x75\163\x65\x72\x5f\160\150\x6f\x6e\x65"]);
        $this->sendChallenge('', NULL, NULL, $pO["\x75\163\145\162\x5f\160\150\157\156\x65"], VerificationType::PHONE);
        goto q1;
        tG:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        q1:
    }
    function processFormAndValidateOTP()
    {
        MoPHPSessions::checkSession();
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto iM;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        iM:
    }
    private function checkIntegrityAndValidateOTP($pO)
    {
        MoPHPSessions::checkSession();
        $this->checkIntegrity($pO);
        $this->validateChallenge($pO["\157\x74\160\124\171\x70\145"], NULL, $pO["\x6f\164\x70\x5f\164\x6f\153\145\x6e"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $pO["\x6f\164\x70\x54\x79\160\145"])) {
            goto b7;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        goto yv;
        b7:
        if (!($pO["\x6f\164\160\124\171\160\145"] === VerificationType::PHONE)) {
            goto Qy;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $pO["\165\163\x65\162\x5f\160\150\157\x6e\x65"]);
        Qy:
        if (!($pO["\x6f\164\160\x54\x79\160\145"] === VerificationType::EMAIL)) {
            goto zj;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $pO["\165\163\145\162\x5f\145\x6d\141\151\154"]);
        zj:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        yv:
    }
    private function checkIntegrity($pO)
    {
        if (!($pO["\x6f\164\160\124\171\160\145"] === VerificationType::PHONE)) {
            goto RS;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $pO["\x75\163\145\162\137\x70\x68\x6f\x6e\x65"])) {
            goto n8;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        n8:
        RS:
        if (!($pO["\157\164\160\124\x79\160\145"] === VerificationType::EMAIL)) {
            goto PN;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $pO["\165\x73\x65\x72\x5f\145\155\141\151\154"])) {
            goto sk;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        sk:
        PN:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto qQ;
        }
        return;
        qQ:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Ne;
        }
        return;
        Ne:
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    public function unsetOTPSessionVariables()
    {
        MoPHPSessions::checkSession();
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneEnabled())) {
            goto ni;
        }
        array_push($zX, $this->_formFieldId);
        ni:
        return $zX;
    }
    function isPhoneEnabled()
    {
        return $this->getVerificationType() == VerificationType::PHONE ? TRUE : FALSE;
    }
    private function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x63\x75\x73\x74\x6f\155\x5f\x66\157\x72\x6d", $_POST)) {
            goto Y6;
        }
        return array();
        Y6:
        $lr = $_POST["\x6d\x6f\x5f\143\x75\x73\x74\157\155\145\x72\x5f\x76\141\x6c\151\144\141\x74\151\157\x6e\x5f\143\x75\x73\x74\x6f\155\x5f\146\x6f\x72\x6d\137\145\156\x61\x62\154\x65\x5f\x74\171\160\x65"] == $this->_typePhoneTag ? "\160\150\x6f\156\145" : "\x65\155\x61\x69\x6c";
        foreach (array_filter($_POST["\x63\x75\x73\x74\157\155\x5f\146\x6f\x72\155"]["\146\x6f\162\155"]) as $Zm => $zs) {
            $form[$zs] = array("\x73\165\142\x6d\151\164\x5f\151\x64" => $_POST["\x63\165\163\164\157\x6d\137\x66\x6f\162\155"][$lr]["\163\165\x62\x6d\151\164\137\x69\144"], "\146\x69\145\154\144\137\151\x64" => $_POST["\x63\x75\163\x74\157\x6d\x5f\x66\x6f\162\x6d"][$lr]["\x66\151\145\154\x64\x5f\x69\144"]);
            m3:
        }
        wB:
        return $form;
    }
    function handleFormOptions()
    {
        $form = $this->parseFormDetails();
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Ae;
        }
        return;
        Ae:
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\x75\x73\x74\x6f\x6d\137\x66\157\x72\155\137\143\x6f\x6e\x74\141\143\164\137\145\156\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\143\x75\x73\164\x6f\155\x5f\146\157\x72\155\137\x65\156\x61\x62\x6c\x65\137\164\x79\160\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x63\165\x73\x74\x6f\x6d\x5f\x66\157\x72\x6d\x5f\142\x75\x74\x74\157\156\x5f\x74\145\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::CUSTOM_CHOOSE)) {
            goto w3;
        }
        update_mo_option("\x63\165\163\164\157\155\x5f\146\x6f\x72\x6d\x5f\157\x74\x70\137\145\x6e\141\x62\154\x65\144", maybe_serialize($this->_formDetails));
        update_mo_option("\x63\165\163\164\157\155\x5f\x66\x6f\162\155\137\143\157\x6e\164\141\143\164\x5f\x65\156\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x63\x75\x73\164\x6f\x6d\137\x66\x6f\x72\x6d\x5f\145\x6e\141\x62\x6c\145\x5f\164\171\x70\x65", $this->_otpType);
        update_mo_option("\143\x75\x73\x74\157\155\x5f\x66\x6f\x72\x6d\137\x62\x75\164\164\x6f\x6e\137\164\145\170\164", $this->_buttonText);
        w3:
    }
    function getSubmitKeyDetails()
    {
        if (!empty($this->_formDetails)) {
            goto MT;
        }
        return;
        MT:
        return stripcslashes($this->_formDetails[1]["\x73\165\x62\155\151\164\x5f\x69\144"]);
    }
    function getFieldKeyDetails()
    {
        if (!empty($this->_formDetails)) {
            goto qZ;
        }
        return;
        qZ:
        return stripcslashes($this->_formDetails[1]["\x66\x69\145\154\x64\x5f\x69\x64"]);
    }
}
