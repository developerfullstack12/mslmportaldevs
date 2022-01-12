<?php


use OTP\Handler\Forms\RegistrationMagicForm;
$GD = RegistrationMagicForm::instance();
$hK = $GD->isFormEnabled() ? "\x63\x68\145\x63\153\x65\x64" : '';
$in = $hK == "\143\150\145\x63\153\x65\x64" ? '' : "\x68\x69\144\144\145\156";
$l4 = $GD->getOtpTypeEnabled();
$Db = admin_url() . "\141\x64\155\x69\x6e\56\160\150\x70\77\x70\141\x67\x65\75\162\x6d\x5f\146\157\162\x6d\x5f\x6d\x61\156\x61\x67\145";
$bR = $GD->getFormDetails();
$P4 = $GD->getPhoneHTMLTag();
$aE = $GD->getEmailHTMLTag();
$Tf = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\145\167\163\x2f\x66\x6f\162\155\x73\57\x52\x65\147\x69\163\x74\x72\141\x74\151\157\156\x4d\141\147\151\x63\x46\157\x72\155\56\160\x68\160";
