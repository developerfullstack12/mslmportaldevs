<?php

class Learndash_Private_Message_Admin {
	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'selectWoo', plugin_dir_url( __FILE__ ) . 'css/selectWoo.min.css', [], $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/learndash-private-message-admin.css', [], $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'selectWoo', plugin_dir_url( __FILE__ ) . 'js/selectWoo.full.min.js', [ 'jquery' ], $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/learndash-private-message-admin.js', [ 'jquery' ], $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'learndash_private_message_backend',
			[
				'nonce_messages_dashboard' => wp_create_nonce( 'ldpm_messages_dashboard' ),
			]
		);
	}

	public function add_setting_page() {
		add_submenu_page(
			'learndash-lms',
			__( 'Chat Messages', 'learndash-private-message' ),
			__( 'Chat Messages', 'learndash-private-message' ),
			'manage_options',
			'ldpm-messages-dashboard',
			[ $this, 'messages_dashboard' ]
		);

		add_submenu_page(
			'learndash-lms',
			__( 'Chat Settings', 'learndash-private-message' ),
			__( 'Chat Settings', 'learndash-private-message' ),
			'manage_options',
			'ldpm-settings',
			[ $this, 'settings' ]
		);
	}

	public function init_settings() {
		$general            = 'ldpm-settings';
		$reminders          = 'ldpm-settings-reminders';
		$chat_notifications = 'ldpm-settings-instructor-notifications';
		$private_options    = 'ldpm-settings-private-options';
		$specific_courses   = 'ldpm-settings-specific-courses';

		// Register settings

		register_setting( $general, 'ldpm_restrict_chats_to_only_students_and_teachers' );
		register_setting( $general, 'ldpm_enable_anonymous_users' );
		register_setting( $general, 'ldpm_chat_refresh_frequency_seconds' );
		register_setting( $general, 'ldpm_delete_tables_on_deactivation' );

		register_setting( $general, 'ldpm_allow_create_private_chat_groups' );
		register_setting( $general, 'ldpm_allow_to_delete_private_messages' );
		register_setting( $general, 'ldpm_select_theme_option' );

		register_setting( $general, 'ldpm_chat_link_page' );
		register_setting( $general, 'ldpm_include_conversation_links' );

		register_setting( $general, 'ldpm_enable_reminders' );
		register_setting( $general, 'ldpm_notification_email' );
		register_setting( $general, 'ldpm_notification_text' );

		register_setting( $general, 'ldpm_twilio_settings' );

		// Specific Courses
		register_setting( $specific_courses, 'ldpm_specific_courses' );
		register_setting( $specific_courses, 'ldpm_specific_groups' );

		// General

		add_settings_section( $general, __( 'General', 'learndash-private-message' ), null, $general );

		add_settings_field(
			'ldpm_restrict_chats_to_only_students_and_teachers',
			__( 'Restrict chats to only students and teachers', 'learndash-private-message' ),
			[ $this, 'field_ldpm_restrict_chats_to_only_students_and_teachers' ],
			$general,
			$general
		);

		add_settings_field(
			'ldpm_enable_anonymous_users',
			__( 'Enable Anonymous Users', 'learndash-private-message' ),
			[ $this, 'field_ldpm_enable_anonymous_users' ],
			$general,
			$general
		);

		add_settings_field(
			'ldpm_chat_refresh_frequency_seconds',
			__( 'Chat refresh frequency (seconds)', 'learndash-private-message' ),
			[ $this, 'field_ldpm_chat_refresh_frequency_seconds' ],
			$general,
			$general
		);

		add_settings_field(
			'ldpm_delete_tables_on_deactivation',
			__( 'Delete database tables on deactivation', 'learndash-private-message' ),
			[ $this, 'field_ldpm_delete_tables_on_deactivation' ],
			$general,
			$general
		);

		add_settings_field(
			'ldpm_select_theme_option',
			__( 'Chat Theme', 'learndash-private-message' ),
			[ $this, 'field_ldpm_select_theme_option' ],
			$general,
			$general
		);

		// Chat Functionalities
		add_settings_section( $private_options, __( 'Private Chat Options', 'learndash-private-message' ), [ $this, 'field_private_chat_options' ], $general );

		add_settings_field(
			'ldpm_allow_create_private_chat_groups',
			__( 'Allow Users to create private groups', 'learndash-private-message' ),
			[ $this, 'field_ldpm_allow_create_private_chat_groups' ],
			$general,
			$private_options
		);

		add_settings_field(
			'ldpm_allow_to_delete_private_messages',
			__( 'Allow User to delete Private Messages', 'learndash-private-message' ),
			[ $this, 'field_ldpm_allow_to_delete_private_messages' ],
			$general,
			$private_options
		);

		// Reminders

		add_settings_section( $reminders, __( 'Reminders', 'learndash-private-message' ), null, $general );

		add_settings_field(
			'ldpm_enable_reminders',
			__( 'Enable Reminders', 'learndash-private-message' ),
			[ $this, 'field_ldpm_enable_reminders' ],
			$general,
			$reminders
		);

		add_settings_field(
			'ldpm_notification_email',
			__( 'Notification Email', 'learndash-private-message' ),
			[ $this, 'field_ldpm_notification_email' ],
			$general,
			$reminders
		);

		add_settings_field(
			'ldpm_notification_text',
			__( 'Notification Text', 'learndash-private-message' ),
			[ $this, 'field_ldpm_notification_text' ],
			$general,
			$reminders
		);

		add_settings_field(
			'ldpm_chat_link_page',
			__( 'Link to your Chat page', 'learndash-private-message' ),
			[ $this, 'field_ldpm_chat_link_page' ],
			$general,
			$reminders
		);

		add_settings_field(
			'ldpm_include_conversation_links',
			__( 'Include Conversation Links in email', 'learndash-private-message' ),
			[ $this, 'field_ldpm_include_conversation_links' ],
			$general,
			$reminders
		);

		add_settings_field(
			'ldpm_conversation_link_message',
			__( 'Conversation Link Message', 'learndash-private-message' ),
			[ $this, 'field_ldpm_conversation_link_message' ],
			$general,
			$reminders
		);

		add_settings_field(
			'ldpm_twilio_settings',
			__( 'Twilio Settings', 'learndash-private-message' ),
			[ $this, 'field_ldpm_twilio_settings' ],
			$general,
			$reminders
		);

		add_settings_section( $specific_courses, __( 'Hide Chat from specific Courses or Groups', 'learndash-private-message' ), null, $specific_courses );

		add_settings_field(
			'ldpm_specific_courses',
			__( 'Select Courses to Hide', 'learndash-private-message' ),
			[ $this, 'field_ldpm_specific_courses' ],
			$specific_courses,
			$specific_courses
		);

		add_settings_field(
			'ldpm_specific_groups',
			__( 'Select Groups to Hide', 'learndash-private-message' ),
			[ $this, 'field_ldpm_specific_groups' ],
			$specific_courses,
			$specific_courses
		);

	}

	public function field_private_chat_options() {
		echo '<div id="ldpm_private_options">' . __( 'This section options are only available when option "Restrict chats to only students and teachers" is not enabled.', 'learndash-private-message' ) . '</div>';
	}

	private function get_all_course_as_options() {
		$query_args = [
			'post_type'   => 'sfwd-courses',
			'post_status' => 'publish',
			'fields'      => 'all',
			'orderby'     => 'title',
			'order'       => 'ASC',
			'nopaging'    => true,    // Turns OFF paging logic to get ALL courses
		];

		$query = new WP_Query( $query_args );
		if ( $query instanceof WP_Query ) {
			return $query->posts;
		}

		return [];
	}

	private function get_all_groups_as_options() {
		$query_args = [
			'post_type'   => 'groups',
			'post_status' => 'publish',
			'fields'      => 'all',
			'orderby'     => 'title',
			'order'       => 'ASC',
			'nopaging'    => true,    // Turns OFF paging logic to get ALL courses
		];

		$query = new WP_Query( $query_args );
		if ( $query instanceof WP_Query ) {
			return $query->posts;
		}

		return [];
	}


	public function field_ldpm_specific_courses() {
		$option = get_option( 'ldpm_specific_courses', [] );
		$option = empty( $option ) ? [] : $option;

		echo '<select id="ldpm_specific_courses" name="ldpm_specific_courses[]" multiple="multiple">';

		foreach ( $this->get_all_course_as_options() as $course ) {
			$is_selected = in_array( strval( $course->ID ), $option, true );
			echo '<option value="' . esc_attr( $course->ID ) . '" ' . ( $is_selected ? 'selected' : '' ) . '>' . esc_html( $course->post_title ) . '</option>';
		}
		echo '</select>';
	}

	public function field_ldpm_specific_groups() {
		$option = get_option( 'ldpm_specific_groups', [] );
		$option = empty( $option ) ? [] : $option;

		echo '<select id="ldpm_specific_groups" name="ldpm_specific_groups[]" multiple="multiple">';

		foreach ( $this->get_all_groups_as_options() as $group ) {
			$is_selected = in_array( strval( $group->ID ), $option, true );
			echo '<option value="' . esc_attr( $group->ID ) . '" ' . ( $is_selected ? 'selected' : '' ) . '>' . esc_html( $group->post_title ) . '</option>';
		}
		echo '</select>';
	}

	public function field_ldpm_restrict_chats_to_only_students_and_teachers() {
		$option = get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' );

		echo '
            <select name="ldpm_restrict_chats_to_only_students_and_teachers" style="width: 100px;">
                <option value="1" ' . selected( $option, 1, false ) . '>
                    ' . __( 'Yes', 'learndash-private-message' ) . '
                </option>
                <option value="0" ' . selected( $option, 0, false ) . '>
                    ' . __( 'No', 'learndash-private-message' ) . '
                </option> 
            </select>
        ';
	}

	public function field_ldpm_enable_anonymous_users() {
		$option = get_option( 'ldpm_enable_anonymous_users' );

		echo '
            <select name="ldpm_enable_anonymous_users" style="width: 100px;">
                <option value="1" ' . selected( $option, 1, false ) . '>
                    ' . __( 'Yes', 'learndash-private-message' ) . '
                </option>
                <option value="0" ' . selected( $option, 0, false ) . '>
                    ' . __( 'No', 'learndash-private-message' ) . '
                </option> 
            </select>
        ';
	}

	public function field_ldpm_chat_refresh_frequency_seconds() {
		echo '<input name="ldpm_chat_refresh_frequency_seconds" value="' . get_option( 'ldpm_chat_refresh_frequency_seconds' ) . '" type="number" min="10" max="3600" style="width: 100px;"/>';
	}


	public function field_ldpm_delete_tables_on_deactivation() {
		$option = get_option( 'ldpm_delete_tables_on_deactivation' );

		echo '
            <select name="ldpm_delete_tables_on_deactivation" style="width: 100px;">
                <option value="1" ' . selected( $option, 1, false ) . '>
                    ' . __( 'Yes', 'learndash-private-message' ) . '
                </option>
                <option value="0" ' . selected( $option, 0, false ) . '>
                    ' . __( 'No', 'learndash-private-message' ) . '
                </option> 
            </select>
        ';
	}


	public function field_ldpm_select_theme_option() {
		$option = get_option( 'ldpm_select_theme_option', 'classic' );

		echo '
            <select name="ldpm_select_theme_option" style="width: 100px;">
                <option value="classic" ' . selected( $option, 'classic', false ) . '>
                    ' . __( 'Classic', 'learndash-private-message' ) . '
                </option>
                <option value="styled" ' . selected( $option, 'styled', false ) . '>
                    ' . __( 'Styled', 'learndash-private-message' ) . '
                </option> 
            </select>
        ';
	}

	public function field_ldpm_allow_create_private_chat_groups() {
		$option = get_option( 'ldpm_allow_create_private_chat_groups', 0 );

		echo '
            <select name="ldpm_allow_create_private_chat_groups" style="width: 100px;">
                <option value="1" ' . selected( $option, 1, false ) . '>
                    ' . __( 'Yes', 'learndash-private-message' ) . '
                </option>
                <option value="0" ' . selected( $option, 0, false ) . '>
                    ' . __( 'No', 'learndash-private-message' ) . '
                </option> 
            </select>
        ';
	}

	public function field_ldpm_allow_to_delete_private_messages() {
		$option = get_option( 'ldpm_allow_to_delete_private_messages', 0 );

		echo '
			<select name="ldpm_allow_to_delete_private_messages" style="width: 100px;">
				<option value="1" ' . selected( $option, 1, false ) . '>
					' . __( 'Yes', 'learndash-private-message' ) . '
				</option>
				<option value="0" ' . selected( $option, 0, false ) . '>
					' . __( 'No', 'learndash-private-message' ) . '
				</option> 
			</select>
		';
	}

	public function field_ldpm_include_conversation_links() {
		$option = get_option( 'ldpm_include_conversation_links', 0 );

		echo '
            <select name="ldpm_include_conversation_links" style="width: 100px;">
                <option value="1" ' . selected( $option, 1, false ) . '>
                    ' . __( 'Yes', 'learndash-private-message' ) . '
                </option>
                <option value="0" ' . selected( $option, 0, false ) . '>
                    ' . __( 'No', 'learndash-private-message' ) . '
                </option> 
            </select>
        ';
	}

	public function field_ldpm_chat_link_page() {
		$option = get_option( 'ldpm_chat_link_page', '' );

		echo '<div style="display: flex; flex-direction: column;">
			<input name="ldpm_chat_link_page" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr__( 'Your /chat-page here.', 'learndash-private-message' ) . '" type="text" style="width: 350px; margin-bottom: 5px;"/>
			<small>Must be a relative path to the page</small>
		</div>';
	}

	public function field_ldpm_enable_reminders() {
		$option = get_option( 'ldpm_enable_reminders' );

		echo '
            <select name="ldpm_enable_reminders" style="width: 100px;">
                <option value="1" ' . selected( $option, 1, false ) . '>
                    ' . __( 'Yes', 'learndash-private-message' ) . '
                </option>
                <option value="0" ' . selected( $option, 0, false ) . '>
                    ' . __( 'No', 'learndash-private-message' ) . '
                </option> 
            </select>
        ';
	}

	public function field_ldpm_notification_email() {
		$option = get_option( 'ldpm_notification_email' );

		echo '<div style="display: flex; flex-direction: column;">';

		echo '<input name="ldpm_notification_email[subject]" value="' . $option['subject'] . '" placeholder="Subject" type="text" style="width: 350px; margin-bottom: 15px;"/>';

		echo '<textarea name="ldpm_notification_email[body]" placeholder="Body" style="width: 350px; height: 100px; margin-bottom: 5px;">' . $option['body'] . '</textarea>';
		echo '<small>Available tokens: {user_name}, {total}, {site_name}, {site_link}, {chat_page}</small>';

		echo '</div>';
	}

	public function field_ldpm_conversation_link_message() {
		$option = get_option( 'ldpm_notification_email' );

		echo '<div style="display: flex; flex-direction: column;">';

		echo '<textarea name="ldpm_notification_email[conversation_link]" placeholder="Body" style="width: 350px; height: 120px; margin-bottom: 5px;">' . $option['conversation_link'] . '</textarea>';
		echo '<small>Available tokens: {unread_messages}, {conversation_type}, {chat_page}</small>';

		echo '</div>';
	}

	public function field_ldpm_notification_text() {
		echo '<div style="display: flex; flex-direction: column;">';

		echo '<input name="ldpm_notification_text" value="' . get_option( 'ldpm_notification_text' ) . '" type="text" style="width: 350px; margin-bottom: 5px;"/>';
		echo '<small>Available tokens: {user_name}, {total}, {site_name}, {site_link}, {chat_page}</small>';

		echo '</div>';
	}

	public function field_ldpm_twilio_settings() {
		$option = get_option( 'ldpm_twilio_settings' );

		echo '<div style="display: flex; flex-direction: column;">';

		echo '<input name="ldpm_twilio_settings[account_sid]" value="' . $option['account_sid'] . '" placeholder="Account SID" type="text" style="width: 350px; margin-bottom: 15px;"/>';
		echo '<input name="ldpm_twilio_settings[auth_token]" value="' . $option['auth_token'] . '" placeholder="Auth Token" type="text" style="width: 350px; margin-bottom: 15px;"/>';
		echo '<input name="ldpm_twilio_settings[from_number]" value="' . $option['from_number'] . '" placeholder="From Number" type="text" style="width: 350px"/>';

		echo '</div>';
	}

	public function settings() {
		?>
		<div class="wrap">
			<h1 class="ldpm-admin-header">LearnDash Chat</h1>

			<?php settings_errors(); ?>

			<div class="postbox" style="margin-top: 15px; padding: 0 25px;">
				<form method="post" action="options.php">
					<?php settings_fields( 'ldpm-settings' ); ?>

					<?php do_settings_sections( 'ldpm-settings' ); ?>

					<?php submit_button(); ?>
				</form>
			</div>

			<div class="postbox" style="margin-top: 15px; padding: 0 25px;">
				<form method="post" action="options.php">
					<?php settings_fields( 'ldpm-settings-specific-courses' ); ?>

					<?php do_settings_sections( 'ldpm-settings-specific-courses' ); ?>

					<?php submit_button(); ?>
				</form>
			</div>
		</div>
		<?php
	}

	public function messages_dashboard() {
		?>
		<div class="wrap">
			<h1 class="ldpm-admin-header">Chat Messages</h1>

			<div class="postbox" style="padding: 20px 15px; min-height: 70vh;">

				<select id="ldpm-user-select" style="width: 100%">
					<option>
						<?php _e( 'Select a user', 'learndash-private-message' ); ?>
					</option>
				</select>

				<div id="ldpm-user-messages"></div>

			</div>
		</div>
		<?php
	}

	public function schedule_unread_message_reminders() {
		if ( false === as_next_scheduled_action( 'ldpm_unread_message_reminder' ) ) {
			as_schedule_recurring_action(
				strtotime( 'now' ),
				HOUR_IN_SECONDS,
				'ldpm_unread_message_reminder'
			);
		}
	}

	/**
	 * @param WP_User $user
	 */
	public function add_user_fields( $user ) {
		?>
		<table class="form-table">
			<tr>
				<th>
					<label for="phone"><?php _e( 'Phone', 'learndash-private-message' ); ?></label>
				</th>
				<td>
					<input
						type="text"
						name="phone"
						id="phone"
						value="<?php echo esc_attr( get_user_meta( $user->ID, 'phone', true ) ); ?>"
						class="regular-text"
						style="margin-bottom: 5px;"
					/>
					<br />
					<small class="description">
						<?php _e( 'Used for LearnDash reminders. International format only, starts with +.', 'learndash-private-message' ); ?>
					</small>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * @param int $user_id
	 *
	 * @return false|void
	 */
	public function save_user_fields( $user_id ) {
		if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}

		$phone = sanitize_text_field( $_POST['phone'] );

		if ( substr( $phone, 0, 1 ) !== '+' ) {
			return;
		}

		update_user_meta( $user_id, 'phone', $phone );
	}

	public function remove_has_published_posts_from_wp_api_user_query( $prepared_args ) {
		unset( $prepared_args['has_published_posts'] );

		return $prepared_args;
	}

	public function load_user_messages() {
		if ( empty( $_POST['nonce'] ) or ! wp_verify_nonce( $_POST['nonce'], 'ldpm_messages_dashboard' ) ) {
			wp_send_json_error();
		}

		$user_id = intval( $_POST['user_id'] );

		// Load messages

		global $wpdb;

		$messages_table = $wpdb->prefix . 'ldpm_messages';

		$sql = $wpdb->prepare(
			"SELECT * FROM {$messages_table} WHERE sender_id = %d ORDER BY created_at DESC",
			$user_id
		);

		$messages = $wpdb->get_results( $sql, ARRAY_A );

		// Map result

		$result = '';

		if ( empty( $messages ) ) {
			$result .= '<div style="padding: 10px">' . __( 'No messages found', 'learndash-private-message' ) . '</div>';
		} else {
			$result .= '<table>';
			$result .= '
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Message</th>
                    </tr>
                </thead>
            ';
			$result .= '<tbody>';

			foreach ( $messages as $msg ) {
				$decoded_message = json_decode( $msg['message'], true );

				$result .= '<tr>';
				$result .= '<th>' . date( 'D M j h:i, Y', $msg['created_at'] ) . '</th>';
				$result .= '<td>' . nl2br( $decoded_message['text'] ) . '</td>';
				$result .= '</tr>';
			}

			$result .= '</tbody>';
			$result .= '</table>';
		}

		wp_send_json_success( $result );
	}
}
