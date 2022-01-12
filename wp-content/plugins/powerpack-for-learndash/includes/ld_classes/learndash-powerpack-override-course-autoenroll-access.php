<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LearnDash_PowerPack_Override_Course_Autoenroll_Access', false ) ) {
	/**
	 * LearnDash_PowerPack_Override_Course_Autoenroll_Access Class.
	 */
	class LearnDash_PowerPack_Override_Course_Autoenroll_Access {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_filter(
					'learndash_override_course_auto_enroll',
					[ $this, 'learndash_override_course_auto_enroll_func' ],
					10,
					3
				);
			}
		}

		/**
		 * Set the admin users autoenroll as false.
		 *
		 * @param bool $auto_enroll The auto_enroll propertie.
		 * @param int  $user_id The ID of the user.
		 * @param int  $post_id The ID of the post.
		 *
		 * @return bool The modified autoenroll propertie.
		 */
		public function learndash_override_course_auto_enroll_func( $auto_enroll, $user_id = 0, $post_id = 0 ) {
			$option_active_status = if_current_class_is_active( $this->current_class );

			if ( user_can( $user_id, 'administrator' ) && 'active' === $option_active_status ) {
				$auto_enroll = false;
			}

			return $auto_enroll;
		}

		/**
		 * Add class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'course', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Disbaled auto enrolled for admin users in all Courses', 'learndash-powerpack' );
			$class_description = esc_html__( 'Enable this option will Disbaled auto enrolled for admin users in all Courses.', 'learndash-powerpack' );
			$deprecated        = esc_html__( 'Setting Deprecated, Available in LearnDash LMS > Settings', 'learndash-powerpack' );
			$deprecated_date   = gmdate( 'Y-m-d', strtotime( '2021-07-29' ) );

			return [
				'title'           => $class_title,
				'ld_type'         => $ld_type,
				'description'     => $class_description,
				'settings'        => false,
				'deprecated'      => $deprecated,
				'deprecated_date' => $deprecated_date,
			];
		}
	}

	new LearnDash_PowerPack_Override_Course_Autoenroll_Access();
}

