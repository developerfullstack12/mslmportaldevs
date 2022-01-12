<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UltimateProRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::ULTIMATE_PRO;
        $this->_phoneFormId = "\151\156\x70\165\164\x5b\x6e\x61\x6d\145\x3d\x70\x68\x6f\156\x65\x5d";
        $this->_formKey = "\x55\x4c\x54\111\x4d\x41\x54\x45\x5f\115\x45\x4d\x5f\120\122\117";
        $this->_typePhoneTag = "\x6d\157\137\x75\154\x74\x69\x70\162\157\x5f\x70\150\157\156\x65\x5f\x65\x6e\141\142\154\145";
        $this->_typeEmailTag = "\155\x6f\137\x75\x6c\x74\151\160\162\157\x5f\x65\155\x61\x69\x6c\x5f\x65\156\x61\x62\154\x65";
        $this->_formName = mo_("\125\154\164\x69\x6d\x61\164\x65\40\x4d\x65\x6d\142\x65\x72\163\x68\x69\160\40\x50\x72\x6f\40\x46\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\165\x6c\164\151\x70\x72\x6f\137\145\156\x61\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::UM_PRO_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\x6c\164\x69\x70\162\157\137\164\x79\160\x65");
        add_action("\x77\x70\x5f\x61\152\x61\x78\137\156\157\160\x72\x69\166\137\151\x68\143\137\143\x68\x65\143\x6b\x5f\162\x65\x67\x5f\x66\151\145\x6c\144\137\x61\x6a\x61\170", array($this, "\x5f\165\154\x74\151\160\x72\x6f\137\150\141\156\x64\154\x65\x5f\163\165\142\x6d\151\164"), 1);
        add_action("\167\160\137\x61\x6a\141\x78\x5f\x69\150\143\137\x63\150\x65\x63\x6b\x5f\x72\145\147\x5f\146\151\145\x6c\144\137\x61\152\141\x78", array($this, "\x5f\165\154\x74\x69\160\x72\x6f\x5f\150\141\x6e\144\x6c\145\137\x73\x75\142\155\x69\x74"), 1);
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto ZlQ;
        }
        add_shortcode("\x6d\157\137\160\x68\x6f\156\x65", array($this, "\x5f\160\150\x6f\x6e\145\137\163\150\x6f\162\x74\x63\x6f\x64\145"));
        ZlQ:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto Rx0;
        }
        add_shortcode("\x6d\157\137\145\155\x61\151\x6c", array($this, "\x5f\x65\x6d\x61\151\154\137\x73\150\157\162\x74\x63\x6f\144\145"));
        Rx0:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\151\x6f\156", $_GET)) {
            goto Vom;
        }
        return;
        Vom:
        switch (trim($_GET["\x6f\x70\x74\151\157\x6e"])) {
            case "\x6d\151\x6e\x69\x6f\162\141\x6e\x67\x65\55\x75\x6c\x74\151":
                $this->_handle_ulti_form($_POST);
                goto oAT;
        }
        XTl:
        oAT:
    }
    function _ultipro_handle_submit()
    {
        $RF = array("\x70\x68\x6f\156\x65", "\x75\x73\x65\x72\137\x65\x6d\141\x69\x6c", "\x76\x61\x6c\151\144\141\164\145");
        $M0 = ihc_return_meta_arr("\x72\145\x67\151\163\x74\145\x72\x2d\155\x73\147");
        if (isset($_REQUEST["\164\171\160\x65"]) && isset($_REQUEST["\x76\x61\x6c\x75\145"])) {
            goto L6w;
        }
        if (!isset($_REQUEST["\146\151\x65\154\x64\163\137\157\x62\152"])) {
            goto G9A;
        }
        $IV = $_REQUEST["\146\151\x65\154\144\163\x5f\x6f\x62\x6a"];
        foreach ($IV as $wX => $pT) {
            if (in_array($pT["\x74\171\160\x65"], $RF)) {
                goto qqn;
            }
            $P3[] = array("\164\171\x70\145" => $pT["\164\x79\160\145"], "\166\x61\x6c\165\x65" => ihc_check_value_field($pT["\x74\x79\x70\145"], $pT["\x76\141\154\165\x65"], $pT["\x73\145\143\157\x6e\144\x5f\x76\141\x6c\x75\x65"], $M0));
            goto Bny;
            qqn:
            $P3[] = $this->validate_umpro_submitted_value($pT["\x74\171\x70\x65"], $pT["\x76\141\154\165\145"], $pT["\163\x65\143\157\156\144\x5f\166\141\154\165\x65"], $M0);
            Bny:
            Ljq:
        }
        pgD:
        echo json_encode($P3);
        G9A:
        goto CMU;
        L6w:
        echo ihc_check_value_field($_REQUEST["\x74\x79\160\145"], $_REQUEST["\x76\141\x6c\x75\x65"], $_REQUEST["\x73\x65\x63\x6f\x6e\144\x5f\x76\x61\x6c\165\145"], $M0);
        CMU:
        die;
    }
    function _phone_shortcode()
    {
        $Eo = "\74\144\x69\x76\x20\163\164\171\x6c\x65\75\47\144\151\x73\x70\x6c\x61\171\72\164\x61\x62\154\x65\x3b\164\145\x78\x74\x2d\x61\154\x69\147\156\x3a\x63\x65\156\164\x65\x72\x3b\x27\76\74\151\x6d\147\40\x73\x72\x63\75\x27" . MOV_URL . "\151\156\x63\154\x75\x64\x65\x73\57\151\x6d\x61\147\x65\x73\x2f\154\157\141\144\x65\162\56\147\x69\146\x27\76\74\57\x64\151\x76\x3e";
        $Ga = "\74\144\151\x76\x20\163\164\x79\154\145\x3d\47\x6d\x61\162\x67\151\x6e\55\x74\157\160\x3a\40\x32\45\x3b\x27\76\x3c\142\165\x74\164\x6f\x6e\40\164\x79\160\145\x3d\x27\x62\x75\x74\164\157\156\x27\40\x64\x69\x73\141\x62\154\145\x64\x3d\x27\144\151\x73\141\x62\154\x65\144\47\x20\x63\x6c\141\163\163\75\47\x62\x75\x74\164\x6f\x6e\40\141\x6c\x74\47\x20\x73\x74\x79\154\x65\75\x27\x77\x69\144\x74\x68\72\x31\x30\60\45\x3b\x68\145\151\x67\x68\164\72\x33\60\160\170\x3b";
        $Ga .= "\146\157\156\x74\55\146\141\155\x69\154\171\72\x20\122\x6f\x62\x6f\x74\157\x3b\146\157\156\164\x2d\x73\x69\x7a\145\72\x20\61\62\x70\x78\40\x21\151\155\160\157\162\x74\x61\x6e\x74\x3b\47\x20\x69\144\x3d\47\155\151\x6e\x69\157\162\x61\156\x67\145\x5f\x6f\x74\x70\x5f\164\x6f\153\145\156\137\163\x75\x62\x6d\x69\x74\x27\x20\164\151\x74\154\x65\75\x27\120\154\145\141\163\x65\x20\x45\x6e\164\145\162\40\141\156\x20\x70\x68\157\x6e\x65\x20\x74\x6f\40\145\156\141\x62\x6c\145\40\x74\150\x69\x73\56\x27\76";
        $Ga .= "\103\x6c\151\143\153\40\x48\145\162\x65\40\x74\x6f\40\126\145\162\x69\x66\171\40\x50\150\x6f\156\x65\74\57\142\x75\x74\164\x6f\156\x3e\x3c\57\x64\151\166\x3e\x3c\144\x69\166\x20\163\x74\171\x6c\x65\75\x27\x6d\141\x72\x67\x69\x6e\x2d\164\x6f\160\72\62\45\47\x3e\x3c\144\x69\166\x20\x69\x64\x3d\47\155\x6f\137\x6d\145\x73\x73\141\x67\145\47\40\x68\151\144\144\145\156\75\x27\x27\40";
        $Ga .= "\163\x74\x79\x6c\x65\x3d\47\142\x61\x63\153\x67\162\157\165\156\x64\x2d\143\157\x6c\x6f\x72\72\x20\x23\x66\67\146\66\x66\x37\x3b\160\141\x64\144\x69\156\147\x3a\x20\61\x65\x6d\40\62\145\x6d\40\x31\145\155\40\63\x2e\x35\145\x6d\73\47\x27\x3e\74\x2f\x64\151\x76\x3e\74\x2f\x64\151\x76\76";
        $V1 = "\74\x73\143\x72\x69\160\x74\76\x6a\121\x75\145\x72\x79\50\144\157\143\165\x6d\x65\x6e\x74\51\56\x72\x65\x61\x64\171\x28\x66\165\x6e\143\164\x69\x6f\x6e\x28\x29\173\44\x6d\x6f\75\152\x51\165\145\162\171\73\40\166\141\162\x20\144\x69\166\x45\x6c\145\155\x65\156\x74\40\75\x20\42" . $Ga . "\42\73\x20";
        $V1 .= "\x24\x6d\157\50\x22\x69\156\x70\x75\x74\x5b\x6e\x61\x6d\x65\x3d\x70\x68\x6f\x6e\145\x5d\42\x29\56\x63\150\141\x6e\x67\x65\50\146\x75\156\143\x74\x69\x6f\156\50\x29\173\40\x69\x66\x28\41\44\155\157\50\164\150\x69\163\51\56\x76\141\154\x28\x29\51\173\40\44\155\157\x28\42\43\155\x69\156\x69\x6f\162\141\x6e\x67\x65\137\x6f\164\x70\x5f\164\157\x6b\145\x6e\137\x73\x75\142\x6d\151\164\x22\x29\56\x70\x72\157\x70\50\x22\x64\151\x73\141\x62\x6c\145\144\x22\54\x74\x72\x75\145\x29\73";
        $V1 .= "\40\x7d\x65\154\x73\145\173\40\x24\155\157\50\42\x23\x6d\x69\156\151\157\x72\x61\156\x67\145\137\x6f\x74\x70\137\164\157\x6b\x65\x6e\137\x73\x75\142\155\151\x74\x22\51\x2e\x70\162\157\160\50\x22\144\x69\x73\141\x62\x6c\x65\144\x22\x2c\x66\x61\154\x73\145\x29\x3b\x20\x7d\40\175\x29\73";
        $V1 .= "\x20\44\x6d\157\50\144\x69\x76\x45\154\x65\x6d\x65\x6e\164\x29\x2e\151\156\x73\x65\162\x74\101\x66\x74\x65\x72\50\44\x6d\x6f\50\40\42\151\x6e\x70\165\x74\x5b\156\x61\x6d\x65\x3d\160\150\x6f\x6e\145\135\x22\x29\x29\x3b\x20\x24\x6d\x6f\50\42\43\x6d\151\156\151\x6f\162\141\156\147\145\137\x6f\164\160\137\164\157\x6b\145\x6e\137\163\x75\142\155\x69\x74\x22\x29\56\x63\x6c\x69\143\153\50\x66\165\156\143\x74\x69\157\156\x28\x6f\x29\x7b\40";
        $V1 .= "\166\141\162\x20\x65\x3d\44\155\x6f\50\x22\x69\156\x70\165\x74\133\156\141\x6d\145\75\160\x68\x6f\x6e\x65\135\x22\x29\x2e\166\x61\154\x28\51\73\x20\x24\x6d\157\x28\42\x23\x6d\157\137\x6d\145\x73\x73\141\147\145\x22\x29\x2e\145\155\x70\164\171\x28\x29\54\x24\155\157\50\42\x23\x6d\x6f\x5f\155\x65\x73\x73\141\147\x65\x22\51\x2e\x61\x70\160\145\156\144\50\x22" . $Eo . "\x22\51\54";
        $V1 .= "\44\155\x6f\50\x22\x23\155\157\x5f\x6d\145\x73\163\x61\x67\x65\42\x29\56\163\x68\157\167\50\51\x2c\x24\155\157\x2e\x61\152\141\x78\x28\173\165\162\x6c\x3a\x22" . site_url() . "\x2f\x3f\x6f\x70\x74\151\157\x6e\x3d\x6d\151\x6e\x69\x6f\x72\x61\156\147\145\x2d\x75\154\164\151\x22\54\x74\171\160\145\72\x22\120\x4f\123\x54\x22\54";
        $V1 .= "\x64\141\164\x61\x3a\x7b\165\x73\x65\162\x5f\160\x68\x6f\x6e\x65\x3a\145\x7d\54\143\162\x6f\163\163\x44\x6f\155\141\151\x6e\x3a\x21\x30\54\144\x61\164\141\x54\x79\160\145\72\x22\x6a\x73\x6f\156\42\54\x73\165\x63\x63\x65\x73\163\x3a\x66\165\x6e\x63\x74\151\157\156\x28\x6f\x29\x7b\x20\151\x66\50\x6f\56\162\145\x73\165\154\164\75\x3d\x22\163\x75\x63\143\x65\163\163\x22\51\173\x24\155\x6f\x28\42\x23\x6d\x6f\137\155\145\x73\x73\x61\147\145\x22\51\56\x65\155\160\x74\171\x28\x29\x2c";
        $V1 .= "\x24\x6d\x6f\50\x22\x23\155\157\x5f\155\x65\x73\x73\141\x67\x65\42\51\56\x61\x70\x70\145\x6e\144\x28\x6f\56\155\145\163\163\x61\147\x65\x29\54\x24\x6d\x6f\50\42\x23\155\x6f\137\155\x65\x73\163\141\147\x65\42\51\56\143\x73\163\x28\42\142\x6f\x72\144\x65\x72\x2d\164\157\x70\42\54\x22\x33\x70\170\x20\163\x6f\x6c\x69\x64\40\147\162\x65\145\x6e\x22\51\x2c";
        $V1 .= "\44\x6d\x6f\x28\x22\x69\156\x70\x75\164\x5b\156\141\x6d\x65\x3d\x65\155\141\x69\x6c\x5f\x76\x65\x72\x69\146\171\135\x22\x29\56\146\x6f\x63\x75\163\50\51\x7d\145\x6c\163\145\x7b\x24\155\157\50\x22\x23\x6d\157\137\x6d\x65\163\x73\x61\x67\x65\x22\51\56\145\x6d\x70\164\x79\x28\51\x2c\44\155\157\50\x22\x23\x6d\157\x5f\155\145\163\163\x61\x67\145\42\x29\56\x61\160\x70\x65\x6e\x64\50\x6f\56\155\x65\163\x73\141\147\145\51\54";
        $V1 .= "\x24\155\157\x28\x22\43\155\x6f\137\155\145\163\x73\141\x67\x65\x22\51\x2e\143\x73\163\50\42\x62\157\x72\144\145\x72\55\x74\157\160\x22\54\42\x33\x70\170\x20\x73\x6f\x6c\x69\x64\x20\x72\x65\144\x22\51\54\x24\x6d\157\x28\42\151\156\x70\165\164\x5b\156\141\x6d\145\x3d\160\x68\157\156\145\x5f\x76\145\162\151\x66\171\135\42\x29\56\x66\x6f\143\x75\163\x28\x29\175\40\73\x7d\54";
        $V1 .= "\x65\x72\162\x6f\x72\x3a\x66\165\x6e\x63\x74\x69\x6f\x6e\x28\157\x2c\145\54\x6e\51\x7b\x7d\x7d\x29\175\51\73\175\51\x3b\x3c\x2f\x73\x63\162\151\x70\164\76";
        return $V1;
    }
    function _email_shortcode()
    {
        $Eo = "\x3c\x64\151\166\40\163\x74\171\154\x65\75\x27\144\x69\x73\x70\154\x61\171\72\x74\x61\x62\x6c\x65\x3b\164\x65\170\164\x2d\141\x6c\151\x67\156\72\143\145\156\164\145\x72\x3b\x27\x3e\x3c\x69\155\147\40\x73\162\143\x3d\47" . MOV_URL . "\x69\156\143\x6c\x75\144\145\163\57\151\x6d\x61\x67\x65\x73\57\154\x6f\141\144\x65\x72\x2e\x67\151\146\x27\76\74\x2f\144\x69\166\x3e";
        $Ga = "\x3c\x64\x69\166\x20\x73\164\x79\x6c\x65\75\x27\155\141\x72\147\x69\156\55\164\x6f\x70\x3a\40\62\45\x3b\47\76\74\142\165\164\x74\157\x6e\x20\x74\x79\x70\145\x3d\47\142\x75\164\164\157\x6e\x27\40\144\151\x73\141\142\x6c\145\144\x3d\x27\x64\151\x73\x61\142\x6c\x65\x64\x27\x20\x63\x6c\141\163\163\75\47\x62\165\x74\164\157\156\x20\x61\154\x74\x27\40";
        $Ga .= "\x73\164\x79\154\145\x3d\x27\167\151\144\164\x68\x3a\61\60\60\x25\x3b\x68\x65\151\x67\150\x74\x3a\63\60\160\170\73\146\157\x6e\164\x2d\146\x61\155\x69\x6c\171\x3a\x20\122\157\142\157\164\x6f\73\x66\157\156\164\x2d\163\x69\x7a\x65\72\40\x31\x32\160\x78\x20\41\151\x6d\x70\157\162\164\141\x6e\164\73\47\x20\x69\x64\75\x27\x6d\x69\x6e\x69\157\x72\141\156\147\x65\x5f\157\164\x70\x5f\164\x6f\x6b\x65\156\x5f\x73\165\142\x6d\x69\x74\x27\x20";
        $Ga .= "\164\x69\164\x6c\145\x3d\x27\120\154\x65\x61\x73\145\40\105\156\x74\145\162\x20\x61\156\x20\145\155\x61\x69\x6c\40\x74\157\x20\145\156\x61\x62\154\145\40\x74\x68\151\163\56\x27\76\x43\x6c\x69\143\x6b\40\x48\x65\162\145\x20\x74\x6f\x20\126\145\162\151\x66\x79\40\171\157\165\x72\40\x65\x6d\141\x69\154\74\57\142\165\164\x74\x6f\x6e\x3e\x3c\x2f\x64\x69\166\76\x3c\x64\151\x76\x20\x73\x74\171\154\145\75\x27\x6d\141\162\147\x69\156\x2d\x74\157\x70\72\62\45\x27\x3e";
        $Ga .= "\74\144\151\x76\40\x69\x64\75\47\155\157\137\x6d\145\163\163\x61\147\145\x27\40\x68\x69\144\144\145\156\x3d\47\47\x20\163\164\171\x6c\145\x3d\47\x62\141\143\x6b\x67\162\x6f\165\156\x64\55\x63\x6f\x6c\157\162\x3a\40\43\146\x37\x66\66\x66\x37\x3b\160\141\x64\x64\151\x6e\x67\x3a\40\61\145\155\40\62\145\155\x20\61\145\155\40\63\x2e\x35\x65\155\x3b\47\47\76\x3c\57\144\x69\166\x3e\74\57\x64\x69\x76\76";
        $V1 = "\74\163\x63\x72\151\x70\164\76\x6a\121\x75\145\x72\171\x28\144\157\x63\165\155\145\156\164\51\56\162\x65\x61\x64\x79\50\146\165\x6e\x63\x74\x69\157\x6e\x28\x29\173\x24\155\x6f\75\x6a\121\165\145\162\x79\73\40\166\141\162\40\x64\x69\x76\105\154\x65\x6d\145\x6e\164\40\75\40\x22" . $Ga . "\x22\73\40";
        $V1 .= "\x24\x6d\x6f\50\x22\x69\156\x70\165\164\133\156\x61\155\x65\x3d\x75\163\145\x72\137\x65\155\x61\151\x6c\135\42\x29\x2e\143\x68\x61\156\x67\145\x28\x66\165\156\143\164\151\157\156\50\x29\173\40\151\x66\x28\41\44\x6d\x6f\x28\164\150\151\x73\51\x2e\166\x61\154\x28\51\51\173\40";
        $V1 .= "\x24\x6d\x6f\50\x22\x23\155\x69\156\151\x6f\x72\x61\156\x67\x65\137\x6f\164\x70\x5f\164\157\153\x65\156\137\163\165\142\155\x69\x74\42\x29\x2e\160\162\157\x70\50\x22\144\x69\163\141\x62\154\145\144\x22\54\x74\162\x75\145\x29\x3b\40\x7d\x65\x6c\x73\x65\x7b\x20";
        $V1 .= "\44\155\157\x28\x22\43\x6d\151\x6e\x69\157\x72\141\x6e\147\145\137\x6f\x74\x70\x5f\x74\157\153\145\x6e\x5f\x73\x75\x62\155\x69\164\42\x29\56\x70\x72\x6f\160\x28\x22\144\x69\163\x61\x62\154\145\x64\x22\54\x66\x61\154\x73\x65\51\x3b\40\175\x20\x7d\x29\x3b\x20";
        $V1 .= "\44\155\157\50\144\151\166\x45\154\x65\155\x65\x6e\x74\51\56\x69\156\x73\x65\162\x74\101\146\x74\x65\162\x28\x24\155\x6f\50\x20\x22\x69\156\160\x75\x74\x5b\x6e\x61\x6d\145\x3d\x75\163\x65\x72\x5f\145\155\x61\x69\x6c\135\42\x29\x29\73\x20\44\x6d\157\50\x22\43\x6d\151\x6e\x69\157\x72\141\x6e\147\145\x5f\x6f\x74\x70\137\164\x6f\153\145\156\x5f\163\165\142\x6d\151\x74\42\x29\x2e\x63\x6c\x69\x63\153\50\x66\x75\156\x63\x74\151\157\x6e\x28\x6f\51\173\x20";
        $V1 .= "\166\141\162\x20\145\x3d\x24\x6d\157\50\x22\151\156\x70\165\x74\133\x6e\141\155\145\75\165\x73\145\162\x5f\145\155\x61\x69\x6c\x5d\x22\51\56\x76\x61\x6c\x28\x29\x3b\x20\44\x6d\x6f\50\42\x23\155\157\137\x6d\x65\x73\163\141\147\x65\42\x29\x2e\x65\x6d\x70\x74\x79\x28\51\x2c\x24\x6d\x6f\x28\x22\x23\x6d\157\137\155\145\x73\x73\141\x67\145\42\x29\56\x61\x70\x70\x65\x6e\144\50\x22" . $Eo . "\x22\x29\x2c";
        $V1 .= "\x24\155\x6f\50\x22\43\x6d\157\x5f\155\145\x73\x73\141\x67\x65\42\51\x2e\163\x68\x6f\167\50\51\x2c\44\155\157\56\x61\x6a\141\170\50\173\x75\162\x6c\x3a\x22" . site_url() . "\57\77\157\160\x74\x69\x6f\156\75\155\x69\x6e\151\157\162\141\x6e\147\145\55\165\154\x74\151\42\x2c\164\x79\x70\145\72\x22\x50\117\x53\124\x22\54\144\x61\164\141\72\x7b\x75\163\145\x72\x5f\x65\155\141\151\x6c\x3a\145\175\x2c\143\x72\x6f\x73\x73\x44\x6f\x6d\141\x69\x6e\x3a\x21\60\x2c\x64\141\x74\x61\x54\x79\160\145\x3a\x22\x6a\163\x6f\x6e\x22\x2c\x73\x75\x63\x63\x65\163\163\x3a\146\x75\x6e\143\164\x69\157\156\x28\x6f\x29\173\x20\151\146\x28\x6f\56\x72\x65\163\165\154\164\x3d\x3d\42\x73\x75\143\x63\x65\163\x73\x22\x29\173\44\155\x6f\50\42\x23\155\157\137\155\x65\163\x73\x61\x67\145\x22\x29\56\x65\155\160\x74\x79\x28\x29\54\44\155\x6f\50\42\43\155\x6f\x5f\x6d\145\x73\x73\141\x67\145\x22\51\56\141\x70\160\145\x6e\144\x28\x6f\56\155\x65\163\163\x61\x67\x65\51\54\x24\155\157\50\x22\x23\x6d\x6f\x5f\x6d\145\x73\x73\x61\x67\145\x22\51\56\x63\x73\x73\50\42\142\157\162\x64\x65\162\x2d\164\157\160\x22\x2c\42\x33\160\x78\40\163\x6f\154\x69\144\40\x67\162\145\145\x6e\42\x29\54\x24\155\x6f\50\42\x69\x6e\x70\165\164\133\156\141\x6d\145\x3d\x65\x6d\141\x69\x6c\137\x76\x65\x72\151\146\171\135\x22\51\56\x66\x6f\x63\x75\x73\50\51\175\x65\x6c\163\x65\173\44\x6d\157\x28\42\x23\155\157\137\x6d\x65\163\163\x61\x67\145\x22\51\x2e\145\155\x70\164\x79\x28\x29\x2c\44\155\157\50\x22\x23\155\x6f\137\155\x65\x73\163\141\147\145\42\x29\56\x61\160\x70\145\x6e\x64\50\157\x2e\155\145\x73\x73\141\x67\145\x29\x2c\x24\x6d\x6f\x28\x22\43\x6d\157\137\x6d\x65\163\163\141\x67\x65\x22\x29\x2e\143\163\163\50\42\142\157\162\x64\x65\162\x2d\x74\157\160\x22\x2c\42\63\x70\170\x20\163\157\x6c\x69\144\x20\162\x65\144\42\51\54\x24\x6d\x6f\50\42\151\x6e\x70\165\164\x5b\x6e\x61\155\x65\75\x70\x68\x6f\156\145\x5f\166\145\x72\151\146\x79\135\42\x29\56\x66\157\143\165\163\50\51\175\x20\73\175\x2c\145\x72\162\x6f\x72\72\x66\x75\156\x63\164\151\157\x6e\x28\157\x2c\145\54\x6e\51\x7b\x7d\175\x29\x7d\x29\x3b\175\51\x3b\74\x2f\x73\143\x72\x69\x70\x74\76";
        return $V1;
    }
    function _handle_ulti_form($pO)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto F7v;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $pO["\x75\x73\x65\x72\x5f\x65\x6d\x61\151\x6c"]);
        $this->sendChallenge('', $pO["\165\163\x65\162\x5f\x65\x6d\141\151\154"], null, null, VerificationType::EMAIL);
        goto BfL;
        F7v:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $pO["\x75\x73\x65\x72\137\160\x68\x6f\156\145"]);
        $this->sendChallenge('', null, null, $pO["\x75\x73\145\162\137\160\x68\157\x6e\x65"], VerificationType::PHONE);
        BfL:
    }
    function validate_umpro_submitted_value($QH, $zs, $j1, $M0)
    {
        $HF = array();
        switch ($QH) {
            case "\160\x68\157\x6e\x65":
                $this->processPhone($HF, $QH, $zs, $j1, $M0);
                goto MxI;
            case "\x75\163\x65\x72\137\145\x6d\141\151\x6c":
                $this->processEmail($HF, $QH, $zs, $j1, $M0);
                goto MxI;
            case "\x76\x61\154\x69\x64\141\x74\145":
                $this->processOTPEntered($HF, $QH, $zs, $j1, $M0);
                goto MxI;
        }
        GbC:
        MxI:
        return $HF;
    }
    function processPhone(&$HF, $QH, $zs, $j1, $M0)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) != 0) {
            goto WFd;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Tdd;
        }
        if (!SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $zs)) {
            goto g6r;
        }
        $HF = array("\164\171\160\x65" => $QH, "\166\x61\154\165\x65" => ihc_check_value_field($QH, $zs, $j1, $M0));
        goto dhT;
        g6r:
        $HF = array("\x74\171\160\x65" => $QH, "\166\141\x6c\165\x65" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        dhT:
        goto Gh9;
        Tdd:
        $HF = array("\x74\x79\x70\x65" => $QH, "\166\141\x6c\165\x65" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        Gh9:
        goto LOL;
        WFd:
        $HF = array("\164\x79\x70\x65" => $QH, "\x76\141\154\x75\x65" => ihc_check_value_field($QH, $zs, $j1, $M0));
        LOL:
    }
    function processEmail(&$HF, $QH, $zs, $j1, $M0)
    {
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) != 0) {
            goto sb2;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Vn7;
        }
        if (!SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $zs)) {
            goto A3j;
        }
        $HF = array("\164\x79\x70\x65" => $QH, "\x76\x61\x6c\165\x65" => ihc_check_value_field($QH, $zs, $j1, $M0));
        goto CiS;
        A3j:
        $HF = array("\x74\171\x70\145" => $QH, "\x76\141\x6c\165\x65" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        CiS:
        goto V8A;
        Vn7:
        $HF = array("\x74\171\x70\x65" => $QH, "\x76\x61\x6c\165\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        V8A:
        goto ueI;
        sb2:
        $HF = array("\164\171\160\145" => $QH, "\x76\141\154\x75\145" => ihc_check_value_field($QH, $zs, $j1, $M0));
        ueI:
    }
    function processOTPEntered(&$HF, $QH, $zs, $j1, $M0)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto KcC;
        }
        $this->validateAndProcessOTP($HF, $QH, $zs);
        goto Ats;
        KcC:
        $HF = array("\164\x79\x70\145" => $QH, "\166\x61\x6c\165\x65" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        Ats:
    }
    function validateAndProcessOTP(&$HF, $QH, $V7)
    {
        $HV = $this->getVerificationType();
        $this->validateChallenge($HV, NULL, $V7);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $HV)) {
            goto O45;
        }
        $this->unsetOTPSessionVariables();
        $HF = array("\164\171\160\145" => $QH, "\x76\x61\x6c\x75\145" => 1);
        goto O2x;
        O45:
        $HF = array("\164\x79\x70\145" => $QH, "\x76\x61\154\x75\145" => MoUtility::_get_invalid_otp_method());
        O2x:
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
            goto blP;
        }
        array_push($zX, $this->_phoneFormId);
        blP:
        return $zX;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Nhp;
        }
        return;
        Nhp:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\154\164\x69\x70\162\x6f\x5f\145\156\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\165\x6c\164\151\x70\x72\x6f\137\164\x79\x70\x65");
        update_mo_option("\165\x6c\164\x69\160\x72\x6f\x5f\145\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\165\154\164\151\160\162\x6f\x5f\x74\x79\160\x65", $this->_otpType);
    }
}
