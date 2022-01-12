<?php


use OTP\Handler\Forms\WPClientRegistration;
$GD = WPClientRegistration::instance();
$CL = $GD->isFormEnabled() ? "\x63\150\x65\143\x6b\x65\x64" : '';
$Lb = $CL == "\143\x68\145\143\153\145\x64" ? '' : "\150\x69\144\144\x65\x6e";
$Xd = $GD->getOtpTypeEnabled();
$Wn = $GD->getPhoneHTMLTag();
$SA = $GD->getEmailHTMLTag();
$TU = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
$pi = $GD->restrictDuplicates() ? "\143\150\145\143\153\145\144" : '';
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\x73\x2f\x66\x6f\x72\155\163\57\x57\120\103\154\151\145\x6e\164\x52\145\x67\151\163\164\162\141\164\151\157\x6e\56\x70\150\x70";
