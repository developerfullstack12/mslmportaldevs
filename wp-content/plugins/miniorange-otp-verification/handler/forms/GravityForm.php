<?php


namespace OTP\Handler\Forms;

use GF_Field;
use GFAPI;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class GravityForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::GF_FORMS;
        $this->_typePhoneTag = "\155\x6f\137\147\146\x5f\143\157\x6e\x74\x61\x63\164\x5f\x70\150\x6f\156\145\x5f\145\x6e\x61\x62\x6c\145";
        $this->_typeEmailTag = "\155\157\137\147\146\137\143\157\156\164\x61\143\164\x5f\x65\155\141\x69\x6c\x5f\145\x6e\141\142\x6c\145";
        $this->_formKey = "\107\122\x41\x56\x49\x54\131\137\x46\x4f\x52\x4d";
        $this->_formName = mo_("\107\162\x61\166\x69\x74\171\40\106\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\147\x66\137\143\157\156\x74\x61\x63\164\137\145\156\141\142\154\x65");
        $this->_phoneFormId = "\56\147\151\x6e\160\165\x74\137\143\x6f\x6e\x74\141\151\x6e\145\162\137\160\x68\157\x6e\x65";
        $this->_buttonText = get_mo_option("\x67\x66\137\x62\x75\164\164\157\156\x5f\x74\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\143\153\40\x48\145\162\145\40\x74\x6f\40\163\145\156\x64\40\117\124\120");
        $this->_formDocuments = MoOTPDocs::GF_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x67\146\137\143\x6f\156\164\141\143\164\137\x74\171\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\147\x66\x5f\x6f\164\x70\x5f\145\x6e\141\x62\154\145\144"));
        if (!empty($this->_formDetails)) {
            goto yE;
        }
        return;
        yE:
        add_filter("\147\x66\x6f\162\x6d\137\146\x69\145\x6c\144\137\x63\157\x6e\164\x65\x6e\164", array($this, "\x5f\x61\144\x64\137\163\x63\x72\x69\x70\x74\163"), 1, 5);
        add_filter("\x67\146\157\162\155\x5f\146\151\x65\x6c\144\137\x76\141\x6c\x69\x64\141\x74\x69\157\156", array($this, "\x76\141\154\151\144\141\164\145\137\x66\157\162\x6d\x5f\163\165\142\x6d\x69\x74"), 1, 5);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\151\157\156", $_GET)) {
            goto r4;
        }
        return;
        r4:
        switch (trim($_GET["\x6f\x70\x74\151\157\x6e"])) {
            case "\x6d\151\x6e\x69\x6f\x72\x61\x6e\x67\x65\55\x67\x66\55\143\157\156\x74\141\x63\164":
                $this->_handle_gf_form($_POST);
                goto Un;
        }
        dC:
        Un:
    }
    function _handle_gf_form($fy)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto eQ;
        }
        $this->processEmailAndStartOTPVerificationProcess($fy);
        eQ:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto a3;
        }
        $this->processPhoneAndStartOTPVerificationProcess($fy);
        a3:
    }
    function processEmailAndStartOTPVerificationProcess($fy)
    {
        if (MoUtility::sanitizeCheck("\165\163\x65\162\137\x65\x6d\141\x69\x6c", $fy)) {
            goto H2;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto hF;
        H2:
        SessionUtils::addEmailVerified($this->_formSessionVar, $fy["\165\163\x65\x72\x5f\x65\x6d\141\x69\154"]);
        $this->sendChallenge('', $fy["\x75\163\x65\x72\x5f\145\155\x61\151\154"], null, $fy["\165\x73\x65\162\137\x65\155\141\x69\154"], VerificationType::EMAIL);
        hF:
    }
    function processPhoneAndStartOTPVerificationProcess($fy)
    {
        if (MoUtility::sanitizeCheck("\x75\163\x65\162\137\160\150\x6f\156\x65", $fy)) {
            goto Zj;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Ac;
        Zj:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($fy["\x75\163\x65\162\137\160\x68\x6f\156\x65"]));
        $this->sendChallenge('', '', null, trim($fy["\165\163\x65\x72\137\160\x68\157\156\145"]), VerificationType::PHONE);
        Ac:
    }
    function _add_scripts($rL, $Pj, $zs, $N4, $Ua)
    {
        $VJ = $this->_formDetails[$Ua];
        if (MoUtility::isBlank($VJ)) {
            goto aM;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && get_class($Pj) === "\107\106\137\106\151\145\x6c\144\x5f\105\x6d\x61\x69\154" && $Pj["\x69\x64"] == $VJ["\x65\155\x61\151\154\153\x65\171"])) {
            goto Cg;
        }
        $rL = $this->_add_shortcode_to_form("\x65\x6d\141\151\154", $rL, $Pj, $Ua);
        Cg:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && get_class($Pj) === "\107\106\137\106\151\x65\154\144\137\120\150\x6f\156\145" && $Pj["\151\x64"] == $VJ["\x70\150\157\x6e\145\x6b\x65\171"])) {
            goto ti;
        }
        $rL = $this->_add_shortcode_to_form("\160\x68\157\156\145", $rL, $Pj, $Ua);
        ti:
        aM:
        return $rL;
    }
    function _add_shortcode_to_form($T0, $rL, $Pj, $Ua)
    {
        $Eo = "\74\144\151\166\40\x73\164\x79\154\145\75\x27\x64\151\163\160\x6c\x61\171\72\x74\141\142\154\x65\73\x74\x65\x78\x74\x2d\x61\x6c\151\147\x6e\x3a\143\x65\156\x74\145\162\73\x27\76\74\x69\x6d\x67\40\x73\x72\143\75\47" . MOV_URL . "\151\156\143\154\165\144\145\x73\57\x69\x6d\x61\147\x65\163\x2f\x6c\157\141\144\x65\162\x2e\x67\151\x66\47\76\74\57\x64\151\x76\x3e";
        $rL .= "\74\144\151\166\x20\x73\x74\171\154\x65\x3d\47\155\x61\162\x67\x69\156\55\x74\x6f\x70\x3a\x20\62\45\73\x27\76\74\151\x6e\160\165\164\40\x74\x79\160\x65\75\x27\x62\165\164\x74\x6f\156\x27\x20\143\x6c\x61\x73\163\x3d\47\x67\146\157\x72\x6d\137\142\x75\164\164\157\156\40\x62\x75\164\x74\157\x6e\40\155\145\x64\x69\x75\155\47\x20";
        $rL .= "\x69\x64\75\47\x6d\151\156\151\x6f\162\141\156\147\145\137\157\164\160\137\164\x6f\x6b\x65\x6e\137\x73\x75\x62\x6d\x69\x74\x27\x20\x74\x69\164\x6c\145\75\x27\120\x6c\145\141\x73\x65\40\105\x6e\x74\145\162\40\x61\x6e\40" . $T0 . "\x20\164\x6f\40\x65\156\x61\142\154\145\x20\164\150\x69\163\x27\x20";
        $rL .= "\166\141\154\165\x65\x3d\40\47" . mo_($this->_buttonText) . "\47\x3e\74\144\x69\166\x20\x73\x74\171\154\145\75\47\x6d\x61\x72\147\x69\x6e\x2d\x74\x6f\x70\72\x32\x25\47\76";
        $rL .= "\74\144\151\x76\x20\151\144\x3d\x27\x6d\x6f\137\155\x65\x73\163\x61\x67\x65\47\40\150\151\x64\x64\x65\156\x3d\x27\x27\40\x73\x74\171\154\x65\75\x27\x62\x61\x63\x6b\x67\x72\x6f\x75\156\144\x2d\143\157\154\x6f\x72\72\40\x23\x66\67\146\66\146\x37\73\160\x61\144\x64\151\x6e\x67\72\x20\61\x65\x6d\40\62\145\x6d\x20\61\x65\x6d\40\63\x2e\x35\145\x6d\x3b\x27\x3e\x3c\57\x64\151\x76\x3e\74\57\144\151\x76\76\74\x2f\144\151\x76\76";
        $rL .= "\x3c\163\164\171\154\145\76\x40\x6d\145\x64\x69\141\40\x6f\x6e\x6c\x79\40\x73\x63\162\x65\x65\x6e\x20\141\x6e\144\40\x28\155\x69\156\55\167\x69\144\x74\x68\72\40\66\64\x31\x70\x78\51\x20\173\x20\43\155\x6f\137\x6d\x65\x73\x73\141\x67\145\x20\x7b\40\x77\x69\x64\x74\x68\72\40\143\141\x6c\143\x28\x35\x30\x25\x20\x2d\40\x38\160\x78\x29\x3b\175\x7d\74\57\x73\x74\171\x6c\x65\x3e";
        $rL .= "\74\x73\x63\162\151\x70\x74\76\x6a\x51\x75\x65\x72\x79\50\144\157\x63\165\x6d\x65\x6e\x74\x29\56\x72\x65\141\x64\171\50\146\x75\156\143\164\x69\157\x6e\x28\x29\173\x24\155\x6f\x3d\x6a\121\165\145\x72\x79\73\x24\155\x6f\x28\42\x23\147\x66\x6f\x72\x6d\137" . $Ua . "\40\43\155\x69\x6e\x69\157\162\141\x6e\147\x65\137\x6f\x74\x70\x5f\x74\x6f\x6b\x65\x6e\x5f\x73\x75\x62\x6d\151\x74\x22\51\x2e\x63\x6c\151\x63\x6b\50\x66\165\x6e\x63\x74\x69\157\x6e\x28\157\51\173";
        $rL .= "\x76\141\x72\x20\145\x3d\x24\155\157\x28\x22\x23\x69\x6e\160\x75\164\x5f" . $Ua . "\x5f" . $Pj->id . "\x22\51\x2e\166\141\154\x28\x29\x3b\x20\x24\155\157\x28\x22\43\x67\146\x6f\162\155\x5f" . $Ua . "\40\x23\x6d\x6f\137\155\145\163\163\141\147\145\x22\x29\56\145\x6d\160\164\171\50\51\54\44\x6d\x6f\50\42\x23\147\146\157\162\x6d\137" . $Ua . "\x20\43\155\157\137\155\145\163\163\x61\x67\x65\x22\x29\x2e\141\160\x70\x65\x6e\x64\x28\42" . $Eo . "\42\51";
        $rL .= "\x2c\x24\155\157\x28\x22\x23\x67\x66\157\x72\155\137" . $Ua . "\x20\43\155\x6f\137\155\145\163\x73\141\x67\145\x22\x29\56\163\150\157\167\x28\51\54\x24\155\157\56\141\x6a\x61\x78\x28\173\165\x72\x6c\72\42" . site_url() . "\57\x3f\x6f\160\x74\x69\x6f\x6e\x3d\x6d\151\x6e\151\157\162\141\x6e\x67\145\x2d\147\x66\x2d\x63\x6f\156\x74\x61\143\x74\x22\54\164\x79\x70\x65\72\42\x50\x4f\x53\x54\x22\54\x64\141\x74\141\72\173\165\x73\145\x72\137";
        $rL .= $T0 . "\72\145\x7d\x2c\x63\162\157\163\x73\104\x6f\x6d\x61\x69\x6e\x3a\41\60\x2c\x64\141\164\x61\124\x79\x70\x65\x3a\x22\x6a\163\x6f\156\x22\54\163\165\x63\x63\145\x73\163\72\146\x75\x6e\143\x74\151\157\156\50\157\51\173\x20\x69\x66\x28\x6f\56\162\145\x73\x75\154\164\x3d\x3d\75\42\163\x75\x63\x63\145\163\x73\42\51\173\x24\x6d\157\x28\x22\43\147\x66\x6f\x72\155\x5f" . $Ua . "\x20\43\x6d\157\137\x6d\145\x73\163\141\x67\x65\x22\x29\x2e\145\x6d\160\x74\171\50\51";
        $rL .= "\x2c\44\155\x6f\x28\x22\x23\x67\146\157\x72\x6d\x5f" . $Ua . "\x20\43\x6d\157\137\x6d\145\163\x73\141\147\x65\42\51\56\141\160\x70\x65\156\144\x28\157\56\155\x65\x73\x73\141\147\145\51\54\x24\x6d\157\x28\42\43\147\x66\x6f\x72\x6d\x5f" . $Ua . "\x20\43\x6d\x6f\137\x6d\145\x73\163\141\x67\x65\42\51\56\143\x73\x73\x28\x22\x62\157\x72\x64\x65\x72\55\164\157\x70\42\x2c\x22\x33\160\170\40\163\157\x6c\x69\144\x20\x67\x72\145\145\156\42\x29\x2c\44\x6d\157\50\42";
        $rL .= "\43\x67\146\157\x72\x6d\137" . $Ua . "\40\151\156\x70\165\x74\133\x6e\141\x6d\x65\75\145\x6d\141\x69\x6c\x5f\x76\145\x72\x69\146\171\135\42\51\x2e\146\x6f\143\165\163\50\51\x7d\145\154\163\145\173\x24\155\x6f\50\x22\43\x67\146\x6f\162\155\x5f" . $Ua . "\40\43\155\x6f\x5f\155\x65\163\x73\141\x67\x65\x22\51\x2e\145\155\160\164\171\50\x29\x2c\x24\155\x6f\x28\x22\43\x67\x66\x6f\x72\155\137" . $Ua . "\x20\43\x6d\157\137\155\x65\x73\x73\x61\x67\145\x22\x29\x2e\x61\160\160\145\x6e\x64\50\x6f\56\155\x65\x73\163\x61\147\x65\x29\54";
        $rL .= "\44\155\157\50\42\43\x67\146\x6f\x72\x6d\x5f" . $Ua . "\x20\x23\x6d\157\137\155\145\163\x73\x61\147\x65\42\51\56\x63\x73\163\x28\x22\142\157\162\x64\x65\162\x2d\164\157\x70\42\x2c\x22\x33\x70\170\x20\163\157\x6c\x69\144\40\162\145\x64\42\x29\x2c\44\155\x6f\x28\x22\43\147\146\157\162\x6d\137" . $Ua . "\40\x69\156\160\165\164\x5b\156\x61\x6d\145\75\160\150\157\156\145\137\x76\145\162\151\x66\x79\x5d\42\51\56\146\157\x63\165\x73\x28\x29\x7d\x20\73\x7d\54";
        $rL .= "\145\x72\x72\157\162\x3a\x66\x75\x6e\x63\x74\151\x6f\156\50\157\54\145\x2c\156\x29\x7b\x7d\175\x29\x7d\51\73\x7d\x29\73\x3c\57\x73\x63\162\x69\x70\164\76";
        return $rL;
    }
    function validate_form_submit($Dz, $zs, $form, $Pj)
    {
        $J4 = MoUtility::sanitizeCheck($Pj->formId, $this->_formDetails);
        if (!($J4 && $Dz["\151\163\x5f\166\141\154\151\x64"] == 1)) {
            goto hn;
        }
        if (strpos($Pj->label, $J4["\166\145\162\151\146\171\x4b\145\x79"]) !== false && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto BL;
        }
        if (!$this->isEmailOrPhoneField($Pj, $J4)) {
            goto FT;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto o3;
        }
        $Dz = array("\x69\x73\x5f\x76\x61\154\x69\x64" => null, "\x6d\145\163\x73\141\147\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        goto tx;
        o3:
        $Dz = $this->validate_submitted_email_or_phone($Dz["\x69\163\x5f\x76\x61\x6c\151\144"], $zs, $Dz);
        tx:
        FT:
        goto Gf;
        BL:
        $Dz = $this->validate_otp($Dz, $zs);
        Gf:
        hn:
        return $Dz;
    }
    function validate_otp($Dz, $zs)
    {
        $lr = $this->getVerificationType();
        if (MoUtility::isBlank($zs)) {
            goto et;
        }
        $this->validateChallenge($lr, NULL, $zs);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $lr)) {
            goto W7;
        }
        $this->unsetOTPSessionVariables();
        goto ri;
        W7:
        $Dz = array("\151\163\137\166\141\154\151\144" => null, "\x6d\x65\163\163\141\147\x65" => MoUtility::_get_invalid_otp_method());
        ri:
        goto yX;
        et:
        $Dz = array("\151\x73\x5f\166\x61\x6c\151\x64" => null, "\x6d\x65\163\163\x61\x67\x65" => MoUtility::_get_invalid_otp_method());
        yX:
        return $Dz;
    }
    function validate_submitted_email_or_phone($JZ, $zs, $Dz)
    {
        $lr = $this->getVerificationType();
        if (!$JZ) {
            goto l2;
        }
        if ($lr === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $zs)) {
            goto Uk;
        }
        if (!($lr === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $zs))) {
            goto PO;
        }
        return array("\151\163\137\166\141\x6c\151\x64" => null, "\x6d\x65\x73\163\x61\x67\x65" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        PO:
        goto Rd;
        Uk:
        return array("\x69\x73\137\166\141\154\x69\144" => null, "\155\x65\x73\x73\141\147\145" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        Rd:
        l2:
        return $Dz;
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto F_;
        }
        foreach ($this->_formDetails as $Zm => $sp) {
            $kR = sprintf("\x25\163\x5f\45\x64\x5f\x25\144", "\151\156\x70\x75\164", $Zm, $sp["\160\x68\157\156\x65\153\145\171"]);
            array_push($zX, sprintf("\45\163\40\x23\x25\163", $this->_phoneFormId, $kR));
            z7:
        }
        Eg:
        F_:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto hr;
        }
        return;
        hr:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\147\146\137\143\x6f\x6e\x74\141\143\x74\x5f\145\156\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x67\146\x5f\143\x6f\156\x74\x61\x63\164\x5f\164\x79\160\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\147\146\137\x62\x75\x74\164\157\156\137\x74\145\x78\164");
        $k3 = $this->parseFormDetails();
        $this->_formDetails = is_array($k3) ? $k3 : '';
        update_mo_option("\x67\x66\x5f\x6f\164\x70\137\145\x6e\141\142\x6c\145\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\x67\x66\x5f\143\x6f\x6e\x74\141\x63\164\137\145\x6e\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x67\x66\137\143\157\x6e\164\141\143\164\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\x67\146\137\x62\165\x74\164\x6f\x6e\x5f\164\x65\170\164", $this->_buttonText);
    }
    private function parseFormDetails()
    {
        $k3 = array();
        $UT = function ($Jk, $mG, $QH) {
            foreach ($Jk as $Pj) {
                if (!(get_class($Pj) === $QH && $Pj["\x6c\x61\x62\145\x6c"] == $mG)) {
                    goto Mu;
                }
                return $Pj["\x69\144"];
                Mu:
                kj:
            }
            a8:
            return null;
        };
        $form = NULL;
        if (!(!array_key_exists("\147\162\141\x76\x69\164\171\x5f\x66\x6f\x72\x6d", $_POST) || !$this->_isFormEnabled)) {
            goto M8;
        }
        return array();
        M8:
        foreach (array_filter($_POST["\147\x72\x61\166\x69\164\171\137\x66\x6f\162\155"]["\x66\157\x72\x6d"]) as $Zm => $zs) {
            $VJ = GFAPI::get_form($zs);
            $kk = $_POST["\147\x72\x61\x76\151\164\x79\x5f\146\157\x72\155"]["\145\x6d\x61\x69\x6c\153\145\x79"][$Zm];
            $wF = $_POST["\147\162\x61\166\x69\x74\171\137\146\x6f\x72\155"]["\160\x68\x6f\x6e\145\x6b\145\x79"][$Zm];
            $k3[$zs] = array("\x65\155\x61\x69\x6c\x6b\x65\x79" => $UT($VJ["\146\x69\x65\x6c\x64\x73"], $kk, "\107\x46\x5f\x46\x69\145\x6c\144\x5f\x45\x6d\141\x69\x6c"), "\x70\x68\157\x6e\145\x6b\145\x79" => $UT($VJ["\146\151\145\154\x64\163"], $wF, "\107\x46\x5f\106\151\145\x6c\144\137\x50\150\x6f\156\x65"), "\166\145\x72\x69\x66\x79\x4b\145\x79" => $_POST["\x67\x72\x61\x76\x69\x74\x79\137\146\157\162\x6d"]["\166\x65\162\151\146\171\x4b\x65\x79"][$Zm], "\160\x68\157\156\x65\x5f\x73\150\157\x77" => $_POST["\x67\162\141\166\151\164\x79\137\146\x6f\x72\155"]["\x70\x68\157\x6e\145\x6b\145\x79"][$Zm], "\x65\x6d\x61\151\x6c\137\x73\x68\157\167" => $_POST["\x67\x72\x61\166\x69\164\x79\137\x66\x6f\162\x6d"]["\145\155\x61\151\x6c\153\145\x79"][$Zm], "\166\x65\x72\151\x66\171\137\x73\x68\x6f\x77" => $_POST["\x67\162\x61\x76\x69\x74\x79\137\x66\157\162\x6d"]["\166\145\162\151\x66\x79\113\x65\171"][$Zm]);
            RT:
        }
        EG:
        return $k3;
    }
    private function isEmailOrPhoneField($Pj, $ua)
    {
        return $this->_otpType === $this->_typePhoneTag && $Pj->id === $ua["\160\150\157\x6e\145\x6b\x65\171"] || $this->_otpType === $this->_typeEmailTag && $Pj->id === $ua["\x65\x6d\x61\x69\x6c\x6b\x65\x79"];
    }
}
