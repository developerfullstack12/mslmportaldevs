<?php


namespace OTP\Addons\CustomMessage;

use OTP\Addons\CustomMessage\Handler\CustomMessages;
use OTP\Addons\CustomMessage\Handler\CustomMessagesShortcode;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\x42\123\120\101\124\x48")) {
    goto jj;
}
die;
jj:
include "\x5f\x61\165\164\x6f\x6c\x6f\x61\144\x2e\x70\150\160";
class MiniOrangeCustomMessage extends BaseAddOn implements AddOnInterface
{
    use Instance;
    function initializeHandlers()
    {
        $D6 = AddOnList::instance();
        $GD = CustomMessages::instance();
        $D6->add($GD->getAddOnKey(), $GD);
    }
    function initializeHelpers()
    {
        CustomMessagesShortcode::instance();
    }
    function show_addon_settings_page()
    {
        include MCM_DIR . "\143\157\x6e\x74\162\x6f\x6c\x6c\145\x72\x73\x2f\155\141\151\x6e\55\143\157\156\x74\x72\x6f\154\x6c\x65\x72\56\x70\150\160";
    }
}
