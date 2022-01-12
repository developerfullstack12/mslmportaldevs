<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\x73\x6d\163"), $_SERVER["\122\105\x51\125\x45\x53\x54\x5f\125\122\x49"]);
$tX = $eV->getUmNewCustomerNotif();
$Eb = $tX->page . "\137\x65\x6e\141\142\154\145";
$AB = $tX->page . "\137\x73\155\163\142\x6f\x64\171";
$YA = $tX->page . "\137\162\x65\143\151\160\151\x65\x6e\164";
$FL = $tX->page . "\x5f\163\145\x74\164\151\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto M2;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$TS = $_POST[$YA];
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getUmNewCustomerNotif()->setIsEnabled($MO);
$eV->getUmNewCustomerNotif()->setRecipient($TS);
$eV->getUmNewCustomerNotif()->setSmsBody($kX);
update_umsn_option("\x6e\x6f\x74\151\x66\151\143\141\164\x69\157\x6e\x5f\x73\x65\164\x74\x69\156\x67\x73", $eV);
$tX = $eV->getUmNewCustomerNotif();
M2:
$TS = maybe_unserialize($tX->recipient);
$TS = MoUtility::isBlank($TS) ? "\x6d\157\x62\151\154\x65\x5f\x6e\x75\x6d\142\145\162" : $TS;
$xt = $tX->isEnabled ? "\x63\x68\x65\x63\153\145\x64" : '';
include UMSN_DIR . "\x2f\x76\x69\145\x77\x73\x2f\163\x6d\163\x6e\x6f\x74\151\x66\x69\143\141\x74\151\x6f\x6e\x73\57\x75\155\55\x63\x75\x73\x74\157\x6d\145\162\x2d\x73\155\x73\x2d\164\145\155\x70\x6c\141\x74\145\x2e\x70\x68\x70";
