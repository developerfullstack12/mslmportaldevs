<?php

/**
 * Container with properties that are required to initialize EDD_SL_Plugin_Updater
 * Created by PhpStorm.
 * User: michaeldajewski
 * Date: 10/18/19
 * Time: 07:14
 * Version: 1.4
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class ELC_SL_Plugin_Updater.
 *
 * Get license data from Store site and compare with ELC license option.
 * Initializes EDD_SL_Plugin_Updater.
 * Declares functions for updating license, render the License form submitting and activating/deactivating license.
 *
 * License info is saved in wp_options table, option_name is {plugin_slug}-license.
 * plugin_slug is a dirname of the main plugin file.
 * @SEE: wp-admin/includes/plugin.php, get_plugin_data(), look for $plugin_slug variable.
 *
 * Requires main plugin file full path to initialize.
 */
class ELC_SL_Plugin_Updater
{
	static $menu_slug = '';
	private $_plugin_file = '';
	private $_base_name = '';
	private $_slug = '';
	private $_plugin_name = '';
	private $_store_uri = '';
	private $_plugin_version = '';
	private $_store_item_id = '';
	private $_plugin_author = '';
	private $_beta = '';
	private $_license_page_url = '';
	private $_license_key = '';
	private $_license_state = '';

	/**
	 * ELC_SL_Plugin_Updater constructor.
	 *
	 * @param $_plugin_file    full path for main plugin file
	 * @param array $_params
	 */
	public function __construct( $_plugin_file, $_params = array() ) {
		if( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
		}
		$this->_plugin_file = $_plugin_file;
		$this->_base_name = plugin_basename( $this->_plugin_file );
		$this->_slug = dirname( $this->_base_name );
		$this->_license_page_url = get_admin_url() . 'options-general.php?page=' . $this->_slug . '-license';

		// Get file data from main plugin file.
		$plugin_file_data = self::getPluginFileData( $this->_plugin_file );

		$this->_plugin_name = $plugin_file_data[ 'plugin_name' ];
		$this->_store_uri = $plugin_file_data[ 'store_uri' ];
		$this->_plugin_author = $plugin_file_data[ 'plugin_author' ];
		$this->_plugin_version = $plugin_file_data[ 'plugin_version' ];
		$this->_store_item_id = $plugin_file_data[ 'store_item_id' ];
		$this->_beta = ! empty( $_params[ 'beta' ] ) ? true : false;

		add_action( 'admin_post_save_elc_license_options', array( 'ELC_SL_Plugin_Updater', 'processELCLicenseOptions' ) );

		$this->init();
	}

	/**
	 * Get file data from main plaugin file.
	 *
	 * @param $file
	 * @return array
	 */
	public static function getPluginFileData( $file ) {
		return get_file_data( $file, array(
			'plugin_name' => 'Plugin Name',
			'store_uri' => 'Plugin URI',
			'plugin_author' => 'Author',
			'plugin_version' => 'Version',
			'store_item_id' => 'Store ItemID',
		) );
	}

