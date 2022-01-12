<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
$fD = $Uh->getNonceValue();
$MU = get_mo_option("\x73\165\x63\143\145\x73\x73\x5f\145\x6d\x61\x69\x6c\x5f\155\145\x73\163\141\x67\145", "\155\x6f\x5f\x6f\164\x70\137") ? get_mo_option("\x73\165\x63\143\145\163\x73\137\145\155\x61\x69\x6c\x5f\155\x65\x73\x73\x61\147\x65", "\155\157\137\x6f\164\x70\x5f") : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
$G6 = get_mo_option("\163\165\x63\143\145\x73\x73\137\x70\x68\x6f\x6e\145\137\x6d\x65\x73\x73\x61\147\x65", "\155\157\137\157\164\x70\137") ? get_mo_option("\x73\x75\143\143\145\x73\x73\x5f\x70\x68\x6f\156\145\137\155\x65\163\163\x61\x67\145", "\x6d\157\137\x6f\x74\160\x5f") : MoMessages::showMessage(MoMessages::OTP_SENT_PHONE);
$aD = get_mo_option("\145\162\162\x6f\162\x5f\160\150\157\x6e\x65\137\155\x65\x73\163\141\147\145", "\x6d\x6f\137\x6f\x74\x70\x5f") ? get_mo_option("\x65\x72\162\x6f\162\x5f\160\150\x6f\156\145\137\x6d\145\x73\x73\x61\147\x65", "\155\x6f\137\157\x74\160\x5f") : MoMessages::showMessage(MoMessages::ERROR_OTP_PHONE);
$mD = get_mo_option("\x65\x72\x72\157\162\137\145\x6d\141\x69\154\137\x6d\145\163\x73\x61\x67\x65", "\x6d\x6f\137\157\x74\x70\x5f") ? get_mo_option("\x65\162\x72\x6f\x72\x5f\145\x6d\x61\x69\x6c\x5f\155\145\x73\x73\141\147\x65", "\155\x6f\x5f\157\x74\x70\x5f") : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
$xK = get_mo_option("\x69\156\166\x61\154\151\144\x5f\160\150\x6f\x6e\145\x5f\x6d\145\x73\163\x61\147\x65", "\x6d\157\x5f\x6f\x74\x70\137") ? get_mo_option("\151\x6e\x76\x61\154\x69\x64\137\160\150\x6f\156\x65\137\155\145\x73\163\141\147\x65", "\155\x6f\x5f\x6f\x74\x70\137") : MoMessages::showMessage(MoMessages::ERROR_PHONE_FORMAT);
$BV = get_mo_option("\151\x6e\x76\141\x6c\151\x64\137\x65\x6d\141\151\154\x5f\x6d\145\x73\163\x61\147\x65", "\155\157\137\157\164\x70\137") ? get_mo_option("\151\156\x76\141\x6c\x69\144\x5f\145\155\x61\x69\154\137\155\145\x73\163\x61\x67\145", "\155\157\x5f\157\x74\160\137") : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
$Aw = MoUtility::_get_invalid_otp_method();
$Fa = get_mo_option("\142\154\157\143\x6b\x65\144\137\x65\155\141\151\154\x5f\x6d\x65\163\163\141\x67\145", "\x6d\x6f\137\x6f\164\x70\137") ? get_mo_option("\x62\x6c\x6f\x63\x6b\x65\x64\x5f\x65\155\x61\151\154\x5f\155\x65\163\163\141\147\x65", "\155\x6f\137\157\x74\x70\137") : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
$AS = get_mo_option("\142\154\157\143\x6b\x65\x64\x5f\x70\150\157\156\x65\137\155\145\x73\x73\141\x67\x65", "\155\157\x5f\157\164\160\137") ? get_mo_option("\142\154\157\x63\x6b\145\x64\137\x70\150\x6f\x6e\145\x5f\x6d\145\x73\x73\x61\147\x65", "\155\x6f\137\157\164\160\x5f") : MoMessages::showMessage(MoMessages::ERROR_PHONE_BLOCKED);
include MOV_DIR . "\x76\x69\x65\x77\x73\x2f\155\x65\x73\x73\x61\147\x65\163\x2e\x70\150\160";
