<?php
/**
 * Helpers
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function setting_is_active( $class_name = '' ) {
	if ( empty( $class_name ) ) {
		return false;
	}

	$get_option = get_option( 'learndash_powerpack_active_classes' );

	if ( isset( $get_option[ $class_name ] ) && 'active' === $get_option[ $class_name ] ) {
		return true;
	}

	return false;
}

/**
 * Checks if a file exists using the classname.
 *
 * @param string $class_name the classname to look for.
 *
 * @return bool
 */
function check_if_file_exist_using_class_name( $class_name = '' ) {
	if ( empty( $class_name ) ) {
		return false;
	}
	$class_name = learndash_powerpack_format_class_file_include( $class_name );
	global $wp_filesystem;
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	$file_path = LD_POWERPACK_PLUGIN_PATH . '/includes/ld_classes/' . $class_name . '.php';

	if ( ! $wp_filesystem->exists( $file_path ) ) {
		return false;
	}

	return true;
}

/**
 * Formats the classname to strlower and replaces _ to -.
 *
 * @param String $class_name the classname to replace.
 *
 * @return false if the classname is empty or formatted classname.
 */
function learndash_powerpack_format_class_file_include( $class_name ) {
	if ( empty( $class_name ) ) {
		return false;
	}
	$class_name = strtolower( str_replace( '_', '-', $class_name ) );

	return $class_name;
}

/**
 * Checks if current class is active.
 *
 * @param String $class_name the classname to format.
 *
 * @return false if the classname is empty or formatted classname.
 */
function if_current_class_is_active( $class_name = '' ) {
	$find_class_status = '';
	$get_option        = get_option( 'learndash_powerpack_active_classes' );
	if ( isset( $get_option[ $class_name ] ) ) {
		$find_class_status = $get_option[ $class_name ];
	}

	return $find_class_status;
}

/**
 * Cleans post.
 *
 * @param array $var the post to clean.
 *
 * @return array or scalar with the cleaned values.
 */
function ld_post_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'ld_post_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}
