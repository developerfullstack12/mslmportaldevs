<?php
/**
 * Listeners
 *
 * @package GamiPress\Birthdays\Listeners
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * User birthday listener
 *
 * @since 1.0.0
 *
 * @param int $user_id      The user ID
 * @param int $birthday  The user birthday number
 */
function gamipress_birthdays_user_birthday_listener( $user_id, $birthday ) {

    // Any birthday
    do_action( 'gamipress_birthdays_any_birthday', $user_id, $birthday );

    // Specific birthday
    do_action( 'gamipress_birthdays_specific_birthday', $user_id, $birthday );

}
add_action( 'gamipress_birthdays_user_birthday', 'gamipress_birthdays_user_birthday_listener', 10, 2 );