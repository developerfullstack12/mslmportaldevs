<?php


use OTP\Handler\Forms\WpMemberForm;
$GD = WpMemberForm::instance();
$er = (bool) $GD->isFormEnabled() ? "\143\150\x65\143\x6b\145\144" : '';
$bW = $er == "\x63\x68\x65\x63\x6b\145\144" ? '' : "\x68\x69\144\144\x65\x6e";
$Se = $GD->getOtpTypeEnabled();
$E6 = admin_url() . "\x61\144\155\x69\156\x2e\x70\x68\160\77\160\141\147\x65\x3d\x77\160\x6d\145\155\x2d\x73\145\x74\x74\151\156\x67\163\x26\164\x61\142\75\146\x69\145\154\x64\163";
$jw = $GD->getPhoneHTMLTag();
$ju = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
$Zq = $GD->getPhoneKeyDetails();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\x2f\x66\157\x72\155\x73\57\127\160\x4d\x65\x6d\x62\145\x72\106\157\162\x6d\56\160\x68\x70";
