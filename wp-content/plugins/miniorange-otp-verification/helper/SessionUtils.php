<?php


namespace OTP\Helper;

if (defined("\101\x42\123\x50\101\124\110")) {
    goto I6;
}
die;
I6:
use OTP\Objects\FormSessionData;
use OTP\Objects\TransactionSessionData;
use OTP\Objects\VerificationType;
final class SessionUtils
{
    static function isOTPInitialized($Zm)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto eY;
        }
        return $VJ->getIsInitialized();
        eY:
        return FALSE;
    }
    static function addEmailOrPhoneVerified($Zm, $vv, $lr)
    {
        switch ($lr) {
            case VerificationType::PHONE:
                self::addPhoneVerified($Zm, $vv);
                goto Ju;
            case VerificationType::EMAIL:
                self::addEmailVerified($Zm, $vv);
                goto Ju;
        }
        NR:
        Ju:
    }
    static function addEmailSubmitted($Zm, $vv)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto Z1;
        }
        $VJ->setEmailSubmitted($vv);
        MoPHPSessions::addSessionVar($Zm, $VJ);
        Z1:
    }
    static function addPhoneSubmitted($Zm, $vv)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto j9;
        }
        $VJ->setPhoneSubmitted($vv);
        MoPHPSessions::addSessionVar($Zm, $VJ);
        j9:
    }
    static function addEmailVerified($Zm, $vv)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto aE;
        }
        $VJ->setEmailVerified($vv);
        MoPHPSessions::addSessionVar($Zm, $VJ);
        aE:
    }
    static function addPhoneVerified($Zm, $vv)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto WM;
        }
        $VJ->setPhoneVerified($vv);
        MoPHPSessions::addSessionVar($Zm, $VJ);
        WM:
    }
    static function addStatus($Zm, $vv, $QH)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto WB;
        }
        if ($VJ->getIsInitialized()) {
            goto ZM;
        }
        return;
        ZM:
        if (!($QH === VerificationType::EMAIL)) {
            goto Gy;
        }
        $VJ->setEmailVerificationStatus($vv);
        Gy:
        if (!($QH === VerificationType::PHONE)) {
            goto xU;
        }
        $VJ->setPhoneVerificationStatus($vv);
        xU:
        MoPHPSessions::addSessionVar($Zm, $VJ);
        WB:
    }
    static function isStatusMatch($Zm, $i0, $QH)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto fY;
        }
        switch ($QH) {
            case VerificationType::EMAIL:
                return $i0 === $VJ->getEmailVerificationStatus();
            case VerificationType::PHONE:
                return $i0 === $VJ->getPhoneVerificationStatus();
            case VerificationType::BOTH:
                return $i0 === $VJ->getEmailVerificationStatus() || $i0 === $VJ->getPhoneVerificationStatus();
        }
        Bg:
        Iz:
        fY:
        return FALSE;
    }
    static function isEmailVerifiedMatch($Zm, $iz)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto Up;
        }
        return $iz === $VJ->getEmailVerified();
        Up:
        return FALSE;
    }
    static function isPhoneVerifiedMatch($Zm, $iz)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto O8;
        }
        return $iz === $VJ->getPhoneVerified();
        O8:
        return FALSE;
    }
    static function setEmailTransactionID($Mc)
    {
        $wC = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($wC instanceof TransactionSessionData) {
            goto x5;
        }
        $wC = new TransactionSessionData();
        x5:
        $wC->setEmailTransactionId($Mc);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $wC);
    }
    static function setPhoneTransactionID($Mc)
    {
        $wC = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($wC instanceof TransactionSessionData) {
            goto F3;
        }
        $wC = new TransactionSessionData();
        F3:
        $wC->setPhoneTransactionId($Mc);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $wC);
    }
    static function getTransactionId($lr)
    {
        $wC = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if (!$wC instanceof TransactionSessionData) {
            goto dO1;
        }
        switch ($lr) {
            case VerificationType::EMAIL:
                return $wC->getEmailTransactionId();
            case VerificationType::PHONE:
                return $wC->getPhoneTransactionId();
            case VerificationType::BOTH:
                return MoUtility::isBlank($wC->getPhoneTransactionId()) ? $wC->getEmailTransactionId() : $wC->getPhoneTransactionId();
        }
        eR:
        bL:
        dO1:
        return '';
    }
    static function unsetSession($Qs)
    {
        foreach ($Qs as $Zm) {
            MoPHPSessions::unsetSession($Zm);
            OV:
        }
        M3:
    }
    static function isPhoneSubmittedAndVerifiedMatch($Zm)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto Xj;
        }
        return $VJ->getPhoneVerified() === $VJ->getPhoneSubmitted();
        Xj:
        return FALSE;
    }
    static function isEmailSubmittedAndVerifiedMatch($Zm)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto CU;
        }
        return $VJ->getEmailVerified() === $VJ->getEmailSubmitted();
        CU:
        return FALSE;
    }
    static function setFormOrFieldId($Zm, $vv)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto hD;
        }
        $VJ->setFieldOrFormId($vv);
        MoPHPSessions::addSessionVar($Zm, $VJ);
        hD:
    }
    static function getFormOrFieldId($Zm)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto By;
        }
        return $VJ->getFieldOrFormId();
        By:
        return '';
    }
    static function initializeForm($form)
    {
        $VJ = new FormSessionData();
        MoPHPSessions::addSessionVar($form, $VJ->init());
    }
    static function addUserInSession($Zm, $vv)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto Ay;
        }
        $VJ->setUserSubmitted($vv);
        MoPHPSessions::addSessionVar($Zm, $VJ);
        Ay:
    }
    static function getUserSubmitted($Zm)
    {
        $VJ = MoPHPSessions::getSessionVar($Zm);
        if (!$VJ instanceof FormSessionData) {
            goto Fh;
        }
        return $VJ->getUserSubmitted();
        Fh:
        return '';
    }
}
