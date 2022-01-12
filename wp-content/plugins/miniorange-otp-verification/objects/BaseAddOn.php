<?php


namespace OTP\Objects;

abstract class BaseAddOn implements AddOnInterface
{
    function __construct()
    {
        $this->initializeHelpers();
        $this->initializeHandlers();
        add_action("\155\157\137\x6f\164\160\x5f\166\x65\162\x69\x66\151\143\x61\164\x69\157\156\x5f\x61\144\144\x5f\x6f\x6e\x5f\x63\x6f\156\164\162\x6f\x6c\154\x65\162", array($this, "\163\x68\157\x77\x5f\141\144\x64\x6f\x6e\137\x73\x65\164\164\151\x6e\147\x73\137\160\x61\147\145"), 1, 1);
    }
}
