<?php


use OTP\Handler\Forms\UltimateMemberProfileForm;
$GD = UltimateMemberProfileForm::instance();
$n3 = $GD->isFormEnabled() ? "\x63\x68\145\x63\x6b\145\x64" : '';
$Tu = $n3 == "\143\x68\145\143\153\145\x64" ? '' : "\x68\x69\144\144\145\x6e";
$Gq = $GD->getOtpTypeEnabled();
$IZ = $GD->getPhoneKeyDetails();
$t7 = admin_url() . "\x65\144\151\164\56\x70\150\160\77\160\157\x73\164\137\164\x79\x70\145\75\x75\x6d\137\x66\157\162\155";
$Pk = $GD->getPhoneHTMLTag();
$cA = $GD->getEmailHTMLTag();
$rD = $GD->getBothHTMLTag();
$Z8 = $GD->restrictDuplicates() ? "\x63\150\145\143\x6b\145\144" : '';
$p0 = $GD->getFormName();
$cx = $GD->getButtonText();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\145\167\x73\57\146\x6f\x72\x6d\163\57\x55\154\164\151\155\x61\x74\x65\x4d\x65\x6d\142\145\x72\x50\x72\x6f\146\x69\154\x65\x46\x6f\x72\x6d\x2e\x70\150\x70";
