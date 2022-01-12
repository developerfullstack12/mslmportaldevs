<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PaidMembershipForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PMPRO_REGISTRATION;
        $this->_formKey = "\120\115\137\120\122\117\137\106\x4f\122\115";
        $this->_formName = mo_("\x50\141\151\x64\x20\115\x65\x6d\x62\145\162\x53\150\x69\x70\40\120\162\x6f\x20\x52\145\x67\151\x73\164\x72\141\x74\x69\157\x6e\40\x46\x6f\162\x6d");
        $this->_phoneFormId = "\x69\x6e\x70\165\164\x5b\x6e\141\155\x65\x3d\160\x68\x6f\x6e\x65\x5f\160\141\x69\x64\155\145\155\142\x65\162\163\x68\151\x70\x5d";
        $this->_typePhoneTag = "\160\155\160\x72\x6f\137\160\150\157\x6e\x65\137\145\156\x61\x62\154\145";
        $this->_typeEmailTag = "\160\x6d\x70\162\x6f\x5f\145\x6d\x61\x69\154\137\x65\156\x61\x62\154\x65";
        $this->_isFormEnabled = get_mo_option("\x70\155\160\162\157\x5f\x65\156\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::PAID_MEMBERSHIP_PRO;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\160\155\160\162\x6f\137\157\164\x70\137\x74\171\x70\145");
        add_action("\167\x70\137\145\156\x71\165\x65\x75\x65\x5f\x73\x63\162\151\x70\164\163", array($this, "\x5f\x73\150\x6f\x77\x5f\x70\150\x6f\x6e\x65\x5f\x66\151\x65\x6c\144\137\157\x6e\x5f\x70\x61\x67\145"));
        add_filter("\160\155\x70\x72\157\x5f\143\150\x65\x63\x6b\157\165\x74\x5f\142\x65\146\x6f\162\x65\137\x70\162\157\143\145\163\x73\x69\x6e\x67", array($this, "\x5f\160\141\151\x64\x4d\x65\x6d\142\x65\x72\163\x68\x69\x70\x50\x72\157\x52\x65\147\x69\163\164\162\x61\164\x69\157\156\103\150\x65\x63\x6b"), 1, 1);
        add_filter("\160\155\160\162\x6f\137\143\x68\145\x63\153\157\165\164\x5f\x63\x6f\x6e\x66\x69\162\155\145\x64", array($this, "\151\x73\126\x61\x6c\151\144\x61\x74\x65\x64"), 99, 2);
        add_action("\x75\163\x65\162\137\162\145\x67\x69\163\x74\x65\162", array($this, "\x6d\151\x6e\151\x6f\x72\141\156\x67\145\137\x72\145\x67\x69\x73\x74\x72\x61\164\x69\x6f\156\x5f\163\x61\x76\x65"), 10, 1);
    }
    function miniorange_registration_save($ZS)
    {
        update_user_meta($ZS, "\155\157\137\x70\x68\x6f\x6e\x65\137\156\165\155\x62\x65\162", $_POST["\160\150\157\x6e\x65\137\160\141\x69\x64\x6d\145\x6d\142\x65\x72\x73\150\151\160"]);
    }
    public function isValidated($zZ, $WQ)
    {
        global $Wp;
        return $Wp == "\x70\155\x70\162\x6f\x5f\145\162\x72\157\162" ? false : $zZ;
    }
    public function _paidMembershipProRegistrationCheck()
    {
        global $Wp;
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto A2;
        }
        $this->unsetOTPSessionVariables();
        return;
        A2:
        $this->validatePhone($_POST);
        if (!($Wp != "\x70\x6d\x70\x72\157\x5f\145\x72\x72\157\x72")) {
            goto Wc;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->startOTPVerificationProcess($_POST);
        Wc:
    }
    private function startOTPVerificationProcess($pO)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Gr;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto Mq;
        }
        goto vz;
        Gr:
        $this->sendChallenge('', '', null, trim($pO["\160\x68\x6f\156\x65\137\160\141\x69\x64\x6d\x65\x6d\x62\145\x72\x73\150\151\x70"]), "\x70\x68\157\156\x65");
        goto vz;
        Mq:
        $this->sendChallenge('', $pO["\142\x65\155\141\x69\x6c"], null, $pO["\142\145\x6d\x61\151\x6c"], "\145\155\141\151\154");
        vz:
    }
    public function validatePhone($pO)
    {
        if (!($this->getVerificationType() != VerificationType::PHONE)) {
            goto yG;
        }
        return;
        yG:
        global $so, $Wp, $phoneLogic, $nI;
        if (!($Wp == "\x70\x6d\160\x72\x6f\137\x65\162\162\157\162")) {
            goto dq;
        }
        return;
        dq:
        $DG = $pO["\x70\x68\x6f\156\145\137\x70\x61\151\144\155\x65\x6d\x62\x65\162\163\x68\x69\x70"];
        if (MoUtility::validatePhoneNumber($DG)) {
            goto kd;
        }
        $SF = str_replace("\43\x23\160\150\x6f\x6e\x65\43\43", $DG, $phoneLogic->_get_otp_invalid_format_message());
        $Wp = "\x70\x6d\160\x72\x6f\x5f\145\x72\162\x6f\x72";
        $nI = false;
        $so = apply_filters("\160\x6d\160\162\157\x5f\163\x65\164\137\155\x65\x73\163\x61\147\x65", $SF, $Wp);
        kd:
    }
    function _show_phone_field_on_page()
    {
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto Jj;
        }
        wp_enqueue_script("\x70\141\x69\144\155\145\x6d\x62\x65\162\163\x68\151\160\163\143\x72\x69\x70\164", MOV_URL . "\x69\x6e\x63\154\165\144\x65\x73\57\152\163\57\160\141\x69\x64\155\x65\155\x62\x65\x72\x73\150\151\x70\160\162\x6f\x2e\x6d\x69\x6e\56\x6a\163\77\166\145\x72\163\151\157\x6e\x3d" . MOV_VERSION, array("\152\161\x75\x65\x72\x79"));
        Jj:
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
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto qU;
        }
        array_push($zX, $this->_phoneFormId);
        qU:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Hh;
        }
        return;
        Hh:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x70\x6d\x70\162\157\x5f\145\156\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\160\x6d\x70\162\x6f\137\143\157\156\164\141\143\164\x5f\164\x79\160\145");
        update_mo_option("\x70\155\160\162\157\x5f\145\156\141\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\160\155\x70\x72\x6f\137\157\x74\160\137\164\x79\x70\145", $this->_otpType);
    }
}
