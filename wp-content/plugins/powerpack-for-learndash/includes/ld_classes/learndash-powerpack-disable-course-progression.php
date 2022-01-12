<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'LearnDash_PowerPack_Disable_Course_Progression', false ) ) {
	/**
	 * LearnDash_PowerPack_Disable_Course_Progression Class.
	 */
	class LearnDash_PowerPack_Disable_Course_Progression {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_action( 'wp_footer', [ $this, 'learndash_wp_footer_price_type' ] );
			}
		}

		/**
		 * Updates the price .
		 */
		public function learndash_wp_footer_price_type() {
			$option_active_status = if_current_class_is_active( $this->current_class );
			if ( 'active' !== $option_active_status ) {
				return;
			}
			$course_query_args = [
				'post_type'   => 'sfwd-courses',
				'post_status' => 'publish',
				'fields'      => 'ids',
			];

			$course_query = new WP_Query( $course_query_args );
			if ( ! empty( $course_query->posts ) ) {
				foreach ( $course_query->posts as $course_id ) {
					learndash_update_setting( $course_id, 'course_disable_lesson_progression', 'on' );
				}
			}
		}

		/**
		 * Add the class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'course', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Course Progression', 'learndash-powerpack' );
			$class_description = esc_html__( 'Enable this option to disable Course Progression.', 'learndash-powerpack' );

			return [
				'title'       => $class_title,
				'ld_type'     => $ld_type,
				'description' => $class_description,
				'settings'    => false,
			];
		}
	}

	new LearnDash_PowerPack_Disable_Course_Progression();
}

