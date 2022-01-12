<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\163\155\x73"), $_SERVER["\122\105\x51\125\x45\123\x54\x5f\x55\122\111"]);
$tX = $eV->getWcOrderRefundedNotif();
$Eb = $tX->page . "\137\145\x6e\141\x62\154\145";
$AB = $tX->page . "\x5f\x73\x6d\x73\x62\157\144\171";
$YA = $tX->page . "\137\x72\x65\143\x69\160\151\x65\156\x74";
$FL = $tX->page . "\x5f\x73\145\x74\x74\x69\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto IN;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcOrderRefundedNotif()->setIsEnabled($MO);
$eV->getWcOrderRefundedNotif()->setSmsBody($kX);
update_wc_option("\x6e\157\164\151\x66\151\143\141\x74\151\x6f\156\137\x73\145\164\x74\x69\x6e\x67\x73", $eV);
$tX = $eV->getWcOrderRefundedNotif();
IN:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\143\150\x65\143\x6b\x65\x64" : '';
include MSN_DIR . "\x2f\166\x69\x65\167\163\x2f\x73\155\163\x6e\x6f\x74\x69\x66\x69\x63\141\164\151\x6f\156\x73\x2f\x77\x63\x2d\143\165\163\164\x6f\x6d\x65\x72\55\163\x6d\x73\x2d\x74\x65\155\x70\x6c\141\x74\145\56\x70\150\160";
