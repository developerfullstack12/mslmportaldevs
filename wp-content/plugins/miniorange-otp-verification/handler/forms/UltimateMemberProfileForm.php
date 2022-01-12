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
use UM\Core\Form;
class UltimateMemberProfileForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_verifyFieldKey;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::UM_PROFILE_UPDATE;
        $this->_typePhoneTag = "\x6d\x6f\137\165\155\137\160\x72\x6f\146\151\x6c\145\137\160\150\x6f\x6e\145\x5f\145\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\x75\x6d\x5f\160\162\x6f\146\151\154\145\x5f\x65\x6d\x61\x69\154\137\145\x6e\x61\142\x6c\x65";
        $this->_typeBothTag = "\x6d\x6f\x5f\x75\x6d\x5f\x70\162\157\x66\151\154\145\x5f\x62\157\x74\x68\x5f\x65\156\x61\x62\154\145";
        $this->_formKey = "\125\114\x54\111\x4d\101\124\x45\137\120\x52\x4f\x46\x49\x4c\105\x5f\x46\117\122\x4d";
        $this->_verifyFieldKey = "\166\x65\162\x69\x66\171\x5f\146\151\145\154\144";
        $this->_formName = mo_("\x55\154\164\151\155\x61\164\x65\40\115\145\155\142\145\x72\40\120\162\157\x66\x69\x6c\145\x2f\x41\x63\x63\157\x75\x6e\x74\40\106\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\x75\x6d\x5f\x70\162\x6f\146\151\154\145\137\x65\x6e\141\x62\x6c\145");
        $this->_restrictDuplicates = get_mo_option("\165\155\x5f\x70\162\157\146\x69\154\x65\137\x72\145\x73\164\162\151\x63\x74\137\x64\x75\160\154\x69\143\141\164\145\163");
        $this->_buttonText = get_mo_option("\x75\155\x5f\160\x72\157\146\151\154\x65\137\142\165\164\164\x6f\156\x5f\x74\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\151\143\153\40\110\x65\162\x65\x20\164\157\x20\x73\x65\x6e\144\x20\x4f\124\120");
        $this->_emailKey = "\x75\163\145\x72\x5f\x65\155\x61\151\x6c";
        $this->_phoneKey = get_mo_option("\165\155\137\160\x72\x6f\x66\151\x6c\x65\137\160\x68\157\156\x65\x5f\153\x65\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\155\x6f\142\151\154\145\x5f\x6e\165\155\x62\x65\x72";
        $this->_phoneFormId = "\151\x6e\x70\x75\x74\133\x6e\x61\155\x65\x5e\x3d\47{$this->_phoneKey}\x27\x5d";
        $this->_formDocuments = MoOTPDocs::UM_PROFILE;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\x6d\137\160\x72\157\146\x69\154\x65\x5f\x65\x6e\x61\x62\x6c\x65\x5f\164\x79\160\x65");
        add_action("\167\160\x5f\x65\156\161\165\145\x75\145\137\x73\143\x72\x69\x70\164\163", array($this, "\x6d\x69\x6e\151\157\162\141\x6e\147\x65\x5f\162\x65\147\151\x73\x74\145\162\137\165\x6d\x5f\x73\x63\x72\151\x70\164"));
        add_action("\x75\x6d\137\163\165\142\x6d\x69\x74\137\x61\143\143\x6f\x75\156\164\x5f\x65\162\162\157\x72\163\137\150\157\157\153", array($this, "\x6d\x69\x6e\x69\157\162\141\x6e\x67\x65\137\x75\x6d\x5f\166\x61\x6c\151\x64\x61\x74\151\x6f\x6e"), 99, 1);
        add_action("\x75\x6d\137\x61\144\144\x5f\145\162\x72\157\162\137\x6f\156\137\x66\157\x72\155\x5f\x73\165\x62\155\151\164\137\166\141\x6c\151\x64\x61\164\151\x6f\x6e", array($this, "\x6d\151\x6e\x69\157\x72\141\x6e\147\x65\137\165\155\x5f\160\162\x6f\146\151\x6c\145\x5f\166\141\x6c\151\x64\x61\x74\x69\157\x6e"), 1, 3);
        $this->routeData();
    }
    private function isAccountVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function isProfileVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function routeData()
    {
        if (array_key_exists("\157\x70\164\x69\157\156", $_GET)) {
            goto K8;
        }
        return;
        K8:
        switch (trim($_GET["\157\160\x74\151\x6f\156"])) {
            case "\155\151\156\x69\157\x72\141\x6e\x67\145\55\x75\x6d\55\141\x63\x63\55\141\x6a\x61\x78\55\166\145\x72\151\146\171":
                $this->sendAjaxOTPRequest();
                goto tT;
        }
        nN:
        tT:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $lc = MoUtility::sanitizeCheck("\165\x73\x65\x72\137\x70\x68\157\x6e\x65", $_POST);
        $CG = MoUtility::sanitizeCheck("\x75\x73\x65\x72\137\145\x6d\x61\x69\154", $_POST);
        $MG = MoUtility::sanitizeCheck("\157\164\160\x5f\162\x65\161\x75\x65\163\164\137\164\171\x70\145", $_POST);
        $this->startOtpTransaction($CG, $lc, $MG);
    }
    private function startOtpTransaction($h4, $J9, $MG)
    {
        if (strcasecmp($MG, $this->_typePhoneTag) == 0) {
            goto A6;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $h4);
        $this->sendChallenge(null, $h4, null, $J9, VerificationType::EMAIL, null, null);
        goto m5;
        A6:
        $this->checkDuplicates($J9, $this->_phoneKey);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $J9);
        $this->sendChallenge(null, $h4, null, $J9, VerificationType::PHONE, null, null);
        m5:
    }
    private function checkDuplicates($zs, $Zm)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($zs, $Zm))) {
            goto vD;
        }
        $SF = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        vD:
    }
    private function getUserData($Zm)
    {
        $current_user = wp_get_current_user();
        if ($Zm === $this->_phoneKey) {
            goto rX;
        }
        return $current_user->user_email;
        goto Vg;
        rX:
        global $wpdb;
        $V_ = "\123\x45\114\105\x43\124\40\x6d\145\164\x61\137\x76\141\154\165\145\x20\x46\122\x4f\115\x20\140{$wpdb->prefix}\165\x73\145\162\x6d\145\164\141\x60\x20\127\x48\105\122\105\40\140\x6d\145\164\x61\137\x6b\x65\x79\x60\x20\75\x20\x27{$Zm}\x27\40\101\x4e\x44\40\140\165\163\145\162\x5f\x69\x64\140\40\75\40{$current_user->ID}";
        $h8 = $wpdb->get_row($V_);
        return isset($h8) ? $h8->meta_value : '';
        Vg:
    }
    private function checkFormSession($form)
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto J8;
        }
        $form->add_error($this->_emailKey, MoUtility::_get_invalid_otp_method());
        $form->add_error($this->_phoneKey, MoUtility::_get_invalid_otp_method());
        goto Zd;
        J8:
        $this->unsetOTPSessionVariables();
        Zd:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto g_;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto KA;
        g_:
        return UM()->form();
        KA:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\x69\x73\x5f\160\x6c\165\x67\151\x6e\x5f\x61\143\164\x69\x76\145")) {
            goto V_;
        }
        include_once ABSPATH . "\x77\160\x2d\141\x64\155\x69\x6e\x2f\151\156\x63\x6c\x75\144\145\x73\57\160\x6c\x75\147\151\156\56\x70\150\x70";
        V_:
        return is_plugin_active("\x75\154\164\x69\155\x61\164\145\55\x6d\145\x6d\x62\145\162\57\165\154\x74\x69\x6d\141\164\145\x2d\155\145\x6d\142\x65\162\56\x70\x68\x70");
    }
    function isPhoneNumberAlreadyInUse($fk, $Zm)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($fk);
        $V_ = "\x53\105\114\105\103\124\40\140\x75\163\x65\162\137\151\x64\140\40\106\122\x4f\115\x20\140{$wpdb->prefix}\165\x73\x65\162\155\x65\x74\x61\140\40\127\x48\x45\x52\105\40\140\x6d\145\164\141\137\153\145\x79\x60\x20\x3d\x20\x27{$Zm}\47\x20\x41\116\104\x20\x60\155\145\x74\x61\137\166\x61\154\165\145\x60\40\x3d\x20\x20\x27{$fk}\x27";
        $h8 = $wpdb->get_row($V_);
        return !MoUtility::isBlank($h8);
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\x6d\x6f\166\165\x6d\x70\x72\x6f\146\x69\x6c\x65", MOV_URL . "\151\156\x63\x6c\x75\x64\145\163\57\152\163\57\x6d\x6f\x75\x6d\160\x72\157\146\x69\x6c\145\56\x6d\151\x6e\56\152\x73", array("\152\161\x75\145\x72\171"));
        wp_localize_script("\x6d\157\166\x75\155\160\x72\157\146\151\154\x65", "\x6d\x6f\165\155\141\x63\x76\x61\x72", array("\x73\151\x74\145\x55\x52\114" => site_url(), "\x6f\164\160\x54\x79\x70\x65" => $this->_otpType, "\145\x6d\141\x69\154\x4f\164\160\124\x79\x70\x65" => $this->_typeEmailTag, "\x70\x68\x6f\x6e\x65\x4f\164\x70\124\x79\x70\145" => $this->_typePhoneTag, "\x62\x6f\x74\x68\117\124\x50\x54\171\x70\145" => $this->_typeBothTag, "\156\157\x6e\143\x65" => wp_create_nonce($this->_nonce), "\142\165\x74\164\x6f\156\124\145\x78\164" => mo_($this->_buttonText), "\151\155\x67\x55\122\114" => MOV_LOADER_URL, "\146\157\162\155\x4b\x65\171" => $this->_verifyFieldKey, "\x65\155\x61\x69\x6c\126\x61\154\165\x65" => $this->getUserData($this->_emailKey), "\160\150\157\x6e\145\x56\141\x6c\x75\145" => $this->getUserData($this->_phoneKey), "\x70\150\157\156\145\113\145\x79" => $this->_phoneKey));
        wp_enqueue_script("\155\157\x76\x75\x6d\x70\162\x6f\x66\x69\x6c\x65");
    }
    private function userHasChangeData($QH, $LD)
    {
        $pO = $this->getUserData($QH);
        return strcasecmp($pO, $LD[$QH]) !== 0;
    }
    public function miniorange_um_validation($LD, $QH = "\x75\163\x65\x72\x5f\x65\155\x61\151\x6c")
    {
        if (!(!(isset($_POST["\137\165\x6d\137\141\143\x63\x6f\x75\156\x74\137\x74\141\142"]) && $_POST["\x5f\165\x6d\x5f\x61\x63\143\x6f\x75\156\164\x5f\x74\141\142"] == "\147\145\156\145\162\141\x6c" && isset($_POST["\x75\163\x65\x72\137\145\155\141\151\154"])) && !isset($_POST["\160\162\157\146\x69\x6c\x65\137\x6e\x6f\x6e\143\x65"]))) {
            goto f4;
        }
        return;
        f4:
        $AH = MoUtility::sanitizeCheck("\x6d\157\144\x65", $LD);
        if (!($this->userHasChangeData($QH, $LD) && $AH != "\162\x65\147\151\163\x74\145\x72")) {
            goto zG;
        }
        $form = $this->getUmFormObj();
        if ($this->isValidationRequired($QH) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto GT;
        }
        foreach ($LD as $Zm => $zs) {
            if ($Zm === $this->_verifyFieldKey) {
                goto oe;
            }
            if ($Zm === $this->_phoneKey) {
                goto Ki;
            }
            goto rz;
            oe:
            $this->checkIntegrityAndValidateOTP($form, $zs, $LD, $AH);
            goto rz;
            Ki:
            $this->processPhoneNumbers($zs, $form);
            rz:
            jm:
        }
        eS:
        goto PE;
        GT:
        $Zm = $this->isProfileVerificationEnabled() && $AH == "\160\162\x6f\146\151\154\x65" ? $this->_phoneKey : $this->_emailKey;
        $form->add_error($Zm, MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        PE:
        zG:
    }
    private function isValidationRequired($QH)
    {
        return $this->isAccountVerificationEnabled() && $QH === "\165\163\145\162\x5f\x65\155\141\151\x6c" || $this->isProfileVerificationEnabled() && $QH === $this->_phoneKey;
    }
    public function miniorange_um_profile_validation($form, $Zm, $LD)
    {
        if (!($Zm === $this->_phoneKey)) {
            goto c3;
        }
        $this->miniorange_um_validation($LD, $this->_phoneKey);
        c3:
    }
    private function processPhoneNumbers($zs, $form)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($zs)) {
            goto xW;
        }
        $SF = str_replace("\43\43\x70\x68\157\156\x65\43\x23", $zs, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($this->_phoneKey, $SF);
        xW:
        $this->checkDuplicates($zs, $this->_phoneKey);
    }
    private function checkIntegrityAndValidateOTP($form, $zs, array $LD, $AH)
    {
        $this->checkIntegrity($form, $LD);
        if (!($form->count_errors() > 0)) {
            goto fp;
        }
        return;
        fp:
        if ($this->isProfileVerificationEnabled() && $AH == "\160\162\x6f\146\151\x6c\145") {
            goto vH;
        }
        $this->validateChallenge("\x65\155\141\151\154", NULL, $zs);
        goto ib;
        vH:
        $this->validateChallenge("\x70\150\x6f\x6e\x65", NULL, $zs);
        ib:
        $this->checkFormSession($form);
    }
    private function checkIntegrity($mT, array $LD)
    {
        if (!$this->isProfileVerificationEnabled()) {
            goto qc;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $LD[$this->_phoneKey])) {
            goto h2;
        }
        $mT->add_error($this->_phoneKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        h2:
        qc:
        if (!$this->isAccountVerificationEnabled()) {
            goto PV;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $LD[$this->_emailKey])) {
            goto D_;
        }
        $mT->add_error($this->_emailKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        D_:
        PV:
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
        if (!($this->isFormEnabled() && $this->isProfileVerificationEnabled())) {
            goto He;
        }
        array_push($zX, $this->_phoneFormId);
        He:
        return $zX;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto P9;
        }
        return;
        P9:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\x6d\137\x70\x72\x6f\x66\x69\x6c\x65\137\145\156\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x75\155\x5f\x70\162\157\146\x69\154\x65\137\x65\156\x61\x62\154\x65\x5f\x74\x79\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\165\x6d\x5f\x70\162\x6f\x66\x69\154\x65\137\x62\x75\x74\164\x6f\x6e\x5f\164\x65\170\x74");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x75\x6d\x5f\x70\x72\x6f\146\x69\x6c\x65\137\162\x65\163\164\x72\151\143\164\x5f\144\165\160\x6c\x69\143\x61\x74\x65\163");
        $this->_phoneKey = $this->sanitizeFormPOST("\165\x6d\137\160\x72\157\146\x69\154\145\x5f\160\x68\157\156\x65\137\x6b\x65\x79");
        if (!$this->basicValidationCheck(BaseMessages::UM_PROFILE_CHOOSE)) {
            goto B1;
        }
        update_mo_option("\165\x6d\x5f\x70\x72\x6f\x66\151\154\145\137\x65\156\141\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\165\x6d\137\x70\x72\157\146\x69\x6c\145\137\x65\156\x61\x62\154\145\x5f\x74\x79\160\145", $this->_otpType);
        update_mo_option("\x75\x6d\137\x70\162\157\146\x69\x6c\x65\137\x62\x75\164\x74\157\x6e\x5f\x74\x65\x78\x74", $this->_buttonText);
        update_mo_option("\165\x6d\x5f\x70\162\x6f\146\x69\x6c\x65\x5f\162\145\x73\164\162\151\x63\x74\x5f\144\x75\160\x6c\x69\143\x61\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\x75\155\x5f\160\x72\x6f\146\x69\x6c\x65\x5f\160\x68\157\x6e\145\x5f\153\145\171", $this->_phoneKey);
        B1:
    }
}
