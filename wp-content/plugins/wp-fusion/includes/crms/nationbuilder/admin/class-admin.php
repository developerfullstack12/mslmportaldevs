<?php

class WPF_NationBuilder_Admin {

	private $slug;
	private $name;
	private $crm;

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function __construct( $slug, $name, $crm ) {

		$this->slug = $slug;
		$this->name = $name;
		$this->crm  = $crm;

		// Settings
		add_filter( 'wpf_configure_settings', array( $this, 'register_connection_settings' ), 15, 2 );
		add_action( 'show_field_nationbuilder_header_begin', array( $this, 'show_field_nationbuilder_header_begin' ), 10, 2 );

		// AJAX
		add_action( 'wp_ajax_wpf_test_connection_' . $this->slug, array( $this, 'test_connection' ) );

		if ( wpf_get_option( 'crm' ) == $this->slug ) {
			$this->init();
		}

		// OAuth
		add_action( 'admin_init', array( $this, 'maybe_oauth_complete' ) );

	}

	/**
	 * Hooks to run when this CRM is selected as active
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function init() {

		add_filter( 'wpf_initialize_options_contact_fields', array( $this, 'add_default_fields' ), 10 );

	}

	/**
	 * Hooks to run when this CRM is selected as active
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function maybe_oauth_complete() {

		if ( isset( $_GET['code'] ) && isset( $_GET['slug'] ) && isset( $_GET['state'] ) && $_GET['state'] == 'wpfnationbuilder' ) {

			$code = sanitize_text_field( wp_unslash( $_GET['code'] ) );
			$slug = sanitize_text_field( wp_unslash( $_GET['slug'] ) );

			$body = array(
				'grant_type'    => 'authorization_code',
				'code'          => $code,
				'client_id'     => $this->crm->client_id,
				'client_secret' => $this->crm->client_secret,
				'redirect_uri'  => 'https://wpfusion.com/parse-nationbuilder-oauth.php',
			);

			wpf_log( 'info', 0, 'Requesting authorization token from NationBuilder:', array( 'meta_array_nofilter' => $body ) );

			$params = array(
				'timeout'    => 30,
				'user-agent' => 'WP Fusion; ' . home_url(),
				'headers'    => array(
					'Content-Type' => 'application/json',
					'Accept'       => 'application/json',
				),
				'body'       => json_encode( $body ),
			);

			$response = wp_safe_remote_post( 'https://' . $slug . '.nationbuilder.com/oauth/token', $params );

			if ( is_wp_error( $response ) ) {
				wpf_log( 'error', 0, 'Error getting authorization token: ' . $response->get_error_message() );
				return false;
			}

			$response = json_decode( wp_remote_retrieve_body( $response ) );

			wp_fusion()->settings->set( 'nationbuilder_slug', $slug );
			wp_fusion()->settings->set( 'nationbuilder_token', $response->access_token );
			wp_fusion()->settings->set( 'crm', $this->slug );

			wp_safe_redirect( get_admin_url() . 'options-general.php?page=wpf-settings#setup' );
			exit;

		}

	}


	/**
	 * Loads NationBuilder connection information on settings page
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function register_connection_settings( $settings, $options ) {

		$new_settings = array();

		$new_settings['nationbuilder_header'] = array(
			'title'   => __( 'NationBuilder Configuration', 'wp-fusion' ),
			'std'     => 0,
			'type'    => 'heading',
			'section' => 'setup',
		);

		$new_settings['nationbuilder_slug'] = array(
			'title'   => __( 'Nation Slug', 'wp-fusion' ),
			'std'     => '',
			'type'    => 'text',
			'section' => 'setup',
			'desc'    => 'Your slug is found in your NationBuilder URL, like https://{slug}.nationbuilder.com/',
		);

		if ( empty( $options['nationbuilder_token'] ) && ! isset( $_GET['code'] ) ) {

			$new_settings['nationbuilder_auth'] = array(
				'std'     => 0,
				'type'    => 'heading',
				'section' => 'setup',
			);

			$new_settings['nationbuilder_auth']['desc']  = '<table class="form-table"><tr>';
			$new_settings['nationbuilder_auth']['desc'] .= '<th scope="row"><label>Authorize</label></th>';
			$new_settings['nationbuilder_auth']['desc'] .= '<td><a id="nationbuilder-auth-btn" class="button button-disabled" href="https://wpfusion.com/oauth/?redirect=' . urlencode( get_admin_url() . './options-general.php?page=wpf-settings' ) . '&action=wpf_get_nationbuilder_token&client_id=' . $this->crm->client_id . '&slug=unknown">Authorize with NationBuilder</a><br /><span class="description">You\'ll be taken to NationBuilder to authorize WP Fusion and generate access keys for this site.</td>';
			$new_settings['nationbuilder_auth']['desc'] .= '</tr></table></div>';

		} else {

			$new_settings['nationbuilder_token'] = array(
				'title'       => __( 'Access Token', 'wp-fusion' ),
				'type'        => 'api_validate',
				'section'     => 'setup',
				'class'       => 'api_key',
				'post_fields' => array( 'nationbuilder_token', 'nationbuilder_slug' ),
			);

		}

		$settings = wp_fusion()->settings->insert_setting_after( 'crm', $settings, $new_settings );

		return $settings;

	}



	/**
	 * Loads standard NationBuilder field names and attempts to match them up with standard local ones
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function add_default_fields( $options ) {

		if ( $options['connection_configured'] == true ) {

			require_once dirname( __FILE__ ) . '/nationbuilder-fields.php';

			foreach ( $options['contact_fields'] as $field => $data ) {

				if ( isset( $nationbuilder_fields[ $field ] ) && empty( $options['contact_fields'][ $field ]['crm_field'] ) ) {
					$options['contact_fields'][ $field ] = array_merge( $options['contact_fields'][ $field ], $nationbuilder_fields[ $field ] );
				}
			}
		}

		return $options;

	}


	/**
	 * Puts a div around the Infusionsoft configuration section so it can be toggled
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function show_field_nationbuilder_header_begin( $id, $field ) {

		echo '</table>';
		$crm = wpf_get_option( 'crm' );
		echo '<div id="' . esc_attr( $this->slug ) . '" class="crm-config ' . ( $crm == false || $crm != $this->slug ? 'hidden' : 'crm-active' ) . '" data-name="' . esc_attr( $this->name ) . '" data-crm="' . esc_attr( $this->slug ) . '">';

	}


	/**
	 * Verify connection credentials
	 *
	 * @access public
	 * @return bool
	 */

	public function test_connection() {

		check_ajax_referer( 'wpf_settings_nonce' );

		$access_token = sanitize_text_field( $_POST['nationbuilder_token'] );
		$slug         = sanitize_text_field( $_POST['nationbuilder_slug'] );

		$connection = $this->crm->connect( $access_token, $slug, true );

		if ( is_wp_error( $connection ) ) {

			wp_send_json_error( $connection->get_error_message() );

		} else {

			$options                          = array();
			$options['nationbuilder_token']   = $access_token;
			$options['nationbuilder_slug']    = $slug;
			$options['crm']                   = $this->slug;
			$options['connection_configured'] = true;

			wp_fusion()->settings->set_multiple( $options );

			wp_send_json_success();

		}

		die();

	}


}
