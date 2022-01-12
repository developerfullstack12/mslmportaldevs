<?php


namespace OTP\Helper\Gateway;

if (defined("\x41\102\123\x50\101\x54\110")) {
    goto Qz;
}
die;
Qz:
use OTP\Objects\IGatewayType;
use OTP\Traits\Instance;
use OTP\Helper\GatewayType;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoConstants;
use OTP\Objects\NotificationSettings;
class MoGateway implements IGatewayType
{
    use Instance;
    private $gateway_url;
    public $_gatewayName;
    public function __construct()
    {
        $this->_gatewayName = "\x6d\x69\156\151\117\162\141\x6e\147\145\x20\107\x61\164\145\x77\x61\171";
    }
    public function sendOTPRequest($SF, $fk)
    {
        $SF = str_replace("\40", "\53", $SF);
        $JX = MoConstants::HOSTNAME . "\x2f\x6d\157\x61\163\57\x61\160\x69\57\x6e\x6f\164\x69\x66\x79\57\x73\x65\x6e\x64";
        $dT = get_mo_option("\x61\x64\155\151\x6e\x5f\x63\165\x73\x74\157\155\x65\x72\137\x6b\145\171");
        $Ca = get_mo_option("\x61\x64\155\x69\x6e\137\141\160\151\x5f\153\x65\171");
        $KB = array("\143\x75\x73\x74\157\155\x65\x72\x4b\x65\x79" => $dT, "\x73\145\x6e\x64\105\155\x61\x69\154" => false, "\x73\145\156\x64\123\x4d\123" => true, "\163\x6d\x73" => array("\143\165\163\164\157\x6d\145\x72\113\145\171" => $dT, "\160\x68\x6f\x6e\x65\116\x75\155\x62\x65\x72" => $fk, "\155\145\x73\x73\x61\x67\x65" => $SF));
        $Rn = json_encode($KB);
        $KI = MocURLOTP::createAuthHeader($dT, $Ca);
        $Re = MocURLOTP::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public function sendEmailOTPRequest($SF, $h4, $s0, $Rk, $dB)
    {
        $JX = MoConstants::HOSTNAME . "\57\x6d\x6f\x61\x73\x2f\141\160\x69\x2f\x6e\x6f\164\151\146\171\x2f\x73\x65\156\x64";
        $dT = get_mo_option("\141\144\x6d\151\156\137\143\165\163\x74\157\x6d\x65\x72\x5f\x6b\145\171");
        $Ca = get_mo_option("\x61\x64\x6d\151\156\x5f\141\x70\151\137\153\145\x79");
        $KB = array("\143\x75\x73\164\x6f\x6d\x65\162\x4b\145\171" => $dT, "\x73\x65\156\144\105\155\141\x69\154" => true, "\163\x65\156\x64\123\115\123" => false, "\x65\x6d\x61\x69\154" => array("\143\165\x73\164\157\155\145\162\x4b\x65\x79" => $dT, "\146\x72\x6f\155\105\x6d\141\x69\x6c" => $s0, "\x62\143\143\105\155\141\151\154" => $i3, "\x66\x72\x6f\155\116\x61\155\145" => $dB, "\164\x6f\x45\x6d\141\x69\154" => $h4, "\x74\157\x4e\x61\155\145" => $h4, "\x73\x75\x62\x6a\x65\x63\164" => $Rk, "\x63\x6f\156\x74\x65\x6e\164" => $SF));
        $Rn = json_encode($KB);
        $KI = MocURLOTP::createAuthHeader($dT, $Ca);
        $Re = MocURLOTP::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public function handleGatewayResponse($Re, $SF, $fk)
    {
        return apply_filters("\x6d\x6f\x5f\143\x75\163\x74\157\x6d\x5f\x67\x61\x74\145\x77\x61\x79\x5f\x72\x65\163\x70\157\156\x73\145", $Re, $SF, $fk);
    }
    public function getGatewayConfigView($GZ, $RR)
    {
        return "\74\x64\151\166\40\x63\x6c\141\x73\x73\x3d\x22\155\157\137\157\x74\160\137\x6e\x6f\x74\x65\x22\76\xd\12\40\x20\x20\40\x20\x20\40\x20\40\x20\x20\40\x20\x20\40\x20\40\x20\x20\x20\74\x69\x3e\74\x73\160\x61\156\40\163\164\x79\x6c\x65\75\42\143\x6f\x6c\x6f\162\x3a\x67\x72\145\171\73\x22\76\106\157\162\40\x6d\157\x72\x65\40\151\156\x66\157\x2c\x20\160\x6c\145\x61\163\x65\40\x63\157\x6e\x74\141\x63\164\x20\74\x61\40\157\156\103\x6c\151\143\x6b\75\42\x6f\x74\160\123\x75\x70\160\157\x72\164\117\156\x43\154\151\x63\153\50\51\73\x22\x3e\74\x75\x3e\x20\x6f\164\x70\x73\x75\160\x70\x6f\162\x74\100\x78\145\143\165\162\151\146\171\56\143\x6f\155\x3c\x2f\x75\76\74\x2f\x61\x3e\74\57\163\x70\141\x6e\x3e\74\57\x69\x3e\xd\xa\x20\40\x20\40\x20\40\40\x20\40\40\40\40\40\40\40\x20\74\57\x64\x69\x76\x3e";
    }
    public function saveGatewayDetails($zy)
    {
    }
}
