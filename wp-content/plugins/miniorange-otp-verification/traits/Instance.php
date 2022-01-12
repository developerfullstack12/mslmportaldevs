<?php


namespace OTP\Traits;

trait Instance
{
    private static $_instance = null;
    public static function instance()
    {
        if (!is_null(self::$_instance)) {
            goto C6;
        }
        self::$_instance = new self();
        C6:
        return self::$_instance;
    }
}
