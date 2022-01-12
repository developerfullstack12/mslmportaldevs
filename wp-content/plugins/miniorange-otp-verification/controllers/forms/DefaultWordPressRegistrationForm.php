<?php


use OTP\Handler\Forms\DefaultWordPressRegistrationForm;
$GD = DefaultWordPressRegistrationForm::instance();
$zM = (bool) $GD->isFormEnabled() ? "\143\150\145\x63\x6b\145\144" : '';
$kx = $zM == "\x63\x68\145\143\153\145\144" ? '' : "\150\x69\x64\144\x65\156";
$kn = $GD->getOtpTypeEnabled();
$AJ = (bool) $GD->restrictDuplicates() ? "\143\x68\145\x63\153\x65\144" : '';
$GR = $GD->getPhoneHTMLTag();
$fd = $GD->getEmailHTMLTag();
$D_ = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
$EJ = $GD->disableAutoActivation() ? '' : "\143\150\x65\x63\153\145\144";
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\x73\x2f\x66\x6f\x72\x6d\x73\x2f\x44\x65\146\x61\165\154\x74\127\x6f\x72\x64\120\162\145\x73\x73\x52\x65\147\151\163\164\x72\141\164\151\x6f\156\x46\157\162\155\56\x70\150\160";
