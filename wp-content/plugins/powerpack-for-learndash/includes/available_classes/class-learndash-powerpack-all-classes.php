<?php
/**
 * Classes
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;
/**
 * Load classes
 *
 * @version 1.0.0
 */

if ( ! class_exists( 'LearnDash_PowerPack_All_Classes', false ) ) {
	/**
	 * LearnDash_PowerPack_All_Classes Class.
	 */
	class LearnDash_PowerPack_All_Classes {
		/**
		 * Hook.
		 */
		public static function get_all_powerpack_classes() {
			$get_declared  = get_declared_classes();
			$classes_array = [];

			foreach ( $get_declared as $class_name ) {
				if ( strpos( $class_name, 'LearnDash_PowerPack_' ) === false ) {
					continue;
				}

				$classes_array[] = $class_name;
			}

			return apply_filters( 'learndash_filter_classes', $classes_array );
		}
	}
}