	/**
	 * Declare WordPress action and filter.
	 * Clean EDD cache and 'update_plugins' transient, if necessary.
	 * Initialize EDD_SL_Plugin_Updater.
	 */
	public function init() {

		// Initialize only when needed.
		if( isset( $_REQUEST[ 'page' ] ) && strpos( $_REQUEST[ 'page' ], $this->_slug ) === false ) {
			return;
		}

		global $pagenow;
		$_sAction = isset( $_POST[ 'action' ] ) ? $_POST[ 'action' ] : '';
		if( 'heartbeat' === $_sAction || in_array( $pagenow, array( 'admin-ajax.php' ) ) ) {
			return;
		}

		$init_on_pages = array(
			'plugins.php',
			'update-core.php',
			'options-general.php',
			'plugin-install.php',
		);
		if( ! in_array( $pagenow, $init_on_pages ) ) {
			return;
		}

		// Allways check if necessary to run updates.
		self::runUpdateScript( $this->_base_name );

		// Get ELC license options from DB.
		$license_option_name = $this->_slug . '-license';
		$license_option = get_option( $license_option_name );
		if( ! $license_option ) {
			// There are no plugin license options in database.
			// Create defaults.
			$license_option = array();
			$license_option[ 'license_key' ] = $this->_license_key;
			$license_option[ 'license_state' ] = $this->_license_state;
			update_option( $license_option_name, $license_option );
		}

		// Set $this->_license_key to what we have in database.
		// User may have changed it in license page.
		$this->_license_key = $license_option[ 'license_key' ];
		// Get license state from $this->_store_uri and update $this->_license_state
		$_license_data = $this->getApiRequestResponse();
		// If there is a network error the getApiRequestResponse() returns false.
		// Than leave $this->_license_state with it's default value.
		if( $_license_data ) $this->_license_state = $_license_data[ 'license' ];

		// Plugin version change:
		// Get version info cache from EDD cache:
		// IMPORTANT: 'edd_sl_' is created upon
		$edd_sl_edd_cache_key = md5( serialize( $this->_slug . ( $this->_license_state == 'valid' ? $this->_license_key : '' ) . $this->_beta ) );
		$edd_sl_edd_cache_option_name = 'edd_api_request_' . $edd_sl_edd_cache_key;
		$edd_sl_edd_cache = get_option( $edd_sl_edd_cache_option_name );
		if( ! $edd_sl_edd_cache ) {
			$edd_sl_edd_cache_option_name = 'edd_sl_' . $edd_sl_edd_cache_key;
			$edd_sl_edd_cache = get_option( $edd_sl_edd_cache_option_name );
		}
		// Get 'update_plugins' transient
		$_transient = get_site_transient( 'update_plugins' );
		if( $edd_sl_edd_cache ) {
			$edd_sl_edd_cache_version_info = json_decode( $edd_sl_edd_cache[ 'value' ] );
			// Update transient if its data is different than $edd_sl_edd_cache_version_info
			if( $_transient->response ) {
				if( isset( $_transient->response[ $this->_base_name ] ) ) {
					$_plugin_transient_data = $_transient->response[ $this->_base_name ];
					if( $_plugin_transient_data->package !== $edd_sl_edd_cache_version_info->package ) {
						// Update 'update_plugins' transient.
						$_plugin_transient_data = $edd_sl_edd_cache_version_info;
						$_plugin_transient_data->plugin = $this->_base_name;
						$_transient->response[ $this->_base_name ] = $_plugin_transient_data;
						$result = set_site_transient( 'update_plugins', $_transient );
					} elseif( $_plugin_transient_data->new_version !== $edd_sl_edd_cache_version_info->new_version
						|| $_plugin_transient_data->stable_version !== $edd_sl_edd_cache_version_info->stable_version
					) {
						$_plugin_transient_data = $edd_sl_edd_cache_version_info;
						$_plugin_transient_data->plugin = $this->_base_name;
						$_transient->response[ $this->_base_name ] = $_plugin_transient_data;
						$result = set_site_transient( 'update_plugins', $_transient );
					}

				}

			}
		} else {
			// No edd_sl_ or edd_api_request_ cache options.
			// Force them to be created.
			unset( $_transient->response[ $this->_base_name ] );
			unset( $_transient->checked[ $this->_base_name ] );
			$result = set_site_transient( 'update_plugins', $_transient );
		}

		// Add 'License' link to 'plugin action links' - at 'Plugins' page.
		add_filter( 'plugin_action_links_' . $this->_base_name, array( $this, 'licenseSettingsLink' ) );

		// Check if there is a new version on the Store server.
		$_version_changed = false;
		// Get last checked version from 'update_plugins' transient.
		if( isset( $_transient->response[ $this->_base_name ] ) ) {
			if( $this->_beta ) {
				$_transient_version = $_transient->response[ $this->_base_name ]->new_version;
			} else {
				$_transient_version = $_transient->response[ $this->_base_name ]->stable_version;
			}
			// Get version data from Store server.
			$_version_data = $this->getApiRequestResponse( 'get_version' );
			if(
				( $_version_data[ 'new_version' ] !== $_transient_version
					|| $_version_data[ 'stable_version' ] !== $_transient_version
				)
				|| $this->_plugin_version !== $_transient->checked[ $this->_base_name ]
			) {
				// The plugin version has been changed.
				// There is a new version on the Store server, or plugin file version was changed.
				$_version_changed = true;
			}
		}

		if( $this->_license_state !== 'valid' ) {
			// The license is not valid at the server.
			// Insert link to plugin License page, into plugin message at Plugins page.
			add_action( 'in_plugin_update_message-' . $this->_base_name, function () {
				$settings_link = '<a href="' . $this->_license_page_url . '">' . __( 'here', 'textdomain' ) . '</a>';
				echo '<em> Click ' . $settings_link . ' to activate your license.</em>';
			} );
		}

		if( $this->_license_state !== $license_option[ 'license_state' ] ) {
			// License state we did get from the Store does not match previous state saved in
			// plugin license options.

			// Update plugin license options.
			$license_option[ 'license_state' ] = $this->_license_state;
			update_option( $license_option_name, $license_option );
		}
		if( $_version_changed ) {
			// Version we did get from the Store does not match the one in transient.
			// We did post new version at Store server.

			// Clear edd_sl_XXX and edd_api_request_XXX cache.
			// Transient 'update_plugins' will update automatically.
			$this->_clear_edd_cache();
		}

		$elc_edd_updater = new EDD_SL_Plugin_Updater(
			$this->_store_uri,
			$this->_base_name,
			array(
				'version' => $this->_plugin_version, // current version number.
				'license' => $this->_license_state == 'valid' ? $this->_license_key : '', // license key (used get_option above to retrieve from DB).
				'item_id' => $this->_store_item_id, // id of this product in EDD.
				'author' => $this->_plugin_author, // author of this plugin.
				'url' => home_url(),
				'beta' => $this->_beta,
			)
		);

	}

