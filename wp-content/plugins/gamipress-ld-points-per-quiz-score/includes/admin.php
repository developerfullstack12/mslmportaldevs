<?php
/**
 * Admin
 *
 * @package GamiPress\LearnDash\Points_Per_Quiz_Score\Admin
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Plugin meta boxes
 *
 * @since  1.0.0
 */
function gamipress_ld_points_per_quiz_score_meta_boxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_ld_points_per_quiz_score_';

    gamipress_add_meta_box(
        'gamipress-ld-points-per-quiz-score',
        __( 'Points per quiz score', 'gamipress-ld-points-per-quiz-score' ),
        'points-type',
        array(
            $prefix . 'award_points' => array(
                'name' 	=> __( 'Award points to users per quiz score?', 'gamipress-ld-points-per-quiz-score' ),
                'desc' 	=> '',
                'type' 	=> 'checkbox',
                'classes' => 'gamipress-switch',
            ),
            $prefix . 'percent' => array(
                'name' => __( 'Percent to award', 'gamipress-ld-points-per-quiz-score' ),
                'desc' => __( 'Set the amount\'s percent to award.', 'gamipress-ld-points-per-quiz-score' )
                    . '<br>' . __( 'A 100% will award the same user quiz score as points (e.g. score of 40 = 40 points).', 'gamipress-ld-points-per-quiz-score' )
                    . '<br>' . __( 'A 200% will award the double of the user quiz score as points (e.g. score of 40 = 80 points).', 'gamipress-ld-points-per-quiz-score' )
                    . '<br>' . __( 'A 50% will award the half of the user quiz score as points (e.g. score of 40 = 20 points).', 'gamipress-ld-points-per-quiz-score' ),
                'type' => 'text',
                'attributes' => array(
                    'type' => 'number',
                    'min' => '1',
                ),
                'default' => '100',
            ),
            $prefix . 'only_passed' => array(
                'name' 	=> __( 'Award only on passing', 'gamipress-ld-points-per-quiz-score' ),
                'desc' 	=> __( 'Award the points only when the user successfully passes the quiz.', 'gamipress-ld-points-per-quiz-score' ),
                'type' 	=> 'checkbox',
                'classes' => 'gamipress-switch',
            ),
            $prefix . 'one_time' => array(
                'name' 	=> __( 'Award only one time', 'gamipress-ld-points-per-quiz-score' ),
                'desc' 	=> __( 'Award the points only on first attempt or when passing the first time (depends if "Award only on passing" is checked). ', 'gamipress-ld-points-per-quiz-score' ),
                'type' 	=> 'checkbox',
                'classes' => 'gamipress-switch',
            ),
        ),
        array( 'context' => 'side' )
    );

}
add_action( 'cmb2_admin_init', 'gamipress_ld_points_per_quiz_score_meta_boxes' );

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_ld_points_per_quiz_score_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-ld-points-per-quiz-score'] = __( 'LearnDash Points Per Quiz Score', 'gamipress-ld-points-per-quiz-score' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_ld_points_per_quiz_score_automatic_updates' );