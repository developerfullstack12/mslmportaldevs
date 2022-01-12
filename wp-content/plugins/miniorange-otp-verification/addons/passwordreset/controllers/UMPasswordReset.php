<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
$GD = UMPasswordResetHandler::instance();
$Uh = MoOTPActionHandlerHandler::instance();
$z6 = $GD->isFormEnabled() ? "\x63\150\x65\x63\153\145\144" : '';
$Z5 = $z6 == "\143\x68\145\x63\153\x65\144" ? '' : "\x68\x69\x64\x64\145\156";
$l6 = $GD->getOtpTypeEnabled();
$QW = $GD->getPhoneHTMLTag();
$yj = $GD->getEmailHTMLTag();
$p0 = $GD->getFormName();
$eG = $GD->getButtonText();
$fD = $Uh->getNonceValue();
$pu = $GD->getFormOption();
$vH = $GD->getPhoneKeyDetails();
$DN = $GD->getIsOnlyPhoneReset() ? "\143\150\x65\x63\x6b\145\x64" : '';
include UMPR_DIR . "\x76\151\x65\x77\x73\57\x55\x4d\x50\x61\x73\163\x77\x6f\x72\144\122\145\163\145\164\56\x70\150\x70";
