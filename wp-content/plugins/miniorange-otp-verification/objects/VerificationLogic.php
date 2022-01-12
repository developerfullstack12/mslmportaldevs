<?php


namespace OTP\Objects;

abstract class VerificationLogic
{
    public abstract function _handle_logic($wB, $CG, $J9, $rI, $Wj);
    public abstract function _handle_otp_sent($wB, $CG, $J9, $rI, $Wj, $SC);
    public abstract function _handle_otp_sent_failed($wB, $CG, $J9, $rI, $Wj, $SC);
    public abstract function _get_otp_sent_message();
    public abstract function _get_otp_sent_failed_message();
    public abstract function _get_otp_invalid_format_message();
    public abstract function _get_is_blocked_message();
    public abstract function _handle_matched($wB, $CG, $J9, $rI, $Wj);
    public abstract function _handle_not_matched($J9, $rI, $Wj);
    public abstract function _start_otp_verification($wB, $CG, $J9, $rI, $Wj);
    public abstract function _is_blocked($CG, $J9);
    public static function _is_ajax_form()
    {
        return (bool) apply_filters("\x69\163\137\x61\x6a\x61\170\x5f\146\157\x72\x6d", FALSE);
    }
}
