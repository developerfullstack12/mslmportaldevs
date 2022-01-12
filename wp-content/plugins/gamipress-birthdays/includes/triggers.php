<?php
/**
 * Triggers
 *
 * @package GamiPress\Birthdays\Triggers
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register specific triggers
 *
 * @since 1.0.0
 *
 * @param array $triggers
 * @return mixed
 */
function gamipress_birthdays_activity_triggers( $triggers ) {

    $triggers[__( 'Birthdays', 'gamipress-birthdays' )] = array(
        'gamipress_birthdays_any_birthday'                => __( 'Your birthday', 'gamipress-birthdays' ),
        'gamipress_birthdays_specific_birthday'           => __( 'Your specific birthday', 'gamipress-birthdays' ),
    );

    return $triggers;

}
add_filter( 'gamipress_activity_triggers', 'gamipress_birthdays_activity_triggers' );

/**
 * Exclude triggers from time limit
 *
 * @since 1.0.0
 *
 * @param array $triggers
 * @return mixed
 */
function gamipress_birthdays_triggers_excluded_from_activity_limit( $triggers ) {

    $triggers[] = 'gamipress_birthdays_any_birthday';
    $triggers[] = 'gamipress_birthdays_specific_birthday';

    return $triggers;

}
add_filter( 'gamipress_activity_triggers_excluded_from_activity_limit', 'gamipress_birthdays_triggers_excluded_from_activity_limit' );

/**
 * Build custom activity trigger label
 *
 * @since 1.0.0
 *
 * @param string    $title
 * @param integer   $requirement_id
 * @param array     $requirement
 *
 * @return string
 */
function gamipress_birthdays_activity_trigger_label( $title, $requirement_id, $requirement ) {

    $birthday = ( isset( $requirement['birthdays_birthday'] ) ) ? absint( $requirement['birthdays_birthday'] ) : 1;

    switch( $birthday ) {
        case 1:
            $suffix = 'st';
            break;
        case 2:
            $suffix = 'nd';
            break;
        case 3:
            $suffix = 'rd';
            break;
        default:
            $suffix = 'th';
            break;
    }

    switch( $requirement['trigger_type'] ) {
        case 'gamipress_birthdays_specific_birthday':
            return sprintf( __( 'Your %d%s birthday', 'gamipress-birthdays' ), $birthday, $suffix );
            break;
    }

    return $title;
}
add_filter( 'gamipress_activity_trigger_label', 'gamipress_birthdays_activity_trigger_label', 10, 3 );

/**
 * Get user for a given trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer $user_id user ID to override.
 * @param  string  $trigger Trigger name.
 * @param  array   $args    Passed trigger args.
 * @return integer          User ID.
 */
function gamipress_birthdays_trigger_get_user_id( $user_id, $trigger, $args ) {

    switch ( $trigger ) {
        case 'gamipress_birthdays_any_birthday':
        case 'gamipress_birthdays_specific_birthday':
            $user_id = $args[0];
            break;
    }

    return $user_id;

}
add_filter( 'gamipress_trigger_get_user_id', 'gamipress_birthdays_trigger_get_user_id', 10, 3 );

/**
 * Extended meta data for event trigger logging
 *
 * @since 1.0.0
 *
 * @param array 	$log_meta
 * @param integer 	$user_id
 * @param string 	$trigger
 * @param integer 	$site_id
 * @param array 	$args
 *
 * @return array
 */
function gamipress_birthdays_log_event_trigger_meta_data( $log_meta, $user_id, $trigger, $site_id, $args ) {

    switch ( $trigger ) {
        case 'gamipress_birthdays_any_birthday':
        case 'gamipress_birthdays_specific_birthday':
            // Add the birthday
            $log_meta['birthday'] = $args[1];
            break;
    }

    return $log_meta;
}
add_filter( 'gamipress_log_event_trigger_meta_data', 'gamipress_birthdays_log_event_trigger_meta_data', 10, 5 );

/**
 * Extra data fields
 *
 * @since 1.0.0
 *
 * @param array     $fields
 * @param int       $log_id
 * @param string    $type
 *
 * @return array
 */
function gamipress_birthdays_log_extra_data_fields( $fields, $log_id, $type ) {

    $prefix = '_gamipress_';

    $log = ct_get_object( $log_id );
    $trigger = $log->trigger_type;

    if( $type !== 'event_trigger' ) {
        return $fields;
    }

    switch( $trigger ) {
        case 'gamipress_birthdays_any_birthday':
        case 'gamipress_birthdays_specific_birthday':
            $fields[] = array(
                'name' 	            => __( 'Birthday', 'gamipress-birthdays' ),
                'desc' 	            => __( 'The user birthday.', 'gamipress-birthdays' ),
                'id'   	            => $prefix . 'birthday',
                'type' 	            => 'text',
            );
            break;
    }

    return $fields;

}
add_filter( 'gamipress_log_extra_data_fields', 'gamipress_birthdays_log_extra_data_fields', 10, 3 );

/**
 * Override the meta data to filter the logs count
 *
 * @since   1.0.0
 *
 * @param  array    $log_meta       The meta data to filter the logs count
 * @param  int      $user_id        The given user's ID
 * @param  string   $trigger        The given trigger we're checking
 * @param  int      $since 	        The since timestamp where retrieve the logs
 * @param  int      $site_id        The desired Site ID to check
 * @param  array    $args           The triggered args or requirement object
 *
 * @return array                    The meta data to filter the logs count
 */
function gamipress_birthdays_get_user_trigger_count_log_meta( $log_meta, $user_id, $trigger, $since, $site_id, $args ) {

    switch( $trigger ) {
        case 'gamipress_birthdays_any_birthday':
        case 'gamipress_birthdays_specific_birthday':

            $birthday = 0;

            if( isset( $args[1] ) ) {
                // Add the birthday
                $birthday = $args[1];
            }

            // $args could be a requirement object
            if( isset( $args['birthdays_birthday'] ) ) {
                // Add the birthday
                $birthday = $args['birthdays_birthday'];
            }

            $log_meta['score'] = array(
                'key' => 'birthday',
                'value' => (int) $birthday,
                'compare' => '>=',
                'type' => 'integer',
            );
            break;
    }

    return $log_meta;

}
add_filter( 'gamipress_get_user_trigger_count_log_meta', 'gamipress_birthdays_get_user_trigger_count_log_meta', 10, 6 );