<?php


use OTP\Handler\Forms\ContactForm7;
$GD = ContactForm7::instance();
$AY = (bool) $GD->isFormEnabled() ? "\143\150\145\143\153\x65\x64" : '';
$hF = $AY == "\x63\x68\x65\x63\x6b\x65\x64" ? '' : "\x68\x69\144\x64\x65\156";
$lz = $GD->getOtpTypeEnabled();
$Uw = admin_url() . "\141\144\155\151\x6e\x2e\x70\150\160\77\160\x61\x67\145\x3d\167\160\143\146\x37";
$p2 = $GD->getEmailKeyDetails();
$dO = $GD->getPhoneHTMLTag();
$uk = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\x69\145\167\163\57\146\157\x72\155\163\57\103\x6f\156\164\141\x63\164\x46\x6f\x72\x6d\x37\x2e\160\x68\160";
