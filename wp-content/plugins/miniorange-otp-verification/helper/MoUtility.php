<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use ReflectionClass;
use ReflectionException;
use stdClass;
if (defined("\101\102\x53\120\x41\x54\110")) {
    goto U0;
}
die;
U0:
class MoUtility
{
    public static function get_hidden_phone($fk)
    {
        return "\x78\170\170\170\x78\170\x78" . substr($fk, strlen($fk) - 3);
    }
    public static function isBlank($zs)
    {
        return !isset($zs) || empty($zs);
    }
    public static function createJson($SF, $QH)
    {
        return array("\155\x65\x73\163\141\x67\x65" => $SF, "\x72\x65\x73\165\x6c\x74" => $QH);
    }
    public static function mo_is_curl_installed()
    {
        return in_array("\143\165\x72\154", get_loaded_extensions());
    }
    public static function currentPageUrl()
    {
        $gv = "\x68\x74\164\x70";
        if (!(isset($_SERVER["\110\124\124\x50\x53"]) && $_SERVER["\110\x54\124\120\x53"] == "\157\x6e")) {
            goto Oc;
        }
        $gv .= "\x73";
        Oc:
        $gv .= "\x3a\57\x2f";
        if ($_SERVER["\x53\x45\x52\x56\x45\x52\x5f\120\117\x52\124"] != "\70\60") {
            goto dH;
        }
        $gv .= $_SERVER["\x53\x45\x52\126\105\122\137\x4e\101\x4d\x45"] . $_SERVER["\122\105\x51\125\105\x53\x54\137\x55\x52\x49"];
        goto YH;
        dH:
        $gv .= $_SERVER["\123\x45\122\126\x45\x52\x5f\x4e\x41\115\x45"] . "\72" . $_SERVER["\123\105\122\126\105\x52\x5f\120\x4f\122\x54"] . $_SERVER["\x52\x45\x51\125\x45\123\x54\x5f\125\x52\x49"];
        YH:
        if (!function_exists("\x61\160\x70\x6c\x79\137\146\x69\x6c\164\x65\162\x73")) {
            goto up;
        }
        apply_filters("\x6d\157\137\x63\165\x72\154\137\160\141\147\145\137\x75\162\154", $gv);
        up:
        return $gv;
    }
    public static function getDomain($h4)
    {
        return $M4 = substr(strrchr($h4, "\100"), 1);
    }
    public static function validatePhoneNumber($fk)
    {
        return preg_match(MoConstants::PATTERN_PHONE, MoUtility::processPhoneNumber($fk), $av);
    }
    public static function isCountryCodeAppended($fk)
    {
        return preg_match(MoConstants::PATTERN_COUNTRY_CODE, $fk, $av) ? true : false;
    }
    public static function processPhoneNumber($fk)
    {
        $fk = preg_replace(MoConstants::PATTERN_SPACES_HYPEN, '', ltrim(trim($fk), "\60"));
        $dV = CountryList::getDefaultCountryCode();
        $fk = !isset($dV) || MoUtility::isCountryCodeAppended($fk) ? $fk : $dV . $fk;
        return apply_filters("\x6d\x6f\137\x70\162\157\x63\145\163\x73\x5f\160\150\157\156\x65", $fk);
    }
    public static function micr()
    {
        $h4 = get_mo_option("\x61\144\x6d\x69\156\x5f\x65\155\141\151\x6c");
        $dT = get_mo_option("\x61\x64\x6d\151\x6e\137\x63\165\x73\164\157\155\145\x72\x5f\x6b\x65\171");
        if (!$h4 || !$dT || !is_numeric(trim($dT))) {
            goto dD;
        }
        return 1;
        goto LK;
        dD:
        return 0;
        LK:
    }
    public static function rand()
    {
        $y8 = wp_rand(0, 15);
        $uS = "\60\61\x32\63\64\65\x36\67\70\x39\141\x62\143\x64\x65\x66\x67\150\151\x6a\153\x6c\x6d\x6e\x6f\x70\161\162\x73\164\x75\x76\x77\170\171\x7a\x41\102\103\104\x45\x46\x47\110\x49\x4a\x4b\114\115\x4e\x4f\x50\x51\122\x53\124\125\126\x57\130\131\x5a";
        $qK = '';
        $Ms = 0;
        VY:
        if (!($Ms < $y8)) {
            goto vT;
        }
        $qK .= $uS[wp_rand(0, strlen($uS) - 1)];
        xB:
        $Ms++;
        goto VY;
        vT:
        return $qK;
    }
    public static function micv()
    {
        $h4 = get_mo_option("\141\144\155\151\x6e\137\x65\x6d\141\x69\x6c");
        $dT = get_mo_option("\141\x64\x6d\x69\x6e\x5f\x63\165\x73\x74\x6f\x6d\145\x72\137\x6b\x65\171");
        $YZ = get_mo_option("\x63\x68\145\x63\x6b\137\154\x6e");
        if (!$h4 || !$dT || !is_numeric(trim($dT))) {
            goto eG;
        }
        return $YZ ? $YZ : 0;
        goto Sn;
        eG:
        return 0;
        Sn:
    }
    public static function _handle_mo_check_ln($wz, $dT, $Ca)
    {
        $g_ = MoMessages::FREE_PLAN_MSG;
        $Z3 = array();
        $tu = GatewayFunctions::instance();
        $SC = json_decode(MocURLOTP::check_customer_ln($dT, $Ca, $tu->getApplicationName()), true);
        if (strcasecmp($SC["\x73\x74\x61\x74\165\x73"], "\x53\125\x43\103\x45\123\123") == 0) {
            goto Rp;
        }
        $SC = json_decode(MocURLOTP::check_customer_ln($dT, $Ca, "\167\x70\137\x65\155\x61\x69\x6c\137\x76\x65\162\151\x66\151\x63\141\164\151\157\156\137\151\x6e\x74\x72\141\x6e\145\x74"), true);
        if (!MoUtility::sanitizeCheck("\x6c\151\143\145\x6e\x73\145\120\x6c\x61\156", $SC)) {
            goto Oi;
        }
        $g_ = MoMessages::INSTALL_PREMIUM_PLUGIN;
        Oi:
        goto Qr;
        Rp:
        $U2 = isset($SC["\x65\x6d\x61\151\x6c\122\145\x6d\141\151\x6e\151\x6e\147"]) ? $SC["\x65\155\x61\151\154\x52\145\x6d\141\x69\x6e\151\156\147"] : 0;
        $eZ = isset($SC["\163\x6d\163\122\x65\x6d\x61\151\x6e\x69\156\147"]) ? $SC["\x73\155\x73\x52\x65\155\141\151\x6e\x69\x6e\x67"] : 0;
        if (!MoUtility::sanitizeCheck("\154\151\x63\x65\x6e\x73\x65\120\x6c\x61\x6e", $SC)) {
            goto oS;
        }
        if (strcmp(MOV_TYPE, "\x4d\x69\x6e\x69\117\162\141\156\x67\145\107\x61\x74\x65\x77\141\x79") === 0 || strcmp(MOV_TYPE, "\x45\x6e\x74\145\162\x70\x72\151\163\145\x47\141\164\x65\167\141\x79\127\x69\x74\150\x41\x64\144\x6f\156\x73") === 0) {
            goto VS;
        }
        $g_ = MoMessages::UPGRADE_MSG;
        $Z3 = array("\160\x6c\x61\156" => $SC["\x6c\x69\143\x65\156\x73\x65\x50\x6c\x61\156"]);
        goto lm;
        VS:
        $g_ = MoMessages::REMAINING_TRANSACTION_MSG;
        $Z3 = array("\160\154\x61\x6e" => $SC["\x6c\x69\143\145\x6e\x73\x65\x50\154\x61\156"], "\163\155\x73" => $eZ, "\145\x6d\141\151\154" => $U2);
        lm:
        update_mo_option("\x63\150\145\x63\x6b\137\x6c\156", base64_encode($SC["\154\151\x63\145\156\x73\x65\x50\x6c\x61\156"]));
        oS:
        update_mo_option("\145\155\x61\151\154\137\x74\162\x61\x6e\x73\x61\143\164\x69\x6f\x6e\163\x5f\162\145\155\141\x69\x6e\x69\x6e\x67", $U2);
        update_mo_option("\160\150\x6f\156\145\x5f\x74\x72\x61\156\x73\141\143\164\x69\157\156\x73\137\x72\x65\x6d\141\x69\x6e\151\156\x67", $eZ);
        Qr:
        if (!$wz) {
            goto YC;
        }
        do_action("\x6d\157\x5f\x72\145\x67\x69\163\x74\x72\141\x74\151\157\x6e\x5f\163\150\157\x77\x5f\155\x65\x73\x73\x61\147\x65", MoMessages::showMessage($g_, $Z3), "\x53\x55\x43\x43\105\x53\123");
        YC:
    }
    public static function initialize_transaction($form)
    {
        $oN = new ReflectionClass(FormSessionVars::class);
        foreach ($oN->getConstants() as $Zm => $zs) {
            MoPHPSessions::unsetSession($zs);
            Q_:
        }
        tK:
        SessionUtils::initializeForm($form);
    }
    public static function _get_invalid_otp_method()
    {
        return get_mo_option("\x69\x6e\x76\x61\154\151\x64\x5f\155\x65\x73\163\141\147\145", "\155\157\x5f\x6f\164\160\x5f") ? mo_(get_mo_option("\151\x6e\166\141\154\x69\144\x5f\155\x65\163\x73\141\x67\x65", "\x6d\x6f\137\157\164\x70\137")) : MoMessages::showMessage(MoMessages::INVALID_OTP);
    }
    public static function _is_polylang_installed()
    {
        return function_exists("\160\154\154\x5f\137") && function_exists("\160\x6c\154\137\x72\145\x67\x69\163\x74\x65\x72\137\x73\164\x72\151\x6e\x67");
    }
    public static function replaceString(array $Sy, $iz)
    {
        foreach ($Sy as $Zm => $zs) {
            $iz = str_replace("\173" . $Zm . "\x7d", $zs, $iz);
            x6:
        }
        fq:
        return $iz;
    }
    private static function testResult()
    {
        $oQ = new stdClass();
        $oQ->status = MO_FAIL_MODE ? "\x45\122\122\117\x52" : "\123\x55\103\103\x45\x53\x53";
        return $oQ;
    }
    public static function send_phone_notif($iZ, $g_)
    {
        $sy = function ($iZ, $g_) {
            return json_decode(MocURLOTP::send_notif(new NotificationSettings($iZ, $g_)));
        };
        $iZ = MoUtility::processPhoneNumber($iZ);
        $g_ = self::replaceString(array("\160\x68\x6f\156\x65" => str_replace("\x2b", '', "\x25\62\102" . $iZ)), $g_);
        $SC = MO_TEST_MODE ? self::testResult() : $sy($iZ, $g_);
        return strcasecmp($SC->status, "\123\125\103\x43\105\x53\123") == 0 ? true : false;
    }
    public static function send_email_notif($s0, $dB, $qD, $Rk, $SF)
    {
        $sy = function ($s0, $dB, $qD, $Rk, $SF) {
            $RN = new NotificationSettings($s0, $dB, $qD, $Rk, $SF);
            return json_decode(MocURLOTP::send_notif($RN));
        };
        $SC = MO_TEST_MODE ? self::testResult() : $sy($s0, $dB, $qD, $Rk, $SF);
        return strcasecmp($SC->status, "\123\x55\x43\x43\x45\123\x53") == 0 ? true : false;
    }
    public static function sanitizeCheck($Zm, $Ui)
    {
        if (is_array($Ui)) {
            goto Z5;
        }
        return $Ui;
        Z5:
        $zs = !array_key_exists($Zm, $Ui) || self::isBlank($Ui[$Zm]) ? false : $Ui[$Zm];
        return is_array($zs) ? $zs : sanitize_text_field($zs);
    }
    public static function mclv()
    {
        $tu = GatewayFunctions::instance();
        return $tu->mclv();
    }
    public static function isGatewayConfig()
    {
        $tu = GatewayFunctions::instance();
        return $tu->isGatewayConfig();
    }
    public static function isMG()
    {
        $tu = GatewayFunctions::instance();
        return $tu->isMG();
    }
    public static function areFormOptionsBeingSaved($EY)
    {
        return current_user_can("\155\x61\156\x61\147\145\x5f\157\160\x74\x69\x6f\x6e\163") && self::micr() && self::mclv() && isset($_POST["\157\160\x74\151\x6f\x6e"]) && $EY == $_POST["\157\x70\x74\x69\x6f\156"];
    }
    public static function is_addon_activated()
    {
        if (!(self::micr() && self::mclv())) {
            goto sL;
        }
        return;
        sL:
        $qZ = TabDetails::instance();
        $ux = add_query_arg(array("\160\x61\x67\x65" => $qZ->_tabDetails[Tabs::ACCOUNT]->_menuSlug), remove_query_arg("\x61\144\144\x6f\156", $_SERVER["\122\x45\121\125\x45\x53\x54\137\x55\x52\111"]));
        echo "\x3c\144\x69\x76\40\x73\164\171\x6c\x65\75\x22\x64\151\163\x70\154\141\171\72\x62\x6c\157\x63\153\x3b\x6d\141\x72\x67\151\x6e\55\164\x6f\160\x3a\61\x30\x70\x78\x3b\x63\x6f\x6c\x6f\162\72\162\x65\x64\73\142\141\x63\153\x67\x72\157\x75\x6e\x64\55\143\157\x6c\x6f\x72\x3a\x72\147\142\141\50\x32\x35\x31\54\40\62\x33\x32\54\x20\x30\x2c\x20\60\x2e\x31\x35\51\73\15\12\x9\x9\11\x9\x9\x9\x9\11\x70\x61\144\144\x69\156\x67\72\x35\160\170\x3b\142\157\x72\144\x65\162\x3a\x73\x6f\x6c\x69\x64\40\x31\x70\x78\40\x72\x67\x62\x61\x28\x32\65\x35\x2c\x20\60\54\40\71\54\x20\x30\56\x33\66\51\73\42\76\15\12\11\x9\11\x20\x9\11\74\x61\x20\150\x72\145\x66\75\42" . $ux . "\x22\76" . mo_("\126\141\x6c\x69\144\141\164\x65\x20\x79\157\x75\x72\x20\x70\x75\x72\143\150\x61\163\x65") . "\x3c\57\141\76\x20\xd\xa\x9\x9\11\40\11\11\11\x9" . mo_("\x20\x74\157\40\x65\156\x61\x62\x6c\x65\x20\164\150\x65\40\101\x64\x64\x20\x4f\156") . "\x3c\57\144\151\166\x3e";
    }
    public static function getActivePluginVersion($k8, $eR = 0)
    {
        if (function_exists("\147\145\x74\137\x70\x6c\x75\x67\x69\156\x73")) {
            goto wL;
        }
        require_once ABSPATH . "\x77\160\55\x61\144\x6d\x69\156\x2f\151\x6e\143\154\165\x64\145\163\57\160\x6c\165\147\151\x6e\x2e\160\150\160";
        wL:
        $rV = get_plugins();
        $Lm = get_option("\x61\143\x74\x69\166\x65\137\160\x6c\165\x67\151\x6e\x73");
        foreach ($rV as $Zm => $zs) {
            if (!(strcasecmp($zs["\116\x61\155\145"], $k8) == 0)) {
                goto SA;
            }
            if (!in_array($Zm, $Lm)) {
                goto yB;
            }
            return (int) $zs["\x56\145\x72\163\151\x6f\156"][$eR];
            yB:
            SA:
            Ws:
        }
        RB:
        return null;
    }
}
