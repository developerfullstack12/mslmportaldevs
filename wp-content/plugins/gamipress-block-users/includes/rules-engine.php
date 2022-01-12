<?php
/**
 * Rules Engine
 *
 * @package GamiPress\Block_Users\Rules_Engine
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Check if user is deserved to get awarded
 *
 * @since 1.0.0
 *
 * @param bool      $return
 * @param int       $user_id
 * @param string    $trigger
 * @param int       $site_id
 * @param array     $args
 *
 * @return bool
 */
function gamipress_block_users_user_deserves_trigger( $return, $user_id, $trigger, $site_id, $args ) {

    $blocked_roles = gamipress_block_users_get_option( 'blocked_roles' );

    // Check if user role has been manually blocked
    if( is_array( $blocked_roles ) ) {

        foreach( $blocked_roles as $blocked_role ) {
            if( user_can( $user_id, $blocked_role ) ) {
                return false;
            }
        }

    }

    $blocked_users = gamipress_block_users_get_option( 'blocked_users' );

    // Check if user has been manually blocked
    if( is_array( $blocked_users ) ) {

        // Turn blocked users IDs to int to ensure check
        $blocked_users = array_map( 'intval', $blocked_users );

        if( in_array( $user_id, $blocked_users ) ) {
            return false;
        }
    }

    return $return;
}
add_filter( 'gamipress_user_deserves_trigger', 'gamipress_block_users_user_deserves_trigger', 10, 5 );