<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'LearnDash_PowerPack_Restrict_Access_To_Certificates', false ) ) {
	/**
	 * LearnDash_PowerPack_Restrict_Access_To_Certificates Class.
	 */
	class LearnDash_PowerPack_Restrict_Access_To_Certificates {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_action( 'template_redirect', [ $this, 'template_redirect_func' ] );
			}
		}

		/**
		 * Redirects to home if the user is not logged in.
		 */
		public function template_redirect_func() {
			$option_active_status = if_current_class_is_active( $this->current_class );
			if ( 'active' !== $option_active_status ) {
				return;
			}

			$post_type = get_query_var( 'post_type' );
			if ( 'sfwd-certificates' === $post_type ) {
				// CHANGE 'manage_options' TO ANY USER CAPABILITY TO CHECK.
				if ( ( ! is_user_logged_in() ) || ( ! current_user_can( 'manage_options' ) ) ) {
					// If the post_type is certiicate
					// and the user is either not logged in or not admin ('manage_options')
					// then redirect to home.
					wp_redirect( home_url() );
					exit();
				}
			}
		}

		/**
		 * Add class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'certificate', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Restrict Access to Certificates', 'learndash-powerpack' );
			$class_description = esc_html__( 'only allow admin ( users with manage_options capability ) to access certificates.', 'learndash-powerpack' );

			return [
				'title'       => $class_title,
				'ld_type'     => $ld_type,
				'description' => $class_description,
				'settings'    => false,
			];
		}
	}

	new LearnDash_PowerPack_Restrict_Access_To_Certificates();
}

