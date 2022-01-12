<?php


namespace OTP\Handler\Forms;

use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
use BP_Signup;
use WP_User;
class BuddyPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::BUDDYPRESS_REG;
        $this->_typePhoneTag = "\x6d\157\x5f\142\x62\160\137\x70\150\x6f\156\x65\x5f\x65\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\x62\x62\x70\137\145\x6d\141\x69\154\137\145\156\141\142\154\145";
        $this->_typeBothTag = "\155\x6f\137\142\142\160\x5f\x62\x6f\x74\150\x5f\145\x6e\141\x62\154\145\144";
        $this->_formKey = "\102\x50\137\104\x45\106\x41\125\x4c\124\137\x46\x4f\122\115";
        $this->_formName = mo_("\102\x75\144\x64\171\120\x72\145\163\163\x20\122\145\x67\151\163\164\x72\x61\x74\151\x6f\x6e\x20\106\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\142\142\x70\137\144\x65\x66\x61\x75\x6c\x74\x5f\x65\x6e\141\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::BBP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\x62\x62\x70\137\160\150\x6f\x6e\145\137\x6b\145\171");
        $this->_otpType = get_mo_option("\142\x62\x70\137\x65\156\141\142\x6c\x65\x5f\164\x79\x70\x65");
        $this->_disableAutoActivate = get_mo_option("\x62\x62\x70\x5f\144\151\163\141\x62\x6c\145\x5f\x61\x63\164\x69\x76\x61\x74\151\x6f\x6e");
        $this->_phoneFormId = "\151\x6e\x70\x75\x74\x5b\x6e\x61\155\x65\x3d\146\x69\145\154\x64\x5f" . $this->moBBPgetphoneFieldId() . "\x5d";
        $this->_restrictDuplicates = get_mo_option("\142\x62\160\137\162\x65\x73\164\162\x69\x63\164\137\144\x75\x70\154\151\143\141\x74\145\x73");
        add_filter("\x62\160\137\162\x65\147\151\x73\164\x72\x61\x74\x69\x6f\156\x5f\x6e\x65\145\144\163\137\141\x63\x74\151\x76\141\164\151\157\156", array($this, "\x66\x69\170\137\163\x69\x67\156\x75\x70\137\x66\x6f\x72\155\x5f\166\141\x6c\151\144\x61\x74\x69\157\156\x5f\164\145\x78\164"));
        add_filter("\142\x70\137\143\157\x72\x65\137\x73\151\x67\x6e\x75\x70\x5f\163\145\x6e\x64\137\141\x63\x74\151\x76\x61\x74\151\157\x6e\137\x6b\145\171", array($this, "\144\151\x73\x61\x62\x6c\x65\x5f\141\x63\x74\151\x76\x61\164\x69\x6f\156\137\145\155\x61\151\154"));
        add_filter("\142\x70\x5f\x73\x69\147\x6e\x75\160\x5f\165\x73\x65\x72\155\145\164\x61", array($this, "\x6d\x69\x6e\x69\157\x72\141\156\147\145\137\142\160\137\165\x73\x65\x72\137\162\145\147\151\x73\x74\162\x61\164\151\157\x6e"), 1, 1);
        add_action("\x62\x70\x5f\163\151\147\156\x75\x70\137\x76\141\x6c\151\x64\141\164\x65", array($this, "\x76\x61\154\x69\x64\x61\x74\x65\x4f\124\x50\122\145\x71\165\x65\x73\164"), 99, 0);
        if (!$this->_disableAutoActivate) {
            goto XOv;
        }
        add_action("\x62\x70\137\143\x6f\162\145\137\x73\151\147\156\x75\x70\137\x75\163\x65\x72", array($this, "\x6d\157\137\x61\x63\164\x69\166\141\164\145\x5f\x62\142\x70\137\165\x73\145\162"), 1, 5);
        XOv:
    }
    function fix_signup_form_validation_text()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function disable_activation_email()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function isPhoneVerificationEnabled()
    {
        $lr = $this->getVerificationType();
        return $lr === VerificationType::PHONE || $lr === VerificationType::BOTH;
    }
    function validateOTPRequest()
    {
        global $bp, $phoneLogic;
        $S5 = "\x66\x69\x65\154\x64\137" . $this->moBBPgetphoneFieldId();
        if (isset($_POST[$S5]) && !MoUtility::validatePhoneNumber($_POST[$S5])) {
            goto gMn;
        }
        if (!$this->isPhoneNumberAlreadyInUse($_POST[$S5])) {
            goto TZN;
        }
        $bp->signup->errors[$S5] = mo_("\120\x68\157\156\145\x20\x6e\x75\155\x62\x65\162\x20\x61\154\x72\x65\x61\x64\x79\40\151\156\x20\165\163\x65\56\x20\120\154\145\141\163\x65\x20\x45\x6e\164\145\162\x20\141\x20\x64\x69\x66\x66\x65\x72\x65\156\x74\x20\120\x68\x6f\x6e\x65\40\x6e\x75\155\142\x65\162\x2e");
        TZN:
        goto ehP;
        gMn:
        $bp->signup->errors[$S5] = str_replace("\x23\43\160\150\x6f\156\x65\x23\x23", $_POST[$S5], $phoneLogic->_get_otp_invalid_format_message());
        ehP:
    }
    function isPhoneNumberAlreadyInUse($fk)
    {
        if (!$this->_restrictDuplicates) {
            goto cRM;
        }
        global $wpdb;
        $fk = MoUtility::processPhoneNumber($fk);
        $S5 = $this->moBBPgetphoneFieldId();
        $h8 = $wpdb->get_row("\x53\105\114\105\x43\x54\40\x60\x75\163\x65\162\x5f\151\144\140\x20\x46\x52\x4f\115\40\140{$wpdb->prefix}\x62\160\x5f\x78\x70\x72\x6f\146\x69\x6c\145\137\x64\x61\x74\x61\x60\40\127\110\x45\122\105\40\x60\x66\x69\145\154\x64\x5f\151\x64\140\x20\75\x20\47{$S5}\x27\40\x41\116\x44\40\140\x76\141\154\x75\x65\x60\40\75\40\x20\x27{$fk}\x27");
        return !MoUtility::isBlank($h8);
        cRM:
        return false;
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto iCE;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        iCE:
        return FALSE;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        $HV = $this->getVerificationType();
        $wp = VerificationType::BOTH === $HV ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    function miniorange_bp_user_registration($N9)
    {
        if (!$this->checkIfVerificationIsComplete()) {
            goto Nqp;
        }
        return $N9;
        Nqp:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        $J9 = NULL;
        foreach ($_POST as $Zm => $zs) {
            if ($Zm === "\163\x69\147\x6e\165\160\x5f\165\x73\x65\162\156\141\x6d\145") {
                goto kLr;
            }
            if ($Zm === "\x73\x69\147\156\165\160\137\145\155\141\x69\154") {
                goto CIB;
            }
            if ($Zm === "\163\x69\x67\156\165\x70\x5f\x70\141\x73\x73\167\157\162\144") {
                goto rg9;
            }
            $tA[$Zm] = $zs;
            goto a35;
            kLr:
            $HR = $zs;
            goto a35;
            CIB:
            $h4 = $zs;
            goto a35;
            rg9:
            $hs = $zs;
            a35:
            xmQ:
        }
        sXc:
        $bP = $this->moBBPgetphoneFieldId();
        if (!isset($_POST["\146\x69\x65\154\144\x5f" . $bP])) {
            goto hdI;
        }
        $J9 = $_POST["\146\x69\x65\x6c\144\x5f" . $bP];
        hdI:
        $tA["\x75\163\x65\162\x6d\x65\164\x61"] = $N9;
        $this->startVerificationProcess($HR, $h4, $errors, $J9, $hs, $tA);
        return $N9;
    }
    function startVerificationProcess($HR, $h4, $errors, $J9, $hs, $tA)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto ZH4;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto JWF;
        }
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::EMAIL, $hs, $tA);
        goto tY8;
        JWF:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::BOTH, $hs, $tA);
        tY8:
        goto Fjc;
        ZH4:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::PHONE, $hs, $tA);
        Fjc:
    }
    function mo_activate_bbp_user($QQ, $wB)
    {
        $HS = $this->moBBPgetActivationKey($wB);
        bp_core_activate_signup($HS);
        BP_Signup::validate($HS);
        $a0 = new WP_User($QQ);
        $a0->add_role("\163\165\142\x73\143\x72\151\x62\145\162");
        return;
    }
    function moBBPgetActivationKey($wB)
    {
        global $wpdb;
        return $wpdb->get_var("\x53\x45\x4c\105\x43\124\x20\141\143\x74\151\x76\x61\x74\x69\157\x6e\x5f\x6b\145\171\x20\106\122\x4f\115\x20{$wpdb->prefix}\x73\151\147\156\165\x70\163\x20\127\110\x45\122\x45\x20\x61\x63\x74\151\x76\145\40\75\40\x27\60\x27\x20\101\116\x44\x20\165\163\145\x72\137\x6c\x6f\147\151\x6e\40\x3d\x20\47" . $wB . "\x27");
    }
    function moBBPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\x53\105\x4c\x45\103\x54\x20\x69\x64\x20\x46\x52\x4f\115\x20{$wpdb->prefix}\x62\160\x5f\170\x70\x72\x6f\x66\x69\154\x65\x5f\x66\x69\145\154\x64\x73\40\167\x68\x65\x72\145\x20\x6e\x61\x6d\145\40\x3d\47" . $this->_phoneKey . "\x27");
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto WEn;
        }
        array_push($zX, $this->_phoneFormId);
        WEn:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Lb5;
        }
        return;
        Lb5:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x62\x62\160\x5f\x64\145\x66\141\165\154\164\137\x65\156\141\142\154\145");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\x62\x62\x70\137\x64\151\x73\x61\142\x6c\x65\137\141\x63\164\151\x76\141\164\151\157\156");
        $this->_otpType = $this->sanitizeFormPOST("\142\x62\x70\137\145\x6e\141\x62\154\x65\137\x74\171\160\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\142\142\160\x5f\x70\150\157\x6e\145\137\153\x65\171");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\142\142\x70\137\x72\145\163\x74\162\151\143\x74\x5f\144\x75\160\x6c\151\x63\x61\164\x65\163");
        if (!$this->basicValidationCheck(BaseMessages::BP_CHOOSE)) {
            goto TWN;
        }
        update_mo_option("\142\x62\160\137\144\x65\146\x61\165\154\x74\137\x65\x6e\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x62\x62\x70\x5f\x64\151\163\141\142\x6c\x65\x5f\141\x63\164\151\166\141\x74\151\x6f\156", $this->_disableAutoActivate);
        update_mo_option("\x62\x62\160\x5f\145\x6e\x61\x62\154\x65\x5f\164\x79\160\x65", $this->_otpType);
        update_mo_option("\142\x62\x70\x5f\162\x65\163\164\162\x69\x63\x74\137\144\x75\x70\x6c\151\x63\x61\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\142\142\x70\137\x70\x68\157\x6e\x65\x5f\x6b\x65\x79", $this->_phoneKey);
        TWN:
    }
}
