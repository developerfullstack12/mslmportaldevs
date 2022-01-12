<?php


namespace OTP\Handler\Forms;

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
use WP_Comment;
class WordPressComments extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPCOMMENT;
        $this->_phoneFormId = "\x69\x6e\160\165\164\x5b\x6e\141\155\145\x3d\x70\x68\x6f\x6e\x65\x5d";
        $this->_formKey = "\x57\x50\103\x4f\115\x4d\x45\116\x54";
        $this->_typePhoneTag = "\155\157\x5f\167\160\143\x6f\155\155\145\x6e\x74\137\x70\150\x6f\x6e\145\137\x65\x6e\x61\x62\154\145";
        $this->_typeEmailTag = "\155\157\137\x77\160\x63\x6f\x6d\155\x65\156\x74\x5f\x65\155\x61\151\154\x5f\x65\x6e\141\x62\x6c\x65";
        $this->_formName = mo_("\127\157\x72\144\120\162\145\x73\163\x20\103\x6f\x6d\155\145\156\164\40\x46\157\162\155");
        $this->_isFormEnabled = get_mo_option("\167\x70\143\157\x6d\x6d\x65\x6e\164\137\145\x6e\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::WP_COMMENT_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x70\143\157\155\155\145\156\164\137\x65\x6e\x61\142\x6c\x65\137\x74\x79\x70\x65");
        $this->_byPassLogin = get_mo_option("\167\x70\143\x6f\x6d\x6d\x65\156\164\x5f\145\x6e\x61\x62\x6c\145\x5f\x66\157\x72\137\154\157\x67\x67\145\144\151\156\137\165\x73\x65\x72\x73");
        if (!$this->_byPassLogin) {
            goto HQ;
        }
        add_filter("\x63\x6f\155\155\x65\156\x74\x5f\146\x6f\x72\x6d\137\144\145\146\141\x75\x6c\164\137\x66\151\x65\x6c\x64\163", array($this, "\x5f\141\x64\x64\x5f\143\x75\163\x74\157\x6d\x5f\x66\151\x65\x6c\x64\x73"), 99, 1);
        goto nw;
        HQ:
        add_action("\143\x6f\x6d\155\145\156\164\137\146\x6f\162\155\x5f\154\157\x67\x67\145\144\x5f\151\x6e\137\141\146\x74\x65\162", array($this, "\137\141\x64\144\x5f\x73\x63\x72\151\160\164\163\137\141\x6e\144\x5f\x61\x64\144\151\164\x69\x6f\x6e\x61\154\137\x66\151\145\154\x64\163"), 1);
        add_action("\143\x6f\x6d\x6d\x65\x6e\x74\x5f\146\157\162\x6d\x5f\x61\x66\164\x65\162\x5f\146\151\145\154\x64\163", array($this, "\x5f\x61\x64\x64\137\x73\x63\x72\151\160\x74\163\x5f\141\x6e\x64\137\141\144\x64\151\164\151\157\156\x61\x6c\137\146\151\x65\154\x64\x73"), 1);
        nw:
        add_filter("\160\x72\145\160\x72\157\143\x65\163\x73\x5f\x63\x6f\x6d\155\x65\156\164", array($this, "\x76\x65\x72\x69\146\171\x5f\143\157\155\155\x65\x6e\164\x5f\x6d\145\x74\141\x5f\x64\x61\164\x61"), 1, 1);
        add_action("\143\157\155\x6d\145\x6e\x74\137\160\x6f\x73\164", array($this, "\x73\141\x76\x65\x5f\143\157\155\x6d\145\x6e\164\137\155\145\164\x61\137\x64\141\x74\x61"), 1, 1);
        add_action("\141\x64\x64\137\155\145\164\x61\x5f\142\157\170\145\x73\x5f\x63\x6f\155\x6d\x65\156\164", array($this, "\145\170\164\145\x6e\144\x5f\x63\x6f\155\155\x65\156\x74\137\141\144\x64\137\155\x65\164\x61\x5f\142\x6f\x78"), 1, 1);
        add_action("\145\144\151\x74\x5f\x63\157\155\x6d\145\x6e\164", array($this, "\x65\170\x74\x65\156\x64\137\x63\157\155\x6d\145\x6e\164\137\145\144\x69\164\x5f\x6d\x65\x74\x61\146\151\145\154\144\163"), 1, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\x69\x6f\x6e", $_GET)) {
            goto JV;
        }
        return;
        JV:
        switch (trim($_GET["\157\160\x74\x69\x6f\156"])) {
            case "\155\157\x2d\x63\157\x6d\155\x65\x6e\164\x73\55\x76\x65\x72\x69\x66\x79":
                $this->_startOTPVerificationProcess($_POST);
                goto nW;
        }
        EQ:
        nW:
    }
    function _startOTPVerificationProcess($fy)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && MoUtility::sanitizeCheck("\165\x73\x65\162\137\145\x6d\x61\x69\x6c", $fy)) {
            goto nc;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && MoUtility::sanitizeCheck("\x75\x73\145\162\137\160\150\x6f\x6e\145", $fy)) {
            goto DB;
        }
        $SF = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? MoMessages::showMessage(MoMessages::ENTER_PHONE) : MoMessages::showMessage(MoMessages::ENTER_EMAIL);
        wp_send_json(MoUtility::createJson($SF, MoConstants::ERROR_JSON_TYPE));
        goto jz;
        DB:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($fy["\165\x73\145\x72\x5f\x70\150\x6f\156\x65"]));
        $this->sendChallenge('', '', null, trim($fy["\165\163\x65\162\137\160\150\x6f\x6e\145"]), VerificationType::PHONE);
        jz:
        goto Lo;
        nc:
        SessionUtils::addEmailVerified($this->_formSessionVar, $fy["\165\163\145\162\137\145\x6d\x61\151\154"]);
        $this->sendChallenge('', $fy["\x75\163\145\x72\137\145\155\x61\x69\x6c"], null, $fy["\x75\163\x65\162\137\x65\x6d\x61\x69\154"], VerificationType::EMAIL);
        Lo:
    }
    function extend_comment_edit_metafields($N7)
    {
        if (!(!isset($_POST["\145\170\x74\x65\x6e\144\x5f\143\157\x6d\155\145\156\164\x5f\165\160\144\x61\164\145"]) || !wp_verify_nonce($_POST["\x65\170\164\x65\x6e\x64\x5f\143\x6f\155\155\x65\x6e\164\x5f\x75\160\144\x61\164\145"], "\x65\x78\x74\145\156\144\137\143\x6f\x6d\155\145\156\x74\x5f\x75\x70\x64\x61\164\145"))) {
            goto q8;
        }
        return;
        q8:
        if (isset($_POST["\160\x68\x6f\156\145"]) && $_POST["\160\150\x6f\156\x65"] != '') {
            goto Dd;
        }
        delete_comment_meta($N7, "\x70\x68\x6f\x6e\x65");
        goto J9;
        Dd:
        $fk = wp_filter_nohtml_kses($_POST["\x70\150\x6f\156\145"]);
        update_comment_meta($N7, "\x70\150\x6f\x6e\145", $fk);
        J9:
    }
    function extend_comment_add_meta_box()
    {
        add_meta_box("\164\151\164\x6c\145", mo_("\105\x78\x74\162\x61\40\106\151\x65\x6c\144\x73"), array($this, "\x65\x78\164\145\156\x64\137\x63\157\x6d\155\145\x6e\164\137\155\x65\x74\141\x5f\x62\x6f\x78"), "\x63\157\155\155\145\156\164", "\x6e\x6f\x72\x6d\x61\154", "\x68\151\x67\x68");
    }
    function extend_comment_meta_box($uN)
    {
        $fk = get_comment_meta($uN->comment_ID, "\x70\x68\x6f\x6e\145", true);
        wp_nonce_field("\145\170\164\145\x6e\x64\x5f\x63\157\x6d\x6d\145\x6e\164\x5f\x75\160\x64\x61\x74\145", "\145\x78\x74\x65\x6e\x64\137\143\157\x6d\155\x65\156\164\137\x75\x70\144\x61\164\145", false);
        echo "\x3c\164\141\x62\154\x65\40\x63\154\x61\x73\163\75\x22\146\157\x72\155\55\x74\x61\x62\154\145\x20\x65\x64\151\164\143\157\x6d\x6d\x65\x6e\x74\x22\x3e\15\xa\40\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\40\x20\40\40\x3c\x74\142\157\x64\x79\x3e\15\xa\x20\40\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\40\40\x20\74\x74\162\x3e\xd\xa\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x20\40\40\x20\40\x20\x20\40\40\x3c\x74\144\40\x63\154\x61\163\x73\x3d\42\x66\x69\162\163\x74\42\x3e\74\154\x61\142\145\154\x20\x66\157\x72\x3d\42\x70\150\x6f\x6e\x65\x22\x3e" . mo_("\x50\x68\x6f\x6e\x65") . "\72\x3c\x2f\x6c\141\x62\145\x6c\76\74\x2f\x74\x64\x3e\15\12\x20\40\40\x20\x20\40\x20\40\x20\40\40\x20\x20\40\40\40\40\x20\x20\x20\x3c\x74\x64\x3e\74\x69\x6e\160\165\164\40\x74\x79\x70\145\75\42\164\x65\x78\164\x22\x20\156\x61\x6d\x65\x3d\x22\160\x68\157\x6e\145\42\x20\x73\x69\172\145\75\x22\63\60\42\40\166\x61\x6c\165\145\x3d\x22" . esc_attr($fk) . "\42\40\x69\x64\75\42\x70\x68\x6f\156\x65\42\76\x3c\x2f\164\x64\x3e\xd\xa\40\40\x20\x20\x20\40\x20\x20\40\40\x20\40\x20\x20\40\x20\x3c\x2f\164\162\76\15\xa\x20\x20\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\x20\40\x20\x3c\57\x74\142\157\x64\x79\76\15\xa\40\40\40\40\40\x20\40\40\x20\40\40\x20\74\57\164\141\x62\154\x65\x3e";
    }
    function verify_comment_meta_data($aR)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto yO;
        }
        return $aR;
        yO:
        if (!(!isset($_POST["\160\150\157\x6e\x65"]) && strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto V2;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_PHONE_ENTER));
        V2:
        if (isset($_POST["\x76\x65\162\x69\146\x79\157\x74\160"])) {
            goto lf;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_VERIFY_ENTER));
        lf:
        $HV = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Qu;
        }
        wp_die(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        Qu:
        if (!($HV === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\145\155\x61\x69\x6c"]))) {
            goto Fb;
        }
        wp_die(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        Fb:
        if (!($HV === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x70\150\157\156\145"]))) {
            goto ZJ;
        }
        wp_die(MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        ZJ:
        $this->validateChallenge($HV, NULL, $_POST["\x76\x65\x72\151\x66\171\x6f\x74\x70"]);
        return $aR;
    }
    function _add_scripts_and_additional_fields()
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto sH;
        }
        echo $this->_getFieldHTML("\x65\155\x61\x69\x6c");
        sH:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto VI;
        }
        echo $this->_getFieldHTML("\x70\150\157\156\x65");
        VI:
        echo $this->_getFieldHTML("\166\x65\x72\151\146\171\x6f\x74\160");
    }
    function _add_custom_fields($KB)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto cm;
        }
        $KB["\145\155\x61\x69\x6c"] = $this->_getFieldHTML("\145\x6d\141\x69\x6c");
        cm:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto xO;
        }
        $KB["\160\x68\157\156\145"] = $this->_getFieldHTML("\x70\x68\x6f\156\x65");
        xO:
        $KB["\x76\x65\x72\151\x66\x79\157\x74\160"] = $this->_getFieldHTML("\x76\145\x72\x69\146\171\157\164\x70");
        return $KB;
    }
    function _getFieldHTML($fR)
    {
        $s8 = array("\x65\155\141\x69\x6c" => (!is_user_logged_in() && !$this->_byPassLogin ? '' : "\74\160\x20\x63\x6c\x61\x73\163\75\42\143\x6f\155\x6d\145\156\164\55\146\x6f\162\155\55\145\x6d\x61\x69\154\x22\76" . "\74\154\x61\142\145\x6c\x20\146\x6f\162\75\42\145\x6d\x61\x69\x6c\x22\76" . mo_("\x45\x6d\141\151\x6c\40\52") . "\74\x2f\x6c\x61\142\x65\154\76" . "\74\x69\x6e\x70\165\x74\x20\x69\144\75\x22\x65\155\x61\x69\x6c\x22\40\x6e\x61\155\145\75\x22\x65\155\141\151\x6c\x22\40\x74\171\160\145\75\42\x74\x65\x78\x74\x22\40\163\x69\x7a\145\x3d\42\63\x30\42\40\40\164\x61\x62\x69\156\x64\145\x78\x3d\x22\x34\42\40\x2f\76" . "\74\57\160\76") . $this->get_otp_html_content("\x65\155\x61\x69\x6c"), "\x70\150\157\x6e\x65" => "\x3c\160\x20\x63\154\x61\x73\163\x3d\42\x63\157\x6d\155\145\156\x74\x2d\146\157\x72\x6d\55\145\155\141\151\x6c\42\76" . "\74\154\x61\142\x65\154\x20\x66\x6f\162\75\x22\160\x68\157\156\145\x22\76" . mo_("\x50\x68\x6f\x6e\x65\x20\x2a") . "\x3c\57\154\141\x62\x65\x6c\x3e" . "\x3c\151\x6e\x70\165\x74\x20\151\144\x3d\x22\160\x68\157\x6e\145\x22\40\156\x61\155\145\x3d\x22\160\150\x6f\x6e\145\42\40\164\171\x70\x65\x3d\x22\x74\x65\170\164\x22\40\163\x69\x7a\145\x3d\x22\x33\60\x22\x20\x20\x74\x61\x62\x69\156\x64\145\x78\75\x22\x34\x22\40\x2f\x3e" . "\x3c\x2f\x70\x3e" . $this->get_otp_html_content("\x70\150\157\x6e\145"), "\166\145\162\151\x66\171\157\164\160" => "\74\x70\x20\x63\x6c\141\x73\163\x3d\x22\x63\x6f\155\x6d\x65\156\164\x2d\146\157\162\x6d\55\145\x6d\x61\x69\154\42\x3e" . "\x3c\154\141\142\145\x6c\x20\146\157\x72\75\42\x76\x65\162\x69\146\171\x6f\164\x70\x22\76" . mo_("\126\x65\x72\151\x66\x69\143\x61\164\151\x6f\x6e\40\103\157\x64\x65") . "\x3c\57\x6c\x61\142\x65\154\76" . "\74\x69\x6e\160\x75\x74\40\151\x64\75\x22\x76\x65\x72\x69\146\x79\x6f\x74\x70\x22\40\x6e\x61\155\145\75\x22\x76\x65\x72\151\x66\171\157\164\160\42\x20\164\x79\x70\x65\75\42\164\x65\170\164\42\x20\x73\x69\x7a\x65\75\42\63\60\42\x20\40\x74\x61\x62\x69\x6e\x64\145\x78\75\42\64\x22\x20\57\x3e" . "\x3c\57\160\x3e\x3c\x62\x72\76");
        return $s8[$fR];
    }
    function get_otp_html_content($D5)
    {
        $Eo = "\x3c\144\151\x76\x20\163\x74\171\x6c\145\x3d\x27\144\151\163\160\154\x61\171\72\x74\x61\142\x6c\145\x3b\164\145\x78\164\55\x61\x6c\151\x67\x6e\x3a\x63\x65\156\164\145\162\73\x27\76\74\151\x6d\147\x20\163\162\x63\x3d\x27" . MOV_URL . "\151\156\143\x6c\x75\x64\x65\163\57\151\155\x61\x67\x65\x73\x2f\x6c\157\141\x64\x65\162\x2e\147\151\x66\47\76\x3c\57\144\x69\166\x3e";
        $V1 = "\x3c\144\x69\x76\40\x73\164\x79\x6c\x65\75\x22\155\x61\x72\x67\151\x6e\x2d\x62\157\164\164\x6f\x6d\x3a\x33\x25\42\x3e\x3c\x69\x6e\x70\165\164\x20\x74\x79\x70\x65\75\42\142\165\164\164\x6f\156\x22\x20\x63\x6c\x61\163\163\75\x22\142\x75\164\164\x6f\156\x20\x61\x6c\164\x22\x20\x73\164\171\x6c\x65\75\42\x77\151\144\x74\x68\72\61\60\60\x25\x22\x20\151\144\75\42\155\151\x6e\151\157\x72\x61\156\147\145\137\157\164\x70\x5f\x74\x6f\153\x65\x6e\137\x73\x75\x62\x6d\x69\x74\x22";
        $V1 .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\164\151\x74\x6c\x65\75\42\x50\x6c\x65\x61\x73\x65\40\x45\x6e\x74\x65\162\40\x61\40\x70\x68\157\x6e\145\x20\156\165\x6d\142\x65\162\x20\164\157\x20\145\x6e\x61\x62\x6c\145\40\164\150\x69\163\56\x22\40" : "\x74\151\164\154\x65\x3d\x22\x50\154\145\141\x73\x65\40\105\x6e\x74\145\162\40\x61\40\x65\155\141\x69\x6c\40\156\165\155\142\x65\x72\x20\164\x6f\x20\145\x6e\141\x62\154\145\40\x74\150\x69\x73\x2e\42\40";
        $V1 .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x76\141\x6c\165\x65\75\x22\x43\x6c\x69\x63\153\40\150\145\x72\x65\x20\164\x6f\x20\166\145\162\x69\146\x79\x20\171\157\x75\x72\x20\x50\150\157\x6e\x65\42\76" : "\166\x61\154\x75\x65\x3d\x22\x43\154\x69\x63\x6b\x20\x68\145\x72\145\40\x74\x6f\40\166\145\x72\x69\x66\171\x20\x79\157\165\x72\x20\x45\x6d\x61\151\154\x22\x3e";
        $V1 .= "\x3c\x64\151\166\x20\151\x64\75\42\155\x6f\137\155\145\163\x73\x61\147\145\x22\x20\x68\x69\x64\144\145\x6e\75\42\42\40\x73\x74\x79\154\x65\75\x22\142\x61\x63\153\x67\162\x6f\x75\x6e\144\55\x63\157\x6c\157\162\72\40\x23\146\67\x66\x36\x66\67\x3b\x70\x61\x64\x64\151\x6e\x67\x3a\x20\x31\x65\155\x20\x32\145\x6d\x20\x31\145\x6d\x20\x33\x2e\65\145\x6d\73\42\x3e\74\57\144\x69\166\x3e\x3c\x2f\x64\151\166\76";
        $V1 .= "\74\163\143\162\x69\x70\164\x3e\152\x51\x75\145\162\x79\50\144\x6f\x63\165\x6d\145\156\164\51\56\x72\x65\141\x64\171\50\x66\x75\156\143\x74\x69\157\x6e\50\51\x7b\x24\x6d\157\x3d\152\121\165\145\x72\x79\x3b\44\155\157\x28\x22\x23\x6d\151\156\151\x6f\162\x61\x6e\x67\x65\137\157\x74\x70\x5f\164\157\153\145\156\x5f\163\165\142\155\151\164\42\51\x2e\143\154\x69\x63\153\50\x66\165\156\x63\x74\151\x6f\156\50\157\51\173";
        $V1 .= "\166\x61\x72\40\145\x3d\44\155\x6f\x28\x22\x69\156\160\165\x74\x5b\x6e\x61\155\145\75" . $D5 . "\x5d\x22\x29\56\166\x61\154\50\51\73\x20\44\155\x6f\50\42\43\155\x6f\137\x6d\145\x73\x73\x61\147\x65\x22\51\56\x65\155\x70\x74\171\x28\x29\54\x24\x6d\x6f\50\x22\43\155\x6f\137\155\x65\x73\x73\141\x67\145\42\51\x2e\x61\x70\160\x65\156\x64\x28\x22" . $Eo . "\42\51\x2c";
        $V1 .= "\44\155\157\x28\x22\x23\x6d\157\137\155\145\163\x73\141\147\x65\42\51\56\163\150\x6f\x77\x28\51\x2c\x24\155\157\x2e\141\152\x61\170\x28\173\165\x72\154\x3a\x22" . site_url() . "\x2f\x3f\157\160\x74\x69\x6f\x6e\75\155\x6f\55\x63\x6f\155\x6d\x65\156\164\x73\55\x76\145\x72\151\x66\171\42\x2c\164\x79\160\145\x3a\42\120\117\x53\x54\x22\x2c";
        $V1 .= "\144\141\x74\x61\72\173\x75\163\x65\x72\137\160\x68\x6f\x6e\145\72\145\54\x75\163\145\x72\137\145\x6d\x61\151\154\x3a\x65\175\x2c\143\x72\157\x73\163\104\157\155\141\x69\x6e\x3a\x21\x30\54\144\x61\x74\x61\124\171\160\145\x3a\x22\x6a\x73\157\156\x22\54\x73\165\x63\x63\x65\x73\x73\72\x66\x75\x6e\143\x74\151\157\156\x28\x6f\x29\173\40\151\x66\50\x6f\x2e\162\x65\163\x75\x6c\164\75\x3d\x3d\42\x73\x75\143\x63\x65\x73\163\x22\51\x7b";
        $V1 .= "\x24\155\157\50\x22\x23\155\157\x5f\x6d\145\x73\163\x61\147\x65\x22\x29\x2e\145\x6d\x70\164\171\x28\x29\54\44\155\x6f\x28\42\43\155\157\137\155\145\x73\163\x61\x67\145\x22\x29\56\141\160\x70\x65\x6e\144\50\x6f\x2e\x6d\145\x73\x73\141\x67\145\51\54\x24\x6d\157\x28\42\43\x6d\157\137\x6d\x65\x73\x73\x61\147\145\42\x29\56\143\x73\x73\x28\x22\x62\157\x72\x64\145\x72\x2d\164\157\160\x22\x2c\42\63\x70\x78\x20\163\157\x6c\x69\144\x20\147\162\145\145\x6e\x22\x29\54";
        $V1 .= "\x24\155\157\x28\x22\151\156\160\165\164\x5b\x6e\141\x6d\x65\75\x65\155\x61\151\x6c\137\166\145\162\151\x66\171\x5d\x22\x29\56\x66\157\x63\165\x73\x28\x29\175\x65\x6c\163\145\x7b\44\155\x6f\x28\x22\x23\x6d\x6f\137\x6d\x65\163\x73\141\147\145\42\x29\x2e\x65\x6d\160\164\171\x28\x29\54\44\155\x6f\50\42\x23\x6d\x6f\137\155\x65\x73\x73\x61\x67\x65\42\51\56\141\160\160\145\156\x64\x28\157\56\155\x65\163\x73\141\x67\x65\x29\x2c";
        $V1 .= "\44\x6d\157\50\42\x23\x6d\157\137\155\145\163\x73\141\x67\x65\42\x29\x2e\143\163\x73\50\x22\142\x6f\x72\x64\145\162\55\x74\157\160\42\54\42\x33\160\170\x20\x73\x6f\154\x69\144\40\x72\145\144\42\x29\54\x24\155\x6f\x28\x22\151\x6e\160\x75\x74\x5b\x6e\141\155\x65\x3d\160\x68\157\x6e\x65\137\x76\x65\x72\x69\146\x79\x5d\x22\51\x2e\146\x6f\x63\165\x73\50\51\x7d\40\x3b\175\x2c";
        $V1 .= "\x65\162\x72\157\162\72\146\165\156\143\164\x69\157\156\x28\x6f\54\x65\x2c\x6e\51\x7b\x7d\x7d\51\175\51\73\x7d\x29\73\74\x2f\x73\143\x72\151\160\x74\x3e";
        return $V1;
    }
    function save_comment_meta_data($N7)
    {
        if (!(isset($_POST["\160\x68\157\156\145"]) && $_POST["\x70\x68\157\156\x65"] != '')) {
            goto pc;
        }
        $fk = wp_filter_nohtml_kses($_POST["\160\150\157\x6e\145"]);
        add_comment_meta($N7, "\x70\x68\157\156\145", $fk);
        pc:
    }
    function handle_failed_verification($wB, $CG, $J9, $lr)
    {
        wp_die(MoUtility::_get_invalid_otp_method());
    }
    function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($zX)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto Qw;
        }
        array_push($zX, $this->_phoneFormId);
        Qw:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto rH;
        }
        return;
        rH:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x70\x63\157\x6d\155\145\156\164\x5f\x65\x6e\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\160\x63\x6f\x6d\155\x65\x6e\x74\137\145\x6e\x61\x62\154\x65\137\x74\x79\160\145");
        $this->_byPassLogin = $this->sanitizeFormPOST("\167\160\143\x6f\x6d\x6d\145\156\164\137\x65\x6e\141\x62\x6c\145\x5f\x66\x6f\162\x5f\154\x6f\147\147\x65\x64\151\156\x5f\x75\163\x65\x72\163");
        update_mo_option("\167\x70\x63\x6f\155\155\x65\x6e\x74\x5f\x65\156\141\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\167\x70\143\157\x6d\155\x65\156\x74\x5f\145\x6e\141\142\154\x65\137\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\167\160\143\x6f\x6d\155\x65\156\164\137\145\156\141\x62\154\x65\137\x66\157\162\x5f\x6c\x6f\x67\147\145\144\x69\156\x5f\x75\163\x65\162\x73", $this->_byPassLogin);
    }
}
