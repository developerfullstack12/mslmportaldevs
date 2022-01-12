<?php
/**
 * @file elc-h5p-admin.php
 * Created by michaeldajewski on 8/12/19.
 */

/**
 * Add 'H5P for LearnDash' item to the Settings admin menu.
 */
function elc_h5p_settings_menu() {
	add_options_page( 'H5P for LearnDash Settings',
		'H5P for LearnDash', 'manage_options',
		'elc_h5p', 'elc_h5p_config_page' );
}

/**
 * Register action to add item to the Settings admin menu.
 */
add_action( 'admin_menu', 'elc_h5p_settings_menu' );

/**
 * Sanitize and update plugin options with values entered in plugin settings page.
 */
function process_elc_h5p_options() {
	// Check user permissions.
	if( ! current_user_can( 'manage_options' ) )
		wp_die( 'Not allowed' );

	// Verify nonce field, created in configuration form is present.
	check_admin_referer( 'elc_h5p' );

	// Get plugin options array.
	$options = elc_h5p_get_options();

	$default_options = elc_h5p_default_options();

	if( isset( $_POST[ 'question_label' ] ) ) {
		$options[ 'question_label' ] = sanitize_text_field( $_POST[ 'question_label' ] );
	}
	if( isset( $_POST[ 'pcpl_msg' ] ) ) {
		$options[ 'pcpl_msg' ] = sanitize_text_field( $_POST[ 'pcpl_msg' ] );
	}
	if( isset( $_POST[ 'mcpl_msg' ] ) ) {
		$options[ 'mcpl_msg' ] = sanitize_text_field( $_POST[ 'mcpl_msg' ] );
	}
	if( isset( $_POST[ 'succ_msg' ] ) ) {
		$options[ 'succ_msg' ] = sanitize_text_field( $_POST[ 'succ_msg' ] );
	}
	if( isset( $_POST[ 'fail_msg' ] ) ) {
		$options[ 'fail_msg' ] = sanitize_text_field( $_POST[ 'fail_msg' ] );
	}
	if( isset( $_POST[ 'elc_h5p_debug' ] ) ) {
		$options[ 'elc_h5p_debug' ] = 1;
	} else {
		$options[ 'elc_h5p_debug' ] = 0;
	}

	// Replace empty values with defaults.
	$options = array_filter($options) + $default_options;

	// Save updated options in database.
	update_option( 'elc_h5p_options', $options );
	wp_redirect( add_query_arg( array( 'page' => 'elc_h5p', 'message' => '1' ), admin_url( 'options-general.php' ) ) );
	exit;
}

/**
 * Execute on plugin settings page.
 */
function elc_h5p_admin_init() {
	add_action( 'admin_post_save_elc_h5p_options', 'process_elc_h5p_options' );
	add_filter( 'sanitize_text_field', function ( $string ) {
		return $string;
	} );
}

/**
 * Register action when entering plugin settings page.
 */
add_action( 'admin_init', 'elc_h5p_admin_init' );

/**
 * Generate settings link for the plugin.
 *
 * @param $links
 * @return mixed
 */
