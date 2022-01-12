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
class RealEstate7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::REALESTATE_7;
        $this->_phoneFormId = "\151\x6e\160\165\164\x5b\x6e\x61\155\145\x3d\143\164\x5f\x75\163\145\162\x5f\160\150\157\156\145\x5f\155\x69\x6e\151\157\162\141\156\x67\x65\135";
        $this->_formKey = "\x52\x45\101\x4c\x5f\105\x53\x54\x41\x54\105\137\67";
        $this->_typePhoneTag = "\155\x6f\137\x72\145\x61\154\x65\x73\x74\141\x74\145\137\143\x6f\156\x74\x61\143\x74\137\160\x68\x6f\x6e\145\137\145\x6e\141\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\137\x72\145\141\154\x65\x73\x74\141\164\145\137\143\x6f\156\164\141\x63\x74\x5f\x65\x6d\x61\151\x6c\137\x65\x6e\141\142\154\x65";
        $this->_formName = mo_("\122\145\141\x6c\40\x45\x73\164\x61\164\145\x20\x37\40\120\162\x6f\40\x54\x68\145\x6d\x65");
        $this->_isFormEnabled = get_mo_option("\x72\x65\141\154\x65\x73\x74\x61\x74\x65\137\x65\156\141\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::REALESTATE7_THEME_LINK;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\x72\145\141\154\x65\163\x74\x61\x74\x65\137\x6f\164\x70\137\x74\171\x70\145");
        add_action("\167\160\x5f\x65\156\x71\x75\145\165\x65\x5f\163\x63\x72\x69\160\164\x73", array($this, "\x61\144\144\x50\150\x6f\x6e\145\x46\151\x65\x6c\144\123\143\x72\151\x70\x74"));
        add_action("\x75\x73\x65\x72\137\162\x65\147\x69\163\x74\x65\x72", array($this, "\155\151\x6e\151\x6f\x72\x61\x6e\x67\x65\137\x72\x65\147\x69\163\164\x72\x61\x74\x69\157\x6e\137\x73\x61\166\x65"), 10, 1);
        if (array_key_exists("\x6f\x70\164\x69\x6f\x6e", $_POST)) {
            goto OA;
        }
        return;
        OA:
        switch ($_POST["\157\160\164\151\157\156"]) {
            case "\162\x65\x61\x6c\x65\x73\164\141\164\x65\x5f\162\x65\147\x69\x73\164\145\x72":
                if (!$this->sanitizeData($_POST)) {
                    goto xu;
                }
                $this->routeData($_POST);
                xu:
                goto af;
            case "\155\151\156\x69\157\162\x61\x6e\147\145\x2d\166\141\x6c\151\144\141\164\145\55\x6f\x74\x70\x2d\146\x6f\x72\155":
                $this->_startValidation();
                goto af;
        }
        IM:
        af:
    }
    public function unsetOTPSessionVariables()
    {
        Sessionutils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
        $this->unsetOTPSessionVariables();
    }
    public function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    public function sanitizeData($AA)
    {
        if (!(isset($AA["\143\x74\x5f\165\x73\145\162\137\x6c\157\147\x69\156"]) && wp_verify_nonce($AA["\143\x74\137\162\145\x67\151\163\x74\145\x72\x5f\x6e\157\156\143\145"], "\x63\x74\55\162\x65\x67\x69\x73\164\x65\x72\x2d\156\x6f\156\143\145"))) {
            goto uN;
        }
        $wB = $AA["\x63\164\137\165\x73\145\162\137\x6c\157\x67\x69\156"];
        $CG = $AA["\x63\x74\137\165\x73\x65\162\137\x65\x6d\141\x69\154"];
        $hl = $AA["\x63\x74\137\x75\x73\145\162\137\146\x69\162\163\x74"];
        $EX = $AA["\x63\x74\137\165\x73\x65\x72\x5f\154\x61\x73\x74"];
        $UY = $AA["\x63\164\137\x75\x73\145\x72\137\x70\x61\x73\x73"];
        $f3 = $AA["\x63\164\137\x75\163\145\x72\x5f\x70\141\x73\163\x5f\143\x6f\x6e\x66\151\x72\155"];
        if (!(username_exists($wB) || !validate_username($wB) || $wB == '' || !is_email($CG) || email_exists($CG) || $UY == '' || $UY != $f3)) {
            goto m6;
        }
        return false;
        m6:
        return true;
        uN:
        return false;
    }
    public function miniorange_registration_save($ZS)
    {
        $lr = $this->getVerificationType();
        $fk = MoPHPSessions::getSessionVar("\x70\150\x6f\x6e\x65\x5f\156\165\155\142\145\162\137\x6d\157");
        if (!($lr === VerificationType::PHONE && $fk)) {
            goto fw;
        }
        add_user_meta($ZS, "\160\x68\157\156\x65", $fk);
        fw:
    }
    private function _startValidation()
    {
        $lr = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto MP;
        }
        return;
        MP:
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $lr)) {
            goto lK;
        }
        return;
        lK:
        $this->validateChallenge($lr);
    }
    public function routeData($AA)
    {
        Moutility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto dL;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto N9;
        }
        $this->_processEmail($AA);
        N9:
        goto jq;
        dL:
        $this->_processPhone($AA);
        jq:
    }
    private function _processPhone($AA)
    {
        if (!(!array_key_exists("\143\164\x5f\165\163\145\x72\137\160\150\157\156\145\x5f\x6d\151\x6e\151\x6f\162\141\x6e\x67\145", $AA) || !isset($AA["\x63\x74\137\x75\163\145\x72\x5f\160\x68\157\x6e\145\x5f\x6d\x69\156\x69\157\x72\141\156\147\145"]))) {
            goto z2;
        }
        return;
        z2:
        $this->sendChallenge('', '', null, trim($AA["\x63\164\137\x75\x73\x65\162\137\160\x68\157\x6e\145\137\x6d\x69\x6e\x69\x6f\x72\141\156\x67\x65"]), VerificationType::PHONE);
    }
    private function _processEmail($AA)
    {
        if (!(!array_key_exists("\x63\x74\137\x75\x73\x65\162\x5f\x65\155\141\151\x6c", $AA) || !isset($AA["\143\x74\x5f\165\163\145\x72\x5f\145\155\141\x69\154"]))) {
            goto bP;
        }
        return;
        bP:
        $this->sendChallenge('', $AA["\143\164\x5f\165\x73\x65\x72\x5f\145\155\141\x69\154"], null, null, VerificationType::EMAIL, '');
    }
    public function addPhoneFieldScript()
    {
        wp_enqueue_script("\x72\x65\141\x6c\105\x73\x74\141\x74\x65\x37\x53\x63\x72\x69\x70\164", MOV_URL . "\x69\x6e\143\154\165\144\145\163\x2f\x6a\163\57\162\145\x61\x6c\x45\x73\164\141\164\145\67\x2e\155\x69\x6e\x2e\152\163\77\166\x65\162\x73\x69\x6f\x6e\x3d" . MOV_VERSION, array("\152\x71\165\x65\x72\x79"));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto x4;
        }
        array_push($zX, $this->_phoneFormId);
        x4:
        return $zX;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto iC;
        }
        return;
        iC:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x72\145\x61\x6c\145\163\x74\141\x74\145\x5f\x65\156\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\162\145\x61\154\x65\x73\164\141\x74\x65\137\x63\157\156\x74\x61\143\x74\137\164\171\160\145");
        update_mo_option("\162\145\x61\154\x65\163\164\141\164\x65\x5f\145\x6e\141\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x72\x65\141\x6c\x65\x73\164\x61\x74\145\x5f\157\x74\160\137\x74\171\160\x65", $this->_otpType);
    }
}
