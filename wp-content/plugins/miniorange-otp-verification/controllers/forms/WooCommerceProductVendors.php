<?php


use OTP\Handler\Forms\WooCommerceProductVendors;
$GD = WooCommerceProductVendors::instance();
$uE = (bool) $GD->isFormEnabled() ? "\143\x68\x65\143\153\x65\144" : '';
$xc = $uE == "\143\x68\145\143\153\145\144" ? '' : "\x68\151\144\144\x65\x6e";
$lL = $GD->getOtpTypeEnabled();
$la = (bool) $GD->restrictDuplicates() ? "\143\x68\x65\x63\153\145\144" : '';
$a4 = $GD->getPhoneHTMLTag();
$cm = $GD->getEmailHTMLTag();
$n0 = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
$wi = $GD->isAjaxForm();
$ZD = $wi ? "\143\150\145\143\x6b\x65\144" : '';
$R0 = $GD->getButtonText();
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\x73\x2f\146\x6f\x72\x6d\x73\x2f\127\157\157\x43\x6f\155\x6d\145\x72\143\145\120\x72\157\x64\165\x63\164\x56\x65\156\x64\157\162\x73\x2e\x70\x68\160";
