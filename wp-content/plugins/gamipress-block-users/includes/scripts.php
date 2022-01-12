<?php
/**
 * Scripts
 *
 * @package     GamiPress\Block_Users\Scripts
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
function gamipress_block_users_admin_register_scripts() {
    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Scripts
    wp_register_script( 'gamipress-block-users-admin-js', GAMIPRESS_BLOCK_USERS_URL . 'assets/js/gamipress-block-users-admin' . $suffix . '.js', array( 'jquery', 'gamipress-admin-functions-js' ), GAMIPRESS_BLOCK_USERS_VER, true );

}
add_action( 'admin_init', 'gamipress_block_users_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_block_users_admin_enqueue_scripts( $hook ) {

    // Settings script
    if ( $hook === 'gamipress_page_gamipress_settings' ) {
        // Localize scripts
        wp_localize_script( 'gamipress-block-users-admin-js', 'gamipress_block_users_admin', array(
            'nonce' => gamipress_get_admin_nonce(),
        ) );

        wp_enqueue_script( 'gamipress-block-users-admin-js' );
    }

}
add_action( 'admin_enqueue_scripts', 'gamipress_block_users_admin_enqueue_scripts', 100 );