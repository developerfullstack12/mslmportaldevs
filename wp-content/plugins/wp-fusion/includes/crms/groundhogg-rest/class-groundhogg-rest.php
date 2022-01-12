<?php

class WPF_Groundhogg_REST {

	/**
	 * Declares how this CRM handles tags and fields.
	 *
	 * @var array
	 * @since 3.38.10
	 */

	public $supports = array();

	/**
	 * API authentication parameters and headers.
	 *
	 * @var array
	 * @since 3.38.10
	 */

	public $params;

	/**
	 * API URL.
	 *
	 * @var array
	 * @since 3.38.10
	 */

	public $url;

	/**
	 * Lets us link directly to editing a contact record.
	 *
	 * @since 3.38.14
	 * @var  string
	 */

	public $edit_url = '';


	/**
	 * Get things started
	 *
	 * @since 3.38.10
	 */

	public function __construct() {

		$this->slug      = 'groundhogg-rest';
		$this->name      = 'Groundhogg';
		$this->menu_name = 'Groundhogg (REST API)';

		// Set up admin options.
		if ( is_admin() ) {
			require_once dirname( __FILE__ ) . '/class-groundhogg-rest-admin.php';
			new WPF_Groundhogg_REST_Admin( $this->slug, $this->name, $this );
		}

		add_filter( 'http_response', array( $this, 'handle_http_response' ), 50, 3 );

	}

	/**
	 * Sets up hooks specific to this CRM.
	 *
	 * This function only runs if this CRM is the active CRM.
	 *
	 * @since 3.38.10
	 */
	public function init() {

		// Error handling
		add_filter( 'wpf_crm_post_data', array( $this, 'format_post_data' ) );

		$url = wpf_get_option( 'groundhogg_rest_url' );

		if ( ! empty( $url ) ) {
			$this->url      = trailingslashit( $url ) . 'wp-json/gh/v4';
			$this->edit_url = trailingslashit( $url ) . 'wp-admin/admin.php?page=gh_contacts&action=edit&contact=%d';
		}

	}


	/**
	 * Formats POST data received from HTTP Posts into standard format
	 *
	 * @access public
	 * @return array
	 */

	public function format_post_data( $post_data ) {

		$payload = json_decode( stripslashes( file_get_contents( 'php://input' ) ) );

		if ( ! is_object( $payload ) ) {
			return false;
		}

		$post_data['contact_id'] = absint( $payload->id );
		$post_data['tags']       = wp_list_pluck( (array) $payload->tags, 'slug' );

		return $post_data;

	}


	/**
	 * Gets params for API calls.
	 *
	 * @since  3.38.10
	 *
	 * @param  string $url      The api url.
	 * @param  string $username The application username.
	 * @param  string $password The application password.
	 * @return array  $params The API parameters.
	 */

	public function get_params( $url = null, $username = null, $password = null ) {

		if ( $this->params ) {
			return $this->params; // already set up
		}

		// Get saved data from DB
		if ( ! $url || ! $username || ! $password ) {
			$url      = wpf_get_option( 'groundhogg_rest_url' );
			$username = wpf_get_option( 'groundhogg_rest_username' );
			$password = wpf_get_option( 'groundhogg_rest_password' );
		}

		$this->url = trailingslashit( $url ) . 'wp-json/gh/v4';

		$this->params = array(
			'timeout'    => 15,
			'user-agent' => 'WP Fusion; ' . home_url(),
			'headers'    => array(
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
				'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
			),
		);

		return $this->params;
	}


	/**
	 * Check HTTP Response for errors and return WP_Error if found.
	 *
	 * @since  3.38.10
	 *
	 * @param  WP_HTTP_Response $response The HTTP response.
	 * @param  array            $args     The HTTP request arguments.
	 * @param  string           $url      The HTTP request URL.
	 * @return WP_HTTP_Response $response The response.
	 */

	public function handle_http_response( $response, $args, $url ) {

		if ( $this->url && strpos( $url, $this->url ) !== false && 'WP Fusion; ' . home_url() == $args['user-agent'] ) {

			if ( 404 == wp_remote_retrieve_response_code( $response ) || empty( wp_remote_retrieve_body( $response ) ) ) {

				$response = new WP_Error( 'error', 'No response was returned. You may need to <a href="https://wordpress.org/support/article/using-permalinks/#mod_rewrite-pretty-permalinks" target="_blank">enable pretty permalinks</a>.' );

			} elseif ( wp_remote_retrieve_response_code( $response ) > 204 ) {

				$body = json_decode( wp_remote_retrieve_body( $response ) );

				if ( ! empty( $body->code ) ) {

					if ( 'rest_no_route' == $body->code ) {

						$body->message .= ' <strong>' . __( 'This usually means the Groundhogg plugin isn\'t active.', 'wp-fusion' ) . '</strong> (URL: ' . $url . ')';

					}

					$response = new WP_Error( 'error', $body->message );

				} else {

					$response = new WP_Error( 'error', wp_remote_retrieve_response_message( $response ) );

				}
			}
		}

		return $response;

	}



