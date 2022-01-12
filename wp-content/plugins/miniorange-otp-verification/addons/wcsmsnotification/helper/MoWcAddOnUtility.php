<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use OTP\Helper\MoUtility;
use WC_Order;
use WP_User_Query;
class MoWcAddOnUtility
{
    public static function getAdminPhoneNumber()
    {
        $user = new WP_User_Query(array("\x72\157\x6c\145" => "\101\144\x6d\151\x6e\x69\x73\x74\162\141\164\x6f\162", "\x73\x65\141\162\143\150\x5f\x63\157\154\165\155\156\x73" => array("\x49\x44", "\x75\163\x65\162\x5f\154\x6f\x67\151\x6e")));
        return !empty($user->results[0]) ? get_user_meta($user->results[0]->ID, "\x62\x69\154\x6c\151\x6e\x67\137\160\x68\157\156\145", true) : '';
    }
    public static function getCustomerNumberFromOrder($z3)
    {
        $ZS = $z3->get_user_id();
        $fk = $z3->get_billing_phone();
        return !empty($fk) ? $fk : get_user_meta($ZS, "\x62\x69\154\154\151\x6e\147\x5f\x70\x68\157\156\x65", true);
    }
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}
