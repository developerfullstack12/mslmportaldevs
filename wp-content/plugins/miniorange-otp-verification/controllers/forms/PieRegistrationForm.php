<?php


use OTP\Handler\Forms\PieRegistrationForm;
$GD = PieRegistrationForm::instance();
$VI = $GD->isFormEnabled() ? "\143\150\145\x63\153\145\144" : '';
$HI = $VI == "\143\150\145\143\153\145\144" ? '' : "\150\151\x64\144\x65\156";
$Ke = $GD->getOtpTypeEnabled();
$FE = $GD->getPhoneKeyDetails();
$JN = $GD->getPhoneHTMLTag();
$Fe = $GD->getEmailHTMLTag();
$hw = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\163\x2f\146\x6f\x72\155\x73\57\x50\151\x65\x52\145\147\x69\x73\164\x72\141\164\151\x6f\x6e\106\157\162\155\x2e\x70\x68\160";
