<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
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
class MultiSiteFormRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MULTISITE;
        $this->_phoneFormId = "\151\x6e\160\x75\x74\133\156\141\x6d\x65\75\x6d\x75\x6c\x74\x69\163\x69\x74\145\x5f\165\x73\x65\162\137\x70\x68\x6f\156\x65\x5f\155\x69\156\151\157\x72\141\x6e\147\x65\135";
        $this->_typePhoneTag = "\155\x6f\x5f\155\165\x6c\164\151\x73\151\164\x65\x5f\143\157\156\x74\141\143\164\137\160\150\157\156\145\137\x65\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\x5f\155\165\154\x74\151\x73\151\x74\x65\137\143\x6f\x6e\x74\x61\x63\x74\x5f\x65\155\141\x69\x6c\137\x65\156\x61\142\154\145";
        $this->_formKey = "\127\x50\x5f\123\111\107\x4e\125\x50\137\x46\117\x52\115";
        $this->_formName = mo_("\x57\x6f\162\144\x50\x72\x65\x73\163\x20\115\165\x6c\164\x69\x73\151\164\x65\40\123\151\147\x6e\125\160\x20\106\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\x6d\165\154\164\151\163\x69\164\145\137\x65\156\x61\142\x6c\x65");
        $this->_phoneKey = "\x74\145\x6c\145\x70\x68\x6f\x6e\x65";
        $this->_formDocuments = MoOTPDocs::MULTISITE_REG_FORM;
        parent::__construct();
    }
    public function handleForm()
    {
        add_action("\167\160\137\x65\156\x71\x75\x65\165\145\137\163\x63\162\151\x70\x74\163", array($this, "\141\144\144\x50\150\157\156\x65\106\x69\x65\x6c\x64\x53\143\x72\x69\160\x74"));
        add_action("\165\x73\145\x72\137\162\x65\147\x69\163\164\x65\162", array($this, "\137\163\x61\166\x65\120\150\157\x6e\x65\116\x75\155\142\145\162"), 10, 1);
        $this->_otpType = get_mo_option("\155\x75\154\x74\x69\x73\151\x74\145\x5f\157\x74\160\x5f\164\x79\x70\x65");
        if (array_key_exists("\157\x70\x74\x69\x6f\156", $_POST)) {
            goto uu;
        }
        return;
        uu:
        switch (trim($_POST["\x6f\160\x74\151\x6f\x6e"])) {
            case "\155\165\154\x74\x69\x73\x69\164\x65\x5f\x72\x65\x67\x69\163\164\145\162":
                $this->_sanitizeAndRouteData($_POST);
                goto xn;
            case "\x6d\x69\156\151\x6f\x72\x61\156\147\145\55\x76\141\154\151\144\x61\x74\x65\55\157\x74\x70\55\x66\x6f\162\155":
                $this->_startValidation();
                goto xn;
        }
        RA:
        xn:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
        $this->unsetOTPSessionVariables();
    }
    public function _savePhoneNumber($ZS)
    {
        $Zu = MoPHPSessions::getSessionVar("\160\150\157\156\x65\x5f\x6e\165\155\x62\145\162\137\155\157");
        if (!$Zu) {
            goto Lf;
        }
        update_user_meta($ZS, $this->_phoneKey, $Zu);
        Lf:
    }
    public function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto nR;
        }
        return;
        nR:
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    function _sanitizeAndRouteData($fy)
    {
        $fM = wpmu_validate_user_signup($_POST["\165\163\x65\x72\137\156\x61\x6d\145"], $_POST["\x75\163\x65\162\137\x65\155\141\x69\154"]);
        $errors = $fM["\145\x72\x72\157\162\x73"];
        if (!$errors->get_error_code()) {
            goto SO;
        }
        return false;
        SO:
        Moutility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto od;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto Mo;
        }
        $this->_processEmail($fy);
        Mo:
        goto zA;
        od:
        $this->_processPhone($fy);
        zA:
        return false;
    }
    private function _startValidation()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto bl;
        }
        return;
        bl:
        $HV = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto f0;
        }
        return;
        f0:
        $this->validateChallenge($HV);
    }
    public function addPhoneFieldScript()
    {
        wp_enqueue_script("\x6d\165\154\x74\151\163\x69\164\x65\x73\143\162\x69\x70\164", MOV_URL . "\151\x6e\143\154\165\x64\145\x73\57\152\x73\57\155\165\x6c\x74\x69\163\x69\164\x65\56\x6d\151\156\56\152\x73\x3f\166\145\162\x73\151\x6f\156\75" . MOV_VERSION, array("\x6a\x71\165\145\x72\171"));
    }
    private function _processPhone($fy)
    {
        if (isset($fy["\155\165\154\x74\151\163\151\x74\145\137\x75\163\145\x72\137\x70\150\157\156\145\x5f\x6d\151\x6e\151\x6f\162\141\x6e\147\145"])) {
            goto Jd;
        }
        return;
        Jd:
        $this->sendChallenge('', '', null, trim($fy["\x6d\165\154\x74\x69\x73\x69\x74\x65\137\x75\163\145\162\137\x70\150\x6f\156\x65\137\155\x69\x6e\151\157\162\141\x6e\147\x65"]), VerificationType::PHONE);
    }
    private function _processEmail($fy)
    {
        if (isset($fy["\x75\x73\145\162\x5f\x65\155\x61\x69\154"])) {
            goto NL;
        }
        return;
        NL:
        $this->sendChallenge('', $fy["\x75\163\145\x72\x5f\145\155\141\x69\x6c"], null, null, VerificationType::EMAIL, '');
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!self::isFormEnabled()) {
            goto gz;
        }
        array_push($zX, $this->_phoneFormId);
        gz:
        return $zX;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto m_;
        }
        return;
        m_:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\155\x75\154\164\x69\x73\151\x74\x65\137\145\156\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\155\x75\154\x74\x69\163\x69\164\x65\137\143\x6f\156\164\x61\143\164\x5f\164\x79\160\x65");
        update_mo_option("\x6d\165\x6c\164\151\163\x69\164\x65\x5f\145\156\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x6d\165\x6c\x74\151\163\151\x74\145\137\x6f\164\x70\137\x74\x79\x70\145", $this->_otpType);
    }
}
