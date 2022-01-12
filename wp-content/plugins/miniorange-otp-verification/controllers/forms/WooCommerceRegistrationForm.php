<?php


use OTP\Handler\Forms\WooCommerceRegistrationForm;
use OTP\Helper\MoUtility;
$GD = WooCommerceRegistrationForm::instance();
$Gr = (bool) $GD->isFormEnabled() ? "\143\x68\145\143\153\145\x64" : '';
$b1 = $Gr == "\143\x68\145\x63\x6b\x65\x64" ? '' : "\150\x69\144\x64\x65\x6e";
$aG = $GD->getOtpTypeEnabled();
$w1 = (bool) $GD->restrictDuplicates() ? "\143\x68\145\x63\153\x65\144" : '';
$Ro = $GD->getPhoneHTMLTag();
$uB = $GD->getEmailHTMLTag();
$kq = $GD->getBothHTMLTag();
$p0 = $GD->getFormName();
$ne = $GD->redirectToPage();
$zj = MoUtility::isBlank($ne) ? '' : get_page_by_title($ne)->ID;
$wi = $GD->isAjaxForm();
$ZD = $wi ? "\x63\x68\x65\143\x6b\x65\144" : '';
$d2 = $GD->getButtonText();
$wl = $GD->isredirectToPageEnabled() ? "\143\150\x65\143\153\145\144" : '';
get_plugin_form_link($GD->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\167\x73\57\146\x6f\x72\x6d\x73\x2f\127\157\157\x43\x6f\155\x6d\145\x72\143\145\x52\145\147\151\x73\x74\x72\x61\164\x69\x6f\156\106\157\x72\x6d\56\x70\x68\x70";
