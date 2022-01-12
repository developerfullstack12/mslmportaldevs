<?php
/**
 * AddOn Name: Wordpress Password Reset through OTP
 * Plugin URI: http://miniorange.com
 * Description: Allow users to reset their password via OTP
 * Version: 1.0.0
 * Author: miniOrange
 * Author URI: http://miniorange.com
 * Text Domain: miniorange-otp-verification
 * License: GPL2
 */

namespace OTP\Addons\PasswordResetWp;

use OTP\Addons\PasswordResetWp\Handler\WpPasswordResetAddOnHandler;
use OTP\Addons\PasswordResetWp\Helper\WpPasswordResetMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;

if(! defined( 'ABSPATH' )) exit;
include '_autoload.php';

final class  WordPressPasswordReset extends BaseAddOn implements AddOnInterface
{
    use Instance;

    public function __construct()
	{
	    parent::__construct();
		add_action( 'admin_enqueue_scripts'					    , array( $this, 'wp_pr_notif_settings_style'   ) );
        add_action( 'mo_otp_verification_delete_addon_options'	, array( $this, 'wp_pr_notif_delete_options' 	) );
	}

	/**
	 * This function is called to append our CSS file
	 * in the backend and frontend. Uses the admin_enqueue_scripts
	 * and enqueue_scripts WordPress hook.
	 */
	function wp_pr_notif_settings_style()
	{
		wp_enqueue_style( 'wp_pr_notif_admin_settings_style', WPPR_CSS_URL);
	}

    /**
     * Initialize all handlers associated with the addon
     */
    function initializeHandlers()
    {
        /** @var AddOnList $list */
        $list = AddOnList::instance();
        /** @var WpPasswordResetAddOnHandler $handler */
        $handler = WpPasswordResetAddOnHandler::instance();
        $list->add($handler->getAddOnKey(),$handler);
    }

    /**
     * Initialize all helper associated with the addon
     */
    function initializeHelpers()
    {
        WpPasswordResetMessages::instance();
    }


    /**
     * This function hooks into the mo_otp_verification_add_on_controller
     * hook to show ultimate notification settings page and forms for
     * validation.
     */
    function show_addon_settings_page()
    {
        include WPPR_DIR . 'controllers/main-controller.php';
    }

	/**
     * Function is called during deletion of the plugin to delete any options
     * related to the add-on. This function hooks into the 'mo_otp_verification_delete_addon_options'
     * hook of the OTP verification plugin.
     */
	function wp_pr_notif_delete_options()
    {
        delete_site_option('mo_wp_pr_pass_enable');
        delete_site_option('mo_wp_pr_pass_button_text');
        delete_site_option('mo_wp_pr_enabled_type');
    }
}