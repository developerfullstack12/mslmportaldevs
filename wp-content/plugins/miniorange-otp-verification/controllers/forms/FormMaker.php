<?php


use OTP\Handler\Forms\FormMaker;
$GD = FormMaker::instance();
$of = (bool) $GD->isFormEnabled() ? "\x63\x68\x65\143\x6b\145\144" : '';
$xB = $of == "\x63\x68\145\x63\153\x65\144" ? '' : "\150\x69\x64\144\145\x6e";
$bm = admin_url() . "\141\x64\x6d\151\156\56\x70\x68\160\77\160\x61\147\x65\x3d\x6d\x61\156\141\x67\145\137\x66\x6d";
$rw = $GD->getOtpTypeEnabled();
$s2 = $GD->getEmailHTMLTag();
$Et = $GD->getPhoneHTMLTag();
$y2 = $GD->getFormDetails();
$p0 = $GD->getFormName();
$gF = $GD->getButtonText();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\163\57\x66\x6f\162\155\163\57\106\157\162\x6d\x4d\x61\x6b\x65\x72\x2e\x70\x68\160";
