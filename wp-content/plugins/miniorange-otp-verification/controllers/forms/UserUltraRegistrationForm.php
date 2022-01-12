<?php


use OTP\Handler\Forms\UserUltraRegistrationForm;
$GD = UserUltraRegistrationForm::instance();
$EQ = $GD->isFormEnabled() ? "\143\x68\145\143\153\145\144" : '';
$Ot = $EQ == "\143\x68\x65\143\153\145\144" ? '' : "\x68\151\144\x64\x65\x6e";
$IE = $GD->getOtpTypeEnabled();
$ly = admin_url() . "\x61\x64\x6d\x69\x6e\x2e\160\150\160\x3f\x70\141\x67\145\75\x75\x73\145\x72\x75\154\x74\x72\141\46\x74\x61\x62\x3d\x66\151\x65\154\x64\163";
$Aa = $GD->getPhoneKeyDetails();
$u7 = $GD->getPhoneHTMLTag();
$uI = $GD->getEmailHTMLTag();
$uA = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\x2f\x66\x6f\162\155\163\x2f\x55\x73\145\x72\125\x6c\164\x72\x61\x52\145\147\151\163\164\162\x61\x74\x69\x6f\x6e\x46\157\162\x6d\56\160\150\160";
