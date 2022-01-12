<?php


use OTP\Handler\Forms\UltimateProRegistrationForm;
$GD = UltimateProRegistrationForm::instance();
$Y6 = (bool) $GD->isFormEnabled() ? "\x63\x68\145\143\153\x65\144" : '';
$KD = $Y6 == "\143\150\x65\x63\x6b\145\144" ? '' : "\150\151\144\144\x65\x6e";
$mJ = $GD->getOtpTypeEnabled();
$Bd = admin_url() . "\x61\x64\x6d\151\x6e\56\160\x68\160\x3f\160\141\x67\145\75\x69\x68\x63\137\155\x61\156\141\147\x65\x26\164\141\x62\75\x72\145\147\151\163\x74\145\162\46\x73\165\142\x74\141\x62\x3d\x63\x75\163\164\x6f\155\137\x66\x69\x65\154\144\x73";
$gj = $GD->getPhoneHTMLTag();
$K1 = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\x69\x65\x77\x73\x2f\x66\x6f\162\x6d\163\57\x55\x6c\164\x69\155\141\164\145\x50\x72\x6f\122\145\147\x69\x73\x74\162\x61\x74\151\x6f\x6e\x46\x6f\x72\x6d\56\x70\150\x70";
