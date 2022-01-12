<?php
/**
 * Created by PhpStorm.
 * User: michaeldajewski
 * Date: 11/22/19
 * Time: 14:47
 */

/** Common part BEGIN */
//if(isset($_GET['plugin'])) {
//	$plugin_basename = $_GET['plugin'];
//}
//
// Get plugin version from main plugin file.
$file = trailingslashit( WP_PLUGIN_DIR ) . $plugin_basename;
$current_version = ELC_SL_Plugin_Updater::getPluginFileData( $file )[ 'plugin_version' ];

// Get plugin version option.
$plugin_slug = dirname( $plugin_basename );
$version_option_name = $plugin_slug . '-version';
$version_option = get_option( $version_option_name );
if( empty( $version_option ) ) {
	// There is no plugin version option in database.
	// Create defaults.
	$version_option = array();
	$version_option[ 'version' ] = '0.0.0';
} else {
	// Merge existing option with defaults.
	$new_version_option = array();
	if( ! isset( $version_option[ 'version' ] ) ) $new_version_option[ 'version' ] = $current_version;
	$version_option = array_merge( $version_option, $new_version_option );
}

$last_installed_version = '0.0.0';
if( isset( $version_option[ 'version' ] ) ) {
	$last_installed_version = $version_option[ 'version' ];
}

if( $last_installed_version === $current_version ) {
	return; // Same version as before - do nothing.
}

// Update version with version from main plugin file.
$version_option[ 'version' ] = $current_version;
// Save option.
update_option( $version_option_name, $version_option );

$parsed_version = ELC_SL_Plugin_Updater::parseVersion( $current_version );
/** Common part END */

/** Update script BEGIN */
$pre_104 = ( $parsed_version->major === 1 && $parsed_version->minor <= 1 && $parsed_version->patch <= 4 ); // < 1.0.4

if( $pre_104 ) {
	// Move 'elc-upd-one/elc-upd-one.php' to 'elc-upd-one-license' option
	$existing_option = get_option( 'elc_h5p_options' );
	if( $existing_option ) {
		$license_option_name = $plugin_slug . '-license';
		update_option( $license_option_name, array(
			'license_key'   => $existing_option[ 'license_key' ],
			'license_state' => $existing_option[ 'license_status' ] ? $existing_option[ 'license_status' ] : null,
		) );
		unset( $existing_option[ 'license_key' ] );
		unset( $existing_option[ 'license_status' ] );

		$result = update_option( 'elc_h5p_options', $existing_option );
		$tmp = $result;
	}
}

/** Update script END */
