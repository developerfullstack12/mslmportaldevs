<?php


namespace OTP\Objects;

interface IMoSessions
{
    static function addSessionVar($Zm, $vv);
    static function getSessionVar($Zm);
    static function unsetSession($Zm);
    static function checkSession();
}
