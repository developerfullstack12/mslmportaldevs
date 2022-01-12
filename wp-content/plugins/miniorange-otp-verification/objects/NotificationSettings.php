<?php


namespace OTP\Objects;

if (defined("\101\x42\123\120\x41\124\110")) {
    goto VQ;
}
die;
VQ:
class NotificationSettings
{
    public $sendSMS;
    public $sendEmail;
    public $phoneNumber;
    public $fromEmail;
    public $fromName;
    public $toEmail;
    public $toName;
    public $subject;
    public $bccEmail;
    public $message;
    public function __construct()
    {
        if (func_num_args() < 4) {
            goto Pi;
        }
        $this->createEmailNotificationSettings(func_get_arg(0), func_get_arg(1), func_get_arg(2), func_get_arg(3), func_get_arg(4));
        goto Mb;
        Pi:
        $this->createSMSNotificationSettings(func_get_arg(0), func_get_arg(1));
        Mb:
    }
    public function createSMSNotificationSettings($Zu, $SF)
    {
        $this->sendSMS = TRUE;
        $this->phoneNumber = $Zu;
        $this->message = $SF;
    }
    public function createEmailNotificationSettings($s0, $dB, $qD, $Rk, $SF)
    {
        $this->sendEmail = TRUE;
        $this->fromEmail = $s0;
        $this->fromName = $dB;
        $this->toEmail = $qD;
        $this->toName = $qD;
        $this->subject = $Rk;
        $this->bccEmail = '';
        $this->message = $SF;
    }
}
