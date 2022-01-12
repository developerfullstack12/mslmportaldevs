<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class NinjaFormAjaxForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::NINJA_FORM_AJAX;
        $this->_typePhoneTag = "\155\x6f\x5f\156\x69\156\152\x61\x5f\x66\157\162\x6d\137\x70\150\x6f\x6e\145\137\145\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x6e\x69\156\x6a\141\x5f\146\157\x72\x6d\137\x65\155\141\151\154\x5f\x65\156\141\142\154\x65";
        $this->_typeBothTag = "\155\x6f\x5f\x6e\x69\x6e\152\x61\x5f\146\157\x72\x6d\137\x62\x6f\x74\x68\137\x65\156\141\142\154\x65";
        $this->_formKey = "\x4e\111\x4e\112\x41\137\x46\117\x52\115\x5f\101\112\x41\x58";
        $this->_formName = mo_("\116\x69\x6e\x6a\x61\x20\x46\157\x72\155\x73\40\x28\x20\x41\142\157\166\145\x20\x76\145\x72\163\151\x6f\156\40\63\56\60\x20\x29");
        $this->_isFormEnabled = get_mo_option("\156\x6a\141\x5f\145\156\141\142\x6c\145");
        $this->_buttonText = get_mo_option("\x6e\152\141\x5f\142\x75\164\x74\x6f\156\x5f\164\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\151\x63\x6b\40\x48\x65\x72\145\x20\164\x6f\x20\x73\x65\x6e\144\x20\x4f\124\x50");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::NINJA_FORMS_AJAX_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x6e\151\x6e\152\x61\137\146\x6f\x72\x6d\x5f\x65\x6e\x61\142\x6c\x65\x5f\x74\x79\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\156\x69\156\x6a\141\137\x66\x6f\x72\x6d\x5f\x6f\164\160\x5f\145\156\x61\x62\154\x65\x64"));
        if (!empty($this->_formDetails)) {
            goto wj;
        }
        return;
        wj:
        foreach ($this->_formDetails as $Zm => $zs) {
            array_push($this->_phoneFormId, "\x69\x6e\160\x75\x74\133\151\144\x3d\x6e\146\55\146\151\x65\154\144\55" . $zs["\160\x68\157\156\145\153\145\x79"] . "\x5d");
            pU:
        }
        c7:
        add_action("\x6e\151\x6e\152\x61\x5f\x66\x6f\162\x6d\x73\137\x61\146\x74\145\162\137\146\157\x72\155\137\x64\x69\163\160\x6c\141\x79", array($this, "\145\156\161\x75\145\x75\145\137\x6e\152\137\x66\x6f\x72\x6d\x5f\x73\143\162\151\160\164"), 99, 1);
        add_filter("\x6e\x69\x6e\x6a\x61\x5f\146\x6f\162\x6d\x73\x5f\163\165\142\155\x69\x74\x5f\144\x61\x74\141", array($this, "\137\150\x61\156\144\154\145\x5f\156\x6a\137\x61\152\x61\x78\x5f\146\x6f\162\155\137\x73\x75\x62\155\151\164"), 99, 1);
        $lr = $this->getVerificationType();
        if (!$lr) {
            goto Tg;
        }
        add_filter("\156\151\x6e\x6a\141\137\x66\157\162\155\x73\x5f\x6c\x6f\143\141\x6c\x69\172\x65\137\x66\151\145\154\x64\137\x73\x65\164\x74\151\156\147\163\137" . $lr, array($this, "\137\x61\x64\144\x5f\142\165\164\164\x6f\156"), 99, 2);
        Tg:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\x69\x6f\x6e", $_GET)) {
            goto jv;
        }
        return;
        jv:
        switch (trim($_GET["\x6f\x70\164\151\157\x6e"])) {
            case "\x6d\151\x6e\151\x6f\x72\x61\x6e\147\x65\55\156\x6a\55\x61\x6a\141\170\55\x76\x65\162\151\x66\x79":
                $this->_send_otp_nj_ajax_verify($_POST);
                goto Rq;
        }
        Rs:
        Rq:
    }
    function enqueue_nj_form_script($Ua)
    {
        if (!array_key_exists($Ua, $this->_formDetails)) {
            goto wI;
        }
        $VJ = $this->_formDetails[$Ua];
        $xY = array_keys($this->_formDetails);
        wp_register_script("\x6e\152\x73\143\162\151\x70\x74", MOV_URL . "\x69\x6e\x63\x6c\x75\144\145\163\x2f\x6a\x73\x2f\156\151\156\152\x61\x66\x6f\162\x6d\x61\152\x61\x78\56\155\x69\156\56\x6a\163", array("\x6a\x71\165\x65\x72\171"), MOV_VERSION, true);
        wp_localize_script("\x6e\x6a\163\x63\x72\151\x70\164", "\x6d\157\156\x69\x6e\x6a\x61\166\x61\162\163", array("\151\x6d\147\125\x52\114" => MOV_URL . "\x69\156\x63\x6c\165\144\145\163\57\151\155\141\x67\145\163\x2f\x6c\157\x61\x64\x65\162\x2e\147\x69\x66", "\x73\x69\x74\x65\125\122\114" => site_url(), "\157\x74\160\x54\171\x70\x65" => $this->_otpType == $this->_typePhoneTag ? VerificationType::PHONE : VerificationType::EMAIL, "\x66\x6f\162\x6d\163" => $this->_formDetails, "\146\x6f\x72\155\113\x65\x79\126\x61\154\x73" => $xY));
        wp_enqueue_script("\x6e\x6a\163\143\x72\x69\160\164");
        wI:
        return $Ua;
    }
    function _add_button($nZ, $form)
    {
        $Z9 = $form->get_id();
        if (array_key_exists($Z9, $this->_formDetails)) {
            goto AQ;
        }
        return $nZ;
        AQ:
        $VJ = $this->_formDetails[$Z9];
        $q1 = $this->_otpType == $this->_typePhoneTag ? "\x70\150\x6f\156\145\x6b\145\171" : "\145\x6d\141\x69\x6c\x6b\x65\x79";
        if (!($nZ["\x69\144"] == $VJ[$q1])) {
            goto D1;
        }
        $nZ["\x61\x66\164\x65\x72\106\151\145\x6c\144"] = "\xd\12\40\40\x20\40\x20\x20\40\40\x20\x20\x20\x20\40\40\x20\40\x3c\x64\x69\166\x20\151\x64\75\42\x6e\x66\x2d\146\x69\145\x6c\x64\x2d\64\55\x63\157\x6e\164\141\151\156\x65\162\42\40\x63\x6c\x61\163\x73\75\x22\x6e\146\x2d\146\x69\x65\154\144\55\x63\157\156\x74\x61\151\156\145\x72\40\163\x75\x62\x6d\x69\x74\x2d\x63\x6f\156\164\141\151\156\145\x72\40\40\154\x61\142\145\154\55\x61\142\x6f\166\x65\x20\42\x3e\xd\12\x20\x20\x20\40\40\x20\40\x20\x20\x20\40\40\40\40\40\x20\x20\x20\40\x20\74\144\151\166\40\143\x6c\141\x73\x73\75\x22\156\146\x2d\x62\145\146\x6f\x72\145\55\x66\x69\x65\x6c\x64\x22\76\xd\12\40\x20\40\40\40\40\x20\40\40\40\40\40\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\x3c\x6e\x66\x2d\x73\145\x63\164\x69\x6f\156\76\74\57\x6e\146\55\163\145\x63\164\x69\157\156\76\xd\12\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\40\x20\x20\40\40\40\74\57\x64\x69\x76\x3e\15\12\x20\40\x20\x20\40\40\x20\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\40\x20\x3c\x64\x69\166\40\143\x6c\141\x73\x73\x3d\42\x6e\x66\55\146\151\x65\154\144\x22\76\xd\12\x20\x20\x20\x20\x20\40\x20\40\40\40\x20\40\40\40\40\x20\x20\x20\x20\x20\x20\40\40\40\x3c\x64\x69\166\x20\143\154\141\x73\163\x3d\42\146\151\145\154\x64\55\x77\162\141\160\40\163\x75\142\x6d\x69\x74\55\x77\x72\x61\x70\42\x3e\xd\xa\40\x20\40\40\40\40\40\40\40\x20\40\40\x20\40\40\40\40\40\x20\x20\40\x20\40\x20\40\40\40\40\74\144\151\166\x20\x63\154\x61\x73\163\75\x22\x6e\x66\x2d\146\151\x65\154\144\x2d\x6c\x61\142\145\x6c\x22\76\74\x2f\x64\x69\x76\76\xd\xa\x20\40\x20\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\40\40\x20\x20\x20\x20\x20\40\40\x20\x20\40\x20\x3c\144\x69\x76\x20\x63\154\x61\163\x73\x3d\42\x6e\x66\x2d\x66\x69\145\154\x64\x2d\145\x6c\145\x6d\x65\x6e\x74\42\x3e\15\12\x20\x20\x20\40\40\x20\40\x20\x20\40\40\40\40\x20\x20\40\x20\x20\40\x20\40\40\x20\x20\40\40\40\40\40\x20\x20\40\74\x69\156\160\165\164\x20\40\151\x64\x3d\42\x6d\151\156\151\157\162\141\156\x67\x65\137\x6f\x74\160\137\x74\157\153\145\x6e\137\163\x75\142\x6d\151\x74\x5f" . $Z9 . "\x22\40\x63\x6c\x61\x73\x73\75\42\156\151\x6e\152\141\55\x66\157\x72\155\163\x2d\x66\151\x65\154\144\40\x6e\x66\55\x65\x6c\145\x6d\x65\156\164\42\15\12\40\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\40\40\40\40\40\40\x20\40\x20\40\x20\40\x20\40\x20\40\40\40\40\40\40\40\x76\x61\x6c\x75\x65\75\42" . mo_($this->_buttonText) . "\x22\x20\164\x79\x70\145\x3d\x22\142\x75\x74\164\157\x6e\x22\76\15\12\40\40\x20\40\x20\x20\x20\40\40\40\x20\40\40\40\x20\x20\40\40\40\40\40\40\40\40\x20\40\x20\40\74\57\144\151\166\76\xd\xa\x20\x20\40\40\x20\x20\40\x20\40\x20\40\40\40\x20\40\x20\40\x20\40\40\40\40\x20\40\74\x2f\144\x69\x76\x3e\xd\xa\40\40\40\x20\40\40\x20\40\40\x20\x20\x20\40\40\40\40\40\40\40\x20\x3c\x2f\x64\151\166\76\xd\xa\x20\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\40\x20\x20\40\x20\40\40\40\74\144\151\x76\x20\143\154\x61\x73\x73\x3d\x22\156\x66\55\141\146\164\145\162\55\x66\x69\145\x6c\x64\42\76\15\xa\x20\40\x20\40\x20\40\x20\x20\x20\40\40\x20\x20\x20\40\40\40\x20\x20\40\40\40\40\x20\74\x6e\x66\x2d\x73\x65\x63\x74\151\x6f\x6e\76\xd\xa\x20\x20\x20\x20\40\40\x20\40\x20\x20\40\40\40\x20\40\40\x20\x20\40\x20\x20\40\x20\40\x20\x20\40\x20\x3c\144\151\166\x20\143\x6c\141\x73\163\x3d\x22\156\x66\55\151\x6e\x70\165\x74\x2d\x6c\x69\155\x69\x74\x22\76\x3c\57\x64\x69\166\x3e\xd\xa\40\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\40\40\x20\x20\x20\40\x20\40\x20\x20\40\40\x20\x3c\x64\x69\x76\x20\x63\154\141\x73\163\75\x22\x6e\x66\x2d\145\162\162\157\162\55\167\162\141\x70\x20\156\146\x2d\x65\x72\x72\157\162\42\x3e\74\57\144\x69\166\76\xd\xa\40\40\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\40\40\40\x20\40\x20\40\40\x20\40\x3c\x2f\156\146\55\163\145\143\x74\151\x6f\x6e\76\xd\12\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\x20\74\x2f\x64\x69\166\x3e\15\xa\x20\x20\40\40\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\74\x2f\144\151\166\x3e\xd\xa\40\40\40\x20\x20\x20\40\40\40\40\40\x20\40\40\40\40\x3c\144\x69\166\x20\x69\x64\75\42\x6d\x6f\137\x6d\145\163\163\141\x67\x65\137" . $Z9 . "\x22\x20\150\x69\x64\144\x65\156\75\42\x22\x20\x73\x74\171\154\x65\x3d\x22\142\x61\x63\x6b\x67\162\157\x75\156\144\55\x63\x6f\x6c\x6f\162\x3a\x20\43\146\x37\x66\66\x66\67\x3b\x70\x61\144\x64\151\x6e\x67\x3a\40\61\x65\155\40\62\145\155\40\61\145\155\x20\x33\56\65\145\155\x3b\42\x3e\x3c\57\144\151\x76\x3e";
        D1:
        return $nZ;
    }
    function _handle_nj_ajax_form_submit($pO)
    {
        if (array_key_exists($pO["\x69\x64"], $this->_formDetails)) {
            goto ih;
        }
        return $pO;
        ih:
        $VJ = $this->_formDetails[$pO["\x69\x64"]];
        $pO = $this->checkIfOtpVerificationStarted($VJ, $pO);
        if (!isset($pO["\x65\x72\x72\x6f\x72\x73"]["\x66\151\145\x6c\x64\x73"])) {
            goto yg;
        }
        return $pO;
        yg:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto vS;
        }
        $pO = $this->processEmail($VJ, $pO);
        vS:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto Y1;
        }
        $pO = $this->processPhone($VJ, $pO);
        Y1:
        if (isset($pO["\145\162\162\157\162\163"]["\146\x69\x65\154\144\x73"])) {
            goto zX;
        }
        $pO = $this->processOTPEntered($pO, $VJ);
        zX:
        return $pO;
    }
    function processOTPEntered($pO, $VJ)
    {
        $sf = $VJ["\166\x65\162\151\146\x79\x4b\x65\171"];
        $lr = $this->getVerificationType();
        $this->validateChallenge($lr, NULL, $pO["\146\x69\145\x6c\x64\x73"][$sf]["\x76\x61\x6c\165\x65"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $lr)) {
            goto zL;
        }
        $this->unsetOTPSessionVariables();
        goto bf;
        zL:
        $pO["\145\x72\162\x6f\162\163"]["\146\151\x65\154\144\x73"][$sf] = MoUtility::_get_invalid_otp_method();
        bf:
        return $pO;
    }
    function checkIfOtpVerificationStarted($VJ, $pO)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto uy;
        }
        return $pO;
        uy:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto vR;
        }
        $pO["\x65\162\162\x6f\162\163"]["\146\151\x65\154\x64\x73"][$VJ["\160\150\157\x6e\x65\x6b\145\171"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        goto xi;
        vR:
        $pO["\145\162\x72\157\x72\x73"]["\146\x69\x65\x6c\144\x73"][$VJ["\145\x6d\141\151\x6c\153\x65\x79"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        xi:
        return $pO;
    }
    function processEmail($VJ, $pO)
    {
        $B9 = $VJ["\x65\155\x61\x69\154\x6b\x65\x79"];
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $pO["\146\151\x65\154\x64\x73"][$B9]["\x76\x61\x6c\x75\x65"])) {
            goto Ir;
        }
        $pO["\x65\162\x72\157\162\163"]["\146\x69\145\154\144\163"][$B9] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        Ir:
        return $pO;
    }
    function processPhone($VJ, $pO)
    {
        $B9 = $VJ["\x70\150\x6f\x6e\x65\153\x65\x79"];
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $pO["\146\151\x65\x6c\x64\x73"][$B9]["\166\x61\154\x75\x65"])) {
            goto uG;
        }
        $pO["\x65\x72\162\x6f\162\163"]["\146\151\x65\154\144\163"][$B9] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        uG:
        return $pO;
    }
    function _send_otp_nj_ajax_verify($pO)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Oh;
        }
        $this->_send_nj_ajax_otp_to_email($pO);
        goto v6;
        Oh:
        $this->_send_nj_ajax_otp_to_phone($pO);
        v6:
    }
    function _send_nj_ajax_otp_to_phone($pO)
    {
        if (!array_key_exists("\x75\x73\145\162\x5f\160\x68\157\156\x65", $pO) || !isset($pO["\165\163\x65\x72\137\x70\x68\x6f\156\x65"])) {
            goto NQ;
        }
        $this->setSessionAndStartOTPVerification(trim($pO["\165\163\145\162\137\160\150\157\x6e\145"]), NULL, trim($pO["\165\163\x65\162\137\x70\150\x6f\x6e\x65"]), VerificationType::PHONE);
        goto U5;
        NQ:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        U5:
    }
    function _send_nj_ajax_otp_to_email($pO)
    {
        if (!array_key_exists("\165\163\145\x72\x5f\145\155\141\x69\x6c", $pO) || !isset($pO["\x75\x73\x65\162\137\x65\155\141\x69\x6c"])) {
            goto tU;
        }
        $this->setSessionAndStartOTPVerification($pO["\x75\x73\x65\162\x5f\x65\x6d\x61\151\x6c"], $pO["\x75\x73\x65\x72\x5f\145\155\x61\151\x6c"], NULL, VerificationType::EMAIL);
        goto CB;
        tU:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        CB:
    }
    function setSessionAndStartOTPVerification($ZI, $TK, $Zu, $lr)
    {
        if ($lr === VerificationType::PHONE) {
            goto dT;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $ZI);
        goto DS;
        dT:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $ZI);
        DS:
        $this->sendChallenge('', $TK, NULL, $Zu, $lr);
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto oo;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        oo:
        return $zX;
    }
    function getFieldId($pO)
    {
        global $wpdb;
        return $wpdb->get_var("\123\x45\x4c\x45\x43\124\x20\151\x64\40\106\x52\x4f\115\x20{$wpdb->prefix}\156\x66\x33\x5f\146\151\145\154\x64\x73\40\167\x68\145\x72\145\40\x60\153\x65\x79\140\x20\x3d\x27" . $pO . "\47");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Im;
        }
        return;
        Im:
        if (!isset($_POST["\155\157\137\x63\165\x73\x74\x6f\x6d\145\x72\x5f\166\x61\x6c\x69\144\x61\x74\151\157\x6e\137\x6e\151\x6e\x6a\141\x5f\146\x6f\162\155\137\x65\156\141\x62\154\145"])) {
            goto Fi;
        }
        return;
        Fi:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\156\x6a\x61\137\x65\156\141\x62\x6c\145\137\x74\171\160\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\156\x6a\x61\x5f\145\x6e\x61\x62\x6c\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x6e\152\x61\x5f\142\165\164\x74\157\156\x5f\x74\145\x78\164");
        update_mo_option("\x6e\x69\156\152\141\x5f\146\x6f\162\155\137\145\156\141\x62\154\x65", 0);
        update_mo_option("\x6e\152\141\x5f\145\156\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\156\x69\x6e\x6a\141\137\146\157\x72\x6d\x5f\145\x6e\x61\x62\154\x65\x5f\164\x79\160\145", $this->_otpType);
        update_mo_option("\x6e\x69\156\x6a\x61\137\146\x6f\x72\155\137\x6f\164\x70\137\x65\x6e\x61\142\x6c\145\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\156\x6a\x61\x5f\x62\x75\164\x74\157\156\x5f\164\x65\x78\164", $this->_buttonText);
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x6e\x69\x6e\x6a\x61\137\141\152\x61\x78\x5f\146\157\162\x6d", $_POST)) {
            goto yC;
        }
        return array();
        yC:
        foreach (array_filter($_POST["\156\x69\156\x6a\141\x5f\141\x6a\x61\x78\x5f\146\x6f\x72\x6d"]["\146\x6f\162\x6d"]) as $Zm => $zs) {
            $form[$zs] = array("\x65\x6d\141\151\x6c\x6b\x65\171" => $this->getFieldId($_POST["\156\x69\156\152\x61\x5f\x61\x6a\x61\x78\x5f\146\157\x72\x6d"]["\145\155\x61\151\154\x6b\145\171"][$Zm]), "\x70\150\x6f\156\145\x6b\x65\x79" => $this->getFieldId($_POST["\156\151\156\x6a\x61\x5f\x61\x6a\141\170\137\146\x6f\162\155"]["\x70\150\157\156\145\153\145\171"][$Zm]), "\166\x65\162\x69\x66\x79\x4b\145\x79" => $this->getFieldId($_POST["\x6e\x69\156\x6a\x61\137\141\x6a\x61\170\137\x66\x6f\162\x6d"]["\166\x65\x72\x69\x66\x79\x4b\145\171"][$Zm]), "\160\x68\x6f\156\x65\137\x73\150\157\167" => $_POST["\x6e\151\x6e\152\141\x5f\141\152\x61\170\x5f\x66\x6f\162\x6d"]["\x70\x68\x6f\156\145\x6b\145\x79"][$Zm], "\145\155\141\151\154\x5f\x73\150\x6f\x77" => $_POST["\156\x69\156\152\x61\x5f\x61\152\141\170\137\146\157\x72\155"]["\x65\x6d\141\151\154\x6b\x65\171"][$Zm], "\166\145\162\151\146\171\137\x73\x68\157\x77" => $_POST["\x6e\x69\156\x6a\141\x5f\141\152\141\x78\x5f\x66\157\x72\x6d"]["\166\145\162\151\x66\171\x4b\145\x79"][$Zm]);
            Wr:
        }
        wC:
        return $form;
    }
}
