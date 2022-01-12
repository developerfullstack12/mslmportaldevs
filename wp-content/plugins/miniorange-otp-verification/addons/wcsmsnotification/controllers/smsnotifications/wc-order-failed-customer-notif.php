<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\163\x6d\163"), $_SERVER["\x52\105\x51\x55\105\123\x54\137\125\122\x49"]);
$tX = $eV->getWcOrderFailedNotif();
$Eb = $tX->page . "\x5f\x65\156\x61\142\154\145";
$AB = $tX->page . "\x5f\x73\155\163\x62\x6f\144\x79";
$YA = $tX->page . "\x5f\x72\145\x63\151\160\x69\x65\156\164";
$FL = $tX->page . "\x5f\x73\x65\x74\x74\x69\156\147\163";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto OC;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcOrderFailedNotif()->setIsEnabled($MO);
$eV->getWcOrderFailedNotif()->setSmsBody($kX);
update_wc_option("\156\157\164\151\x66\x69\143\141\x74\x69\x6f\156\137\x73\x65\x74\164\151\x6e\147\x73", $eV);
$tX = $eV->getWcOrderFailedNotif();
OC:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\143\150\145\143\x6b\145\144" : '';
include MSN_DIR . "\x2f\x76\x69\x65\167\163\57\x73\x6d\x73\156\157\164\x69\146\151\x63\x61\x74\151\157\x6e\163\x2f\x77\x63\55\143\165\x73\x74\x6f\155\x65\x72\x2d\x73\155\163\x2d\164\145\x6d\160\154\x61\x74\x65\56\160\150\160";