	/**
	 * Run update script.
	 * Use of this function is not necessary if there is no update script.
	 * It is suggested to run this function if plugin was updated manually and it is already activated.
	 *
	 * @param $plugin_basename  A variable defined in the code that calls this function.
	 *                          Format plugin_directory/main_plugin_file_name.php
	 *
	 * Example usage:
	 * Add main plugin file:
	 * add_action('init', function(){
	 *   ELC_SL_Plugin_Updater::runUpdateScript(plugin_basename( __FILE__ ));
	 *  } );
	 *
	 * Above solution will run on every page load.
	 * Better solution is to insert following in the function that is a starting point for the plugin:
	 * ELC_SL_Plugin_Updater::runUpdateScript(plugin_basename( __FILE__ ));
	 */
	public static function runUpdateScript( $plugin_basename ) {
		$file = trailingslashit( WP_PLUGIN_DIR ) . dirname( $plugin_basename ) . '/updater/update_script.php';
		if( file_exists( $file ) ) include_once( $file );
	}

	/**
	 * Get response from Store Site.
	 * Use EDD API query parameters.
	 *
	 * @param string $action
	 * @return array|bool|mixed|object
	 */
	public function getApiRequestResponse( $action = 'check_license' ) {
		$api_params = array(
			'edd_action' => $action,
			'license' => $this->_license_key,
			'item_id' => $this->_store_item_id, // The ID of the item in EDD
			'url' => home_url(),
		);

		if( $action === 'get_version' ) {
			$api_params = array(
				'edd_action' => $action,
				'license' => $this->_license_state == 'valid' ? $this->_license_key : '',
				'item_name' => false,
				'item_id' => isset( $this->_store_item_id ) ? $this->_store_item_id : false,
				'version' => false,
				'slug' => $this->_slug,
				'author' => $this->_plugin_author,
				'url' => home_url(),
				'beta' => ! empty( $this->_beta ),
			);
		}

		// Call the custom API.
		$response = wp_remote_post( $this->_store_uri, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if( is_wp_error( $response ) ) {
			//cURL error 6: Could not resolve host: eddasdfasdf.dev
			return false;
		}
		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		return $data;
	}

	/**
	 * Clear edd_sl_XXX and edd_api_request_XXX cache.
	 * Remove all options for valid and invalid license for this plugin.
	 *
	 * Forcing Plugin Update Checks Using Easy Digital Downloads Software Licensing
	 * @SEE: https://laternastudio.com/blog/forcing-plugin-update-checks-using-easy-digital-downloads-software-licensing/
	 *
	 * @return array|null|object
	 */
	private function _clear_edd_cache() {
		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name REGEXP 'edd_sl_|edd_api_request_'" );
		$sql = "DELETE FROM $wpdb->options WHERE option_name REGEXP 'edd_sl_|edd_api_request_' AND option_value LIKE %s";
		$query = $wpdb->prepare( $sql, '%' . $wpdb->esc_like( '"slug":"' . $this->_slug . '"' ) . '%' );
		$result = $wpdb->get_results( $query );
		return $result;
	}

	/**
	 * This is a means of catching errors from the activation method above and displaying it to the customer.
	 */
	public static function ELCLinenseAdminNotices() {
		if( isset( $_GET[ 'sl_activation' ] ) && ! empty( $_GET[ 'message' ] ) ) {
			switch ( $_GET[ 'sl_activation' ] ) {
				case 'false':
					$message = urldecode( $_GET[ 'message' ] );
					?>
					<div class="error">
						<p><?php echo $message; ?></p>
					</div>
					<?php
					break;
				case 'true':
				default:
					// Developers can put a custom success message here for when activation is successful if they way.
					break;
			}
		}
	}

	/**
	 * Activate/deactivate plugin license.
	 */
	public static function ELCLicenseActions() {
		// Listen for activate/deactivate button to be clicked.
		if( isset( $_POST[ 'elc_license_activate' ] ) || isset( $_POST[ 'elc_license_deactivate' ] ) ) {
			// Run security check.
			if( ! check_admin_referer( 'edd_sample_nonce', 'edd_sample_nonce' ) ) return; // get out if we didn't click the Activate button

			$plugin_basename = self::getPluginBasename();
			// Once we did rebuild plugin basename we can get all plugin info from its main php file.
			if( ! empty( $plugin_basename ) ) {
				$file = trailingslashit( WP_PLUGIN_DIR ) . $plugin_basename;
			}
			$plugin_file_data = self::getPluginFileData( $file );

			$plugin_slug = dirname( $plugin_basename );
			$license_option_name = $plugin_slug . '-license';
			// Retrieve license key from the database.
			$license = trim( get_option( $license_option_name )[ 'license_key' ] );

			$new_license_key = sanitize_text_field( $_POST[ 'license_key' ] );
			if( $new_license_key !== $license ) {
				update_option( $license_option_name, array(
					'license_key' => $new_license_key,
					'license_state' => null
				) );
				$license = $new_license_key;
			}

			$_edd_action = 'activate_license';
			if( isset( $_POST[ 'elc_license_deactivate' ] ) ) {
				$_edd_action = 'deactivate_license';
			}
			// API request to be sent to URL set in main plugin file header: Plugin URI.
			$api_params = array(
				'edd_action' => $_edd_action,
				'license' => $license,
				'item_id' => $plugin_file_data[ 'store_item_id' ], // The ID of the item in EDD
				'url' => home_url(),
			);
			// Call the custom API.
			$response = wp_remote_post( $plugin_file_data[ 'store_uri' ], array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
			// Make sure the response came back okay.
			if( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				$message = ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : __( 'An error occurred, please try again.' );
			} else {
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );
				update_option( $license_option_name, array(
					'license_key' => $license,
					'license_state' => $license_data->license
				) );
				if( false === $license_data->success ) {
					switch ( $license_data->error ) {
						case 'expired' :
							$message = sprintf(
								__( 'Your license key expired on %s.' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;
						case 'revoked' :
							$message = __( 'Your license key has been disabled.' );
							break;
						case 'missing' :
							$message = __( 'Invalid license.' );
							break;
						case 'invalid' :
						case 'site_inactive' :
							$message = __( 'Your license is not active for this URL.' );
							break;
						case 'item_name_mismatch' :
							$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), 'H5P for LearnDash ' );
							break;
						case 'no_activations_left':
							$message = __( 'Your license key has reached its activation limit.' );
							break;
						default :
							$message = __( 'An error occurred, please try again.' );
							break;
					}
				}
			}
			// Check if anything passed on a message constituting a failure.
			if( ! empty( $message ) ) {
				$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $_REQUEST[ '_wp_http_referer' ] );
				wp_redirect( $redirect );
				exit();
			}

			$options = get_option( $license_option_name, array() );
			// $license_data->license will be either "valid" or "invalid"
			$options[ 'license_state' ] = $license_data->license;
			update_option( $license_option_name, $options );
			$redirect = remove_query_arg( array( 'sl_activation', 'message' ), $_REQUEST[ '_wp_http_referer' ] );
			wp_redirect( $redirect );
			exit();
		}
	}

