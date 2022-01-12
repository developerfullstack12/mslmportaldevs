<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\x73\155\x73"), $_SERVER["\122\105\121\x55\x45\x53\x54\x5f\x55\x52\x49"]);
$tX = $eV->getWcOrderOnHoldNotif();
$Eb = $tX->page . "\x5f\x65\x6e\141\x62\154\x65";
$AB = $tX->page . "\137\163\x6d\x73\x62\157\144\171";
$YA = $tX->page . "\137\162\x65\x63\151\x70\151\x65\156\x74";
$FL = $tX->page . "\x5f\163\x65\164\x74\x69\x6e\147\163";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto b1;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcOrderOnHoldNotif()->setIsEnabled($MO);
$eV->getWcOrderOnHoldNotif()->setSmsBody($kX);
update_wc_option("\x6e\x6f\x74\x69\x66\151\143\141\164\x69\157\156\137\x73\145\x74\x74\151\156\x67\x73", $eV);
$tX = $eV->getWcOrderOnHoldNotif();
b1:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\143\x68\145\x63\153\145\x64" : '';
include MSN_DIR . "\57\166\151\x65\x77\163\x2f\x73\x6d\163\156\x6f\164\151\146\x69\143\x61\164\x69\x6f\156\x73\x2f\167\x63\x2d\x63\x75\x73\x74\x6f\155\145\162\x2d\163\155\163\55\164\x65\155\160\x6c\x61\x74\145\56\x70\x68\x70";
