<?php
/**
 * Listeners
 *
 * @package     GamiPress\Conditional_Notifications\Listeners
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Listener for user points balance updates
 *
 * @since 1.0.0
 *
 * @param int       $user_id
 * @param int       $new_points
 * @param int       $total_points
 * @param int       $admin_id
 * @param int       $achievement_id
 * @param string    $points_type
 * @param string    $reason
 * @param string    $log_type
 */
function gamipress_conditional_notifications_points_listener( $user_id, $new_points, $total_points, $admin_id, $achievement_id, $points_type, $reason, $log_type ) {

    $prefix = '_gamipress_conditional_notifications_';

    // Get active conditional notifications based on points balance
    $conditional_notifications = gamipress_conditional_notifications_get_active_conditional_notifications( 'points-balance' );

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    // Loop all conditional notifications
    foreach( $conditional_notifications as $conditional_notification ) {

        // Shorthand
        $id = $conditional_notification->conditional_notification_id;

        $required_points = absint( ct_get_object_meta( $id, $prefix . 'points', true ) );
        $required_points_type = ct_get_object_meta( $id, $prefix . 'points_type', true );

        // Bail wrong setup conditional notifications
        if( $required_points === 0 ) continue;

        // Bail if user doesn't meets the required points
        if( $total_points < $required_points ) continue;

        // Bail if points type doesn't matches
        if( $points_type !== $required_points_type ) continue;

        // Add to the queue of notifications to display
        gamipress_conditional_notifications_add_notification_to_display( $user_id, $id );

    }

    ct_reset_setup_table();

}
add_action( 'gamipress_update_user_points', 'gamipress_conditional_notifications_points_listener', 10, 8 );

/**
 * Listener for achievement awards
 *
 * @since 1.0.0
 *
 * @param int       $user_id
 * @param int       $achievement_id
 * @param string    $trigger
 * @param int       $site_id
 * @param array     $args
 */
function gamipress_conditional_notifications_achievement_listener( $user_id, $achievement_id, $trigger, $site_id, $args ) {

    $prefix = '_gamipress_conditional_notifications_';

    $achievement_type = gamipress_get_post_type( $achievement_id );

    // Check if ID given is an achievement
    if( ! in_array( $achievement_type, gamipress_get_achievement_types_slugs() ) ) {
        return;
    }

    // Get active conditional notifications based on specific achievement balance
    $conditional_notifications = gamipress_conditional_notifications_get_active_conditional_notifications( 'specific-achievement' );

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    foreach( $conditional_notifications as $conditional_notification ) {

        // Shorthand
        $id = $conditional_notification->conditional_notification_id;

        $required_achievement = absint( ct_get_object_meta( $id, $prefix . 'achievement', true ) );

        // Bail if user doesn't meets the required achievement
        if( $achievement_id !== $required_achievement ) continue;

        // Add to the queue of notifications to display
        gamipress_conditional_notifications_add_notification_to_display( $user_id, $id );

    }

    ct_reset_setup_table();

    // Get active conditional notifications based on specific achievement balance
    $conditional_notifications = gamipress_conditional_notifications_get_active_conditional_notifications( 'any-achievement' );

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    foreach( $conditional_notifications as $conditional_notification ) {

        // Shorthand
        $id = $conditional_notification->conditional_notification_id;

        $required_achievement_type = ct_get_object_meta( $id, $prefix . 'achievement_type', true );

        // Bail if user doesn't meets the required achievement type
        if( $achievement_type !== $required_achievement_type ) continue;

        // Add to the queue of notifications to display
        gamipress_conditional_notifications_add_notification_to_display( $user_id, $id );

    }

    ct_reset_setup_table();


}
add_action( 'gamipress_award_achievement', 'gamipress_conditional_notifications_achievement_listener', 10, 5 );

/**
 * Add a hook for each achievement type
 *
 * @since 1.0.0
 */
function gamipress_conditional_notifications_load_all_achievements_listener() {

    foreach( gamipress_get_achievement_types_slugs() as $achievement_type ) {

        add_action( "gamipress_unlock_all_{$achievement_type}", 'gamipress_conditional_notifications_all_achievements_listener', 10, 2 );
    }

}
add_action( 'init', 'gamipress_conditional_notifications_load_all_achievements_listener' );

/**
 * Listener for all achievements of type unlock
 *
 * @since 1.0.0
 *
 * @param int       $user_id
 * @param int       $achievement_id
 */
function gamipress_conditional_notifications_all_achievements_listener( $user_id, $achievement_id ) {

    $prefix = '_gamipress_conditional_notifications_';

    $achievement_type = str_replace( 'gamipress_unlock_all_', '', current_filter() );

    // Check if is a registered achievement type
    if( ! in_array( $achievement_type, gamipress_get_achievement_types_slugs() ) ) {
        return;
    }

    // Get active conditional notifications based on specific achievement balance
    $conditional_notifications = gamipress_conditional_notifications_get_active_conditional_notifications( 'all-achievements' );

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    foreach( $conditional_notifications as $conditional_notification ) {

        // Shorthand
        $id = $conditional_notification->conditional_notification_id;

        $required_achievement_type = ct_get_object_meta( $id, $prefix . 'achievement_type', true );

        // Bail if user doesn't meets the required achievement type
        if( $achievement_type !== $required_achievement_type ) continue;

        // Add to the queue of notifications to display
        gamipress_conditional_notifications_add_notification_to_display( $user_id, $id );

    }

    ct_reset_setup_table();

}

/**
 * Listener for user rank updates
 *
 * @since 1.0.0
 *
 * @param int       $user_id
 * @param WP_Post   $new_rank
 * @param WP_Post   $old_rank
 * @param int       $admin_id
 * @param int       $achievement_id
 */
function gamipress_conditional_notifications_rank_listener( $user_id, $new_rank, $old_rank, $admin_id, $achievement_id ) {

    $prefix = '_gamipress_conditional_notifications_';

    // Get active conditional notifications based on specific rank balance
    $conditional_notifications = gamipress_conditional_notifications_get_active_conditional_notifications( 'specific-rank' );

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    foreach( $conditional_notifications as $conditional_notification ) {

        // Shorthand
        $id = $conditional_notification->conditional_notification_id;

        $required_rank = absint( ct_get_object_meta( $id, $prefix . 'rank', true ) );

        // Bail if user doesn't meets the required rank
        if( absint( $new_rank->ID ) !== $required_rank ) continue;

        // Add to the queue of notifications to display
        gamipress_conditional_notifications_add_notification_to_display( $user_id, $id );

    }

    ct_reset_setup_table();

}
add_action( 'gamipress_update_user_rank', 'gamipress_conditional_notifications_rank_listener', 10, 5 );