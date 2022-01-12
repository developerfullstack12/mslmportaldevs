<?php


use OTP\Handler\Forms\WooCommerceCheckOutForm;
$GD = WooCommerceCheckOutForm::instance();
$kH = $GD->isFormEnabled() ? "\143\x68\145\x63\x6b\x65\144" : '';
$mj = $kH == "\x63\x68\145\143\153\x65\144" ? '' : "\x68\x69\144\x64\x65\156";
$op = $GD->getOtpTypeEnabled();
$na = $GD->isGuestCheckoutOnlyEnabled() ? "\x63\150\145\143\153\x65\x64" : '';
$G_ = $GD->showButtonInstead() ? "\143\150\145\143\153\x65\144" : '';
$wk = $GD->isPopUpEnabled() ? "\143\x68\x65\x63\153\145\144" : '';
$gu = $GD->getPaymentMethods();
$cy = $GD->isSelectivePaymentEnabled() ? "\143\x68\x65\x63\153\145\144" : '';
$Dr = $cy == "\x63\150\145\x63\153\145\x64" ? '' : "\x68\x69\x64\x64\x65\x6e";
$q_ = $GD->getPhoneHTMLTag();
$NZ = $GD->getEmailHTMLTag();
$gF = $GD->getButtonText();
$p0 = $GD->getFormName();
$bg = $GD->isAutoLoginDisabled() ? "\143\150\x65\143\153\x65\x64" : '';
$pi = $GD->restrictDuplicates() ? "\143\x68\145\x63\153\145\144" : '';
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\163\57\x66\157\162\x6d\x73\57\127\x6f\157\103\x6f\x6d\155\145\162\143\x65\103\150\145\x63\153\x4f\165\164\x46\x6f\x72\155\x2e\x70\150\160";
