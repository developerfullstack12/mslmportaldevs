<?php


use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\MoUtility;
$eV = get_wc_option("\156\157\x74\x69\x66\x69\143\141\164\x69\157\x6e\x5f\163\145\x74\164\151\156\x67\x73");
$eV = $eV ? maybe_unserialize($eV) : WooCommerceNotificationsList::instance();
$kX = '';
if (isset($_GET["\163\x6d\x73"])) {
    goto uE;
}
include MSN_DIR . "\57\x76\x69\145\x77\x73\57\167\143\x2d\x73\x6d\x73\55\x6e\x6f\164\151\146\151\143\x61\164\x69\157\156\x2e\160\150\160";
goto Xv;
uE:
$kX = $_GET["\x73\x6d\163"];
$PT = $XJ . "\57\163\155\x73\x6e\157\x74\x69\146\151\143\141\x74\151\157\x6e\x73\x2f";
switch ($_GET["\x73\x6d\163"]) {
    case "\x77\x63\137\156\145\167\x5f\x63\x75\x73\164\x6f\x6d\145\x72\x5f\x6e\x6f\x74\151\146":
        include $PT . "\x77\x63\55\156\145\x77\x2d\143\165\163\x74\157\x6d\x65\x72\55\x6e\157\x74\151\x66\x2e\160\150\160";
        goto GD;
    case "\x77\143\x5f\143\x75\x73\x74\157\x6d\145\x72\137\x6e\x6f\x74\145\x5f\156\157\x74\x69\x66":
        include $PT . "\167\x63\x2d\x63\x75\163\x74\157\155\145\162\55\156\157\x74\x65\x2d\156\x6f\164\x69\x66\x2e\160\x68\x70";
        goto GD;
    case "\167\143\x5f\157\162\x64\x65\162\137\143\x61\156\x63\x65\x6c\154\145\144\x5f\x6e\x6f\x74\x69\146":
        include $PT . "\x77\x63\x2d\x6f\162\x64\x65\x72\x2d\143\x61\x6e\143\x65\154\154\x65\x64\x2d\143\165\163\x74\157\155\145\162\x2d\x6e\x6f\164\x69\x66\56\160\x68\x70";
        goto GD;
    case "\167\x63\137\x6f\162\144\x65\x72\137\x63\x6f\155\160\x6c\x65\164\145\144\137\156\157\164\151\x66":
        include $PT . "\167\143\x2d\x6f\x72\x64\145\x72\55\143\157\x6d\160\154\145\164\x65\x64\55\143\165\x73\x74\157\155\x65\162\55\156\157\164\x69\x66\56\x70\x68\160";
        goto GD;
    case "\167\143\x5f\x6f\x72\144\x65\162\x5f\146\141\151\x6c\x65\144\x5f\156\x6f\x74\x69\x66":
        include $PT . "\167\x63\55\x6f\162\x64\x65\162\55\x66\x61\151\154\145\x64\x2d\x63\165\163\164\x6f\x6d\x65\x72\55\156\x6f\x74\151\x66\56\160\x68\160";
        goto GD;
    case "\x77\143\137\157\162\144\145\162\137\157\x6e\x5f\x68\157\154\x64\137\156\157\164\x69\146":
        include $PT . "\167\x63\x2d\157\x72\x64\x65\162\x2d\157\156\x68\157\154\x64\55\x63\x75\x73\164\x6f\x6d\145\x72\55\156\x6f\164\x69\x66\x2e\x70\150\160";
        goto GD;
    case "\167\x63\x5f\157\162\144\145\162\x5f\x70\162\x6f\143\145\163\163\x69\x6e\147\137\156\157\x74\151\x66":
        include $PT . "\167\x63\x2d\x6f\x72\x64\145\x72\55\160\162\157\x63\x65\x73\163\x69\156\x67\55\143\x75\163\x74\x6f\155\x65\x72\x2d\x6e\157\164\151\x66\x2e\160\x68\x70";
        goto GD;
    case "\167\x63\x5f\157\x72\144\x65\162\137\162\145\146\165\x6e\x64\145\x64\x5f\156\157\164\151\146":
        include $PT . "\x77\143\x2d\x6f\x72\144\x65\x72\55\162\x65\146\x75\x6e\144\x65\144\x2d\x63\165\163\x74\157\155\145\x72\x2d\156\157\x74\151\x66\56\160\150\x70";
        goto GD;
    case "\167\143\x5f\141\x64\x6d\151\156\137\x6f\x72\144\145\x72\x5f\163\x74\141\x74\x75\x73\137\x6e\x6f\x74\x69\146":
        include $PT . "\167\143\55\157\x72\x64\145\162\x2d\x73\164\x61\164\165\163\x2d\141\x64\155\151\156\x2d\156\x6f\164\x69\x66\x2e\160\150\160";
        goto GD;
    case "\167\x63\x5f\157\x72\x64\x65\x72\x5f\x70\145\156\144\151\x6e\147\137\x6e\157\x74\151\146":
        include $PT . "\167\x63\55\x6f\162\x64\x65\162\55\x70\x65\156\x64\151\x6e\x67\x2d\x63\165\x73\164\157\155\x65\x72\x2d\156\157\164\151\146\x2e\160\x68\160";
        goto GD;
}
CH:
GD:
Xv:
function show_notifications_table(WooCommerceNotificationsList $uu)
{
    foreach ($uu as $ME => $NR) {
        $JX = add_query_arg(array("\x73\x6d\163" => $NR->page), $_SERVER["\x52\105\121\125\x45\123\124\137\x55\122\111"]);
        echo "\11\74\x74\162\76\xd\xa\x20\x20\40\40\x20\40\40\40\x20\x20\x20\40\x20\40\40\x20\40\x20\40\x20\74\164\x64\x20\143\154\141\x73\x73\x3d\x22\155\x73\156\x2d\164\x61\142\x6c\145\x2d\x6c\151\163\x74\55\x73\164\141\164\165\163\x22\x3e\xd\xa\x20\x20\40\40\40\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\x3c\163\160\141\156\40\x63\x6c\x61\x73\x73\75\x22" . ($NR->isEnabled ? "\163\164\x61\x74\x75\x73\55\x65\156\x61\142\154\x65\144" : '') . "\42\76\x3c\x2f\163\160\141\156\x3e\15\xa\40\40\x20\40\40\x20\40\x20\x20\40\x20\x20\40\40\x20\40\x20\40\40\x20\x3c\x2f\x74\144\x3e\xd\12\x20\x20\40\40\x20\40\40\40\x20\x20\x20\40\40\x20\x20\40\x20\x20\40\x20\x3c\164\144\x20\143\154\141\163\163\x3d\x22\x6d\x73\156\x2d\x74\141\x62\154\145\55\154\x69\163\x74\x2d\x6e\x61\155\x65\42\x3e\15\xa\40\40\40\x20\x20\x20\x20\40\x20\40\40\x20\x20\40\40\40\40\x20\40\x20\x20\x20\x20\x20\74\x61\x20\150\162\x65\x66\75\42" . $JX . "\x22\76" . $NR->title . "\74\x2f\141\76";
        mo_draw_tooltip(MoWcAddOnMessages::showMessage($NR->tooltipHeader), MoWcAddOnMessages::showMessage($NR->tooltipBody));
        echo "\x9\x9\x3c\57\164\x64\x3e\15\xa\40\40\x20\x20\x20\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\x20\x3c\164\144\x20\143\154\141\163\163\x3d\42\155\x73\156\x2d\x74\x61\x62\154\145\55\x6c\x69\163\x74\x2d\162\145\x63\x69\160\x69\145\x6e\164\x22\x20\163\x74\x79\x6c\x65\x3d\42\x77\x6f\162\x64\55\x77\x72\x61\x70\72\40\142\x72\145\x61\x6b\55\167\x6f\162\x64\x3b\x22\x3e\xd\xa\40\40\40\x20\40\x20\x20\x20\x20\40\40\40\x20\40\40\x20\40\40\x20\x20\40\x20\40\x20" . $NR->notificationType . "\15\12\40\40\x20\40\x20\x20\x20\x20\x20\x20\40\x20\x20\40\x20\40\40\40\x20\x20\74\57\x74\144\x3e\15\xa\x20\x20\x20\x20\40\40\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\x20\x20\x3c\164\144\x20\143\154\x61\163\x73\x3d\42\155\163\156\x2d\x74\x61\x62\x6c\145\x2d\x6c\151\x73\x74\55\163\164\141\x74\165\163\x2d\141\x63\164\151\x6f\x6e\163\x22\x3e\15\12\x20\40\40\x20\x20\x20\x20\40\40\40\40\40\40\40\40\x20\x20\x20\40\x20\40\x20\x20\x20\74\141\x20\x63\154\141\163\163\75\42\142\x75\x74\x74\157\156\40\x61\154\x69\147\156\x72\151\x67\x68\x74\40\x74\x69\x70\x73\x22\40\x68\x72\145\146\x3d\x22" . $JX . "\42\76\103\157\x6e\x66\x69\x67\165\162\145\74\57\x61\76\15\12\40\x20\x20\40\40\x20\x20\40\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\40\x3c\57\x74\x64\76\15\12\x20\40\x20\x20\x20\40\40\40\x20\40\x20\x20\x20\40\40\x20\x3c\x2f\164\x72\76";
        GK:
    }
    W3:
}
