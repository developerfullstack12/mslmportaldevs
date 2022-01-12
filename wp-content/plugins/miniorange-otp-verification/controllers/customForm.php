<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Handler\CustomForm;
$fD = $Uh->getNonceValue();
$GD = CustomForm::instance();
$Bf = $GD->getSubmitKeyDetails();
$HB = $Bf != '' || empty($Bf) ? true : false;
$mu = get_mo_option("\143\146\137\x65\x6e\141\x62\154\145\x5f\164\x79\160\145", "\155\157\x5f\157\x74\160\x5f");
$i_ = $GD->getFieldKeyDetails();
$xO = $GD->getPhoneHTMLTag();
$o3 = $GD->getEmailHTMLTag();
$gF = $GD->getButtonText();
include MOV_DIR . "\x76\x69\145\167\163\x2f\143\x75\x73\x74\x6f\155\x46\157\162\155\56\x70\150\160";
