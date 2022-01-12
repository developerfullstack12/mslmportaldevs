<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WPCF7_FormTag;
use WPCF7_Validation;
class ContactForm7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CF7_FORMS;
        $this->_typePhoneTag = "\155\157\x5f\143\146\67\x5f\143\157\156\164\141\x63\164\x5f\160\150\x6f\156\145\137\145\156\141\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\137\x63\146\67\x5f\x63\x6f\156\164\x61\x63\164\137\x65\x6d\x61\151\154\x5f\145\x6e\141\x62\154\x65";
        $this->_formKey = "\103\106\x37\137\106\117\x52\115";
        $this->_formName = mo_("\x43\x6f\x6e\x74\141\x63\x74\x20\106\x6f\162\155\40\67\40\55\x20\x43\x6f\x6e\164\141\x63\164\x20\x46\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x63\146\67\x5f\143\157\x6e\164\141\x63\x74\137\x65\x6e\141\x62\x6c\x65");
        $this->_generateOTPAction = "\155\x69\156\x69\x6f\162\x61\x6e\x67\145\55\x63\146\67\x2d\143\157\156\x74\141\143\164";
        $this->_formDocuments = MoOTPDocs::CF7_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\146\67\x5f\143\x6f\156\164\x61\x63\x74\137\x74\171\160\x65");
        $this->_emailKey = get_mo_option("\143\146\67\x5f\145\x6d\x61\151\x6c\137\x6b\x65\x79");
        $this->_phoneKey = "\x6d\x6f\137\x70\150\x6f\156\145";
        $this->_phoneFormId = array("\x2e\x63\x6c\141\163\x73\137" . $this->_phoneKey, "\151\156\160\x75\164\x5b\156\x61\x6d\x65\75" . $this->_phoneKey . "\x5d");
        add_filter("\167\x70\x63\146\x37\x5f\x76\x61\x6c\151\x64\x61\164\145\x5f\x74\145\170\x74\x2a", array($this, "\166\x61\x6c\151\144\x61\164\x65\x46\157\x72\x6d\x50\157\x73\x74"), 1, 2);
        add_filter("\x77\160\143\x66\x37\137\166\x61\154\151\x64\141\164\145\137\145\155\x61\x69\x6c\x2a", array($this, "\166\x61\154\151\x64\141\x74\x65\x46\x6f\162\x6d\120\157\x73\x74"), 1, 2);
        add_filter("\x77\x70\x63\x66\x37\x5f\x76\x61\154\151\144\x61\164\145\137\145\155\x61\x69\154", array($this, "\x76\x61\x6c\151\x64\141\164\x65\x46\157\162\x6d\x50\x6f\163\x74"), 1, 2);
        add_filter("\x77\160\143\x66\67\x5f\166\141\154\x69\x64\x61\164\145\x5f\164\145\x6c\52", array($this, "\x76\x61\x6c\x69\x64\141\164\145\x46\157\x72\x6d\120\157\x73\164"), 1, 2);
        add_action("\x77\x70\143\x66\x37\137\x62\145\x66\157\162\145\137\x73\x65\156\x64\x5f\155\141\x69\x6c", array($this, "\165\156\x73\145\x74\123\x65\x73\x73\x69\157\156"), 1, 1);
        add_shortcode("\x6d\x6f\x5f\x76\145\x72\151\x66\171\x5f\145\x6d\141\151\154", array($this, "\137\143\146\67\137\145\155\141\x69\x6c\x5f\163\150\x6f\x72\x74\x63\157\x64\x65"));
        add_shortcode("\x6d\157\137\166\145\162\151\x66\x79\x5f\x70\x68\x6f\156\x65", array($this, "\137\x63\146\67\137\x70\x68\x6f\156\145\x5f\163\x68\x6f\x72\x74\x63\x6f\x64\x65"));
        add_action("\x77\x70\137\141\x6a\x61\x78\137\x6e\157\160\x72\151\x76\x5f{$this->_generateOTPAction}", array($this, "\137\150\x61\x6e\x64\x6c\x65\x5f\143\146\x37\x5f\143\x6f\156\x74\141\x63\x74\x5f\x66\157\162\x6d"));
        add_action("\167\160\137\141\152\x61\170\137{$this->_generateOTPAction}", array($this, "\137\x68\141\156\x64\154\x65\x5f\x63\x66\67\137\143\157\x6e\x74\x61\x63\164\137\146\157\x72\x6d"));
    }
    function _handle_cf7_contact_form()
    {
        $pO = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (MoUtility::sanitizeCheck("\165\x73\145\162\137\145\155\x61\151\x6c", $pO)) {
            goto LQ9;
        }
        if (MoUtility::sanitizeCheck("\165\x73\x65\162\x5f\x70\x68\157\156\x65", $pO)) {
            goto Hq9;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto sPi;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto XYY;
        sPi:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        XYY:
        goto b_b;
        Hq9:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($pO["\165\163\145\x72\137\160\x68\x6f\x6e\145"]));
        $this->sendChallenge("\x74\x65\x73\164", '', null, trim($pO["\x75\x73\145\162\137\x70\x68\157\156\x65"]), VerificationType::PHONE);
        b_b:
        goto XgC;
        LQ9:
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\x75\x73\145\x72\137\x65\155\141\x69\x6c"]);
        $this->sendChallenge("\x74\145\x73\164", $pO["\165\163\x65\162\x5f\145\155\141\151\154"], null, $pO["\x75\x73\145\162\x5f\145\x6d\141\151\154"], VerificationType::EMAIL);
        XgC:
    }
    function validateFormPost($fM, $dy)
    {
        $dy = new WPCF7_FormTag($dy);
        $P6 = $dy->name;
        $zs = isset($_POST[$P6]) ? trim(wp_unslash(strtr((string) $_POST[$P6], "\12", "\x20"))) : '';
        if (!("\x65\155\141\151\154" == $dy->basetype && $P6 == $this->_emailKey && strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto EFq;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $zs);
        EFq:
        if (!("\x74\x65\x6c" == $dy->basetype && $P6 == $this->_phoneKey && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto R5n;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $zs);
        R5n:
        if (!("\x74\x65\170\164" == $dy->basetype && $P6 == "\x65\x6d\141\151\x6c\137\x76\x65\162\x69\146\171" || "\x74\145\x78\164" == $dy->basetype && $P6 == "\x70\150\157\156\145\137\x76\145\x72\151\x66\x79")) {
            goto ONj;
        }
        $this->checkIfVerificationCodeNotEntered($P6, $fM, $dy);
        $this->checkIfVerificationNotStarted($fM, $dy);
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto SxK;
        }
        $this->processEmail($fM, $dy);
        SxK:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto mIZ;
        }
        $this->processPhoneNumber($fM, $dy);
        mIZ:
        if (!empty($fM->get_invalid_fields())) {
            goto i_B;
        }
        if ($this->processOTPEntered($P6)) {
            goto EG0;
        }
        $fM->invalidate($dy, MoUtility::_get_invalid_otp_method());
        EG0:
        i_B:
        ONj:
        return $fM;
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $lr);
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $lr);
    }
    function processOTPEntered($P6)
    {
        $HV = $this->getVerificationType();
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto zBN;
        }
        $this->validateChallenge($HV, $P6, NULL);
        zBN:
        return SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV);
    }
    function processEmail(&$fM, $dy)
    {
        if (SessionUtils::isEmailSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto HnL;
        }
        $fM->invalidate($dy, mo_(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        HnL:
    }
    function processPhoneNumber(&$fM, $dy)
    {
        if (Sessionutils::isPhoneSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto GaM;
        }
        $fM->invalidate($dy, mo_(MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        GaM:
    }
    function checkIfVerificationNotStarted(&$fM, $dy)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto LPH;
        }
        $fM->invalidate($dy, mo_(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE)));
        LPH:
    }
    function checkIfVerificationCodeNotEntered($P6, &$fM, $dy)
    {
        if (MoUtility::sanitizeCheck($P6, $_REQUEST)) {
            goto MR9;
        }
        $fM->invalidate($dy, wpcf7_get_message("\151\x6e\x76\141\154\x69\144\137\x72\x65\161\165\151\162\x65\x64"));
        MR9:
    }
    function _cf7_email_shortcode($oP)
    {
        $kk = MoUtility::sanitizeCheck("\x6b\x65\x79", $oP);
        $DQ = MoUtility::sanitizeCheck("\142\165\x74\164\157\156\x69\x64", $oP);
        $CO = MoUtility::sanitizeCheck("\x6d\x65\163\163\141\x67\145\144\x69\166", $oP);
        $kk = $kk ? "\43" . $kk : "\151\x6e\x70\165\164\133\x6e\141\155\145\x3d\x27" . $this->_emailKey . "\47\x5d";
        $DQ = $DQ ? $DQ : "\155\x69\156\x69\157\x72\x61\x6e\x67\x65\137\157\x74\x70\137\164\157\x6b\145\x6e\137\x73\165\x62\155\151\164";
        $CO = $CO ? $CO : "\x6d\157\x5f\155\x65\163\x73\141\147\145";
        $Eo = "\x3c\144\x69\166\40\163\x74\171\x6c\x65\x3d\47\144\x69\x73\x70\154\141\171\x3a\x74\141\142\x6c\x65\x3b\164\x65\x78\x74\55\x61\154\x69\x67\x6e\72\x63\x65\x6e\x74\x65\162\x3b\x27\x3e" . "\74\x69\x6d\147\40\x73\162\x63\x3d\47" . MOV_URL . "\151\x6e\143\x6c\x75\144\x65\x73\57\x69\155\x61\147\x65\163\x2f\154\157\x61\144\x65\x72\56\147\x69\x66\x27\x3e" . "\74\x2f\x64\x69\166\76";
        $Eo = str_replace("\x22", "\x27", $Eo);
        $V1 = "\x3c\163\143\162\151\160\164\x3e" . "\152\x51\x75\x65\162\x79\x28\x64\157\x63\x75\155\x65\x6e\x74\x29\56\x72\145\141\x64\x79\50\x66\x75\x6e\x63\x74\x69\x6f\156\x28\51\173" . "\44\x6d\157\x3d\x6a\121\x75\x65\x72\171\73" . "\x24\155\157\x28\x20\x22\x23" . $DQ . "\42\40\51\56\x65\x61\143\150\50\x66\165\156\143\x74\x69\x6f\156\50\x69\x6e\x64\x65\x78\51\40\x7b" . "\x24\x6d\157\x28\x74\x68\151\163\51\56\x6f\x6e\50\x22\143\154\x69\143\x6b\42\54\40\x66\165\156\143\x74\x69\x6f\x6e\50\51\173" . "\x76\141\162\40\x74\40\75\40\x24\155\x6f\50\x74\150\x69\x73\x29\x2e\143\154\157\163\x65\163\x74\x28\42\x66\157\x72\x6d\x22\51\x3b" . "\166\141\162\40\x65\x20\x3d\40\x74\x2e\146\x69\156\x64\50\42" . $kk . "\x22\x29\x2e\x76\x61\154\50\51\x3b" . "\166\x61\162\40\x6e\40\75\40\x74\56\146\x69\156\144\x28\42\x69\x6e\160\x75\164\133\x6e\141\x6d\145\75\47\145\x6d\x61\x69\154\137\166\x65\x72\151\x66\171\x27\135\42\51\73" . "\166\141\x72\x20\x64\x20\x3d\40\164\56\x66\x69\x6e\x64\x28\x22\x23" . $CO . "\42\51\73" . "\144\x2e\145\155\160\x74\171\50\51\73" . "\x64\56\x61\x70\160\145\x6e\144\x28\x22" . $Eo . "\42\x29\73" . "\x64\x2e\x73\150\x6f\167\50\x29\73" . "\x24\155\x6f\56\141\152\141\x78\x28\x7b" . "\165\162\154\x3a\x22" . wp_ajax_url() . "\x22\54" . "\x74\171\x70\x65\x3a\x22\x50\117\123\x54\x22\x2c" . "\x64\141\164\x61\72\x7b" . "\165\x73\x65\162\x5f\145\155\x61\x69\x6c\x3a\x65\54" . "\141\143\x74\151\x6f\156\x3a\x22" . $this->_generateOTPAction . "\x22\x2c" . $this->_nonceKey . "\72\42" . wp_create_nonce($this->_nonce) . "\42" . "\x7d\54" . "\x63\162\x6f\163\x73\104\157\155\141\151\x6e\x3a\x21\x30\x2c" . "\144\x61\x74\141\124\x79\160\145\72\42\x6a\163\x6f\156\x22\54" . "\x73\x75\x63\x63\x65\163\x73\72\146\x75\156\x63\164\151\x6f\156\50\157\x29\173\x20" . "\151\x66\50\157\56\x72\145\163\165\x6c\x74\x3d\75\42\x73\165\x63\x63\x65\163\x73\x22\51\x7b" . "\144\56\x65\155\160\x74\171\x28\51\x2c" . "\144\56\141\160\160\x65\x6e\144\50\x6f\56\x6d\x65\x73\163\x61\x67\x65\51\x2c" . "\x64\x2e\x63\x73\x73\x28\x22\x62\157\162\x64\145\162\x2d\x74\x6f\160\x22\54\42\63\x70\170\40\x73\x6f\x6c\151\x64\x20\x67\162\x65\145\x6e\x22\51\54" . "\156\56\146\157\x63\165\x73\50\51" . "\175\145\x6c\163\x65\173" . "\x64\x2e\x65\155\160\164\x79\50\x29\x2c" . "\x64\56\141\x70\x70\x65\x6e\144\50\157\56\x6d\x65\163\163\x61\147\x65\x29\54" . "\144\56\x63\x73\163\x28\42\142\x6f\x72\x64\x65\162\55\164\x6f\x70\x22\54\x22\x33\160\x78\40\163\157\154\151\x64\x20\162\x65\x64\x22\51" . "\x7d" . "\x7d\54" . "\x65\162\162\157\x72\x3a\x66\x75\x6e\143\164\x69\157\x6e\50\x6f\x2c\x65\x2c\156\x29\x7b\x7d" . "\175\x29" . "\175\x29\x3b" . "\x7d\51\73" . "\x7d\51\73" . "\74\57\x73\x63\162\151\160\164\x3e";
        return $V1;
    }
    function _cf7_phone_shortcode($oP)
    {
        $ZK = MoUtility::sanitizeCheck("\153\145\171", $oP);
        $DQ = MoUtility::sanitizeCheck("\142\x75\164\x74\157\x6e\x69\x64", $oP);
        $CO = MoUtility::sanitizeCheck("\x6d\145\x73\x73\141\147\x65\x64\151\x76", $oP);
        $ZK = $ZK ? "\43" . $ZK : "\x69\x6e\160\x75\164\133\x6e\x61\x6d\x65\75\47" . $this->_phoneKey . "\x27\135";
        $DQ = $DQ ? $DQ : "\x6d\151\156\151\x6f\162\x61\x6e\x67\x65\x5f\157\x74\160\x5f\164\x6f\153\145\x6e\x5f\163\x75\x62\x6d\x69\164";
        $CO = $CO ? $CO : "\x6d\157\137\x6d\145\163\x73\141\147\x65";
        $Eo = "\x3c\144\151\x76\40\x73\x74\171\x6c\145\x3d\47\x64\151\163\160\154\x61\171\x3a\164\141\142\x6c\145\x3b\164\145\x78\x74\x2d\x61\x6c\151\x67\x6e\x3a\143\x65\x6e\164\145\x72\x3b\47\76" . "\x3c\x69\155\147\x20\x73\162\x63\75\x27" . MOV_URL . "\151\156\143\154\x75\x64\145\163\x2f\151\x6d\x61\147\145\x73\57\154\157\x61\x64\x65\x72\56\147\x69\146\x27\76" . "\x3c\57\x64\151\166\x3e";
        $Eo = str_replace("\42", "\47", $Eo);
        $V1 = "\x3c\x73\x63\x72\151\x70\x74\x3e" . "\x6a\121\x75\x65\x72\171\50\144\x6f\x63\x75\155\145\x6e\164\51\x2e\x72\145\141\144\171\x28\146\x75\156\x63\x74\x69\x6f\x6e\50\x29\173" . "\44\155\x6f\75\152\121\165\x65\162\x79\73\x24\155\x6f\x28\40\42\x23" . $DQ . "\42\x20\51\56\145\141\x63\x68\50\x66\x75\156\x63\164\x69\x6f\x6e\x28\151\x6e\144\145\x78\x29\x20\x7b" . "\x24\155\x6f\50\x74\150\x69\163\51\x2e\157\x6e\x28\42\x63\x6c\151\x63\x6b\42\x2c\x20\146\165\x6e\x63\164\151\x6f\x6e\50\x29\x7b" . "\x76\141\x72\x20\x74\40\x3d\x20\44\x6d\x6f\50\164\x68\x69\x73\51\x2e\x63\154\157\163\145\x73\x74\50\42\x66\x6f\162\155\42\51\73" . "\x76\141\162\40\145\40\75\x20\x74\x2e\x66\x69\x6e\x64\50\x22" . $ZK . "\42\51\56\166\x61\x6c\x28\x29\73" . "\166\141\x72\x20\156\x20\x3d\x20\164\x2e\146\151\156\144\50\42\x69\x6e\160\165\x74\133\156\x61\155\x65\75\47\x70\x68\x6f\156\x65\x5f\166\145\162\151\x66\171\x27\135\x22\x29\x3b" . "\x76\x61\162\x20\144\40\x3d\40\164\56\x66\x69\x6e\x64\50\42\43" . $CO . "\42\51\x3b" . "\144\x2e\x65\x6d\160\164\171\x28\x29\73" . "\144\56\x61\x70\x70\145\156\x64\50\42" . $Eo . "\x22\x29\73" . "\144\x2e\163\150\x6f\167\50\x29\73" . "\44\155\x6f\x2e\x61\x6a\x61\x78\50\173" . "\x75\162\x6c\x3a\x22" . wp_ajax_url() . "\42\54" . "\164\x79\x70\145\x3a\x22\x50\117\123\124\42\54" . "\x64\141\x74\x61\72\173" . "\x75\163\145\162\x5f\160\150\x6f\x6e\145\x3a\145\x2c" . "\141\143\164\151\157\156\72\42" . $this->_generateOTPAction . "\x22\x2c" . $this->_nonceKey . "\x3a\42" . wp_create_nonce($this->_nonce) . "\42" . "\175\54" . "\x63\x72\x6f\163\x73\x44\157\155\141\x69\156\72\x21\60\54" . "\144\141\164\x61\x54\x79\x70\145\x3a\42\x6a\163\157\x6e\42\54" . "\163\x75\143\143\145\163\163\x3a\x66\x75\x6e\143\164\151\157\x6e\50\157\51\173\x20" . "\x69\x66\50\157\x2e\x72\x65\x73\165\x6c\164\x3d\x3d\42\163\x75\143\143\145\163\x73\x22\x29\x7b" . "\x64\56\x65\155\160\x74\x79\50\51\54" . "\144\x2e\x61\160\160\145\156\144\50\x6f\x2e\155\x65\x73\x73\141\x67\145\x29\54" . "\x64\56\x63\x73\x73\x28\x22\142\157\x72\x64\145\162\55\164\157\x70\x22\54\42\x33\x70\x78\40\x73\157\154\151\144\40\x67\x72\x65\x65\156\x22\x29\x2c" . "\x6e\56\146\157\143\x75\163\50\51" . "\x7d\x65\154\163\145\173" . "\144\x2e\x65\x6d\160\x74\x79\x28\x29\54" . "\144\x2e\141\x70\160\x65\x6e\x64\50\x6f\56\x6d\x65\x73\163\141\147\145\x29\x2c" . "\x64\x2e\x63\x73\x73\50\x22\142\157\x72\x64\145\x72\55\x74\x6f\x70\42\54\x22\63\160\170\x20\x73\x6f\x6c\x69\x64\40\162\x65\144\42\51" . "\x7d" . "\175\54" . "\145\x72\162\157\162\x3a\x66\x75\x6e\x63\164\151\157\156\x28\x6f\x2c\145\54\x6e\x29\x7b\175" . "\x7d\x29" . "\175\51\x3b" . "\x7d\x29\73" . "\175\x29\73" . "\x3c\57\x73\143\162\151\x70\164\76";
        return $V1;
    }
    public function unsetSession($fM)
    {
        $this->unsetOTPSessionVariables();
        return $fM;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto aLD;
        }
        $zX = array_merge($zX, $this->_phoneFormId);
        aLD:
        return $zX;
    }
    private function emailKeyValidationCheck()
    {
        if (!($this->_otpType === $this->_typeEmailTag && MoUtility::isBlank($this->_emailKey))) {
            goto SBh;
        }
        do_action("\x6d\157\137\162\145\147\151\163\x74\x72\141\164\x69\157\156\137\163\x68\157\167\137\155\x65\163\163\141\x67\x65", MoMessages::showMessage(BaseMessages::CF7_PROVIDE_EMAIL_KEY), MoConstants::ERROR);
        return false;
        SBh:
        return true;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto yCf;
        }
        return;
        yCf:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\146\x37\137\x63\x6f\x6e\164\x61\143\x74\137\x65\156\141\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x63\x66\67\x5f\143\157\x6e\x74\x61\x63\x74\x5f\x74\x79\x70\145");
        $this->_emailKey = $this->sanitizeFormPOST("\x63\x66\x37\137\x65\155\x61\151\x6c\x5f\146\151\x65\x6c\144\137\x6b\x65\x79");
        if (!($this->basicValidationCheck(BaseMessages::CF7_CHOOSE) && $this->emailKeyValidationCheck())) {
            goto xAG;
        }
        update_mo_option("\143\146\x37\x5f\x63\x6f\x6e\x74\x61\143\x74\x5f\x65\x6e\141\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\x63\x66\x37\137\x63\x6f\156\164\x61\x63\164\x5f\164\171\x70\x65", $this->_otpType);
        update_mo_option("\x63\146\67\x5f\145\x6d\141\151\x6c\137\x6b\x65\x79", $this->_emailKey);
        xAG:
    }
}
