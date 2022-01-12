<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LearnDash_PowerPack_Disable_Transients_For_All_Selective_Data', false ) ) {
	/**
	 * LearnDash_PowerPack_Disable_Transients_For_All_Selective_Data Class.
	 */
	class LearnDash_PowerPack_Disable_Transients_For_All_Selective_Data {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_filter( 'learndash_transients_disabled', [ $this, 'learndash_transients_disabled_func' ], 10, 2 );
			}
		}

		/**
		 * Returns the status of the option to disable the transient.
		 *
		 * @param bool   $disabled The option to disable the transient.
		 * @param String $key Not used.
		 *
		 * @return bool The option to disable the transient.
		 */
		public function learndash_transients_disabled_func( $disabled, $key = '' ) {
			$option_active_status = if_current_class_is_active( $this->current_class );
			if ( 'active' === $option_active_status ) {
				$disabled = true;
			}

			return $disabled;
		}

		/**
		 * Add the class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'transients', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Disable use of Transients for all of selective data', 'learndash-powerpack' );
			$class_description = '';
			$deprecated        = esc_html__( 'Setting Deprecated, Transients will be disabled by default in 3.4', 'learndash-powerpack' );
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

	new LearnDash_PowerPack_Disable_Transients_For_All_Selective_Data();
}

