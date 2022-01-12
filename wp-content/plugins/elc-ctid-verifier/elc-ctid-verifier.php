<?php
/**
 * Plugin Name: Certificate Verifier for LearnDash
 * Plugin URI: http://elearningcomplete.com
 * Description: Provides a shortcode that renders a form for certificate verification.
 * Version: 1.01.09
 * Store ItemID: 12522
 * Author: E|Learning Complete
 * Author URI: http://www.elearningcomplete.com
 * Text Domain: elc-ctid-verifier
 * Domain Path: /languages
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
 * Add scripts or before the closing body tag on the front end.
 */
add_action( 'wp_footer', 'elc_ssc_footer' );

/**
 * wp_footer callback function.
 */
function elc_ssc_footer() {

	$myajaxurl = get_site_url();
	$myajaxurl .= '/wp-admin/admin-ajax.php';
	?>
	<script>

		jQuery(document).ready(function ($) {
			jQuery("tr:odd").addClass("odd");
			var animation = jQuery('#loading-animation-search');
			animation.hide();
		});

		jQuery('input#search_by_id').keypress(function(e) {
			if(e.which == 13) {
				e.preventDefault();
				elcSearchByID();
			}
		});

		function elcSearchByID() {
			var animation = jQuery('#loading-animation-search');
			var certificate_id = jQuery('#search_by_id').val();
			var submission = jQuery('#xyq').val();
			animation.show();

			jQuery.ajax({
				url: '<?php echo $myajaxurl; ?>',
				type: 'GET',
				dataType: 'json',
				data: {
					action: 'elc_ssc_catch_search_by_id',
					security: '<?php echo wp_create_nonce( "elc" ); ?>',
					submission: submission,
					certificate_id: certificate_id
				},

				success: function (response) {
					jQuery('#search-table').html(response.data);
					animation.hide();
				},

				error: function (error) {
					animation.hide();
				}
			});
		}
	</script>
	<?php
}

/**
 * Callback function.
 *
 * @return string|void    HTML for search result
 */
function elc_ssc_catch_search_by_id() {

	if( ! $_REQUEST[ 'certificate_id' ] ) {
		if( ! check_ajax_referer( 'elc', 'security' ) ) {
			wp_send_json_error( 'Invalid Nonce' );
		}
	}

	if( ! empty( $_GET[ 'submission' ] ) ) {
		wp_send_json_error( 'No Bots Allowed!' );
	}

	if( isset( $_GET[ 'certificate_id' ] ) ) {
		$certificate_id = sanitize_text_field( $_GET[ 'certificate_id' ] );

		// Although we enforce prefix to not to have special characters, this rule may be relazed in the future.
		// There fore we reverse array so we can get user_id, course/quiz id, timestamp, and prefix.
		$certificate_id_parts = array_reverse( explode( '-', $certificate_id ) );

		$user_id = $certificate_id_parts[ 0 ];
		$course_id = $certificate_id_parts[ 1 ];
		$timestamp = $certificate_id_parts[ 2 ];

		$certificate_meta_key = 'elc_certificate_ids';
		$saved_certificates = get_user_meta( $user_id, $certificate_meta_key, true );

		// Search in $saved_certificates for $certificate_full_id.
		$found = array_filter( $saved_certificates, function ( $ar ) use ( $course_id, $certificate_id, $saved_certificates ) {
			if( $ar[ 'cid' ] === $certificate_id ) {
				return $ar;
			}
		} );

		$request_html = '<table id="elc_search-table">';
		if( ! empty( $found ) ) {
			//get user data
			$user_info = get_userdata( $user_id );
			$first_name = $user_info->first_name;
			$last_name = $user_info->last_name;
			$course_title = get_the_title( $course_id );

			$course_completion_date = empty( $timestamp ) ? "" : gmdate( "Y-m-d", $timestamp );

			$request_html .= '<thead><tr style="vertical-align: baseline;">' .
				'<th>' . esc_html__( 'First Name', 'elc-ctid-verifier' ) . '</th><th>' . esc_html__( 'Last Name', 'elc-ctid-verifier' ) . '</th>' .
				'<th>' . esc_html__( 'Course or Quiz Title', 'elc-ctid-verifier' ) . '</th>' .
				'<th>' . esc_html__( 'Completion Date', 'elc-ctid-verifier' ) .
				'<div style="font-style:italic;font-size:0.8rem;font-weight:normal">(' .
					esc_html__( 'yyyy-mm-dd', 'elc-ctid-verifier' ) . ')</div>' .
				'</th>' .
				'</tr>' .
				'</thead>';
			$request_html .= "<tbody><tr><td>$first_name</td><td>$last_name</td><td>$course_title</td>
                <td>$course_completion_date</td></tr></tbody>";
		} else {
			$request_html .= '<tbody>';
			$request_html .= '<tr>' .
				'<td colspan=3>' . esc_html__( 'No Certificates Found', 'elc-ctid-verifier' ) . '</td>' .
				'</tr>' .
				'</tbody>';
		}
		$request_html .= '</table>';

		if( isset( $_REQUEST[ 'security' ] ) ) {
			wp_send_json_success( $request_html );
		} else {
			return $request_html;
		}
	}
	return;
}

