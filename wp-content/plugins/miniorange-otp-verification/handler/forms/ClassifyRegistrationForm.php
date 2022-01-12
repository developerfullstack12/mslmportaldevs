<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
class ClassifyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CLASSIFY_REGISTER;
        $this->_typePhoneTag = "\143\x6c\x61\163\163\x69\x66\171\137\160\x68\157\x6e\145\137\145\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\143\154\141\x73\163\151\x66\x79\137\x65\155\141\x69\154\x5f\145\x6e\141\x62\x6c\145";
        $this->_formKey = "\103\114\x41\123\123\111\106\x59\137\x52\105\107\x49\x53\124\105\122";
        $this->_formName = mo_("\103\154\141\x73\163\x69\x66\x79\x20\x54\x68\x65\x6d\x65\40\122\145\147\151\163\x74\x72\x61\x74\151\157\x6e\40\x46\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\143\x6c\x61\163\x73\151\146\x79\x5f\145\x6e\141\x62\x6c\x65");
        $this->_phoneFormId = "\151\156\160\x75\164\133\x6e\x61\x6d\x65\75\160\150\157\x6e\145\x5d";
        $this->_formDocuments = MoOTPDocs::CLASSIFY_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\x6c\141\x73\163\151\x66\171\x5f\164\171\x70\x65");
        add_action("\167\160\x5f\145\x6e\x71\165\145\165\145\137\x73\143\x72\151\x70\164\163", array($this, "\x5f\x73\150\157\167\137\x70\150\157\156\145\x5f\146\151\x65\x6c\x64\137\157\x6e\137\160\x61\147\x65"));
        add_action("\x75\x73\145\x72\137\162\145\147\x69\163\164\x65\x72", array($this, "\x73\141\x76\x65\137\x70\150\x6f\x6e\145\x5f\156\x75\155\142\145\x72"), 10, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto HR;
        }
        if (!(MoUtility::sanitizeCheck("\x6f\160\164\x69\x6f\156", $_POST) === "\x76\x65\162\x69\146\171\137\x75\x73\x65\x72\x5f\x63\x6c\x61\163\163\151\x66\171")) {
            goto cQ;
        }
        $this->_handle_classify_theme_form_post($_POST);
        cQ:
        goto pF;
        HR:
        $this->unsetOTPSessionVariables();
        pF:
    }
    function _show_phone_field_on_page()
    {
        wp_enqueue_script("\143\154\x61\163\x73\x69\146\x79\x73\x63\x72\151\x70\x74", MOV_URL . "\151\x6e\x63\x6c\x75\x64\145\163\57\152\163\x2f\143\154\141\x73\x73\151\x66\171\56\155\x69\156\56\x6a\x73\x3f\x76\145\162\x73\151\x6f\156\75" . MOV_VERSION, array("\152\x71\x75\x65\x72\x79"));
    }
    function _handle_classify_theme_form_post($pO)
    {
        $HR = $pO["\165\163\145\162\x6e\x61\x6d\x65"];
        $Y7 = $pO["\x65\155\141\151\x6c"];
        $fk = $pO["\x70\150\157\156\145"];
        if (!(username_exists($HR) != FALSE)) {
            goto Yd;
        }
        return;
        Yd:
        if (!(email_exists($Y7) != FALSE)) {
            goto Bz;
        }
        return;
        Bz:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Bi;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto d7;
        }
        $this->sendChallenge($_POST["\x75\163\x65\x72\156\141\x6d\x65"], $Y7, null, $fk, "\x62\157\164\150", null, null);
        goto Go;
        d7:
        $this->sendChallenge($_POST["\165\x73\145\162\x6e\141\155\145"], $Y7, null, null, "\x65\x6d\141\x69\x6c", null, null);
        Go:
        goto Fp;
        Bi:
        $this->sendChallenge($_POST["\165\163\x65\x72\x6e\x61\155\x65"], $Y7, null, $fk, "\x70\150\157\x6e\145", null, null);
        Fp:
    }
    function save_phone_number($ZS)
    {
        $Zu = MoPHPSessions::getSessionVar("\x70\x68\x6f\156\145\x5f\x6e\165\155\x62\x65\x72\x5f\x6d\157");
        if (!$Zu) {
            goto wA;
        }
        update_user_meta($ZS, "\160\150\157\156\x65", $Zu);
        wA:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto eT;
        }
        return;
        eT:
        $HV = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x70\150\x6f\x6e\145" : (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 ? "\145\155\x61\151\154" : "\142\x6f\x74\x68");
        $wp = strcasecmp($HV, "\142\x6f\x74\150") === 0 ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto dJ;
        }
        array_push($zX, $this->_phoneFormId);
        dJ:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto d3;
        }
        return;
        d3:
        $this->_otpType = $this->sanitizeFormPOST("\x63\154\x61\163\x73\151\146\171\x5f\164\171\x70\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\x6c\x61\163\x73\151\x66\171\x5f\x65\x6e\x61\x62\x6c\x65");
        update_mo_option("\x63\154\141\x73\163\x69\x66\171\137\145\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x63\154\x61\x73\x73\151\146\x79\x5f\164\x79\160\145", $this->_otpType);
    }
}
