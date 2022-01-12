<?php


namespace OTP;

use OTP\Handler\EmailVerificationLogic;
use OTP\Handler\FormActionHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Handler\MoRegistrationHandler;
use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MenuItems;
use OTP\Helper\MoConstants;
use OTP\Helper\MoDisplayMessages;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\MOVisualTour;
use OTP\Helper\PolyLangStrings;
use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
use OTP\Helper\MoAddonListContent;
use OTP\Helper\MoOffer;
use OTP\Handler\CustomForm;
use OTP\Helper\MocURLOTP;
use OTP\Objects\BaseMessages;
use OTP\Helper\MoVersionUpdate;
use OTP\Helper\MoOTPAlphaNumeric;
use OTP\Helper\MoSMSBackupGateway;
use OTP\Helper\MoGloballyBannedPhone;
if (defined("\x41\102\123\x50\101\x54\110")) {
    goto mD;
}
die;
mD:
final class MoOTP
{
    use Instance;
    private function __construct()
    {
        $this->initializeHooks();
        $this->initializeGlobals();
        $this->initializeHelpers();
        $this->initializeHandlers();
        $this->registerPolyLangStrings();
        $this->registerAddOns();
    }
    private function initializeHooks()
    {
        add_action("\160\x6c\165\147\151\x6e\163\x5f\x6c\x6f\141\x64\x65\x64", array($this, "\x6f\164\160\137\x6c\157\141\144\x5f\x74\x65\170\x74\144\x6f\x6d\x61\151\156"));
        add_action("\141\144\155\x69\x6e\137\x6d\x65\156\165", array($this, "\x6d\x69\x6e\x69\157\162\x61\x6e\147\145\x5f\x63\165\x73\x74\x6f\x6d\x65\x72\137\166\x61\154\151\x64\141\164\x69\x6f\156\x5f\x6d\x65\156\x75"));
        add_action("\141\144\155\x69\156\x5f\145\x6e\x71\165\x65\165\145\x5f\x73\143\x72\x69\160\x74\x73", array($this, "\x6d\x6f\137\162\x65\x67\151\163\164\x72\141\164\151\157\x6e\137\x70\x6c\165\147\x69\156\x5f\163\x65\164\164\x69\156\x67\163\x5f\x73\x74\171\x6c\145"));
        add_action("\x61\144\155\151\x6e\137\145\156\x71\165\x65\165\145\137\x73\x63\x72\151\160\x74\x73", array($this, "\155\157\137\x72\145\x67\151\x73\x74\162\x61\x74\151\x6f\156\x5f\x70\154\165\x67\x69\156\x5f\x73\x65\x74\164\x69\156\147\x73\137\163\143\162\151\x70\164"));
        add_action("\167\160\137\145\156\161\x75\145\x75\x65\137\x73\143\162\151\x70\164\x73", array($this, "\155\x6f\x5f\x72\x65\147\151\x73\164\162\141\164\151\x6f\156\137\160\154\165\147\151\x6e\x5f\146\162\157\156\x74\x65\156\144\x5f\163\143\162\x69\x70\164\163"), 99);
        add_action("\x6c\157\x67\151\156\x5f\x65\x6e\161\x75\145\x75\145\137\163\x63\x72\151\x70\164\x73", array($this, "\155\x6f\137\162\145\147\x69\x73\x74\162\x61\164\151\157\x6e\x5f\x70\x6c\165\x67\151\156\x5f\146\x72\x6f\156\x74\x65\x6e\x64\x5f\x73\143\x72\x69\160\164\x73"), 99);
        add_action("\x6d\x6f\137\162\145\x67\151\163\164\162\141\164\151\x6f\156\137\163\150\x6f\x77\137\155\145\x73\x73\141\147\x65", array($this, "\x6d\x6f\x5f\x73\x68\157\x77\x5f\x6f\164\x70\x5f\155\145\x73\163\141\x67\x65"), 1, 2);
        add_action("\x68\x6f\165\162\154\171\123\x79\156\x63", array($this, "\x68\157\165\162\154\x79\123\x79\x6e\143"));
        add_action("\141\144\x6d\151\x6e\137\x66\x6f\157\164\145\x72", array($this, "\x66\145\x65\x64\x62\141\143\x6b\137\x72\145\x71\165\145\163\x74"));
        add_filter("\x77\x70\137\155\141\x69\x6c\x5f\146\x72\x6f\155\x5f\x6e\141\x6d\x65", array($this, "\x63\165\x73\x74\157\155\137\167\x70\137\x6d\141\151\x6c\137\146\162\157\x6d\x5f\x6e\141\x6d\145"));
        add_filter("\160\154\x75\x67\151\156\137\162\157\167\137\x6d\145\164\141", array($this, "\x6d\x6f\137\155\145\x74\x61\x5f\154\151\x6e\x6b\163"), 10, 2);
        add_action("\167\x70\137\145\x6e\x71\165\145\165\145\x5f\163\x63\x72\x69\160\x74\163", array($this, "\154\157\x61\144\x5f\x6a\161\165\x65\x72\x79\x5f\157\156\x5f\146\x6f\162\155\163"));
        add_action("\x70\154\x75\147\x69\156\x5f\x61\143\x74\151\x6f\x6e\137\x6c\x69\156\153\x73\137" . MOV_PLUGIN_NAME, array($this, "\x70\154\165\147\151\156\137\x61\143\164\x69\x6f\x6e\x5f\154\151\156\x6b\x73"), 10, 1);
    }
    function load_jquery_on_forms()
    {
        if (wp_script_is("\152\161\x75\145\162\171", "\x65\156\x71\165\x65\165\x65\x64")) {
            goto a5;
        }
        wp_enqueue_script("\152\161\165\x65\162\x79");
        a5:
    }
    private function initializeHelpers()
    {
        MoMessages::instance();
        MoAddonListContent::instance();
        MoOffer::instance();
        PolyLangStrings::instance();
        MOVisualTour::instance();
        if (!file_exists(MOV_DIR . "\x68\145\x6c\x70\145\162\57\115\x6f\x56\145\x72\163\151\157\x6e\125\x70\144\141\164\145\56\x70\x68\160")) {
            goto qq;
        }
        MoVersionUpdate::instance();
        qq:
        if (!file_exists(MOV_DIR . "\x68\x65\x6c\160\145\162\57\x4d\157\117\x54\x50\x41\x6c\160\x68\x61\x4e\x75\155\145\162\x69\143\x2e\x70\150\160")) {
            goto dv;
        }
        MoOTPAlphaNumeric::instance();
        dv:
        if (!file_exists(MOV_DIR . "\x68\145\154\x70\145\162\57\115\x6f\x53\x4d\123\102\x61\143\x6b\x75\x70\107\141\x74\x65\x77\x61\x79\x2e\160\x68\x70")) {
            goto q7;
        }
        MoSMSBackupGateway::instance();
        q7:
        if (!file_exists(MOV_DIR . "\x68\x65\154\x70\145\x72\x2f\115\157\x47\154\157\x62\141\x6c\x6c\x79\x42\x61\156\156\x65\x64\120\x68\x6f\x6e\145\56\160\150\x70")) {
            goto BX;
        }
        MoGloballyBannedPhone::instance();
        BX:
    }
    private function initializeHandlers()
    {
        FormActionHandler::instance();
        MoOTPActionHandlerHandler::instance();
        DefaultPopup::instance();
        ErrorPopup::instance();
        ExternalPopup::instance();
        UserChoicePopup::instance();
        MoRegistrationHandler::instance();
        CustomForm::instance();
    }
    private function initializeGlobals()
    {
        global $phoneLogic, $emailLogic;
        $phoneLogic = PhoneVerificationLogic::instance();
        $emailLogic = EmailVerificationLogic::instance();
    }
    function miniorange_customer_validation_menu()
    {
        MenuItems::instance();
    }
    function mo_customer_validation_options()
    {
        include MOV_DIR . "\x63\157\156\164\x72\x6f\154\x6c\145\x72\x73\57\x6d\x61\151\x6e\55\x63\157\x6e\164\162\x6f\x6c\154\145\162\x2e\x70\150\x70";
    }
    function mo_registration_plugin_settings_style()
    {
        wp_enqueue_style("\155\x6f\137\143\x75\x73\164\x6f\155\x65\162\137\166\x61\x6c\151\144\x61\164\x69\x6f\x6e\x5f\141\144\155\151\x6e\x5f\x73\x65\x74\x74\x69\156\x67\163\x5f\x73\x74\171\154\145", MOV_CSS_URL);
        wp_enqueue_style("\155\157\137\143\x75\163\164\x6f\x6d\x65\162\x5f\166\141\154\x69\144\x61\x74\151\157\x6e\137\151\x6e\164\164\145\154\x69\156\160\165\x74\137\163\x74\171\154\x65", MO_INTTELINPUT_CSS);
    }
    function mo_registration_plugin_settings_script()
    {
        $zC = array();
        wp_enqueue_script("\x6d\157\137\x63\165\163\x74\x6f\155\x65\162\x5f\x76\x61\x6c\151\x64\141\x74\151\x6f\156\137\141\x64\x6d\151\x6e\137\163\145\164\164\151\x6e\147\x73\x5f\x73\143\162\151\x70\x74", MOV_JS_URL, array("\x6a\x71\x75\145\162\x79"));
        wp_enqueue_script("\155\157\137\x63\x75\x73\164\157\155\x65\x72\137\166\x61\154\151\144\x61\164\151\x6f\156\x5f\146\x6f\x72\155\137\166\x61\154\x69\144\141\x74\151\157\156\137\x73\143\162\151\x70\x74", VALIDATION_JS_URL, array("\152\161\165\145\x72\171"));
        wp_register_script("\155\157\137\143\165\x73\x74\x6f\155\145\x72\x5f\166\x61\x6c\151\x64\x61\164\x69\157\156\x5f\x69\x6e\x74\x74\x65\154\x69\156\160\x75\164\137\x73\143\x72\151\x70\164", MO_INTTELINPUT_JS, array("\152\x71\165\x65\x72\x79"));
        $a3 = CountryList::getCountryCodeList();
        $a3 = apply_filters("\x73\x65\x6c\145\143\164\x65\x64\x5f\143\x6f\165\156\x74\x72\151\145\x73", $a3);
        foreach ($a3 as $Zm => $zs) {
            array_push($zC, $zs);
            SV:
        }
        jN:
        wp_localize_script("\x6d\x6f\x5f\x63\165\x73\164\157\x6d\x65\x72\x5f\166\x61\154\x69\x64\x61\x74\151\x6f\x6e\x5f\x69\x6e\x74\x74\x65\154\x69\156\160\x75\164\137\163\143\x72\151\x70\164", "\155\x6f\163\145\x6c\145\x63\x74\x65\x64\x64\162\157\160\x64\x6f\167\156", array("\x73\x65\154\145\143\x74\x65\144\x64\x72\157\160\144\x6f\x77\x6e" => $zC));
        wp_enqueue_script("\155\157\x5f\x63\x75\x73\x74\x6f\x6d\x65\162\x5f\x76\x61\154\151\144\141\164\151\157\156\x5f\x69\156\x74\164\x65\154\151\x6e\160\x75\164\x5f\x73\x63\x72\151\160\x74");
    }
    function mo_registration_plugin_frontend_scripts()
    {
        $zC = array();
        if (get_mo_option("\x73\x68\157\167\137\144\162\x6f\160\144\x6f\x77\156\x5f\157\156\137\146\x6f\x72\155")) {
            goto hA;
        }
        return;
        hA:
        $zX = apply_filters("\155\x6f\137\x70\150\157\156\x65\137\144\162\157\x70\x64\157\x77\x6e\137\x73\x65\x6c\145\x63\x74\x6f\x72", array());
        if (!MoUtility::isBlank($zX)) {
            goto mn;
        }
        return;
        mn:
        $zX = array_unique($zX);
        $a3 = CountryList::getCountryCodeList();
        $a3 = apply_filters("\163\145\154\145\x63\x74\145\144\137\x63\157\x75\156\x74\162\151\145\163", $a3);
        foreach ($a3 as $Zm => $zs) {
            array_push($zC, $zs);
            hm:
        }
        CA:
        wp_register_script("\x6d\157\x5f\143\165\163\164\157\x6d\x65\162\137\166\x61\x6c\x69\x64\x61\164\151\x6f\x6e\x5f\151\156\x74\x74\145\x6c\151\x6e\x70\165\164\x5f\x73\x63\162\151\x70\164", MO_INTTELINPUT_JS, array("\x6a\x71\x75\145\x72\171"));
        wp_localize_script("\155\x6f\x5f\143\x75\x73\x74\x6f\x6d\145\x72\137\x76\141\x6c\151\144\x61\x74\151\x6f\x6e\x5f\x69\x6e\x74\x74\x65\x6c\151\x6e\160\165\164\137\x73\x63\x72\151\x70\164", "\155\157\163\x65\154\x65\x63\x74\x65\144\144\x72\x6f\x70\144\x6f\x77\156", array("\x73\145\x6c\x65\x63\164\145\144\144\x72\157\x70\144\157\167\156" => $zC));
        wp_enqueue_script("\155\157\137\143\x75\x73\164\x6f\155\145\x72\137\166\x61\x6c\x69\x64\141\164\151\x6f\156\x5f\151\x6e\x74\164\145\x6c\x69\156\160\x75\x74\137\163\143\162\x69\160\x74");
        wp_enqueue_style("\155\x6f\137\143\x75\x73\x74\157\155\x65\x72\137\166\x61\x6c\151\x64\x61\x74\151\x6f\x6e\137\x69\156\164\164\145\x6c\151\x6e\x70\165\164\x5f\x73\x74\x79\154\x65", MO_INTTELINPUT_CSS);
        wp_register_script("\x6d\157\137\x63\x75\x73\164\x6f\155\x65\162\x5f\x76\141\154\151\x64\x61\164\151\157\156\x5f\144\162\157\x70\144\157\x77\x6e\137\x73\143\x72\x69\160\x74", MO_DROPDOWN_JS, array("\x6a\161\165\x65\x72\171"), MOV_VERSION, true);
        wp_localize_script("\155\157\x5f\x63\x75\x73\x74\x6f\155\145\x72\x5f\x76\x61\x6c\151\144\141\164\x69\x6f\x6e\x5f\144\162\157\x70\144\157\167\x6e\x5f\163\x63\x72\151\x70\x74", "\x6d\x6f\144\x72\x6f\x70\x64\157\167\156\166\x61\162\x73", array("\163\145\x6c\145\143\164\x6f\162" => json_encode($zX), "\x64\145\146\141\165\x6c\x74\103\x6f\x75\156\x74\x72\x79" => CountryList::getDefaultCountryIsoCode(), "\157\x6e\154\171\x43\x6f\165\x6e\164\162\x69\145\x73" => CountryList::getOnlyCountryList()));
        wp_enqueue_script("\x6d\x6f\x5f\x63\x75\163\164\x6f\155\x65\162\x5f\x76\141\x6c\151\x64\141\x74\151\157\156\137\144\x72\x6f\x70\x64\x6f\167\156\137\163\x63\x72\x69\160\164");
    }
    function mo_show_otp_message($SC, $QH)
    {
        new MoDisplayMessages($SC, $QH);
    }
    function otp_load_textdomain()
    {
        load_plugin_textdomain("\x6d\151\x6e\x69\x6f\x72\141\x6e\x67\x65\x2d\x6f\x74\x70\55\x76\145\162\151\x66\151\x63\x61\x74\151\x6f\156", FALSE, dirname(plugin_basename(__FILE__)) . "\57\154\x61\156\x67\57");
        do_action("\155\157\x5f\x6f\164\x70\137\x76\x65\162\x69\146\x69\143\141\164\151\157\156\x5f\141\x64\144\x5f\157\156\137\x6c\141\156\x67\x5f\146\151\x6c\x65\x73");
    }
    private function registerPolylangStrings()
    {
        if (MoUtility::_is_polylang_installed()) {
            goto PR;
        }
        return;
        PR:
        foreach (unserialize(MO_POLY_STRINGS) as $Zm => $zs) {
            pll_register_string($Zm, $zs, "\x6d\151\x6e\151\x6f\x72\x61\x6e\147\x65\55\x6f\x74\160\x2d\166\x65\162\x69\x66\x69\143\141\x74\151\x6f\156");
            W0:
        }
        wG:
    }
    private function registerAddOns()
    {
        $tu = GatewayFunctions::instance();
        $tu->registerAddOns();
    }
    function feedback_request()
    {
        include MOV_DIR . "\143\157\156\x74\x72\157\x6c\154\145\162\x73\57\x66\145\145\x64\x62\x61\143\x6b\x2e\x70\x68\160";
    }
    function mo_meta_links($R1, $Yv)
    {
        if (!(MOV_PLUGIN_NAME === $Yv)) {
            goto JJ;
        }
        $R1[] = "\74\x73\160\x61\x6e\x20\x63\x6c\141\x73\163\75\47\x64\141\x73\x68\x69\143\x6f\x6e\163\40\144\141\163\150\151\x63\157\156\x73\x2d\x73\x74\x69\x63\x6b\x79\47\76\x3c\x2f\163\x70\141\x6e\76\xd\xa\x20\x20\40\x20\40\40\40\40\40\40\40\x20\x3c\x61\40\x68\162\x65\x66\x3d\47" . MoConstants::FAQ_URL . "\47\x20\164\141\162\x67\x65\164\75\x27\x5f\x62\x6c\x61\156\153\47\76" . mo_("\106\101\x51\x73") . "\74\57\141\x3e";
        JJ:
        return $R1;
    }
    function plugin_action_links($Xc)
    {
        $qZ = TabDetails::instance();
        $lq = $qZ->_tabDetails[Tabs::FORMS];
        if (!is_plugin_active(MOV_PLUGIN_NAME)) {
            goto Bo;
        }
        $Xc = array_merge(array("\x3c\141\40\x68\162\145\146\x3d\x22" . esc_url(admin_url("\x61\x64\x6d\x69\x6e\56\x70\150\x70\x3f\x70\x61\147\145\75" . $lq->_menuSlug)) . "\x22\x3e" . mo_("\x53\x65\x74\164\x69\156\147\163") . "\x3c\57\141\76"), $Xc);
        Bo:
        return $Xc;
    }
    function hourlySync()
    {
        $tu = GatewayFunctions::instance();
        $tu->hourlySync();
    }
    function custom_wp_mail_from_name($Wk)
    {
        $tu = GatewayFunctions::instance();
        return $tu->custom_wp_mail_from_name($Wk);
    }
}
