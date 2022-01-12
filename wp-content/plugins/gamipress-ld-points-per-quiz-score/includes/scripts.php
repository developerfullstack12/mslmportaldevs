<?php
/**
 * Scripts
 *
 * @package GamiPress\LearnDash\Points_Per_Quiz_Score\Scripts
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_ld_points_per_quiz_score_admin_register_scripts() {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Scripts
    wp_register_script( 'gamipress-ld-points-per-quiz-score-admin-js', GAMIPRESS_LD_POINTS_PER_QUIZ_SCORE_URL . 'assets/js/gamipress-ld-points-per-quiz-score-admin' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_LD_POINTS_PER_QUIZ_SCORE_VER, true );

}
add_action( 'admin_init', 'gamipress_ld_points_per_quiz_score_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_ld_points_per_quiz_score_admin_enqueue_scripts( $hook ) {

    global $post_type;

    //Scripts
    if ( $post_type === 'points-type' ) {

        wp_enqueue_script( 'gamipress-ld-points-per-quiz-score-admin-js' );

    }
}
add_action( 'admin_enqueue_scripts', 'gamipress_ld_points_per_quiz_score_admin_enqueue_scripts', 100 );