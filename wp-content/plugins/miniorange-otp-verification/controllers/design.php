<?php


use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\Template;
$vU = DefaultPopup::instance();
$K3 = UserChoicePopup::instance();
$Ef = ExternalPopup::instance();
$ob = ErrorPopup::instance();
$fD = $vU->getNonceValue();
$U1 = $vU->getTemplateKey();
$zU = $K3->getTemplateKey();
$Ti = $Ef->getTemplateKey();
$OE = $ob->getTemplateKey();
$nY = maybe_unserialize(get_mo_option("\x63\x75\x73\164\157\x6d\137\160\x6f\x70\165\x70\163"));
$GU = $nY[$vU->getTemplateKey()];
$pL = $nY[$Ef->getTemplateKey()];
$ow = $nY[$K3->getTemplateKey()];
$eA = $nY[$ob->getTemplateKey()];
$xE = Template::$templateEditor;
$Pm = $vU->getTemplateEditorId();
$No = array_merge($xE, array("\164\x65\x78\x74\141\x72\x65\141\x5f\156\141\155\145" => $Pm, "\x65\x64\151\164\157\x72\x5f\150\x65\x69\x67\x68\x74" => 400));
$PG = $K3->getTemplateEditorId();
$Yr = array_merge($xE, array("\164\x65\x78\x74\x61\162\x65\141\x5f\156\141\x6d\x65" => $PG, "\145\x64\x69\164\157\162\x5f\150\145\x69\147\150\164" => 400));
$v9 = $Ef->getTemplateEditorId();
$R_ = array_merge($xE, array("\164\145\x78\164\x61\x72\x65\141\137\156\x61\x6d\145" => $v9, "\x65\x64\x69\164\x6f\x72\x5f\150\x65\151\x67\150\164" => 400));
$bn = $ob->getTemplateEditorId();
$B1 = array_merge($xE, array("\x74\145\170\164\x61\x72\x65\141\137\x6e\141\155\145" => $bn, "\x65\144\x69\164\157\162\137\150\x65\151\x67\x68\164" => 400));
$q3 = str_replace("\x7b\173\103\x4f\x4e\x54\105\x4e\124\175\x7d", "\74\151\155\x67\40\163\x72\143\75\x27" . MOV_LOADER_URL . "\x27\76", $vU->paneContent);
$oH = "\x3c\x73\160\x61\156\x20\163\x74\x79\x6c\x65\x3d\47\146\157\x6e\x74\55\x73\x69\x7a\x65\x3a\40\x31\56\63\x65\155\x3b\x27\x3e" . "\120\x52\105\126\111\x45\127\40\120\x41\x4e\x45\x3c\142\x72\57\76\74\142\162\57\x3e" . "\74\x2f\163\x70\x61\x6e\x3e" . "\x3c\163\x70\x61\x6e\76" . "\103\x6c\151\x63\x6b\x20\157\156\x20\164\150\x65\x20\120\x72\145\166\x69\145\167\x20\x62\x75\x74\164\157\x6e\40\141\x62\157\x76\145\40\x74\157\40\143\150\145\x63\x6b\40\150\157\x77\40\x79\x6f\x75\x72\40\160\157\x70\x75\x70\x20\167\x6f\165\154\x64\40\x6c\157\157\x6b\40\154\x69\x6b\x65\56" . "\74\x2f\163\160\141\156\x3e";
$oH = str_replace("\x7b\173\x4d\105\123\123\101\107\x45\x7d\x7d", $oH, $vU->messageDiv);
$SF = str_replace("\173\173\x43\117\x4e\x54\105\x4e\124\175\175", $oH, $vU->paneContent);
include MOV_DIR . "\x76\151\145\x77\163\x2f\144\145\163\151\147\x6e\x2e\x70\150\160";
