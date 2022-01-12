<?php


use OTP\Handler\Forms\VisualFormBuilder;
$GD = VisualFormBuilder::instance();
$C8 = $GD->isFormEnabled() ? "\x63\150\145\143\153\145\144" : '';
$x3 = $C8 == "\143\x68\x65\143\153\x65\144" ? '' : "\x68\151\x64\144\145\x6e";
$aJ = $GD->getOtpTypeEnabled();
$y5 = admin_url() . "\141\144\x6d\x69\x6e\56\160\150\160\77\x70\x61\147\145\x3d\x76\x69\163\x75\141\x6c\55\146\x6f\x72\155\55\142\165\151\154\144\145\162";
$b2 = $GD->getFormDetails();
$K2 = $GD->getPhoneHTMLTag();
$B4 = $GD->getEmailHTMLTag();
$gF = $GD->getButtonText();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\x69\145\167\163\57\x66\157\162\x6d\163\x2f\126\151\x73\165\x61\154\x46\x6f\x72\x6d\x42\x75\x69\x6c\x64\145\x72\x2e\x70\150\160";
