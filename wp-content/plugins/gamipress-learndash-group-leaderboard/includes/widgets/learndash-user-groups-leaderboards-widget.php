<?php
/**
 * LearnDash User Groups Leaderboards Widget
 *
 * @package     GamiPress\LearnDash_Group_Leaderboard\Widgets\Widget\LearnDash_User_Groups_Leaderboards
 * @since       1.0.3
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class GamiPress_LearnDash_User_Groups_Leaderboards_Widget extends GamiPress_Widget {

    public function __construct() {
        parent::__construct(
            'gamipress_learndash_user_groups_leaderboards_widget',
            __( 'GamiPress: LearnDash User Groups Leaderboards', 'gamipress-learndash-group-leaderboard' ),
            __( 'Render all leaderboards of all user\'s groups.', 'gamipress-learndash-group-leaderboard' )
        );
    }

    public function get_fields() {

        return GamiPress()->shortcodes['gamipress_learndash_user_groups_leaderboards']->fields;
    }

    public function get_widget( $args, $instance ) {
        echo gamipress_do_shortcode( 'gamipress_learndash_user_groups_leaderboards', array(
            'current_user'          => ( $instance['current_user'] === 'on' ? 'yes' : 'no' ),
            'user_id'               => $instance['user_id'],
            'exclude_groups'        => is_array( $instance['exclude_groups'] ) ? implode( ',', $instance['exclude_groups'] ) : $instance['exclude_groups'],
            'exclude_leaderboards'  => is_array( $instance['exclude_leaderboards'] ) ? implode( ',', $instance['exclude_leaderboards'] ) : $instance['exclude_leaderboards'],
            'excerpt'               => ( $instance['excerpt'] === 'on' ? 'yes' : 'no' ),
            'search'                => ( $instance['search'] === 'on' ? 'yes' : 'no' ),
            'sort'                  => ( $instance['sort'] === 'on' ? 'yes' : 'no' ),
            'hide_admins'           => ( $instance['hide_admins'] === 'on' ? 'yes' : 'no' ),
        ) );
    }

}