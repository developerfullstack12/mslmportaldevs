<?php


use OTP\Handler\Forms\NinjaForm;
$GD = NinjaForm::instance();
$X2 = $GD->isFormEnabled() ? "\143\150\x65\x63\x6b\145\144" : '';
$sh = $X2 == "\143\150\x65\143\x6b\x65\x64" ? '' : "\x68\151\144\x64\145\x6e";
$UG = $GD->getOtpTypeEnabled();
$I8 = admin_url() . "\141\x64\x6d\151\156\x2e\x70\x68\x70\x3f\x70\x61\x67\145\75\x6e\x69\156\152\x61\x2d\146\x6f\162\x6d\163";
$Si = $GD->getFormDetails();
$n2 = $GD->getPhoneHTMLTag();
$Vf = $GD->getEmailHTMLTag();
$eg = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\151\145\167\163\x2f\x66\157\162\x6d\163\57\116\x69\156\152\141\x46\x6f\162\x6d\x2e\160\150\160";
