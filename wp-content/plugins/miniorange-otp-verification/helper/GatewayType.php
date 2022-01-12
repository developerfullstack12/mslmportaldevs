<?php


namespace OTP\Helper;

if (defined("\x41\102\x53\x50\101\x54\x48")) {
    goto cw;
}
die;
cw:
use OTP\Objects\IGatewayType;
use OTP\Traits\Instance;
class GatewayType implements IGatewayType
{
    use Instance;
    private $gatewayType;
    public function __construct()
    {
        $nF = get_mo_option("\x63\x75\x73\164\157\x6d\145\137\x67\141\x74\145\x77\141\x79\137\164\x79\160\x65");
        $nF = "\x4f\x54\x50\134\x48\145\x6c\x70\145\x72\134\x47\x61\164\145\167\x61\171\134" . ($nF ? $nF : "\115\157\107\x61\164\145\x77\x61\x79\125\x52\114");
        $this->gatewayType = $nF::instance();
    }
    public function handleGatewayResponse($Re, $SF, $fk)
    {
        return $this->gatewayType->handleGatewayResponse($Re, $SF, $fk);
    }
    public function sendOTPRequest($SF, $fk)
    {
        return $this->gatewayType->sendOTPRequest($SF, $fk);
    }
    public function getGatewayConfigView($GZ, $RR)
    {
        return $this->gatewayType->getGatewayConfigView($GZ, $RR);
    }
    public function saveGatewayDetails($zy)
    {
        $this->gatewayType->saveGatewayDetails($zy);
    }
}
