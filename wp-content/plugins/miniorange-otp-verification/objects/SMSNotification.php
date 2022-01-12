<?php


namespace OTP\Objects;

abstract class SMSNotification
{
    public $page;
    public $isEnabled;
    public $tooltipHeader;
    public $tooltipBody;
    public $recipient;
    public $smsBody;
    public $defaultSmsBody;
    public $title;
    public $availableTags;
    public $pageHeader;
    public $pageDescription;
    public $notificationType;
    function __construct()
    {
    }
    public abstract function sendSMS(array $LD);
    public function setIsEnabled($MO)
    {
        $this->isEnabled = $MO;
        return $this;
    }
    public function setRecipient($it)
    {
        $this->recipient = $it;
        return $this;
    }
    public function setSmsBody($p6)
    {
        $this->smsBody = $p6;
        return $this;
    }
}
