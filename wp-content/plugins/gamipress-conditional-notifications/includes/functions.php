<?php
/**
 * Functions
 *
 * @package     GamiPress\Conditional_Notifications\Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Append custom notifications dynamic CSS
 *
 * @since 1.0.0
 *
 * @param string $css
 *
 * @return string
 */
function gamipress_conditional_notifications_dynamic_css( $css ) {

    $prefix = '_gamipress_conditional_notifications_';

    $conditional_notifications = gamipress_conditional_notifications_all_active_conditional_notifications();

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

    foreach( $conditional_notifications as $conditional_notification ) {

        // Shorthand
        $id = $conditional_notification->conditional_notification_id;

        $background_color   = ct_get_object_meta( $id, $prefix . 'background_color', true );
        $title_color        = ct_get_object_meta( $id, $prefix . 'title_color', true );
        $text_color         = ct_get_object_meta( $id, $prefix . 'text_color', true );
        $link_color         = ct_get_object_meta( $id, $prefix . 'link_color', true );
        $selector           = ".gamipress-notification.gamipress-conditional-notification-{$id}";

        if( ! empty( $background_color ) )
            $css .= "$selector { background-color: $background_color; }";

        if( ! empty( $text_color ) )
            $css .= "$selector { color: $text_color; }";

        if( ! empty( $title_color ) )
            $css .= "$selector .gamipress-notification-title { color: $title_color; }";

        if( ! empty( $link_color ) )
            $css .= "$selector a { color: $link_color; }";

    }

    ct_reset_setup_table();

    return $css;

}
add_filter( 'gamipress_notifications_dynamic_css', 'gamipress_conditional_notifications_dynamic_css' );

/**
 * Add conditional notification to user notifications
 *
 * @since 1.0.0
 *
 * @param array $response
 * @param int   $user_id
 * @param bool  $user_points
 *
 * @return array
 */
function gamipress_conditional_notifications_append_to_user_notifications( $response, $user_id, $user_points ) {

    global $gamipress_conditional_notifications_template_args;

    $prefix = '_gamipress_conditional_notifications_';

    $to_display = gamipress_get_user_meta( $user_id, $prefix . 'to_display' );
    $to_display = explode( ',', $to_display );
    $displayed = array();

    foreach( $to_display as $id ) {

        // Make loop faster by prevent to check empty ids
        if( absint( $id ) === 0 ) continue;

        // Setup table
        // Note: Need to be setup on each loop since parse tags sometimes doesn't resets correctly the user earnings table
        $ct_table = ct_setup_table( 'gamipress_conditional_notifications' );

        $conditional_notification = ct_get_object( $id );

        // Bail if conditional notification not exists
        if( ! $conditional_notification ) continue;

        // Bail if conditional notification is not active
        if( $conditional_notification->status !== 'active' ) continue;

        /**
         * Filter the conditional notification title
         *
         * @since 1.0.0
         *
         * @param string    $title
         * @param int       $user_id
         * @param int       $conditional_notification_id
         * @param stdClass  $conditional_notification
         */
        $title = apply_filters( 'gamipress_conditional_notifications_conditional_notification_title', $conditional_notification->subject, $user_id, $id, $conditional_notification );

        $title = gamipress_conditional_notifications_parse_pattern_tags( $title, $user_id );

        /**
         * Filter the conditional notification content
         *
         * @since 1.0.0
         *
         * @param string    $title
         * @param int       $user_id
         * @param int       $conditional_notification_id
         * @param stdClass  $conditional_notification
         */
        $content = apply_filters( 'gamipress_conditional_notifications_conditional_notification_content', $conditional_notification->content, $user_id, $id, $conditional_notification );

        $content = gamipress_conditional_notifications_parse_pattern_tags( $content, $user_id );

        // Text formatting and shortcode execution
        $content = wpautop( $content );
        $content = do_shortcode( $content );

        // Initialize template args
        $gamipress_conditional_notifications_template_args = array(
            'conditional_notification_id'   => $id,
            'conditional_notification'      => $conditional_notification,
            'notification_title'            => $title,
            'notification_content'          => $content,
        );

        // Setup the notification content
        ob_start();
        gamipress_get_template_part( 'conditional-notification' );
        $content = ob_get_clean();

        if( ! empty( $content ) ) {

            // Show sound effect
            $show_sound = ct_get_object_meta( $id, $prefix . 'show_sound', true );

            // If not sound setup, get the sound from settings
            if( empty( $show_sound ) ) {
                $show_sound = gamipress_notifications_get_option( 'show_sound', '' );
            }

            if( ! empty( $show_sound ) ) {
                $content .= '<div id="gamipress-notification-show-sound" data-src="' . $show_sound . '"></div>';
            }

            // Hide sound effect
            $hide_sound = ct_get_object_meta( $id, $prefix . 'hide_sound', true );

            // If not sound setup, get the sound from settings
            if( empty( $hide_sound ) ) {
                $hide_sound = gamipress_notifications_get_option( 'hide_sound', '' );
            }

            if( ! empty( $hide_sound ) ) {
                $content .= '<div id="gamipress-notification-hide-sound" data-src="' . $hide_sound . '"></div>';
            }

            $response['notices'][] = $content;

        }

        $displayed[] = $id;

        ct_reset_setup_table();

    }

    // Loop notifications displayed again to mark them
    foreach( $displayed as $id ) {

        // Mark as displayed
        if( (bool) gamipress_notifications_get_option( 'disable_live_checks', false ) ) {
            // If live checks disabled, mark as displayed
            gamipress_conditional_notifications_notification_shown( $user_id, $id );
        } else {
            // If live checks enabled, then add to a list of conditional notifications to being marked as displayed on last check update
            gamipress_conditional_notifications_add_notification_to_mark( $user_id, $id );
        }

    }

    return $response;

}
add_filter( 'gamipress_notifications_get_user_notifications', 'gamipress_conditional_notifications_append_to_user_notifications', 10, 3 );

