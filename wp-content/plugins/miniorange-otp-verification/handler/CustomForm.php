<?php


namespace OTP\Handler;

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
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class CustomForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->isEnabled = get_mo_option("\143\x66\x5f\x73\165\x62\155\x69\x74\x5f\x69\x64", "\x6d\x6f\137\157\164\160\137") ? true : false;
        $this->_formSessionVar = FormSessionVars::CUSTOMFORM;
        $this->_typePhoneTag = "\x6d\x6f\137\143\165\163\x74\x6f\155\106\157\x72\x6d\x5f\x70\x68\157\156\x65\137\145\156\x61\142\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\x63\165\x73\x74\x6f\x6d\106\157\162\155\137\x65\x6d\141\151\154\137\145\156\141\142\154\x65";
        $this->_isFormEnabled = $this->isEnabled;
        $this->_phoneFormId = stripslashes(get_mo_option("\x63\146\137\146\x69\145\x6c\144\137\x69\144", "\155\x6f\x5f\157\x74\160\137"));
        $this->_generateOTPAction = "\155\x69\156\151\157\162\x61\156\x67\145\x2d\x63\x75\163\164\157\155\106\157\x72\155\x2d\x73\x65\x6e\144\x2d\157\x74\x70";
        $this->_validateOTPAction = "\x6d\x69\x6e\x69\157\162\141\156\147\x65\55\143\165\163\164\157\x6d\106\157\x72\x6d\x2d\x76\145\162\151\146\x79\x2d\143\157\144\x65";
        $this->_checkValidatedOnSubmit = "\x6d\151\x6e\x69\x6f\x72\141\x6e\147\145\55\143\x75\x73\x74\157\155\x46\157\x72\155\55\x76\145\x72\151\x66\171\55\163\x75\142\155\151\x74";
        $this->_otpType = get_mo_option("\x63\x66\137\x65\156\x61\142\154\145\137\x74\171\x70\x65", "\x6d\x6f\137\x6f\164\x70\x5f");
        $this->_buttonText = get_mo_option("\x63\146\137\x62\165\x74\164\157\156\137\164\x65\x78\164", "\x6d\157\x5f\x6f\164\x70\137");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\x69\143\153\40\110\x65\162\x65\40\164\157\x20\x73\x65\x6e\144\x20\117\124\x50");
        $this->validated = FALSE;
        parent::__construct();
        $this->handleForm();
    }
    function handleForm()
    {
        MoPHPSessions::checkSession();
        if ($this->isEnabled) {
            goto HDj;
        }
        return;
        HDj:
        add_action("\167\160\x5f\145\156\161\165\145\165\x65\137\163\x63\162\x69\160\164\x73", array($this, "\155\x6f\x5f\145\x6e\161\165\145\165\145\x5f\146\x6f\x72\155\137\163\x63\x72\x69\160\x74"));
        add_action("\x6c\157\147\x69\156\137\x65\x6e\161\165\x65\x75\145\x5f\163\143\x72\151\x70\x74\x73", array($this, "\x6d\x6f\137\145\x6e\161\165\145\165\145\137\146\157\162\x6d\137\x73\x63\x72\x69\x70\164"));
        add_action("\x77\160\x5f\141\x6a\141\x78\137{$this->_generateOTPAction}", array($this, "\x5f\163\x65\x6e\144\x5f\157\x74\160"));
        add_action("\x77\160\137\x61\152\141\170\137\156\x6f\x70\x72\151\166\x5f{$this->_generateOTPAction}", array($this, "\137\x73\145\156\x64\x5f\157\164\160"));
        add_action("\167\160\137\x61\x6a\x61\x78\x5f{$this->_validateOTPAction}", array($this, "\x70\162\x6f\143\x65\163\x73\x46\x6f\x72\x6d\x41\156\x64\126\141\154\151\144\x61\164\x65\117\124\x50"));
        add_action("\x77\x70\137\x61\x6a\141\170\x5f\x6e\x6f\160\x72\x69\x76\137{$this->_validateOTPAction}", array($this, "\x70\162\157\x63\145\163\x73\106\x6f\162\x6d\101\156\144\126\141\154\x69\x64\x61\x74\145\x4f\124\120"));
        add_action("\x77\x70\x5f\141\152\x61\x78\137{$this->_checkValidatedOnSubmit}", array($this, "\137\143\x68\145\x63\x6b\126\x61\154\151\144\x61\x74\145\x64\117\156\x53\165\x62\x6d\x69\164"));
        add_action("\167\160\x5f\x61\x6a\x61\170\x5f\x6e\x6f\160\x72\x69\166\x5f{$this->_checkValidatedOnSubmit}", array($this, "\137\x63\x68\x65\x63\x6b\x56\x61\x6c\x69\144\x61\x74\145\x64\x4f\156\123\x75\x62\155\151\164"));
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto rW2;
        }
        $this->validated = TRUE;
        $this->unsetOTPSessionVariables();
        return;
        rW2:
    }
    function mo_enqueue_form_script()
    {
        wp_register_script($this->_formSessionVar, MOV_URL . "\151\x6e\143\x6c\165\x64\x65\x73\x2f\x6a\163\57" . $this->_formSessionVar . "\x2e\152\x73", array("\x6a\x71\x75\145\x72\x79"));
        wp_localize_script($this->_formSessionVar, $this->_formSessionVar, array("\x73\x69\x74\x65\125\x52\114" => wp_ajax_url(), "\157\164\160\124\171\160\x65" => $this->getVerificationType(), "\x66\157\x72\155\x44\x65\164\141\151\x6c\x73" => $this->_formDetails, "\x62\165\x74\x74\x6f\156\164\x65\x78\164" => $this->_buttonText, "\151\x6d\x67\125\x52\114" => MOV_LOADER_URL, "\x66\151\x65\x6c\144\x54\145\x78\x74" => mo_("\x45\x6e\164\x65\x72\x20\x4f\x54\120\40\x68\145\162\145"), "\147\156\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\x6e\157\x6e\x63\x65\x4b\x65\171" => wp_create_nonce($this->_nonceKey), "\x76\x6e\157\x6e\143\145" => wp_create_nonce($this->_nonce), "\147\141\x63\x74\151\x6f\x6e" => $this->_generateOTPAction, "\x76\x61\143\164\151\x6f\156" => $this->_validateOTPAction, "\x66\x69\x65\x6c\x64\x53\145\x6c\x65\143\164\157\162" => stripcslashes(get_mo_option("\x63\x66\x5f\x66\x69\x65\154\144\137\151\144", "\155\x6f\137\x6f\x74\x70\x5f")), "\x73\165\142\x6d\x69\x74\123\x65\x6c\x65\143\x74\x6f\x72" => stripcslashes(get_mo_option("\x63\146\x5f\x73\x75\x62\155\151\x74\x5f\151\x64", "\x6d\x6f\137\157\x74\x70\137")), "\x73\x69\x74\x65\x55\x52\x4c" => wp_ajax_url(), "\x73\141\143\x74\x69\x6f\156" => $this->_checkValidatedOnSubmit));
        wp_enqueue_script($this->_formSessionVar);
        wp_enqueue_style("\155\157\137\x66\157\x72\x6d\163\x5f\x63\163\163", MOV_FORM_CSS);
    }
    function _send_otp()
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto X9h;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        X9h:
        if (!(MoUtility::sanitizeCheck("\157\164\x70\x54\x79\x70\145", $_POST) === VerificationType::PHONE)) {
            goto a2X;
        }
        $this->_processPhoneAndSendOTP($_POST);
        a2X:
        if (!(MoUtility::sanitizeCheck("\x6f\164\x70\x54\171\x70\x65", $_POST) === VerificationType::EMAIL)) {
            goto hBm;
        }
        $this->_processEmailAndSendOTP($_POST);
        hBm:
    }
    public function _checkValidatedOnSubmit()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar) || $this->validated) {
            goto o4K;
        }
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) && !$this->validated)) {
            goto POn;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        POn:
        goto sXS;
        o4K:
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        sXS:
    }
    private function _processEmailAndSendOTP($pO)
    {
        MoPHPSessions::checkSession();
        if (!MoUtility::sanitizeCheck("\x75\163\x65\162\x5f\145\x6d\141\x69\x6c", $pO)) {
            goto rAV;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\165\163\145\162\x5f\x65\155\141\151\154"]);
        $this->sendChallenge('', $pO["\x75\163\x65\x72\x5f\145\x6d\141\151\x6c"], NULL, NULL, VerificationType::EMAIL);
        goto XpS;
        rAV:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        XpS:
    }
    private function _processPhoneAndSendOTP($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\162\x5f\160\x68\x6f\156\x65", $pO)) {
            goto kgz;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $pO["\x75\x73\145\162\137\x70\x68\x6f\x6e\145"]);
        $this->sendChallenge('', NULL, NULL, $pO["\165\163\145\162\137\x70\x68\x6f\x6e\145"], VerificationType::PHONE);
        goto Dru;
        kgz:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Dru:
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
            goto vnV;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        vnV:
    }
    private function checkIntegrityAndValidateOTP($pO)
    {
        MoPHPSessions::checkSession();
        $this->checkIntegrity($pO);
        $this->validateChallenge($pO["\x6f\x74\x70\124\171\160\145"], NULL, $pO["\x6f\164\x70\137\x74\157\x6b\x65\x6e"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $pO["\x6f\x74\160\124\x79\x70\145"])) {
            goto flI;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        goto LiO;
        flI:
        if (!($pO["\x6f\x74\x70\124\x79\x70\145"] === VerificationType::PHONE)) {
            goto C3X;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $pO["\165\163\x65\162\x5f\160\x68\x6f\x6e\145"]);
        C3X:
        if (!($pO["\157\x74\160\124\x79\160\145"] === VerificationType::EMAIL)) {
            goto w7S;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $pO["\x75\x73\145\162\137\145\155\141\151\154"]);
        w7S:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::CUSTOM_FORM_MESSAGE), MoConstants::ERROR_JSON_TYPE));
        LiO:
    }
    private function checkIntegrity($pO)
    {
        if (!($pO["\157\x74\x70\124\171\x70\x65"] === VerificationType::PHONE)) {
            goto Ujq;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $pO["\x75\163\145\x72\x5f\x70\150\x6f\156\145"])) {
            goto Ude;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Ude:
        Ujq:
        if (!($pO["\x6f\164\x70\124\x79\x70\x65"] === VerificationType::EMAIL)) {
            goto GcB;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $pO["\165\163\x65\162\137\145\x6d\141\151\x6c"])) {
            goto l8d;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        l8d:
        GcB:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Yvm;
        }
        return;
        Yvm:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto j6m;
        }
        return;
        j6m:
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
            goto VVS;
        }
        array_push($zX, $this->_phoneFormId);
        VVS:
        return $zX;
    }
    function isPhoneEnabled()
    {
        return $this->getVerificationType() == VerificationType::PHONE ? TRUE : FALSE;
    }
    function handleFormOptions()
    {
    }
    function getSubmitKeyDetails()
    {
        return stripcslashes(get_mo_option("\143\x66\x5f\x73\x75\142\x6d\151\164\x5f\151\144", "\x6d\157\137\x6f\164\160\137"));
    }
    function getFieldKeyDetails()
    {
        return stripcslashes(get_mo_option("\143\x66\137\x66\x69\145\x6c\x64\137\151\x64", "\155\x6f\x5f\x6f\x74\160\x5f"));
    }
}
