<?php
/**
 * LearnDash Groups
 *
 * @package GamiPress\LearnDash_Group_Leaderboard\LearnDash_Groups
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * On save/insert a group, try to assign a leaderboard
 *
 * @since 1.0.0
 */
function gamipress_learndash_group_leaderboard_on_save_group( $post_id, $post ) {

    if( get_post_type( $post_id ) === 'groups' ) {
        // Automatically generates a leaderboard for this group
        $leaderboard_id = gamipress_learndash_group_leaderboard_get_group_leaderboard( $post_id );

        // Keep leaderboard title updated
        if( $leaderboard_id ) {
            wp_update_post( array(
                'ID' => $leaderboard_id,
                'post_title' => sprintf( __( 'Group %s Leaderboard', 'gamipress-learndash-group-leaderboard' ), $post->post_title ),
            ) );
        }
    }

}
add_action( 'save_post', 'gamipress_learndash_group_leaderboard_on_save_group', 10, 2 );

/**
 * On delete a group, also delete the assigned leaderboard
 *
 * @since 1.0.0
 *
 * @param int $post_id
 */
function gamipress_learndash_group_leaderboard_on_delete_group( $post_id ) {

    if( get_post_type( $post_id ) === 'groups' ) {
        // Get the leaderboard ID of this group
        $leaderboard_id = gamipress_learndash_group_leaderboard_get_group_leaderboard( $post_id );

        if( $leaderboard_id )
            wp_delete_post( $leaderboard_id, true );
    }

}
add_action( 'delete_post', 'gamipress_learndash_group_leaderboard_on_delete_group' );