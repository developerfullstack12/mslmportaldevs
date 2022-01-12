<?php
/**
 * Content Filters
 *
 * @package GamiPress\LearnDash_Group_Leaderboard\Content_Filters
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Filter leaderboard query vars to just include group members
 *
 * @param array     $query_vars
 * @param int       $leaderboard_id
 *
 * @return array
 */
function gamipress_learndash_group_leaderboard_leaderboard_pre_query_vars( $query_vars, $leaderboard_id ) {

    // Check if leaderboard is for a specific group
    $group_id = absint( gamipress_get_post_meta( $leaderboard_id, '_gamipress_learndash_group_leaderboard_group_id' ) );

    if( $group_id !== 0 ) {

        // Setup an array of group members IDs to be used on $query_vars (second parameter is to force to not use cache, sometimes it fails)
        $include_users = learndash_get_groups_user_ids( $group_id, true );

        // Force leaderboards users to just group members
        if( count( $include_users ) ) {

            $query_vars['where'][] = "u.ID IN ( " . implode( ', ', $include_users ) . " )";

        }

    }

    return $query_vars;

}
add_filter( 'gamipress_leaderboards_leaderboard_pre_query_vars', 'gamipress_learndash_group_leaderboard_leaderboard_pre_query_vars', 10, 2 );

/**
 * Common function to override a group leaderboard option
 *
 * @param mixed $option_value
 * @param int   $leaderboard_id
 *
 * @return mixed
 */
function gamipress_learndash_group_leaderboard_override_leaderboard_option( $option_value, $leaderboard_id ) {

    // Check if leaderboard is for a specific group
    $group_id = absint( gamipress_get_post_meta( $leaderboard_id, '_gamipress_learndash_group_leaderboard_group_id' ) );

    if( $group_id !== 0 ) {

        // Turns 'gamipress_leaderboards_leaderboard_columns' into 'columns'
        $option = str_replace( 'gamipress_leaderboards_leaderboard_', '', current_filter() );

        // Setup option default value
        $option_default = '';

        switch( $option ) {
            case 'columns':
            case 'metrics':
                $option_default = array();
                break;
            case 'users':
            case 'users_per_page':
                $option_default = 10;
                break;
        }

        // Override option value
        $option_value = gamipress_learndash_group_leaderboard_get_option( $option, $option_default );

    }

    return $option_value;

}
add_filter( 'gamipress_leaderboards_leaderboard_users', 'gamipress_learndash_group_leaderboard_override_leaderboard_option', 10, 2 );
add_filter( 'gamipress_leaderboards_leaderboard_users_per_page', 'gamipress_learndash_group_leaderboard_override_leaderboard_option', 10, 2 );
add_filter( 'gamipress_leaderboards_leaderboard_columns', 'gamipress_learndash_group_leaderboard_override_leaderboard_option', 10, 2 );
add_filter( 'gamipress_leaderboards_leaderboard_metrics', 'gamipress_learndash_group_leaderboard_override_leaderboard_option', 10, 2 );
add_filter( 'gamipress_leaderboards_leaderboard_period', 'gamipress_learndash_group_leaderboard_override_leaderboard_option', 10, 2 );
add_filter( 'gamipress_leaderboards_leaderboard_period_start_date', 'gamipress_learndash_group_leaderboard_override_leaderboard_option', 10, 2 );
add_filter( 'gamipress_leaderboards_leaderboard_period_end_date', 'gamipress_learndash_group_leaderboard_override_leaderboard_option', 10, 2 );