<?php


namespace OTP\Addons\PasswordReset;

use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\x42\x53\120\101\x54\x48")) {
    goto iX;
}
die;
iX:
include "\137\141\165\164\157\154\x6f\141\x64\56\x70\x68\x70";
final class UltimateMemberPasswordReset extends BaseAddOn implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\x64\155\x69\x6e\x5f\145\156\161\165\145\x75\145\137\x73\x63\x72\151\x70\x74\x73", array($this, "\165\x6d\137\x70\x72\x5f\x6e\157\164\x69\x66\137\x73\x65\x74\164\151\x6e\147\x73\137\x73\x74\171\154\145"));
        add_action("\x6d\157\x5f\157\x74\x70\137\x76\x65\x72\x69\146\x69\x63\141\x74\151\157\156\137\x64\145\x6c\145\x74\x65\137\x61\144\144\157\x6e\137\x6f\x70\x74\x69\x6f\x6e\x73", array($this, "\165\x6d\137\160\x72\137\156\x6f\164\x69\x66\137\x64\145\154\x65\164\x65\137\x6f\x70\x74\x69\157\156\x73"));
    }
    function um_pr_notif_settings_style()
    {
        wp_enqueue_style("\x75\x6d\x5f\x70\162\x5f\156\157\x74\x69\x66\137\141\144\155\151\x6e\137\x73\145\164\x74\x69\156\147\x73\137\163\x74\171\x6c\x65", UMPR_CSS_URL);
    }
    function initializeHandlers()
    {
        $D6 = AddOnList::instance();
        $GD = UMPasswordResetAddOnHandler::instance();
        $D6->add($GD->getAddOnKey(), $GD);
    }
    function initializeHelpers()
    {
        UMPasswordResetMessages::instance();
    }
    function show_addon_settings_page()
    {
        include UMPR_DIR . "\143\157\156\x74\x72\x6f\154\x6c\145\x72\x73\57\x6d\141\x69\x6e\55\x63\x6f\x6e\x74\x72\x6f\154\154\x65\162\x2e\160\x68\160";
    }
    function um_pr_notif_delete_options()
    {
        delete_site_option("\x6d\x6f\x5f\x75\x6d\x5f\160\x72\137\x70\141\x73\163\137\145\156\x61\x62\154\x65");
        delete_site_option("\x6d\x6f\x5f\165\x6d\x5f\160\162\x5f\160\141\163\x73\137\142\x75\164\x74\157\x6e\137\164\x65\170\x74");
        delete_site_option("\x6d\157\x5f\x75\x6d\137\160\162\x5f\x65\x6e\141\x62\154\145\x64\137\x74\171\x70\x65");
    }
}
