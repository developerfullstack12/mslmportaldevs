<?php

class Learndash_Private_Message_Migrator {
	/**
	 * For each version listed below you should create a method like "migrate_to_2_0_0" if the version is 2.0.0
	 * Always add a new version to the end of the array.
	 *
	 * @var array
	 */
	protected static $versions_with_migrations = [
		'3.1.0',
		'3.2.0',
		'3.3.0',
		'3.4.0',
		'4.0.2',
		'4.1.0',
	];

	public function migrate() {
		$current_version = get_option( 'ldpm_db_version', '1.0.0' );

		if ( version_compare( $current_version, LEARNDASH_PRIVATE_MESSAGE_VERSION, '==' ) ) {
			return;
		}

		foreach ( self::$versions_with_migrations as $version ) {
			// Current plugin version is not the latest, stop migrations accordingly
			if ( version_compare( $version, LEARNDASH_PRIVATE_MESSAGE_VERSION, '>' ) ) {
				break;
			}

			// It was already migrated, skip
			if ( version_compare( $version, $current_version, '<=' ) ) {
				continue;
			}

			// Migrate

			$method_name = 'migrate_to_' . str_replace( '.', '_', $version );

			if ( ! method_exists( self::class, $method_name ) ) {
				continue;
			}

			call_user_func( [ self::class, $method_name ] );
		}

		update_option( 'ldpm_db_version', LEARNDASH_PRIVATE_MESSAGE_VERSION );
	}

	public function migrate_to_3_1_0() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'ldpm_messages';

		// Add is_read for conversations_table.
		$is_read_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'is_read';",
				$table_name
			)
		);
		if ( empty( $is_read_column_exists ) ) {
			$wpdb->query( "ALTER TABLE {$table_name} ADD is_read BOOLEAN NOT NULL DEFAULT 0 AFTER message" );
		}

		update_option(
			'ldpm_notification_email',
			[
				'subject' => 'You have {total} unread messages on {site_name}',
				'body'    => "Hello {user_name},\r\nYou have {total} unread messages on {site_name}.\r\nYour messages can be reviewed from {site_link}.",
			]
		);
	}

	public function migrate_to_3_2_0() {
		update_option( 'ldpm_enable_reminders', 0 );

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

	public function migrate_to_3_3_0() {
		update_option( 'ldpm_select_theme_option', 'classic' );
	}

	public function migrate_to_3_4_0() {
		self::create_settings_table();
		self::create_private_groups_table();
		self::create_sent_email_archive();

		self::alter_tables_v_3_4_0();
	}

	public static function create_settings_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . 'ldpm_settings';

		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS {$table_name} (
				id int(11) NOT NULL AUTO_INCREMENT,
				`user_id` BIGINT(11) UNSIGNED NOT NULL,
				settings LONGTEXT DEFAULT NULL,
				created_at TIMESTAMP NOT NULL DEFAULT NOW(),
				PRIMARY KEY (id)
			) {$charset_collate};"
		);
	}

	public static function create_private_groups_table() {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'ldpm_private_group_conversation_user';
		$charset_collate = $wpdb->get_charset_collate();

		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS {$table_name} (
				id int(11) NOT NULL AUTO_INCREMENT,
				conversation_id int(11) NOT NULL,
				`user_id` BIGINT(11) UNSIGNED NOT NULL,
				is_accepted BOOLEAN DEFAULT NULL,
				is_deleted BOOLEAN NOT NULL DEFAULT 0,
				created_at TIMESTAMP NOT NULL DEFAULT NOW(),
				PRIMARY KEY (id)
			) {$charset_collate};"
		);
	}

	public static function create_sent_email_archive() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . 'ldpm_sent_email_archive';

		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS {$table_name} (
				id int(11) NOT NULL AUTO_INCREMENT,
				`user_id` BIGINT(11) UNSIGNED NOT NULL,
				sent_at TIMESTAMP NOT NULL DEFAULT NOW(),
				PRIMARY KEY (id)
			) {$charset_collate};"
		);
	}

	public static function alter_tables_v_3_4_0() {
		global $wpdb;
		$ldpm_messages      = $wpdb->prefix . 'ldpm_messages';
		$ldpm_conversations = $wpdb->prefix . 'ldpm_conversations';

		// Add name for conversations_table.
		$conversation_name_column_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'name';",
				$ldpm_conversations
			)
		);

		// if empty === does not exist
		if ( empty( $conversation_name_column_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_conversations}
					ADD COLUMN name VARCHAR(255) DEFAULT NULL"
			);
		}

		// Add is_deleted and deleted_at for conversations_table.
		$delete_message_columns_exists = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT COLUMN_NAME
					FROM INFORMATION_SCHEMA.COLUMNS
					WHERE table_name = %s
					AND column_name = 'is_deleted';",
				$ldpm_messages
			)
		);

		// if empty === does not exist
		if ( empty( $delete_message_columns_exists ) ) {
			$wpdb->query(
				"ALTER TABLE {$ldpm_messages}
					ADD COLUMN is_deleted BOOLEAN NOT NULL DEFAULT 0,
					ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL"
			);
		}
	}

	public function migrate_to_4_0_2() {
		self::create_read_messages_table();
	}

	/**
	 * Function created for Courses, Groups and Private Groups read messages
	 *
	 * @return void
	 */
	public static function create_read_messages_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table           = $wpdb->prefix . 'ldpm_read_messages';

		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS {$table} (
				id BIGINT(11) NOT NULL AUTO_INCREMENT,
				`user_id` BIGINT(11) UNSIGNED NOT NULL,
				conversation_id BIGINT(11) UNSIGNED NOT NULL,
				message_id BIGINT(11) UNSIGNED NOT NULL,
				is_read BOOLEAN NOT NULL DEFAULT 0,
				read_at TIMESTAMP NULL DEFAULT NULL,
				created_at TIMESTAMP NOT NULL DEFAULT NOW(),
				PRIMARY KEY (id)
			) {$charset_collate};"
		);
	}

	public function migrate_to_4_1_0() {
		$settings = get_option( 'ldpm_notification_email' );

		if ( isset( $settings['conversation_link'] ) ) {
			return;
		}

		if ( ! empty( $settings ) ) {
			$settings['conversation_link'] = "You have {unread_messages} pending messages on {conversation_type}.\r\n\r\nClick in this link to go to the conversation:\r\n{chat_page}";

			update_option(
				'ldpm_notification_email',
				$settings
			);
		} else {
			update_option(
				'ldpm_notification_email',
				[
					'subject'           => 'You have {total} unread messages on {site_name}',
					'body'              => "Hello {user_name},\r\nYou have {total} unread messages on {site_name}.\r\nYour messages can be reviewed from {site_link}.",
					'conversation_link' => "You have {unread_messages} pending messages on \"{conversation_type}\" chat.\r\n\r\nClick in this link to go to the conversation:\r\n{chat_page}",
				]
			);
		}

	}
}
