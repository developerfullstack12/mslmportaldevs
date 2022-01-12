<?php


use OTP\Handler\Forms\FormCraftPremiumForm;
$GD = FormCraftPremiumForm::instance();
$xj = $GD->isFormEnabled() ? "\x63\150\x65\143\153\x65\144" : '';
$wd = $xj == "\143\x68\145\143\x6b\145\144" ? '' : "\x68\x69\x64\x64\145\156";
$Dh = $GD->getOtpTypeEnabled();
$Vk = admin_url() . "\141\144\x6d\x69\156\x2e\x70\x68\x70\77\160\x61\147\145\75\x66\157\x72\155\x63\x72\x61\146\x74\137\x61\x64\x6d\x69\156";
$Kf = $GD->getFormDetails();
$VC = $GD->getPhoneHTMLTag();
$b9 = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\x73\x2f\146\157\x72\155\163\x2f\x46\157\x72\155\103\x72\141\146\x74\120\162\x65\155\151\x75\155\106\157\x72\155\56\x70\150\x70";
