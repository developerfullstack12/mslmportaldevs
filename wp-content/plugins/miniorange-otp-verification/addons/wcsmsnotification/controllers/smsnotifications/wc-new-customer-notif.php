<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\x73\x6d\x73"), $_SERVER["\122\105\121\125\105\x53\124\x5f\125\x52\x49"]);
$tX = $eV->getWcNewCustomerNotif();
$Eb = $tX->page . "\x5f\145\x6e\x61\x62\154\145";
$AB = $tX->page . "\x5f\163\x6d\163\142\x6f\x64\x79";
$YA = $tX->page . "\x5f\x72\x65\x63\151\x70\x69\145\x6e\164";
$FL = $tX->page . "\137\x73\145\x74\x74\x69\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto ax;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcNewCustomerNotif()->setIsEnabled($MO);
$eV->getWcNewCustomerNotif()->setSmsBody($kX);
update_wc_option("\x6e\157\x74\x69\x66\x69\143\x61\164\151\x6f\x6e\x5f\x73\145\x74\x74\151\156\147\163", $eV);
$tX = $eV->getWcNewCustomerNotif();
ax:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\143\150\145\143\153\145\144" : '';
include MSN_DIR . "\x2f\x76\151\145\x77\163\57\163\x6d\163\x6e\157\164\x69\146\x69\143\x61\164\151\x6f\x6e\x73\x2f\167\x63\x2d\143\165\x73\x74\x6f\155\x65\x72\x2d\x73\155\163\55\164\x65\155\160\x6c\141\164\x65\56\160\150\x70";
