<?php


namespace OTP\Objects;

class FormSessionData
{
    private $isInitialized = false;
    private $emailSubmitted;
    private $phoneSubmitted;
    private $emailVerified;
    private $phoneVerified;
    private $emailVerificationStatus;
    private $phoneVerificationStatus;
    private $fieldOrFormId;
    private $userSubmitted;
    function __construct()
    {
    }
    function init()
    {
        $this->isInitialized = true;
        return $this;
    }
    public function getIsInitialized()
    {
        return $this->isInitialized;
    }
    public function getEmailSubmitted()
    {
        return $this->emailSubmitted;
    }
    public function setEmailSubmitted($L5)
    {
        $this->emailSubmitted = $L5;
    }
    public function getPhoneSubmitted()
    {
        return $this->phoneSubmitted;
    }
    public function setPhoneSubmitted($OF)
    {
        $this->phoneSubmitted = $OF;
    }
    public function getEmailVerified()
    {
        return $this->emailVerified;
    }
    public function setEmailVerified($T1)
    {
        $this->emailVerified = $T1;
    }
    public function getPhoneVerified()
    {
        return $this->phoneVerified;
    }
    public function setPhoneVerified($Ci)
    {
        $this->phoneVerified = $Ci;
    }
    public function getEmailVerificationStatus()
    {
        return $this->emailVerificationStatus;
    }
    public function setEmailVerificationStatus($C1)
    {
        $this->emailVerificationStatus = $C1;
    }
    public function getPhoneVerificationStatus()
    {
        return $this->phoneVerificationStatus;
    }
    public function setPhoneVerificationStatus($Mg)
    {
        $this->phoneVerificationStatus = $Mg;
    }
    public function getFieldOrFormId()
    {
        return $this->fieldOrFormId;
    }
    public function setFieldOrFormId($nS)
    {
        $this->fieldOrFormId = $nS;
    }
    public function getUserSubmitted()
    {
        return $this->userSubmitted;
    }
    public function setUserSubmitted($fh)
    {
        $this->userSubmitted = $fh;
    }
}
