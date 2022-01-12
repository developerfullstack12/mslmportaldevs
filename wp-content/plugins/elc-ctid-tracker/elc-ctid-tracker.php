<?php
/**
 * Plugin Name: Certificate Tracker for LearnDash
 * Plugin URI: http://elearningcomplete.com
 * Description: Provides shortcode to render unique certificate ID on certificates and saves to Database.
 * Version: 1.02.03
 * Text Domain: elc-ctid-tracker
 * Store ItemID: 12520
 * Author: E|Learning Complete
 * Author URI: http://www.elearningcomplete.com
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Updater block BEGIN */
if( ! class_exists( 'ELC_SL_Plugin_Updater' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'updater/ELC_SL_Plugin_Updater.php';
}

/**
 * Register action to initialise ELC Updater.
 */
add_action( 'admin_init', function () {
	$elc_updater = new ELC_SL_Plugin_Updater( __FILE__ );
} );

/**
 * Register plugin license page.
 * Do not add menu item to admin settings menu.
 */
add_action( 'admin_menu', function () {
	$page_callback = array( 'ELC_SL_Plugin_Updater', 'licenseFormHTML' );
	$menu_slug = basename( __FILE__, '.php' ) . '-license';
	$url = ELC_SL_Plugin_Updater::registerPluginLicensePage( $page_callback, $menu_slug );
} );

/**
 * Register action to process license activate/deactivate.
 */
add_action( 'admin_init', array( 'ELC_SL_Plugin_Updater', 'ELCLicenseActions' ) );

/**
 * Register action for admin notices.
 */
add_action( 'admin_notices', array( 'ELC_SL_Plugin_Updater', 'ELCLinenseAdminNotices' ) );
/** Updater block END */

/**
 * Register activation hook.
 */
register_activation_hook( __FILE__, 'elc_certificate_id_activation' );

/**
 * Activation hook callback.
 */
function elc_certificate_id_activation() {

	// Create temp dir.
	$tmp_path = elc_certificate_id_get_tmp_path();

	// Schedules a cleanup recurring event.
	wp_schedule_event( time() + ( 3600 * 24 ), 'daily', 'elc_certificate_id_daily_cleanup' );
}

/**
 * Register deactivation hook.
 */
register_deactivation_hook( __FILE__, 'elc_certificate_id_deactivation' );

/**
 * Deactivation hook callback.
 */
function elc_certificate_id_deactivation() {
	// Remove a cleanup recurring event.
	wp_clear_scheduled_hook( 'elc_certificate_id_daily_cleanup' );
}

/**
 * Register action for plugins loaded.
 */
add_action( 'plugins_loaded', 'elc_certificate_id_init' );

/**
 * 'plugins_loaded' action callback function.
 * Load text domain.
 */
function elc_certificate_id_init() {
	$test = load_plugin_textdomain( 'elc-ctid-tracker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	require_once plugin_dir_path( __FILE__ ) . 'includes/elc-ctid-qrcode.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/elc-ctid-reporting.php';
}

/**
 * Return path to temp dir.
 *
 * @return string
 */
function elc_certificate_id_get_tmp_path() {
	$upload_dir = wp_upload_dir();

	$tmp_path = $upload_dir[ 'basedir' ] . '/elc-tmp';

	// If temp dir does not exist, create it.
	if( ! file_exists( $tmp_path ) ) {
		mkdir( $tmp_path, 0755 );
	}

	return $tmp_path;
}

/**
 * Delete old temporary files.
 * Scheduled task.
 * @SEE: elc_certificate_id_activation()
 *
 * @return int  number of deleted files.
 */
function elc_certificate_id_daily_cleanup() {
	// Remove old temp files

	$tmp_path = elc_certificate_id_get_tmp_path();

	// @TODO: Change 300 to 86400. For testing purposes the age of the file is set to 5min.
	$older_than = time() - 300;//86400;
	$num = 0; // Number of files deleted.

	$files = glob( $tmp_path . DIRECTORY_SEPARATOR . '*' );
	foreach( $files as $file ) {
		if( filemtime( $file ) < $older_than ) {
			// File has not been modified in over a day.
			if( unlink( $file ) ) {
				$num++;
			}
		}
	}

	return $num;
}

/**
 * Add a new shortcode.
 */
add_shortcode( 'elc_certificate_id', 'elc_certificate_id' );

/**
 * Shortcode callback function.
 *
 * @param $atts
 * @return string|void
 */
function elc_certificate_id( $atts ) {

	$user_id = get_current_user_id();

	if( empty( $_REQUEST ) ) return;

	if( isset( $_REQUEST[ 'quiz' ] ) && ( $_id = $_REQUEST[ 'quiz' ] ) ) {
		// This is a quiz certificate.
		if( isset( $_POST[ 'results' ][ 'comp' ][ 'quizEndTimestamp' ] ) ) {
			$_tstamp = intval( $_POST[ 'results' ][ 'comp' ][ 'quizEndTimestamp' ] / 1000 );
		} else {
			$st_sfwd_quizzes = get_user_meta( $user_id, '_sfwd-quizzes', true );
			if( $st_sfwd_quizzes ) {
				$quiz_time = $_REQUEST[ 'time' ];
				$pass_array = array_filter( $st_sfwd_quizzes, function ( $ar ) use ( $_id, $quiz_time ) {
					if( isset( $quiz_time ) ) {
						// User selected 'Certificate' link from 'profile' page.
						return ( $ar[ 'pass' ] == 1 && $ar[ 'quiz' ] == $_id && $ar[ 'time' ] == $quiz_time );
					} else {
						// User selected 'PRINT YOUR CERTIFICATE' button after passing the the quiz.
						return ( $ar[ 'pass' ] == 1 && $ar[ 'quiz' ] == $_id );
					}
				} );
			}
			foreach( $pass_array as $key => $val ) {
				$quiz_id_ar[] = array(
					'quiz'      => $val[ 'quiz' ],
					'completed' => $val[ 'completed' ],
				);
			}
			// Get the last quiz from the array if there is no $_REQUEST[ 'time' ] set.
			// The same logic as in:
			// wp-content/plugins/sfwd-lms/includes/quiz/ld-quiz-info-shortcode.php:learndash_quizinfo()
			$_tstamp = end( $quiz_id_ar )[ 'completed' ];
		}
	} elseif( isset( $_REQUEST[ 'course_id' ] ) && ( $_id = $_REQUEST[ 'course_id' ] ) ) {
		// This is a course certificate.
		$_tstamp = get_user_meta( $user_id, 'course_completed_' . $_id, true );
	} else {
		return;
	}

	$certificate_meta_key = 'elc_certificate_ids';

	$saved_certificates = get_user_meta( $user_id, $certificate_meta_key, true );
	$saved_certificates = maybe_unserialize( $saved_certificates );

	if( ! is_array( $saved_certificates ) ) {
		$saved_certificates = array();
	}

	$prefix = $atts[ 'prefix' ];

	$pattern = '/[^A-Za-z0-9 ]/';
	// Alphanumeric, no special characters, upto 8 characters long.
	if( ! empty( $prefix ) ) $prefix = substr( preg_replace( $pattern, '', $prefix ), 0, 8 ) . '-';

	if( isset( $_REQUEST[ 'quiz' ] ) && isset( $_REQUEST[ 'course_id' ] ) ) {
		// This is a call from e.g.: Uncanny email course and/or quiz certificates.
		// If this is a course certificate LD already updated user_meta ('course_completed_<course_id>').
		// else it is a quiz email
		$_course_completed_tstamp = intval( get_user_meta( $user_id, 'course_completed_' . $_POST[ 'course_id' ], true ) );
		if( $_tstamp < $_course_completed_tstamp ) {
			// This is a course
			$_tstamp = $_course_completed_tstamp;
			$_id = $_REQUEST[ 'course_id' ];
		}
	}

	$certificate_full_id = $prefix . $_tstamp . '-' . $_id . '-' . $user_id;

	// Search in $saved_certificates for $certificate_full_id
	$found = array_filter( $saved_certificates, function ( $ar ) use ( $_id, $certificate_full_id, $saved_certificates ) {
		if( $ar[ 'cid' ] === $certificate_full_id ) {
			return $ar;
		}
	} );

	if( empty( $found ) ) {
		// Create new certificate item.
		$certificate_meta_value_array = array(
			'cid' => $prefix . $_tstamp . '-' . $_id . '-' . $user_id,
		);
		// Add it into $saved_certificates array.
		$saved_certificates[] = $certificate_meta_value_array;
		// Update user meta.
		update_user_meta( $user_id, $certificate_meta_key, $saved_certificates );
	}

	return $certificate_full_id;
}

/**
 * Helper function to get from post content the shortcode by it's tag name
 * and return the array of shortcode arguments.
 *
 * @param  string $content
 * @param  array|string $tagname
 * @return array|void
 */
function elc_certificate_id_get_shortcode_args( $content, $tagname ) {
	$pattern = is_array( $tagname ) ? get_shortcode_regex( $tagname ) : get_shortcode_regex( array( $tagname ) );
	if( preg_match_all( '/' . $pattern . '/s', $content, $matches ) ) {
		$keys = array();
		$shortcode_args = array();
		$i = 0;
		$output = array();
		foreach( $matches[ 0 ] as $key => $value ) {
			// $matches[3] return the shortcode attribute(s) as string.
			// Replace space with '&' for parse_str() function.

			// Do not parse shortcodes with double square brackets
			// $matches[1] and $matches[1] return double square brackets.
			if( empty( $matches[ 1 ][ $key ] ) && empty( $matches[ 6 ][ $key ] ) ) {
				$get = str_replace( ' ', '&', str_replace( '"', '', $matches[ 3 ][ $key ] ) );
				parse_str( $get, $output );

				// Get all shortcode attribute keys.
				$keys = array_unique( array_merge( $keys, array_keys( $output ) ) );
				$shortcode_args[ $i ] = $output;
				$i++;
			}
		}

		return $shortcode_args;
	} else {

		return;
	}
}

/**
 * Add full certificate ID to SU QRcode data and link.
 * This way we can pass the certificate ID as query parameter to certificate-verification page.
 *
 * @param $out
 * @param $pairs
 * @param $atts
 * @return mixed
 */
function elc_certificate_id_query_param( $out ) {

	// Process only if shortcode is in certificate.
	// This condition is similar to one in elc_certificate_id()
	// Uncanny email course and/or quiz certificates.
	if( ! ( isset( $_REQUEST[ 'quiz' ] ) || isset( $_REQUEST[ 'course_id' ] ) ) ) {

		return $out;
	}

	// Get site URL.
	if( is_multisite() ) {
		$_shp = network_site_url();
	} else {
		$_shp = site_url();
	}

	// Get 'Certificate ID' prefix from shortcode in certificate post content.
	$cert_id_prefix = elc_certificate_id_get_prefix();

	// Get certificate verification page id.
	$verification_page_id = elc_certificate_id_get_verification_page_id( $out[ 'data' ] );

	// Get certificate full ID, including prefix.
	$certificate_full_id = elc_certificate_id( array( 'prefix' => $cert_id_prefix ) );

	// Construct 'plain' permalink to the certificate verification page and add certificate id to the query.
	$_qr_link_url = add_query_arg( array(
		'p'              => $verification_page_id,
		'certificate_id' => $certificate_full_id,
	), trailingslashit( $_shp ) );

	$out[ 'data' ] = $out[ 'link' ] = $_qr_link_url;

	return $out;
}

/**
 * Helper function.
 * Find out from the data url the verification page id.
 *
 * @param $data
 * @return string|void  verification page id
 */
function elc_certificate_id_get_verification_page_id( $data ) {
	global $wp_rewrite;
	$_page_post_id = null;

	// First, check to see if there is a 'p=N' or 'page_id=N' to match against.
	if( preg_match( '#[?&](p|page_id|attachment_id)=(\d+)#', $data, $values ) ) {
		$_page_post_id = absint( $values[ 2 ] );
	}

	// Check if $wp_rewrite is set, url_to_postid() uses it.
	if( ! is_null( $wp_rewrite ) && ! is_null( $_page_post_id ) ) {
		$_page_post_id = url_to_postid( $data );
	}

	if( is_null( $_page_post_id ) ) {
		$_page_path = parse_url( $data, PHP_URL_PATH );
		$_page_obj = get_page_by_path( $_page_path );
		if( ! empty( $_page_obj ) ) {
			$_page_post_id = $_page_obj->ID;
		}
	}

	return $_page_post_id;
}

/**
 * Filter a shortcode’s default attributes.
 * The 'su_qrcode' id is actually 'qrcode'.
 */
add_filter( 'shortcode_atts_qrcode', 'elc_certificate_id_query_param' );

/**
 * Add a new shortcode.
 */
add_shortcode( 'elc_certificate_qrcode', 'elc_certificate_qrcode' );

/**
 * Helper function.
 * Get 'Certificate ID' prefix from shortcode in certificate post content.
 *
 * @return string
 */
function elc_certificate_id_get_prefix( $certificate_id = null ) {
	$cert_id_prefix = '';

	if( ! $certificate_id ) {
		// Get certificate_id
		if( isset( $_REQUEST[ 'quiz' ] ) ) {
			$meta = get_post_meta( $_REQUEST[ 'quiz' ], '_sfwd-quiz', true );
			$certificate_id = $meta[ 'sfwd-quiz_certificate' ];
		} elseif( isset( $_REQUEST[ 'course_id' ] ) ) {
			$meta = get_post_meta( $_REQUEST[ 'course_id' ], '_sfwd-courses', true );
			$certificate_id = $meta[ 'sfwd-courses_certificate' ];
		} else {
			$certificate_id = null;
		}
	}

	if( ! empty( $certificate_id ) ) {
		$content = get_post_field( 'post_content', $certificate_id );
		$shortcode_args = elc_certificate_id_get_shortcode_args( $content, array( 'elc_certificate_id' ) );
		if( ! empty( $shortcode_args ) ) {
			$cert_id_prefix = $shortcode_args[ 0 ][ 'prefix' ] ? $shortcode_args[ 0 ][ 'prefix' ] : '';
		}
	}

	return $cert_id_prefix;
}

/**
 * Shortcode callback function.
 *
 * @param $atts
 * @return string|void
 */
function elc_certificate_qrcode( $atts ) {

	// Get site URL.
	if( is_multisite() ) {
		$_shp = network_site_url();
	} else {
		$_shp = site_url();
	}

	$verifier_shortcode_tag = 'elc_ssc_front_search';

	$atts = shortcode_atts(
		array(
			'ecl'        => 'L',        // https://www.qrcode.com/en/about/error_correction.html
			'background' => null,       // image data
			'color'      => '#000000',  // image data
			'data'       => $_shp,      // image data and HTML hyperlink tag <a> href attribute
			'padding'    => 0,          // image data
			'size'       => null,       // image data
			'class'      => '',         // HTML inline wrapper <span>
			'link'       => null,       // HTML create hyperlink tag <a>
			'target'     => 'blank',    // HTML hyperlink tag <a> target attribute
			'title'      => '',         // HTML image tag <img> alt attribute
		),
		$atts,
		'elc_certificate_qrcode'
	);

	// Set local variables.
	$ecl = $atts[ 'ecl' ];
	$background = $atts[ 'background' ];
	$color = $atts[ 'color' ];
	$data = $atts[ 'data' ];
	$padding = $atts[ 'padding' ];
	$size = $atts[ 'size' ];
	$class = $atts[ 'class' ];
	$link = filter_var( $atts[ 'link' ], FILTER_VALIDATE_BOOLEAN );
	$target = $atts[ 'target' ];
	$title = $atts[ 'title' ];

	// Sanitize attributes.
	$ecl_values = array( 'L', 'M', 'Q', 'H' );
	$ecl = in_array( strtoupper( $ecl ), $ecl_values ) ? $ecl : 'L';
	// background, color are sanitized in TCPDF.
	$data = esc_url( $data );
	$padding = floatval( $padding );
	$size = floatval( $size );
	$class = sanitize_html_class( $class );
	// link sanitized above
	$target = ( strtolower( $target ) == 'blank' ) ? 'blank' : '';
	$title = sanitize_text_field( $title );

	// Get 'Certificate ID' prefix from shortcode in certificate post content.
	$cert_id_prefix = elc_certificate_id_get_prefix();

	// Get certificate verification page id.
	$verification_page_id = elc_certificate_id_get_verification_page_id( $data );

	// Verify URL provided in data.
	// Verification page must have the [elc_ssc_front_search] shortcode.
	$verification_page_content = get_post_field( 'post_content', $verification_page_id );
	$has_valid_shortcode = has_shortcode( $verification_page_content, $verifier_shortcode_tag );

	// If it is verification page add certificate verification page ID
	// and certificate IF to URL query string.
	// The URL becomes qrcode data.
	//
	if( ! empty( $verification_page_id ) && $has_valid_shortcode ) {
		// Get certificate full ID, including prefix.
		$certificate_full_id = elc_certificate_id( array( 'prefix' => $cert_id_prefix ) );

		// Construct 'plain' permalink to the certificate verification page and add certificate id to the query.
		$_shp = add_query_arg( array(
			'p'              => $verification_page_id,
			'certificate_id' => $certificate_full_id,
		), trailingslashit( $_shp ) );
	}

	// Load TCPDF libraries.
	if( ! class_exists( 'TCPDF' ) ) {
		require_once LEARNDASH_LMS_LIBRARY_DIR . '/tcpdf/config/lang/' . 'eng' . '.php';
		require_once LEARNDASH_LMS_LIBRARY_DIR . '/tcpdf/tcpdf.php';
	}
	require_once( LEARNDASH_LMS_LIBRARY_DIR . '/tcpdf/tcpdf_barcodes_2d.php' );

	if( ( ! in_array( $ecl, array( 'L', 'M', 'Q', 'H' ) ) ) ) {
		$ecl = 'L'; // Default: Low error correction
	}

	// Initialize qrcode.
	$barcodeobj = new TCPDF2DBarcode( $_shp, 'QRCODE,' . $ecl );

	// Get the qrcode content in SVG format.
	$svg_code = $barcodeobj->getBarcodeSVGcode( 3, 3, $color );

	// Add settings from shortcode attributes.
	$barcode_array = $barcodeobj->getBarcodeArray();

	// Edit SVG $svg_code BEGIN
	$intrinsic_width = $barcode_array[ 'num_cols' ] * 3;
	// We do not worry about height since qrcode is a square.
//	$intrinsic_height = $barcode_array['num_rows'] * 3;

	// If $size is specified.
	if( ! empty( $size ) ) {
		// Adjust width and height if size is specified.
		$parsed = get_string_between( $svg_code, '<svg ', '>' );

		$width_height = str_replace( '="' . $intrinsic_width . '"', '="' . $size . '"', $parsed, $count );
		$svg_code = str_replace_first( $parsed, $width_height, $svg_code );
	} else {
		$size = $intrinsic_width;
	}

	// If $background specified insert <rect ...></rect> after the <desc>...</desc> element.
	if( ! empty( $background ) ) {
		$str_to_insert = '<rect width="' . $size . '" height="' . $size . '" fill="' . $background . '"/>' . "\n" . "\t";
		$pos = strpos( $svg_code, '<g id="elements" ' );
		$svg_code = substr_replace( $svg_code, $str_to_insert, $pos, 0 );
	}

	// If size is different than 'natural' or padding is specified, scale the image.
	if( $size !== $intrinsic_width || $padding > 0 ) {
		$padding_string = "translate($padding,$padding) ";
		// Adjust transform for padding and scale
		$scaled_size = $size - ( 2 * $padding );
		$scale = $scaled_size / $intrinsic_width;

		// Find 1st group element <g ...>...</g>
		$parsed = get_string_between( $svg_code, '<g id="elements" ', '>' );
		// Construct transform string.
		$transform_string = ' transform="' . $padding_string . 'scale(' . $scale . ')"';

		// Insert the transform string.
		// <g id="elements" fill="$color" stroke="none" transform="translate($padding,$padding) scale($scale)">
		$svg_code = str_replace_first( $parsed, $parsed . $transform_string, $svg_code );
	}
	// Edit SVG $svg_code END

	// Set directory for temporary files.
	$tmp_path = elc_certificate_id_get_tmp_path();

	// Set the temporary file name.
	$tmpfile = tempnam( $tmp_path, 'elc' );
	chmod( $tmpfile, 0644 );
	rename( $tmpfile, $tmpfile .= '.svg' );

	// Write the $svg_code to the temporary file.
	$bytes = file_put_contents( $tmpfile, $svg_code );

	// Run cleanup in temp dir.
	// @TODO: We may remove it because it is added to the cron upon plugin activation.
	$num = elc_certificate_id_daily_cleanup();

	if( ! $bytes ) return;
	// Change the temporary file path to URL.
	$upload_dir = wp_upload_dir();
	$tmpfile = str_replace( $upload_dir[ 'basedir' ], $upload_dir[ 'baseurl' ], $tmpfile );

	// HTML BEGIN
	// HTML tag attributes.
	$attr_alt = ! empty( $title ) ? ' alt="' . $title . '"' : '';
	$attr_class = ! empty( $class ) ? ' class="' . $class . '"' : '';
	$attr_target = ! empty( $target ) && $target == 'blank' ? ' target="_blank"' : '';
	$attr_title = ! empty( $title ) ? ' title="' . $title . '"' : '';

	// Construct the HTML output string $qr_code.
	$qr_code = '<span' . $attr_class . '>';
	$qr_code .= ! empty( $link ) ? '<a href="' . $_shp . '"' . $attr_title . $attr_target . '>' : '';
	$qr_code .= '<img src="' . $tmpfile . '"' . $attr_alt . '>';
	$qr_code .= ! empty( $link ) ? '</a>' : '';
	$qr_code .= '</span>';

	// HTML END

	return $qr_code;
}

/**
 * Helper function.
 * Return substring between two strings (without the strings).
 * @SEE: http://www.justin-cook.com/2006/03/31/php-parse-a-string-between-two-strings/
 *
 * @param $string   The string to be searched.
 * @param $start    string
 * @param $end      string
 *
 * @return string
 */
function get_string_between( $string, $start, $end ) {
	$string = ' ' . $string;
	$ini = strpos( $string, $start );
	if( $ini == 0 ) return '';
	$ini += strlen( $start );
	$len = strpos( $string, $end, $ini ) - $ini;

	return substr( $string, $ini, $len );
}

/**
 * Helper function.
 * Replace first occurance of the substring.
 * @SEE: https://stackoverflow.com/a/1252705
 *
 * @param $pattern
 * @param $replacement
 * @param $subject
 *
 * @return mixed|null
 */
function str_replace_first( $pattern, $replacement, $subject ) {
	$pattern = '/' . preg_quote( $pattern, '/' ) . '/';

	return preg_replace( $pattern, $replacement, $subject, 1 );
}
