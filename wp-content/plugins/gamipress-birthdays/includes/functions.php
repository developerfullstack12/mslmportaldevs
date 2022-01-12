<?php
/**
 * Functions
 *
 * @package GamiPress\Birthdays\Functions
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Checks for today birthdays
 *
 * This function is only intended to be used by WordPress cron.
 *
 * To force the use of this function outside cron, set a code like:
 * define( 'DOING_CRON', true );
 * gamipress_birthdays_check();
 *
 * @since 1.0.0
 *
 * @param string $date A valid date in Y-m-d format
 */
function gamipress_birthdays_check( $date = '' ) {

    global $wpdb, $bp;

    if( empty( $date ) ) {
        $date = date( 'Y-m-d', current_time( 'timestamp' ) );
    }

    $last_check = get_option( 'gamipress_birthdays_last_check', false );

    // Bail if have checked today
    if( $last_check === $date ) {
        return;
    }

    // Mark today as checked
    update_option( 'gamipress_birthdays_last_check', $date, false );

    $from = gamipress_birthdays_get_option( 'from', 'user_meta' );
    $users = array();

    if( $from === 'user_meta' ) {
        $user_meta = gamipress_birthdays_get_option( 'user_meta', '' );

        // Bail if not configured
        if( empty( $user_meta ) ) {
            return;
        }

        // Get users with this meta
        $users = $wpdb->get_results( $wpdb->prepare(
            "SELECT user_id, meta_value AS birthday FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value LIKE %s",
            $user_meta,
            '%' . $wpdb->esc_like( date( '-m-d', strtotime( $date ) ) ) . '%'
        ) );
    } else if( $from === 'buddypress_field' ) {

        $buddypress_field = gamipress_birthdays_get_option( 'buddypress_field', '' );

        // Bail if not configured
        if( empty( $buddypress_field ) ) {
            return;
        }

        // Get users with this profile field
        $users = $wpdb->get_results( $wpdb->prepare(
            "SELECT user_id, value AS birthday FROM {$bp->profile->table_name_data} WHERE field_id = %d AND value LIKE %s;",
            absint( $buddypress_field ),
            '%' . $wpdb->esc_like( date( '-m-d', strtotime( $date ) ) ) . '%'
        ) );

    }

    foreach( $users as $user ) {

        $birthday = date( 'Y-m-d', strtotime( $user->birthday ) );

        // Calculate the difference in years
        $from = date_create( $birthday );
        $to = date_create( $date );

        $interval = date_diff( $from, $to );

        $birthday = (int) $interval->format('%y');

        /**
         * Action triggered on user birthday
         *
         * @since 1.0.0
         *
         * @param int $user_id      The user ID
         * @param int $birthday     The user birthday number
         */
        do_action( 'gamipress_birthdays_user_birthday', $user->user_id, $birthday );

    }

}
add_action( 'gamipress_birthdays_cron', 'gamipress_birthdays_check' );