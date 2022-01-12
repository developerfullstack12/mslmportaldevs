<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       immerseus.com
 * @since      1.0.0
 *
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/public
 */

class Learndash_Private_Message_Public {
	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
			wp_register_style( 'imm-tailwind', plugin_dir_url( __FILE__ ) . 'css/tailwind-styles.css', [], $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/chat.js', [ 'jquery' ], $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'learndash_private_message_frontend',
			[
				'ajaxurl'                        => admin_url( 'admin-ajax.php' ),
				'nonce'                          => wp_create_nonce( 'ldpm_chat' ),
				'chat_refresh_frequency_seconds' => get_option( 'ldpm_chat_refresh_frequency_seconds' ) ?: 30,
				'max_upload_size'                => wp_max_upload_size(),
				'theme'                          => get_option( 'ldpm_select_theme_option', 'classic' ),
			]
		);
	}

	public function shortcodes() {
		add_shortcode( 'learndash_chat', [ $this, 'chat' ] );
	}

	function add_tab_button( $tabs, $context, $course_id, $user_id ) {

		$course_to_hide = get_option( 'ldpm_specific_courses', [] );
		$groups_to_hide = get_option( 'ldpm_specific_groups', [] );

		if ( ( ! empty( $course_to_hide ) && in_array( strval( $course_id ), $course_to_hide, true ) )
			|| ( ! empty( $groups_to_hide ) && in_array( strval( $course_id ), $groups_to_hide, true ) )
		) {
			return $tabs;
		}

		$tabs[] = [
			'id'      => 'chat',
			'icon'    => 'ld-icon-comments',
			'label'   => 'Chat',
			'content' => do_shortcode( "[learndash_chat course_id={$course_id}/]" ),
		];

		return $tabs;
	}

	function chat( $atts ) {
		wp_enqueue_style( 'imm-tailwind' );
		wp_enqueue_script( $this->plugin_name );
		wp_enqueue_style( $this->plugin_name );

		// Since is declared in this function, the included filed will have access to this variable.
		$shortcode_args = shortcode_atts(
			[
				'course_id' => null,
			],
			$atts
		);

		$user_settings = new Learndash_Private_Message_User_Settings( get_current_user_id() );

		$user_settings_options = $user_settings->get_settings();

		ob_start();

		include_once 'partials/learndash-private-message-public-display.php';

		return ob_get_clean();
	}
}
