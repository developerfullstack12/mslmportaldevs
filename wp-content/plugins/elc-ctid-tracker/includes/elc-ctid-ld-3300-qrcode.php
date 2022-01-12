<?php
/**
 * Created by PhpStorm.
 * User: Michael Dajewski
 * Date: 12/13/20
 * Time: 18:45
 *
 * @TODO: Insert WP hooks if someone wants to change output.
 */

/**
 * Callback function for 'learndash_certification_content_write_cell_before' action hook.
 * @SEE: wp-content/plugins/sfwd-lms/includes/ld-convert-post-pdf.php
 *
 * @param $pdf
 * @param $cert_args
 */
function elc_certificate_id_qrcode( $pdf, $cert_args ) {

	$cert_id = $cert_args[ 'cert_id' ];

	// Get qrcode options from post meta.
	$elc_qrcode_options_meta = get_post_meta( $cert_id, 'elc_qrcode_options', true );

	$enable = $elc_qrcode_options_meta[ 'enable' ];

	if( empty( $enable ) ) return;

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

	// Get the current page break margin.
	$b_margin = $pdf->getBreakMargin();

	// Get current auto-page-break mode.
	$auto_page_break = $pdf->getAutoPageBreak();

	// Disable auto-page-break.
	$pdf->SetAutoPageBreak( false, 0 );

	// Get width and height of page for dynamic adjustments.
	$pageH = $pdf->getPageHeight();
	$pageW = $pdf->getPageWidth();

	// Alignment LTR or RTL.
	if( $elc_qrcode_options_meta[ 'align' ] == 'right' ) {
		$x = $pageW - $size - $x;
	} elseif( $elc_qrcode_options_meta[ 'align' ] == 'center' ) {
		$x = ( $pageW - $size ) / 2 + $x;
	}

	// Get margins.
	$margins = $pdf->getMargins();

	// Set margins.
	$pdf->SetMargins( 0, 0, 0 );

	if( $elc_qrcode_options_meta[ 'position' ] == 'bottom' ) {
		$y = $pageH - $size - $margins[ 'bottom' ] - $y;
	} elseif( $elc_qrcode_options_meta[ 'position' ] == 'middle' ) {
		$y = ( $pageH - $size - $margins[ 'bottom' ] ) / 2 - $y;
	}

	// Print QR-Code.
	$pdf->write2DBarcode( $data, 'QRCODE,' . $ecl, $x, $y, $size, $size, $style, 'N' );

	// Print Link.
	if( $link ) {
		$pdf->Link( $x, $y, $size, $size, $data, $spaces = 0 );
	}

	// Restore margins.
	$pdf->SetMargins( $margins[ 'left' ], $margins[ 'top' ], $margins[ 'right' ] );

	// Restore auto-page-break status.
	$pdf->SetAutoPageBreak( $auto_page_break, $b_margin );

	// Set the starting point for the page content.
	$pdf->setPageMark();

	add_filter( 'learndash_certification_content_write_cell_args',
		function ( $pdf_cell_args, $cert_args, $tcpdf_params, $pdf ) {
			// The upper-left corner of the cell corresponds to the current printer head position.
			// Had we inserted something before, we need to adjust it's position where it belongs.
			//
			$pdf_cell_args[ 'x' ] = $tcpdf_params[ 'margins' ][ 'left' ];
			$pdf_cell_args[ 'y' ] = $tcpdf_params[ 'margins' ][ 'top' ];

			// Draw border around the cell to see it's extents - debugging purpose.
			// $pdf_cell_args['border'] = 1;

			return $pdf_cell_args;

		},
		10, 4 );
}

add_action( 'learndash_certification_content_write_cell_before', 'elc_certificate_id_qrcode', 10, 2 );
