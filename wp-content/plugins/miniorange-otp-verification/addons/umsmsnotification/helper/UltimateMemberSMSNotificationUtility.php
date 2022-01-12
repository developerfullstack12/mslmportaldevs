<?php


namespace OTP\Addons\UmSMSNotification\Helper;

use OTP\Helper\MoUtility;
use WP_User_Query;
class UltimateMemberSMSNotificationUtility
{
    public static function getAdminPhoneNumber()
    {
        $user = new WP_User_Query(array("\162\x6f\154\145" => "\x41\144\155\151\x6e\x69\163\x74\x72\x61\164\157\x72", "\x73\145\x61\x72\x63\x68\x5f\143\157\x6c\165\155\x6e\x73" => array("\111\104", "\x75\163\145\162\x5f\x6c\157\147\151\x6e")));
        return !empty($user->results[0]) ? array(get_user_meta($user->results[0]->ID, "\155\157\x62\x69\x6c\145\137\156\x75\x6d\142\145\162", true)) : '';
    }
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}
