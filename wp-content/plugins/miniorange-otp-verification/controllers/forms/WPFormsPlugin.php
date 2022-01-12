<?php


use OTP\Handler\Forms\WPFormsPlugin;
$GD = WPFormsPlugin::instance();
$rk = (bool) $GD->isFormEnabled() ? "\143\x68\145\143\x6b\x65\x64" : '';
$Bv = $rk == "\143\x68\x65\x63\153\145\x64" ? '' : "\x68\x69\144\144\145\156";
$YS = $GD->getOtpTypeEnabled();
$iK = $GD->getFormDetails();
$Cp = admin_url() . "\141\144\x6d\151\156\56\160\x68\x70\x3f\160\x61\147\x65\75\x77\160\146\x6f\162\x6d\x73\55\x6f\x76\x65\162\166\x69\x65\x77";
$gF = $GD->getButtonText();
$WN = $GD->getPhoneHTMLTag();
$km = $GD->getEmailHTMLTag();
$KA = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\x73\x2f\146\157\162\155\163\57\x57\x50\106\x6f\x72\155\163\x50\154\165\x67\x69\156\56\160\150\160";
