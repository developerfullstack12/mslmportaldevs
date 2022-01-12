<?php
/**
 * Admin
 *
 * @package     GamiPress\Email_Digests\Admin
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Add plugin admin bar menu
 *
 * @since 1.0.0
 *
 * @param WP_Admin_Bar $wp_admin_bar
 */
function gamipress_email_digests_admin_bar_menu( $wp_admin_bar ) {

    // - Email Digests
    $wp_admin_bar->add_node( array(
        'id'     => 'gamipress-email-digests',
        'title'  => __( 'Email Digests', 'gamipress-email-digests' ),
        'parent' => 'gamipress',
        'href'   => admin_url( 'admin.php?page=gamipress_email_digests' )
    ) );

}
add_action( 'admin_bar_menu', 'gamipress_email_digests_admin_bar_menu', 150 );


/**
 * Plugin Licensing meta box
 *
 * @since  1.0.0
 *
 * @param $meta_boxes
 *
 * @return mixed
 */
function gamipress_email_digests_licenses_meta_boxes( $meta_boxes ) {

    $meta_boxes['gamipress-email-digests-license'] = array(
        'title' => __( 'GamiPress Email Digests', 'gamipress-email-digests' ),
        'fields' => array(
            'gamipress_email_digests_license' => array(
                'name' => __( 'License', 'gamipress-email-digests' ),
                'type' => 'edd_license',
                'file' => GAMIPRESS_EMAIL_DIGESTS_FILE,
                'item_name' => 'Email Digests',
            ),
        )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_licenses_meta_boxes', 'gamipress_email_digests_licenses_meta_boxes' );

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_email_digests_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-email-digests'] = __( 'Email Digests', 'gamipress-email-digests' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_email_digests_automatic_updates' );