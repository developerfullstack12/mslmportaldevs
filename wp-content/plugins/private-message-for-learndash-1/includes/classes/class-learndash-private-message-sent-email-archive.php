<?php

class Learndash_Private_Message_Sent_Email_Archive {

	private static $instance = null;

	const ARCHIVE_TABLE = 'ldpm_sent_email_archive';

	public function __construct() {
	}


	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Learndash_Private_Message_Sent_Email_Archive();
		}

		return self::$instance;
	}

	public function create( int $user_id ): int {
		global $wpdb;
		$table = $wpdb->prefix . self::ARCHIVE_TABLE;

		$wpdb->insert(
			$table,
			[
				'user_id' => $user_id,
			],
			[ '%d' ]
		);

		return $wpdb->insert_id;
	}

	public function delete_by_user_id( int $user_id ) {
		global $wpdb;
		$table = $wpdb->prefix . self::ARCHIVE_TABLE;

		$wpdb->delete(
			$table,
			[
				'user_id' => $user_id,
			],
			[ '%d' ]
		);
	}

	public function exists( int $user_id ): bool {
		global $wpdb;
		$table = $wpdb->prefix . self::ARCHIVE_TABLE;

		$current_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$table} WHERE user_id = %d", $user_id ) );

		return (bool) $current_id;
	}
}
