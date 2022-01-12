<?php
/**
 * Scripts
 *
 * @package     GamiPress\Conditional_Notifications\Scripts
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_conditional_notifications_admin_register_scripts( $hook ) {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-conditional-notifications-admin-css', GAMIPRESS_CONDITIONAL_NOTIFICATIONS_URL . 'assets/css/gamipress-conditional-notifications-admin' . $suffix . '.css', array(), GAMIPRESS_CONDITIONAL_NOTIFICATIONS_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-conditional-notifications-admin-js', GAMIPRESS_CONDITIONAL_NOTIFICATIONS_URL . 'assets/js/gamipress-conditional-notifications-admin' . $suffix . '.js', array( 'jquery', 'gamipress-admin-functions-js', 'gamipress-select2-js' ), GAMIPRESS_CONDITIONAL_NOTIFICATIONS_VER, true );

}
add_action( 'admin_init', 'gamipress_conditional_notifications_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_conditional_notifications_admin_enqueue_scripts( $hook ) {

    //Scripts

    // Email Digests add/edit screen
    if( $hook === 'gamipress_page_gamipress_conditional_notifications' || $hook === 'admin_page_edit_gamipress_conditional_notifications' ) {

        // Enqueue admin functions
        gamipress_enqueue_admin_functions_script();

        //Stylesheets
        wp_enqueue_style( 'gamipress-conditional-notifications-admin-css' );

        //Scripts
        wp_enqueue_script( 'gamipress-conditional-notifications-admin-js' );

    }

}
add_action( 'admin_enqueue_scripts', 'gamipress_conditional_notifications_admin_enqueue_scripts', 100 );