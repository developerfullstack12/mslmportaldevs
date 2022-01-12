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
class DocDirectThemeRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::DOCDIRECT_REG;
        $this->_typePhoneTag = "\x6d\157\137\x64\157\143\x64\x69\x72\x65\143\x74\x5f\x70\x68\157\156\x65\137\x65\156\141\142\154\145";
        $this->_typeEmailTag = "\x6d\157\x5f\x64\157\x63\x64\x69\x72\145\143\164\137\145\x6d\x61\151\154\137\x65\156\x61\x62\x6c\x65";
        $this->_formKey = "\x44\x4f\x43\104\x49\122\x45\103\x54\137\124\x48\x45\x4d\x45";
        $this->_formName = mo_("\104\x6f\143\x20\x44\151\x72\x65\143\164\40\x54\x68\x65\155\x65\x20\142\171\40\124\150\145\155\157\107\162\x61\x70\150\151\x63\x73");
        $this->_isFormEnabled = get_mo_option("\144\157\143\144\151\162\x65\x63\x74\137\x65\x6e\x61\142\154\145");
        $this->_phoneFormId = "\151\156\x70\x75\x74\x5b\156\x61\x6d\x65\x3d\x70\150\x6f\x6e\145\137\x6e\x75\x6d\142\x65\162\x5d";
        $this->_formDocuments = MoOTPDocs::DOCDIRECT_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x64\157\143\x64\151\162\145\x63\164\137\x65\x6e\x61\x62\154\x65\137\164\171\160\145");
        add_action("\x77\160\137\145\156\161\165\x65\165\x65\x5f\163\143\162\x69\x70\164\163", array($this, "\141\144\x64\123\x63\x72\151\x70\x74\x54\157\x52\x65\147\151\163\x74\x72\x61\x74\151\157\x6e\120\x61\147\145"));
        add_action("\167\x70\137\x61\x6a\x61\x78\137\144\157\x63\x64\151\162\x65\143\x74\x5f\165\163\145\x72\x5f\x72\145\147\x69\163\164\162\141\164\151\x6f\x6e", array($this, "\x6d\x6f\137\x76\x61\154\151\x64\x61\164\145\137\144\x6f\143\144\151\x72\145\x63\164\x5f\x75\x73\145\x72\137\x72\145\147\151\163\164\x72\141\x74\151\157\156"), 1);
        add_action("\167\160\137\x61\x6a\141\170\137\156\157\x70\x72\151\166\137\x64\157\x63\x64\x69\162\x65\143\164\137\165\x73\x65\162\137\162\145\x67\151\163\164\162\x61\164\151\157\x6e", array($this, "\x6d\x6f\137\166\141\x6c\x69\x64\x61\164\145\137\144\x6f\143\144\151\162\145\143\x74\x5f\x75\163\145\x72\137\162\x65\x67\151\x73\164\x72\141\164\x69\x6f\156"), 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\x69\157\156", $_GET)) {
            goto zB;
        }
        return;
        zB:
        switch (trim($_GET["\x6f\x70\x74\151\x6f\x6e"])) {
            case "\155\x69\x6e\151\157\162\141\x6e\147\x65\x2d\x64\157\143\144\x69\162\x65\143\164\55\x76\145\x72\x69\146\171":
                $this->startOTPVerificationProcess($_POST);
                goto PD;
        }
        Dz:
        PD:
    }
    function addScriptToRegistrationPage()
    {
        wp_register_script("\144\157\x63\x64\x69\x72\x65\143\164", MOV_URL . "\x69\156\143\154\x75\x64\x65\163\x2f\x6a\x73\57\x64\157\143\144\x69\x72\x65\x63\x74\x2e\155\151\156\56\152\x73\x3f\166\145\162\163\x69\157\156\75" . MOV_VERSION, array("\x6a\x71\x75\x65\162\171"), MOV_VERSION, true);
        wp_localize_script("\x64\x6f\x63\144\151\x72\145\143\x74", "\155\x6f\144\157\x63\144\151\162\145\143\x74", array("\x69\155\x67\x55\122\114" => MOV_URL . "\151\x6e\143\154\165\x64\x65\x73\x2f\x69\155\x61\147\x65\163\57\x6c\x6f\141\x64\x65\x72\x2e\147\151\146", "\142\x75\x74\x74\x6f\156\124\145\x78\164" => mo_("\x43\x6c\x69\x63\x6b\40\x48\x65\162\145\x20\x74\157\40\126\x65\x72\x69\x66\171\40\131\157\x75\x72\163\145\x6c\146"), "\151\x6e\163\x65\162\164\101\x66\164\145\x72" => strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x69\x6e\160\x75\x74\x5b\156\x61\x6d\x65\x3d\x70\150\157\x6e\145\137\x6e\165\155\x62\145\162\135" : "\x69\156\x70\x75\x74\133\x6e\x61\155\x65\x3d\x65\155\x61\x69\154\135", "\x70\154\141\143\145\110\157\x6c\144\145\162" => mo_("\117\124\x50\x20\x43\157\144\x65"), "\x73\x69\164\145\x55\122\114" => site_url()));
        wp_enqueue_script("\x64\x6f\x63\x64\x69\162\x65\143\x74");
    }
    function startOtpVerificationProcess($pO)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto N8;
        }
        $this->_send_otp_to_email($pO);
        goto GR;
        N8:
        $this->_send_otp_to_phone($pO);
        GR:
    }
    function _send_otp_to_phone($pO)
    {
        if (array_key_exists("\x75\x73\x65\x72\137\160\150\157\x6e\x65", $pO) && !MoUtility::isBlank($pO["\165\163\145\162\137\x70\150\x6f\x6e\145"])) {
            goto MY;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Eu;
        MY:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($pO["\x75\163\x65\x72\137\x70\150\x6f\x6e\x65"]));
        $this->sendChallenge("\x74\145\163\164", '', null, trim($pO["\x75\163\145\162\137\160\150\157\x6e\145"]), VerificationType::PHONE);
        Eu:
    }
    function _send_otp_to_email($pO)
    {
        if (array_key_exists("\165\163\145\x72\x5f\145\x6d\x61\151\x6c", $pO) && !MoUtility::isBlank($pO["\x75\163\145\x72\137\x65\155\141\151\x6c"])) {
            goto Oa;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto zm;
        Oa:
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\165\x73\x65\x72\137\x65\x6d\141\x69\154"]);
        $this->sendChallenge("\x74\145\x73\x74", $pO["\165\x73\145\162\137\x65\155\x61\151\154"], null, $pO["\x75\x73\145\162\137\145\x6d\141\x69\x6c"], VerificationType::EMAIL);
        zm:
    }
    function mo_validate_docdirect_user_registration()
    {
        $this->checkIfVerificationNotStarted();
        $this->checkIfVerificationCodeNotEntered();
        $this->handle_otp_token_submitted();
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto TG;
        }
        echo json_encode(array("\x74\x79\x70\145" => "\145\x72\x72\157\162", "\155\x65\x73\163\141\x67\145" => MoMessages::showMessage(MoMessages::DOC_DIRECT_VERIFY)));
        die;
        TG:
    }
    function checkIfVerificationCodeNotEntered()
    {
        if (!(!array_key_exists("\x6d\x6f\x5f\166\x65\162\151\146\x79", $_POST) || MoUtility::isBlank($_POST["\155\157\137\166\145\162\x69\x66\171"]))) {
            goto sU;
        }
        echo json_encode(array("\x74\x79\x70\145" => "\145\162\162\157\x72", "\155\x65\x73\x73\141\147\x65" => MoMessages::showMessage(MoMessages::DCD_ENTER_VERIFY_CODE)));
        die;
        sU:
    }
    function handle_otp_token_submitted()
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto WF;
        }
        $this->processEmail();
        goto uJ;
        WF:
        $this->processPhoneNumber();
        uJ:
        $this->validateChallenge($this->getVerificationType(), "\155\157\x5f\166\145\162\x69\x66\x79", NULL);
    }
    function processPhoneNumber()
    {
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\160\150\x6f\x6e\x65\x5f\156\x75\155\142\x65\162"])) {
            goto Ej;
        }
        echo json_encode(array("\x74\x79\160\145" => "\145\x72\x72\x6f\x72", "\155\145\163\x73\x61\147\145" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        die;
        Ej:
    }
    function processEmail()
    {
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\145\155\x61\x69\154"])) {
            goto ir;
        }
        echo json_encode(array("\164\171\x70\x65" => "\x65\x72\162\x6f\x72", "\x6d\145\x73\163\141\147\145" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        die;
        ir:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto It;
        }
        return;
        It:
        echo json_encode(array("\x74\171\160\145" => "\x65\162\162\x6f\x72", "\155\x65\163\x73\141\147\x65" => MoUtility::_get_invalid_otp_method()));
        die;
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto Jq;
        }
        array_push($zX, $this->_phoneFormId);
        Jq:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto fB;
        }
        return;
        fB:
        $this->_otpType = $this->sanitizeFormPOST("\x64\157\x63\144\x69\x72\145\143\164\137\x65\x6e\x61\x62\154\x65\x5f\x74\x79\x70\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\144\x6f\143\x64\x69\162\x65\x63\164\137\145\x6e\x61\142\154\x65");
        update_mo_option("\x64\x6f\143\144\151\162\145\x63\164\x5f\145\x6e\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x64\x6f\x63\144\151\162\145\x63\164\x5f\x65\156\x61\142\154\x65\x5f\164\x79\x70\145", $this->_otpType);
    }
}
