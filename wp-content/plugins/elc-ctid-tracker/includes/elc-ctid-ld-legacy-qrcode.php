<?php
/**
 * Created by PhpStorm.
 * User: Michael Dajewski
 * Date: 12/13/20
 * Time: 18:44
 *
 * @TODO: Insert WP hooks of someone wants to change output.
 */

/**
 * Callback funciton for 'learndash_certificate_content' filter.
 * Get featured image path from certificate post.
 * This needs to be done before LD is doing it and/or Uncanny which uses it's own copy of
 * wp-content/plugins/sfwd-lms/includes/ld-convert-post-pdf.php
 *
 * @param $cert_content
 * @param $cert_id
 * @return string
 */
function elc_certificate_id_content( $cert_content, $cert_id ) {

	$elc_qrcode_options_meta = get_post_meta( $cert_id, 'elc_qrcode_options', true );
	$enable = $elc_qrcode_options_meta[ 'enable' ];

	if( empty( $enable ) ) {
		$removed = remove_filter( 'get_post_metadata', 'elc_certificate_id_get_post_metadata', 10 );

		return $cert_content;
	}

	$img_file = null;
	if( function_exists( 'learndash_get_thumb_path' ) ) {
		$img_file = learndash_get_thumb_path( $cert_id );
	} elseif( class_exists( '\uncanny_pro_toolkit\Tcpdf_Certificate_Code' ) ) {
		$has_filter = has_filter( 'get_post_metadata', 'elc_certificate_id_get_post_metadata' );
		if( $has_filter !== false ) {
			$removed = remove_filter( 'get_post_metadata', 'elc_certificate_id_get_post_metadata', 10 );
		}
		$img_file = uncanny_pro_toolkit\Tcpdf_Certificate_Code::learndash_get_thumb_path( $cert_id );
	}

	// Use global for certificate content.
	global $elc_certificate_id_content;
	$elc_certificate_id_content = $cert_content;
	global $elc_certificate_id_img_file;
	$elc_certificate_id_img_file = $img_file;
	global $elc_certificate_id_type_course;
	global $elc_certificate_id_type_quiz;

	return '';
}

add_filter( 'learndash_certificate_content', 'elc_certificate_id_content', 10, 2 );

/**
 * Part of Uncanny fix.
 * Get $certificate_type, can be 'course' (default), 'preview', 'quiz'.
 * @SEE: \uncanny_pro_toolkit\Tcpdf_Certificate_Code::generate_course_content()
 */
add_filter( 'uo_generate_course_certificate_content',
	/**
	 * We need to know if it is 'course' certificate type.
	 * Set global $elc_certificate_id_type_course (boolean).
	 * Used in elc_certificate_id_qrcode() to disable printing featured image after
	 * it was already printed.
	 *
	 * return (string) $cert_content
	 */
	function ( $cert_content, $u_id, $course_id ) {
		global $elc_certificate_id_type_course;
		$elc_certificate_id_type_course = ! empty( $course_id );

		return $cert_content;
	}, 10, 3
);

/**
 * Part of Uncanny fix.
 * Get $certificate_type, can be 'quiz' (default), 'preview', 'quiz'.
 * @SEE: \uncanny_pro_toolkit\Tcpdf_Certificate_Code::generate_course_content()
 */
add_filter( 'uo_generate_quiz_certificate_content',
	/**
	 * We need to know if it is 'course' certificate type.
	 * Set global $elc_certificate_id_type_quiz (boolean).
	 * Used in elc_certificate_id_qrcode() to disable printing featured image after
	 * it was already printed.
	 *
	 * return (string) $cert_content
	 */
	function ( $cert_content, $u_id, $quiz_id, $course_id ) {
		global $elc_certificate_id_type_quiz;
		$elc_certificate_id_type_quiz = ! empty( $quiz_id );

		return $cert_content;
	}, 10, 4
);

/**
 * Callback function for 'learndash_certification_after' action hook.
 * @SEE: wp-content/plugins/sfwd-lms/includes/ld-convert-post-pdf.php
 * - Write 'featured' image if configured.
 *   Unset 'featured' image path so LD does not print it again.
 * - Write Output QRCode.
 * - Write Link.
 * - Set AutoPageBreak etc.
 * - Write certificate HTML.
 *   Unset the certificate HTML so LD does not print it again.
 *
 * @param $pdf
 * @param $cert_id
 */
