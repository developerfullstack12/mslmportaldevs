<?php
/**
 * Plugin Name: H5P for LearnDash
 * Plugin URI: http://elearningcomplete.com
 * Description: H5P Interactions Control Progress in LearnDash Without an LRS!
 * Version: 2.0.5
 * Store ItemID: 5031
 * Author: E|Learning Complete
 * Author URI: http://elearningcomplete.com
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full path to the plugin root directory.
 */
define( 'ELC_H5PLD_ROOT_PATH', plugin_dir_path( __FILE__ ) );

/**
 * URL for plugin.
 */
define( 'ELC_H5PLD_ROOT_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin base name (plugin_dir/plugin_file_name.extension).
 */
define( 'ELC_H5PLD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Main plugin file name with extension.
 */
define( 'ELC_H5PLD_FILE_NAME', pathinfo( __FILE__ )[ 'basename' ] );

/**
 * Plugin version.
 * Retrieve 'Version' from this file PHPDoc.
 */
define( 'ELC_H5PLD_PLUGIN_VERSION',
get_file_data( ELC_H5PLD_ROOT_PATH . ELC_H5PLD_FILE_NAME, array( 'Version' => 'Version' ) )[ 'Version' ]
);

require_once ELC_H5PLD_ROOT_PATH . 'includes/elc-h5p-ajax.php';
require_once ELC_H5PLD_ROOT_PATH . 'includes/white-list.php';
require_once ELC_H5PLD_ROOT_PATH . 'admin/elc-h5p-admin.php';

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
 * Run update script after upgrader did finish.
 */
add_action( 'upgrader_process_complete', function () {
	ELC_SL_Plugin_Updater::runUpdateScript( plugin_basename( __FILE__ ) );
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
 * Helper function to prepare params and run wp_enqueue_script().
 * Sets the version to the file date to force reload if the file was changed.
 * This is handy when developing the file(s).
 *
 * @param string $handle  Name of the script. Should be unique.
 * @param string $src     Path of the script relative to the plugin directory.
 *                        Default empty.
 */
function _elc_h5pld_enqueue_assets( $handle, $src = '' ) {
	$_ver = date( "ymd-Gis", filemtime( ELC_H5PLD_ROOT_PATH . $src ) );
	if( pathinfo( $src, PATHINFO_EXTENSION ) == 'js' ) {
		wp_enqueue_script( $handle, ELC_H5PLD_ROOT_URL . $src, array(), $_ver, true );
	} elseif( pathinfo( $src, PATHINFO_EXTENSION ) == 'css' ) {
		wp_enqueue_style( $handle, ELC_H5PLD_ROOT_URL . $src, array(), $_ver );
	} else {
		// Do nothing
	}
}

/**
 * Load scripts and stylesheets.
 */
function elc_h5pld_enqueue_scripts() {
	$post_types = array(
		'sfwd-courses',
		'sfwd-lessons',
		'sfwd-topic',
		'sfwd-quiz',
		'sfwd-question',
	);
	if( is_singular( $post_types ) ) {
		wp_enqueue_script( 'jquery' );
		_elc_h5pld_enqueue_assets( 'elc-h5p-ld-js', 'assets/js/' . 'elc-h5p-ld.js' );
		_elc_h5pld_enqueue_assets( 'elc-h5p-ld-css', 'assets/css/' . 'elc-h5p-ld.css' );
	}
	// Get options
	$options = get_option( 'elc_h5p_options' );
	// Pass variables to JavaScript.
	wp_localize_script( 'elc-h5p-ld-js', 'elcAJAX', array(
		'url'            => admin_url( 'admin-ajax.php' ),
		'nonce'          => wp_create_nonce( 'elc_insert_data' ),
		'elc_debug'      => $options[ 'elc_h5p_debug' ],
		'question_label' => $options[ 'question_label' ],
	) );
}

/**
 * Register action to load scripts.
 */
add_action( 'wp_enqueue_scripts', 'elc_h5pld_enqueue_scripts' );

/**
 * Alter styles for H5P content.
 * See: \H5P_Plugin::alter_assets
 *
 * @param array  &$styles    List of stylesheets to be included.
 * @param array  $libraries  The list of libraries that has the styles.
 * @param string $embed_type Possible values are: div, iframe, external, editor.
 */
function elc_h5p_alter_library_styles( &$styles, $libraries, $embed_type ) {
	// H5P.InteractiveVideo CSS fix for enscreen to have vertical scroll if needed.
	if( isset( $libraries[ "H5P.InteractiveVideo" ] ) ) {
		$_src = 'assets/css/elc-iv-endscreen.css';
		$_ver = date( "ymd-Gis", filemtime( ELC_H5PLD_ROOT_PATH . $_src ) );

		// Path must be relative to wp-content/uploads/h5p or absolute.
		$styles[] = (object)array(
			'path' => ELC_H5PLD_ROOT_URL . $_src,
			'ver'  => $_ver,
		);
	}
}

/**
 * Register action to alter styles for the H5P content.
 */
add_action( 'h5p_alter_library_styles', 'elc_h5p_alter_library_styles', 10, 3 );

/**
 * Default plugin options.
 *
 * @return array
 */
function elc_h5p_default_options() {
	$default_options = array();

	// @TODO: Translate
	$default_options[ 'question_label' ] = 'H5P content points';
	$default_options[ 'pcpl_msg' ] = 'Previously completed message.';
	$default_options[ 'mcpl_msg' ] = 'Must complete message.';
	$default_options[ 'succ_msg' ] = 'Success message.';
	$default_options[ 'fail_msg' ] = 'Failure message.';
	$default_options[ 'elc_h5p_debug' ] = '0';

	return $default_options;
}

/**
 * Get plugin options.
 * Set defalult values for the options and merge with values set in plugin settings page.
 *
 * @return array
 */
function elc_h5p_get_options() {
	$options = get_option( 'elc_h5p_options', array() );

	$default_options = elc_h5p_default_options();

	$merged_options = wp_parse_args( $options, $default_options );

	$compare_options = array_diff_key( $default_options, $options );
	if( empty( $options ) || ! empty( $compare_options ) ) {
		update_option( 'elc_h5p_options', $merged_options );
	}

	return $merged_options;
}

/**
 *  Delete legacy options and get new options.
 */
function elc_h5p_set_default_options_array() {
	// Clear legacy options if any.
	delete_option( 'elc_h5p_options' );
	elc_h5p_get_options();
}

/**
 * Execute upon plugin activation.
 */
function elc_h5p_activation() {
	elc_h5p_set_default_options_array();
}

/**
 * Register activation hook.
 */
register_activation_hook( __FILE__, 'elc_h5p_activation' );

/**
 * Detect LearnDash post types and delegate for processing.
 */
function elc_h5p_quiz_get_ld_custom_post_type() {
	// When the lesson or later the topic load lets see if an H5P is required before "Mark Complete" button is enabled
	// if it is then we check to see if the user has passed it before it is enabled.

	if( is_singular( 'sfwd-courses' ) ) {
		elc_h5p_process_post_types( 'course' );
	} elseif( is_singular( 'sfwd-lessons' ) ) {
		elc_h5p_process_post_types( 'lesson' );
	} elseif( is_singular( 'sfwd-topic' ) ) {
		//TODO: $topic_list = learndash_get_topic_list();
		elc_h5p_process_post_types( 'topic' );
	} elseif( is_singular( 'sfwd-quiz' ) ) {
		elc_h5p_process_post_types( 'quiz' );
	} elseif( is_singular( 'sfwd-question' ) ) {
		elc_h5p_process_post_types( 'question' );
	} else {
		// Do nothing.
	}
}

/**
 * Register action.
 */
add_action( 'wp_footer', 'elc_h5p_quiz_get_ld_custom_post_type' );

/**
 * Helper function.
 * Load the H5P content and return content settings.
 *
 * @param $content_id
 * @return array|null
 */
function elc_get_h5p_content_settings( $content_id ) {
	$H5PP = H5P_Plugin::get_instance();
	$content = $H5PP->get_content( $content_id );
	if( is_string( $content ) ) {
		// $H5PP->get_content() error: 'missing H5P identifier' or 'no H5P content with id'.
		return null;
	} else {
		return $H5PP->get_content_settings( $content );
	}
}

/**
 * Helper function.
 * Return library name from H5P content settings.
 *
 * @param $settings
 * @return mixed
 */
function elc_get_h5p_library_name( $settings ) {
	$lib_name = explode( ' ', substr( $settings[ 'library' ], 4 ) )[ 0 ];
	// Not using now but may need to.
	//$lib_ver = explode( ' ', substr( $settings['library'], 4 ) )[1];
	return $lib_name;
}

/**
 * Helper function.
 * Return true if the elc_h5p shortcode has id parameter that matches $content_id
 * and ignore parameter.
 *
 * @param array $args       shortcode args just for elc_h5p
 * @param int   $content_id H5P content ID
 * @return bool
 */
function elc_h5p_ignore( $args, $content_id ) {
	$ignore = false;
	if( isset( $args ) ) {
		foreach( $args as $k => $v ) {
			if( isset( $v[ 'id' ] ) && (int)$v[ 'id' ] === (int)$content_id ) {
				if( isset( $v[ 'ignore' ] ) ) $ignore = empty( $v[ 'ignore' ] ) || filter_var( $v[ 'ignore' ], FILTER_VALIDATE_BOOLEAN );
			}
			if( $ignore ) break;
		}
	}

	return $ignore;
}

/**
 * Upon loading page enable/disable 'Mark complete' and 'Start quiz' buttons.
 * Verify if user passed H5P content by checking value of 'elc_h5p_save_success_' meta_key for
 * every instance of H5P shortcode.
 * If any user did fail one or more - disable buttons.
 *
 * Print on the page JS script to disable the buttons.
 *
 * @param string $post_type
 */
function elc_h5p_process_post_types( $post_type ) {
	global $wp_query;
//	global $elc_h5p_updated_questions;
//	$elc_h5p_updated_questions = array();

	$post_id = $wp_query->post->ID;

	// Check if post has at least one H5P shortcode.
	$post_content = get_post_field( 'post_content', $post_id, 'raw' );
	$shortcode_args[ 'h5p' ] = elc_get_shortcode_args( $post_content, array( 'h5p' ) );

	// Check if post has elc_h5p shortcode
	$shortcode_args[ 'elc_h5p' ] = elc_get_shortcode_args( $post_content, array( 'elc_h5p' ) );

	// If there is at least one H5P shortcode.
	if( isset( $shortcode_args[ 'h5p' ][ 0 ][ 'id' ] ) ) {
		$pass = true;
		global $current_user;
		$user_id = $current_user->ID;

		foreach( $shortcode_args[ 'h5p' ] as $key => $value ) {
			$content_id = $value[ 'id' ];
			// If there is elc_h5p shortcode with matching id and it has ignore param do ignore h5p content.
			$ignore = elc_h5p_ignore( $shortcode_args[ 'elc_h5p' ], $content_id );

			if( ! $ignore ) {
				$settings = elc_get_h5p_content_settings( $content_id );
				if( ! is_null( $settings ) ) {
					$lib_name = elc_get_h5p_library_name( $settings );
					// Chek if the library is on the white_list.
					if( in_array( $lib_name, ELC_H5PLD_WHITE_LIST ) ) {
						// We process the H5P shortcode, otherwise we do nothing.
						$elc_h5p_save_success_meta = (bool)get_user_meta( $user_id, 'elc_h5p_save_success_' . $content_id, true );
						$pass = $pass && $elc_h5p_save_success_meta;
					}
				}
			}
			if( ! $pass ) break;
		}

		if( ! $pass ) {
			if( $post_type !== 'quiz' ) {
				?>
				<script>
					var learndash_mark_complete_button = jQuery('.learndash_mark_complete_button');
					if (learndash_mark_complete_button.length > 0 && !learndash_mark_complete_button.prop('disabled')) {
						learndash_mark_complete_button.prop('disabled', true);
					}
					var start_quiz_button = jQuery('.wpProQuiz_button[name=startQuiz]');
					// There are more than one elements with 'wpProQuiz_button' class, we have to select by name attribute.
					if (start_quiz_button.length > 0 && !start_quiz_button.prop('disabled')) {
						start_quiz_button.prop('disabled', true);
					}
				</script>
				<?php
			} else {
				?>
				<script>
					var start_quiz_button = jQuery('.wpProQuiz_button[name=startQuiz]');
					// There are more than one elements with 'wpProQuiz_button' class, we have to select by name attribute.
					if (start_quiz_button.length > 0 && !start_quiz_button.prop('disabled')) {
						start_quiz_button.prop('disabled', true);
					}
				</script>
				<?php
			}
		}
	}

	?>
	<?php
}

/**
 * Helper function to get from post content the shortcode by it's tag name
 * and return the array of shortcode arguments.
 *
 * @param  string       $content
 * @param  array|string $tagname
 * @return array|void
 */
function elc_get_shortcode_args( $content, $tagname ) {
	$pattern = is_array( $tagname ) ? get_shortcode_regex( $tagname ) : get_shortcode_regex( array( $tagname ) );
	if( preg_match_all( '/' . $pattern . '/s', $content, $matches ) ) {
		$keys = array();
		$shortcode_args = array();
		$i = 0;
		$output = array();
		foreach( $matches[ 0 ] as $key => $value ) {
			// $matches[3] return the shortcode attribute(s) as string.
			// Replace space with '&' for parse_str() function.

			// Do not parse shortcodes with double [[]]
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
 * Helper function.
 * Find all instances of H5P shortcode and if for any of them the 'id' parameter equals to
 * $content_id return true.
 *
 * @param string $post_id    Post id of which content to search for H5P shortcodes.
 * @param string $content_id H5P content id to compare with.
 * @return bool
 */
function elc_is_h5p_id_match( $post_id, $content_id ) {
	if( empty( $content_id ) ) return false;
	$post_content = get_post_field( 'post_content', $post_id, 'raw' );
	$shortcode_args[ 'h5p' ] = elc_get_shortcode_args( $post_content, array( 'h5p' ) );
	if( isset( $shortcode_args[ 'h5p' ] ) ) {
		$h5p_id_match = false;
		// Set $h5p_id_match = true if any of H5P shortcode has 'id' parameter with
		// value that matches elc_h5p 'id' parameter value.
		foreach( $shortcode_args[ 'h5p' ] as $key => $value ) {
			$h5p_id_match = (int)$value[ 'id' ] === (int)$content_id;
			if( $h5p_id_match ) break;
		}

		return $h5p_id_match;
	}
}

/**
 * Helper function.
 * Get quiz questions by quiz post ID.
 *
 * @param $post_id
 * @return array
 */
function elc_h5p_get_quiz_questions_by_post_id( $post_id ) {
	$ld_settings = learndash_get_setting( $post_id );
	$quiz_id = $ld_settings[ 'quiz_pro' ];
	$quizMapper = new WpProQuiz_Model_QuizMapper();
	$questionMapper = new WpProQuiz_Model_QuestionMapper();
	$quiz = $quizMapper->fetch( $quiz_id );

	return $questionMapper->fetchAll( $quiz );
}

/**
 * Render elc_h5p shortcode.
 *
 * @param array $atts
 * @return string   HTML string.
 */
function elc_h5p( $atts ) {

	// Execute elc_h5p shortcode only in frontend.
	if( is_admin() ) return;

	$content_id = isset( $atts[ 'id' ] ) ? $atts[ 'id' ] : '';

	$msg_txt = '';
	$msg_classes = ' class="elc-h5p-response';

	$options = get_option( 'elc_h5p_options' );

	if( ! empty( $content_id ) ) {
		if( isset( $atts[ 'ignore' ] ) ) {
			$ignore = filter_var( $atts[ 'ignore' ], FILTER_VALIDATE_BOOLEAN );
		} else {
			$ignore = in_array( 'ignore', $atts );
		}

		global $current_user;
		$user_id = $current_user->ID;

		global $wp_query;
		$post_id = $wp_query->post->ID;

		// Check if post does have an H5P shortcode with id parameter that
		// matches 'id' parameter passed in processed elc_h5p shortcode.
		$post_ids = array( $post_id );
		if( is_singular( 'sfwd-quiz' ) ) {
			// Add post ids to $post_ids

			$questions = elc_h5p_get_quiz_questions_by_post_id( $post_id );
			foreach( $questions as $q ) {
				$post_ids[] = $q->getQuestionPostId();
			}
		}
		foreach( $post_ids as $pid ) {
			if( elc_is_h5p_id_match( $pid, $content_id ) ) {

				// If library is not on the white_list we output
				// This H5P content type has NO xAPI implemented.
				$settings = elc_get_h5p_content_settings( $content_id );
				if( ! is_null( $settings ) ) {
					$lib_name = elc_get_h5p_library_name( $settings );

					$msg_classes .= ' h5pid-' . $content_id;
					// Get options
					if( in_array( $lib_name, ELC_H5PLD_WHITE_LIST ) && ! $ignore ) {
						// Get usermeta
						$score_success = get_user_meta( $user_id, 'elc_h5p_save_success_' . $content_id, true );

						// Include the h5pid-[cid] class for JS being able to find correct element.
						// There may be more than one elements with 'elc-h5p-response' class.
						if( $score_success >= 1 ) {
							$msg_key = 'pcpl_msg';
						} else {
							$msg_key = 'mcpl_msg';
						}
						$msg_txt .= $options[ $msg_key ];
						$msg_classes .= ' ' . $msg_key;

						return '<p' . $msg_classes . '">' . $msg_txt . '</p>';
					} elseif( $ignore && $options[ 'elc_h5p_debug' ] ) {
						$msg_txt .= 'DEBUG: Ignored';
						$msg_classes .= ' ' . 'elc_ignore';

						return '<p' . $msg_classes . '">' . $msg_txt . '</p>';
					} elseif( $options[ 'elc_h5p_debug' ] ) {
						$msg_txt .= 'DEBUG: Not on the white-list';
						$msg_classes .= ' ' . 'no_xapi';

						return '<p' . $msg_classes . '">' . $msg_txt . '</p>';
					} else {
						// Do nothing.
					}
				}
			}
		}
	} elseif( $options[ 'elc_h5p_debug' ] ) {
		$msg_txt .= '[elc_h5p <strong>id</strong> parameter is required]';
		$msg_classes .= ' no_id';

		return '<p' . $msg_classes . '">' . $msg_txt . '</p>';
	}
}

/**
 * Register elc_h5p shortcode.
 */
//add_shortcode( 'elc_h5p', 'elc_h5p' );

add_action( 'init', 'elc_h5p_init' );

function elc_h5p_init() {
	add_shortcode( 'elc_h5p', 'elc_h5p' );

}

/**
 * Delete meta_keys added by plugin in 'wp_usermeta' - for the user.
 * Delete H5P results and user meta - for the user.
 * Invoked by hook in: wp-content/plugins/sfwd-lms/includes/ld-users.php,
 * when editing user and 'Permanently Delete Course Data' is checked ON.
 *
 * @param int $user_id
 */
function elc_learndash_delete_user_data( $user_id ) {
	global $wpdb;

	// Check user permissions.
	if( ! current_user_can( 'edit_users' ) ) {
		return;
	}

	$user_id = intval( $user_id );

	if( ! empty( $user_id ) ) {
		$user = get_user_by( 'id', $user_id );

		$metaKeys = array(
			'elc_h5p_save_score_scaled_',
			'elc_h5p_save_score_raw_',
			'elc_h5p_save_success_',
		);

		// Delete all H5P results and contents_user_meta for the user.
		// This is only for H5P content associated with LearnDash.
		$wpdb->query( 'SELECT meta_key FROM ' . $wpdb->usermeta . " WHERE meta_key LIKE '" . 'elc_h5p_save_success_' . "%' AND user_id = " . $user->ID );
		$wpdb_select_result = $wpdb->last_result;
		foreach( $wpdb_select_result as $key => $value ) {
			// Remove user scores/results.
			$wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'h5p_results',
				array( 'user_id' => $user->ID, 'content_id' => substr( $value->meta_key, 21 ) ),
				array( '%d', '%d' )
			);
			// Remove user/usage data.
			$wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'h5p_contents_user_data',
				array( 'user_id' => $user->ID, 'content_id' => substr( $value->meta_key, 21 ) ), array( '%d', '%d' )
			);
		}
		foreach( $metaKeys as $meta_key ) {
			$wpdb->query( 'DELETE FROM ' . $wpdb->usermeta . " WHERE meta_key LIKE '" . $meta_key . "%' AND user_id = " . $user->ID );
		}
		// Alternatively we could delete all H5P results and contents_user_meta for the user.
		//$plugin_admin = H5P_Plugin_Admin::get_instance();
		//$plugin_admin->deleted_user($user_id);
	}
}

/**
 * Register action when editing user profile and selecting 'permanently delete user's LearnDash course data'.
 */
add_action( 'learndash_delete_user_data', 'elc_learndash_delete_user_data' );

/**
 * Callback function for 'learndash_quiz_submitted' action.
 * If option '_elc_h5p_updated_questions' is NOT empty.
 * If calculated $$quiz_global_points_delta !== 0
 * Update user_meta
 *
 * @param $quizdata
 */
function elc_learndash_quiz_submitted( $quizdata ) {
	// The $elc_h5p_updated_questions should be array of question id's with possible points before and after save.
	// We need to accomodate for these questions in user statistics '_sfwd_quizzes'.
	// Otherwise the pass for the quiz may be fail and certificate will not be issued.

	$elc_h5p_updated_questions = get_option( '_elc_h5p_updated_questions' );

	if( empty( $elc_h5p_updated_questions ) ) {
		return; // Do nothing.
	}

	// If any questions were updated than we have to make sure they are in $_POST[ 'results' ].
	$quiz_global_points_delta = 0;

	// The 'subset of questions' can be set, we have to get the questions from $_POST['results']
	foreach( $_POST[ 'results' ] as $pid => $question ) {
		// If $pid is in $elc_h5p_updated_questions than proceed
		if( in_array( $pid, array_keys( $elc_h5p_updated_questions ) ) ) {
			$quiz_global_points_delta += $elc_h5p_updated_questions[ $pid ][ 'quiz_global_points_delta' ];
			unset( $elc_h5p_updated_questions[ $pid ] );
		}
	}
	update_option( '_elc_h5p_updated_questions', $elc_h5p_updated_questions );

	// If $quiz_global_points_delta !== 0 than we have to update user_meta for the quiz.
	if( $quiz_global_points_delta !== 0 ) {
		// Replace in user_meta '_sfwd_quizzes'
		$total_points = $quizdata[ 'total_points' ] + $quiz_global_points_delta;

		// The user meta has been updated, but the 'total_points' and 'percentage' and 'pass' need to be updated.
		// @SEE: wp-content/plugins/sfwd-lms/includes/quiz/ld-quiz-pro.php:999
		$uid = get_current_user_id();
		$user_quizzes = get_user_meta( $uid, '_sfwd-quizzes', true );
		// Find last quiz and fix it.
		$key = array_search( $quizdata[ 'time' ], array_column( $user_quizzes, 'time' ) );
		$points = $user_quizzes[ $key ][ 'points' ];
		$user_quizzes[ $key ][ 'total_points' ] = $total_points;
		$percentage = round( $points * 100 / $total_points, 2 );
		$user_quizzes[ $key ][ 'percentage' ] = $percentage;
		$quiz_post_id = $user_quizzes[ $key ][ 'quiz' ];
		$quiz_post_settings = learndash_get_setting( $quiz_post_id );
		if( ! is_array( $quiz_post_settings ) ) {
			$quiz_post_settings = array();
		}
		if( ! isset( $quiz_post_settings[ 'passingpercentage' ] ) ) {
			$quiz_post_settings[ 'passingpercentage' ] = 0;
		}
		$passingpercentage = absint( $quiz_post_settings[ 'passingpercentage' ] );
		$pass = ( $percentage >= $passingpercentage ) ? 1 : 0;
		$user_quizzes[ $key ][ 'pass' ] = $pass;
		update_user_meta( $uid, '_sfwd-quizzes', $user_quizzes );
	}
}

/**
 * Register action for 'learndash_quiz_submitted'.
 * 'wp_pro_quiz_completed_quiz'
 */
add_action( 'learndash_quiz_submitted', 'elc_learndash_quiz_submitted' );
