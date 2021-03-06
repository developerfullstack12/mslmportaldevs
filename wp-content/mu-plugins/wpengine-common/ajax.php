<?php
//class to handle wpe-related ajax
class Wpe_Ajax {
	/**
	* Since this class has to be hooked statically into the wp_ajax_ hook we don't need the standard constructor (though we may want it later).
	* This class assumes a POST request containing the wpe-action variable and runs a method based on whether it is set.
	*/
	public static function instance() {
		check_ajax_referer( 'wpe_common_ajax_nonce', 'nonce' );

		$wpe_action = isset( $_REQUEST['wpe-action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wpe-action'] ) ): '';

		if ( ! empty( $wpe_action ) ){
			$method = str_replace('-','_', $wpe_action);
			if ( method_exists( 'Wpe_Ajax', $method ) ) {
				call_user_func_array(array('Wpe_Ajax',$method), array());
			} else {
			die('Method not found');
			}

		} else{
			die();
		}
	}

	/**
	* Hide a pointer
	* If a pointer variable is sent with this request then the value is added to the usermeta
	*/
	public function hide_pointer() {
		if( !is_user_logged_in() )
			wp_die("Must be an autheticated user");

		$pointer_nonce = isset( $_REQUEST['pointer'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['pointer'] ) ) : '';
		if ( isset( $_REQUEST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ), 'wpe_common_ajax_nonce'  ) ) {
			$user = wp_get_current_user();

			add_user_meta( $user->ID, 'hide-pointer', esc_attr( $pointer_nonce ) );
		}
	}

	/**
	* Lookup Tables
	*
	*/
	public function lookup_tables() {
		global $wpdb;
		$result = $wpdb->get_col("SHOW TABLES;");
		print json_encode($result);
	}

	/**
	* Deploy From Staging
	* Sends the api request to deploy from staging
	*/
	public function deploy_staging() {

		if ( ! is_user_logged_in() ) {
			wp_die( "Must be an autheticated user" );
		}

		if ( ! current_user_can( 'administrator' ) ) {
			wp_die( "Must be an administrator" );
		}

		if ( ! defined( "PWP_NAME" ) or ! defined( 'WPE_APIKEY' ) ) {
			echo "This process could not be started.";
		}

		require_once( WPE_PLUGIN_DIR . '/class-wpeapi.php' );

		if ( isset( $_REQUEST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ), 'wpe_common_ajax_nonce' ) ) {

			$db_mode = isset( $_REQUEST['db_mode'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['db_mode'] ) ) : 'default';
			$email   = isset( $_REQUEST['email'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['email'] ) ) : get_option( 'admin_email' );
			$tables  = isset( $_REQUEST['tables'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['tables'] ) ) : false;

			$api = new WPE_API();
			$api->set_arg( 'method', 'deploy-from-staging' );
			$api->set_arg( 'db_mode', esc_attr( $db_mode ) );
			$api->set_arg( 'email', esc_attr( $email ) );
			if ( $tables ) {
				$api->set_arg( 'tables', implode( '&', $tables ) );
			}
			$api_domain = wpe_el( $GLOBALS, 'api-domain', 'https://api.wpengine.com' );
			$api_domain = str_replace( "https://", "", $api_domain );
			$api->set_arg( 'headers', "Host:{$api_domain}" );
			$api->post();
			if ( ! $api->is_error() ) {
				echo "Your request has been submitted. You will receive an email once it has been processed";
			} else {
				echo $api->is_error();
			}
		} else {
			echo "There was an error verifying the request.";
		}
	}
}
