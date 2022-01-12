<?php
/**
 * Created by PhpStorm.
 * User: michaeldajewski
 * Date: 10/24/20
 * Time: 18:15
 *
 * Limitations: The qrcode, will not be rendered in certificate HTML preview
 * Add metabox
 * https://developer.wordpress.org/reference/functions/add_meta_box/
 */

/**
 * Callback function for 'add_meta_boxes' action hook.
 * Registers QR-Code options metabox.
 * Fires on `add_meta_boxes` hook.
 *
 * @param WP_Post $post WP_Post object.
 */
function elc_certificate_id_qrcode_add_meta_box( $post ) {
	add_meta_box(
		'elc_certificate_id_qrcode_options',
		esc_html__( 'ELC QR-Code options', 'elc-ctid-tracker' ),
		'elc_certificate_id_qrcode_options_metabox',
		'sfwd-certificates',
		'advanced',
		'high'
	);
}

add_action( 'add_meta_boxes', 'elc_certificate_id_qrcode_add_meta_box' );

/**
 * Callback function for 'default_post_metadata' filter.
 *
 * @param $value
 * @param $object_id
 * @param $meta_key
 * @param $single
 * @param $meta_type
 * @return array
 */
function elc_certificate_id_qrcode_default_options( $value, $object_id, $meta_key, $single, $meta_type ) {
	if( $meta_key === 'elc_qrcode_options' ) {
		$value = array(
			'ecl'      => 'L',
			'data'     => '',
			'size'     => '20',
			'padding'  => '0',
			'x'        => '6',
			'y'        => '6',
			'align'    => 'left',
			'position' => 'top',
			'border'   => '0',
			'fgcolor'  => '#000',
			'bgcolor'  => false,
			'link'     => '0',
		);
	}

	return $value;
}

add_filter( 'default_post_metadata', 'elc_certificate_id_qrcode_default_options', 10, 5 );

/**
 * Callback function for metabox.
 * @SEE: elc_certificate_id_qrcode_add_meta_box()
 *
 * @param $certificate
 */
function elc_certificate_id_qrcode_options_metabox( $certificate ) {

	$elc_qrcode_options_meta = get_post_meta( $certificate->ID, 'elc_qrcode_options', true );

	if( ! is_array( $elc_qrcode_options_meta ) ) {
		if( ! empty( $elc_qrcode_options_meta ) ) {
			$elc_qrcode_options_meta = array( $elc_qrcode_options_meta );
		} else {
			$elc_qrcode_options_meta = array();
		}
	}

	// Set nonce.
	wp_nonce_field( plugin_basename( __FILE__ ), 'elc_certificate_id_qrcode_nonce' );

	$enable = $elc_qrcode_options_meta[ 'enable' ];
//	$enable = 1;

	$link = $elc_qrcode_options_meta[ 'link' ];
	// L : QRcode Low error correction
	// M : QRcode Medium error correction
	// Q : QRcode Better error correction
	// H : QR-CODE Best error correction
	$elc_qrcode_options[ 'ecl' ] = array(
		'L' => esc_html__( 'L (low)', 'elc-ctid-tracker' ),
		'M' => esc_html__( 'M (medium)', 'elc-ctid-tracker' ),
		'Q' => esc_html__( 'Q (better)', 'elc-ctid-tracker' ),
		'H' => esc_html__( 'H (best)', 'elc-ctid-tracker' ),
	);

	$max_padding = $elc_qrcode_options_meta[ 'size' ];

	$elc_qrcode_options[ 'align' ] = array(
		'left'  => esc_html__( 'left', 'elc-ctid-tracker' ),
		'right' => esc_html__( 'right', 'elc-ctid-tracker' ),
	);

	$elc_qrcode_options[ 'position' ] = array(
		'top'    => esc_html__( 'top', 'elc-ctid-tracker' ),
		'bottom' => esc_html__( 'bottom', 'elc-ctid-tracker' ),
	);

	// Get URL for qrcode-a.svg.
	$obj_data_attribute = trailingslashit( plugins_url( '', __FILE__ ) ) . "images/qrcode-a.svg";

	$border = $elc_qrcode_options_meta[ 'border' ];

	// Use temple file.
	ob_start();
	include plugin_dir_path( __FILE__ ) . 'templates/elc-ctid-certificate-edit.tpl.php';
	echo ob_get_clean();
}

/**
 * Saves certificate qrcode option metabox fields.
 * Fires on `save_post` hook.
 *
 * @param int $post_id Current post ID being edited.
 */
function elc_certificate_id_qrcode_save_meta_box( $post_id ) {
	// verify if this is an auto save routine.
	// If it is our form has not been submitted, so we dont want to do anything
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if( ! isset( $_POST[ 'elc_certificate_id_qrcode_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'elc_certificate_id_qrcode_nonce' ], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	if( 'sfwd-certificates' != $_POST[ 'post_type' ] ) {
		return;
	}

	// Check permissions.
	if( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$elc_qrcode_options = array();

	// Sanitize and add to options array.
	//
	if( ( isset( $_POST[ 'elc_qrcode_options' ][ 'ecl' ] ) ) && ( ! empty( $_POST[ 'elc_qrcode_options' ][ 'ecl' ] ) ) ) {
		$elc_qrcode_options[ 'ecl' ] = esc_attr( $_POST[ 'elc_qrcode_options' ][ 'ecl' ] );
	} else {
		$elc_qrcode_options[ 'ecl' ] = 'L';
	}

	$elc_qrcode_options[ 'data' ] = esc_url_raw( $_POST[ 'elc_qrcode_options' ][ 'data' ] );

	// @TODO: Sanitize the resto of fields.
	$elc_qrcode_options[ 'enable' ] = ! empty( $_POST[ 'elc_qrcode_options' ][ 'enable' ] );
	$elc_qrcode_options[ 'size' ] = $_POST[ 'elc_qrcode_options' ][ 'size' ];
	$elc_qrcode_options[ 'padding' ] = $_POST[ 'elc_qrcode_options' ][ 'padding' ];
	$elc_qrcode_options[ 'x' ] = $_POST[ 'elc_qrcode_options' ][ 'x' ];
	$elc_qrcode_options[ 'y' ] = $_POST[ 'elc_qrcode_options' ][ 'y' ];
	$elc_qrcode_options[ 'align' ] = $_POST[ 'elc_qrcode_options' ][ 'align' ];
	$elc_qrcode_options[ 'position' ] = $_POST[ 'elc_qrcode_options' ][ 'position' ];
	$elc_qrcode_options[ 'border' ] = $_POST[ 'elc_qrcode_options' ][ 'border' ];
	$elc_qrcode_options[ 'fgcolor' ] = $_POST[ 'elc_qrcode_options' ][ 'fgcolor' ];
	$elc_qrcode_options[ 'bgcolor' ] = $_POST[ 'elc_qrcode_options' ][ 'bgcolor' ];

	$elc_qrcode_options[ 'link' ] = ! empty( $_POST[ 'elc_qrcode_options' ][ 'link' ] );

	// Update post meta.
	update_post_meta( $post_id, 'elc_qrcode_options', $elc_qrcode_options );
}

add_action( 'save_post', 'elc_certificate_id_qrcode_save_meta_box' );
