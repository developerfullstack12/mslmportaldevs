<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Handler\Forms\YourOwnForm;
$GD = YourOwnForm::instance();
$HB = (bool) $GD->isFormEnabled() ? "\143\x68\145\x63\153\145\144" : '';
$Pl = $HB == "\x63\x68\145\143\153\145\144" ? '' : "\x68\151\144\144\145\156";
$jW = $GD->getOtpTypeEnabled();
$BD = admin_url() . "\x61\144\x6d\x69\x6e\x2e\x70\x68\x70\77\x70\141\147\x65\x3d\143\165\163\x74\x6f\x6d\x5f\x66\x6f\x72\155";
$Fp = $GD->getEmailKeyDetails();
$xO = $GD->getPhoneHTMLTag();
$o3 = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
$gF = $GD->getButtonText();
$Bf = $GD->getSubmitKeyDetails();
$i_ = $GD->getFieldKeyDetails();
include MOV_DIR . "\x76\x69\x65\167\163\57\146\157\162\155\x73\57\131\x6f\x75\x72\x4f\x77\x6e\x46\x6f\x72\x6d\x2e\x70\x68\160";
