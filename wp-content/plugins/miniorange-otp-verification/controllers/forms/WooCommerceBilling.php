<?php


use OTP\Handler\Forms\WooCommerceBilling;
$GD = WooCommerceBilling::instance();
$RH = (bool) $GD->isFormEnabled() ? "\x63\x68\145\143\x6b\145\144" : '';
$Nl = $RH == "\143\x68\x65\143\x6b\x65\144" ? '' : "\150\151\x64\144\145\156";
$Xz = $GD->getOtpTypeEnabled();
$HA = $GD->getPhoneHTMLTag();
$ZU = $GD->getEmailHTMLTag();
$w1 = (bool) $GD->restrictDuplicates() ? "\x63\x68\145\x63\153\x65\144" : '';
$gF = $GD->getButtonText();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\x73\x2f\x66\157\x72\x6d\x73\57\127\157\157\x43\x6f\155\x6d\145\x72\x63\x65\x42\151\154\x6c\x69\156\147\x2e\160\x68\160";
