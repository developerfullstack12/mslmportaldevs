<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
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
use WP_Error;
class MemberPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MEMBERPRESS_REG;
        $this->_typePhoneTag = "\x6d\157\137\x6d\x72\x70\x5f\x70\150\x6f\156\145\137\145\x6e\141\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x6d\162\x70\x5f\x65\155\x61\x69\154\137\145\156\141\142\x6c\x65";
        $this->_typeBothTag = "\155\157\137\x6d\x72\160\x5f\142\157\x74\x68\x5f\145\156\141\142\154\145";
        $this->_formName = mo_("\115\145\x6d\142\x65\162\x50\162\145\163\163\x20\122\145\147\x69\x73\x74\x72\x61\x74\151\157\156\40\x46\x6f\x72\x6d");
        $this->_formKey = "\115\x45\115\x42\105\122\x50\x52\x45\123\x53";
        $this->_isFormEnabled = get_mo_option("\155\x72\160\137\x64\145\x66\x61\x75\154\x74\137\x65\x6e\141\x62\154\145");
        $this->_formDocuments = MoOTPDocs::MRP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_byPassLogin = get_mo_option("\x6d\162\x70\137\141\x6e\x6f\156\137\157\x6e\154\171");
        $this->_phoneKey = get_mo_option("\x6d\x72\160\x5f\160\150\x6f\156\145\137\x6b\145\x79");
        $this->_otpType = get_mo_option("\x6d\162\160\x5f\x65\156\141\x62\x6c\145\x5f\x74\x79\x70\145");
        $this->_phoneFormId = "\x69\x6e\x70\x75\x74\133\x6e\141\x6d\145\75" . $this->_phoneKey . "\x5d";
        add_filter("\x6d\145\x70\162\55\x76\x61\154\x69\x64\141\x74\145\55\163\x69\x67\156\x75\x70", array($this, "\155\151\156\x69\157\x72\x61\156\x67\145\x5f\x73\x69\x74\x65\x5f\162\145\x67\x69\163\164\x65\x72\x5f\x66\157\x72\x6d"), 99, 1);
    }
    function miniorange_site_register_form($errors)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto m8n;
        }
        return $errors;
        m8n:
        $N9 = $_POST;
        $J9 = '';
        if (!$this->isPhoneVerificationEnabled()) {
            goto bOh;
        }
        $J9 = $_POST[$this->_phoneKey];
        $errors = $this->validatePhoneNumberField($errors);
        bOh:
        if (!(is_array($errors) && !empty($errors))) {
            goto B0v;
        }
        return $errors;
        B0v:
        if (!$this->checkIfVerificationIsComplete()) {
            goto srz;
        }
        return $errors;
        srz:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        foreach ($_POST as $Zm => $zs) {
            if ($Zm == "\165\163\145\162\x5f\x66\151\x72\x73\164\137\x6e\x61\155\x65") {
                goto IbN;
            }
            if ($Zm == "\165\163\145\x72\137\x65\155\141\x69\x6c") {
                goto uOq;
            }
            if ($Zm == "\x6d\x65\x70\x72\x5f\x75\x73\145\162\x5f\160\x61\163\163\167\x6f\x72\x64") {
                goto oQH;
            }
            $tA[$Zm] = $zs;
            goto ru2;
            IbN:
            $HR = $zs;
            goto ru2;
            uOq:
            $h4 = $zs;
            goto ru2;
            oQH:
            $hs = $zs;
            ru2:
            gqM:
        }
        jvg:
        $tA["\165\163\145\x72\x6d\145\x74\x61"] = $N9;
        $this->startVerificationProcess($HR, $h4, $errors, $J9, $hs, $tA);
        return $errors;
    }
    function validatePhoneNumberField($errors)
    {
        global $phoneLogic;
        if (!MoUtility::sanitizeCheck($this->_phoneKey, $_POST)) {
            goto Nyq;
        }
        if (MoUtility::validatePhoneNumber($_POST[$this->_phoneKey])) {
            goto Zk7;
        }
        $errors[] = $phoneLogic->_get_otp_invalid_format_message();
        Zk7:
        goto fux;
        Nyq:
        $errors[] = mo_("\120\x68\157\156\x65\40\156\x75\155\x62\x65\x72\x20\146\151\145\x6c\144\x20\x63\141\156\x20\x6e\x6f\164\x20\142\145\40\142\x6c\141\x6e\x6b");
        fux:
        return $errors;
    }
    function startVerificationProcess($HR, $h4, $errors, $J9, $hs, $tA)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto iCi;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto Qx2;
        }
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::EMAIL, $hs, $tA);
        goto HD8;
        iCi:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::PHONE, $hs, $tA);
        goto HD8;
        Qx2:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::BOTH, $hs, $tA);
        HD8:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Wg8;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        Wg8:
        return FALSE;
    }
    function moMRPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\x53\105\114\105\x43\124\x20\151\x64\40\106\x52\117\115\40{$wpdb->prefix}\x62\x70\137\x78\160\x72\157\x66\151\154\x65\x5f\x66\x69\145\x6c\x64\x73\x20\x77\x68\145\162\145\x20\x6e\x61\x6d\x65\40\75\x27" . $this->_phoneKey . "\47");
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto evp;
        }
        return;
        evp:
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!(self::isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto oGg;
        }
        array_push($zX, $this->_phoneFormId);
        oGg:
        return $zX;
    }
    function isPhoneVerificationEnabled()
    {
        $lr = $this->getVerificationType();
        return $lr === VerificationType::PHONE || $lr === VerificationType::BOTH;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Qdx;
        }
        return;
        Qdx:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\155\162\x70\137\x64\x65\x66\x61\165\154\x74\137\x65\x6e\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x6d\162\x70\x5f\x65\156\x61\142\x6c\145\x5f\164\x79\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\155\x72\160\x5f\160\x68\157\x6e\x65\x5f\x66\x69\x65\x6c\144\137\153\145\171");
        $this->_byPassLogin = $this->sanitizeFormPOST("\155\160\162\137\x61\156\x6f\156\137\x6f\156\154\x79");
        if (!$this->basicValidationCheck(BaseMessages::MEMBERPRESS_CHOOSE)) {
            goto bNV;
        }
        update_mo_option("\155\x72\x70\x5f\x64\145\x66\141\x75\x6c\164\137\x65\x6e\141\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\x6d\x72\x70\137\145\x6e\141\x62\x6c\x65\137\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\155\162\160\x5f\160\x68\x6f\x6e\145\137\153\145\x79", $this->_phoneKey);
        update_mo_option("\x6d\x72\160\x5f\x61\156\157\x6e\137\157\156\154\171", $this->_byPassLogin);
        bNV:
    }
}
