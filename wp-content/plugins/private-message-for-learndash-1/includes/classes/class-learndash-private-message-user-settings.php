<?php

class Learndash_Private_Message_User_Settings {

	const HIDE_FROM_MEMBERS_LIST_CHAT = 'hide_from_members_list_chat';

	const DEFAULT_SETTINGS = [
		self::HIDE_FROM_MEMBERS_LIST_CHAT => false,
	];

	const TABLE_NAME = 'ldpm_settings';

	protected $settings = [];

	protected $user_id = null;

	public function __construct( $user_id ) {
		$this->user_id = $user_id;
		$this->init();
	}

	public function get_settings() {

		$current_settings = ! is_null( $this->settings ) ? $this->settings : [];

		return array_merge( self::DEFAULT_SETTINGS, $current_settings );
	}

	public function set_settings( $settings ) {
		$this->settings = $settings;
	}

	public function update_setting( $setting_option, $value ) {
		$current_settings = $this->get_settings();

		if ( ! in_array( $setting_option, array_keys( self::DEFAULT_SETTINGS ), true ) ) {
			return;
		}

		$current_settings[ $setting_option ] = $value;

		$this->update_settings_for_user( $current_settings );
	}

	public static function get_user_ids_by_setting_name( $setting_option, $searched_value = null ) {
		if ( ! in_array( $setting_option, array_keys( self::DEFAULT_SETTINGS ), true ) ) {
			return null;
		}
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$results = $wpdb->get_results( "SELECT `user_id`, settings FROM $table_name", ARRAY_A );

		$user_ids = [];
		foreach ( $results as $record ) {
			$settings = json_decode( $record['settings'], true );

			if ( $settings[ $setting_option ] === $searched_value ) {
				$user_ids[] = $record['user_id'];
			}
		}
		return $user_ids;
	}

	public static function get_label_for_setting( $setting ) {
		switch ( $setting ) {
			case self::HIDE_FROM_MEMBERS_LIST_CHAT:
				return 'Hide yourself from the members list in the chat area.';
			default:
				return '';
		}
	}


	private function init() {
		if ( 0 === $this->user_id || empty( $this->user_id ) ) {
			return;
		}

		if ( ! $this->exists_db_record() ) {
			$this->create_settings_for_user();
		}

		$this->get_user_settings();
	}

	public function get_user_settings() {
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$record = $wpdb->get_var( $wpdb->prepare( "SELECT settings FROM $table_name WHERE `user_id` = %d", $this->user_id ) );

		$decoded = ! empty( $record ) ? json_decode( $record, true ) : [];

		$this->set_settings( $decoded );

		return $this->get_settings();
	}

	protected function create_settings_for_user() {
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$json_settings = wp_json_encode( $this->get_settings() );

		$wpdb->query( $wpdb->prepare( "INSERT INTO $table_name (`user_id`, `settings`) VALUES (%d, %s)", $this->user_id, $json_settings ) );
	}


	protected function update_settings_for_user( $settings ) {
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$json_settings = wp_json_encode( $settings );

		$wpdb->update(
			$table_name,
			[
				'settings' => $json_settings,
			],
			[
				'user_id' => $this->user_id,
			],
			[ '%s' ],
			[ '%d' ]
		);

		$this->set_settings( $settings );

	}

	protected function exists_db_record() {
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$record = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE `user_id` = %d", $this->user_id ) );

		return ! empty( $record );
	}
}