	/**
	 * Initialize connection.
	 *
	 * This is run during the setup process to validate that the user has
	 * entered the correct API credentials.
	 *
	 * @since  3.38.10
	 *
	 * @param  string $url      The api url.
	 * @param  string $username The application username.
	 * @param  string $password The application password.
	 * @param  bool   $test     Whether to validate the credentials.
	 * @return bool|WP_Error A WP_Error will be returned if the API credentials are invalid.
	 */

	public function connect( $url = null, $username = null, $password = null, $test = false ) {

		if ( ! $this->params ) {
			$this->get_params( $url, $username, $password );
		}

		if ( false === $test ) {
			return true;
		}

		$request  = $this->url . '/contacts';
		$response = wp_safe_remote_get( $request, $this->params );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return true;

	}


	/**
	 * Performs initial sync once connection is configured.
	 *
	 * @since  3.38.10
	 *
	 * @return bool
	 */

	public function sync() {

		$this->connect();

		$this->sync_tags();
		$this->sync_crm_fields();

		do_action( 'wpf_sync' );

		return true;

	}


	/**
	 * Gets all available tags and saves them to options.
	 *
	 * @since  3.38.10
	 *
	 * @return array|WP_Error Either the available tags in the CRM, or a WP_Error.
	 */
	public function sync_tags() {

		$available_tags = array();
		$continue       = true;
		$page           = 1;

		while ( $continue ) {

			$request  = $this->url . '/tags?sort_by=id&sort_order=DESC&per_page=100&page=' . $page;
			$response = wp_safe_remote_get( $request, $this->get_params() );

			if ( is_wp_error( $response ) ) {
				return $response;
			}

			$response = json_decode( wp_remote_retrieve_body( $response ) );

			if ( ! empty( $response->items ) ) {

				foreach ( $response->items as $tag ) {

					$available_tags[ $tag->ID ] = $tag->data->tag_name;

				}
			}

			if ( empty( $response->items ) || count( $response->items ) < 100 ) {
				$continue = false;
			} else {
				$page++;
			}
		}

		asort( $available_tags );

		wp_fusion()->settings->set( 'available_tags', $available_tags );

		return $available_tags;

	}


	/**
	 * Gets all available fields from the CRM and saves them to options.
	 *
	 * @since  3.38.10
	 *
	 * @return array|WP_Error Either the available fields in the CRM, or a WP_Error.
	 */
	public function sync_crm_fields() {

		// Load built in fields first.

		$fields = WPF_Groundhogg_REST_Admin::get_default_fields();

		$built_in_fields = array();

		foreach ( $fields as $data ) {
			$built_in_fields[ $data['crm_field'] ] = $data['crm_label'];
		}

		asort( $built_in_fields );

		// Then get custom ones

		$request  = $this->url . '/fields?per_page=500';
		$response = wp_safe_remote_get( $request, $this->get_params() );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		$custom_fields = array();

		if ( ! empty( $response->items ) ) {
			foreach ( $response->items as $field ) {
				$custom_fields[ $field->id ] = $field->label;
			}
		}

		asort( $custom_fields );

		$crm_fields = array(
			'Standard Fields' => $built_in_fields,
			'Custom Fields'   => $custom_fields,
		);

		wp_fusion()->settings->set( 'crm_fields', $crm_fields );

		return $crm_fields;

	}


	/**
	 * Gets contact ID for a user based on email address.
	 *
	 * @since  3.38.10
	 *
	 * @param  string $email_address The email address to look up.
	 * @return int|WP_Error The contact ID in the CRM.
	 */
	public function get_contact_id( $email_address ) {

		$request  = $this->url . '/contacts?per_page=1&search=' . rawurlencode( $email_address );
		$response = wp_safe_remote_get( $request, $this->get_params() );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		if ( empty( $response->items ) ) {
			return false;
		}

		return $response->items[0]->ID;

	}



	/**
	 * Gets all tags currently applied to the contact in the CRM.
	 *
	 * @since  3.38.10
	 *
	 * @param  int $contact_id The contact ID to load the tags for.
	 * @return array|WP_Error The tags currently applied to the contact in the CRM.
	 */
	public function get_tags( $contact_id ) {

		$request  = $this->url . '/contacts/' . $contact_id;
		$response = wp_safe_remote_get( $request, $this->get_params() );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		$tags = array();

		foreach ( $response->item->tags as $tag ) {
			$tags[] = $tag->ID;
		}

		return $tags;

	}


	/**
	 * Applies tags to a contact.
	 *
	 * @since  3.38.10
	 *
	 * @param  array $tags       A numeric array of tags to apply to the
	 *                           contact.
	 * @param  int   $contact_id The contact ID to apply the tags to.
	 * @return bool|WP_Error Either true, or a WP_Error if the API call failed.
	 */
	public function apply_tags( $tags, $contact_id ) {

		$params         = $this->get_params();
		$params['body'] = wp_json_encode( $tags );

		$request  = $this->url . '/contacts/' . $contact_id . '/tags';
		$response = wp_safe_remote_post( $request, $params );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return true;

	}

