<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\163\x6d\163"), $_SERVER["\x52\105\x51\x55\x45\x53\124\x5f\125\122\111"]);
$tX = $eV->getWcOrderProcessingNotif();
$Eb = $tX->page . "\x5f\x65\x6e\141\x62\154\145";
$AB = $tX->page . "\137\163\155\x73\x62\x6f\144\171";
$YA = $tX->page . "\137\x72\145\143\x69\x70\151\x65\156\164";
$FL = $tX->page . "\x5f\163\145\164\x74\151\156\147\163";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto O2;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcOrderProcessingNotif()->setIsEnabled($MO);
$eV->getWcOrderProcessingNotif()->setSmsBody($kX);
update_wc_option("\156\x6f\164\151\x66\151\x63\141\x74\151\157\156\137\x73\x65\164\164\151\156\x67\x73", $eV);
$tX = $eV->getWcOrderProcessingNotif();
O2:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\143\x68\145\143\x6b\145\144" : '';
include MSN_DIR . "\57\x76\151\x65\167\163\x2f\163\x6d\163\156\157\164\x69\146\x69\143\141\164\x69\x6f\x6e\x73\x2f\167\x63\55\x63\x75\163\x74\157\x6d\x65\x72\55\x73\x6d\163\55\x74\x65\155\160\x6c\141\x74\145\x2e\x70\x68\160";
