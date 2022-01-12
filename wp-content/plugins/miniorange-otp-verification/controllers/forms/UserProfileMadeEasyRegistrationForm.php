<?php


use OTP\Handler\Forms\UserProfileMadeEasyRegistrationForm;
$GD = UserProfileMadeEasyRegistrationForm::instance();
$Gp = $GD->isFormEnabled() ? "\143\150\x65\x63\153\x65\144" : '';
$TX = $Gp == "\x63\150\x65\x63\x6b\x65\x64" ? '' : "\150\x69\144\144\x65\156";
$AP = $GD->getOtpTypeEnabled();
$ty = admin_url() . "\x61\144\x6d\151\156\56\160\x68\x70\77\x70\x61\147\x65\75\x75\160\x6d\145\x2d\x66\x69\x65\x6c\144\55\x63\165\x73\x74\157\155\x69\x7a\145\162";
$s7 = $GD->getPhoneKeyDetails();
$E5 = $GD->getPhoneHTMLTag();
$w5 = $GD->getEmailHTMLTag();
$Vo = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\145\x77\163\57\x66\157\162\155\x73\x2f\125\x73\x65\x72\120\162\157\x66\151\x6c\x65\x4d\x61\x64\x65\x45\141\163\171\x52\145\x67\x69\163\x74\162\141\164\151\157\156\x46\x6f\162\155\x2e\160\x68\x70";
