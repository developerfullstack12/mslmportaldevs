<?php

class Learndash_Private_Message_Private_Groups {

	private static $instance = null;

	const CONVERSATIONS_TABLE                   = 'ldpm_conversations';
	const PRIVATE_GROUP_CONVERSATION_USER_TABLE = 'ldpm_private_group_conversation_user';
	const MESSAGES_TABLE                        = 'ldpm_messages';

	const CHAT_TYPE_PRIVATE_GROUP = 'private_group';

	public function __construct() {
	}


	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Learndash_Private_Message_Private_Groups();
		}

		return self::$instance;
	}

	public function create_conversation( $user_id, $group_name, $invited_ids = [] ) {
		global $wpdb;

		$conversations_table = $wpdb->prefix . self::CONVERSATIONS_TABLE;

		$wpdb->insert(
			$conversations_table,
			[
				'entity_id'  => $user_id,
				'sender_id'  => $user_id,
				'type'       => self::CHAT_TYPE_PRIVATE_GROUP,
				'name'       => $group_name,
				'created_at' => current_time( 'timestamp' ),
			],
			[ '%d', '%d', '%s', '%s', '%d' ]
		);
		$conversation_id = $wpdb->insert_id;

		// As group creator, will be accepted by default.
		$this->invite_members( $conversation_id, [ $user_id ], true );

		if ( 0 < count( $invited_ids ) ) {
			$this->invite_members( $conversation_id, $invited_ids );
		}

		return $conversation_id;
	}

	public function get_conversations_by_user_id( $user_id ) {
		global $wpdb;

		$table               = $wpdb->prefix . self::PRIVATE_GROUP_CONVERSATION_USER_TABLE;
		$conversations_table = $wpdb->prefix . self::CONVERSATIONS_TABLE;

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT c.id, c.name, pg.is_accepted
				FROM ${table} pg
				INNER JOIN ${conversations_table} c
					ON c.id = pg.conversation_id
				WHERE pg.user_id = %d
					AND pg.is_deleted = 0
					AND (pg.is_accepted IS NULL OR pg.is_accepted = 1)",
				$user_id
			),
			ARRAY_A
		);

		return $results;
	}

	public function get_members_of_conversation( $conversation_id ) {
		global $wpdb;

		$table = $wpdb->prefix . self::PRIVATE_GROUP_CONVERSATION_USER_TABLE;

		$user_ids = $wpdb->get_results( $wpdb->prepare( "SELECT `user_id` FROM ${table} WHERE conversation_id = %d AND is_deleted = 0 AND is_accepted = 1", $conversation_id ), ARRAY_A );
		$user_ids = array_column( $user_ids, 'user_id' );
		$users    = get_users(
			[
				'include' => $user_ids,
				'fields'  => [ 'user_email', 'display_name', 'id' ],
			]
		);
		return $users;
	}

	public function respond_invitation( $conversation_id, $user_id, $is_accepted ) {
		global $wpdb;

		$table = $wpdb->prefix . self::PRIVATE_GROUP_CONVERSATION_USER_TABLE;

		$wpdb->update(
			$table,
			[
				'is_accepted' => $is_accepted,
			],
			[
				'conversation_id' => $conversation_id,
				'user_id'         => $user_id,
			],
			'%d',
			[ '%d', '%d' ]
		);
	}

	public function leave_private_group( $conversation_id, $user_id ) {
		global $wpdb;

		$table = $wpdb->prefix . self::PRIVATE_GROUP_CONVERSATION_USER_TABLE;

		$wpdb->update(
			$table,
			[
				'is_deleted' => 1,
			],
			[
				'conversation_id' => $conversation_id,
				'user_id'         => $user_id,
			],
			'%d',
			[ '%d', '%d' ]
		);
	}

	public function delete_private_group( $conversation_id ) {
		global $wpdb;

		$conversation_table = $wpdb->prefix . self::CONVERSATIONS_TABLE;
		$table              = $wpdb->prefix . self::PRIVATE_GROUP_CONVERSATION_USER_TABLE;

		$wpdb->delete(
			$table,
			[
				'conversation_id' => $conversation_id,
			],
			[ '%d' ]
		);
		$wpdb->delete(
			$conversation_table,
			[
				'id' => $conversation_id,
			],
			[ '%d' ]
		);
	}

	public function invite_members( $conversation_id, $invited_ids = [], $force_accept = false ) {
		global $wpdb;

		$table               = $wpdb->prefix . self::PRIVATE_GROUP_CONVERSATION_USER_TABLE;
		$conversations_table = $wpdb->prefix . self::CONVERSATIONS_TABLE;

		$real_ids = get_users(
			[
				'include' => $invited_ids,
				'fields'  => 'ids',
			]
		);

		foreach ( $real_ids as $user_id ) {
			$settings      = new Learndash_Private_Message_User_Settings( $user_id );
			$user_settings = $settings->get_settings();

			// check the settings of invited_ids... if they have "hidden chat blablabla" do not add them.
			if ( true === $user_settings[ Learndash_Private_Message_User_Settings::HIDE_FROM_MEMBERS_LIST_CHAT ] ) {
				continue;
			}

			$ignore_user_id = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT id, `is_accepted` 
					FROM ${table} 
					WHERE conversation_id = %d 
						AND `user_id` = %d 
						AND is_deleted = 1 
						AND is_accepted = 0
				",
					$conversation_id,
					$user_id
				),
				ARRAY_A
			);

			// if the member was already invited and rejected the invitation, do not invited again.
			if ( $ignore_user_id ) {
				continue;
			}

			$wpdb->insert(
				$table,
				[
					'conversation_id' => $conversation_id,
					'user_id'         => $user_id,
					'is_accepted'     => true === $force_accept ? 1 : null,
				],
				[ '%d', '%d', '%d' ]
			);
		}

	}

	public function get_available_members( $ignore_ids = [] ) {
		$admin_ids = get_users(
			[
				'role__in' => [ 'administrator' ],
				'fields'   => [ 'ID', 'display_name' ],
				'exclude'  => $ignore_ids,
			]
		);

		$excluded_ids = Learndash_Private_Message_User_Settings::get_user_ids_by_setting_name( Learndash_Private_Message_User_Settings::HIDE_FROM_MEMBERS_LIST_CHAT, true );

		$user_ids = array_merge(
			$admin_ids,
			get_users(
				[
					'role__not_in' => [ 'administrator' ],
					'fields'       => [ 'ID', 'display_name' ],
					'exclude'      => $ignore_ids,
				]
			)
		);

		$users = array_map(
			function( $user ) {
				return [
					'id'   => $user->ID,
					'name' => $user->display_name,
				];
			},
			$user_ids
		);

		// This will hide ONLY if the current user is NOT an Admin.
		if ( ! current_user_can( 'administrator' ) && ! empty( $excluded_ids ) ) {
			$users = array_filter(
				$users,
				function( $user ) use ( $excluded_ids ) {
					return ! in_array( $user['id'], $excluded_ids, true );
				}
			);
		}

		return array_values( $users );
	}

	public function validate_user_invitation( $user_id, $conversation_id ) {
		global $wpdb;

		$table  = $wpdb->prefix . self::PRIVATE_GROUP_CONVERSATION_USER_TABLE;
		$result = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT `is_accepted`
				FROM ${table}
				WHERE `user_id` = %d
					AND `conversation_id` = %d",
				$user_id,
				$conversation_id
			)
		);

		if ( is_null( $result ) ) {
			return 'pending';
		}

		if ( ! $result ) {
			return 'declined';
		}

		return 'accepted';
	}

	public function get_name( int $conversation_id ) {
		global $wpdb;

		$table  = $wpdb->prefix . self::CONVERSATIONS_TABLE;
		$result = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT `name`
				FROM {$table}
				WHERE `id` = %d",
				$conversation_id
			)
		);

		return $result;
	}

	public function is_group_leader( int $user_id, int $conversation_id ) {
		global $wpdb;

		$table = $wpdb->prefix . self::CONVERSATIONS_TABLE;

		$result = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT `id`
				FROM {$table}
				WHERE `id` = %d AND sender_id = %d",
				$conversation_id,
				$user_id
			)
		);

		return $result;
	}
}
