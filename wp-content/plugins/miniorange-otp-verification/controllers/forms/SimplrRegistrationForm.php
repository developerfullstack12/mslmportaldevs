<?php


use OTP\Handler\Forms\SimplrRegistrationForm;
$GD = SimplrRegistrationForm::instance();
$C7 = $GD->isFormEnabled() ? "\x63\150\x65\x63\x6b\145\144" : '';
$vg = $C7 == "\x63\x68\145\143\x6b\145\x64" ? '' : "\150\x69\x64\x64\145\156";
$Jg = $GD->getOtpTypeEnabled();
$D0 = admin_url() . "\x6f\160\164\x69\x6f\x6e\x73\55\147\145\156\145\x72\141\x6c\x2e\160\150\x70\x3f\x70\141\147\145\x3d\163\x69\155\x70\154\x72\x5f\162\145\x67\137\163\145\164\x26\x72\145\147\166\x69\x65\x77\75\146\151\145\x6c\144\x73\x26\157\162\x64\x65\162\x62\171\75\x6e\x61\x6d\x65\46\157\x72\144\145\162\x3d\144\x65\x73\x63";
$vZ = $GD->getPhoneKeyDetails();
$kD = $GD->getPhoneHTMLTag();
$gi = $GD->getEmailHTMLTag();
$zD = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\x77\x73\x2f\x66\157\x72\155\163\57\123\x69\x6d\x70\x6c\162\x52\145\147\x69\x73\164\162\141\164\151\157\x6e\x46\x6f\162\x6d\x2e\160\150\160";
