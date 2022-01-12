<?php


use OTP\Handler\Forms\ProfileBuilderRegistrationForm;
$GD = ProfileBuilderRegistrationForm::instance();
$s9 = $GD->isFormEnabled() ? "\x63\x68\145\x63\x6b\x65\x64" : '';
$Dm = $s9 == "\x63\x68\145\x63\x6b\145\x64" ? '' : "\x68\151\144\x64\x65\156";
$mq = $GD->getOtpTypeEnabled();
$v0 = $GD->getPhoneKeyDetails();
$hg = admin_url() . "\x61\x64\x6d\x69\x6e\56\160\150\x70\x3f\160\141\147\145\75\x6d\x61\x6e\x61\147\145\55\146\x69\x65\x6c\144\163";
$xz = $GD->getPhoneHTMLTag();
$c3 = $GD->getEmailHTMLTag();
$MR = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\163\57\146\x6f\162\155\163\57\x50\x72\157\146\151\x6c\x65\102\x75\151\154\x64\x65\x72\122\145\x67\x69\163\x74\162\x61\x74\151\157\x6e\x46\x6f\x72\155\56\x70\x68\x70";
