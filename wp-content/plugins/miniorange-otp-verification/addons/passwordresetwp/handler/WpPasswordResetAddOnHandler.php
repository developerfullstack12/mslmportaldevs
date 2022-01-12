<?php

namespace OTP\Addons\PasswordResetWp\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;

/**
 * The class is used to handle all wordpress Password Reset related functionality.
 * <br/><br/>
 * This class hooks into all the available notification hooks and filters of
 * wordpress to provide the possibility of overriding the default password reset
 * behaviour of  wordpress and replace it with OTP.
 */
class WpPasswordResetAddOnHandler extends BaseAddOnHandler
{
    use Instance;

    /**
     * Constructor checks if add-on has been enabled by the admin and initializes
     * all the class variables. This function also defines all the hooks to
     * hook into to make the add-on functionality work.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->moAddOnV()) return;
        WpPasswordResetHandler::instance();
    }

    /** Set a unique for the AddOn */
    function setAddonKey()
    {
        $this->_addOnKey = 'wp_pass_reset_addon';
    }

    /** Set a AddOn Description */
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("Allows your users to reset their password using OTP instead of email links."
            ."Click on the settings button to the right to configure settings for the same.");
    }

    /** Set an AddOnName */
    function setAddOnName()
    {
        $this->_addOnName = mo_("WordPress Password Reset Over OTP");
    }

    /** Set an Addon Docs link */
        function setAddOnDocs()
        {
            //$this->_addOnDocs = MoOTPDocs::ULTIMATEMEMBER_PASSWORD_RESET_ADDON_LINK['guideLink'];
        }

         /** Set an Addon Video link */
        function setAddOnVideo()
        {
            //$this->_addOnVideo = MoOTPDocs::ULTIMATEMEMBER_PASSWORD_RESET_ADDON_LINK['videoLink'];
        }

    /** Set Settings Page URL */
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg( array('addon'=> 'wppr_notif'), $_SERVER['REQUEST_URI']);
    }
}