function elc_certificate_id_qrcode( $pdf, $cert_id ) {

	$elc_qrcode_options_meta = get_post_meta( $cert_id, 'elc_qrcode_options', true );
	$enable = $elc_qrcode_options_meta[ 'enable' ];

	if( empty( $enable ) ) return;

	global $elc_certificate_id_content;

	// Get full path of featured image, so we can print it before we print qrcode.
	if( function_exists( 'learndash_get_thumb_path' ) ) {
		$img_file = learndash_get_thumb_path( $cert_id );
	} elseif( class_exists( '\uncanny_pro_toolkit\Tcpdf_Certificate_Code' ) ) {
		$img_file = uncanny_pro_toolkit\Tcpdf_Certificate_Code::learndash_get_thumb_path( $cert_id );
	}

	// Get qrcode options from post meta.
	$elc_qrcode_options_meta = get_post_meta( $cert_id, 'elc_qrcode_options', true );

	$ecl = $elc_qrcode_options_meta[ 'ecl' ];
	$data = $elc_qrcode_options_meta[ 'data' ];
	$size = $elc_qrcode_options_meta[ 'size' ];
	$padding = $elc_qrcode_options_meta[ 'padding' ];
	$x = $elc_qrcode_options_meta[ 'x' ];
	$y = $elc_qrcode_options_meta[ 'y' ];
	$elc_qrcode_options_meta[ 'align' ];
	$border = $elc_qrcode_options_meta[ 'border' ];

	$spot_color = TCPDF_COLORS::$spotcolor;
	$fgcolor = $elc_qrcode_options_meta[ 'fgcolor' ];

	if( empty( $fgcolor ) ) {
		$fgcolor = '#000';
	}
	$fgc_array = TCPDF_COLORS::convertHTMLColorToDec( $fgcolor, $spot_color );
	$bgcolor = $elc_qrcode_options_meta[ 'bgcolor' ];
	if( strcasecmp( $bgcolor, 'false' ) === 0 || strcasecmp( $bgcolor, 'transparent' ) === 0 || empty( $bgcolor ) ) {
		$bgcolor_dec = false;
	} else {
		$bgcolor_dec = TCPDF_COLORS::convertHTMLColorToDec( $bgcolor, $spot_color );
	}

	$link = $elc_qrcode_options_meta[ 'link' ];

	// Insert qrcode here.
	$style = array(
		'border'        => $border,
		'padding'       => $padding,
		'fgcolor'       => $fgc_array,
		'bgcolor'       => $bgcolor_dec,
		'module_width'  => 1,
		'module_height' => 1,
	);

	$prefix = elc_certificate_id_get_prefix( $cert_id );
	$certificate_full_id = elc_certificate_id( array( 'prefix' => $prefix ) );

	// Get certificate verification page id.
	$verification_page_id = elc_certificate_id_get_verification_page_id( $data );

	// Get site URL.
	if( is_multisite() ) {
		$_shp = network_site_url();
	} else {
		$_shp = site_url();
	}

	if( ! is_null( $verification_page_id ) ) {
		$data = add_query_arg( array(
			'p'              => $verification_page_id,
			'certificate_id' => $certificate_full_id,
		), trailingslashit( $_shp ) );
	} else {
		$data = trailingslashit( $_shp );
	}

	// Only print image if it exists.
	// Verify in wp-content/plugins/sfwd-lms/includes/ld-convert-post-pdf.php
	//   lines after 'learndash_certification_after' hook in the
	//   if( $img_file != '' ) { ... }
	//
	if( $img_file != '' ) {
		// BEGIN verify.

		//Print BG image.
		$pdf->setPrintHeader( false );

		// get the current page break margin.
		$bMargin = $pdf->getBreakMargin();

		// get current auto-page-break mode.
		$auto_page_break = $pdf->getAutoPageBreak();

		// disable auto-page-break.
		$pdf->SetAutoPageBreak( false, 0 );

		// Get width and height of page for dynamic adjustments.
		$pageH = $pdf->getPageHeight();
		$pageW = $pdf->getPageWidth();

		// Print the Background.
		$pdf->Image( $img_file, '0', '0', $pageW, $pageH, '', '', '', false, 300, '', false, false, 0, false, false, false, false, array() );
		// END verify.
	}

	if( $data != '' ) {

		// Print BG image.
		$pdf->setPrintHeader( false );

		if( empty( $bMargin ) ) {
			// Get the current page break margin.
			$bMargin = $pdf->getBreakMargin();
		}

		if( ! $auto_page_break ) {
			// Get current auto-page-break mode.
			$auto_page_break = $pdf->getAutoPageBreak();

			// Disable auto-page-break.
			$pdf->SetAutoPageBreak( false, 0 );
		}

		$margins = $pdf->getMargins();
		$margin_top = $margins[ 'top' ];
		$margin_left = $margins[ 'left' ];

		$pdf->SetMargins( $margins[ 'left' ], $margins[ 'top' ], -3, false );

		// Get width and height of page for dynamic adjustments
		$pageH = $pdf->getPageHeight();
		$pageW = $pdf->getPageWidth();

		// Alignment LTR or RTL
		if( $elc_qrcode_options_meta[ 'align' ] == 'right' ) {
			$x = $pageW - $size - $x;
		} elseif( $elc_qrcode_options_meta[ 'align' ] == 'center' ) {
			$x = ( $pageW - $size ) / 2 + $x;
		}

		if( $elc_qrcode_options_meta[ 'position' ] == 'bottom' ) {
			$y = $pageH - $size - $margins[ 'bottom' ] - $y;
		} elseif( $elc_qrcode_options_meta[ 'position' ] == 'middle' ) {
			$y = ( $pageH - $size - $margins[ 'bottom' ] ) / 2 - $y;
		}

		$pdf->write2DBarcode( $data, 'QRCODE,' . $ecl, $x, $y, $size, $size, $style, 'N' );
	}

	// Link.
	if( $link ) {
		$pdf->Link( $x, $y, $size, $size, $data, $spaces = 0 );
	}

	if( $auto_page_break ) {
		// BEGIN verify cont.
		// restore auto-page-break status.
		$pdf->SetAutoPageBreak( $auto_page_break, $bMargin );

		// Set the starting point for the page content.
		$pdf->setPageMark();
		// END verify cont.
	}

	$pdf->SetMargins( $margins[ 'left' ], $margins[ 'top' ], $margins[ 'right' ], false );

	// Print certificate HTML.
	$pdf->writeHTMLCell( 0, 0, $margin_left, $margin_top, $elc_certificate_id_content, 0, 1, 0, true, '', true );

	// Disable printing featured image after it was printed already.
	if( function_exists( 'learndash_get_thumb_path' ) ) {
		remove_post_type_support( 'sfwd-certificates', 'thumbnail' );
	} elseif( class_exists( '\uncanny_pro_toolkit\Tcpdf_Certificate_Code' ) ) {
		/**
		 * Filter out get_post_metadata for '_thumbnail_id'.
		 * Could use remove_post_type_support() if Tcpdf_Certificate_Code::learndash_get_thumb_path() would implement
		 * post_type_supports() the same way as LD learndash_get_thumb_path()
		 */
		add_filter( 'get_post_metadata', 'elc_certificate_id_get_post_metadata', 10, 5 );
	}
}

add_action( 'learndash_certification_after', 'elc_certificate_id_qrcode', 10, 2 );

/**
 * Part of Uncanny fix.
 * Output empty string for get_post_metadata().
 * used in: \uncanny_pro_toolkit\Tcpdf_Certificate_Code::learndash_get_thumb_path().
 *
 * @param $value
 * @param $object_id
 * @param $meta_key
 * @param $single
 * @param $meta_type
 *
 * @return string
 */
function elc_certificate_id_get_post_metadata( $value, $object_id, $meta_key, $single, $meta_type ) {
	global $elc_certificate_id_type_course;
	global $elc_certificate_id_type_quiz;
	if( $elc_certificate_id_type_course == true && $meta_key == '_thumbnail_id' ) {
		return '';
	} elseif( $elc_certificate_id_type_quiz == true && $meta_key == '_thumbnail_id' ) {
		return '';
	} else {
		return $value;
	}
}
