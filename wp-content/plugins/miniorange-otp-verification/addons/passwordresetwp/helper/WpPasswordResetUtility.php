<?php

namespace OTP\Addons\PasswordResetWp\Helper;

use OTP\Helper\MoUtility;

/**
 * This class is used to define some plugin wide utility
 * functions. The functions described here are all static
 * in nature so that it's accessible without an instance.
 */
class WpPasswordResetUtility
{
    /**
     * Checks if the customer is registered or not and shows a message on the page
     * to the user so that they can register or login themselves to use the plugin.
     */
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}