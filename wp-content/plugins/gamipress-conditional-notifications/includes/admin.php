<?php
/**
 * Admin
 *
 * @package     GamiPress\Conditional_Notifications\Admin
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
function gamipress_conditional_notifications_admin_bar_menu( $wp_admin_bar ) {

    // - Conditional Notifications
    $wp_admin_bar->add_node( array(
        'id'     => 'gamipress-conditional-notifications',
        'title'  => __( 'Conditional Notifications', 'gamipress-conditional-notifications' ),
        'parent' => 'gamipress',
        'href'   => admin_url( 'admin.php?page=gamipress_conditional_notifications' )
    ) );

}
add_action( 'admin_bar_menu', 'gamipress_conditional_notifications_admin_bar_menu', 150 );


/**
 * Plugin Licensing meta box
 *
 * @since  1.0.0
 *
 * @param $meta_boxes
 *
 * @return mixed
 */
function gamipress_conditional_notifications_licenses_meta_boxes( $meta_boxes ) {

    $meta_boxes['gamipress-conditional-notifications-license'] = array(
        'title' => __( 'GamiPress Conditional Notifications', 'gamipress-conditional-notifications' ),
        'fields' => array(
            'gamipress_conditional_notifications_license' => array(
                'name' => __( 'License', 'gamipress-conditional-notifications' ),
                'type' => 'edd_license',
                'file' => GAMIPRESS_CONDITIONAL_NOTIFICATIONS_FILE,
                'item_name' => 'Conditional Notifications',
            ),
        )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_licenses_meta_boxes', 'gamipress_conditional_notifications_licenses_meta_boxes' );

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_conditional_notifications_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-conditional-notifications'] = __( 'Conditional Notifications', 'gamipress-conditional-notifications' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_conditional_notifications_automatic_updates' );