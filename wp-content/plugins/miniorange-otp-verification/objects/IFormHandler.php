<?php


namespace OTP\Objects;

interface IFormHandler
{
    public function unsetOTPSessionVariables();
    public function handle_post_verification($u8, $wB, $CG, $hs, $J9, $tA, $lr);
    public function handle_failed_verification($wB, $CG, $J9, $lr);
    public function handleForm();
    public function handleFormOptions();
    public function getPhoneNumberSelector($zX);
    public function isLoginOrSocialForm($Hd);
    public function is_ajax_form_in_play($WB);
    public function getPhoneHTMLTag();
    public function getEmailHTMLTag();
    public function getBothHTMLTag();
    public function getFormKey();
    public function getFormName();
    public function getOtpTypeEnabled();
    public function disableAutoActivation();
    public function getPhoneKeyDetails();
    public function isFormEnabled();
    public function getEmailKeyDetails();
    public function getButtonText();
    public function getFormDetails();
    public function getVerificationType();
    public function getFormDocuments();
}
