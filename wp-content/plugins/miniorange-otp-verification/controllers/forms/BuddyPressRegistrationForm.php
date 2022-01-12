<?php


use OTP\Handler\Forms\BuddyPressRegistrationForm;
$GD = BuddyPressRegistrationForm::instance();
$ru = $GD->isFormEnabled() ? "\x63\x68\145\x63\153\145\144" : '';
$Od = $ru == "\x63\x68\145\143\153\x65\x64" ? '' : "\150\x69\144\x64\145\156";
$Cj = $GD->getOtpTypeEnabled();
$h0 = admin_url() . "\x75\163\x65\x72\x73\x2e\160\x68\x70\77\160\x61\x67\x65\x3d\142\160\x2d\x70\162\157\x66\151\154\145\55\x73\x65\x74\165\160";
$a9 = $GD->getPhoneKeyDetails();
$gm = $GD->disableAutoActivation() ? "\x63\150\x65\143\153\x65\144" : '';
$wr = $GD->getPhoneHTMLTag();
$RU = $GD->getEmailHTMLTag();
$F9 = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
$pi = $GD->restrictDuplicates() ? "\143\150\x65\x63\153\145\x64" : '';
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\x73\x2f\x66\157\x72\155\163\57\102\165\144\144\x79\120\x72\x65\x73\x73\122\x65\x67\x69\x73\164\x72\141\x74\151\x6f\x6e\106\157\162\x6d\x2e\x70\x68\x70";
