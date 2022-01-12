<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'LearnDash_PowerPack_Change_The_Price_Type_For_All_Courses', false ) ) {
	/**
	 * LearnDash_PowerPack_Change_The_Price_Type_For_All_Courses Class.
	 */
	class LearnDash_PowerPack_Change_The_Price_Type_For_All_Courses {
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
		 * Set the price to closed for all courses.
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
					// Example #1: Set the course price type to 'closed' for all courses.
					learndash_update_setting( $course_id, 'course_price_type', 'closed' );
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
			$class_title       = esc_html__( 'Change the Price Type for all Courses', 'learndash-powerpack' );
			$class_description = esc_html__( 'Enable this option to set the course price type to closed for all courses.', 'learndash-powerpack' );

			return [
				'title'       => $class_title,
				'ld_type'     => $ld_type,
				'description' => $class_description,
				'settings'    => false,
			];
		}
	}

	new LearnDash_PowerPack_Change_The_Price_Type_For_All_Courses();
}

