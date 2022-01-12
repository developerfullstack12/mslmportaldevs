<?php


namespace OTP\Helper;

if (defined("\x41\x42\x53\x50\101\124\x48")) {
    goto ch;
}
die;
ch:
class AEncryption
{
    public static function encrypt_data($iz, $wY)
    {
        $fM = '';
        $Ms = 0;
        b_:
        if (!($Ms < strlen($iz))) {
            goto Y3;
        }
        $xH = substr($iz, $Ms, 1);
        $Bh = substr($wY, $Ms % strlen($wY) - 1, 1);
        $xH = chr(ord($xH) + ord($Bh));
        $fM .= $xH;
        J_:
        $Ms++;
        goto b_;
        Y3:
        return base64_encode($fM);
    }
    public static function decrypt_data($iz, $wY)
    {
        $fM = '';
        $iz = base64_decode($iz);
        $Ms = 0;
        MJ:
        if (!($Ms < strlen($iz))) {
            goto TS;
        }
        $xH = substr($iz, $Ms, 1);
        $Bh = substr($wY, $Ms % strlen($wY) - 1, 1);
        $xH = chr(ord($xH) - ord($Bh));
        $fM .= $xH;
        rG:
        $Ms++;
        goto MJ;
        TS:
        return $fM;
    }
}
