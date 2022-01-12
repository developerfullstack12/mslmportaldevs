<?php


namespace OTP\Objects;

class TransactionSessionData
{
    private $emailTransactionId;
    private $phoneTransactionId;
    public function getEmailTransactionId()
    {
        return $this->emailTransactionId;
    }
    public function setEmailTransactionId($xx)
    {
        $this->emailTransactionId = $xx;
    }
    public function getPhoneTransactionId()
    {
        return $this->phoneTransactionId;
    }
    public function setPhoneTransactionId($ho)
    {
        $this->phoneTransactionId = $ho;
    }
}
