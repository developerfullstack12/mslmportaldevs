<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LearnDash_PowerPack_Include_Admin_Users_In_Display_And_Reporting', false ) ) {
	/**
	 * LearnDash_PowerPack_Include_Admin_Users_In_Display_And_Reporting Class.
	 */
	class LearnDash_PowerPack_Include_Admin_Users_In_Display_And_Reporting {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_filter( 'ld_propanel_exclude_admin_users', [ $this, 'ld_propanel_exclude_admin_users_func' ] );
			}
		}

		/**
		 * Include the admin users in display and reporting.
		 *
		 * @param bool $exclude_admin_users The flag to include/exclude the admin users from reports.
		 *
		 * @return bool The modified flag.
		 */
		public function ld_propanel_exclude_admin_users_func( $exclude_admin_users ) {
			$option_active_status = if_current_class_is_active( $this->current_class );

			if ( 'active' !== $option_active_status ) {
				return $exclude_admin_users;
			}
			// If you want to INCLUDE admin users set the return to 'false'.
			$exclude_admin_users = false;

			return $exclude_admin_users;
		}

		/**
		 * Add class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'user', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Include admin users option', 'learndash-powerpack' );
			$class_description = esc_html__( 'Enable this option will Include admin users in display and reporting.', 'learndash-powerpack' );
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

	new LearnDash_PowerPack_Include_Admin_Users_In_Display_And_Reporting();
}

