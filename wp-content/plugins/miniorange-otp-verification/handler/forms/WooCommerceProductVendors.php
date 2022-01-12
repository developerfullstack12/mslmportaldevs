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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WooCommerceProductVendors extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_PRODUCT_VENDOR;
        $this->_isAjaxForm = TRUE;
        $this->_typePhoneTag = "\155\x6f\137\167\x63\x5f\x70\x76\137\x70\150\157\156\x65\x5f\145\156\141\x62\154\x65";
        $this->_typeEmailTag = "\155\x6f\137\167\143\137\x70\x76\137\x65\x6d\141\151\154\x5f\145\x6e\x61\x62\x6c\145";
        $this->_phoneFormId = "\43\162\145\147\x5f\142\x69\154\154\x69\156\x67\x5f\160\x68\x6f\156\145";
        $this->_formKey = "\127\103\137\x50\126\137\x52\105\x47\x5f\x46\x4f\122\115";
        $this->_formName = mo_("\x57\x6f\157\143\x6f\155\x6d\145\162\x63\x65\x20\120\x72\x6f\x64\x75\x63\x74\40\x56\x65\x6e\x64\x6f\x72\40\122\145\147\151\x73\x74\x72\x61\x74\151\x6f\x6e\x20\106\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\x77\x63\x5f\160\x76\137\144\x65\x66\141\x75\x6c\164\137\x65\156\x61\142\x6c\x65");
        $this->_buttonText = get_mo_option("\167\143\137\160\x76\x5f\x62\165\x74\164\x6f\156\137\x74\x65\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\x69\x63\x6b\40\x48\145\x72\x65\40\x74\x6f\40\x73\145\156\144\40\x4f\124\x50");
        $this->_formDocuments = MoOTPDocs::WC_PRODUCT_VENDOR;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\x63\x5f\x70\x76\137\145\x6e\141\x62\x6c\x65\137\164\x79\x70\145");
        $this->_restrictDuplicates = get_mo_option("\167\143\137\x70\x76\137\x72\145\163\x74\162\x69\x63\164\137\144\165\160\x6c\151\143\x61\164\x65\x73");
        add_action("\167\x63\x70\166\137\162\x65\x67\151\163\164\x72\141\164\151\x6f\156\x5f\146\x6f\162\x6d", array($this, "\155\x6f\x5f\141\x64\x64\x5f\x70\150\157\156\145\137\x66\x69\145\154\x64"), 1);
        add_action("\167\160\x5f\141\x6a\x61\170\137\x6e\x6f\x70\162\x69\x76\x5f\155\151\x6e\x69\x6f\162\x61\x6e\x67\x65\137\167\x63\137\166\160\x5f\162\145\x67\137\166\x65\162\151\146\x79", array($this, "\x73\145\x6e\144\101\x6a\141\170\117\x54\x50\122\x65\x71\165\145\163\x74"));
        add_filter("\x77\143\160\166\x5f\163\x68\157\162\164\143\x6f\144\x65\137\x72\x65\x67\x69\x73\164\x72\x61\164\151\x6f\156\x5f\146\157\x72\x6d\137\x76\141\x6c\x69\x64\x61\x74\x69\157\156\x5f\x65\x72\162\157\x72\x73", array($this, "\x72\145\147\x5f\146\x69\x65\154\144\x73\x5f\145\x72\162\157\x72\163"), 1, 2);
        add_action("\x77\x70\137\145\156\161\x75\145\x75\145\x5f\x73\x63\162\x69\160\164\x73", array($this, "\155\x69\x6e\x69\157\x72\141\x6e\x67\145\137\x72\145\147\151\x73\x74\x65\x72\x5f\x77\x63\x5f\163\143\162\151\160\164"));
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $lc = MoUtility::sanitizeCheck("\x75\163\145\162\x5f\x70\150\157\x6e\145", $_POST);
        $CG = MoUtility::sanitizeCheck("\x75\163\x65\162\137\x65\x6d\141\151\154", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto e8;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $CG);
        goto mM;
        e8:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($lc));
        mM:
        $Dz = $this->processFormFields(null, $CG, new WP_Error(), null, $lc);
        if (!$Dz->get_error_code()) {
            goto TV;
        }
        wp_send_json(MoUtility::createJson($Dz->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        TV:
    }
    public function reg_fields_errors($errors, $wE)
    {
        if (empty($errors)) {
            goto Bv;
        }
        return $errors;
        Bv:
        $this->assertOTPField($errors, $wE);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($wE, $errors);
    }
    private function assertOTPField(&$errors, $wE)
    {
        if (MoUtility::sanitizeCheck("\x6d\x6f\166\x65\162\151\146\171", $wE)) {
            goto dk;
        }
        $errors[] = MoMessages::showMessage(MoMessages::REQUIRED_OTP);
        dk:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto cC;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        cC:
    }
    private function checkIntegrityAndValidateOTP($pO, array $errors)
    {
        if (empty($errors)) {
            goto gl;
        }
        return $errors;
        gl:
        $pO["\142\151\154\x6c\151\156\x67\x5f\x70\x68\x6f\156\145"] = MoUtility::processPhoneNumber($pO["\142\x69\154\x6c\151\x6e\x67\137\160\150\157\x6e\x65"]);
        $errors = $this->checkIntegrity($pO, $errors);
        if (empty($errors->errors)) {
            goto O3;
        }
        return $errors;
        O3:
        $HV = $this->getVerificationType();
        $this->validateChallenge($HV, NULL, $pO["\155\x6f\166\x65\162\x69\146\171"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto z0;
        }
        $this->unsetOTPSessionVariables();
        goto xw;
        z0:
        $errors[] = MoUtility::_get_invalid_otp_method();
        xw:
        return $errors;
    }
    private function checkIntegrity($pO, array $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto s4;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto vg;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $pO["\145\x6d\141\x69\154"])) {
            goto N0;
        }
        $errors[] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        N0:
        vg:
        goto zn;
        s4:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, MoUtility::processPhoneNumber($pO["\142\151\x6c\154\x69\x6e\x67\137\160\150\x6f\156\145"]))) {
            goto kk;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        kk:
        zn:
        return $errors;
    }
    function processFormFields($HR, $h4, $errors, $hs, $fk)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto BV;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto sZ;
        }
        $fk = isset($fk) ? $fk : '';
        $this->sendChallenge($HR, $h4, $errors, $fk, VerificationType::EMAIL, $hs);
        sZ:
        goto jU;
        BV:
        if (!isset($fk) || !MoUtility::validatePhoneNumber($fk)) {
            goto gQ;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($fk, "\142\x69\x6c\x6c\x69\156\147\137\160\x68\157\x6e\x65")) {
            goto mY;
        }
        goto Kx;
        gQ:
        return new WP_Error("\x62\x69\x6c\154\151\156\x67\137\160\150\x6f\156\145\x5f\145\x72\x72\157\162", str_replace("\x23\43\x70\x68\157\156\145\43\x23", $fk, $phoneLogic->_get_otp_invalid_format_message()));
        goto Kx;
        mY:
        return new WP_Error("\x62\x69\x6c\154\x69\x6e\147\137\x70\x68\x6f\x6e\145\137\x65\162\x72\x6f\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        Kx:
        $this->sendChallenge($HR, $h4, $errors, $fk, VerificationType::PHONE, $hs);
        jU:
        return $errors;
    }
    function isPhoneNumberAlreadyInUse($fk, $Zm)
    {
        global $wpdb;
        $fk = MoUtility::processPhoneNumber($fk);
        $h8 = $wpdb->get_row("\x53\x45\x4c\105\103\x54\40\x60\x75\163\145\x72\x5f\x69\x64\x60\40\106\x52\117\x4d\x20\x60{$wpdb->prefix}\165\x73\x65\162\155\145\164\x61\140\x20\127\110\x45\122\x45\x20\x60\x6d\x65\x74\x61\137\153\x65\171\140\x20\x3d\40\x27{$Zm}\47\40\x41\116\104\x20\140\155\x65\164\x61\137\x76\141\154\x75\x65\x60\x20\75\40\40\x27{$fk}\x27");
        return !MoUtility::isBlank($h8);
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\155\157\x77\x63\x70\x76\162\x65\x67", MOV_URL . "\x69\156\143\x6c\x75\x64\x65\x73\57\x6a\x73\57\167\x63\160\166\162\145\147\56\155\151\x6e\56\152\163", array("\x6a\x71\x75\145\162\171"));
        wp_localize_script("\155\x6f\167\143\x70\x76\162\145\147", "\x6d\x6f\x77\x63\160\166\162\x65\x67", array("\x73\151\x74\x65\x55\122\114" => wp_ajax_url(), "\x6f\x74\x70\x54\x79\x70\x65" => $this->_otpType, "\x6e\x6f\x6e\143\x65" => wp_create_nonce($this->_nonce), "\x62\x75\x74\x74\x6f\x6e\164\x65\x78\164" => mo_($this->_buttonText), "\x66\x69\x65\154\x64" => $this->_otpType === $this->_typePhoneTag ? "\x72\x65\147\137\x76\x70\137\x62\x69\x6c\x6c\151\x6e\x67\x5f\160\x68\157\156\145" : "\x77\143\x70\166\x2d\143\157\x6e\x66\x69\162\x6d\55\145\x6d\141\151\154", "\x69\155\147\x55\x52\x4c" => MOV_LOADER_URL, "\x63\x6f\x64\145\x4c\141\142\145\154" => mo_("\x45\x6e\x74\x65\x72\x20\x56\x65\162\151\x66\151\x63\141\x74\x69\x6f\x6e\x20\x43\157\144\x65")));
        wp_enqueue_script("\x6d\157\167\143\160\x76\162\x65\x67");
    }
    public function mo_add_phone_field()
    {
        echo "\x3c\x70\x20\x63\154\x61\x73\163\75\x22\x66\x6f\x72\155\55\162\157\x77\40\146\157\x72\x6d\55\x72\157\167\x2d\167\x69\144\145\42\x3e\15\12\x9\11\x9\11\x9\74\x6c\141\142\x65\x6c\40\146\x6f\x72\x3d\x22\x72\x65\147\x5f\x76\x70\x5f\x62\151\x6c\154\151\156\147\137\160\x68\157\x6e\145\42\x3e\15\12\11\x9\11\11\11\40\40\x20\x20" . mo_("\x50\x68\157\x6e\145") . "\xd\12\x9\x9\11\x9\x9\40\x20\x20\40\74\x73\x70\141\x6e\x20\x63\154\x61\163\x73\75\x22\162\x65\x71\x75\151\162\145\x64\x22\x3e\x2a\74\57\163\160\141\x6e\76\15\12\x20\40\40\x20\x20\40\x20\40\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\74\x2f\x6c\x61\x62\x65\x6c\x3e\15\xa\11\11\11\11\x9\x3c\x69\156\160\x75\x74\x20\x74\x79\160\145\75\x22\x74\145\x78\164\x22\40\x63\x6c\x61\x73\163\x3d\x22\x69\x6e\160\x75\x74\55\x74\x65\x78\x74\42\40\15\xa\x9\11\11\11\x9\40\x20\x20\40\x20\40\x20\x20\x6e\x61\155\x65\75\42\x62\151\x6c\154\x69\x6e\147\x5f\160\150\x6f\x6e\145\x22\x20\x69\144\x3d\42\162\145\147\137\x76\x70\x5f\x62\x69\154\x6c\x69\156\147\137\x70\150\x6f\x6e\145\42\x20\15\12\x9\x9\x9\11\x9\x20\40\40\40\x20\x20\x20\x20\166\141\154\x75\x65\x3d\42" . (!empty($_POST["\x62\x69\154\x6c\151\156\147\137\160\x68\x6f\x6e\x65"]) ? $_POST["\x62\151\x6c\x6c\x69\x6e\147\x5f\x70\x68\157\156\145"] : '') . "\x22\x20\x2f\x3e\xd\xa\x9\11\x9\40\40\x9\x20\40\74\57\160\76";
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    public function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!$this->isFormEnabled()) {
            goto Wl;
        }
        array_push($zX, $this->_phoneFormId);
        Wl:
        return $zX;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Se;
        }
        return;
        Se:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x63\x5f\160\x76\137\144\x65\146\141\165\154\x74\137\x65\156\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\137\x70\166\x5f\145\x6e\141\x62\154\x65\x5f\x74\171\x70\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\x63\x5f\x70\x76\x5f\x72\x65\x73\x74\162\x69\143\x74\x5f\144\165\x70\154\x69\x63\141\164\145\x73");
        $this->_buttonText = $this->sanitizeFormPOST("\167\143\137\160\x76\137\142\165\x74\164\157\156\x5f\x74\x65\x78\x74");
        update_mo_option("\167\143\137\160\166\137\x64\145\146\141\165\x6c\164\x5f\x65\156\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\167\143\x5f\x70\166\x5f\145\156\141\x62\154\x65\137\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\x77\143\137\160\x76\x5f\162\x65\163\164\x72\151\143\164\x5f\144\x75\160\x6c\x69\143\141\x74\145\163", $this->_restrictDuplicates);
        update_mo_option("\x77\143\x5f\160\x76\x5f\x62\165\x74\x74\x6f\x6e\137\x74\x65\x78\164", $this->_buttonText);
    }
}
