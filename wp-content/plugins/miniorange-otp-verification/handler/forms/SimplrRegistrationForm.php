<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
use stdClass;
class SimplrRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::SIMPLR_REG;
        $this->_typePhoneTag = "\x6d\x6f\137\x70\x68\x6f\x6e\145\137\x65\x6e\141\x62\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\145\x6d\141\x69\x6c\x5f\145\x6e\x61\142\154\x65";
        $this->_typeBothTag = "\x6d\157\x5f\142\157\164\150\x5f\145\156\141\142\x6c\x65";
        $this->_formKey = "\123\111\x4d\x50\x4c\x52\137\x46\x4f\122\115";
        $this->_formName = mo_("\123\151\x6d\x70\154\x72\x20\125\163\x65\x72\x20\x52\x65\x67\151\x73\x74\162\x61\164\151\157\x6e\x20\106\157\162\155\40\120\x6c\165\163");
        $this->_isFormEnabled = get_mo_option("\x73\x69\x6d\x70\x6c\162\x5f\144\145\146\x61\165\154\x74\137\145\x6e\x61\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::SIMPLR_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_formKey = get_mo_option("\163\x69\x6d\x70\x6c\x72\x5f\x66\151\x65\154\x64\137\x6b\145\x79");
        $this->_otpType = get_mo_option("\x73\151\x6d\160\x6c\x72\137\x65\x6e\x61\x62\x6c\145\137\164\171\x70\145");
        $this->_phoneFormId = "\151\156\160\x75\x74\x5b\x6e\x61\155\x65\x3d" . $this->_formKey . "\135";
        add_filter("\x73\151\155\x70\154\162\137\166\x61\x6c\x69\144\141\164\x65\x5f\x66\157\162\155", array($this, "\163\x69\155\160\154\x72\137\x73\151\164\145\x5f\162\145\x67\x69\163\x74\162\x61\164\x69\157\156\x5f\145\x72\x72\x6f\162\163"), 10, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $HV = $this->getVerificationType();
        return $HV === VerificationType::PHONE || $HV === VerificationType::BOTH;
    }
    function simplr_site_registration_errors($errors)
    {
        $hs = $J9 = '';
        if (!(!empty($errors) || isset($_POST["\146\x62\x75\163\145\162\x5f\151\144"]))) {
            goto Qh;
        }
        return $errors;
        Qh:
        foreach ($_POST as $Zm => $zs) {
            if ($Zm == "\x75\163\145\x72\x6e\x61\x6d\x65") {
                goto UM;
            }
            if ($Zm == "\145\x6d\141\151\154") {
                goto fF;
            }
            if ($Zm == "\160\141\x73\x73\x77\157\162\144") {
                goto q6;
            }
            if ($Zm == $this->_formKey) {
                goto rv;
            }
            $tA[$Zm] = $zs;
            goto YK;
            UM:
            $HR = $zs;
            goto YK;
            fF:
            $h4 = $zs;
            goto YK;
            q6:
            $hs = $zs;
            goto YK;
            rv:
            $J9 = $zs;
            YK:
            cq:
        }
        h4:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && !$this->processPhone($J9, $errors))) {
            goto yJ;
        }
        return $errors;
        yJ:
        $this->processAndStartOTPVerificationProcess($HR, $h4, $errors, $J9, $hs, $tA);
        return $errors;
    }
    function processPhone($J9, &$errors)
    {
        if (MoUtility::validatePhoneNumber($J9)) {
            goto sx;
        }
        global $phoneLogic;
        $errors[] .= str_replace("\x23\43\160\150\x6f\x6e\x65\x23\x23", $J9, $phoneLogic->_get_otp_invalid_format_message());
        add_filter($this->_formKey . "\137\145\162\162\x6f\x72\x5f\143\x6c\x61\x73\x73", "\137\x73\x72\x65\x67\x5f\x72\x65\x74\x75\162\156\137\x65\162\x72\157\x72");
        return FALSE;
        sx:
        return TRUE;
    }
    function processAndStartOTPVerificationProcess($HR, $h4, $errors, $J9, $hs, $tA)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto HH;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto AR;
        }
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::EMAIL, $hs, $tA);
        goto W9;
        AR:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::BOTH, $hs, $tA);
        W9:
        goto DZ;
        HH:
        $this->sendChallenge($HR, $h4, $errors, $J9, VerificationType::PHONE, $hs, $tA);
        DZ:
    }
    function register_simplr_user($wB, $CG, $hs, $J9, $tA)
    {
        $pO = array();
        global $sreg;
        if ($sreg) {
            goto KE;
        }
        $sreg = new stdClass();
        KE:
        $pO["\x75\163\145\162\x6e\141\155\x65"] = $wB;
        $pO["\145\x6d\x61\x69\154"] = $CG;
        $pO["\160\x61\163\x73\167\157\x72\144"] = $hs;
        if (!$this->_formKey) {
            goto ln;
        }
        $pO[$this->_formKey] = $J9;
        ln:
        $pO = array_merge($pO, $tA);
        $oK = $tA["\141\x74\164\163"];
        $sreg->output = simplr_setup_user($oK, $pO);
        if (!MoUtility::isBlank($sreg->errors)) {
            goto vc;
        }
        $this->checkMessageAndRedirect($oK);
        vc:
    }
    function checkMessageAndRedirect($oK)
    {
        global $sreg, $simplr_options;
        $Ab = isset($oK["\164\150\141\x6e\153\163"]) ? get_permalink($oK["\164\x68\x61\x6e\x6b\x73"]) : (!MoUtility::isBlank($simplr_options->thank_you) ? get_permalink($simplr_options->thank_you) : '');
        if (MoUtility::isBlank($Ab)) {
            goto Ls;
        }
        wp_redirect($Ab);
        die;
        goto Nn;
        Ls:
        $sreg->success = $sreg->output;
        Nn:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto U1;
        }
        return;
        U1:
        $HV = $this->getVerificationType();
        $wp = $HV === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wB, $CG, $J9, MoUtility::_get_invalid_otp_method(), $HV, $wp);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        $this->unsetOTPSessionVariables();
        $this->register_simplr_user($wB, $CG, $hs, $J9, $tA);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto B_;
        }
        array_push($zX, $this->_phoneFormId);
        B_:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto nd;
        }
        return;
        nd:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\163\151\x6d\x70\154\x72\137\144\145\146\141\165\154\164\137\x65\156\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\163\x69\155\160\x6c\162\x5f\145\x6e\x61\142\154\145\137\164\x79\x70\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\163\x69\x6d\x70\154\162\x5f\160\150\x6f\x6e\145\137\x66\151\x65\154\144\137\x6b\x65\x79");
        update_mo_option("\163\x69\x6d\x70\154\162\x5f\x64\145\146\x61\165\154\x74\x5f\145\x6e\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\163\151\x6d\x70\154\x72\137\145\156\x61\142\154\145\137\164\171\160\145", $this->_otpType);
        update_mo_option("\163\x69\155\160\154\x72\x5f\146\x69\145\154\x64\x5f\x6b\145\x79", $this->_phoneKey);
    }
}
