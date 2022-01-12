<?php
/**
 * Ajax call function
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Learndash_PowerPack_Ajax_Call', false ) ) {
	/**
	 * Learndash_PowerPack_Ajax_Call Class.
	 */
	class Learndash_PowerPack_Ajax_Call {
		public $option_name = 'learndash_powerpack_active_classes';

		/**
		 * Constructor.
		 */
		public function __construct() {
			/**
			 * Ajax call enable/disable class.
			 */
			add_action( 'wp_ajax_enable_disable_class_ajax', [ $this, 'enable_disable_class_ajax' ] );
			add_action( 'wp_ajax_nopriv_enable_disable_class_ajax', [ $this, 'enable_disable_class_ajax' ] );
			/**
			 * Ajax call get model content.
			 */
			add_action( 'wp_ajax_learndash_get_model_content', [ $this, 'learndash_get_model_content' ] );
			add_action( 'wp_ajax_nopriv_learndash_get_model_content', [ $this, 'learndash_get_model_content' ] );
			/**
			 * Ajax call save form data.
			 */
			add_action( 'wp_ajax_learndash_save_class_data_ajax', [ $this, 'learndash_save_class_data_ajax' ] );
			add_action( 'wp_ajax_nopriv_learndash_save_class_data_ajax', [ $this, 'learndash_save_class_data_ajax' ] );
		}

		/**
		 * Ajax call to enable/disable classes.
		 */
		public function enable_disable_class_ajax() {
			// check_ajax_referer( 'title_example' ).
			$get_option = get_option( $this->option_name );
			$return     = [
				'success' => 'true',
				'message' => 'Updated',
			];
			if ( isset( $_POST['value'] ) ) {
				$class_name = sanitize_text_field( $_POST['value'] );
			}
			if ( isset( $_POST['active'] ) ) {
				$active = sanitize_text_field( $_POST['active'] );
			}

			$get_option[ $class_name ] = $active;
			$update_option             = update_option( $this->option_name, $get_option );
			wp_send_json( $return );
			wp_die(); // All ajax handlers should die when finished.
		}

		/**
		 * Ajax call to get model content.
		 */
		public function learndash_get_model_content() {
			$return          = [
				'success' => 'true',
				'message' => 'Updated',
			];
			$class_name_main = sanitize_text_field( $_POST['class_name'] );
			// $class_name = 'sample-lesson'.
			// include (WC_LD_POWEERPACK_PLUGIN_PATH.'/includes/ld_classes/'.$class_name.'.php').
			$instatiate                 = new $class_name_main();
			$class_data                 = $instatiate->learndash_powerpack_class_details();
			$return['title']            = $class_data['title'];
			$return['settings_content'] = $class_data['settings'];
			$return['footer_content']   = '<input type="submit" data-class="' . esc_html__( $class_name_main, 'learndash-powerpack' ) . '" class="learndash_save_form_data imm-bg-white imm-py-2 imm-px-5 imm-border-solid imm-border-2 imm-border-gray-500 imm-rounded imm-font-semibold imm-cursor-pointer" value="' . esc_html__( 'Save Settings', 'learndash-powerpack' ) . '">';
			wp_send_json( $return );
			wp_die(); // All ajax handlers should die when finished.
		}

		/**
		 * Ajax call for save form content.
		 */
		public function learndash_save_class_data_ajax() {
			$return        = [
				'success' => 'true',
				'message' => 'Updated',
			];
			$class_name    = sanitize_text_field( $_POST['class_name'] );
			$form_data     = ld_post_clean( wp_unslash( $_POST['formData'] ) );
			$update_option = update_option( $class_name, $form_data );
			wp_send_json( $return );
			wp_die(); // All ajax handlers should die when finished.
		}
	}

	new Learndash_PowerPack_Ajax_Call();
}