add_action( 'wp_ajax_elc_ssc_catch_search_by_id', 'elc_ssc_catch_search_by_id' );
add_action( 'wp_ajax_nopriv_elc_ssc_catch_search_by_id', 'elc_ssc_catch_search_by_id' );

/**
 * Shortcode callback function.
 *
 * @return string   Search form HTML
 */
function elc_ssc_front_search() {
	$search_html = '<div class="certificate-tracker">';
	if( ! isset( $_REQUEST[ 'certificate_id' ] ) ) {
		$search_html .= '<form id="search_form">';
	}
	$search_html .= '<div class="meta-row">';
	$search_html .= '<div id="search-certificates" class="meta-td">';
	$search_html .= '<input name="search_by_id" id="search_by_id" maxlength="30" size="25" ';
	if( isset( $_REQUEST[ 'certificate_id' ] ) ) {
		$search_html .= 'value="' . $_REQUEST[ 'certificate_id' ] . '" disabled="disabled"';
	}
	$search_html .= '/>';
	if( ! isset( $_REQUEST[ 'certificate_id' ] ) ) {
		$search_html .= '<input type="hidden" id="xyq" value="" />';
		$search_html .= '<input type="button" id="search-btn" value="' .
			esc_attr__( 'Search', 'elc-ctid-verifier' ) .
			'" class="button-primary" onclick="elcSearchByID();" />';
		$image = esc_url( admin_url( 'images/loading.gif' ) );
		$search_html .= '<img src=' . $image . ' id="loading-animation-search" style="display: none;margin-left: 1rem;">';
	} else {
		$search_html .= '<a href="' . get_permalink() . '" class="button" class="button"  style="white-space: nowrap;">' .
			esc_html__( 'Search for other certificate ID', 'elc-ctid-verifier' ) .
			'</a>';
	}
	$search_html .= '</div></div>';
	if( ! isset( $_REQUEST[ 'certificate_id' ] ) ) {
		$search_html .= '</form>';
	}

	$search_html .= '<p id="search-table" ></p>';
	$search_html .= '</div>';
	if( isset( $_REQUEST[ 'certificate_id' ] ) ) {
		$search_html .= elc_ssc_catch_search_by_id();
	}
	return $search_html;
}

/**
 * Add a new shortcode.
 */
add_shortcode( 'elc_ssc_front_search', 'elc_ssc_front_search' );

/**
 * Allow Translations to be loaded.
 */
add_action( 'init', 'elc_ssc_text_domain' );

/**
 * Load plugin text domain.
 */
function elc_ssc_text_domain() {
	load_plugin_textdomain( 'elc-ctid-verifier', false, basename( __FILE__ ) . '/languages/' );
}
