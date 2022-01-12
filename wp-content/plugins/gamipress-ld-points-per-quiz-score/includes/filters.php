<?php
/**
 * Filters
 *
 * @package GamiPress\LearnDash\Points_Per_Quiz_Score\Filters
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Quiz completed listener
 *
 * @param array $quiz_data array(
 *      'course' => WP_Post,
 *      'quiz' => WP_Post,
 *      'pass' => integer,
 *      'percentage' => integer,
 * )
 * @param WP_User $current_user
 */
function gamipress_ld_points_per_quiz_score_quiz_completed( $quiz_data, $current_user ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_ld_points_per_quiz_score_';

    $quiz_id = $quiz_data['quiz']->ID;
    $user_id = $current_user->ID;
    $score = absint( $quiz_data['points'] );

    foreach( gamipress_get_points_types() as $points_type => $data ) {

        // Skip if award points is not checked
        if( ! (bool) gamipress_get_post_meta( $data['ID'], $prefix . 'award_points' ) ) {
            continue;
        }

        $percent = (int) gamipress_get_post_meta( $data['ID'], $prefix . 'percent' );

        // Skip if percent is not higher than 0
        if( $percent <= 0 ) {
            continue;
        }

        // Check if award is limited to 1 time only
        if( (bool) gamipress_get_post_meta( $data['ID'], $prefix . 'one_time' ) ) {
            // Skip if points of this type has been already awarded
            if( (bool) get_post_meta( $quiz_id, $prefix . $points_type . '_awarded', true ) ) {
                continue;
            }
        }

        // Check if only looking for passed quizzes
        if( (bool) gamipress_get_post_meta( $data['ID'], $prefix . 'only_passed' ) ) {
            // Skip if user has not passed the quiz
            if( ! $quiz_data['pass'] ) {
                continue;
            }
        }

        // Setup the ratio value used to convert the score into points
        $ratio = $percent / 100;

        $points_to_award = absint( $score * $ratio );

        /**
         * Filter to allow override this amount at any time
         *
         * @since 1.0.0
         *
         * @param int       $points_to_award    Points amount that will be awarded
         * @param int       $user_id            User ID that will receive the points
         * @param string    $points_type        Points type slug of the points amount
         * @param int       $order_id           Order ID
         * @param int       $percent            Percent setup on the points type
         *
         * @return int
         */
        $points_to_award = (int) apply_filters( 'gamipress_ld_points_per_quiz_score_points_to_award', $points_to_award, $user_id, $points_type, $order_id, $percent );

        // Award the points to the user
        if( $points_to_award > 0 ) {

            gamipress_award_points_to_user( $user_id, $points_to_award, $points_type );

            // Insert the custom user earning for the manual balance adjustment
            gamipress_insert_user_earning( $user_id, array(
                'title'	        => sprintf(
                    __( '%s for complete the quiz "%s" with a score of %s', 'gamipress-ld-points-per-quiz-score' ),
                    gamipress_format_points( $points_to_award, $points_type ),
                    $quiz_data['quiz']->post_title,
                    $score . ''
                ),
                'user_id'	    => $user_id,
                'post_id'	    => $data['ID'],
                'post_type' 	=> 'points-type',
                'points'	    => $points_to_award,
                'points_type'	=> $points_type,
                'date'	        => date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ),
            ) );

            // Set a post meta to meet that points have been awarded
            update_post_meta( $quiz_id, $prefix . $points_type . '_awarded', '1' );

        }
    }

}
add_action( 'learndash_quiz_completed', 'gamipress_ld_points_per_quiz_score_quiz_completed', 10, 2 );