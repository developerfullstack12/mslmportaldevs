<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'LearnDash_PowerPack_Bypass_The_Learndash_Lesson_Drip_Feed_Logic_For_Admin_Users', false ) ) {
	/**
	 * LearnDash_PowerPack_Bypass_The_Learndash_Lesson_Drip_Feed_Logic_For_Admin_Users Class.
	 */
	class LearnDash_PowerPack_Bypass_The_Learndash_Lesson_Drip_Feed_Logic_For_Admin_Users {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_filter( 'ld_lesson_access_from', [ $this, 'ld_lesson_access_from_func' ], 10, 3 );
			}
		}

		/**
		 * Determines if the user have access to a lesson.
		 *
		 * @param bool $return To store wether the user has access.
		 * @param int  $lesson_id The ID of the lesson.
		 * @param int  $user_id The ID of the user.
		 *
		 * @return bool whether the user has access to the lesson or not.
		 */
		public function ld_lesson_access_from_func( $return, $lesson_id = 0, $user_id = 0 ) {
			$option_active_status = if_current_class_is_active( $this->current_class );
			if ( 'active' !== $option_active_status ) {
				return $return;
			}

			// If the lesson_id OR user_id are empty then just return.
			if ( ( empty( $lesson_id ) ) || ( empty( $user_id ) ) ) {
				return $return;
			}

			// If the user is admin (can manage_options) then set the $return to false.
			if ( user_can( $user_id, 'manage_options' ) ) {
				$return = false;
			}

			// If the user is group leader role then bypass
			// UNCOMMENT THE LINES BELOW to EXCLUDE GROUP LEADERS USERS
			// if ( user_can( $user_id, 'group_leader' ) ) {
			// $return = false;
			// }

			return $return;
		}

		/**
		 * Add class details.
		 *
		 * @return array Class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'lesson', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Lesson Drip-Feed logic for Admin users', 'learndash-powerpack' );
			$class_description = esc_html__( 'Enable this option will bypass the LearnDash Lesson Drip-Feed logic for Admin users', 'learndash-powerpack' );
			$deprecated        = esc_html__( 'Setting Deprecated due the functionality is already on LearnDash Core', 'learndash-powerpack' );
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

	new LearnDash_PowerPack_Bypass_The_Learndash_Lesson_Drip_Feed_Logic_For_Admin_Users();
}

