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
class VisualFormBuilder extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::VISUAL_FORM;
        $this->_typePhoneTag = "\155\157\x5f\166\151\x73\x75\x61\154\137\x66\x6f\162\155\x5f\160\150\x6f\156\x65\x5f\x65\156\x61\142\154\x65";
        $this->_typeEmailTag = "\155\157\137\166\x69\x73\165\x61\154\137\x66\157\x72\155\137\145\155\x61\151\x6c\137\145\156\141\x62\154\145";
        $this->_typeBothTag = "\155\x6f\137\x76\x69\163\x75\x61\x6c\137\146\x6f\x72\155\x5f\142\157\164\150\x5f\x65\x6e\x61\142\154\x65";
        $this->_formKey = "\x56\x49\123\125\101\114\137\x46\x4f\x52\115";
        $this->_formName = mo_("\126\151\163\x75\141\x6c\40\x46\157\x72\x6d\x20\102\x75\151\154\x64\x65\x72");
        $this->_phoneFormId = array();
        $this->_isFormEnabled = get_mo_option("\166\151\163\165\x61\x6c\137\146\x6f\x72\x6d\x5f\145\x6e\x61\142\154\145");
        $this->_buttonText = get_mo_option("\x76\x69\163\x75\141\154\x5f\x66\157\x72\155\x5f\x62\165\x74\x74\x6f\156\137\x74\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\x63\x6b\x20\110\145\162\145\x20\164\157\40\163\145\x6e\144\40\117\124\120");
        $this->_generateOTPAction = "\155\x69\x6e\x69\157\162\141\x6e\x67\145\x2d\166\x66\x2d\163\145\x6e\x64\55\x6f\164\160";
        $this->_validateOTPAction = "\155\151\156\151\x6f\x72\141\x6e\x67\x65\x2d\x76\146\55\x76\x65\162\151\x66\x79\55\143\157\x64\145";
        $this->_formDocuments = MoOTPDocs::VISUAL_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\166\151\x73\165\x61\x6c\137\x66\x6f\162\155\x5f\145\x6e\x61\142\x6c\145\x5f\x74\x79\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\166\151\163\165\141\154\137\146\x6f\162\155\137\x6f\164\x70\137\x65\x6e\x61\x62\154\145\x64"));
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto yM;
        }
        return;
        yM:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\43" . $zs["\160\150\157\x6e\x65\153\145\171"]);
            xd:
        }
        OK:
        add_action("\167\x70\x5f\x65\156\x71\x75\145\165\145\137\x73\143\x72\x69\160\x74\163", array($this, "\x6d\x6f\x5f\x65\x6e\x71\x75\145\165\x65\x5f\166\x66"));
        add_action("\x77\160\137\141\x6a\141\170\x5f{$this->_generateOTPAction}", array($this, "\x5f\x73\145\156\x64\x5f\x6f\164\160\x5f\x76\x66\137\x61\152\x61\x78"));
        add_action("\x77\160\137\141\152\x61\x78\137\156\157\x70\x72\x69\x76\137{$this->_generateOTPAction}", array($this, "\137\163\145\156\x64\137\157\164\x70\137\x76\146\137\141\x6a\x61\170"));
        add_action("\x77\x70\x5f\x61\152\141\x78\x5f{$this->_validateOTPAction}", array($this, "\x70\162\157\143\145\x73\x73\106\157\162\155\101\x6e\144\126\141\x6c\151\144\141\x74\x65\x4f\124\x50"));
        add_action("\167\160\137\x61\x6a\141\x78\x5f\156\157\160\x72\x69\166\137{$this->_validateOTPAction}", array($this, "\160\162\x6f\143\x65\163\163\106\157\x72\x6d\101\x6e\x64\x56\141\x6c\151\144\x61\x74\145\117\x54\120"));
    }
    function mo_enqueue_vf()
    {
        wp_register_script("\166\146\163\143\162\151\160\164", MOV_URL . "\x69\x6e\143\x6c\165\x64\145\163\57\152\163\57\166\146\x73\x63\162\x69\160\164\x2e\155\151\x6e\56\152\x73", array("\x6a\161\x75\x65\x72\171"));
        wp_localize_script("\x76\146\163\143\162\x69\160\x74", "\x6d\157\x76\x66\166\141\162", array("\163\151\164\x65\125\x52\114" => wp_ajax_url(), "\157\164\x70\x54\171\x70\145" => strcasecmp($this->_otpType, $this->_typePhoneTag), "\x66\157\x72\155\x44\x65\x74\141\151\x6c\163" => $this->_formDetails, "\x62\165\164\x74\x6f\156\164\145\x78\x74" => $this->_buttonText, "\151\155\147\125\122\114" => MOV_LOADER_URL, "\x66\151\x65\x6c\144\124\145\170\x74" => mo_("\105\156\164\x65\162\40\x4f\x54\120\40\150\145\x72\x65"), "\x67\156\157\x6e\143\145" => wp_create_nonce($this->_nonce), "\156\157\156\143\x65\113\145\x79" => wp_create_nonce($this->_nonceKey), "\x76\x6e\x6f\156\x63\145" => wp_create_nonce($this->_nonce), "\147\x61\143\164\x69\x6f\x6e" => $this->_generateOTPAction, "\166\141\x63\164\151\x6f\156" => $this->_validateOTPAction));
        wp_enqueue_script("\x76\146\163\x63\x72\x69\160\x74");
    }
    function _send_otp_vf_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto jC;
        }
        $this->_send_vf_otp_to_email($_POST);
        goto go;
        jC:
        $this->_send_vf_otp_to_phone($_POST);
        go:
    }
    function _send_vf_otp_to_phone($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\x72\137\x70\150\157\156\145", $pO)) {
            goto xe;
        }
        $this->startOTPVerification(trim($pO["\165\x73\x65\x72\x5f\160\x68\x6f\x6e\x65"]), NULL, trim($pO["\x75\x73\145\162\x5f\160\150\157\156\145"]), VerificationType::PHONE);
        goto UV;
        xe:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        UV:
    }
    function _send_vf_otp_to_email($pO)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\162\137\x65\155\x61\x69\x6c", $pO)) {
            goto e0;
        }
        $this->startOTPVerification($pO["\165\163\145\x72\137\x65\x6d\x61\151\154"], $pO["\x75\163\x65\x72\x5f\145\x6d\x61\151\154"], NULL, VerificationType::EMAIL);
        goto Ru;
        e0:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        Ru:
    }
    private function startOTPVerification($ZI, $TK, $Zu, $lr)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($lr === VerificationType::PHONE) {
            goto OX;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $ZI);
        goto Mk;
        OX:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ZI);
        Mk:
        $this->sendChallenge('', $TK, NULL, $Zu, $lr);
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfVerificationNotStarted();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto CV;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        CV:
    }
    private function checkIntegrityAndValidateOTP($post)
    {
        $this->checkIntegrity($post);
        $this->validateChallenge($this->getVerificationType(), NULL, $post["\x6f\x74\x70\x5f\164\157\x6b\x65\x6e"]);
    }
    private function checkIntegrity($post)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto am;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $post["\x73\x75\x62\x5f\146\151\145\x6c\x64"])) {
            goto HY;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        HY:
        goto kZ;
        am:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $post["\x73\165\142\x5f\x66\x69\145\x6c\144"])) {
            goto jO;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        jO:
        kZ:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto ge;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        ge:
        return $zX;
    }
    function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV == VerificationType::PHONE || $HV === VerificationType::BOTH;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto yl;
        }
        return;
        yl:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\166\x69\x73\x75\x61\x6c\x5f\146\157\x72\x6d\x5f\x65\x6e\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x76\151\163\165\x61\x6c\137\146\157\x72\155\137\145\156\141\x62\154\x65\137\x74\x79\160\145");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\166\151\163\x75\x61\154\x5f\146\157\x72\155\x5f\x62\165\164\164\157\156\137\164\x65\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::VISUAL_FORM_CHOOSE)) {
            goto i7;
        }
        update_mo_option("\166\x69\163\x75\x61\154\x5f\x66\x6f\162\x6d\x5f\x62\x75\x74\164\157\x6e\137\164\145\170\x74", $this->_buttonText);
        update_mo_option("\166\x69\x73\165\141\154\x5f\146\x6f\162\155\x5f\145\x6e\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x76\x69\163\x75\x61\x6c\137\146\157\162\x6d\x5f\145\x6e\141\x62\154\x65\137\x74\x79\x70\145", $this->_otpType);
        update_mo_option("\x76\151\x73\x75\141\154\137\x66\x6f\x72\155\137\x6f\x74\x70\137\145\156\141\142\x6c\x65\144", maybe_serialize($this->_formDetails));
        i7:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\166\x69\x73\x75\141\154\137\146\x6f\162\155", $_POST)) {
            goto ZH;
        }
        return array();
        ZH:
        foreach (array_filter($_POST["\166\151\163\165\x61\x6c\x5f\x66\157\x72\155"]["\146\x6f\162\x6d"]) as $Zm => $zs) {
            $form[$zs] = array("\x65\155\x61\x69\x6c\153\145\x79" => $this->getFieldID($_POST["\166\151\163\x75\141\154\x5f\146\157\x72\x6d"]["\145\155\141\x69\x6c\x6b\x65\171"][$Zm], $zs), "\x70\x68\157\156\x65\153\x65\x79" => $this->getFieldID($_POST["\x76\151\163\x75\x61\154\x5f\146\x6f\162\x6d"]["\160\150\x6f\156\x65\153\145\171"][$Zm], $zs), "\160\150\157\x6e\145\x5f\x73\150\x6f\x77" => $_POST["\x76\151\163\x75\141\x6c\x5f\x66\157\x72\155"]["\160\x68\157\156\x65\153\x65\x79"][$Zm], "\145\x6d\141\x69\x6c\x5f\163\x68\x6f\x77" => $_POST["\166\x69\163\x75\141\x6c\x5f\146\157\x72\155"]["\145\x6d\141\151\154\153\x65\171"][$Zm]);
            kF:
        }
        pp:
        return $form;
    }
    private function getFieldID($Zm, $Z9)
    {
        global $wpdb;
        $qn = "\123\x45\x4c\x45\x43\x54\x20\x2a\40\106\122\117\x4d\x20" . VFB_WP_FIELDS_TABLE_NAME . "\x20\167\x68\x65\x72\145\x20\146\151\x65\154\x64\137\156\141\155\145\x20\75\47" . $Zm . "\47\141\x6e\144\40\146\x6f\162\x6d\137\x69\x64\x20\x3d\x20\x27" . $Z9 . "\x27";
        $fM = $wpdb->get_row($qn);
        return !MoUtility::isBlank($fM) ? "\166\x66\142\x2d" . $fM->field_id : '';
    }
}
