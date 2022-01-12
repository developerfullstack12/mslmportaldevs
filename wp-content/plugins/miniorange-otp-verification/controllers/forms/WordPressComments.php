<?php


use OTP\Handler\Forms\WordPressComments;
$GD = WordPressComments::instance();
$or = (bool) $GD->isFormEnabled() ? "\143\x68\x65\143\x6b\x65\x64" : '';
$CQ = $or == "\x63\x68\x65\143\153\x65\144" ? '' : "\150\151\x64\144\x65\x6e";
$Iw = $GD->getOtpTypeEnabled();
$Vg = $GD->bypassForLoggedInUsers() ? "\x63\150\x65\143\x6b\145\144" : '';
$ko = $GD->getPhoneHTMLTag();
$n4 = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\x73\57\x66\x6f\x72\155\163\x2f\127\x6f\162\144\x50\x72\145\x73\x73\x43\x6f\x6d\x6d\x65\x6e\x74\x73\56\x70\x68\160";
