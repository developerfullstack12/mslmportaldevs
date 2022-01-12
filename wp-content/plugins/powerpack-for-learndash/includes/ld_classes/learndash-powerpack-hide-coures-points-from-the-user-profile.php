<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LearnDash_PowerPack_Hide_Coures_Points_From_The_User_Profile', false ) ) {
	/**
	 * LearnDash_PowerPack_Hide_Coures_Points_From_The_User_Profile Class.
	 */
	class LearnDash_PowerPack_Hide_Coures_Points_From_The_User_Profile {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_action( 'wp_footer', [ $this, 'learndash_wp_footer_func' ] );
			}
		}

		/**
		 * Returns the CSS style for the footer.
		 */
		public function learndash_wp_footer_func() {
			$option_active_status = if_current_class_is_active( $this->current_class );

			if ( 'active' !== $option_active_status ) {
				return;
			}
			?>
            <style>
                .learndash-wrapper .ld-profile-summary .ld-profile-stats .ld-profile-stat:last-child {
                    display: none;
                }

                .learndash-wrapper .ld-profile-summary .ld-profile-stats .ld-profile-stat:nth-child(3) {
                    border-right: none;
                }
            </style>
			<?php
		}

		/**
		 * Add class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'course', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Hide Course Points', 'learndash-powerpack' );
			$class_description = esc_html__( 'Enable this option to hide the course points from showing in the [ld_profile] shortcode.', 'learndash-powerpack' );

			return [
				'title'       => $class_title,
				'ld_type'     => $ld_type,
				'description' => $class_description,
				'settings'    => false,
			];
		}
	}

	new LearnDash_PowerPack_Hide_Coures_Points_From_The_User_Profile();
}

