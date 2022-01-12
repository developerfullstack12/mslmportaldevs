<?php


use OTP\Handler\Forms\GravityForm;
$GD = GravityForm::instance();
$wZ = $GD->isFormEnabled() ? "\143\150\x65\x63\153\x65\x64" : '';
$jz = $wZ == "\x63\150\145\x63\x6b\145\x64" ? '' : "\150\x69\144\x64\145\x6e";
$SQ = $GD->getOtpTypeEnabled();
$Nu = admin_url() . "\x61\x64\155\151\156\x2e\160\x68\160\77\x70\x61\147\145\75\x67\x66\x5f\145\x64\151\164\x5f\x66\x6f\162\155\x73";
$X9 = $GD->getFormDetails();
$no = $GD->getEmailHTMLTag();
$U9 = $GD->getPhoneHTMLTag();
$p0 = $GD->getFormName();
$NU = $GD->getButtonText();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\x73\x2f\x66\x6f\x72\155\x73\x2f\x47\x72\141\166\x69\x74\x79\x46\x6f\x72\155\x2e\x70\150\160";
