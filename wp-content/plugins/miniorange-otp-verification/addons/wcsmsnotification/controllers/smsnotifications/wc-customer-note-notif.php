<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\163\x6d\x73"), $_SERVER["\x52\105\121\x55\x45\123\124\x5f\125\122\111"]);
$tX = $eV->getWcCustomerNoteNotif();
$Eb = $tX->page . "\137\x65\156\141\142\x6c\145";
$AB = $tX->page . "\x5f\163\155\x73\142\x6f\144\x79";
$YA = $tX->page . "\x5f\162\145\x63\x69\160\x69\x65\x6e\164";
$FL = $tX->page . "\137\163\145\x74\164\x69\x6e\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto uz;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcCustomerNoteNotif()->setIsEnabled($MO);
$eV->getWcCustomerNoteNotif()->setSmsBody($kX);
update_wc_option("\x6e\x6f\x74\151\146\151\143\141\164\151\157\156\137\x73\145\x74\164\151\x6e\147\163", $eV);
$tX = $eV->getWcCustomerNoteNotif();
uz:
$TS = $tX->recipient;
$xt = $tX->isEnabled ? "\143\x68\145\x63\x6b\x65\144" : '';
include MSN_DIR . "\x2f\x76\151\145\x77\x73\57\x73\x6d\163\x6e\x6f\164\151\146\151\x63\x61\x74\x69\157\x6e\163\57\x77\x63\x2d\x63\165\x73\164\157\x6d\145\x72\x2d\163\x6d\x73\55\x74\x65\155\x70\x6c\141\x74\x65\56\160\x68\160";