function elc_h5p_settings_link( $links ) {
	$url = get_admin_url() . 'options-general.php?page=elc_h5p';
	$settings_link = '<a href="' . $url . '">' . __( 'Settings', 'textdomain' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}

/**
 * Add filter applied to the list of links to display on the plugins page.
 */
function elc_h5p_after_setup_theme() {
	add_filter( 'plugin_action_links_' . ELC_H5PLD_PLUGIN_BASENAME, 'elc_h5p_settings_link' );
}

/**
 * Register action afer theme is initialized.
 */
add_action( 'after_setup_theme', 'elc_h5p_after_setup_theme' );

/**
 * Render admin page contents using HTML.
 */
function elc_h5p_config_page() {
	// Get plugin configuration options from database.
	$options = elc_h5p_get_options();
	$default_options = elc_h5p_default_options();

	?>

	<?php if( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == '1' ): ?>
		<div id='message' class='updated fade'><p><strong>Settings Saved</strong></p></div>
	<?php endif; ?>

	<div id="elc_h5p-general" class="wrap">
		<h1>H5P for LearnDash Settings</h1>

		<form method="post" action="admin-post.php">
			<input type="hidden" name="action" value="save_elc_h5p_options">

			<?php wp_nonce_field( 'elc_h5p' ); ?>
			<br>

			<h1 class="title">LearnDash Quiz Question</h1>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="elc_h5p_question_label">Question Answer text</label></th>
					<td>
						<input size="80" type="text" name="question_label"
						       placeholder="<?php echo esc_html( $default_options[ 'question_label' ] ); ?>"
						       value="<?php echo esc_html( $options[ 'question_label' ] ); ?>"/>

						<p class="description">This field is rendered under the H5P activity when used in Quiz Question.</p>
						<p class="description">To hide entire field enter the word <i>hide</i> above.</p>
					</td>
				</tr>
			</table>
			<br><br>

			<h1 class="title">How to use the shortcode</h1>

			<p>For the H5P for LearnDash to work you will need to add H5P content on your lesson, topic or quiz page. This is
				done by inserting a shortcode e.g.: [h5p id="3"]. That's all you need to do. The plugin will do the rest.</p>

			<h2 class="title">How to show custom messages below your h5p content:</h2>

			<p>Place the elc_h5p shortcode immediately after the H5P shortcode and use the same id as in your H5P shortcode
				eg. [h5p id="3"][elc_h5p id="3"]. You can edit the default messages below.</p>

			<h2 class="title">How to prevent an individual H5P content from not controlling the LearnDash progress
				buttons:</h2>

			<p>In certain cases, you may not want the H5P content to control the Mark Complete or Start Quiz button. You can
				accomplish this by using the “ignore” attribute in the shortcode : e.g.: [elc_h5p id="3" ignore]. The ignore
				attribute, when present will stop the 'H5P for LearnDash' plugin from processing the H5P content with 'id'
				3.</p>
			<br><br>

			<h1 class="title">Custom messages</h1>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="pcpl_msg">Previously completed message</label></th>
					<td>
						<input size="80" type="text" name="pcpl_msg"
						       placeholder="<?php echo esc_html( $default_options[ 'pcpl_msg' ] ); ?>"
						       value="<?php echo esc_html( $options[ 'pcpl_msg' ] ); ?>"/>

						<p class="description">Message displayed when H5P content was completed and result was submitted.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mcpl_msg">Must complete message</label></th>
					<td>
						<input size="80" type="text" name="mcpl_msg"
						       placeholder="<?php echo esc_html( $default_options[ 'mcpl_msg' ] ); ?>"
						       value="<?php echo esc_html( $options[ 'mcpl_msg' ] ); ?>"/>

						<p class="description">Message displayed when H5P result was NOT yet submitted.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="succ_msg">Success message</label></th>
					<td>
						<input size="80" type="text" name="succ_msg"
						       placeholder="<?php echo esc_html( $default_options[ 'succ_msg' ] ); ?>"
						       value="<?php echo esc_html( $options[ 'succ_msg' ] ); ?>"/>

						<p class="description">Message displayed when H5P result was submitted and H5P indicated success.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fail_msg">Failure message</label></th>
					<td>
						<input size="80" type="text" name="fail_msg"
						       placeholder="<?php echo esc_html( $default_options[ 'fail_msg' ] ); ?>"
						       value="<?php echo esc_html( $options[ 'fail_msg' ] ); ?>"/>

						<p class="description">Message displayed when H5P result was submitted but H5P indicated failure.</p>
					</td>
				</tr>
			</table>
			<br><br><br>

			<h1 class="title">Debugging</h1>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="elc_h5p_debug">Debug</label></th>
					<td>
						<label>
							<input type="checkbox" name="elc_h5p_debug"
							       value="<?php echo esc_html( $options[ 'elc_h5p_debug' ] ); ?>"
								<?php if( $options[ 'elc_h5p_debug' ] ) echo ' checked="checked" '; ?>
							>Enable Debug
							<p class="description">If debug is enabled the elc_h5p shortcode will display message indicating ignore
								parameter and/or when the H5P
								content type is not on ELC_H5P white-list.</p>

						</label>
					</td>
				</tr>
			</table>
			<br><br><br>

			<p class="submit">
				<input type="submit" value="Submit" class="button-primary">
			</p>
		</form>
	</div>
	<?php
}
