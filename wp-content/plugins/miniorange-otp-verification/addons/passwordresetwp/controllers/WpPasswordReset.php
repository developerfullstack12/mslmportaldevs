<?php

use OTP\Addons\PasswordResetWp\Handler\WpPasswordResetHandler;
use OTP\Handler\MoOTPActionHandlerHandler;

// WordPress registration form
/** @var WpPasswordResetHandler $handler */
$handler                    = WpPasswordResetHandler::instance();
/** @var MoOTPActionHandlerHandler $adminHandler */
$adminHandler               = MoOTPActionHandlerHandler::instance();
$wppr_enabled 			    = $handler->isFormEnabled() ? "checked" : "";
$wppr_hidden 			    = $wppr_enabled=="checked" ? "" : "hidden";
$wppr_enabled_type		    = $handler->getOtpTypeEnabled();
$wppr_type_phone	 	    = $handler->getPhoneHTMLTag();
$wppr_type_email	 		= $handler->getEmailHTMLTag();
$form_name                  = $handler->getFormName();
$wppr_button_text           = $handler->getButtonText();
$nonce                      = $adminHandler->getNonceValue();
$formOption                 = $handler->getFormOption();
$wppr_field_key             = $handler->getPhoneKeyDetails();
$wppr_only_phone            = $handler->getIsOnlyPhoneReset() ? "checked" : "";


if ($wppr_enabled_type==$wppr_type_email) {
	$wppr_only_phone="";
	update_wppr_option('only_phone_reset',$wppr_only_phone);
}

include WPPR_DIR . 'views/WPPasswordReset.php';