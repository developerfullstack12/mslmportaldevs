<?php
/**
 * Scripts
 *
 * @package     GamiPress\LearnDash_Group_Leaderboard\Scripts
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_learndash_group_leaderboard_admin_register_scripts() {
    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-learndash-group-leaderboard-admin-css', GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_URL . 'assets/css/gamipress-learndash-group-leaderboard-admin' . $suffix . '.css', array( ), GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-learndash-group-leaderboard-admin-js', GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_URL . 'assets/js/gamipress-learndash-group-leaderboard-admin' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_VER, true );
    wp_register_script( 'gamipress-learndash-group-leaderboard-admin-widgets-js', GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_URL . 'assets/js/gamipress-learndash-group-leaderboard-admin-widgets' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_VER, true );
    wp_register_script( 'gamipress-learndash-group-leaderboard-shortcode-editor-js', GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_URL . 'assets/js/gamipress-learndash-group-leaderboard-shortcode-editor' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), GAMIPRESS_LEARNDASH_GROUP_LEADERBOARD_VER, true );

}
add_action( 'admin_init', 'gamipress_learndash_group_leaderboard_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_learndash_group_leaderboard_admin_enqueue_scripts( $hook ) {

    global $post_type;

    // Settings page
    if( $hook === 'gamipress_page_gamipress_settings' ) {

        //Stylesheets
        wp_enqueue_style( 'gamipress-learndash-group-leaderboard-admin-css' );

        //Scripts
        wp_enqueue_script( 'gamipress-learndash-group-leaderboard-admin-js' );

    }

    // Widgets scripts
    if( $hook === 'widgets.php' ) {
        wp_enqueue_script( 'gamipress-learndash-group-leaderboard-admin-widgets-js' );
    }

    // Just enqueue on add/edit views and on post types that supports editor feature
    if( ( $hook === 'post.php' || $hook === 'post-new.php' ) && post_type_supports( $post_type, 'editor' ) ) {
        wp_enqueue_script( 'gamipress-learndash-group-leaderboard-shortcode-editor-js' );

    }

}
add_action( 'admin_enqueue_scripts', 'gamipress_learndash_group_leaderboard_admin_enqueue_scripts', 100 );