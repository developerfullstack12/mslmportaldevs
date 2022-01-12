<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
use OTP\Helper\MoOTPDocs;
class UMPasswordResetAddOnHandler extends BaseAddOnHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto dU;
        }
        return;
        dU:
        UMPasswordResetHandler::instance();
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x75\x6d\x5f\160\x61\x73\x73\137\x72\145\163\145\164\x5f\141\144\x64\x6f\x6e";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\x41\154\154\x6f\167\163\x20\x79\157\165\162\x20\165\x73\145\x72\163\x20\164\157\x20\x72\145\163\x65\164\40\x74\150\145\151\x72\x20\160\141\x73\163\167\x6f\x72\x64\x20\x75\163\x69\x6e\x67\x20\x4f\x54\x50\x20\151\156\x73\164\145\x61\x64\40\157\146\40\145\x6d\x61\151\154\x20\154\151\156\x6b\163\x2e" . "\x43\154\x69\x63\x6b\x20\157\x6e\40\164\x68\x65\x20\163\145\164\164\151\x6e\147\x73\x20\142\x75\164\164\157\x6e\40\x74\x6f\40\x74\x68\145\40\162\151\x67\150\164\x20\164\157\x20\143\x6f\x6e\x66\151\x67\x75\162\145\40\x73\145\164\x74\x69\156\147\x73\40\x66\x6f\162\x20\x74\x68\145\x20\163\141\x6d\145\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\125\154\x74\x69\155\x61\x74\x65\x20\115\x65\155\x62\145\162\40\x50\x61\x73\x73\x77\157\x72\x64\40\x52\x65\x73\x65\x74\x20\117\166\x65\x72\40\x4f\x54\120");
    }
    function setAddOnDocs()
    {
        $this->_addOnDocs = MoOTPDocs::ULTIMATEMEMBER_PASSWORD_RESET_ADDON_LINK["\x67\165\151\144\145\x4c\151\x6e\x6b"];
    }
    function setAddOnVideo()
    {
        $this->_addOnVideo = MoOTPDocs::ULTIMATEMEMBER_PASSWORD_RESET_ADDON_LINK["\x76\x69\144\145\x6f\x4c\151\156\x6b"];
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\144\144\157\156" => "\165\x6d\x70\x72\x5f\156\x6f\164\151\x66"), $_SERVER["\122\x45\121\x55\x45\123\x54\x5f\125\122\x49"]);
    }
}
