<?php


use OTP\Helper\MoUtility;
$bY = remove_query_arg(array("\x73\155\163"), $_SERVER["\x52\105\x51\125\x45\x53\124\x5f\x55\122\x49"]);
$tX = $eV->getWcAdminOrderStatusNotif();
$Eb = $tX->page . "\137\145\156\141\x62\154\x65";
$AB = $tX->page . "\x5f\x73\155\163\142\157\x64\171";
$YA = $tX->page . "\x5f\x72\x65\143\x69\160\x69\x65\x6e\x74";
$FL = $tX->page . "\137\x73\x65\164\x74\x69\156\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($FL)) {
    goto cu;
}
$MO = array_key_exists($Eb, $_POST) ? TRUE : FALSE;
$YA = serialize(explode("\x3b", $_POST[$YA]));
$kX = MoUtility::isBlank($_POST[$AB]) ? $tX->defaultSmsBody : $_POST[$AB];
$eV->getWcAdminOrderStatusNotif()->setIsEnabled($MO);
$eV->getWcAdminOrderStatusNotif()->setRecipient($YA);
$eV->getWcAdminOrderStatusNotif()->setSmsBody($kX);
update_wc_option("\x6e\x6f\164\x69\x66\x69\x63\141\x74\151\x6f\x6e\137\x73\x65\164\x74\x69\x6e\x67\x73", $eV);
$tX = $eV->getWcAdminOrderStatusNotif();
cu:
$TS = maybe_unserialize($tX->recipient);
$TS = is_array($TS) ? implode("\73", $TS) : $TS;
$xt = $tX->isEnabled ? "\x63\150\x65\143\x6b\145\x64" : '';
include MSN_DIR . "\57\x76\x69\145\x77\163\57\x73\x6d\x73\x6e\157\x74\x69\146\x69\x63\141\164\x69\x6f\x6e\x73\x2f\167\x63\55\141\x64\x6d\x69\156\x2d\x73\x6d\163\55\164\145\155\x70\x6c\x61\x74\145\x2e\160\150\160";
