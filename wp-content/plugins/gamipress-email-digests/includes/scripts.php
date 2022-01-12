<?php
/**
 * Scripts
 *
 * @package     GamiPress\Email_Digests\Scripts
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
function gamipress_email_digests_admin_register_scripts( $hook ) {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-email-digests-admin-css', GAMIPRESS_EMAIL_DIGESTS_URL . 'assets/css/gamipress-email-digests-admin' . $suffix . '.css', array( ), GAMIPRESS_EMAIL_DIGESTS_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-email-digests-admin-js', GAMIPRESS_EMAIL_DIGESTS_URL . 'assets/js/gamipress-email-digests-admin' . $suffix . '.js', array( 'jquery', 'gamipress-admin-functions-js', 'gamipress-select2-js' ), GAMIPRESS_EMAIL_DIGESTS_VER, true );

}
add_action( 'admin_init', 'gamipress_email_digests_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_email_digests_admin_enqueue_scripts( $hook ) {

    //Scripts

    // Email Digests add/edit screen
    if( $hook === 'gamipress_page_gamipress_email_digests' || $hook === 'admin_page_edit_gamipress_email_digests' ) {

        //Stylesheets
        wp_enqueue_style( 'gamipress-email-digests-admin-css' );
        wp_enqueue_style( 'gamipress-select2-css' );

        //Scripts
        wp_enqueue_script( 'gamipress-email-digests-admin-js' );

    }

}
add_action( 'admin_enqueue_scripts', 'gamipress_email_digests_admin_enqueue_scripts', 100 );