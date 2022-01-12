<?php
/**
 * Custom Tables
 *
 * @package     GamiPress\Conditional_Notifications\Custom_Tables
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

require_once GAMIPRESS_CONDITIONAL_NOTIFICATIONS_DIR . 'includes/custom-tables/conditional-notifications.php';

/**
 * Register all plugin Custom DB Tables
 *
 * @since  1.0.0
 *
 * @return void
 */
function gamipress_conditional_notifications_register_custom_tables() {

    // Conditional Notifications Table
    ct_register_table( 'gamipress_conditional_notifications', array(
        'singular' => __( 'Conditional Notification', 'gamipress-conditional-notifications' ),
        'plural' => __( 'Conditional Notifications', 'gamipress-conditional-notifications' ),
        'show_ui' => true,
        'version' => 1,
        'global' => gamipress_is_network_wide_active(),
        'supports' => array( 'meta' ),
        'views' => array(
            'list' => array(
                'menu_title' => __( 'Conditional Notifications', 'gamipress-conditional-notifications' ),
                'parent_slug' => 'gamipress'
            ),
            'add' => array(
                'show_in_menu' => false,
            ),
            'edit' => array(
                'show_in_menu' => false,
            ),
        ),
        'schema' => array(
            'conditional_notification_id' => array(
                'type' => 'bigint',
                'length' => '20',
                'auto_increment' => true,
                'primary_key' => true,
            ),
            'title' => array(
                'type' => 'text',
            ),
            'subject' => array(
                'type' => 'text',
            ),
            'content' => array(
                'type' => 'longtext',
            ),
            'status' => array(
                'type' => 'text',
            ),
            'date' => array(
                'type' => 'datetime',
                'default' => '0000-00-00 00:00:00'
            ),
        ),
    ) );

}
add_action( 'ct_init', 'gamipress_conditional_notifications_register_custom_tables' );