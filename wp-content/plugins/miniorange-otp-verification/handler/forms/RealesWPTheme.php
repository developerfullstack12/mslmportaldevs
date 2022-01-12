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
class RealesWPTheme extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::REALESWP_REGISTER;
        $this->_typePhoneTag = "\x6d\157\x5f\162\145\x61\154\x65\163\x5f\x70\150\x6f\156\x65\137\x65\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\162\145\x61\154\x65\x73\137\x65\x6d\141\x69\154\137\x65\x6e\141\x62\x6c\145";
        $this->_phoneFormId = "\x23\160\150\x6f\156\x65\123\151\x67\x6e\x75\160";
        $this->_formKey = "\x52\x45\x41\114\105\x53\x5f\122\105\107\111\123\124\105\122";
        $this->_formName = mo_("\x52\145\141\x6c\x65\x73\x20\127\120\x20\x54\x68\x65\155\145\40\x52\145\147\151\163\164\162\x61\164\x69\157\x6e\x20\x46\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x72\x65\141\x6c\145\163\x5f\x65\156\141\x62\154\145");
        $this->_formDocuments = MoOTPDocs::REALES_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x72\x65\141\x6c\145\163\x5f\145\156\x61\142\x6c\x65\x5f\x74\x79\160\x65");
        add_action("\167\x70\x5f\x65\156\161\x75\x65\165\145\x5f\x73\143\x72\151\160\x74\x73", array($this, "\145\156\161\165\x65\x75\145\x5f\x73\143\x72\151\x70\164\x5f\157\x6e\137\160\x61\x67\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\151\x6f\156", $_GET)) {
            goto dw;
        }
        return;
        dw:
        switch (trim($_GET["\157\x70\164\x69\x6f\x6e"])) {
            case "\155\x69\x6e\x69\157\x72\x61\156\x67\145\55\162\x65\141\x6c\145\163\167\x70\55\166\x65\x72\x69\146\171":
                $this->_send_otp_realeswp_verify($_POST);
                goto Zm;
            case "\155\x69\156\151\x6f\x72\141\x6e\x67\x65\x2d\166\x61\154\151\144\141\x74\145\x2d\x72\145\x61\154\x65\x73\167\160\55\157\x74\160":
                $this->_reales_validate_otp($_POST);
                goto Zm;
        }
        ts:
        Zm:
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\x72\145\x61\154\145\163\x77\x70\123\x63\x72\x69\x70\164", MOV_URL . "\x69\156\143\x6c\165\144\x65\163\57\152\163\57\x72\x65\141\x6c\x65\163\x77\160\x2e\x6d\x69\156\56\152\x73\x3f\x76\145\x72\x73\151\x6f\156\75" . MOV_VERSION, array("\152\161\165\145\x72\171"));
        wp_localize_script("\162\x65\x61\154\145\x73\167\160\x53\x63\162\151\160\x74", "\x6d\x6f\166\141\x72\x73", array("\151\155\x67\x55\122\x4c" => MOV_URL . "\x69\156\x63\x6c\x75\144\x65\163\57\x69\155\141\x67\145\x73\57\x6c\157\x61\x64\x65\x72\x2e\147\151\x66", "\146\151\145\x6c\x64\x6e\141\155\145" => $this->_otpType == $this->_typePhoneTag ? "\160\x68\157\x6e\x65\40\156\x75\155\x62\x65\162" : "\145\x6d\141\x69\154", "\x66\x69\145\x6c\x64" => $this->_otpType == $this->_typePhoneTag ? "\x70\150\x6f\156\x65\x53\x69\x67\156\165\x70" : "\145\155\x61\x69\154\x53\x69\147\x6e\x75\160", "\163\x69\x74\145\125\x52\x4c" => site_url(), "\151\156\x73\x65\162\164\101\146\164\145\162" => $this->_otpType == $this->_typePhoneTag ? "\43\160\x68\157\156\x65\x53\x69\147\156\165\x70" : "\43\x65\x6d\141\x69\154\x53\x69\x67\x6e\165\160", "\160\154\141\143\145\110\157\154\144\x65\162" => mo_("\x4f\x54\120\x20\x43\x6f\144\145"), "\x62\165\x74\164\x6f\x6e\124\x65\x78\x74" => mo_("\126\x61\x6c\x69\144\141\x74\145\x20\141\156\x64\40\123\151\x67\x6e\x20\x55\160"), "\141\152\x61\170\x75\162\154" => wp_ajax_url()));
        wp_enqueue_script("\162\x65\141\x6c\145\163\x77\x70\123\x63\162\x69\x70\164");
    }
    function _send_otp_realeswp_verify($pO)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto r8;
        }
        $this->_send_otp_to_email($pO);
        goto Rx;
        r8:
        $this->_send_otp_to_phone($pO);
        Rx:
    }
    function _send_otp_to_phone($pO)
    {
        if (array_key_exists("\165\x73\145\162\x5f\160\150\157\x6e\x65", $pO) && !MoUtility::isBlank($pO["\165\x73\x65\162\137\x70\x68\x6f\x6e\x65"])) {
            goto nP;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Nh;
        nP:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($pO["\x75\163\145\x72\x5f\x70\x68\157\156\145"]));
        $this->sendChallenge("\x74\x65\x73\164", '', null, trim($pO["\x75\163\145\162\x5f\x70\150\157\x6e\x65"]), VerificationType::PHONE);
        Nh:
    }
    function _send_otp_to_email($pO)
    {
        if (array_key_exists("\x75\163\145\x72\137\145\155\141\x69\154", $pO) && !MoUtility::isBlank($pO["\x75\x73\145\x72\137\x65\155\141\x69\154"])) {
            goto LR;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto Lj;
        LR:
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\x75\163\145\162\x5f\x65\x6d\x61\151\154"]);
        $this->sendChallenge("\x74\145\x73\164", $pO["\165\163\145\162\137\x65\x6d\141\x69\154"], null, $pO["\165\x73\x65\162\137\145\155\x61\x69\154"], VerificationType::EMAIL);
        Lj:
    }
    function _reales_validate_otp($pO)
    {
        $Hp = !isset($pO["\x6f\164\x70"]) ? sanitize_text_field($pO["\157\x74\x70"]) : '';
        $this->checkIfOTPVerificationHasStarted();
        $this->validateSubmittedFields($pO);
        $this->validateChallenge(NULL, $Hp);
    }
    function validateSubmittedFields($pO)
    {
        $HV = $this->getVerificationType();
        if ($HV === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $pO["\x75\x73\145\162\x5f\145\x6d\x61\151\x6c"])) {
            goto eO;
        }
        if ($HV === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $pO["\x75\x73\145\x72\x5f\x70\x68\157\x6e\145"])) {
            goto t1;
        }
        goto gF;
        eO:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        goto gF;
        t1:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        gF:
    }
    function checkIfOTPVerificationHasStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto v9;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        die;
        v9:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        die;
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoMessages::REG_SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
        die;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto np;
        }
        array_push($zX, $this->_phoneFormId);
        np:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Og;
        }
        return;
        Og:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\162\x65\141\x6c\145\163\137\145\x6e\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\162\x65\x61\x6c\x65\x73\137\x65\x6e\141\x62\154\145\x5f\164\171\160\145");
        update_mo_option("\162\145\141\x6c\x65\x73\137\x65\156\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\162\x65\141\154\x65\163\137\145\156\x61\142\154\x65\x5f\x74\171\x70\x65", $this->_otpType);
    }
}
