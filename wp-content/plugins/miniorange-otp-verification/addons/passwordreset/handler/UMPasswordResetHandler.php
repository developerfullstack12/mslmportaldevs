<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use UM;
use um\core\Form;
use um\core\Options;
use um\core\Password;
use um\core\User;
use WP_User;
class UMPasswordResetHandler extends FormHandler implements IFormHandler
{
    use Instance;
    private $_fieldKey;
    private $_isOnlyPhoneReset;
    protected function __construct()
    {
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->_formOption = "\x75\x6d\x5f\x70\141\x73\x73\x77\x6f\162\x64\137\x72\x65\x73\145\164\x5f\x68\x61\156\x64\x6c\145\x72";
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_PASS;
        $this->_typePhoneTag = "\x6d\x6f\137\165\x6d\137\x70\150\157\x6e\x65\137\145\156\141\x62\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x75\155\137\x65\155\141\x69\154\x5f\x65\156\141\142\154\x65";
        $this->_phoneFormId = "\x75\x73\x65\162\156\x61\x6d\x65\x5f\142";
        $this->_fieldKey = "\x75\x73\145\x72\156\141\x6d\x65\x5f\142";
        $this->_formKey = "\x55\114\124\x49\115\x41\x54\105\137\120\x41\x53\x53\137\x52\x45\x53\105\124";
        $this->_formName = mo_("\x55\x6c\x74\x69\155\141\164\145\40\x4d\x65\x6d\x62\145\162\40\x50\x61\x73\x73\167\157\162\144\40\122\145\163\x65\x74\40\165\x73\151\156\x67\40\117\x54\x50");
        $this->_isFormEnabled = get_umpr_option("\160\141\x73\x73\137\x65\x6e\x61\142\154\145") ? TRUE : FALSE;
        $this->_generateOTPAction = "\x6d\157\137\165\x6d\x70\162\137\163\x65\x6e\x64\x5f\157\x74\160";
        $this->_buttonText = get_umpr_option("\160\x61\x73\163\x5f\142\x75\x74\164\157\156\137\164\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\122\x65\163\x65\x74\x20\120\x61\163\163\167\157\x72\144");
        $this->_phoneKey = get_umpr_option("\160\141\163\x73\x5f\160\x68\x6f\x6e\x65\113\x65\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\x6d\157\142\x69\x6c\x65\137\x6e\165\155\142\x65\x72";
        $this->_isOnlyPhoneReset = get_umpr_option("\x6f\x6e\154\171\137\x70\x68\157\156\x65\137\162\145\x73\145\164");
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_umpr_option("\x65\x6e\x61\142\154\145\144\137\x74\x79\x70\145");
        if (!$this->_isOnlyPhoneReset) {
            goto cR;
        }
        $this->_phoneFormId = "\151\x6e\160\165\164\43\x75\x73\145\x72\x6e\x61\x6d\x65\137\142";
        cR:
        add_action("\167\160\x5f\x61\x6a\141\x78\137\156\x6f\160\162\x69\166\137" . $this->_generateOTPAction, array($this, "\x73\145\156\144\x41\x6a\x61\170\x4f\x54\x50\122\x65\x71\165\x65\x73\164"));
        add_action("\x77\x70\x5f\141\152\141\x78\x5f" . $this->_generateOTPAction, array($this, "\163\145\x6e\x64\x41\x6a\141\170\117\x54\x50\122\145\161\165\145\x73\164"));
        add_action("\167\x70\137\x65\156\161\x75\145\x75\x65\x5f\163\143\x72\151\160\x74\x73", array($this, "\155\x69\x6e\x69\157\162\141\156\x67\145\x5f\162\x65\147\151\x73\164\x65\162\137\x75\x6d\137\x73\x63\x72\151\x70\164"));
        add_action("\165\155\137\x72\145\163\145\x74\x5f\160\141\163\x73\x77\157\162\x64\137\x65\162\x72\157\162\x73\x5f\150\157\157\x6b", array($this, "\x75\155\137\162\x65\x73\145\x74\137\x70\x61\163\163\x77\x6f\x72\144\137\x65\x72\x72\x6f\x72\163\x5f\x68\x6f\157\x6b"), 99);
        add_action("\165\x6d\x5f\x72\x65\x73\145\164\x5f\x70\141\x73\x73\x77\157\x72\x64\x5f\x70\x72\x6f\x63\145\x73\x73\137\x68\x6f\x6f\x6b", array($this, "\165\155\137\162\145\x73\145\164\137\x70\141\163\x73\x77\157\162\144\137\x70\x72\157\143\x65\x73\163\x5f\150\x6f\157\153"), 1);
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $HR = MoUtility::sanitizeCheck("\165\x73\145\x72\x6e\141\x6d\145", $_POST);
        SessionUtils::addUserInSession($this->_formSessionVar, $HR);
        $user = $this->getUser($HR);
        if (!$user) {
            goto hv;
        }
        $fk = get_user_meta($user->ID, $this->_phoneKey, true);
        $this->startOtpTransaction(null, $user->user_email, null, $fk, null, null);
        goto WL;
        hv:
        if ($this->_isOnlyPhoneReset) {
            goto cI;
        }
        wp_send_json(MoUtility::createJson(UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_NOT_EXIST), "\x65\162\x72\x6f\162"));
        goto Ku;
        cI:
        wp_send_json(MoUtility::createJson(UMPasswordResetMessages::showMessage(UMPasswordResetMessages::RESET_LABEL_OP), "\x65\162\162\157\162"));
        Ku:
        WL:
    }
    public function um_reset_password_process_hook()
    {
        $user = MoUtility::sanitizeCheck("\x75\163\145\162\156\x61\155\x65\137\142", $_POST);
        $user = $this->getUser(trim($user));
        $ll = $this->getUmPwdObj();
        um_fetch_user($user->ID);
        $this->getUmUserObj()->password_reset();
        wp_redirect($ll->reset_url());
        die;
    }
    public function um_reset_password_errors_hook()
    {
        $form = $this->getUmFormObj();
        $HR = MoUtility::sanitizeCheck($this->_fieldKey, $_POST);
        if (!isset($form->errors)) {
            goto pN;
        }
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($HR))) {
            goto pT;
        }
        $user = $this->getUserFromPhoneNumber($HR);
        if (!$user) {
            goto eD;
        }
        $form->errors = null;
        if (isset($form->errors)) {
            goto Pw;
        }
        $this->check_reset_password_limit($form, $user->ID);
        Pw:
        goto XR;
        eD:
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_NOT_EXIST));
        XR:
        pT:
        pN:
        if (isset($form->errors)) {
            goto Xg;
        }
        $this->checkIntegrityAndValidateOTP($form, MoUtility::sanitizeCheck("\166\x65\162\x69\146\x79\137\146\x69\x65\x6c\144", $_POST), $_POST);
        Xg:
    }
    private function checkIntegrityAndValidateOTP(&$form, $zs, array $LD)
    {
        $HV = $this->getVerificationType();
        $this->checkIntegrity($form, $LD);
        $this->validateChallenge($HV, NULL, $zs);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto pB;
        }
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::INVALID_OTP));
        pB:
    }
    private function checkIntegrity($mT, array $LD)
    {
        $FD = SessionUtils::getUserSubmitted($this->_formSessionVar);
        if (!($FD !== $LD[$this->_fieldKey])) {
            goto RM;
        }
        $mT->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_MISMATCH));
        RM:
    }
    public function getUserId($user)
    {
        $user = $this->getUser($user);
        return $user ? $user->ID : false;
    }
    public function getUser($HR)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($HR)) {
            goto Gs;
        }
        if (is_email($HR)) {
            goto ty;
        }
        $user = get_user_by("\x6c\x6f\x67\x69\156", $HR);
        goto C2;
        ty:
        $user = get_user_by("\x65\155\141\151\154", $HR);
        C2:
        goto UD;
        Gs:
        $HR = MoUtility::processPhoneNumber($HR);
        $user = $this->getUserFromPhoneNumber($HR);
        UD:
        return $user;
    }
    function getUserFromPhoneNumber($HR)
    {
        global $wpdb;
        $h8 = $wpdb->get_row("\x53\105\114\105\x43\x54\x20\140\x75\x73\x65\x72\137\151\144\140\x20\x46\x52\x4f\x4d\40\x60{$wpdb->prefix}\x75\163\145\162\x6d\x65\164\x61\x60\x20\x57\x48\x45\x52\x45\40\140\x6d\x65\164\141\137\153\x65\171\140\x20\x3d\40\47{$this->_phoneKey}\47\x20\x41\116\x44\x20\x60\x6d\x65\x74\141\x5f\x76\x61\154\x75\x65\140\x20\x3d\x20\x20\47{$HR}\x27");
        return !MoUtility::isBlank($h8) ? get_userdata($h8->user_id) : false;
    }
    public function check_reset_password_limit(Form &$form, $ZS)
    {
        $f_ = (int) get_user_meta($ZS, "\160\x61\163\x73\167\157\162\144\x5f\162\163\x74\137\141\164\x74\x65\x6d\x70\x74\163", true);
        $S7 = user_can(intval($ZS), "\155\141\156\141\x67\x65\137\157\x70\164\151\157\x6e\163");
        if (!$this->getUmOptions()->get("\x65\x6e\141\142\154\x65\137\162\145\x73\x65\x74\137\160\x61\163\163\x77\x6f\x72\144\137\154\151\x6d\x69\164")) {
            goto TX;
        }
        if ($this->getUmOptions()->get("\x64\x69\x73\141\x62\154\x65\x5f\141\x64\x6d\151\x6e\x5f\x72\145\x73\145\164\x5f\x70\141\163\163\x77\157\162\x64\x5f\x6c\x69\x6d\x69\164") && $S7) {
            goto hI;
        }
        $d8 = $this->getUmOptions()->get("\162\145\x73\x65\164\x5f\x70\141\x73\x73\167\x6f\162\x64\x5f\154\x69\155\151\x74\x5f\156\165\155\142\x65\162");
        if ($f_ >= $d8) {
            goto FW;
        }
        update_user_meta($ZS, "\x70\141\163\x73\167\157\162\x64\137\162\163\x74\137\141\164\x74\145\155\x70\164\163", $f_ + 1);
        goto hk;
        FW:
        $form->add_error($this->_fieldKey, __("\x59\157\165\40\150\141\166\x65\40\x72\x65\141\143\150\x65\x64\40\x74\x68\x65\x20\154\151\x6d\151\164\40\146\x6f\x72\x20\x72\x65\x71\165\x65\163\x74\151\x6e\147\x20\x70\141\163\x73\167\x6f\x72\144\x20\x22\56\xd\12\40\40\x20\40\x20\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\x20\x20\42\143\x68\x61\x6e\x67\145\40\x66\157\162\40\x74\150\x69\x73\x20\x75\x73\145\x72\x20\141\154\x72\145\141\144\x79\56\x20\103\157\x6e\x74\x61\143\x74\x20\163\x75\x70\160\x6f\x72\x74\x20\x69\146\x20\x79\157\165\x20\143\x61\156\156\x6f\164\x20\157\x70\x65\x6e\40\164\150\145\40\x65\155\141\x69\x6c", "\x75\154\164\x69\155\x61\x74\145\55\155\x65\155\142\x65\x72"));
        hk:
        goto dy;
        hI:
        dy:
        TX:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto Rz;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto AM;
        Rz:
        return UM()->form();
        AM:
    }
    private function getUmUserObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto kQ;
        }
        global $ultimatemember;
        return $ultimatemember->user;
        goto gq;
        kQ:
        return UM()->user();
        gq:
    }
    private function getUmPwdObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto Te;
        }
        global $ultimatemember;
        return $ultimatemember->password;
        goto B0;
        Te:
        return UM()->password();
        B0:
    }
    private function getUmOptions()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto CN;
        }
        global $ultimatemember;
        return $ultimatemember->options;
        goto T9;
        CN:
        return UM()->options();
        T9:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\151\x73\x5f\160\154\x75\147\151\x6e\x5f\141\143\x74\151\166\145")) {
            goto M7;
        }
        include_once ABSPATH . "\x77\160\x2d\141\144\155\151\156\57\151\x6e\143\x6c\x75\144\145\x73\57\x70\154\x75\147\x69\156\x2e\x70\150\x70";
        M7:
        return is_plugin_active("\x75\154\x74\x69\155\141\x74\x65\x2d\155\x65\x6d\142\145\x72\57\165\x6c\164\x69\155\x61\x74\x65\x2d\155\145\155\x62\145\162\x2e\160\x68\160");
    }
    private function startOtpTransaction($HR, $h4, $errors, $J9, $hs, $tA)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Em;
        }
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::EMAIL, $hs, $tA);
        goto fS;
        Em:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::PHONE, $hs, $tA);
        fS:
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\155\x6f\x75\155\x70\x72", UMPR_URL . "\151\x6e\x63\154\165\x64\145\x73\57\x6a\163\57\155\157\165\x6d\x70\162\56\x6d\151\156\x2e\x6a\163", array("\x6a\x71\165\x65\x72\x79"));
        wp_localize_script("\155\x6f\x75\155\160\x72", "\155\x6f\x75\155\x70\x72\166\x61\162", array("\163\x69\x74\x65\125\x52\x4c" => wp_ajax_url(), "\x6e\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\x62\x75\164\x74\157\x6e\x74\x65\x78\164" => mo_($this->_buttonText), "\x69\155\147\x55\122\x4c" => MOV_LOADER_URL, "\141\x63\x74\151\x6f\156" => array("\163\x65\156\x64" => $this->_generateOTPAction), "\146\x69\x65\x6c\144\113\145\x79" => $this->_fieldKey, "\x72\x65\163\145\164\114\141\x62\145\x6c\x54\x65\x78\164" => UMPasswordResetMessages::showMessage($this->_isOnlyPhoneReset ? UMPasswordResetMessages::RESET_LABEL_OP : UMPasswordResetMessages::RESET_LABEL), "\x70\x68\x54\145\170\x74" => $this->_isOnlyPhoneReset ? mo_("\105\156\x74\x65\162\x20\131\x6f\165\x72\x20\x50\x68\x6f\x6e\x65\40\116\x75\x6d\x62\145\162") : mo_("\105\156\164\x65\x72\x20\x59\x6f\165\162\40\x45\155\141\151\x6c\x2c\40\125\163\x65\162\156\141\x6d\145\40\x6f\x72\40\x50\x68\x6f\x6e\145\40\x4e\165\x6d\x62\145\162")));
        wp_enqueue_script("\x6d\x6f\x75\155\160\162");
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
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Ph;
        }
        return;
        Ph:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\155\x5f\160\162\x5f\145\x6e\141\142\x6c\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\165\x6d\x5f\160\x72\137\142\165\x74\164\157\x6e\137\164\x65\170\164");
        $this->_buttonText = $this->_buttonText ? $this->_buttonText : "\122\x65\163\145\164\40\x50\141\x73\163\167\157\x72\144";
        $this->_otpType = $this->sanitizeFormPOST("\x75\x6d\x5f\x70\162\137\145\156\141\142\x6c\145\137\x74\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\155\x5f\160\162\x5f\160\150\x6f\x6e\x65\x5f\x66\151\x65\154\144\137\153\x65\171");
        $this->_isOnlyPhoneReset = $this->sanitizeFormPOST("\x75\x6d\x5f\x70\x72\137\x6f\156\x6c\171\137\x70\x68\x6f\156\145");
        update_umpr_option("\157\156\x6c\x79\137\160\x68\157\156\145\137\x72\145\x73\145\164", $this->_isOnlyPhoneReset);
        update_umpr_option("\160\141\x73\x73\x5f\x65\x6e\x61\142\154\x65", $this->_isFormEnabled);
        update_umpr_option("\160\x61\163\163\x5f\x62\165\x74\164\x6f\156\x5f\164\x65\x78\x74", $this->_buttonText);
        update_umpr_option("\x65\156\141\x62\154\x65\x64\x5f\164\171\x70\145", $this->_otpType);
        update_umpr_option("\160\141\163\x73\x5f\160\150\157\x6e\x65\113\x65\x79", $this->_phoneKey);
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto wM;
        }
        array_push($zX, $this->_phoneFormId);
        wM:
        return $zX;
    }
    public function getIsOnlyPhoneReset()
    {
        return $this->_isOnlyPhoneReset;
    }
}
