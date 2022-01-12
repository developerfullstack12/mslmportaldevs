<?php


use OTP\Handler\Forms\PaidMembershipForm;
$GD = PaidMembershipForm::instance();
$BU = $GD->isFormEnabled() ? "\x63\150\x65\x63\x6b\145\144" : '';
$jY = $BU == "\143\150\145\143\153\145\x64" ? '' : "\x68\x69\x64\x64\x65\156";
$T5 = $GD->getOtpTypeEnabled();
$md = $GD->getPhoneHTMLTag();
$iC = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\x73\x2f\x66\x6f\162\155\163\57\120\141\151\144\115\x65\x6d\142\x65\x72\163\150\151\160\106\x6f\x72\155\x2e\x70\x68\x70";
