<?php


use OTP\Handler\Forms\MemberPressRegistrationForm;
$GD = MemberPressRegistrationForm::instance();
$Hu = $GD->isFormEnabled() ? "\x63\x68\145\143\153\x65\x64" : '';
$CB = $Hu == "\x63\150\145\x63\x6b\145\x64" ? '' : "\x68\151\144\144\x65\156";
$A8 = $GD->getOtpTypeEnabled();
$Pr = $GD->getPhoneKeyDetails();
$hy = admin_url() . "\141\x64\155\x69\x6e\x2e\160\150\160\77\160\x61\147\x65\x3d\155\145\x6d\142\145\162\x70\162\145\x73\163\55\157\160\164\151\x6f\156\163\x23\155\x65\x70\162\x2d\x66\x69\x65\154\x64\x73";
$Xx = $GD->getPhoneHTMLTag();
$zA = $GD->getEmailHTMLTag();
$c1 = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
$E4 = $GD->bypassForLoggedInUsers() ? "\143\x68\145\x63\153\145\x64" : '';
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\x73\57\146\157\162\155\x73\x2f\115\145\155\x62\x65\x72\x50\162\x65\163\x73\x52\x65\x67\151\163\x74\162\141\164\151\x6f\x6e\106\x6f\x72\155\56\x70\x68\x70";
