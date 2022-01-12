<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use ReflectionClass;
final class WcOrderStatus
{
    const PROCESSING = "\x70\162\157\x63\x65\x73\x73\151\156\x67";
    const ON_HOLD = "\x6f\156\x2d\150\157\154\x64";
    const CANCELLED = "\143\141\156\x63\x65\154\x6c\145\144";
    const PENDING = "\x70\145\156\144\x69\x6e\x67";
    const FAILED = "\x66\141\151\154\145\x64";
    const COMPLETED = "\143\157\155\x70\154\145\x74\145\x64";
    const REFUNDED = "\x72\145\x66\x75\x6e\x64\x65\x64";
    public static function getAllStatus()
    {
        $A1 = new ReflectionClass(self::class);
        return array_values($A1->getConstants());
    }
}
