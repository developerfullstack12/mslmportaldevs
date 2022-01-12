<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Objects\Tabs;
use OTP\Helper\MoUtility;
$QL = remove_query_arg(array("\141\144\144\157\x6e", "\x66\157\162\155", "\163\165\x62\160\141\147\145"), $_SERVER["\x52\105\x51\x55\x45\123\x54\x5f\125\x52\x49"]);
$YG = add_query_arg(array("\x70\x61\x67\x65" => $qZ->_tabDetails[Tabs::ACCOUNT]->_menuSlug), $QL);
$UX = MoConstants::FAQ_URL;
$YY = MoMessages::showMessage(MoMessages::REGISTER_WITH_US, array("\x75\162\154" => $YG));
$IJ = MoMessages::showMessage(MoMessages::ACTIVATE_PLUGIN, array("\x75\x72\154" => $YG));
$RR = add_query_arg(array("\160\x61\x67\145" => $qZ->_tabDetails[Tabs::SMS_EMAIL_CONFIG]->_menuSlug), $QL);
$nN = MoMessages::showMessage(MoMessages::CONFIG_GATEWAY, array("\165\162\154" => $RR));
$Yh = $_GET["\160\x61\x67\145"];
$TJ = add_query_arg(array("\160\x61\x67\x65" => $qZ->_tabDetails[Tabs::PRICING]->_menuSlug), $QL);
$fD = $Uh->getNonceValue();
$Hg = MoUtility::micr();
$TC = strcmp(MOV_TYPE, "\x4d\x69\156\x69\x4f\x72\141\156\x67\x65\107\141\164\145\x77\x61\171") === 0;
include MOV_DIR . "\166\151\145\x77\x73\x2f\x6e\x61\166\x62\141\x72\x2e\160\x68\x70";