	/**
	 * Get plugin base bame from page URL.
	 *
	 * @return mixed
	 */
	public static function getPluginBasename() {
		$active_plugins = get_option( 'active_plugins' );
		if( isset( $_REQUEST[ 'page' ] ) ) {
			$plugin_slug = preg_replace( '/-license/', '', $_REQUEST[ 'page' ] );
		} elseif( isset( $_REQUEST[ '_wp_http_referer' ] ) ) {
			$url_query = parse_url( $_REQUEST[ "_wp_http_referer" ], PHP_URL_QUERY );
			parse_str( $url_query, $query );
			$plugin_slug = preg_replace( '/-license/', '', $query[ 'page' ] );
		}
		if( isset( $plugin_slug ) ) {
			foreach( $active_plugins as $val ) {
				if( strpos( $val, $plugin_slug . '.php' ) ) {
					$plugin_basename = $val;
					break;
				}
			}
		}
		return $plugin_basename;
	}

	/**
	 * Update ELC license options with data returned from Store site.
	 */
	public static function processELCLicenseOptions() {
		if( isset( $_POST[ 'license_key' ] ) ) {
			$plugin_basename = self::getPluginBasename();
			$plugin_slug = dirname( $plugin_basename );
			$license_option_name = $plugin_slug . '-license';

			$license_option = get_option( $license_option_name );
			if( isset( $license_option[ 'license_key' ] ) && $license_option[ 'license_key' ] !== $_POST[ 'license_key' ] ) {

				// Check if the license key is valid.
				// Get Store item id from main plugin file.
				if( ! empty( $plugin_basename ) ) {
					$file = trailingslashit( WP_PLUGIN_DIR ) . $plugin_basename;
					$plugin_file_data = self::getPluginFileData( $file );
					$api_params = array(
						'edd_action' => 'check_license',
						'license' => $_POST[ 'license_key' ],
						'item_id' => $plugin_file_data[ 'store_item_id' ], // The ID of the item in EDD
						'url' => home_url(),
					);

					// Call the custom API.
					$response = wp_remote_post( $plugin_file_data[ 'store_uri' ], array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
					$license_data = json_decode( wp_remote_retrieve_body( $response ) );

					// Update options
					$license_option = array(
						'license_key' => $_POST[ 'license_key' ],
						'license_state' => $license_data->license,
					);
					update_option( $license_option_name, $license_option );
				}
			}
		}
		$redirect = remove_query_arg( array( 'sl_activation', 'message' ), $_REQUEST[ '_wp_http_referer' ] );
		wp_redirect( $redirect );
		exit();
	}

	/**
	 * Parse version string into major, minor, patch.
	 *
	 * @since  1.01.04
	 * @param  string $file
	 * @return  stdClass|boolean false on failure to parse
	 */
	public static function parseVersion( $version ) {
		$version_array = explode( '.', $version );
		if( count( $version_array ) !== 3 ) {
			return false;
		}

		return (object)array(
			'major' => (int)$version_array[ 0 ],
			'minor' => (int)$version_array[ 1 ],
			'patch' => (int)$version_array[ 2 ]
		);
	}

	/**
	 * Check if the plugin has been updated and if we need to run some upgrade
	 * scripts, change the database or something else.
	 *
	 * @since 1.01.04
	 */

	/**
	 * Register a Callback as an Admin Page
	 *
	 * This Page is not added to any menu.
	 *
	 * @param Callback $callback
	 * @param String $menu_slug
	 * @return string URL for the new page
	 */
	public static function registerPluginLicensePage( $callback, $menu_slug ) {
		// Wordpress Constant
		$parent_slug = 'options-general.php';

		// Get Hookname
		$hookname = get_plugin_page_hookname( $menu_slug, $parent_slug );

		// Assign Callback to hook
		add_filter( $hookname, $callback );
		// Register Hook as a Page-Hook
		$GLOBALS[ '_registered_pages' ][ $hookname ] = true;

		$url = admin_url( $parent_slug . '?page=' . $menu_slug );

		return $url;
	}

	/**
	 * Render plugin license form.
	 */
	public static function licenseFormHTML() {
		// Rebuild plugin file path from the url.
		$plugin_basename = self::getPluginBasename();
		// Once we did rebuild plugin basename we can get all plugin info from its main php file.
		if( ! empty( $plugin_basename ) ) {
			$file = trailingslashit( WP_PLUGIN_DIR ) . $plugin_basename;
		}
		$plugin_slug = self::getPluginSlugFromUrl();
		$license_option_name = $plugin_slug . '-license';
		$license_option = get_option( $license_option_name );
		$license_key = $license_option[ 'license_key' ];
		$license_active = $license_option[ 'license_state' ] == 'valid' ? true : false;
		$plugin_file_data = self::getPluginFileData( $file );
		$plugin_name = $plugin_file_data[ 'plugin_name' ];

		if( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == '1' ) {
			?>
			<div id='message' class='updated fade'><p><strong>Settings Saved</strong></p></div>
			<?php
		}
		?>
		<div id="elc_h5p-general" class="wrap">
			<h1><?php echo $plugin_name; ?> Settings</h1>

			<form method="post" action="admin-post.php">
				<input type="hidden" name="action" value="save_elc_license_options">

				<h1 class="title">Plugin License</h1>
				<table class="form-table">
					<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e( 'License Key' ); ?>
						</th>
						<td>
							<input id="license_key" name="license_key" type="text" class="regular-text"
							       value="<?php esc_attr_e( $license_key ); ?>"
								<?php echo $license_active ? 'readonly' : ''; ?>/>
							<label class="description"
								<?php echo $license_active ? 'style="color:green;"' : ''; ?>
								     for="license_key">
								<?php $license_active ? _e( 'active' ) : _e( 'Enter your license key' ); ?>
							</label>
						</td>
					</tr>
					<?php if( false !== $license_key ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e( 'Activate License' ); ?>
							</th>
							<td>
								<?php if( $license_active ) { ?>
									<?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
									<input type="submit" class="button-secondary" name="elc_license_deactivate"
									       value="<?php _e( 'Deactivate License' ); ?>"/>
								<?php } else { ?>
									<?php wp_nonce_field( 'edd_sample_nonce', 'edd_sample_nonce' ); ?>
									<input type="submit" class="button-secondary" name="elc_license_activate"
									       value="<?php _e( 'Activate License' ); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" value="Submit" class="button-primary">
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Get plugin slug from page URL.
	 *
	 * @return mixed
	 */
	public static function getPluginSlugFromUrl() {
		$active_plugins = get_option( 'active_plugins' );
		if( isset( $_REQUEST[ 'page' ] ) ) {
			$plugin_slug = preg_replace( '/-license/', '', $_REQUEST[ 'page' ] );
		} elseif( isset( $_REQUEST[ '_wp_http_referer' ] ) ) {
			$url_query = parse_url( $_REQUEST[ "_wp_http_referer" ], PHP_URL_QUERY );
			parse_str( $url_query, $query );
			$plugin_slug = preg_replace( '/-license/', '', $query[ 'page' ] );
		}
		return $plugin_slug;
	}

	/**
	 * Generate settings link for the plugin.
	 *
	 * @param $links
	 * @return mixed
	 */
	public function licenseSettingsLink( $links ) {
		$settings_link = '<a href="' . $this->_license_page_url . '">' . __( 'License', 'textdomain' ) . '</a>';
		// last element
		$last = array_slice( $links, -1 );
		array_pop( $links );
		array_push( $links, $settings_link );
		$links = array_merge( $links, $last );
		return $links;
	}

}
