<?php


use OTP\Handler\Forms\WPLoginForm;
$GD = WPLoginForm::instance();
$bk = (bool) $GD->isFormEnabled() ? "\143\150\x65\143\x6b\145\144" : '';
$kL = $bk == "\x63\x68\145\143\153\x65\x64" ? '' : "\150\151\x64\x64\x65\156";
$l1 = (bool) $GD->savePhoneNumbers() ? "\x63\150\145\x63\153\x65\x64" : '';
$bQ = $GD->getPhoneKeyDetails();
$V5 = (bool) $GD->byPassCheckForAdmins() ? "\x63\150\x65\x63\x6b\145\x64" : '';
$LW = (bool) $GD->allowLoginThroughPhone() ? "\143\150\145\143\x6b\145\x64" : '';
$hh = (bool) $GD->restrictDuplicates() ? "\143\x68\x65\143\153\x65\x64" : '';
$cG = $GD->getOtpTypeEnabled();
$ST = $GD->getPhoneHTMLTag();
$Da = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
$ON = $GD->getSkipPasswordCheck() ? "\143\x68\x65\143\x6b\x65\x64" : '';
$dY = $GD->getSkipPasswordCheck() ? "\142\x6c\x6f\143\153" : "\150\x69\x64\x64\x65\156";
$gd = $GD->getSkipPasswordCheckFallback() ? "\143\150\145\143\x6b\x65\144" : '';
$jN = $GD->getUserLabel();
$fC = $GD->isDelayOtp() ? "\x63\x68\x65\x63\x6b\x65\x64" : '';
$sj = $GD->isDelayOtp() ? "\142\154\x6f\143\x6b" : "\x68\x69\x64\x64\145\x6e";
$U_ = $GD->getDelayOtpInterval();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\x73\x2f\146\x6f\x72\155\x73\x2f\x57\120\x4c\x6f\147\151\x6e\106\157\162\155\x2e\160\150\160";
