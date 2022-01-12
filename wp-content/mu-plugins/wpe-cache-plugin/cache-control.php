<?php
declare(strict_types=1);

namespace wpengine\cache_plugin;

require_once __DIR__ . '/security/security-checks.php';
require_once __DIR__ . '/cache-db-settings.php';
require_once __DIR__ . '/cache-setting-values.php';
\wpengine\cache_plugin\check_security();

class CacheControl {
	private $db_settings;

	public function __construct( CacheDbSettings $db_settings ) {
		$this->db_settings = $db_settings;
	}

	public function send_header_cache_control_length( $last_modified, $post_id, $post_type ): void {
		$last_mod_seconds = time() - $last_modified;
		if ( $this->db_settings->get( 'smarter_cache_enabled' ) &&
			in_array( $post_type, $this->db_settings->get( 'sanitized_builtin_post_types' ), true ) && $last_mod_seconds > CacheSettingValues::FOUR_WEEKS_IN_SECONDS ) {
			$cache_length = CacheSettingValues::SIX_MONTHS_IN_SECONDS;
			$cache_length = apply_filters( 'wpe_smarter_cache_length', $cache_length );
		} else {
			$cache_length = $this->db_settings->get( $post_type . '_cache_expires_value' );
		}

		if ( ! $this->headers_sent() ) {
			$this->header( $cache_length );
		}
	}

	public function send_header_last_modified( $last_modified, $post_id, $post_type ) {
		$last_modified_toggle = $this->db_settings->get( 'last_modified_enabled' );
		if ( '1' === $last_modified_toggle && in_array( $post_type, $this->db_settings->get( 'sanitized_post_types' ), true ) ) {
			$last_modified        = apply_filters( 'wpe_last_modified_header', $last_modified, $post_id );
			$last_modified_header = gmdate( 'D, d M Y H:i:s T', $last_modified );
			$this->send_last_modified_header( $last_modified_header );
		}
	}

	public function headers_sent(): bool {
		return headers_sent();
	}

	public function send_last_modified_header( $last_modified ) {
		header( "Last-Modified: $last_modified" );
	}

	public function header( $cache_length ): void {
		if ( $this->is_setting_default_value( $cache_length ) ) {
			return;
		}
		header( "Cache-Control: max-age=$cache_length, must-revalidate" );
	}

	public function is_on_active_woocommerce_page(): bool {
		return is_plugin_active( 'woocommerce/woocommerce.php' ) && ( is_cart() || is_checkout() );
	}

	public function wpe_add_cache_header(): void {
		if ( ! $this->is_singular() ) {
			return;
		}
		// Displaying headers when users were logged in lead to some weird stuff with browser cache.
		// Better to just avoid it when we're passing through varnish anyway.
		if ( $this->is_user_logged_in() ) {
			return;
		}
		$post_id       = $this->get_the_id();
		$post_type     = get_post_type( $post_id );
		$last_modified = get_the_modified_date( 'U' );
		if ( $this->is_on_active_woocommerce_page() ) {
			return;
		} else {
			$this->send_header_cache_control_length( $last_modified, $post_id, $post_type );
			$this->send_header_last_modified( $last_modified, $post_id, $post_type );
		}
	}

	public function get_the_id() {
		return get_the_ID();
	}

	public function is_singular(): bool {
		return is_singular();
	}

	public function is_user_logged_in(): bool {
		return is_user_logged_in();
	}

	public function get_namespace( $route ) {
		$namespaces = $this->db_settings->get( 'namespaces' );
		foreach ( $namespaces as $namespace ) {
			if ( false !== strpos( $route, $namespace ) ) {
				return $namespace;
			}
		}
	}

	public function send_header_cache_control_api( $route ) {
		$namespace              = $this->get_namespace( $route );
		$namespace_cache_length = $this->db_settings->get( $namespace . '_cache_expires_value' );
		$namespace_cache_length = apply_filters( 'wpe_cache_namespace_cache_length', $namespace_cache_length, $namespace, $route );
		if ( ! $this->headers_sent() ) {
			$this->header( $namespace_cache_length );
		}
	}

	private function is_setting_default_value( $value ): bool {
		return CacheSettingValues::SETTING_DEFAULT_VALUE === $value;
	}
}
