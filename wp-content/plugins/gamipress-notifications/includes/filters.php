<?php
/**
 * Filters
 *
 * @package     GamiPress\Notifications\Filters
 * @since       1.4.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Exclude notifications check in AutomatorWP redirect utility
 *
 * @param array $excluded_ajax_actions
 *
 * @return array
 */
function gamipress_notifications_exclude_notifications_check_in_automatorwp( $excluded_ajax_actions ) {

    $excluded_ajax_actions[] = 'gamipress_notifications_get_notices';

    return $excluded_ajax_actions;

}
add_filter( 'automatorwp_redirect_excluded_ajax_actions', 'gamipress_notifications_exclude_notifications_check_in_automatorwp' );