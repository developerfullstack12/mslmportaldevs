<?php


use OTP\Handler\Forms\FormidableForm;
$GD = FormidableForm::instance();
$aS = $GD->isFormEnabled() ? "\143\150\x65\x63\153\145\x64" : '';
$wT = $aS == "\x63\150\x65\143\153\x65\x64" ? '' : "\150\x69\x64\144\x65\156";
$dp = $GD->getOtpTypeEnabled();
$iN = admin_url() . "\141\x64\x6d\151\x6e\x2e\160\x68\160\x3f\160\141\147\145\x3d\146\x6f\x72\x6d\151\144\141\x62\x6c\x65";
$Vt = $GD->getFormDetails();
$a1 = $GD->getPhoneHTMLTag();
$ea = $GD->getEmailHTMLTag();
$gF = $GD->getButtonText();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\x69\x65\x77\x73\x2f\146\157\162\155\163\57\106\x6f\162\x6d\x69\144\x61\x62\x6c\x65\x46\x6f\x72\x6d\56\x70\150\160";
