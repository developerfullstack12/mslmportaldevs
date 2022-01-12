<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\x73\x6d\163"), $_SERVER["\122\105\x51\125\105\x53\124\137\125\x52\111"]);
$tX = $eV->getWcOrderPendingNotif();
$Eb = $tX->page . "\x5f\x65\156\x61\142\154\145";
$AB = $tX->page . "\x5f\x73\x6d\163\x62\x6f\x64\171";
$YA = $tX->page . "\x5f\x72\x65\x63\151\160\x69\x65\156\x74";
$FL = $tX->page . "\x5f\x73\145\164\164\151\x6e\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto cX;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcOrderPendingNotif()->setIsEnabled($MO);
$eV->getWcOrderPendingNotif()->setSmsBody($kX);
update_wc_option("\156\x6f\164\x69\146\x69\x63\141\x74\151\157\x6e\137\163\x65\164\x74\151\156\x67\163", $eV);
$tX = $eV->getWcOrderPendingNotif();
cX:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\x63\150\145\x63\153\145\144" : '';
include MSN_DIR . "\57\x76\x69\145\167\x73\x2f\x73\x6d\x73\x6e\157\x74\x69\x66\x69\143\141\164\151\157\156\x73\x2f\x77\143\55\143\165\163\164\157\155\x65\x72\55\x73\x6d\163\55\164\x65\155\160\154\x61\164\x65\x2e\x70\x68\x70";