/**
 * Ajax function to notify to the server last time user has check the notifications
 *
 * @since   1.0.0
 * @updated 1.0.5 Bind this function to 'gamipress_notifications_ajax_last_check_updated' action
 *
 * @param int       $user_id    The given user's ID
 * @param int       $last_check Last check timestamp
 */
function gamipress_conditional_notifications_ajax_last_check( $user_id, $last_check ) {

    $prefix = '_gamipress_conditional_notifications_';

    // Bail if no user given
    if( $user_id === 0 ) return;

    // Bail if live checks has been disabled
    if( (bool) gamipress_notifications_get_option( 'disable_live_checks', false ) )
        return;

    // Notifications to mark
    $to_mark = gamipress_get_user_meta( $user_id, $prefix . 'to_mark' );
    $to_mark = explode( ',', $to_mark );

    // Bail if not notifications to mark as shown
    if( empty( $to_mark ) ) return;

    // Notifications shown
    $shown = gamipress_get_user_meta( $user_id, $prefix . 'shown' );
    $shown = explode( ',', $shown );

    foreach( $to_mark as $index => $id ) {

        // Add to notifications shown if hasn't been added yet (but don't skip loop to avoid repeated notifications
        if( ! in_array( $id, $shown ) )
            $shown[] = $id;

        // Remove from notifications to mark
        unset( $to_mark[$index] );

        // Remove from to display
        gamipress_conditional_notifications_remove_notification_to_display( $user_id, $id );

    }

    // Update notifications to mark
    $to_mark = implode( ',', $to_mark );
    gamipress_update_user_meta( $user_id, $prefix . 'to_mark', $to_mark );

    // Update notifications shown
    $shown = implode( ',', $shown );
    gamipress_update_user_meta( $user_id, $prefix . 'shown', $shown );

}
add_action( 'gamipress_notifications_ajax_last_check_updated', 'gamipress_conditional_notifications_ajax_last_check', 10, 2 );

/**
 * Add a new conditional notification to display
 *
 * @since 1.0.0
 *
 * @param int $user_id
 * @param int $conditional_notification_id
 *
 * @return bool
 */
