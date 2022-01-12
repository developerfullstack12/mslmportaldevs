<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoException;
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
class WooCommerceRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_redirectToPage;
    private $_redirect_after_registration;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_DEFAULT_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\167\x63\137\160\150\x6f\x6e\x65\137\x65\156\141\142\x6c\145";
        $this->_typeEmailTag = "\155\x6f\137\x77\x63\x5f\x65\155\x61\x69\154\137\x65\x6e\x61\142\154\145";
        $this->_typeBothTag = "\155\157\137\x77\143\137\142\x6f\164\x68\x5f\145\156\141\142\154\145";
        $this->_phoneFormId = "\43\x72\145\x67\137\x62\x69\x6c\x6c\x69\x6e\147\137\160\x68\x6f\156\x65";
        $this->_formKey = "\127\x43\137\x52\x45\x47\x5f\106\x4f\122\115";
        $this->_formName = mo_("\127\x6f\157\x63\x6f\155\155\x65\162\x63\145\x20\122\145\147\151\x73\164\162\141\x74\x69\157\156\40\106\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\167\143\137\x64\145\146\x61\x75\x6c\164\137\x65\156\141\142\154\x65");
        $this->_buttonText = get_mo_option("\x77\143\137\142\165\x74\164\157\156\x5f\164\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\151\x63\x6b\40\x48\145\x72\x65\40\x74\x6f\x20\163\145\156\144\40\117\x54\120");
        $this->_formDocuments = MoOTPDocs::WC_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_isAjaxForm = get_mo_option("\167\x63\137\151\x73\x5f\x61\x6a\141\x78\x5f\146\x6f\162\155");
        $this->_otpType = get_mo_option("\167\143\x5f\145\x6e\x61\x62\x6c\x65\x5f\x74\x79\160\x65");
        $this->_redirectToPage = get_mo_option("\x77\143\x5f\162\x65\144\x69\x72\145\x63\x74");
        $this->_redirect_after_registration = get_mo_option("\x77\x63\x72\145\147\137\162\145\x64\151\x72\145\143\x74\x5f\x61\146\164\x65\x72\x5f\162\145\147\x69\163\164\x72\x61\x74\x69\157\x6e");
        $this->_restrictDuplicates = get_mo_option("\x77\143\x5f\162\145\163\164\x72\x69\x63\x74\x5f\144\x75\160\x6c\151\x63\141\164\x65\x73");
        add_filter("\x77\x6f\x6f\x63\157\155\x6d\145\x72\x63\145\x5f\x70\162\157\143\x65\x73\163\137\162\x65\147\x69\163\164\x72\141\x74\151\x6f\156\137\145\x72\162\x6f\x72\163", array($this, "\167\157\157\143\157\x6d\x6d\x65\162\x63\x65\137\x73\151\x74\x65\137\162\145\x67\x69\163\x74\x72\141\x74\x69\x6f\156\137\145\x72\162\157\x72\163"), 99, 4);
        add_action("\x77\x6f\x6f\x63\x6f\x6d\155\145\x72\x63\145\137\x63\162\145\141\164\145\x64\137\x63\165\163\x74\157\155\x65\x72", array($this, "\162\x65\147\151\163\164\145\x72\137\x77\x6f\157\143\x6f\155\x6d\145\x72\x63\x65\137\x75\163\145\x72"), 1, 3);
        add_filter("\167\x6f\157\143\x6f\x6d\x6d\x65\x72\x63\145\137\162\145\147\x69\163\164\x72\x61\x74\x69\157\156\137\162\x65\x64\151\x72\145\143\x74", array($this, "\x63\165\x73\x74\157\x6d\x5f\x72\145\x67\151\x73\164\162\141\164\151\157\156\x5f\162\x65\x64\151\x72\145\x63\x74"), 99, 1);
        if (!$this->isPhoneVerificationEnabled()) {
            goto wk0;
        }
        add_action("\167\157\157\x63\157\155\155\145\162\x63\145\x5f\x72\145\147\151\163\164\145\162\x5f\x66\157\162\x6d", array($this, "\x6d\x6f\137\x61\x64\144\137\x70\x68\157\156\x65\137\x66\151\145\154\144"), 1);
        add_action("\x77\143\155\x70\x5f\x76\145\156\x64\x6f\x72\x5f\162\x65\147\151\163\164\x65\x72\137\146\x6f\x72\x6d", array($this, "\x6d\x6f\x5f\141\x64\x64\137\x70\x68\157\156\x65\137\146\x69\145\154\144"), 1);
        wk0:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto Pnx;
        }
        add_action("\167\157\x6f\x63\x6f\155\x6d\145\162\143\145\x5f\x72\x65\147\151\x73\x74\x65\162\x5f\x66\x6f\x72\x6d", array($this, "\x6d\157\x5f\x61\144\x64\x5f\166\145\162\x69\x66\x69\143\x61\x74\151\x6f\x6e\x5f\146\151\145\154\144"), 1);
        add_action("\167\x63\x6d\160\x5f\166\x65\x6e\144\x6f\x72\137\162\x65\147\x69\163\x74\x65\162\137\146\157\162\155", array($this, "\x6d\x6f\137\x61\144\x64\137\166\145\x72\x69\146\151\143\141\164\151\157\x6e\137\x66\x69\x65\154\x64"), 1);
        add_action("\x77\160\137\145\156\x71\165\x65\x75\x65\137\x73\x63\162\151\160\164\163", array($this, "\x6d\151\156\151\157\x72\141\156\x67\145\x5f\162\145\147\151\x73\x74\145\162\137\x77\x63\x5f\163\143\162\x69\x70\x74"));
        $this->routeData();
        Pnx:
    }
    private function routeData()
    {
        if (array_key_exists("\157\x70\x74\151\157\x6e", $_GET)) {
            goto mRI;
        }
        return;
        mRI:
        switch (trim($_GET["\x6f\x70\164\x69\157\156"])) {
            case "\x6d\x69\x6e\151\x6f\x72\141\156\x67\x65\x2d\x77\143\x2d\162\x65\147\x2d\x76\145\x72\x69\x66\x79":
                $this->sendAjaxOTPRequest();
                goto ATN;
        }
        c69:
        ATN:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $lc = MoUtility::sanitizeCheck("\x75\163\x65\x72\137\x70\150\157\156\x65", $_POST);
        $CG = MoUtility::sanitizeCheck("\165\x73\x65\x72\137\145\155\141\x69\x6c", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto xKl;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $CG);
        goto KGd;
        xKl:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($lc));
        KGd:
        $Dz = $this->processFormFields(null, $CG, new WP_Error(), null, $lc);
        if (!$Dz->get_error_code()) {
            goto mhK;
        }
        wp_send_json(MoUtility::createJson($Dz->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        mhK:
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\x6d\x6f\167\x63\x72\145\x67", MOV_URL . "\x69\156\x63\154\x75\x64\145\x73\57\x6a\x73\x2f\x77\143\162\145\x67\x2e\x6d\151\x6e\x2e\152\163", array("\x6a\161\x75\145\x72\x79"));
        wp_localize_script("\x6d\157\x77\x63\x72\x65\x67", "\x6d\157\x77\x63\x72\x65\x67", array("\163\151\164\145\x55\122\114" => site_url(), "\157\164\160\x54\171\160\x65" => $this->_otpType, "\x6e\x6f\156\x63\145" => wp_create_nonce($this->_nonce), "\142\165\164\x74\x6f\156\164\x65\x78\x74" => mo_($this->_buttonText), "\146\x69\145\x6c\144" => $this->_otpType === $this->_typePhoneTag ? "\x72\x65\x67\x5f\x62\x69\154\x6c\x69\156\147\137\x70\150\x6f\x6e\145" : "\x72\x65\x67\137\x65\155\141\x69\x6c", "\x69\155\147\125\x52\114" => MOV_LOADER_URL));
        wp_enqueue_script("\x6d\157\x77\x63\162\x65\147");
    }
    function custom_registration_redirect($Mz)
    {
        if (!($this->_redirect_after_registration && get_mo_option("\x77\143\x5f\x64\145\x66\x61\x75\154\x74\x5f\145\x6e\141\142\154\x65"))) {
            goto N0J;
        }
        return get_permalink(get_page_by_title($this->_redirectToPage)->ID);
        N0J:
        return $Mz;
    }
    function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV === VerificationType::BOTH || $HV === VerificationType::PHONE;
    }
    function woocommerce_site_registration_errors(WP_Error $errors, $HR, $hs, $h4)
    {
        if (MoUtility::isBlank(array_filter($errors->errors))) {
            goto fZv;
        }
        return $errors;
        fZv:
        if ($this->_isAjaxForm) {
            goto bZ7;
        }
        return $this->processFormAndSendOTP($HR, $hs, $h4, $errors);
        goto N4D;
        bZ7:
        $this->assertOTPField($errors, $_POST);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($_POST, $errors);
        N4D:
    }
    private function assertOTPField(&$errors, $wE)
    {
        if (MoUtility::sanitizeCheck("\x6d\157\x76\145\x72\151\x66\x79", $wE)) {
            goto NmO;
        }
        $errors = new WP_Error("\x72\x65\147\x69\x73\164\162\x61\x74\x69\x6f\156\x2d\x65\162\x72\x6f\x72\x2d\x6f\164\160\55\x6e\145\x65\144\145\x64", MoMessages::showMessage(MoMessages::REQUIRED_OTP));
        NmO:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto KQz;
        }
        $errors = new WP_Error("\162\145\147\x69\163\x74\x72\x61\x74\x69\157\156\x2d\x65\162\162\x6f\x72\x2d\x6e\x65\145\144\55\166\x61\x6c\x69\144\141\x74\x69\x6f\156", MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        KQz:
    }
    private function checkIntegrityAndValidateOTP($pO, WP_Error $errors)
    {
        if (empty($errors->errors)) {
            goto C21;
        }
        return $errors;
        C21:
        if (!isset($pO["\x62\x69\154\154\151\x6e\147\x5f\x70\150\x6f\156\145"])) {
            goto m1l;
        }
        $pO["\x62\x69\x6c\154\151\x6e\x67\x5f\160\150\157\x6e\x65"] = MoUtility::processPhoneNumber($pO["\x62\x69\154\154\x69\156\147\137\x70\150\x6f\156\x65"]);
        m1l:
        $errors = $this->checkIntegrity($pO, $errors);
        if (empty($errors->errors)) {
            goto UDu;
        }
        return $errors;
        UDu:
        $HV = $this->getVerificationType();
        $this->validateChallenge($HV, NULL, $pO["\x6d\157\166\145\162\151\146\x79"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto F00;
        }
        return new WP_Error("\x72\x65\147\151\163\x74\x72\141\164\x69\x6f\156\55\x65\x72\162\157\162\55\x69\156\x76\x61\x6c\x69\144\x2d\157\x74\160", MoUtility::_get_invalid_otp_method());
        goto Pzr;
        F00:
        $this->unsetOTPSessionVariables();
        Pzr:
        return $errors;
    }
    private function checkIntegrity($pO, WP_Error $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto OTH;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto XfN;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $pO["\145\x6d\x61\x69\154"])) {
            goto lU1;
        }
        return new WP_Error("\x72\x65\x67\x69\163\164\x72\x61\164\151\x6f\x6e\55\x65\162\x72\x6f\x72\x2d\x69\156\166\x61\154\x69\x64\x2d\145\x6d\141\151\154", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        lU1:
        XfN:
        goto eJw;
        OTH:
        if (Sessionutils::isPhoneVerifiedMatch($this->_formSessionVar, $pO["\142\x69\x6c\x6c\151\156\147\137\x70\150\157\x6e\145"])) {
            goto M46;
        }
        return new WP_Error("\x62\151\154\154\x69\x6e\x67\137\160\x68\x6f\x6e\145\137\145\x72\162\x6f\x72", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        M46:
        eJw:
        return $errors;
    }
    private function processFormAndSendOTP($HR, $hs, $h4, WP_Error $errors)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto WBO;
        }
        $this->unsetOTPSessionVariables();
        return $errors;
        WBO:
        $rT = isset($_POST["\x62\x69\x6c\154\151\x6e\x67\x5f\160\150\x6f\x6e\x65"]) ? $_POST["\142\151\x6c\x6c\151\x6e\x67\x5f\x70\150\157\156\145"] : '';
        MoUtility::initialize_transaction($this->_formSessionVar);
        try {
            $this->assertUserName($HR);
            $this->assertPassword($hs);
            $this->assertEmail($h4);
        } catch (MoException $S9) {
            return new WP_Error($S9->getMoCode(), $S9->getMessage());
        }
        do_action("\x77\x6f\157\x63\x6f\155\x6d\x65\162\x63\x65\137\x72\145\147\151\163\164\x65\162\137\x70\157\x73\x74", $HR, $h4, $errors);
        return $errors->get_error_code() ? $errors : $this->processFormFields($HR, $h4, $errors, $hs, $rT);
    }
    private function assertPassword($hs)
    {
        if (!(get_mo_option("\167\x6f\x6f\143\x6f\155\155\x65\162\143\x65\137\x72\x65\147\151\163\164\x72\141\164\151\157\156\x5f\147\x65\156\x65\162\141\164\x65\137\160\x61\163\163\x77\x6f\162\x64", '') === "\156\x6f")) {
            goto k9D;
        }
        if (!MoUtility::isBlank($hs)) {
            goto Ffl;
        }
        throw new MoException("\x72\x65\x67\x69\x73\164\162\x61\164\x69\x6f\156\55\x65\x72\162\x6f\x72\x2d\x69\156\166\141\x6c\x69\x64\55\x70\141\163\163\x77\x6f\162\144", mo_("\x50\x6c\145\141\x73\x65\x20\x65\x6e\x74\x65\162\40\x61\x20\x76\141\x6c\x69\x64\40\141\143\x63\157\165\x6e\164\x20\160\x61\x73\163\x77\157\x72\144\56"), 204);
        Ffl:
        k9D:
    }
    private function assertEmail($h4)
    {
        if (!(MoUtility::isBlank($h4) || !is_email($h4))) {
            goto rk_;
        }
        throw new MoException("\x72\x65\147\x69\x73\164\x72\x61\x74\x69\157\156\55\x65\x72\x72\157\x72\55\151\156\166\x61\x6c\x69\x64\x2d\145\155\141\151\x6c", mo_("\x50\x6c\145\x61\x73\145\x20\145\x6e\x74\145\162\40\x61\40\166\x61\154\151\x64\x20\145\x6d\x61\151\154\x20\x61\144\x64\162\145\163\x73\x2e"), 202);
        rk_:
        if (!email_exists($h4)) {
            goto JIb;
        }
        throw new MoException("\x72\145\x67\151\x73\164\162\141\x74\x69\157\156\55\x65\x72\x72\x6f\162\55\145\x6d\x61\x69\154\55\145\170\151\x73\x74\x73", mo_("\x41\x6e\x20\x61\x63\143\157\165\x6e\x74\40\x69\x73\40\141\x6c\x72\x65\141\144\171\40\x72\x65\x67\151\163\164\145\x72\x65\144\x20\167\151\164\150\x20\171\x6f\x75\x72\x20\x65\x6d\141\x69\154\x20\x61\x64\144\162\145\163\x73\x2e\x20\120\154\x65\141\x73\145\40\154\x6f\x67\x69\156\56"), 203);
        JIb:
    }
    private function assertUserName($HR)
    {
        if (!(get_mo_option("\167\x6f\x6f\x63\x6f\155\155\145\x72\x63\145\x5f\x72\x65\147\151\163\x74\x72\141\164\151\x6f\156\137\147\145\x6e\145\162\141\164\x65\137\x75\x73\x65\162\x6e\141\x6d\x65", '') === "\156\x6f")) {
            goto x0u;
        }
        if (!(MoUtility::isBlank($HR) || !validate_username($HR))) {
            goto sUc;
        }
        throw new MoException("\162\x65\x67\x69\163\164\162\141\164\151\157\156\55\145\162\x72\157\162\x2d\151\x6e\166\x61\x6c\x69\x64\x2d\x75\x73\x65\162\x6e\x61\155\145", mo_("\x50\154\x65\141\x73\x65\x20\x65\x6e\x74\145\x72\x20\141\x20\166\141\154\x69\x64\40\x61\x63\x63\157\x75\156\x74\x20\165\x73\145\x72\x6e\x61\x6d\145\x2e"), 200);
        sUc:
        if (!username_exists($HR)) {
            goto MnT;
        }
        throw new MoException("\x72\x65\x67\151\163\x74\x72\141\x74\x69\157\x6e\x2d\145\162\162\x6f\162\x2d\x75\163\x65\162\156\141\x6d\145\x2d\x65\x78\151\x73\x74\163", mo_("\101\156\x20\x61\x63\x63\157\x75\156\164\40\151\163\40\x61\154\x72\x65\x61\x64\x79\x20\162\145\x67\151\163\x74\145\162\145\144\x20\167\151\x74\150\40\x74\x68\141\164\40\165\x73\145\162\156\x61\x6d\x65\x2e\40\x50\x6c\145\141\163\x65\x20\143\150\x6f\x6f\x73\x65\40\x61\x6e\157\x74\150\x65\x72\56"), 201);
        MnT:
        x0u:
    }
    function processFormFields($HR, $h4, $errors, $hs, $fk)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Ci_;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto N3F;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeBothTag) === 0)) {
            goto wGT;
        }
        if (!isset($fk) || !MoUtility::validatePhoneNumber($fk)) {
            goto tid;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($fk, "\x62\x69\x6c\154\151\x6e\147\x5f\x70\150\x6f\156\x65")) {
            goto tvj;
        }
        goto mh5;
        tid:
        return new WP_Error("\x62\x69\x6c\x6c\151\x6e\147\x5f\x70\150\157\156\x65\137\x65\x72\x72\157\x72", str_replace("\x23\x23\x70\x68\157\156\145\43\43", $_POST["\142\x69\154\154\x69\156\x67\x5f\160\x68\x6f\156\x65"], $phoneLogic->_get_otp_invalid_format_message()));
        goto mh5;
        tvj:
        return new WP_Error("\x62\151\x6c\x6c\x69\x6e\147\x5f\x70\x68\157\x6e\145\x5f\x65\x72\162\157\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        mh5:
        $this->sendChallenge($HR, $h4, $errors, $_POST["\142\x69\x6c\154\151\x6e\x67\x5f\160\150\157\156\x65"], VerificationType::BOTH, $hs);
        wGT:
        goto rrN;
        N3F:
        $fk = isset($fk) ? $fk : '';
        $this->sendChallenge($HR, $h4, $errors, $fk, VerificationType::EMAIL, $hs);
        rrN:
        goto NTo;
        Ci_:
        if (!isset($fk) || !MoUtility::validatePhoneNumber($fk)) {
            goto Se5;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($fk, "\x62\151\x6c\x6c\151\x6e\147\137\160\150\x6f\x6e\x65")) {
            goto tpT;
        }
        goto j7k;
        Se5:
        return new WP_Error("\142\x69\154\x6c\151\x6e\x67\137\160\150\157\x6e\145\x5f\x65\162\162\157\162", str_replace("\43\x23\x70\x68\x6f\x6e\x65\43\x23", $fk, $phoneLogic->_get_otp_invalid_format_message()));
        goto j7k;
        tpT:
        return new WP_Error("\x62\x69\154\x6c\151\x6e\147\137\x70\x68\x6f\x6e\x65\137\145\162\162\157\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        j7k:
        $this->sendChallenge($HR, $h4, $errors, $fk, VerificationType::PHONE, $hs);
        NTo:
        return $errors;
    }
    public function register_woocommerce_user($yx, $ep, $Br)
    {
        if (!isset($_POST["\142\x69\154\154\151\x6e\x67\x5f\x70\150\x6f\x6e\x65"])) {
            goto whK;
        }
        $fk = MoUtility::sanitizeCheck("\x62\151\x6c\x6c\x69\156\x67\137\x70\x68\x6f\156\x65", $_POST);
        update_user_meta($yx, "\142\x69\x6c\154\151\156\x67\137\160\150\x6f\156\x65", MoUtility::processPhoneNumber($fk));
        whK:
    }
    function mo_add_phone_field()
    {
        if (!(!did_action("\167\157\x6f\143\157\x6d\x6d\145\162\143\x65\137\162\x65\147\x69\x73\x74\x65\x72\137\146\x6f\162\155") || !did_action("\167\x63\x6d\x70\x5f\x76\145\x6e\x64\x6f\162\x5f\162\x65\x67\x69\x73\164\x65\162\137\x66\x6f\x72\155"))) {
            goto gv9;
        }
        echo "\x3c\x70\x20\x63\x6c\141\x73\x73\75\x22\146\157\162\x6d\x2d\x72\157\167\x20\146\157\162\155\x2d\x72\157\x77\x2d\x77\151\x64\x65\42\x3e\15\12\40\x20\40\40\40\x20\40\x20\x20\40\40\x20\40\40\x20\40\x3c\154\141\x62\x65\154\x20\x66\x6f\162\x3d\42\x72\x65\147\x5f\x62\x69\154\x6c\x69\156\x67\x5f\x70\x68\157\x6e\145\42\76\xd\xa\x20\x20\x20\x20\40\x20\x20\40\40\40\40\x20\x20\40\x20\40\x20\x20\40\40" . mo_("\x50\150\x6f\156\x65") . "\xd\12\x20\40\40\40\40\40\x20\40\x20\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\74\163\x70\141\x6e\x20\x63\154\x61\163\163\x3d\x22\x72\x65\x71\x75\x69\x72\145\x64\42\76\52\74\x2f\x73\x70\141\156\76\15\12\40\40\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\x20\x20\74\x2f\x6c\x61\x62\145\154\76\xd\12\40\x20\40\x20\40\x20\x20\40\40\40\40\x20\40\x20\x20\40\74\151\156\x70\165\164\40\x74\x79\160\x65\x3d\x22\164\145\170\x74\x22\40\x63\x6c\x61\163\x73\75\x22\151\x6e\x70\165\164\55\164\x65\x78\x74\x22\40\xd\12\40\x20\40\x20\x20\40\x20\x20\40\x20\x20\40\40\x20\x20\x20\x20\40\x20\x20\40\x20\40\40\x6e\141\155\x65\x3d\x22\x62\x69\154\x6c\x69\x6e\147\x5f\x70\x68\x6f\156\x65\42\x20\151\x64\x3d\42\x72\145\x67\x5f\142\151\x6c\x6c\151\x6e\x67\137\160\x68\x6f\x6e\x65\42\40\xd\12\40\x20\x20\x20\40\40\40\x20\40\40\40\40\40\40\40\x20\40\x20\40\x20\40\x20\40\x20\166\141\x6c\165\145\x3d\42" . (!empty($_POST["\142\x69\154\x6c\x69\156\147\137\160\x68\x6f\156\x65"]) ? $_POST["\142\151\x6c\x6c\151\x6e\147\x5f\160\x68\x6f\156\x65"] : '') . "\42\40\x2f\76\15\12\40\40\40\40\x20\x20\40\40\x20\40\40\40\x20\40\x3c\57\160\76";
        gv9:
    }
    function mo_add_verification_field()
    {
        if (!(!did_action("\x77\157\x6f\143\157\155\x6d\x65\x72\x63\145\x5f\x72\x65\x67\151\x73\x74\x65\162\137\146\x6f\162\155") || !did_action("\x77\x63\155\160\x5f\x76\145\x6e\x64\157\162\x5f\x72\x65\147\151\x73\x74\x65\x72\137\146\157\x72\155"))) {
            goto T9B;
        }
        echo "\x3c\x70\x20\x63\154\x61\163\x73\75\42\x66\157\x72\x6d\55\162\157\x77\40\x66\157\x72\x6d\55\x72\x6f\167\x2d\x77\x69\144\x65\x22\76\15\xa\x20\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\40\40\x20\x20\74\x6c\x61\x62\x65\x6c\x20\x66\157\162\75\42\x72\x65\147\x5f\x76\x65\162\x69\146\x69\143\141\164\x69\x6f\x6e\x5f\160\150\157\x6e\145\42\x3e\15\xa\x20\40\40\x20\40\x20\40\x20\40\40\40\x20\x20\x20\x20\40\40\x20\x20\x20" . mo_("\105\156\164\x65\162\x20\x43\157\144\145") . "\xd\xa\x20\40\x20\x20\40\40\x20\x20\40\x20\x20\40\40\40\x20\x20\40\x20\x20\40\74\x73\x70\x61\x6e\40\143\x6c\x61\163\163\x3d\42\x72\145\x71\x75\151\x72\145\144\x22\76\x2a\x3c\x2f\x73\x70\x61\x6e\76\15\12\x20\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\74\x2f\154\141\142\x65\x6c\x3e\15\xa\40\40\x20\40\40\40\40\x20\x20\x20\x20\x20\x20\x20\40\x20\74\x69\156\x70\x75\164\x20\x74\171\x70\x65\75\42\x74\x65\x78\164\x22\x20\x63\154\141\x73\x73\x3d\x22\x69\156\x70\x75\164\55\x74\145\170\x74\x22\x20\156\x61\x6d\145\75\42\155\157\166\145\162\151\146\x79\42\x20\xd\xa\x20\40\x20\x20\40\x20\40\40\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\40\40\x20\x69\x64\75\42\x72\145\147\x5f\x76\x65\x72\x69\146\151\143\141\164\151\157\x6e\x5f\146\151\x65\x6c\x64\42\x20\xd\xa\40\40\x20\x20\x20\x20\x20\40\40\x20\x20\40\40\40\x20\x20\40\x20\40\x20\40\x20\40\40\166\x61\x6c\x75\145\75\x22\42\40\x2f\76\15\xa\40\x20\40\40\40\x20\40\x20\x20\40\40\40\40\x20\x3c\x2f\160\76";
        T9B:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if ($this->_isAjaxForm) {
            goto Czq;
        }
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
        goto RAN;
        Czq:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
        RAN:
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto S2D;
        }
        array_push($zX, $this->_phoneFormId);
        S2D:
        return $zX;
    }
    function isPhoneNumberAlreadyInUse($fk, $Zm)
    {
        global $wpdb;
        $fk = MoUtility::processPhoneNumber($fk);
        $h8 = $wpdb->get_row("\x53\x45\114\x45\103\x54\40\140\x75\163\x65\x72\137\x69\144\x60\40\106\122\x4f\x4d\x20\x60{$wpdb->prefix}\x75\163\x65\x72\x6d\145\x74\x61\140\40\127\x48\105\x52\x45\40\140\155\x65\164\141\x5f\153\x65\171\x60\40\x3d\x20\x27{$Zm}\x27\40\x41\x4e\104\x20\140\x6d\x65\x74\x61\x5f\166\x61\x6c\x75\145\140\x20\x3d\40\40\x27{$fk}\47");
        return !MoUtility::isBlank($h8);
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto knx;
        }
        return;
        knx:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\143\x5f\144\145\146\141\x75\154\x74\137\x65\156\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\167\143\x5f\145\156\x61\142\x6c\145\137\164\x79\160\145");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\143\x5f\162\x65\163\164\x72\151\143\164\x5f\x64\165\x70\x6c\x69\x63\141\164\145\163");
        $this->_redirectToPage = isset($_POST["\160\x61\x67\x65\137\151\x64"]) ? get_the_title($_POST["\x70\141\147\x65\x5f\x69\144"]) : "\x4d\x79\x20\101\x63\143\157\x75\156\x74";
        $this->_isAjaxForm = $this->sanitizeFormPOST("\x77\x63\x5f\151\x73\x5f\141\x6a\141\x78\137\x66\x6f\162\155");
        $this->_buttonText = $this->sanitizeFormPOST("\167\x63\137\142\165\164\164\x6f\156\137\164\145\x78\164");
        $this->_redirect_after_registration = $this->sanitizeFormPOST("\167\x63\162\145\x67\137\x72\x65\144\x69\162\x65\x63\164\x5f\141\146\x74\145\x72\137\x72\x65\x67\x69\x73\164\x72\x61\x74\x69\x6f\x6e");
        update_mo_option("\167\x63\x72\145\x67\137\x72\x65\x64\151\162\145\143\164\x5f\x61\146\x74\145\x72\137\x72\145\147\151\x73\164\162\141\x74\151\x6f\x6e", $this->_redirect_after_registration);
        update_mo_option("\x77\143\137\x64\145\146\141\x75\x6c\164\137\145\156\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x77\143\137\145\x6e\141\x62\154\x65\x5f\x74\x79\160\145", $this->_otpType);
        update_mo_option("\x77\143\x5f\x72\145\x73\164\x72\x69\143\x74\137\144\x75\160\154\x69\x63\x61\164\x65\163", $this->_restrictDuplicates);
        update_mo_option("\167\143\137\162\145\144\151\162\x65\x63\x74", $this->_redirectToPage);
        update_mo_option("\x77\143\x5f\x69\163\x5f\x61\152\x61\x78\137\146\157\x72\x6d", $this->_isAjaxForm);
        update_mo_option("\167\143\x5f\142\x75\x74\x74\157\156\137\164\x65\x78\x74", $this->_buttonText);
    }
    public function redirectToPage()
    {
        return $this->_redirectToPage;
    }
    public function isredirectToPageEnabled()
    {
        return $this->_redirect_after_registration;
    }
}
