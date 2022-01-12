<?php


use OTP\Handler\Forms\CalderaForms;
$GD = CalderaForms::instance();
$jG = (bool) $GD->isFormEnabled() ? "\143\x68\x65\x63\153\x65\x64" : '';
$Cf = $jG == "\143\x68\145\x63\153\x65\144" ? '' : "\150\x69\144\x64\145\156";
$YX = $GD->getOtpTypeEnabled();
$o9 = $GD->getFormDetails();
$Mm = admin_url() . "\141\144\155\x69\x6e\x2e\160\150\160\77\160\x61\x67\x65\x3d\143\x61\x6c\x64\145\x72\141\55\146\x6f\x72\155\163";
$gF = $GD->getButtonText();
$Tn = $GD->getPhoneHTMLTag();
$hR = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\x73\57\x66\x6f\162\155\x73\x2f\103\x61\154\144\145\162\141\106\157\x72\x6d\x73\x2e\x70\x68\160";
