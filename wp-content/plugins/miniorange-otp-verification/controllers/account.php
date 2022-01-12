<?php


use OTP\Handler\MoRegistrationHandler;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
$JX = MoConstants::HOSTNAME . "\57\x6d\157\141\x73\57\154\157\x67\x69\156" . "\77\162\145\x64\151\162\x65\x63\x74\x55\x72\154\75" . MoConstants::HOSTNAME . "\57\x6d\x6f\x61\163\57\x76\151\145\167\154\x69\143\x65\156\163\x65\153\145\171\163";
$GD = MoRegistrationHandler::instance();
if (get_mo_option("\x72\145\147\151\x73\164\x72\141\x74\151\x6f\156\137\x73\164\141\x74\x75\x73") === "\x4d\117\137\117\x54\120\137\x44\105\x4c\111\126\105\122\x45\x44\137\x53\x55\x43\x43\x45\x53\123" || get_mo_option("\x72\x65\147\151\163\164\162\141\x74\151\x6f\156\x5f\x73\x74\x61\164\165\163") === "\x4d\x4f\x5f\x4f\124\120\x5f\126\101\x4c\111\x44\101\124\x49\x4f\x4e\137\106\x41\111\114\x55\122\105" || get_mo_option("\x72\145\147\151\x73\x74\162\141\164\x69\157\x6e\137\163\164\141\x74\165\x73") === "\115\x4f\x5f\117\x54\120\137\x44\105\x4c\111\x56\105\122\105\104\137\106\101\x49\x4c\x55\122\105") {
    goto UR;
}
if (get_mo_option("\x76\145\162\151\146\171\137\143\x75\x73\x74\157\155\x65\x72")) {
    goto qP;
}
if (!MoUtility::micr()) {
    goto sV;
}
if (MoUtility::micr() && !MoUtility::mclv()) {
    goto HZ;
}
$yx = get_mo_option("\x61\x64\x6d\151\156\x5f\x63\x75\163\x74\157\x6d\x65\x72\137\x6b\145\x79");
$sJ = get_mo_option("\141\144\155\151\156\137\x61\160\x69\x5f\x6b\x65\x79");
$w0 = get_mo_option("\143\165\163\x74\x6f\155\145\162\137\x74\157\153\145\156");
$dl = MoUtility::mclv() && !MoUtility::isMG();
$fD = $Uh->getNonceValue();
$S8 = $GD->getNonceValue();
include MOV_DIR . "\166\151\x65\167\x73\57\x61\143\143\x6f\165\156\x74\57\160\162\157\146\x69\154\x65\56\160\x68\160";
goto Rf;
HZ:
$fD = $GD->getNonceValue();
include MOV_DIR . "\x76\151\145\x77\163\x2f\141\x63\143\157\x75\x6e\164\57\166\x65\162\151\x66\x79\x2d\154\153\56\x70\x68\x70";
Rf:
goto qR;
sV:
$current_user = wp_get_current_user();
$jr = get_mo_option("\x61\144\155\x69\156\137\160\x68\x6f\156\x65") ? get_mo_option("\x61\144\155\x69\156\137\160\x68\157\x6e\145") : '';
$fD = $GD->getNonceValue();
delete_site_option("\160\x61\x73\x73\167\157\162\144\x5f\x6d\151\x73\x6d\x61\164\143\150");
update_mo_option("\156\x65\167\x5f\x72\145\x67\151\x73\164\x72\x61\x74\x69\157\x6e", "\x74\162\165\145");
include MOV_DIR . "\166\151\145\167\x73\57\141\x63\x63\157\x75\x6e\x74\57\162\145\147\151\x73\x74\145\162\56\x70\150\160";
qR:
goto ZZ;
qP:
$i2 = get_mo_option("\x61\144\x6d\151\x6e\137\145\x6d\x61\x69\154") ? get_mo_option("\141\x64\x6d\151\x6e\137\x65\155\x61\x69\x6c") : '';
$fD = $GD->getNonceValue();
include MOV_DIR . "\166\151\x65\167\163\57\141\143\143\157\165\156\x74\57\154\157\147\x69\x6e\x2e\x70\x68\x70";
ZZ:
goto gJ;
UR:
$jr = get_mo_option("\141\144\155\151\156\x5f\160\x68\x6f\x6e\145") ? get_mo_option("\x61\x64\x6d\151\156\137\160\150\x6f\x6e\x65") : '';
$fD = $GD->getNonceValue();
include MOV_DIR . "\166\x69\x65\167\163\57\x61\143\x63\157\165\156\164\57\x76\x65\x72\151\146\171\x2e\160\150\160";
gJ:
