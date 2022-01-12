<?php


namespace OTP\Objects;

interface IGatewayType
{
    public function handleGatewayResponse($Re, $SF, $fk);
    public function sendOTPRequest($SF, $fk);
    public function getGatewayConfigView($GZ, $RR);
    public function saveGatewayDetails($zy);
}
