<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\163\155\x73"), $_SERVER["\x52\105\x51\125\x45\x53\x54\137\125\x52\111"]);
$tX = $eV->getWcOrderCancelledNotif();
$Eb = $tX->page . "\x5f\x65\156\141\142\x6c\145";
$AB = $tX->page . "\x5f\163\155\x73\x62\x6f\144\171";
$YA = $tX->page . "\x5f\x72\x65\143\151\x70\x69\x65\156\x74";
$FL = $tX->page . "\x5f\163\x65\164\x74\x69\156\147\163";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto F6;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcOrderCancelledNotif()->setIsEnabled($MO);
$eV->getWcOrderCancelledNotif()->setSmsBody($kX);
update_wc_option("\156\x6f\164\151\146\151\x63\141\x74\x69\x6f\156\137\163\x65\x74\x74\x69\156\x67\x73", $eV);
$tX = $eV->getWcOrderCancelledNotif();
F6:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\143\x68\145\x63\x6b\x65\144" : '';
include MSN_DIR . "\57\x76\151\145\x77\163\57\163\x6d\x73\156\157\x74\x69\146\x69\x63\x61\164\151\157\156\x73\x2f\x77\x63\55\143\x75\x73\164\157\x6d\x65\x72\x2d\163\155\x73\x2d\164\x65\x6d\160\154\141\x74\145\x2e\160\x68\160";
