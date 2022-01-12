<?php

/**
 * Fired during plugin activation
 *
 * @link       immerseus.com
 * @since      1.0.0
 *
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/includes
 * @author     Dnyanesh Mahajan <dnyaneshmahajan12@gmail.com>
 */
class Learndash_Private_Message_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! class_exists( 'SFWD_LMS' ) ) {
			// Stop activation redirect and show error
			wp_die( 'Sorry, but this plugin requires the Parent Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>' );
		}

		self::ldpm_create_tables();
		self::alter_table();
	}

	public static function ldpm_create_tables() {
		global $wpdb;

		$conversations_table = $wpdb->prefix . 'ldpm_conversations';

		$charset_collate = $wpdb->get_charset_collate();

		$wpdb->query(
			sprintf(
				'
				CREATE TABLE IF NOT EXISTS %s (
					id int(11) NOT NULL AUTO_INCREMENT,
					conversation_id int(11) NOT NULL, 
					sender_id int NOT NULL,
					type VARCHAR(255) NOT NULL,
					message text NOT NULL,
					is_read BOOLEAN NOT NULL DEFAULT 0,
					is_deleted BOOLEAN NOT NULL DEFAULT 0,
					created_at int NOT NULL,
					deleted_at TIMESTAMP NULL DEFAULT NULL,
					PRIMARY KEY (id)
				) %s;
			',
				$wpdb->prefix . 'ldpm_messages',
				$charset_collate
			)
		);

		$wpdb->query(
			sprintf(
				'
				CREATE TABLE IF NOT EXISTS %s (
					id int(11) NOT NULL AUTO_INCREMENT,
					entity_id int NOT NULL,
					limited_to_user_id int,
					type VARCHAR(255) NOT NULL,
					sender_id int NOT NULL,
					name VARCHAR(255) DEFAULT NULL,
					created_at int NOT NULL,
					PRIMARY KEY (id)
				) %s;
			',
				$wpdb->prefix . 'ldpm_conversations',
				$charset_collate
			)
		);

		if ( class_exists( 'Learndash_Private_Message_Migrator' ) ) {
			Learndash_Private_Message_Migrator::create_private_groups_table();
			Learndash_Private_Message_Migrator::create_read_messages_table();
			Learndash_Private_Message_Migrator::create_sent_email_archive();
			Learndash_Private_Message_Migrator::create_settings_table();
		}

		update_option( 'ldpm_db_version', LEARNDASH_PRIVATE_MESSAGE_VERSION );

		update_option( 'ldpm_restrict_chats_to_only_students_and_teachers', 0 );
		update_option( 'ldpm_delete_tables_on_deactivation', 0 );
		update_option( 'ldpm_chat_refresh_frequency_seconds', 30 );
		update_option( 'ldpm_chat_theme_option', 'classic' );

		update_option( 'ldpm_enable_reminders', 0 );

		update_option(
			'ldpm_notification_email',
			[
				'subject'           => 'You have {total} unread messages on {site_name}',
				'body'              => "Hello {user_name},\r\nYou have {total} unread messages on {site_name}.\r\nYour messages can be reviewed from {site_link}.",
				'conversation_link' => "You have {unread_messages} pending messages on \"{conversation_type}\" chat.\r\n\r\nClick in this link to go to the conversation:\r\n{chat_page}",
			]
		);

		update_option( 'ldpm_notification_text', 'Hello {user_name}, you have {total} unread messages on {site_name}.' );

		update_option(
			'ldpm_twilio_settings',
			[
				'account_sid' => '',
				'auth_token'  => '',
				'from_number' => '',
			]
		);
	}

	private static function alter_table() {
		global $wpdb;
		$ldpm_messages      = $wpdb->prefix . 'ldpm_messages';
		$ldpm_conversations = $wpdb->prefix . 'ldpm_conversations';

		// Change room_id for conversation_id.
		$room_id_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'room_id';",
				$ldpm_messages
			)
		);

		// if NOT empty === exists
		if ( ! empty( $room_id_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					CHANGE `room_id` `conversation_id` int(11) NOT NULL"
			);

			// should be 1 time for type.
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					MODIFY COLUMN type VARCHAR(255)"
			);

			// should be 1 time for type.
			$wpdb->query(
				"ALTER TABLE {$ldpm_conversations}
					MODIFY COLUMN type VARCHAR(255)"
			);
		}

		// Change timestamp for created_at.
		$timestamp_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'timestamp';",
				$ldpm_messages
			)
		);

		// if NOT empty === exists
		if ( ! empty( $timestamp_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					CHANGE `timestamp` `created_at` int NOT NULL"
			);
		}

		// Remove receiver_id.
		$receiver_id_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'receiver_id';",
				$ldpm_messages
			)
		);

		// if NOT empty === exists
		if ( ! empty( $receiver_id_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					DROP COLUMN receiver_id"
			);
		}

		// Remove status.
		$status_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'status';",
				$ldpm_messages
			)
		);

		// if NOT empty === exists
		if ( ! empty( $status_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					DROP COLUMN status"
			);
		}

		// Remove user_status.
		$user_status_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'user_status';",
				$ldpm_messages
			)
		);

		// if NOT empty === exists
		if ( ! empty( $user_status_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					DROP COLUMN user_status;"
			);
		}

		// Add is_read for conversations_table.
		$is_read_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'is_read';",
				$ldpm_messages
			)
		);

		// if empty === does not exist
		if ( empty( $is_read_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					ADD COLUMN is_read BOOLEAN NOT NULL DEFAULT 0;"
			);
		}

		// Add limited_to_user_id for conversations_table.
		$limited_to_user_id_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'limited_to_user_id';",
				$ldpm_conversations
			)
		);

		// if empty === does not exist
		if ( empty( $limited_to_user_id_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_conversations}
					ADD COLUMN limited_to_user_id INT"
			);
		}

	}

}
