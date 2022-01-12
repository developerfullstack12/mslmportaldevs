<?php


use OTP\Handler\Forms\WpEmemberForm;
$GD = WpEmemberForm::instance();
$gr = $GD->isFormEnabled() ? "\143\150\145\143\153\x65\x64" : '';
$jU = $gr == "\143\x68\x65\143\153\145\144" ? '' : "\x68\x69\x64\144\145\x6e";
$jO = $GD->getOtpTypeEnabled();
$EU = admin_url() . "\141\x64\x6d\151\156\x2e\160\150\160\x3f\x70\141\147\145\x3d\x65\115\145\x6d\x62\145\162\137\163\x65\x74\164\x69\156\x67\163\137\155\145\156\x75\46\x74\141\142\75\64";
$mN = $GD->getPhoneHTMLTag();
$HL = $GD->getEmailHTMLTag();
$D3 = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\163\x2f\x66\157\x72\x6d\x73\57\127\160\x45\x6d\145\155\142\145\x72\106\157\162\155\56\160\x68\160";
