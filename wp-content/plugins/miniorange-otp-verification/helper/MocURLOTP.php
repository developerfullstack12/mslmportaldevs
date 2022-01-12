<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
if (defined("\x41\x42\x53\120\x41\124\110")) {
    goto Cu;
}
die;
Cu:
class MocURLOTP
{
    public static function create_customer($h4, $Hn, $hs, $fk = '', $RM = '', $RO = '')
    {
        $JX = MoConstants::HOSTNAME . "\57\x6d\x6f\x61\x73\x2f\x72\x65\163\x74\x2f\143\x75\163\x74\x6f\x6d\145\x72\57\x61\144\144";
        $dT = MoConstants::DEFAULT_CUSTOMER_KEY;
        $Ca = MoConstants::DEFAULT_API_KEY;
        $KB = array("\143\157\155\x70\141\x6e\171\116\141\x6d\x65" => $Hn, "\141\x72\145\x61\117\x66\x49\x6e\x74\145\x72\145\x73\x74" => MoConstants::AREA_OF_INTEREST, "\x66\x69\x72\163\164\x6e\x61\155\x65" => $RM, "\154\141\163\164\156\x61\x6d\145" => $RO, "\x65\155\x61\x69\154" => $h4, "\160\x68\x6f\x6e\145" => $fk, "\x70\x61\163\163\x77\x6f\162\144" => $hs);
        $Rn = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public static function get_customer_key($h4, $hs)
    {
        $JX = MoConstants::HOSTNAME . "\x2f\x6d\157\x61\x73\57\162\145\163\164\x2f\143\x75\x73\x74\157\155\145\162\57\x6b\145\x79";
        $dT = MoConstants::DEFAULT_CUSTOMER_KEY;
        $Ca = MoConstants::DEFAULT_API_KEY;
        $KB = array("\145\155\x61\x69\154" => $h4, "\x70\x61\x73\163\167\x6f\162\144" => $hs);
        $Rn = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public static function check_customer($h4)
    {
        $JX = MoConstants::HOSTNAME . "\57\x6d\x6f\141\x73\57\x72\x65\163\x74\57\x63\x75\x73\x74\157\155\145\x72\57\x63\150\145\143\153\x2d\151\146\55\145\x78\151\x73\164\x73";
        $dT = MoConstants::DEFAULT_CUSTOMER_KEY;
        $Ca = MoConstants::DEFAULT_API_KEY;
        $KB = array("\145\155\x61\x69\154" => $h4);
        $Rn = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public static function mo_send_otp_token($x_, $h4 = '', $fk = '')
    {
        $JX = MoConstants::HOSTNAME . "\57\x6d\157\141\x73\57\x61\160\x69\57\141\165\164\150\x2f\143\x68\141\154\154\145\x6e\147\145";
        $dT = !MoUtility::isBlank(get_mo_option("\x61\144\x6d\151\156\x5f\x63\165\x73\x74\157\x6d\145\x72\137\x6b\x65\x79")) ? get_mo_option("\x61\144\155\151\x6e\137\x63\x75\x73\x74\x6f\155\145\162\137\153\145\171") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $Ca = !MoUtility::isBlank(get_mo_option("\x61\144\x6d\x69\x6e\x5f\141\160\151\137\x6b\x65\171")) ? get_mo_option("\x61\x64\155\x69\156\137\141\160\x69\137\x6b\x65\171") : MoConstants::DEFAULT_API_KEY;
        $KB = array("\143\x75\163\164\x6f\155\145\x72\x4b\145\x79" => $dT, "\x65\x6d\x61\x69\x6c" => $h4, "\160\x68\x6f\x6e\145" => $fk, "\141\165\x74\x68\124\171\160\145" => $x_, "\164\x72\x61\x6e\163\x61\x63\164\151\x6f\156\116\141\x6d\145" => MoConstants::AREA_OF_INTEREST);
        $Rn = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public static function validate_otp_token($Ew, $V7)
    {
        $JX = MoConstants::HOSTNAME . "\57\155\157\141\x73\x2f\x61\160\x69\x2f\141\165\164\x68\x2f\166\x61\x6c\x69\144\x61\x74\x65";
        $dT = !MoUtility::isBlank(get_mo_option("\x61\144\155\151\x6e\137\x63\x75\163\x74\157\x6d\145\162\137\x6b\145\171")) ? get_mo_option("\x61\x64\x6d\x69\156\x5f\x63\165\x73\164\157\155\145\x72\x5f\x6b\145\x79") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $Ca = !MoUtility::isBlank(get_mo_option("\x61\144\x6d\151\x6e\137\141\x70\x69\x5f\x6b\x65\x79")) ? get_mo_option("\x61\x64\155\151\156\137\x61\160\151\137\x6b\145\x79") : MoConstants::DEFAULT_API_KEY;
        $KB = array("\164\170\111\x64" => $Ew, "\164\x6f\153\x65\x6e" => $V7);
        $Rn = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public static function submit_contact_us($hd, $YJ, $qn)
    {
        $current_user = wp_get_current_user();
        $JX = MoConstants::HOSTNAME . "\57\x6d\x6f\x61\163\x2f\162\x65\x73\x74\57\143\165\163\x74\157\155\145\x72\x2f\x63\157\156\x74\x61\x63\164\x2d\x75\x73";
        $qn = "\x5b" . MoConstants::AREA_OF_INTEREST . "\40" . "\50" . MoConstants::PLUGIN_TYPE . "\x29" . "\x5d\x3a\40" . $qn;
        $dT = !MoUtility::isBlank(get_mo_option("\x61\144\155\151\x6e\x5f\143\165\x73\x74\157\x6d\145\162\137\x6b\145\x79")) ? get_mo_option("\x61\144\x6d\151\x6e\137\143\x75\x73\164\157\155\145\x72\x5f\153\x65\x79") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $Ca = !MoUtility::isBlank(get_mo_option("\141\144\x6d\x69\156\137\x61\160\151\x5f\x6b\145\171")) ? get_mo_option("\141\144\155\x69\x6e\x5f\141\x70\x69\137\x6b\x65\x79") : MoConstants::DEFAULT_API_KEY;
        $KB = array("\146\x69\162\x73\x74\x4e\141\155\x65" => $current_user->user_firstname, "\x6c\141\x73\x74\116\x61\x6d\x65" => $current_user->user_lastname, "\x63\157\155\x70\141\156\x79" => $_SERVER["\123\x45\x52\x56\105\x52\137\x4e\101\x4d\105"], "\145\x6d\141\x69\x6c" => $hd, "\x63\x63\x45\x6d\141\x69\154" => MoConstants::FEEDBACK_EMAIL, "\160\x68\x6f\x6e\145" => $YJ, "\x71\165\x65\x72\x79" => $qn);
        $F0 = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $F0, $KI);
        return true;
    }
    public static function forgot_password($h4)
    {
        $JX = MoConstants::HOSTNAME . "\x2f\155\157\141\163\57\x72\x65\x73\x74\x2f\143\x75\163\164\157\155\x65\162\x2f\160\141\163\x73\167\157\x72\x64\55\x72\145\163\145\x74";
        $dT = get_mo_option("\141\x64\x6d\x69\156\x5f\143\165\163\164\x6f\x6d\x65\x72\x5f\x6b\x65\171");
        $Ca = get_mo_option("\x61\x64\155\x69\x6e\137\x61\160\x69\x5f\153\x65\x79");
        $KB = array("\x65\x6d\141\x69\x6c" => $h4);
        $Rn = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public static function check_customer_ln($dT, $Ca, $Yi)
    {
        $JX = MoConstants::HOSTNAME . "\57\155\x6f\x61\x73\x2f\162\x65\x73\164\x2f\x63\x75\163\x74\157\x6d\145\162\57\x6c\x69\143\x65\156\163\x65";
        $KB = array("\x63\x75\163\x74\x6f\x6d\x65\162\111\144" => $dT, "\141\x70\x70\154\151\143\x61\164\151\x6f\156\x4e\141\x6d\x65" => $Yi, "\154\x69\143\x65\x6e\x73\x65\x54\171\160\x65" => !MoUtility::micr() ? "\104\x45\x4d\117" : "\x50\122\105\115\111\125\x4d");
        $Rn = json_encode($KB);
        $KI = self::createAuthHeader($dT, $Ca);
        $Re = self::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public static function createAuthHeader($dT, $Ca)
    {
        $wf = self::getTimestamp();
        if (!MoUtility::isBlank($wf)) {
            goto EL;
        }
        $wf = round(microtime(true) * 1000);
        $wf = number_format($wf, 0, '', '');
        EL:
        $g6 = $dT . $wf . $Ca;
        $KI = hash("\x73\150\x61\65\61\62", $g6);
        $w_ = array("\103\157\x6e\x74\x65\x6e\x74\x2d\124\x79\160\x65" => "\x61\160\160\154\151\x63\x61\164\151\x6f\156\x2f\152\163\157\x6e", "\103\165\163\164\157\x6d\x65\x72\55\113\x65\171" => $dT, "\124\151\155\145\x73\x74\141\x6d\x70" => $wf, "\x41\165\x74\150\x6f\162\151\x7a\141\x74\151\x6f\156" => $KI);
        return $w_;
    }
    public static function getTimestamp()
    {
        $JX = MoConstants::HOSTNAME . "\57\x6d\157\141\163\x2f\162\x65\163\164\57\155\x6f\142\151\x6c\145\57\x67\145\x74\x2d\164\x69\x6d\145\163\164\x61\155\x70";
        return self::callAPI($JX, null, null);
    }
    public static function callAPI($JX, $PJ, $i7 = array("\x43\157\156\x74\145\x6e\x74\x2d\124\171\x70\x65" => "\141\160\x70\154\x69\143\141\164\x69\157\156\57\152\x73\x6f\x6e"), $mk = "\120\117\x53\124")
    {
        $LD = array("\x6d\145\x74\150\x6f\x64" => $mk, "\x62\157\144\x79" => $PJ, "\164\151\x6d\x65\157\x75\x74" => "\x31\60\60\x30\60", "\x72\x65\144\x69\x72\x65\143\x74\x69\157\x6e" => "\61\60", "\x68\164\164\160\166\145\x72\163\x69\x6f\x6e" => "\61\x2e\60", "\142\x6c\157\143\153\x69\156\147" => true, "\x68\145\x61\x64\145\x72\163" => $i7, "\x73\x73\154\166\145\x72\x69\146\171" => MOV_SSL_VERIFY);
        $Re = wp_remote_post($JX, $LD);
        if (!is_wp_error($Re)) {
            goto Le;
        }
        wp_die("\123\157\x6d\145\164\x68\x69\x6e\147\x20\x77\x65\156\x74\x20\167\x72\x6f\156\147\x3a\40\x3c\x62\x72\57\76\x20{$Re->get_error_message()}");
        Le:
        return wp_remote_retrieve_body($Re);
    }
    public static function send_notif(NotificationSettings $nZ)
    {
        $tu = GatewayFunctions::instance();
        return $tu->mo_send_notif($nZ);
    }
}
