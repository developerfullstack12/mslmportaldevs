<?php


namespace OTP\Helper\Gateway;

if (defined("\x41\102\123\x50\101\x54\110")) {
    goto p4;
}
die;
p4:
use OTP\Objects\IGatewayType;
use OTP\Traits\Instance;
use OTP\Helper\GatewayType;
use OTP\Helper\Gateway\MoGatewayURL;
class MoMSG91Request implements IGatewayType
{
    use Instance;
    private $gateway;
    public $_gatewayName;
    public function __construct()
    {
        $this->_gatewayName = "\115\x53\x47\x39\61";
        $this->gateway = MoGatewayURL::instance();
    }
    public function sendOTPRequest($SF, $fk)
    {
        $Re = $this->gateway->sendOTPRequest($SF, $fk);
        return $Re;
    }
    public function handleGatewayResponse($Re, $SF, $fk)
    {
        $Re = apply_filters("\155\157\137\x63\165\163\164\157\x6d\137\x67\141\x74\x65\167\141\x79\137\162\x65\x73\160\157\156\163\145", $Re, $SF, $fk);
        return $Re;
    }
    public function getGatewayConfigView($GZ, $RR)
    {
        return $this->gateway->getGatewayConfigView($GZ, $RR);
    }
    public function saveGatewayDetails($zy)
    {
        $Re = $this->gateway->saveGatewayDetails($zy);
    }
}