	/**
	 * Removes tags from a contact.
	 *
	 * @since  3.38.10
	 *
	 * @param  array $tags       A numeric array of tags to remove from
	 *                           the contact.
	 * @param  int   $contact_id The contact ID to remove the tags from.
	 * @return bool|WP_Error Either true, or a WP_Error if the API call failed.
	 */
	public function remove_tags( $tags, $contact_id ) {

		$params           = $this->get_params();
		$params['body']   = wp_json_encode( $tags );
		$params['method'] = 'DELETE';

		$request  = $this->url . '/contacts/' . $contact_id . '/tags';
		$response = wp_safe_remote_post( $request, $params );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return true;

	}



	/**
	 * Adds a new contact.
	 *
	 * @since  3.38.10
	 *
	 * @param  array $data            An associative array of contact
	 *                                fields and field values.
	 * @param  bool  $map_meta_fields Whether to map WordPress meta keys
	 *                                to CRM field keys.
	 * @return int|WP_Error Contact ID on success, or WP Error.
	 */
	public function add_contact( $data, $map_meta_fields = true ) {

		if ( $map_meta_fields ) {
			$data = wp_fusion()->crm_base->map_meta_fields( $data );
		}

		$fields = wpf_get_option( 'crm_fields' );

		// Custom fields go in their own key.

		$meta = array();

		foreach ( $data as $key => $value ) {

			if ( ! isset( $fields['Standard Fields'][ $key ] ) ) {

				$meta[ $key ] = $value;

				unset( $data[ $key ] );

			}
		}

		$update_data = array(
			'data' => $data,
			'meta' => $meta,
		);

		$params         = $this->get_params();
		$params['body'] = wp_json_encode( $update_data );

		$request  = $this->url . '/contacts';
		$response = wp_safe_remote_post( $request, $params );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		return $response->item->ID;

	}

	/**
	 * Updates an existing contact record.
	 *
	 * @since  3.38.10
	 *
	 * @param  int   $contact_id      The ID of the contact to update.
	 * @param  array $data            An associative array of contact
	 *                                fields and field values.
	 * @param  bool  $map_meta_fields Whether to map WordPress meta keys
	 *                                to CRM field keys.
	 * @return bool|WP_Error Error if the API call failed.
	 */
	public function update_contact( $contact_id, $data, $map_meta_fields = true ) {

		if ( $map_meta_fields ) {
			$data = wp_fusion()->crm_base->map_meta_fields( $data );
		}

		$fields = wpf_get_option( 'crm_fields' );

		// Custom fields go in their own key.

		$meta = array();

		foreach ( $data as $key => $value ) {

			if ( ! isset( $fields['Standard Fields'][ $key ] ) ) {

				$meta[ $key ] = $value;

				unset( $data[ $key ] );

			}
		}

		$update_data = array(
			'data' => $data,
			'meta' => $meta,
		);

		$params         = $this->get_params();
		$params['body'] = wp_json_encode( $update_data );

		$request  = $this->url . '/contacts/' . $contact_id;
		$response = wp_safe_remote_post( $request, $params );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return true;

	}


	/**
	 * Loads a contact record from the CRM and maps CRM fields to WordPress
	 * fields.
	 *
	 * @since  3.38.10
	 *
	 * @param  int $contact_id The ID of the contact to load.
	 * @return array|WP_Error User meta data that was returned.
	 */
	public function load_contact( $contact_id ) {

		$request  = $this->url . '/contacts/' . $contact_id;
		$response = wp_safe_remote_get( $request, $this->get_params() );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$user_meta      = array();
		$contact_fields = wpf_get_option( 'contact_fields' );
		$response       = json_decode( wp_remote_retrieve_body( $response ), true );

		$data = $response['item']['data'];

		if ( ! empty( $response['item']['meta'] ) ) {
			$data = array_merge( $data, $response['item']['meta'] ); // merge custom fields for quicker mapping.
		}

		foreach ( $contact_fields as $field_id => $field_data ) {

			if ( $field_data['active'] && isset( $data[ $field_data['crm_field'] ] ) ) {
				$user_meta[ $field_id ] = $data[ $field_data['crm_field'] ];
			}
		}

		return $user_meta;

	}


	/**
	 * Gets a list of contact IDs based on tag.
	 *
	 * @since  3.38.10
	 *
	 * @param  string $tag    The tag ID or name to search for.
	 * @return array  Contact IDs returned.
	 */
	public function load_contacts( $tag ) {

		$request  = $this->url . '/contacts/?tags_include=' . $tag;
		$response = wp_safe_remote_get( $request, $this->get_params() );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		if ( empty( $response->items ) ) {
			return array();
		}

		$contact_ids = array();

		foreach ( $response->items as $contact ) {
			$contact_ids[] = $contact->ID;
		}

		return $contact_ids;

	}


}
