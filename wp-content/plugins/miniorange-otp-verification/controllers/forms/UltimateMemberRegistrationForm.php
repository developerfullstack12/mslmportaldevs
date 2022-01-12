<?php


use OTP\Handler\Forms\UltimateMemberRegistrationForm;
$GD = UltimateMemberRegistrationForm::instance();
$qv = $GD->isFormEnabled() ? "\x63\x68\x65\x63\x6b\x65\144" : '';
$If = $qv == "\x63\x68\x65\x63\x6b\x65\x64" ? '' : "\x68\x69\x64\144\145\156";
$A4 = $GD->getOtpTypeEnabled();
$qI = admin_url() . "\x65\x64\x69\164\x2e\x70\x68\x70\77\x70\157\163\x74\x5f\164\x79\160\x65\x3d\x75\x6d\x5f\x66\157\162\155";
$oc = $GD->getPhoneHTMLTag();
$Be = $GD->getEmailHTMLTag();
$VQ = $GD->getBothHTMLTag();
$J7 = $GD->restrictDuplicates() ? "\143\150\x65\143\x6b\x65\144" : '';
$p0 = $GD->getFormName();
$O3 = $GD->getButtonText();
$wi = $GD->isAjaxForm();
$ZD = $wi ? "\143\x68\145\143\153\145\x64" : '';
$bX = $GD->getFormKey();
$kw = $GD->getPhoneKeyDetails();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\57\x66\157\162\155\x73\x2f\x55\x6c\x74\151\x6d\141\164\145\x4d\x65\x6d\x62\x65\x72\x52\145\147\151\x73\164\x72\141\x74\x69\157\156\x46\157\x72\x6d\x2e\160\150\160";
