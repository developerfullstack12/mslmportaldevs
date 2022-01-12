<?php
/**
 * Widgets
 *
 * @package     GamiPress\LearnDash_Group_Leaderboard\Widgets
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

require_once GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_DIR .'includes/widgets/learndash-user-groups-leaderboards-widget.php';

// Register plugin widgets
function gamipress_learndash_group_leaderboard_register_widgets() {

    register_widget( 'gamipress_learndash_user_groups_leaderboards_widget' );

}
add_action( 'widgets_init', 'gamipress_learndash_group_leaderboard_register_widgets' );