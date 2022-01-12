<?php


use OTP\Handler\Forms\UserProRegistrationForm;
$GD = UserProRegistrationForm::instance();
$rP = $GD->isFormEnabled() ? "\x63\x68\x65\x63\x6b\145\x64" : '';
$k0 = $rP == "\x63\x68\145\143\153\145\x64" ? '' : "\150\x69\x64\144\145\x6e";
$Vd = $GD->getOtpTypeEnabled();
$Kh = admin_url() . "\141\144\x6d\151\x6e\56\160\x68\x70\x3f\160\x61\147\145\75\165\163\x65\x72\160\x72\157\x26\x74\x61\x62\75\146\x69\145\154\x64\163";
$Ju = $GD->disableAutoActivation() ? "\x63\x68\145\x63\x6b\145\x64" : '';
$tn = $GD->getPhoneHTMLTag();
$I1 = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\x77\163\57\x66\x6f\162\155\163\x2f\125\163\x65\x72\120\162\x6f\122\x65\x67\x69\x73\164\162\x61\164\x69\x6f\x6e\106\x6f\162\155\x2e\160\x68\x70";
