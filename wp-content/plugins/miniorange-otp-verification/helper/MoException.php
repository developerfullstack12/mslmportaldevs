<?php


namespace OTP\Helper;

if (defined("\101\102\x53\x50\x41\x54\x48")) {
    goto Cv;
}
die;
Cv:
class MoException extends \Exception
{
    private $moCode;
    public function __construct($OY, $SF, $fS)
    {
        $this->moCode = $OY;
        parent::__construct($SF, $fS, NULL);
    }
    public function getMoCode()
    {
        return $this->moCode;
    }
}
