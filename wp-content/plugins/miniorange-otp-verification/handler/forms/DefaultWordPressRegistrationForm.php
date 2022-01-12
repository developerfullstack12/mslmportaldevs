<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class DefaultWordPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_DEFAULT_REG;
        $this->_phoneKey = "\x74\145\154\145\x70\150\157\x6e\145";
        $this->_phoneFormId = "\x23\x70\150\x6f\x6e\x65\137\x6e\165\155\x62\145\162\x5f\155\x6f";
        $this->_formKey = "\127\x50\x5f\104\x45\106\x41\x55\x4c\x54";
        $this->_typePhoneTag = "\x6d\157\x5f\x77\x70\137\144\x65\x66\141\x75\154\164\x5f\x70\150\x6f\x6e\x65\x5f\x65\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\155\157\137\x77\x70\137\144\x65\146\x61\x75\154\x74\137\145\x6d\x61\151\x6c\x5f\145\156\x61\142\x6c\145";
        $this->_typeBothTag = "\x6d\157\x5f\x77\160\x5f\144\x65\146\141\165\x6c\x74\137\x62\x6f\x74\x68\x5f\x65\156\141\142\x6c\x65";
        $this->_formName = mo_("\127\x6f\x72\144\120\x72\x65\x73\163\40\104\x65\146\141\165\154\x74\x20\x2f\x20\124\x4d\x4c\x20\x52\145\x67\x69\x73\x74\x72\x61\164\151\x6f\x6e\40\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\x77\160\x5f\144\x65\146\x61\x75\x6c\164\x5f\145\156\x61\142\154\145");
        $this->_formDocuments = MoOTPDocs::WP_DEFAULT_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x70\137\144\x65\x66\141\165\x6c\164\137\x65\156\141\x62\x6c\x65\x5f\x74\171\160\145");
        $this->_disableAutoActivate = get_mo_option("\167\160\x5f\x72\145\x67\x5f\x61\x75\164\x6f\x5f\x61\x63\164\151\x76\141\x74\145") ? FALSE : TRUE;
        $this->_restrictDuplicates = get_mo_option("\167\x70\x5f\x72\145\x67\137\162\145\x73\x74\162\151\143\164\x5f\x64\165\x70\154\151\x63\141\x74\145\163");
        add_action("\162\x65\147\151\x73\x74\x65\162\x5f\146\157\x72\155", array($this, "\155\151\156\x69\x6f\162\141\x6e\x67\x65\x5f\163\x69\x74\x65\137\162\145\x67\x69\x73\164\145\162\x5f\146\157\x72\155"));
        add_filter("\x72\x65\x67\151\163\x74\x72\x61\x74\151\x6f\x6e\137\145\x72\x72\x6f\x72\163", array($this, "\x6d\151\156\151\x6f\162\141\x6e\x67\145\137\x73\x69\x74\145\x5f\162\145\147\x69\x73\164\x72\x61\x74\151\157\x6e\x5f\145\162\x72\x6f\x72\x73"), 99, 3);
        add_action("\x61\x64\155\151\x6e\137\x70\x6f\163\x74\137\156\x6f\160\x72\151\x76\x5f\166\141\154\x69\144\x61\164\151\x6f\x6e\137\x67\x6f\x42\x61\x63\153", array($this, "\x5f\150\141\x6e\144\154\x65\x5f\x76\141\154\x69\x64\141\164\x69\157\156\x5f\147\x6f\x42\x61\143\153\137\x61\143\x74\151\157\x6e"));
        add_action("\x75\x73\145\162\x5f\162\x65\147\x69\163\164\145\162", array($this, "\155\151\x6e\151\x6f\162\x61\x6e\147\145\x5f\162\x65\x67\x69\x73\164\162\x61\164\x69\157\156\x5f\163\141\x76\x65"), 10, 1);
        add_filter("\x77\x70\137\x6c\157\147\x69\x6e\x5f\145\x72\162\x6f\162\x73", array($this, "\155\151\x6e\x69\x6f\x72\x61\156\x67\145\137\x63\x75\x73\164\x6f\x6d\x5f\x72\145\x67\x5f\x6d\x65\x73\x73\x61\x67\x65"), 10, 2);
        if ($this->_disableAutoActivate) {
            goto ZS;
        }
        remove_action("\x72\145\x67\151\163\x74\145\162\137\x6e\x65\x77\x5f\165\x73\x65\162", "\x77\x70\137\163\x65\156\x64\137\x6e\145\x77\x5f\x75\163\145\162\137\x6e\157\164\x69\x66\151\x63\141\x74\x69\x6f\x6e\x73");
        ZS:
    }
    function isPhoneVerificationEnabled()
    {
        $lr = $this->getVerificationType();
        return $lr === VerificationType::PHONE || $lr === VerificationType::BOTH;
    }
    function miniorange_custom_reg_message(WP_Error $errors, $u8)
    {
        if ($this->_disableAutoActivate) {
            goto X8;
        }
        if (!in_array("\x72\x65\147\x69\163\164\145\162\x65\x64", $errors->get_error_codes())) {
            goto MM;
        }
        $errors->remove("\x72\145\147\151\x73\x74\x65\x72\x65\144");
        $errors->add("\162\x65\147\x69\163\164\145\162\x65\x64", mo_("\x52\x65\x67\151\x73\164\162\141\x74\x69\x6f\x6e\40\x43\x6f\x6d\x70\154\145\x74\x65\56"), "\155\x65\163\163\x61\147\x65");
        MM:
        X8:
        return $errors;
    }
    function miniorange_site_register_form()
    {
        echo "\74\x69\x6e\x70\165\164\x20\x74\x79\160\x65\x3d\42\x68\x69\x64\144\x65\156\42\40\x6e\141\x6d\x65\75\42\x72\145\x67\151\163\x74\145\162\x5f\x6e\x6f\156\x63\145\42\40\166\x61\x6c\x75\x65\75\x22\162\x65\x67\151\163\164\145\162\x5f\156\x6f\x6e\x63\x65\x22\x2f\x3e";
        if (!$this->isPhoneVerificationEnabled()) {
            goto ho;
        }
        echo "\74\154\x61\142\145\x6c\40\146\157\x72\75\x22\160\x68\157\156\x65\137\156\165\155\142\x65\162\x5f\155\157\x22\x3e" . mo_("\120\150\x6f\156\x65\40\116\x75\155\142\145\162") . "\x3c\x62\162\40\57\x3e\15\12\40\x20\x20\x20\x20\40\x20\40\40\40\x20\40\x20\x20\x20\40\x3c\x69\156\160\x75\164\x20\x74\171\160\x65\x3d\x22\164\x65\170\164\x22\x20\x6e\x61\x6d\x65\x3d\42\160\150\x6f\156\x65\x5f\x6e\165\155\x62\x65\162\x5f\x6d\157\x22\x20\x69\144\75\x22\x70\x68\157\x6e\x65\137\x6e\x75\155\x62\x65\x72\x5f\155\x6f\42\40\143\x6c\141\x73\163\75\42\x69\x6e\x70\x75\164\42\40\x76\141\154\x75\145\75\x22\x22\x20\163\x74\x79\x6c\x65\x3d\x22\x22\x2f\x3e\74\57\x6c\x61\142\x65\154\76";
        ho:
        if ($this->_disableAutoActivate) {
            goto Cn;
        }
        echo "\74\x6c\x61\x62\145\x6c\40\x66\157\162\x3d\x22\160\x61\163\x73\167\x6f\162\144\137\155\157\x22\x3e" . mo_("\120\141\x73\163\167\157\x72\x64") . "\74\x62\x72\x20\57\76\xd\xa\x20\40\x20\40\x20\40\x20\40\40\x20\40\x20\x20\x20\40\40\x3c\151\x6e\160\165\x74\40\x74\171\x70\x65\x3d\x22\160\141\163\x73\x77\x6f\162\144\x22\40\x6e\x61\155\x65\x3d\x22\160\141\163\163\167\157\162\x64\x5f\155\157\42\40\151\144\x3d\42\x70\x61\163\x73\x77\x6f\x72\144\x5f\x6d\x6f\42\x20\x63\154\x61\x73\x73\75\x22\x69\156\x70\165\164\x22\40\166\x61\x6c\x75\x65\75\x22\42\x20\x73\164\x79\x6c\x65\x3d\42\42\57\76\74\57\x6c\x61\x62\145\x6c\x3e";
        echo "\x3c\154\141\142\x65\154\40\146\x6f\162\75\x22\x63\x6f\156\146\x69\x72\x6d\137\x70\141\x73\x73\x77\x6f\162\x64\137\155\157\x22\x3e" . mo_("\103\157\x6e\146\151\x72\x6d\x20\x50\x61\x73\x73\x77\157\162\144") . "\74\142\162\x20\57\76\xd\xa\x20\40\x20\40\x20\40\x20\40\40\x20\40\40\40\40\x20\40\x3c\151\156\160\165\164\40\x74\x79\x70\x65\x3d\42\160\x61\163\163\167\157\x72\x64\42\40\x6e\141\155\145\75\42\143\x6f\x6e\146\151\x72\155\x5f\x70\141\163\163\167\x6f\162\x64\x5f\x6d\x6f\42\40\x69\144\75\x22\x63\x6f\x6e\146\x69\x72\x6d\x5f\160\x61\x73\163\x77\x6f\162\144\x5f\155\157\42\40\x63\x6c\141\x73\x73\x3d\x22\x69\x6e\160\165\164\x22\x20\166\141\154\165\x65\75\x22\x22\40\163\164\171\154\x65\x3d\x22\x22\57\x3e\x3c\57\154\x61\x62\145\154\76";
        echo "\74\163\143\162\x69\160\x74\76\x77\x69\x6e\144\157\x77\56\x6f\156\154\x6f\141\x64\x3d\146\165\x6e\x63\x74\x69\x6f\156\x28\x29\173\x20\x64\157\143\x75\x6d\145\156\164\56\147\x65\x74\x45\x6c\x65\x6d\145\156\x74\102\x79\x49\144\x28\42\162\x65\147\x5f\160\141\163\x73\155\x61\x69\154\42\x29\x2e\162\x65\x6d\x6f\x76\x65\x28\x29\73\x20\x7d\74\57\x73\143\x72\x69\x70\164\76";
        Cn:
    }
    function miniorange_registration_save($ZS)
    {
        $Zu = MoPHPSessions::getSessionVar("\x70\150\x6f\x6e\x65\137\x6e\x75\x6d\142\145\x72\137\155\157");
        if (!$Zu) {
            goto cF;
        }
        add_user_meta($ZS, $this->_phoneKey, $Zu);
        cF:
        if ($this->_disableAutoActivate) {
            goto p1;
        }
        wp_set_password($_POST["\x70\x61\x73\x73\x77\x6f\x72\x64\x5f\x6d\157"], $ZS);
        update_user_option($ZS, "\144\x65\146\141\x75\x6c\164\137\x70\141\163\x73\x77\x6f\162\x64\x5f\x6e\x61\x67", false, true);
        p1:
    }
    function miniorange_site_registration_errors(WP_Error $errors, $Ni, $CG)
    {
        $J9 = isset($_POST["\160\150\x6f\x6e\145\x5f\156\x75\155\x62\145\x72\x5f\155\157"]) ? $_POST["\x70\150\x6f\156\x65\137\x6e\x75\155\142\x65\162\137\155\157"] : null;
        $hs = isset($_POST["\x70\x61\163\163\167\157\x72\144\x5f\155\x6f"]) ? $_POST["\x70\141\x73\x73\167\157\162\x64\x5f\x6d\157"] : null;
        $xL = isset($_POST["\143\157\x6e\x66\151\162\x6d\137\x70\141\x73\163\x77\157\162\x64\137\x6d\157"]) ? $_POST["\143\x6f\156\x66\151\162\x6d\x5f\x70\x61\163\x73\167\x6f\x72\144\137\155\157"] : null;
        $this->checkIfPhoneNumberUnique($errors, $J9);
        $this->validatePasswords($errors, $hs, $xL);
        if (empty($errors->errors)) {
            goto B4;
        }
        return $errors;
        B4:
        if ($this->_otpType) {
            goto e1;
        }
        return $errors;
        e1:
        return $this->startOTPTransaction($Ni, $CG, $errors, $J9);
    }
    private function validatePasswords(WP_Error &$Dz, $hs, $xL)
    {
        if (!$this->_disableAutoActivate) {
            goto Q9;
        }
        return;
        Q9:
        if (!(strcasecmp($hs, $xL) !== 0)) {
            goto b3;
        }
        $Dz->add("\160\141\x73\163\x77\157\x72\144\137\155\151\163\155\141\164\x63\150", MoMessages::showMessage(MoMessages::PASS_MISMATCH));
        b3:
    }
    private function checkIfPhoneNumberUnique(WP_Error &$errors, $J9)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto Z0;
        }
        return;
        Z0:
        if (MoUtility::isBlank($J9) || !MoUtility::validatePhoneNumber($J9)) {
            goto Jb;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse(trim($J9), $this->_phoneKey)) {
            goto dt;
        }
        goto fk;
        Jb:
        $errors->add("\x69\x6e\166\141\154\151\x64\x5f\160\x68\157\x6e\145", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        goto fk;
        dt:
        $errors->add("\151\156\166\141\x6c\x69\144\137\160\150\157\x6e\x65", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        fk:
    }
    function startOTPTransaction($Ni, $CG, $errors, $J9)
    {
        if (!(!MoUtility::isBlank(array_filter($errors->errors)) || !isset($_POST["\x72\145\147\x69\163\x74\145\162\x5f\156\157\x6e\x63\x65"]))) {
            goto mW;
        }
        return $errors;
        mW:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto zi;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto Et;
        }
        $this->sendChallenge($Ni, $CG, $errors, $J9, VerificationType::EMAIL);
        goto E7;
        Et:
        $this->sendChallenge($Ni, $CG, $errors, $J9, VerificationType::BOTH);
        E7:
        goto nE;
        zi:
        $this->sendChallenge($Ni, $CG, $errors, $J9, VerificationType::PHONE);
        nE:
        return $errors;
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
    function isPhoneNumberAlreadyInUse($fk, $Zm)
    {
        global $wpdb;
        $fk = MoUtility::processPhoneNumber($fk);
        $h8 = $wpdb->get_row("\123\105\114\105\x43\x54\40\x60\x75\163\x65\162\x5f\x69\x64\x60\40\x46\x52\117\x4d\x20\x60{$wpdb->prefix}\x75\163\x65\x72\x6d\x65\164\x61\140\x20\x57\110\x45\122\105\40\140\x6d\145\x74\x61\137\153\x65\171\x60\40\x3d\x20\47{$Zm}\47\40\x41\x4e\104\40\140\x6d\x65\x74\x61\137\166\141\154\x75\145\140\40\x3d\40\40\x27{$fk}\x27");
        return !MoUtility::isBlank($h8);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto YJ;
        }
        array_push($zX, $this->_phoneFormId);
        YJ:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto NI;
        }
        return;
        NI:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x70\137\x64\145\x66\141\165\x6c\164\137\x65\156\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\x5f\144\x65\146\x61\165\x6c\x74\137\x65\x6e\x61\142\154\x65\x5f\x74\x79\x70\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\x70\137\162\145\x67\x5f\162\x65\x73\164\162\x69\143\164\x5f\x64\x75\x70\x6c\151\x63\x61\x74\x65\163");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\167\x70\137\162\x65\x67\x5f\x61\165\164\x6f\137\x61\143\164\151\x76\141\164\x65") ? FALSE : TRUE;
        update_mo_option("\x77\x70\x5f\144\x65\x66\x61\x75\x6c\164\137\x65\156\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\x70\x5f\144\x65\146\141\x75\x6c\x74\x5f\145\156\141\142\x6c\145\x5f\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\x77\x70\137\x72\145\147\x5f\162\145\x73\164\x72\151\x63\x74\x5f\x64\165\160\x6c\x69\143\141\164\x65\163", $this->_restrictDuplicates);
        update_mo_option("\x77\x70\137\x72\145\147\x5f\141\165\x74\x6f\137\x61\x63\x74\151\x76\x61\x74\x65", $this->_disableAutoActivate ? FALSE : TRUE);
    }
}
