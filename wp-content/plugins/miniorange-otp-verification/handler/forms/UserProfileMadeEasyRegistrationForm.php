<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UserProfileMadeEasyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UPME_REG;
        $this->_typePhoneTag = "\155\x6f\137\x75\160\155\145\x5f\x70\x68\x6f\156\145\x5f\x65\156\x61\x62\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\165\x70\x6d\x65\137\145\155\x61\151\154\x5f\x65\x6e\141\x62\x6c\x65";
        $this->_typeBothTag = "\x6d\157\137\165\160\155\145\x5f\142\x6f\x74\150\137\x65\x6e\x61\x62\x6c\x65";
        $this->_formKey = "\x55\x50\115\x45\x5f\x46\x4f\x52\x4d";
        $this->_formName = mo_("\x55\x73\145\x72\x50\x72\157\146\x69\x6c\x65\40\x4d\x61\144\145\x20\105\141\x73\x79\x20\x52\x65\x67\x69\163\x74\162\141\x74\151\157\x6e\40\106\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x75\160\155\145\137\x64\145\146\141\x75\154\x74\137\x65\x6e\x61\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::UPME_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\165\160\155\145\x5f\145\x6e\141\142\x6c\145\137\x74\171\x70\145");
        $this->_phoneKey = get_mo_option("\165\x70\x6d\x65\137\160\150\157\156\145\137\153\145\171");
        $this->_phoneFormId = "\151\x6e\x70\165\x74\133\156\x61\155\145\75" . $this->_phoneKey . "\x5d";
        add_filter("\x69\156\163\145\x72\164\x5f\x75\x73\x65\162\137\155\x65\164\x61", array($this, "\155\151\156\151\157\162\141\156\147\x65\x5f\x75\160\155\x65\x5f\x69\156\163\x65\162\x74\x5f\x75\x73\x65\162"), 1, 3);
        add_filter("\x75\160\x6d\145\x5f\162\x65\x67\x69\163\164\162\x61\x74\151\x6f\x6e\137\143\x75\163\164\157\155\x5f\146\x69\145\x6c\x64\137\164\x79\x70\x65\137\x72\145\163\164\x72\151\143\x74\151\x6f\156\163", array($this, "\x6d\151\x6e\151\157\162\x61\x6e\x67\145\137\x75\x70\155\145\x5f\x63\150\x65\x63\153\137\x70\150\x6f\156\x65"), 1, 2);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto iU;
        }
        if (array_key_exists("\165\x70\x6d\x65\x2d\162\x65\147\151\163\164\145\x72\55\146\157\162\x6d", $_POST) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Z4;
        }
        goto tY;
        iU:
        $this->unsetOTPSessionVariables();
        goto tY;
        Z4:
        $this->_handle_upme_form_submit($_POST);
        tY:
    }
    function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV === VerificationType::PHONE || $HV === VerificationType::BOTH;
    }
    function _handle_upme_form_submit($NF)
    {
        $lc = '';
        foreach ($NF as $Zm => $zs) {
            if (!($Zm == $this->_phoneKey)) {
                goto A_;
            }
            $lc = $zs;
            goto qB;
            A_:
            S6:
        }
        qB:
        $this->miniorange_upme_user($_POST["\165\x73\x65\162\x5f\154\157\x67\151\156"], $_POST["\165\x73\145\x72\137\x65\155\x61\x69\x6c"], $lc);
    }
    function miniorange_upme_insert_user($pp, $user, $q6)
    {
        $T3 = MoPHPSessions::getSessionVar("\146\151\x6c\x65\137\165\x70\154\157\141\144");
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) || !$T3)) {
            goto Nq;
        }
        return $pp;
        Nq:
        foreach ($T3 as $Zm => $zs) {
            $Rl = get_user_meta($user->ID, $Zm, true);
            if (!('' != $Rl)) {
                goto O5;
            }
            upme_delete_uploads_folder_files($Rl);
            O5:
            update_user_meta($user->ID, $Zm, $zs);
            RK:
        }
        S4:
        return $pp;
    }
    function miniorange_upme_check_phone($errors, $KB)
    {
        global $phoneLogic;
        if (!empty($errors)) {
            goto Hg;
        }
        if (!($KB["\x6d\x65\164\x61"] == $this->_phoneKey)) {
            goto Bw;
        }
        if (MoUtility::validatePhoneNumber($KB["\x76\141\x6c\x75\x65"])) {
            goto nx;
        }
        $errors[] = str_replace("\x23\43\x70\150\x6f\156\145\43\x23", $KB["\166\141\154\165\x65"], $phoneLogic->_get_otp_invalid_format_message());
        nx:
        Bw:
        Hg:
        return $errors;
    }
    function miniorange_upme_user($UK, $CG, $J9)
    {
        global $upme_register;
        $upme_register->prepare($_POST);
        $upme_register->handle();
        $T3 = array();
        if (MoUtility::isBlank($upme_register->errors)) {
            goto V3;
        }
        return;
        V3:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->processFileUpload($T3);
        MoPHPSessions::addSessionVar("\146\x69\x6c\145\137\x75\160\154\x6f\x61\144", $T3);
        $this->processAndStartOTPVerification($UK, $CG, $J9);
    }
    function processFileUpload(&$T3)
    {
        if (!empty($_FILES)) {
            goto Vk;
        }
        return;
        Vk:
        $cw = wp_upload_dir();
        $Z1 = $cw["\142\141\163\145\x64\151\162"] . "\x2f\x75\x70\x6d\x65\x2f";
        if (is_dir($Z1)) {
            goto Ra;
        }
        mkdir($Z1, 511);
        Ra:
        foreach ($_FILES as $Zm => $HN) {
            $Wb = sanitize_file_name(basename($HN["\x6e\141\155\145"]));
            $Z1 = $Z1 . time() . "\137" . $Wb;
            $v2 = $cw["\142\141\163\145\x75\162\x6c"] . "\57\x75\160\x6d\x65\x2f";
            $v2 = $v2 . time() . "\x5f" . $Wb;
            move_uploaded_file($HN["\x74\x6d\160\x5f\x6e\141\155\145"], $Z1);
            $T3[$Zm] = $v2;
            pS:
        }
        O0:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto X9;
        }
        array_push($zX, $this->_phoneFormId);
        X9:
        return $zX;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    function processAndStartOTPVerification($UK, $CG, $J9)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto kp;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto re;
        }
        $this->sendChallenge($UK, $CG, null, $J9, VerificationType::EMAIL);
        goto cO;
        re:
        $this->sendChallenge($UK, $CG, null, $J9, VerificationType::BOTH);
        cO:
        goto Fw;
        kp:
        $this->sendChallenge($UK, $CG, null, $J9, VerificationType::PHONE);
        Fw:
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto g9;
        }
        return;
        g9:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\x70\155\145\x5f\x64\x65\x66\x61\165\154\164\x5f\x65\x6e\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x75\160\x6d\x65\137\145\x6e\141\142\x6c\x65\x5f\x74\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x70\x6d\x65\x5f\160\x68\x6f\x6e\145\x5f\146\x69\145\154\144\x5f\153\145\x79");
        update_mo_option("\x75\160\x6d\x65\137\144\145\146\x61\x75\x6c\164\x5f\x65\156\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\165\x70\155\x65\137\x65\x6e\141\x62\x6c\145\x5f\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\x75\x70\155\145\x5f\x70\x68\x6f\x6e\145\137\x6b\x65\x79", $this->_phoneKey);
    }
}
