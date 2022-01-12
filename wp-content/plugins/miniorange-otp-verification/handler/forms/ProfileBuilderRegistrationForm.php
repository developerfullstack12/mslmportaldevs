<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class ProfileBuilderRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PB_DEFAULT_REG;
        $this->_typePhoneTag = "\155\157\x5f\160\x62\137\x70\150\x6f\x6e\145\x5f\x65\x6e\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\x6f\x5f\160\x62\x5f\x65\155\x61\151\x6c\137\x65\x6e\141\x62\x6c\145";
        $this->_typeBothTag = "\155\157\137\x70\x62\137\x62\157\x74\x68\137\145\156\141\x62\x6c\x65";
        $this->_formKey = "\x50\x42\137\104\x45\x46\x41\125\114\x54\x5f\x46\117\x52\115";
        $this->_formName = mo_("\120\x72\x6f\x66\x69\154\x65\x20\102\165\x69\154\x64\145\x72\40\122\x65\x67\151\x73\x74\162\x61\164\151\x6f\156\x20\106\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\x70\142\137\144\145\x66\141\165\x6c\x74\137\145\156\141\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::PB_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x70\x62\x5f\145\156\141\x62\x6c\145\x5f\x74\171\x70\145");
        $this->_phoneKey = get_mo_option("\160\x62\137\160\x68\x6f\156\x65\x5f\x6d\x65\164\141\137\153\x65\171");
        $this->_phoneFormId = "\x69\x6e\160\x75\x74\133\156\x61\155\145\x3d" . $this->_phoneKey . "\135";
        add_filter("\x77\160\160\142\x5f\x6f\x75\164\160\x75\164\x5f\146\151\145\x6c\144\137\145\x72\162\157\162\x73\x5f\x66\151\x6c\x74\145\162", array($this, "\x66\x6f\x72\x6d\142\x75\151\154\x64\145\162\x5f\163\151\164\x65\137\x72\x65\147\151\x73\164\x72\x61\x74\x69\157\x6e\x5f\145\x72\x72\157\x72\163"), 99, 4);
    }
    function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV === VerificationType::PHONE || $HV === VerificationType::BOTH;
    }
    function formbuilder_site_registration_errors($BG, $Wc, $n5, $Cn)
    {
        if (empty($BG)) {
            goto lk;
        }
        return $BG;
        lk:
        if (!($n5["\141\x63\x74\151\157\x6e"] == "\162\145\x67\151\x73\x74\145\x72")) {
            goto K_;
        }
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Hy;
        }
        $this->unsetOTPSessionVariables();
        return $BG;
        Hy:
        return $this->startOTPVerificationProcess($BG, $n5);
        K_:
        return $BG;
    }
    function startOTPVerificationProcess($BG, $pO)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $LD = $this->extractArgs($pO, $this->_phoneKey);
        $this->sendChallenge($LD["\165\x73\x65\162\x6e\141\155\145"], $LD["\x65\x6d\141\151\x6c"], new WP_Error(), $LD["\x70\150\x6f\x6e\145"], $this->getVerificationType(), $LD["\x70\141\x73\163\167\61"], array());
    }
    private function extractArgs($LD, $wF)
    {
        return array("\x75\x73\145\x72\156\141\155\145" => $LD["\x75\163\x65\162\156\141\155\145"], "\x65\155\141\151\x6c" => $LD["\145\155\141\151\x6c"], "\160\141\163\x73\x77\x31" => $LD["\x70\x61\163\x73\x77\x31"], "\x70\x68\x6f\156\x65" => MoUtility::sanitizeCheck($wF, $LD));
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $this->getVerificationType(), FALSE);
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
            goto GU;
        }
        array_push($zX, $this->_phoneFormId);
        GU:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto AY;
        }
        return;
        AY:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x70\x62\137\144\x65\146\x61\165\x6c\x74\137\x65\156\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x70\142\x5f\x65\156\x61\x62\154\x65\x5f\x74\171\160\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\160\142\137\160\150\157\156\x65\137\146\151\x65\x6c\144\137\x6b\145\171");
        update_mo_option("\x70\x62\x5f\x64\x65\146\x61\x75\x6c\164\137\x65\x6e\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\160\x62\x5f\x65\156\141\x62\154\x65\137\164\171\160\145", $this->_otpType);
        update_mo_option("\x70\142\x5f\x70\x68\157\x6e\x65\x5f\x6d\145\x74\x61\137\153\x65\171", $this->_phoneKey);
    }
}
