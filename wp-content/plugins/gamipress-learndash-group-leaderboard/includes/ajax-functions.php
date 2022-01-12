<?php
/**
 * Ajax Functions
 *
 * @package GamiPress\LearnDash_Group_Leaderboard\Ajax_Functions
 * @since 1.0.2
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Ajax function to loop all groups and reassign a leaderboard if haven't one
 *
 * @since 1.0.2
 */
function gamipress_learndash_group_leaderboard_regenerate_leaderboards_ajax() {

    gamipress_learndash_group_leaderboard_regenerate_leaderboards();

    wp_send_json_success( __( 'All group\'s leaderboards has been regenerated successfully!', 'gamipress-learndash-group-leaderboard' ) );

}
add_action( 'wp_ajax_gamipress_learndash_group_leaderboard_regenerate_leaderboards', 'gamipress_learndash_group_leaderboard_regenerate_leaderboards_ajax' );
