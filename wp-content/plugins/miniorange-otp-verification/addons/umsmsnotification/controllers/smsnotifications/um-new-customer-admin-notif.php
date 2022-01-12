<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\163\155\163"), $_SERVER["\122\x45\121\x55\x45\123\124\x5f\125\x52\111"]);
$tX = $eV->getUmNewUserAdminNotif();
$Eb = $tX->page . "\137\x65\x6e\x61\142\154\x65";
$AB = $tX->page . "\x5f\x73\x6d\x73\142\x6f\144\x79";
$YA = $tX->page . "\137\x72\x65\143\x69\x70\151\145\x6e\x74";
$FL = $tX->page . "\x5f\163\145\164\164\x69\x6e\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto bX;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$TS = serialize(explode("\73", $_POST[$YA]));
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getUmNewUserAdminNotif()->setIsEnabled($MO);
$eV->getUmNewUserAdminNotif()->setRecipient($TS);
$eV->getUmNewUserAdminNotif()->setSmsBody($kX);
update_umsn_option("\x6e\157\x74\151\x66\x69\x63\x61\164\151\157\156\x5f\x73\145\x74\x74\x69\x6e\147\x73", $eV);
$tX = $eV->getUmNewUserAdminNotif();
bX:
$TS = maybe_unserialize($tX->recipient);
$TS = is_array($TS) ? implode("\x3b", $TS) : $TS;
$xt = $tX->isEnabled ? "\143\150\x65\143\153\145\x64" : '';
include UMSN_DIR . "\x2f\166\x69\145\167\163\57\163\155\163\156\157\164\x69\146\151\143\x61\164\151\157\156\163\57\x75\x6d\55\141\x64\x6d\x69\156\x2d\163\x6d\x73\x2d\164\145\155\x70\154\141\x74\x65\56\160\150\160";
