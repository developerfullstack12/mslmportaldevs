<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\Tabs;
$rp = admin_url() . "\x65\144\x69\164\x2e\160\150\x70\77\160\157\163\x74\137\x74\171\x70\x65\x3d\160\141\x67\145";
$tJ = MoUtility::micv() ? "\167\x70\137\x6f\164\160\x5f\x76\x65\x72\x69\146\151\143\141\164\x69\157\x6e\137\165\160\x67\x72\x61\144\x65\x5f\x70\154\141\x6e" : "\167\160\x5f\x6f\x74\160\137\x76\x65\162\x69\x66\151\x63\x61\164\x69\x6f\x6e\137\x62\x61\163\x69\143\137\x70\x6c\141\156";
$fD = $Uh->getNonceValue();
$R6 = add_query_arg(array("\x70\141\x67\145" => $qZ->_tabDetails[Tabs::FORMS]->_menuSlug, "\x66\157\162\x6d" => "\143\x6f\156\x66\151\147\x75\x72\x65\x64\x5f\146\x6f\162\x6d\x73\x23\x63\157\156\x66\151\x67\x75\x72\x65\144\137\146\x6f\x72\x6d\x73"));
$hc = add_query_arg("\x70\x61\147\x65", $qZ->_tabDetails[Tabs::FORMS]->_menuSlug . "\43\146\x6f\162\155\x5f\x73\x65\x61\x72\x63\x68", remove_query_arg(array("\x66\157\162\155")));
$sb = isset($_GET["\x66\x6f\x72\155"]) ? $_GET["\x66\157\162\x6d"] : false;
$Di = $sb == "\143\157\x6e\x66\151\x67\x75\x72\x65\x64\x5f\146\157\x72\155\163";
$ZC = $qZ->_tabDetails[Tabs::OTP_SETTINGS];
$w9 = $ZC->_url;
$ix = $qZ->_tabDetails[Tabs::SMS_EMAIL_CONFIG];
$tc = $ix->_url;
$Nk = $qZ->_tabDetails[Tabs::DESIGN];
$dJ = $Nk->_url;
$V3 = $qZ->_tabDetails[Tabs::ADD_ONS];
$Ge = $V3->_url;
$kP = $qZ->_tabDetails[Tabs::CONTACT_US];
$xu = $kP->_url;
$Sm = MoConstants::FEEDBACK_EMAIL;
include MOV_DIR . "\166\x69\x65\167\x73\x2f\x73\x65\x74\164\151\x6e\147\x73\56\160\150\x70";
include MOV_DIR . "\166\x69\x65\x77\163\x2f\151\156\x73\x74\162\165\x63\164\151\x6f\x6e\163\56\x70\150\160";