function gamipress_conditional_notifications_add_notification_to_display( $user_id, $conditional_notification_id ) {

    $prefix = '_gamipress_conditional_notifications_';

    // Setup table
    ct_setup_table( 'gamipress_conditional_notifications' );

    // Shorthand
    $id = $conditional_notification_id;

    // Check max displays
    $displays = absint( ct_get_object_meta( $id, $prefix . 'displays', true ) );
    $max_displays = absint( ct_get_object_meta( $id, $prefix . 'max_displays', true ) );

    // Check if max displays has been exceeded
    if( $max_displays !== 0 && $displays >= $max_displays )
        return false;

    $shown = gamipress_get_user_meta( $user_id, $prefix . 'shown' );
    $shown = explode( ',', $shown );

    $condition = absint( ct_get_object_meta( $id, $prefix . 'condition', true ) );

    // Prevent to display the notification more than 1 time for points balance and all achievements conditions
    if( in_array( $condition, array( 'points-balance', 'all-achievements' ) ) ) {
        // Bail if notification has been already shown to the user
        if( in_array( $id, $shown ) ) return false;
    }

    $to_display = gamipress_get_user_meta( $user_id, $prefix . 'to_display' );
    $to_display = explode( ',', $to_display );

    // Bail if notification will be displayed
    if( in_array( $id, $to_display ) ) return false;

    $to_display[] = $id;
    $to_display = implode( ',', $to_display );

    // Update the user meta
    gamipress_update_user_meta( $user_id, $prefix . 'to_display', $to_display );

    // Increase notification displays
    ct_update_object_meta( $id, $prefix . 'displays', ( $displays + 1 ), $displays );

    ct_reset_setup_table();

    return true;

}

/**
 * Remove a conditional notification to display
 *
 * @since 1.0.0
 *
 * @param int $user_id
 * @param int $conditional_notification_id
 *
 * @return bool
 */
function gamipress_conditional_notifications_remove_notification_to_display( $user_id, $conditional_notification_id ) {

    $prefix = '_gamipress_conditional_notifications_';

    // Shorthand
    $id = absint( $conditional_notification_id );

    $to_display = gamipress_get_user_meta( $user_id, $prefix . 'to_display' );
    $to_display = explode( ',', $to_display );

    // Bail if notification won't be displayed
    if( ! in_array( $id, $to_display ) ) return false;

    foreach( $to_display as $index => $to_display_id ) {

        if( absint( $to_display_id ) === $id )
            unset( $to_display[$index] );

    }

    $to_display = implode( ',', $to_display );

    // Update the user meta
    gamipress_update_user_meta( $user_id, $prefix . 'to_display', $to_display );

    return true;

}

/**
 * Add a new conditional notification to being marked as shown
 *
 * @since 1.0.0
 *
 * @param int $user_id
 * @param int $conditional_notification_id
 *
 * @return bool
 */
function gamipress_conditional_notifications_add_notification_to_mark( $user_id, $conditional_notification_id ) {

    $prefix = '_gamipress_conditional_notifications_';

    // Shorthand
    $id = $conditional_notification_id;

    $to_mark = gamipress_get_user_meta( $user_id, $prefix . 'to_mark' );
    $to_mark = explode( ',', $to_mark );

    // Bail if notification has been already marked to being marked as shown to the user
    if( in_array( $id, $to_mark ) ) return false;

    $to_mark[] = $id;
    $to_mark = implode( ',', $to_mark );

    // Update the user meta
    gamipress_update_user_meta( $user_id, $prefix . 'to_mark', $to_mark );

    return true;

}

/**
 * Add a conditional notification as shown
 *
 * @since 1.0.0
 *
 * @param int $user_id
 * @param int $conditional_notification_id
 *
 * @return bool
 */
function gamipress_conditional_notifications_notification_shown( $user_id, $conditional_notification_id ) {

    $prefix = '_gamipress_conditional_notifications_';

    // Shorthand
    $id = $conditional_notification_id;

    $shown = gamipress_get_user_meta( $user_id, $prefix . 'shown' );
    $shown = explode( ',', $shown );

    if( ! in_array( $id, $shown ) ) {

        $shown[] = $id;
        $shown = implode( ',', $shown );

        // Update the user meta
        gamipress_update_user_meta( $user_id, $prefix . 'shown', $shown );

    }

    // Remove from to display
    gamipress_conditional_notifications_remove_notification_to_display( $user_id, $conditional_notification_id );

    return true;

}
