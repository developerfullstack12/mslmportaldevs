<?php


use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Helper\MoUtility;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
$Vs = MoUtility::micr();
$nR = MoUtility::mclv();
$KN = MoUtility::isGatewayConfig();
$Z3 = MoUtility::micv();
$GZ = $Vs && $nR ? '' : "\144\x69\x73\x61\142\x6c\x65\144";
$current_user = wp_get_current_user();
$h4 = get_mo_option("\141\144\x6d\x69\x6e\137\145\155\x61\x69\x6c");
$fk = get_mo_option("\x61\144\155\151\156\137\x70\150\157\156\x65");
$XJ = MOV_DIR . "\x63\157\156\x74\x72\x6f\154\154\145\162\x73\57";
$Uh = MoOTPActionHandlerHandler::instance();
$qZ = TabDetails::instance();
include $XJ . "\x6e\x61\166\142\x61\x72\56\x70\150\160";
echo "\74\144\x69\166\40\x63\x6c\141\x73\163\x3d\47\x6d\x6f\x2d\157\160\x74\x2d\x63\157\156\x74\145\156\x74\47\x3e\xd\xa\x20\40\x20\40\x20\x20\x20\x20\x3c\144\151\x76\x20\151\x64\x3d\47\x6d\x6f\142\x6c\x6f\143\x6b\47\x20\143\154\141\163\163\x3d\47\155\157\x5f\143\x75\x73\x74\x6f\155\x65\162\x5f\x76\x61\154\151\x64\141\164\x69\x6f\156\x2d\155\157\x64\x61\x6c\x2d\x62\x61\143\153\144\x72\157\160\x20\144\x61\163\x68\x62\157\x61\x72\x64\47\76" . "\74\x69\x6d\x67\x20\163\x72\x63\75\47" . MOV_LOADER_URL . "\x27\76" . "\74\57\144\151\x76\x3e";
if (!isset($_GET["\160\x61\147\145"])) {
    goto xh;
}
foreach ($qZ->_tabDetails as $J0) {
    if (!($J0->_menuSlug == $_GET["\x70\141\x67\145"])) {
        goto RL;
    }
    include $XJ . $J0->_view;
    RL:
    Ly:
}
V4:
do_action("\155\157\x5f\157\x74\x70\x5f\x76\145\162\151\x66\x69\143\141\x74\x69\x6f\156\137\x61\x64\x64\137\x6f\156\x5f\143\157\x6e\164\162\157\154\x6c\x65\x72");
include $XJ . "\163\x75\x70\x70\157\162\164\x2e\160\x68\160";
xh:
echo "\74\x2f\x64\x69\166\76";
echo "\x20\x20\40\x3c\144\151\166\x20\x63\x6c\141\x73\163\x3d\x22\155\157\137\157\x74\x70\137\x66\x6f\x6f\x74\145\x72\x22\76\x20\xd\xa\40\40\74\144\x69\x76\x20\143\154\141\x73\x73\x3d\42\155\x6f\x2d\157\164\x70\55\155\x61\151\154\x2d\142\165\x74\x74\157\x6e\42\x3e\xd\xa\x20\x20\74\x69\x6d\147\40\163\162\x63\x3d\42" . MOV_MAIL_LOGO . "\42\x20\143\154\141\x73\163\75\42\163\x68\x6f\x77\137\x73\165\x70\160\x6f\162\x74\x5f\146\157\162\x6d\x22\x20\151\144\75\x22\x68\145\154\160\102\x75\164\164\157\x6e\42\76\x3c\57\144\151\x76\x3e\xd\12\x20\40\74\x62\165\x74\164\157\x6e\40\x74\x79\x70\x65\x3d\42\142\165\x74\164\157\x6e\x22\40\x63\x6c\x61\163\163\x3d\42\155\157\55\157\x74\160\55\x68\145\x6c\x70\x2d\x62\x75\x74\164\x6f\x6e\55\x74\145\170\x74\42\x3e\110\145\154\154\157\40\164\x68\145\x72\145\41\x3c\142\162\x3e\x4e\145\x65\x64\x20\x48\145\154\x70\77\x20\104\162\157\x70\40\x75\x73\40\x61\x6e\x20\105\155\141\x69\x6c\x3c\57\142\x75\x74\x74\157\x6e\76\xd\xa\x20\x20\74\x2f\x64\151\166\76";
