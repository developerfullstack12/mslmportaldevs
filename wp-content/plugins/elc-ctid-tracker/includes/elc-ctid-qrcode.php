<?php
/**
 * Created by PhpStorm.
 * User: Michael Dajewski
 * Date: 10/22/20
 * Time: 10:00
 */

require_once plugin_dir_path( __FILE__ ) . 'elc-ctid-certificate-edit.php';

/**
 * Callback for 'admin_enqueue_scripts' action.
 * Load scripts for admin pages.
 */
function elc_certificate_id_admin_enqueue_scripts( $hook ) {
	$post_id = get_the_ID();
	$post_type = get_post_type( $post_id );

	if( 'post.php' == $hook && $post_type === 'sfwd-certificates' ) {
		$src = 'js/elc_ctid_admin.js';
		$_ver = date( "ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . $src ) );
		wp_enqueue_script( 'elc_ctid_admin_js',
			plugins_url( $src, __FILE__ ),
			array(),
			$_ver,
			true
		);
	}
	if( version_compare( LEARNDASH_VERSION, '3.2.3.6', 'le' ) ) {
		$src = 'js/elc_ctid_admin_ld_legacy.js';
		$_ver = date( "ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . $src ) );
		wp_enqueue_script( 'elc_ctid_admin_ld_legacy',
			plugins_url( $src, __FILE__ ),
			array(),
			$_ver,
			true
		);
	}
}

/**
 * Load scripts.
 */
add_action( 'admin_enqueue_scripts', 'elc_certificate_id_admin_enqueue_scripts' );

/**
 *
 */
if( version_compare( LEARNDASH_VERSION, '3.3.0', 'lt' ) || ( defined( 'UNCANNY_TOOLKIT_PRO_VERSION' ) && version_compare( UNCANNY_TOOLKIT_PRO_VERSION, '3.6', 'lt' ) ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'elc-ctid-ld-legacy-qrcode.php';
} else {
	require_once plugin_dir_path( __FILE__ ) . 'elc-ctid-ld-3300-qrcode.php';
}
