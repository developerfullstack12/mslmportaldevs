<?php
/**
 * Conditional Notifications Functions
 *
 * @package     GamiPress\Conditional_Notifications\Conditional_Notifications_Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Get the registered conditional notifications statuses
 *
 * @since  1.0.0
 *
 * @return array Array of conditional notifications statuses
 */
function gamipress_conditional_notifications_get_conditional_notification_statuses() {

    return apply_filters( 'gamipress_conditional_notifications_get_conditional_notification_statuses', array(
        'active'    => __( 'Active', 'gamipress-conditional-notifications' ),
        'inactive'  => __( 'Inactive', 'gamipress-conditional-notifications' ),
    ) );

}

/**
 * Get the registered conditional notifications conditions
 *
 * @since  1.0.0
 *
 * @return array Array of conditional notifications conditions
 */
function gamipress_conditional_notifications_get_conditional_notification_conditions() {

    return apply_filters( 'gamipress_conditional_notifications_get_conditional_notification_conditions', array(
        'points-balance'        => __( 'Reach a points balance', 'gamipress-conditional-notifications' ),
        'specific-achievement'  => __( 'Unlock a specific achievement', 'gamipress-conditional-notifications' ),
        'any-achievement'       => __( 'Unlock any achievement of type', 'gamipress-conditional-notifications' ),
        'all-achievements'     	=> __( 'Unlock all achievements of type', 'gamipress-conditional-notifications' ),
        'specific-rank'         => __( 'Reach a specific rank', 'gamipress-conditional-notifications' ),
    ) );

}

/**
 * Get all active conditional notifications
 *
 * @since  1.0.0
 *
 * @return array
 */
function gamipress_conditional_notifications_all_active_conditional_notifications() {

    global $wpdb;

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    // Search all conditional notifications actives and published before current date
    $conditional_notifications = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM {$ct_table->db->table_name} AS cn
        WHERE cn.status = %s
          AND cn.date < %s",
        'active',
        date( 'Y-m-d 00:00:00', current_time('timestamp') )
    ) );

    ct_reset_setup_table();

    /**
     * Filter all active conditional notifications
     *
     * @since  1.0.0
     *
     * @param array     $conditional_notifications
     *
     * @return array
     */
    return apply_filters( 'gamipress_conditional_notifications_all_active_conditional_notifications', $conditional_notifications );

}

/**
 * Get all active conditional notifications based on given condition
 *
 * @since  1.0.0
 *
 * @param string $condition
 *
 * @return array
 */
function gamipress_conditional_notifications_get_active_conditional_notifications( $condition ) {

    global $wpdb;

    $prefix = '_gamipress_conditional_notifications_';

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    // Search all conditional notifications actives, published before current date and based on a given condition
    $conditional_notifications = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM {$ct_table->db->table_name} AS cn
        LEFT JOIN {$ct_table->meta->db->table_name} AS cnm ON ( cn.conditional_notification_id = cnm.conditional_notification_id AND cnm.meta_key = %s )
        WHERE cnm.meta_value = %s
          AND cn.status = %s
          AND cn.date < %s",
        $prefix . 'condition',
        $condition,
        'active',
        date( 'Y-m-d 00:00:00', current_time('timestamp') )
    ) );

    ct_reset_setup_table();

    /**
     * Filter active conditional notifications based on given condition
     *
     * @since  1.0.0
     *
     * @param array     $conditional_notifications
     * @param string    $condition
     *
     * @return array
     */
    return apply_filters( 'gamipress_conditional_notifications_get_active_conditional_notifications', $conditional_notifications, $condition );

}