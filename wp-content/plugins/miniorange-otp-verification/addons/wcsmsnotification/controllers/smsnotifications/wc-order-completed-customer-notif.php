<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\163\155\x73"), $_SERVER["\x52\105\x51\x55\105\123\124\137\125\x52\x49"]);
$tX = $eV->getWcOrderCompletedNotif();
$Eb = $tX->page . "\x5f\145\156\x61\142\154\x65";
$AB = $tX->page . "\137\163\155\x73\142\x6f\x64\171";
$YA = $tX->page . "\x5f\x72\145\143\x69\160\x69\145\x6e\164";
$FL = $tX->page . "\x5f\x73\x65\x74\x74\x69\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto HN;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcOrderCompletedNotif()->setIsEnabled($MO);
$eV->getWcOrderCompletedNotif()->setSmsBody($kX);
update_wc_option("\156\x6f\164\151\146\151\x63\x61\x74\151\157\156\137\x73\x65\x74\x74\151\156\147\163", $eV);
$tX = $eV->getWcOrderCompletedNotif();
HN:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\x63\150\x65\x63\x6b\x65\144" : '';
include MSN_DIR . "\x2f\x76\151\x65\x77\x73\57\x73\155\x73\x6e\x6f\x74\151\146\x69\x63\x61\164\x69\x6f\156\x73\x2f\167\x63\55\x63\x75\x73\164\157\x6d\145\x72\55\163\155\x73\x2d\x74\x65\155\x70\x6c\141\x74\145\x2e\160\150\x70";
