<?php
/**
 * Blocks
 *
 * @package     GamiPress\LearnDash_Group_Leaderboard\Blocks
 * @since       1.0.3
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Turn select2 fields into 'post' or 'user' field types
 *
 * @since 1.0.3
 *
 * @param array                 $fields
 * @param GamiPress_Shortcode   $shortcode
 *
 * @return array
 */
function gamipress_learndash_group_leaderboard__block_fields( $fields, $shortcode ) {

    switch ( $shortcode->slug ) {
        case 'gamipress_learndash_user_groups_leaderboards':
            // Exclude Groups
            $fields['exclude_groups']['type'] = 'post';
            $fields['exclude_groups']['post_type'] = 'groups';
            // Exclude Leaderboards
            $fields['exclude_leaderboards']['type'] = 'post';
            $fields['exclude_leaderboards']['post_type'] = 'leaderboard';
            break;
    }

    return $fields;

}
add_filter( 'gamipress_get_block_fields', 'gamipress_learndash_group_leaderboard__block_fields', 11, 2 );
