<?php

/**
 * Fired during plugin deactivation
 *
 * @link       immerseus.com
 * @since      1.0.0
 *
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/includes
 * @author     Dnyanesh Mahajan <dnyaneshmahajan12@gmail.com>
 */
class Learndash_Private_Message_Deactivator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( ! get_option( 'ldpm_delete_tables_on_deactivation' ) ) {
			return;
		}

		global $wpdb;

		$table_name1 = $wpdb->prefix . 'ldpm_messages';
		$table_name2 = $wpdb->prefix . 'ldpm_conversations';
		$table_name3 = $wpdb->prefix . 'ldpm_settings';
		$table_name4 = $wpdb->prefix . 'ldpm_private_group_conversation_user';
		$table_name5 = $wpdb->prefix . 'ldpm_sent_email_archive';
		$table_name6 = $wpdb->prefix . 'ldpm_read_messages';

		$wpdb->query( "DROP TABLE IF EXISTS {$table_name1}, {$table_name2}, {$table_name3}, {$table_name4}, {$table_name5}, {$table_name6}" );

		delete_option( 'ldpm_db_version' );

		delete_option( 'ldpm_restrict_chats_to_only_students_and_teachers' );
		delete_option( 'ldpm_delete_tables_on_deactivation' );
		delete_option( 'ldpm_chat_refresh_frequency_seconds' );

		delete_option( 'ldpm_enable_reminders' );
		delete_option( 'ldpm_notification_email' );
		delete_option( 'ldpm_notification_text' );
		delete_option( 'ldpm_twilio_settings' );
	}
}
