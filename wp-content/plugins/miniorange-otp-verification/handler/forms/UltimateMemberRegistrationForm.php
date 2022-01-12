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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use um\core\Form;
use WP_Error;
class UltimateMemberRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = get_mo_option("\165\155\137\x69\x73\x5f\x61\x6a\141\x78\137\146\x6f\x72\x6d");
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\x6f\137\165\155\137\x70\150\157\156\145\137\145\x6e\141\x62\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\165\155\x5f\x65\155\x61\151\154\x5f\x65\156\141\x62\154\x65";
        $this->_typeBothTag = "\x6d\157\137\165\x6d\137\x62\157\x74\150\x5f\x65\x6e\x61\x62\x6c\x65";
        $this->_phoneKey = get_mo_option("\165\x6d\x5f\160\x68\x6f\156\x65\x5f\x6b\145\171");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\x6d\x6f\x62\151\x6c\x65\x5f\x6e\x75\155\x62\145\162";
        $this->_phoneFormId = "\151\x6e\160\165\x74\x5b\x6e\141\155\145\136\x3d\47" . $this->_phoneKey . "\x27\x5d";
        $this->_formKey = "\125\114\x54\x49\x4d\x41\x54\x45\137\106\117\122\115";
        $this->_formName = mo_("\x55\154\164\151\x6d\141\x74\145\x20\115\145\x6d\x62\x65\162\x20\x52\145\147\x69\x73\x74\162\141\164\151\x6f\156\40\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\x75\155\x5f\x64\145\146\x61\x75\x6c\164\137\x65\x6e\x61\x62\154\145");
        $this->_restrictDuplicates = get_mo_option("\165\155\x5f\162\145\163\x74\x72\151\x63\164\137\x64\165\x70\154\151\143\x61\164\145\163");
        $this->_buttonText = get_mo_option("\165\155\137\142\165\x74\164\157\x6e\x5f\164\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\x63\x6b\x20\110\x65\x72\x65\x20\164\157\x20\163\145\156\x64\40\117\x54\120");
        $this->_formKey = get_mo_option("\x75\155\x5f\166\x65\x72\x69\x66\171\137\x6d\145\164\x61\137\x6b\x65\171");
        $this->_formDocuments = MoOTPDocs::UM_ENABLED;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\155\137\x65\x6e\x61\x62\x6c\x65\x5f\x74\x79\x70\x65");
        if ($this->isUltimateMemberV2Installed()) {
            goto vY;
        }
        add_action("\165\155\137\x73\165\x62\x6d\x69\x74\137\x66\157\x72\x6d\x5f\x65\162\x72\157\x72\163\137\x68\x6f\157\153\137", array($this, "\x6d\151\x6e\151\x6f\162\141\156\x67\x65\x5f\165\x6d\137\160\150\157\x6e\x65\x5f\x76\141\x6c\151\144\141\164\x69\x6f\x6e"), 99, 1);
        add_action("\x75\x6d\137\142\145\x66\x6f\162\x65\x5f\156\x65\167\x5f\165\x73\x65\x72\x5f\x72\145\x67\x69\x73\x74\x65\x72", array($this, "\155\151\156\x69\157\x72\141\x6e\147\x65\x5f\165\x6d\x5f\165\163\x65\162\x5f\x72\x65\x67\151\163\164\162\141\164\151\x6f\x6e"), 99, 1);
        goto oN;
        vY:
        add_action("\x75\155\137\163\165\142\x6d\x69\164\137\146\x6f\162\x6d\137\145\x72\162\x6f\162\x73\137\x68\x6f\157\x6b\137\x5f\162\x65\x67\x69\163\164\162\141\x74\151\x6f\x6e", array($this, "\x6d\x69\156\151\x6f\x72\x61\156\147\x65\x5f\165\155\62\x5f\160\x68\157\x6e\x65\x5f\166\141\x6c\x69\144\141\164\x69\x6f\156"), 99, 1);
        add_filter("\165\155\x5f\x72\145\147\151\163\164\162\141\x74\151\157\156\137\165\x73\145\x72\x5f\x72\157\x6c\145", array($this, "\x6d\151\x6e\x69\157\162\141\x6e\x67\145\x5f\165\155\x32\x5f\x75\x73\145\162\x5f\x72\x65\x67\151\x73\x74\x72\141\x74\x69\157\x6e"), 99, 2);
        oN:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto Pg;
        }
        add_action("\x77\160\137\145\x6e\161\x75\145\165\145\x5f\163\x63\162\x69\160\164\x73", array($this, "\155\x69\x6e\x69\x6f\162\141\x6e\147\145\x5f\162\145\147\151\x73\x74\145\x72\137\x75\155\137\x73\x63\x72\x69\160\x74"));
        $this->routeData();
        Pg:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\x69\x73\137\x70\x6c\165\147\x69\156\137\141\143\164\151\x76\x65")) {
            goto p2;
        }
        include_once ABSPATH . "\x77\160\x2d\141\144\155\151\156\x2f\151\x6e\x63\x6c\165\144\145\163\57\160\154\165\147\151\x6e\x2e\160\x68\160";
        p2:
        return is_plugin_active("\x75\x6c\x74\x69\155\141\x74\x65\x2d\155\x65\155\142\x65\x72\57\165\154\x74\151\x6d\141\x74\x65\x2d\155\x65\155\142\x65\162\56\160\x68\x70");
    }
    private function routeData()
    {
        if (array_key_exists("\x6f\160\164\x69\157\x6e", $_GET)) {
            goto BP;
        }
        return;
        BP:
        switch (trim($_GET["\157\x70\x74\x69\x6f\x6e"])) {
            case "\x6d\151\156\x69\x6f\x72\x61\156\x67\x65\x2d\165\155\x2d\141\x6a\141\170\x2d\166\145\162\x69\146\171":
                $this->sendAjaxOTPRequest();
                goto S3;
        }
        I0:
        S3:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $lc = MoUtility::sanitizeCheck("\x75\x73\145\162\137\x70\x68\x6f\x6e\x65", $_POST);
        $CG = MoUtility::sanitizeCheck("\165\163\x65\162\x5f\145\x6d\141\151\154", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto VD;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $CG);
        goto ve;
        VD:
        $this->checkDuplicates($lc, $this->_phoneKey, null);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $lc);
        ve:
        $this->startOtpTransaction(null, $CG, null, $lc, null, null);
    }
    function miniorange_register_um_script()
    {
        wp_register_script("\155\157\x76\x75\x6d", MOV_URL . "\x69\156\x63\x6c\165\x64\145\163\x2f\x6a\x73\x2f\x75\x6d\162\145\x67\56\155\151\x6e\x2e\x6a\163", array("\152\x71\x75\145\x72\x79"));
        wp_localize_script("\155\x6f\x76\165\155", "\155\x6f\x75\x6d\x76\141\x72", array("\163\151\164\x65\125\122\114" => site_url(), "\157\164\x70\124\x79\x70\145" => $this->_otpType, "\x6e\x6f\156\x63\145" => wp_create_nonce($this->_nonce), "\x62\165\164\164\157\x6e\164\145\170\164" => mo_($this->_buttonText), "\x66\x69\x65\x6c\x64" => $this->_otpType === $this->_typePhoneTag ? $this->_phoneKey : "\165\163\145\x72\137\145\155\x61\x69\x6c", "\151\155\x67\x55\122\114" => MOV_LOADER_URL));
        wp_enqueue_script("\x6d\157\x76\x75\155");
    }
    function isPhoneVerificationEnabled()
    {
        $CU = $this->getVerificationType();
        return $CU === VerificationType::PHONE || $CU === VerificationType::BOTH;
    }
    function miniorange_um2_user_registration($co, $LD)
    {
        $HV = $this->getVerificationType();
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto nq;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar) && $this->_isAjaxForm) {
            goto Vr;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $LD = $this->extractArgs($LD);
        $this->startOtpTransaction($LD["\165\x73\145\162\137\154\157\x67\x69\x6e"], $LD["\x75\163\145\162\137\x65\x6d\x61\x69\x6c"], new WP_Error(), $LD[$this->_phoneKey], $LD["\165\163\145\162\x5f\160\141\x73\x73\x77\x6f\x72\144"], null);
        goto Aa;
        nq:
        $this->unsetOTPSessionVariables();
        return $co;
        goto Aa;
        Vr:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        Aa:
        return $co;
    }
    private function extractArgs($LD)
    {
        return array("\x75\163\145\x72\137\154\x6f\x67\x69\x6e" => $LD["\165\x73\145\162\x5f\154\157\147\x69\x6e"], "\165\163\145\162\137\145\x6d\141\151\154" => $LD["\165\163\x65\x72\x5f\145\x6d\141\x69\x6c"], $this->_phoneKey => $LD[$this->_phoneKey], "\165\163\145\162\137\160\141\x73\163\x77\157\162\144" => $LD["\165\x73\145\x72\x5f\160\141\163\x73\x77\157\x72\144"]);
    }
    function miniorange_um_user_registration($LD)
    {
        $errors = new WP_Error();
        MoUtility::initialize_transaction($this->_formSessionVar);
        foreach ($LD as $Zm => $zs) {
            if ($Zm == "\x75\x73\145\162\x5f\x6c\x6f\x67\151\x6e") {
                goto Vz;
            }
            if ($Zm == "\x75\163\x65\162\137\x65\x6d\x61\x69\154") {
                goto Xs;
            }
            if ($Zm == "\165\x73\145\162\137\160\x61\163\163\167\157\162\x64") {
                goto i8;
            }
            if ($Zm == $this->_phoneKey) {
                goto H6;
            }
            $tA[$Zm] = $zs;
            goto U2;
            Vz:
            $HR = $zs;
            goto U2;
            Xs:
            $h4 = $zs;
            goto U2;
            i8:
            $hs = $zs;
            goto U2;
            H6:
            $J9 = $zs;
            U2:
            VJ:
        }
        QA:
        $this->startOtpTransaction($HR, $h4, $errors, $J9, $hs, $tA);
    }
    function startOtpTransaction($HR, $h4, $errors, $J9, $hs, $tA)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Dk;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto n6;
        }
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::EMAIL, $hs, $tA);
        goto mf;
        Dk:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::PHONE, $hs, $tA);
        goto mf;
        n6:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::BOTH, $hs, $tA);
        mf:
    }
    function miniorange_um2_phone_validation($LD)
    {
        $form = UM()->form();
        foreach ($LD as $Zm => $zs) {
            if ($this->_isAjaxForm && $Zm === $this->_formKey) {
                goto de;
            }
            if ($Zm === $this->_phoneKey) {
                goto Mp;
            }
            goto l4;
            de:
            $this->checkIntegrityAndValidateOTP($form, $zs, $LD);
            goto l4;
            Mp:
            $this->processPhoneNumbers($zs, $Zm, $form);
            l4:
            Ol:
        }
        MF:
    }
    private function processPhoneNumbers($zs, $Zm, $form = null)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($zs)) {
            goto Fj;
        }
        $SF = str_replace("\x23\43\x70\150\x6f\156\145\43\x23", $zs, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($Zm, $SF);
        Fj:
        $this->checkDuplicates($zs, $Zm, $form);
    }
    private function checkDuplicates($zs, $Zm, $form = null)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($zs, $Zm))) {
            goto HX;
        }
        $SF = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        if ($this->_isAjaxForm && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto yh;
        }
        $form->add_error($Zm, $SF);
        goto QQ;
        yh:
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        QQ:
        HX:
    }
    private function checkIntegrityAndValidateOTP($form, $zs, array $LD)
    {
        $HV = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto vx;
        }
        $form->add_error($this->_formKey, MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        return;
        vx:
        $this->checkIntegrity($form, $LD, $HV);
        $this->validateChallenge($HV, NULL, $zs);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto Qa;
        }
        $form->add_error($this->_formKey, MoUtility::_get_invalid_otp_method());
        Qa:
    }
    private function checkIntegrity($mT, array $LD, $HV)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto tw;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto us;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $LD["\165\x73\x65\x72\x5f\145\155\141\151\x6c"])) {
            goto mh;
        }
        $mT->add_error($this->_formKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        mh:
        us:
        goto cs;
        tw:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $LD[$this->_phoneKey])) {
            goto ft;
        }
        $mT->add_error($this->_formKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        ft:
        cs:
    }
    function miniorange_um_phone_validation($LD)
    {
        global $ultimatemember;
        foreach ($LD as $Zm => $zs) {
            if ($this->_isAjaxForm && $Zm === $this->_formKey) {
                goto RW;
            }
            if ($Zm === $this->_phoneKey) {
                goto ME;
            }
            goto x2;
            RW:
            $this->checkIntegrityAndValidateOTP($ultimatemember->form, $zs, $LD);
            goto x2;
            ME:
            $this->processPhoneNumbers($zs, $Zm, $ultimatemember->form);
            x2:
            p0:
        }
        si:
    }
    function isPhoneNumberAlreadyInUse($fk, $Zm)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($fk);
        $V_ = "\123\105\114\x45\x43\x54\x20\x60\x75\163\145\x72\137\x69\144\x60\40\106\122\x4f\115\40\140{$wpdb->prefix}\x75\163\x65\162\155\145\164\141\x60\40\x57\x48\105\122\105\40\140\x6d\145\x74\x61\x5f\153\145\171\140\x20\75\x20\47{$Zm}\47\40\x41\116\x44\40\x60\155\x65\164\x61\x5f\x76\141\x6c\165\x65\140\x20\75\x20\40\x27{$fk}\x27";
        $h8 = $wpdb->get_row($V_);
        return !MoUtility::isBlank($h8);
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto uT;
        }
        return;
        uT:
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        if ($this->_isAjaxForm) {
            goto sX;
        }
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
        sX:
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        if (function_exists("\x69\x73\137\x70\x6c\165\x67\x69\x6e\x5f\x61\x63\164\151\x76\x65")) {
            goto Po;
        }
        include_once ABSPATH . "\167\160\x2d\x61\x64\x6d\151\x6e\x2f\151\x6e\x63\154\165\x64\145\163\57\x70\x6c\x75\x67\151\156\x2e\160\x68\160";
        Po:
        if ($this->isUltimateMemberV2Installed()) {
            goto aG;
        }
        $this->register_ultimateMember_user($wB, $CG, $hs, $J9, $tA);
        goto Q3;
        aG:
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
        Q3:
    }
    function register_ultimateMember_user($wB, $CG, $hs, $J9, $tA)
    {
        $LD = array();
        $LD["\x75\163\x65\x72\137\154\157\x67\151\156"] = $wB;
        $LD["\x75\163\x65\162\137\145\x6d\141\x69\x6c"] = $CG;
        $LD["\x75\x73\145\162\x5f\x70\141\x73\163\x77\x6f\x72\x64"] = $hs;
        $LD = array_merge($LD, $tA);
        $ZS = wp_create_user($wB, $hs, $CG);
        $this->unsetOTPSessionVariables();
        do_action("\165\x6d\x5f\x61\x66\x74\x65\162\137\x6e\145\167\x5f\x75\x73\145\162\x5f\x72\x65\x67\151\x73\x74\145\x72", $ZS, $LD);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto QH;
        }
        array_push($zX, $this->_phoneFormId);
        QH:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto dQ;
        }
        return;
        dQ:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\x6d\137\x64\x65\x66\x61\x75\154\x74\137\x65\156\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\165\155\x5f\x65\x6e\x61\x62\154\145\x5f\164\x79\160\145");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x75\155\137\162\x65\x73\164\162\x69\143\x74\x5f\x64\165\160\x6c\151\x63\141\164\x65\x73");
        $this->_isAjaxForm = $this->sanitizeFormPOST("\x75\x6d\x5f\x69\163\x5f\141\x6a\x61\170\x5f\146\x6f\x72\x6d");
        $this->_buttonText = $this->sanitizeFormPOST("\165\155\x5f\142\165\x74\x74\157\156\137\x74\x65\170\164");
        $this->_formKey = $this->sanitizeFormPOST("\165\x6d\x5f\166\145\162\151\146\171\x5f\x6d\145\x74\x61\137\x6b\145\171");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x6d\x5f\160\150\157\x6e\x65\x5f\153\145\171");
        if (!$this->basicValidationCheck(BaseMessages::UM_CHOOSE)) {
            goto zU;
        }
        update_mo_option("\165\x6d\x5f\160\150\157\x6e\145\137\153\145\171", $this->_phoneKey);
        update_mo_option("\165\155\137\144\145\x66\141\x75\154\164\x5f\145\156\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\165\155\137\x65\156\x61\142\154\145\x5f\164\171\160\x65", $this->_otpType);
        update_mo_option("\x75\x6d\x5f\162\145\x73\164\x72\x69\x63\x74\x5f\x64\165\160\x6c\x69\143\141\164\145\x73", $this->_restrictDuplicates);
        update_mo_option("\165\x6d\137\151\x73\x5f\x61\x6a\141\x78\x5f\x66\157\x72\x6d", $this->_isAjaxForm);
        update_mo_option("\165\155\137\x62\x75\x74\164\157\x6e\137\x74\145\170\x74", $this->_buttonText);
        update_mo_option("\165\x6d\137\x76\x65\x72\x69\146\171\x5f\x6d\145\x74\141\137\153\145\171", $this->_formKey);
        zU:
    }
}
