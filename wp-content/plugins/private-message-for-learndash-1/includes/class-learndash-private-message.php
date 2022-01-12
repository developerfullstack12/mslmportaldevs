<?php

use Embera\Embera;
use Twilio\Rest\Client;

class Learndash_Private_Message {
	const CHAT_TYPE_GROUP = 'group';

	const CHAT_TYPE_COURSE = 'course';

	const CHAT_TYPE_PRIVATE = 'private';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Learndash_Private_Message_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * The embera class object handler.
	 *
	 * @since    1.0.0
	 * @access   protected
	 */

	protected $embera_obj;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'LEARNDASH_PRIVATE_MESSAGE_VERSION' ) ) {
			$this->version = LEARNDASH_PRIVATE_MESSAGE_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'learndash-private-message';

		$this->load_dependencies();
		$this->run_migrations();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Learndash_Private_Message_Loader. Orchestrates the hooks of the plugin.
	 * - Learndash_Private_Message_i18n. Defines internationalization functionality.
	 * - Learndash_Private_Message_Admin. Defines all hooks for the admin area.
	 * - Learndash_Private_Message_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-learndash-private-message-loader.php';

		/**
		 * The class responsible for defining migrations functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-learndash-private-message-migrator.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-learndash-private-message-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-learndash-private-message-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-learndash-private-message-public.php';

		$this->loader = new Learndash_Private_Message_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Learndash_Private_Message_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Learndash_Private_Message_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Define the migrator for this plugin for database migrations.
	 *
	 * Uses the Learndash_Private_Message_Migrator class in order to set run migrations and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function run_migrations() {
		$plugin_migrator = new Learndash_Private_Message_Migrator();

		$this->loader->add_action( 'plugins_loaded', $plugin_migrator, 'migrate' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Learndash_Private_Message_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_setting_page' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'init_settings' );

		$this->loader->add_action( 'init', $plugin_admin, 'schedule_unread_message_reminders' );

		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'add_user_fields' );
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'add_user_fields' );
		$this->loader->add_action( 'user_new_form', $plugin_admin, 'add_user_fields' );

		$this->loader->add_action( 'personal_options_update', $plugin_admin, 'save_user_fields' );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'save_user_fields' );

		$this->loader->add_filter( 'rest_user_query', $plugin_admin, 'remove_has_published_posts_from_wp_api_user_query' );
		$this->loader->add_filter( 'wp_ajax_load_user_messages', $plugin_admin, 'load_user_messages' );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Learndash_Private_Message_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Learndash_Private_Message_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'shortcodes' );
		$this->loader->add_filter( 'learndash_content_tabs', $plugin_public, 'add_tab_button', 10, 4 );

		$this->loader->add_action( 'ldpm_unread_message_reminder', $this, 'send_unread_message_reminders' );

		$this->loader->add_action( 'wp_ajax_load_conversations', $this, 'load_conversations' );
		$this->loader->add_action( 'wp_ajax_load_conversation', $this, 'load_conversation' );
		$this->loader->add_action( 'wp_ajax_send_message', $this, 'send_message' );
		$this->loader->add_action( 'wp_ajax_update_settings', $this, 'update_settings' );
		$this->loader->add_filter( 'wp_ajax_delete_message', $this, 'delete_message' );

		// PRIVATE GROUPS.
		$this->loader->add_filter( 'wp_ajax_create_private_group', $this, 'create_private_group' );
		$this->loader->add_filter( 'wp_ajax_invite_members_to_private_groups', $this, 'invite_members_to_private_groups' );
		$this->loader->add_filter( 'wp_ajax_respond_to_invitation', $this, 'respond_to_invitation' );
		$this->loader->add_filter( 'wp_ajax_leave_private_group', $this, 'leave_private_group' );
		$this->loader->add_filter( 'wp_ajax_delete_private_group', $this, 'delete_private_group' );
		$this->loader->add_filter( 'wp_ajax_is_group_leader', $this, 'is_group_leader' );
		$this->loader->add_filter( 'wp_ajax_get_members_of_conversation', $this, 'get_members_of_conversation' );
		$this->loader->add_filter( 'wp_ajax_get_available_members', $this, 'get_available_members' );
		$this->loader->add_filter( 'wp_ajax_validate_user_invitation', $this, 'validate_user_invitation' );
	}

	// TODO: also check if a user has access to the opponent entity
	public function load_conversations() {
		if ( empty( $_POST['nonce'] ) or ! wp_verify_nonce( $_POST['nonce'], 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$course_id = 0;

		if ( isset( $_POST['course_id'] ) ) {
			$course_id = intval( $_POST['course_id'] );
		}

		$limited_to_user_id = $this->map_limited_to_user_id_param();
		$cur_user_id        = get_current_user_id();

		$html = '';

		// Map courses

		$html .= $this->map_conversation_list(
			self::CHAT_TYPE_COURSE,
			$this->get_available_course_ids( $cur_user_id, $course_id ),
			__( 'Courses', 'learndash-private-message' ),
			$limited_to_user_id
		);

		// Map groups

		$html .= $this->map_conversation_list(
			self::CHAT_TYPE_GROUP,
			$this->get_available_group_ids( $cur_user_id ),
			__( 'Groups', 'learndash-private-message' ),
			$limited_to_user_id
		);

		// Map Private Groups
		$html .= $this->map_private_group_conversations( $cur_user_id );

		// Map users

		if ( ! get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' ) ) {

			$chat_type      = isset( $_POST['chat_type'] ) ? sanitize_text_field( wp_unslash( $_POST['chat_type'] ) ) : '';
			$chat_entity_id = isset( $_POST['chat_entity_id'] ) ? intval( $_POST['chat_entity_id'] ) : 0;

			$html .= $this->map_users(
				$this->get_available_member_ids( $chat_type, $chat_entity_id ),
				$limited_to_user_id
			);
		}

		wp_send_json_success( $html );
	}

	public function load_conversation() {
		if ( empty( $_POST['nonce'] ) or ! wp_verify_nonce( $_POST['nonce'], 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		if (
			empty( $_POST['type'] ) or
			! $this->is_valid_chat_type( $_POST['type'] ) or
			empty( $_POST['id'] ) or
			! isset( $_POST['limited_to_user_id'] )
			// TODO: also check if a user has access to the opponent entity
		) {
			wp_send_json_error();
		}

		$chat_type = sanitize_text_field( $_POST['type'] );
		$id        = intval( $_POST['id'] );

		$conversation_id = $this->find_or_create_conversation( $chat_type, $id, $this->map_limited_to_user_id_param() );

		$messages = $this->get_conversation_messages( $conversation_id );

		$this->mark_conversation_messages_as_read( $conversation_id, $chat_type );
		if ( get_option( 'ldpm_enable_reminders' ) ) {
			$archive_instance = Learndash_Private_Message_Sent_Email_Archive::get_instance();
			$archive_instance->delete_by_user_id( get_current_user_id() );
		}

		wp_send_json_success(
			$this->map_messages( $messages )
		);
	}

	public function send_message() {
		if ( empty( $_POST['nonce'] ) or ! wp_verify_nonce( $_POST['nonce'], 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		// TODO: add additional validation
		if (
			( empty( $_POST['message'] ) and empty( $_FILES['file'] ) ) or
			empty( $_POST['chat_type'] ) or
			! $this->is_valid_chat_type( $_POST['chat_type'] ) or
			empty( $_POST['chat_entity_id'] ) or
			! isset( $_POST['limited_to_user_id'] )
		) {
			wp_send_json_error();
		}

		$chat_type      = sanitize_text_field( $_POST['chat_type'] );
		$chet_entity_id = intval( $_POST['chat_entity_id'] );
		$text           = sanitize_textarea_field( wp_unslash( $_POST['message'] ) );

		$conversation_id = $this->find_or_create_conversation( $chat_type, $chet_entity_id, $this->map_limited_to_user_id_param() );

		$message_json = json_encode(
			[
				'text'  => $text,
				'files' => $this->process_files(),
			]
		);

		$insert_result = self::post_message( $conversation_id, get_current_user_id(), $chat_type, $message_json );

		if ( ! $insert_result ) {
			wp_send_json_error();
		}

		wp_send_json_success();
	}

	public function delete_message() {
		global $wpdb;

		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		if ( ! get_option( 'ldpm_allow_to_delete_private_messages', 0 ) ) {
			wp_send_json_error( 'nothing to delete' );
		}

		$message_id = isset( $_POST['message_id'] ) ? sanitize_text_field( wp_unslash( $_POST['message_id'] ) ) : null;

		if ( empty( $message_id ) || ! is_numeric( $message_id ) ) {
			wp_send_json_error( 'nothing to delete' );
		}

		$table = $wpdb->prefix . 'ldpm_messages';

		$created_at = $wpdb->get_var( $wpdb->prepare( "SELECT created_at FROM $table WHERE id = %d", $message_id ) );

		// get minutes
		$should_delete = intval( ( current_time( 'timestamp' ) - $created_at ) / 60 );

		// only delete if the message was created in less than 10 minutes
		if ( 10 >= $should_delete ) {
			$wpdb->update(
				$wpdb->prefix . 'ldpm_messages',
				[
					'is_deleted' => true,
					'deleted_at' => current_time( 'mysql' ),
				],
				[
					'id'        => $message_id,
					'sender_id' => get_current_user_id(),
					'type'      => self::CHAT_TYPE_PRIVATE,
				],
				[ '%d', '%s' ],
				[ '%d', '%d' ]
			);
		}

		wp_send_json_success();

	}

	public static function post_message( $conversation_id, $sender_id, $chat_type, $message_json ) {
		global $wpdb;

		$is_read = get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' )
			? false
			: self::CHAT_TYPE_PRIVATE !== $chat_type; // group messages are always read

		$message_inserted = $wpdb->insert(
			$wpdb->prefix . 'ldpm_messages',
			[
				'conversation_id' => $conversation_id,
				'sender_id'       => $sender_id,
				'type'            => $chat_type,
				'message'         => $message_json,
				'is_read'         => $is_read,
				'created_at'      => current_time( 'timestamp' ),
			]
		);

		// Support read messages for Courses Groups and Private Groups.
		if ( self::CHAT_TYPE_PRIVATE !== $chat_type ) {
			$message_id = $wpdb->insert_id;

			$participants = ( new self() )->get_members_of_conversation_id( $conversation_id );

			foreach ( $participants as $participant_id ) {
				$wpdb->insert(
					$wpdb->prefix . 'ldpm_read_messages',
					[
						'conversation_id' => $conversation_id,
						'user_id'         => $participant_id,
						'message_id'      => $message_id,
					]
				);
			}
		}

		return $message_inserted;
	}

	public static function get_type_by_conversation_id( $conversation_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'ldpm_conversations';

		return $wpdb->get_var( $wpdb->prepare( "SELECT `type` FROM {$table_name} WHERE id = %d", $conversation_id ) );
	}

	public static function get_messages_sql( $conversation_id, $args = [] ) {
		$sql_params = [];
		$query      = wp_parse_args(
			$args,
			[
				'limit'                 => -1,
				'type'                  => null,
				'sender_id'             => null,
				'is_read'               => null,
				'created_at'            => null,
				'created_at_comparison' => '<=',
				'order'                 => 'ASC',
				'orderby'               => 'created_at',
			]
		);

		global $wpdb;
		$table_name = $wpdb->prefix . 'ldpm_messages';

		$sql          = "SELECT id, sender_id, `message`, is_read, created_at FROM {$table_name} WHERE conversation_id = %d ";
		$sql_params[] = $conversation_id;

		if ( ! is_null( $query['sender_id'] ) ) {
			$sql         .= ' AND sender_id = %d';
			$sql_params[] = $query['sender_id'];
		}

		if ( ! is_null( $query['type'] ) ) {
			$sql         .= ' AND `type` = %s';
			$sql_params[] = $query['type'];
		}

		if ( ! is_null( $query['is_read'] ) ) {
			$sql         .= ' AND is_read = %d';
			$sql_params[] = $query['is_read'];
		}

		if ( $query['created_at'] instanceof \DateTime ) {
			$date = clone $query['created_at'];
			$date->setTimezone( new \DateTimeZone( 'UTC' ) );

			$comparator = $query['created_at_comparison'];
			if ( ! in_array( $comparator, [ '!=', '>', '>=', '<', '<=', '=' ], true ) ) {
				$comparator = '=';
			}

			$sql         .= " AND created_at $comparator %d";
			$sql_params[] = $date->getTimestamp();
		}

		if ( 'ASC' === strtoupper( $query['order'] ) ) {
			$order = 'ASC';
		} else {
			$order = 'DESC';
		}

		if ( 'created_at' === $query['orderby'] ) {
			$sql .= " ORDER BY created_at $order";
		}

		if ( $query['limit'] > 0 ) {
			$sql         .= ' LIMIT %d';
			$sql_params[] = $query['limit'];
		}

		$results = $wpdb->get_results( $wpdb->prepare( $sql, $sql_params ), ARRAY_A ); // WPCS: unprepared SQL OK.

		foreach ( $results as $key => $result ) {
			$results[ $key ]['message'] = json_decode( $result['message'] );
		}

		return $results;
	}

	protected function get_embed_formated_url( $message = '' ) {
		if ( empty( $message ) ) {
			return $message;
		}

		if ( ( $this->embera_obj instanceof Embera ) != true ) {
			$config = apply_filters( 'embed_filter_config_data', [ 'height' => 250 ] );

			$this->embera_obj = new Embera( $config );
		}

		return apply_filters(
			'filter_original_and_embed_message',
			$this->embera_obj->autoEmbed( $message ),
			$message
		);
	}

	/**
	 * @param string   $type
	 * @param int      $entity_id
	 * @param int|null $limited_to_user_id
	 *
	 * @return int
	 */
	protected function find_or_create_conversation( string $type, int $entity_id, $limited_to_user_id ): int {
		$conversation_id = $this->find_conversation_id( $type, $entity_id, $limited_to_user_id );

		if ( $conversation_id ) {
			return $conversation_id;
		}

		global $wpdb;

		$wpdb->insert(
			$wpdb->prefix . 'ldpm_conversations',
			[
				'entity_id'          => $entity_id,
				'limited_to_user_id' => $limited_to_user_id ?: null,
				'type'               => $type,
				'sender_id'          => get_current_user_id(),
				'created_at'         => current_time( 'timestamp' ),
			]
		);

		return $wpdb->insert_id;
	}

	/**
	 * @param string   $type
	 * @param int      $entity_id
	 * @param int|null $limited_to_user_id
	 *
	 * @return string|null
	 */
	protected function find_conversation_id( string $type, int $entity_id, $limited_to_user_id ) {
		global $wpdb;

		$conversation_table = $wpdb->prefix . 'ldpm_conversations';
		$cur_user_id        = get_current_user_id();

		if ( $type === self::CHAT_TYPE_PRIVATE ) {
			$sql = $wpdb->prepare(
				"SELECT id FROM {$conversation_table} WHERE type = %s AND ( (entity_id = %d AND sender_id = %d) OR (sender_id = %d AND entity_id = %d) )",
				$type,
				$entity_id,
				$cur_user_id,
				$entity_id,
				$cur_user_id
			);
		} elseif ( Learndash_Private_Message_Private_Groups::CHAT_TYPE_PRIVATE_GROUP === $type ) {
			$sql = $wpdb->prepare(
				"SELECT id FROM {$conversation_table} WHERE type = %s AND id = %d",
				$type,
				$entity_id
			);
		} else {
			if ( get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' ) ) {
				$sql = $wpdb->prepare(
					"SELECT id FROM {$conversation_table} WHERE type = %s AND entity_id = %d AND limited_to_user_id = %d",
					$type,
					$entity_id,
					$limited_to_user_id
				);
			} else {
				$sql = $wpdb->prepare(
					"SELECT id FROM {$conversation_table} WHERE type = %s AND entity_id = %d AND limited_to_user_id IS NULL",
					$type,
					$entity_id
				);
			}
		}

		return $wpdb->get_var( $sql );
	}

	/**
	 * @param string   $chat_type
	 * @param array    $entity_ids
	 * @param string   $header
	 * @param int|null $limited_to_user_id
	 *
	 * @return string
	 */
	protected function map_conversation_list( string $chat_type, array $entity_ids, string $header, $limited_to_user_id ): string {
		if ( empty( $entity_ids ) ) {
			return '';
		}

		$result = '<div class="imm-group">';

		$result .= $this->map_conversation_list_header( $header );

		$result .= '<div class="imm-chat-paper imm-group__items">';

		if ( get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' ) && false === $this->current_user_is_student() ) {
			foreach ( $entity_ids as $entity_id ) {
				$user_ids = $this->get_available_member_ids( $chat_type, $entity_id );

				foreach ( $user_ids as $limited_to_user_id ) {
					$result .= $this->map_conversation_list_item( $chat_type, $entity_id, $limited_to_user_id );
				}
			}
		} else {
			foreach ( $entity_ids as $entity_id ) {
				$result .= $this->map_conversation_list_item( $chat_type, $entity_id, $limited_to_user_id );
			}
		}

		$result .= '</div></div>';

		return $result;
	}

	protected function map_conversation_list_header( string $label ): string {
		return '<div class="imm-group__title">' . esc_html( $label ) . '</div>';
	}

	protected function map_unread_messages_counter( int $count ): string {
		if ( $count === 0 ) {
			return '';
		}

		return '
			<div  class="imm-group__item__notifications">
				' . esc_html( $count ) . '
			</div>
		 ';
	}

	/**
	 * @param string   $chat_type
	 * @param int      $entity_id
	 * @param int|null $user_id
	 *
	 * @return string
	 */
	protected function map_conversation_list_item( string $chat_type, int $entity_id, ?int $user_id = null ): string {
		$unread_messages_count = $this->count_unread_messages( $chat_type, $entity_id, $user_id );
		$limit_to_user_id      = false === $this->current_user_is_student() ? $user_id : '';

		$title = get_the_title( $entity_id );

		if ( false === $this->current_user_is_student() and $user_id ) {
			$title .= '<br/>' . get_userdata( $user_id )->display_name;
		}

		$result = '<div class="ldpm-conversation-link imm-group__item" data-type="' . esc_attr( $chat_type ) . '" data-id="' . esc_attr( $entity_id ) . '" data-limit-to-user-id="' . esc_attr( $limit_to_user_id ) . '">';

		$result .= '<div class="imm-group__item__avatar">' . $title[0] . '</div>';

		$result .= '<div class="imm-group__item__info">';

		$result .= '<span class="imm-group__item__name">' . $title . '</span>';

		$result .= $this->map_unread_messages_counter( $unread_messages_count );

		$result .= '</div>';
		$result .= '</div>';

		return $result;
	}

	/**
	 * @param array    $user_ids
	 * @param int|null $limited_to_user_id
	 *
	 * @return string
	 */
	protected function map_users( array $user_ids, $limited_to_user_id ): string {
		if ( empty( $user_ids ) ) {
			return '';
		}

		$result = '<div class="imm-group">';

		$result .= $this->map_conversation_list_header(
			__( 'Members', 'learndash-private-message' )
		);

		$result .= '<div class="imm-chat-paper imm-group__items">';

		foreach ( get_users( [ 'include' => $user_ids ] ) as $user ) {
			/** @var WP_User $user */
			$unread_messages_count = $this->count_unread_messages( self::CHAT_TYPE_PRIVATE, $user->ID, $limited_to_user_id );

			$result .= '<div class="ldpm-conversation-link imm-group__item" data-type="' . esc_attr( self::CHAT_TYPE_PRIVATE ) . '" data-id="' . esc_attr( $user->ID ) . '">';

			$result .= '<img class="imm-group__item__avatar" src="' . esc_attr( get_avatar_url( $user->ID ) ) . '" alt="" />';

			$result .= '<div class="imm-group__item__info">';

			$result .= '<span class="imm-group__item__name">' . esc_html( $user->display_name ) . '</span>';

			$result .= $this->map_unread_messages_counter( $unread_messages_count );

			$result .= '</div>';
			$result .= '</div>';
		}

		$result .= '</div>';

		return $result;
	}

	protected function map_messages( array $messages ): string {
		if ( empty( $messages ) ) {
			return '
                <span class="imm-capitalize imm-text-center imm-leading-6 imm-text-xl imm-text-gray-200 imm-font-medium imm-absolute imm-top-1/2 imm-left-1/2 imm-transform imm--translate-x-1/2 imm--translate-y-1/2">
                    ' . __( 'No messages', 'learndash-private-message' ) . '
                </span >
            ';
		}

		$html = '';

		$is_anonymous = get_option( 'ldpm_enable_anonymous_users', 0 );

		$current_user_avatar_url = get_avatar_url(
			get_current_user_id(),
			[
				'force_default' => $is_anonymous,
			]
		);
		$current_user_data       = wp_get_current_user();
		$wp_date_format          = get_option( 'date_format' );
		$wp_time_format          = get_option( 'time_format' );

		$full_date_format = "{$wp_date_format} {$wp_time_format}";

		$owner_delete_message    = __( 'You deleted this message', 'learndash-private-message' );
		$receiver_delete_message = __( 'This message was deleted by ', 'learndash-private-message' );

		foreach ( $messages as $msg ) {
			$decoded_message = json_decode( $msg['message'], true );

			$text = wp_unslash( nl2br( $decoded_message['text'] ) );
			$text = $this->get_embed_formated_url( $text );
			$text = $text ? "<div>{$text}</div>" : '';

			$is_deleted = (bool) $msg['is_deleted'];

			$attachments = '';

			if ( ! empty( $decoded_message['files'] ) ) {
				$attachments .= '<div class="imm-block imm-text-sm imm-flex-col">';

				foreach ( $decoded_message['files'] as $file ) {
					$file_url = esc_url( get_home_url( null, $file['path'] ) );

					$attachments .= '<a href="' . esc_attr( $file_url ) . '" class="imm-chat__message__attachment" download>' . esc_attr( $file['name'] ) . '</a>';
				}

				$attachments .= '</div> ';
			}

			if ( get_current_user_id() === intval( $msg['sender_id'] ) ) {

				$delete_message_button = '';

				if ( get_option( 'ldpm_allow_to_delete_private_messages', 0 ) ) {
					// get minutes
					$should_delete = intval( ( current_time( 'timestamp' ) - $msg['created_at'] ) / 60 );
					if ( 10 >= $should_delete && self::CHAT_TYPE_PRIVATE === $msg['type'] ) {
						$delete_message_button = ' -<button type="button" class="imm-chat__message__delete__button" data-id="' . esc_attr( $msg['id'] ) . '">' . __( 'Delete', 'learndash-private-message' ) . '</button>';
					}
				}

				$user_to_display = $is_anonymous ? __( 'Anonymous', 'learndash-private-message' ) : $current_user_data->data->display_name;
				$text_to_display = $is_deleted ? ( '<div class="imm-chat__message__text--is-deleted">' . $owner_delete_message . '</div>' ) : ( $text . $attachments );
				$html           .= '
                    <div class="imm-chat__message imm-chat__message--is-right">
						<div class="imm-chat__message__content">
							<div class="ldpm-chat-message ldpm-chat-message-own imm-chat__message__text">
								<div class="imm-chat__message__text__container">' . $text_to_display . '</div>
							</div>
							
							<div class="imm-chat__message__user">
								<img class="imm-chat__message__avatar" src="' . esc_attr( $current_user_avatar_url ) . '">
							</div>
						</div>
						<div>
							<div class="imm-chat__message__username">
								' . __( 'You', 'learndash-private-message' ) . ' (' . $user_to_display . ')
							</div>
							<div class="imm-chat__message__time">
							' . date( $full_date_format, $msg['created_at'] ) . ( $is_deleted ? '' : $delete_message_button ) . '
							</div>
						</div>
					</div>
			  	';
			} else {
				$opponent            = get_userdata( $msg['sender_id'] );
				$opponent_avatar_url = get_avatar_url(
					$opponent->ID,
					[
						'force_default' => $is_anonymous,
					]
				);

				$user_to_display = $is_anonymous ? __( 'Anonymous', 'learndash-private-message' ) : $opponent->display_name;
				$text_to_display = $is_deleted ? ( '<div class="imm-chat__message__text--is-deleted">' . $receiver_delete_message . $user_to_display . '</div>' ) : ( $text . $attachments );

				$html .= '
					<div class="imm-chat__message">
						<div class="imm-chat__message__content">
							<div class="imm-chat__message__user">
								<img class="imm-chat__message__avatar" src="' . esc_attr( $opponent_avatar_url ) . '">
							</div>

							<div class="ldpm-chat-message ldpm-chat-message-opponent imm-chat__message__text">
								<div class="imm-chat__message__text__container">' . $text_to_display . '</div>
							</div>
						</div>
						<div>
							<div class="imm-chat__message__username">
								' . $user_to_display . '
							</div>
							<div class="imm-chat__message__time">
								' . date( $full_date_format, $msg['created_at'] ) . '
							</div>
						</div>
					</div>
				';
			}
		}

		return '<div class="imm-chat__history__items"><div class="imm-chat__history__hidden"></div>' . $html . '</div>';
	}

	/**
	 * @param int $cur_user_id
	 *
	 * @return array
	 */
	protected function get_available_course_ids( int $cur_user_id, int $course_id = 0 ): array {
		$courses        = learndash_get_user_course_access_list( $cur_user_id );
		$course_to_hide = get_option( 'ldpm_specific_courses', [] );

		if ( ! empty( $course_to_hide ) ) {
			$courses = array_filter(
				$courses,
				function ( $course ) use ( $course_to_hide ) {
					return ! in_array( strval( $course ), $course_to_hide, true );
				}
			);
		}

		if ( $this->has_user_role( 'ld_instructor' ) ) {

			if ( empty( $courses ) ) {
				$courses = get_posts(
					[
						'post_type'   => 'sfwd-courses',
						'post_status' => 'publish',
						'fields'      => 'ids',
						'meta_query'  => [
							[
								'key' => '_ld_instructor_ids',
							],
						],
					]
				);
			}

			$courses = array_filter(
				$courses,
				function ( $course ) use ( $cur_user_id ) {
					$extra_instructor_ids = get_post_meta( $course, '_ld_instructor_ids', true );
					$extra_instructor_ids = array_map( 'intval', (array) $extra_instructor_ids );
					$author               = get_post_field( 'post_author', $course );
					return in_array( (int) $cur_user_id, (array) $extra_instructor_ids, true ) || (int) $author === (int) $cur_user_id;
				}
			);
		}

		if ( 0 === $course_id ) {
			return $courses;
		}

		return array_filter(
			$courses,
			function ( $course ) use ( $course_id ) {
				return $course === $course_id;
			}
		);
	}

	/**
	 * @param int $cur_user_id
	 *
	 * @return array
	 */
	protected function get_available_group_ids( int $cur_user_id ): array {
		if ( learndash_is_admin_user( $cur_user_id ) ) {
			$group_ids = learndash_get_groups( true );
		} elseif ( learndash_is_group_leader_user( $cur_user_id ) ) {
			$group_ids = learndash_get_administrators_group_ids( $cur_user_id );
		} else {
			$group_ids = learndash_get_users_group_ids( $cur_user_id );
		}

		if ( $this->has_user_role( 'ld_instructor' ) ) {
			$group_ids = get_posts(
				[
					'fields'         => 'ids',
					'author'         => $cur_user_id,
					'posts_per_page' => -1,
					'post_type'      => 'groups',
					'post_status'    => 'published',
				]
			);
		}

		$groups_to_hide = get_option( 'ldpm_specific_groups', [] );
		if ( ! empty( $groups_to_hide ) ) {
			$group_ids = array_filter(
				$group_ids,
				function ( $group ) use ( $groups_to_hide ) {
					return ! in_array( strval( $group ), $groups_to_hide, true );
				}
			);
		}

		return $group_ids;
	}

	protected function get_members_of_conversation_id( int $conversation_id ) {
		global $wpdb;

		$conversations_table = $wpdb->prefix . 'ldpm_conversations';

		$sql = $wpdb->prepare(
			"SELECT  entity_id, `type`, limited_to_user_id FROM {$conversations_table} WHERE id = %d",
			$conversation_id
		);

		$data = $wpdb->get_row( $sql, ARRAY_A );

		$members = $this->get_available_member_ids( $data['type'], $data['entity_id'] );

		$admin_ids = get_users(
			[
				'role__in' => [ 'administrator' ],
				'fields'   => 'ID',
			]
		);

		if ( get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' ) && self::CHAT_TYPE_COURSE === $data['type'] ) {

			if ( in_array( $data['limited_to_user_id'], array_values( $members ), true ) ) {
				return [ $data['limited_to_user_id'] ];
			}

			return $admin_ids;
		}

		if ( self::CHAT_TYPE_GROUP === $data['type'] ) {
			$group_admins = array_filter(
				$admin_ids,
				function ( $admin_id ) use ( $data ) {
					$groups_ids = learndash_get_administrators_group_ids( $admin_id );
					return ! in_array( $data['entity_id'], $groups_ids, true );
				}
			);

			$members = array_merge( $members, $group_admins );
		}

		return $members;
	}

	/**
	 * @param string|null $chat_type
	 * @param int         $chat_entity_id
	 *
	 * @return array
	 */
	protected function get_available_member_ids( ?string $chat_type, int $chat_entity_id ): array {
		$admin_ids = get_users(
			[
				'role__in' => [ 'administrator' ],
				'fields'   => 'ID',
			]
		);

		if ( get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' ) ) {
			if ( self::CHAT_TYPE_GROUP === $chat_type ) {
				$user_ids = learndash_get_groups_user_ids( $chat_entity_id );
			} elseif ( self::CHAT_TYPE_COURSE === $chat_type ) {
				if ( $this->has_user_role( 'group_leader' ) || learndash_is_group_leader_user( get_current_user_id() ) ) {
					$groups   = learndash_get_course_groups( $chat_entity_id );
					$user_ids = [];
					foreach ( $groups as $group_id ) {
						$user_ids = array_merge( $user_ids, learndash_get_groups_user_ids( $group_id ) );
					}
					$user_ids = array_unique( $user_ids );
					$user_ids = array_diff( $user_ids, [ get_current_user_id() ] );

					$user_ids = array_filter(
						$user_ids,
						function ( $user_id ) use ( $chat_entity_id ) {
							return learndash_check_group_leader_course_user_intersect( get_current_user_id(), $user_id, $chat_entity_id );
						}
					);
				} else {
					$users_for_course = learndash_get_users_for_course( $chat_entity_id, [ 'fields' => 'ID' ] );
					$user_ids         = is_a( $users_for_course, WP_User_Query::class ) ? $users_for_course->get_results() : [];
				}
			}

			return array_diff( $user_ids, [ get_current_user_id() ] );
		}

		if ( empty( $chat_type ) ) {
			// This will get ALL the user_ids that have the setting Learndash_Private_Message_User_Settings::HIDE_FROM_MEMBERS_LIST_CHAT enabled.
			$excluded_ids = Learndash_Private_Message_User_Settings::get_user_ids_by_setting_name( Learndash_Private_Message_User_Settings::HIDE_FROM_MEMBERS_LIST_CHAT, true );

			$user_ids = array_merge(
				$admin_ids,
				get_users(
					[
						'role__not_in' => [ 'administrator' ],
						'fields'       => 'ID',
					]
				)
			);

			// This will hide ONLY if the current user is NOT an Admin.
			if ( ! current_user_can( 'administrator' ) && ! empty( $excluded_ids ) ) {
				$user_ids = array_values(
					array_filter(
						$user_ids,
						function( $id ) use ( $excluded_ids ) {
							return ! in_array( $id, $excluded_ids, true );
						}
					)
				);
			}
		} elseif ( self::CHAT_TYPE_GROUP === $chat_type ) {
			$user_ids = array_merge(
				$admin_ids,
				learndash_get_groups_administrator_ids( $chat_entity_id ),
				learndash_get_groups_user_ids( $chat_entity_id )
			);
		} elseif ( self::CHAT_TYPE_COURSE === $chat_type ) {
			$group_ids        = learndash_get_course_groups( $chat_entity_id );
			$group_leader_ids = [];

			foreach ( $group_ids as $group_id ) {
				$group_leader_ids = array_merge( $group_leader_ids, learndash_get_groups_administrator_ids( $group_id ) );
			}

			$users_for_course = learndash_get_users_for_course( $chat_entity_id, [ 'fields' => 'ID' ] );
			$student_ids      = is_a( $users_for_course, WP_User_Query::class ) ? $users_for_course->get_results() : [];

			$user_ids = array_merge( $admin_ids, $group_leader_ids, $student_ids );
		} elseif ( self::CHAT_TYPE_PRIVATE === $chat_type ) {
			$user_ids = array_merge(
				[ $chat_entity_id ],
				$admin_ids,
				get_users(
					[
						'role__not_in' => [ 'administrator' ],
						'fields'       => 'ID',
					]
				)
			);
		} elseif ( Learndash_Private_Message_Private_Groups::CHAT_TYPE_PRIVATE_GROUP === $chat_type ) {
			$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
			$user_ids    = $pg_instance->get_members_of_conversation( $chat_entity_id );
			$user_ids    = array_column( $user_ids, 'id' );
		}

		$user_ids = array_diff(
			array_unique( $user_ids ),
			[ get_current_user_id() ]
		);

		return array_values( $user_ids );
	}

	protected function get_conversation_messages( $conversation_id ) {
		global $wpdb;

		$messages_table = $wpdb->prefix . 'ldpm_messages';

		$sql = $wpdb->prepare(
			"SELECT  * FROM {$messages_table} WHERE conversation_id = %d",
			$conversation_id
		);

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	protected function mark_conversation_messages_as_read( $conversation_id, $chat_type ) {
		global $wpdb;

		$messages_table      = $wpdb->prefix . 'ldpm_messages';
		$read_messages_table = $wpdb->prefix . 'ldpm_read_messages';
		$current_user        = get_current_user_id();

		if ( self::CHAT_TYPE_PRIVATE === $chat_type ) {
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE {$messages_table} SET is_read = 1 WHERE conversation_id = %d AND sender_id != %d",
					$conversation_id,
					$current_user
				)
			);

		} else {
			$wpdb->update(
				$read_messages_table,
				[
					'is_read' => 1,
					'read_at' => current_time( 'mysql' ),
				],
				[
					'conversation_id' => $conversation_id,
					'user_id'         => $current_user,
				],
				[ '%d', '%s' ],
				[ '%d', '%d' ]
			);
		}
	}

	/**
	 * @return array
	 */
	protected function process_files(): array {
		// TODO: process upload errors
		if ( empty( $_FILES['file'] ) ) {
			return [];
		}

		// TODO: make customizable
		$valid_extensions = [
			'jpg',
			'pdf',
			'jpeg',
			'gif',
			'png',
			'doc',
			'docx',
			'xls',
			'xlsx',
			'ppt',
			'pptx',
			'txt',
			'zip',
			'rar',
			'gzip',
		];

		$file_data = wp_check_filetype_and_ext( $_FILES['file'], $_FILES['file']['name'] );

		if ( ! in_array( $file_data['ext'], $valid_extensions ) ) {
			return [];
		}

		// TODO: check mime type

		if ( $_FILES['file']['size'] > wp_max_upload_size() ) {
			return [];
		}

		$upload_result = wp_handle_upload( $_FILES['file'], [ 'test_form' => false ] );

		if ( isset( $upload_result['error'] ) ) {
			return [];
		}

		$file = [
			'name' => $_FILES['file']['name'],
			'path' => parse_url( $upload_result['url'] )['path'],
		];

		return [ $file ];
	}

	protected function current_user_is_student(): bool {
		$cur_user_id = get_current_user_id();

		return ! ( learndash_is_group_leader_user( $cur_user_id ) || learndash_is_admin_user( $cur_user_id ) || $this->has_user_role( 'ld_instructor' ) );
	}

	/**
	 * @param string   $chat_type
	 * @param int      $entity_id
	 * @param int|null $limited_to_user_id
	 *
	 * @return int
	 */
	protected function count_unread_messages( string $chat_type, int $entity_id, $limited_to_user_id ): int {
		$restrict_chats_to_only_students_and_teachers = get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' );

		// If conversation does not exit, nothing to count
		$conversation_id = $this->find_conversation_id( $chat_type, $entity_id, $limited_to_user_id );

		if ( ! $conversation_id ) {
			return 0;
		}

		global $wpdb;

		$messages_table      = $wpdb->prefix . 'ldpm_messages';
		$read_messages_table = $wpdb->prefix . 'ldpm_read_messages';
		$current_user        = get_current_user_id();

		if ( self::CHAT_TYPE_PRIVATE === $chat_type ) {
			$sql = $wpdb->prepare(
				"SELECT count(*) FROM {$messages_table} WHERE conversation_id = %d AND sender_id != %d AND is_read = 0",
				$conversation_id,
				$current_user
			);
		} else {
			$sql = $wpdb->prepare(
				"SELECT count(*) FROM {$read_messages_table} WHERE conversation_id = %d AND `user_id` = %d AND is_read = 0",
				$conversation_id,
				$current_user
			);
		}

		return $wpdb->get_var( $sql );
	}

	/**
	 * @return int|mixed
	 */
	protected function map_limited_to_user_id_param() {
		$chat_type          = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
		$limited_to_user_id = isset( $_POST['limited_to_user_id'] ) ? intval( $_POST['limited_to_user_id'] ) : 0;

		if ( get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' ) and $chat_type !== self::CHAT_TYPE_PRIVATE ) {
			$limited_to_user_id = $this->current_user_is_student() ? get_current_user_id() : $limited_to_user_id;
		}

		return $limited_to_user_id;
	}

	protected function count_unread_messages_for_user( int $user_id ) {
		global $wpdb;

		$messages_table         = $wpdb->prefix . 'ldpm_messages';
		$conversations_table    = $wpdb->prefix . 'ldpm_conversations';
		$read_messages_table    = $wpdb->prefix . 'ldpm_read_messages';
		$private_messages_count = 0;
		$private_conversations  = [];

		if ( ! get_option( 'ldpm_restrict_chats_to_only_students_and_teachers' ) ) {
			$private_messages_count = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT count(*) 
				FROM {$messages_table} AS m
				LEFT JOIN 
					{$conversations_table} AS c ON m.conversation_id = c.id 
				WHERE
					m.is_read = 0 AND 
					m.is_deleted = 0 AND 
					m.sender_id != %d AND
					c.type = %s AND
					(c.entity_id = %d OR c.sender_id = %d)
				",
					$user_id,
					self::CHAT_TYPE_PRIVATE,
					$user_id,
					$user_id
				)
			);

			$private_conversations = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT m.conversation_id, m.sender_id, m.type, m.message
				FROM {$messages_table} AS m
				LEFT JOIN 
					{$conversations_table} AS c ON m.conversation_id = c.id 
				WHERE
					m.is_read = 0 AND 
					m.is_deleted = 0 AND 
					m.sender_id != %d AND
					c.type = %s AND
					(c.entity_id = %d OR c.sender_id = %d)
				LIMIT 5
				",
					$user_id,
					self::CHAT_TYPE_PRIVATE,
					$user_id,
					$user_id
				),
				ARRAY_A
			);

		}

		$unread_messages_count = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT count(*) 
			FROM {$read_messages_table}
			WHERE
				`user_id` = %d
				AND is_read = 0
			",
				$user_id
			)
		);

		$unread_conversations = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT rm.conversation_id, m.sender_id, m.type, m.message
				FROM {$read_messages_table} as rm
				INNER JOIN {$messages_table} as m
				ON rm.message_id = m.id
				WHERE rm.`user_id` = %d
				AND rm.is_read = 0
				LIMIT 5",
				$user_id
			),
			ARRAY_A
		);

		$total_unread_messages_count = $private_messages_count + $unread_messages_count;

		$total_conversations = array_merge( $private_conversations, $unread_conversations );

		$new_conversations = [];

		foreach ( $total_conversations as $conversation ) {

			if ( isset( $new_conversations[ $conversation['conversation_id'] ] ) ) {
				$new_conversations[ $conversation['conversation_id'] ]['messages'] = array_merge( $new_conversations[ $conversation['conversation_id'] ]['messages'], [ $conversation ] );
			} else {
				$new_conversations[ $conversation['conversation_id'] ] = [
					'type'      => $conversation['type'],
					'sender_id' => $conversation['sender_id'],
					'messages'  => array_merge( [], [ $conversation ] ),
				];
			}
		}

		return [
			'count'         => $total_unread_messages_count,
			'conversations' => $new_conversations,
		];
	}

	protected function get_entity_id_from_conversation_id( $conversation_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'ldpm_conversations';
		return $wpdb->get_var( $wpdb->prepare( "SELECT entity_id FROM $table WHERE id = %d", $conversation_id ) );
	}

	public function send_unread_message_reminders() {
		if ( ! get_option( 'ldpm_enable_reminders' ) ) {
			return;
		}

		$twilio_settings = get_option( 'ldpm_twilio_settings' );

		$twilio_client = null;

		if ( ! empty( $twilio_settings['account_sid'] ) && ! empty( $twilio_settings['auth_token'] ) && ! empty( $twilio_settings['from_number'] ) ) {
			$twilio_client = new Client( $twilio_settings['account_sid'], $twilio_settings['auth_token'] );
		}

		$notification_email_settings = get_option( 'ldpm_notification_email' );

		$chat_page = untrailingslashit( get_option( 'siteurl' ) ) . '/' . trim( get_option( 'ldpm_chat_link_page' ), '/' );

		$tokens = [
			'{site_name}' => get_option( 'blogname' ),
			'{site_link}' => get_option( 'siteurl' ),
			'{chat_page}' => $chat_page,
		];

		/** @var WP_User[] $users */
		$users                  = get_users();
		$archive                = Learndash_Private_Message_Sent_Email_Archive::get_instance();
		$private_group_instance = Learndash_Private_Message_Private_Groups::get_instance();

		foreach ( $users as $user ) {
			$unread_messages = $this->count_unread_messages_for_user( $user->ID );

			if ( 0 === $unread_messages['count'] ) {
				continue;
			}

			if ( $archive->exists( $user->ID ) ) {
				continue;
			}

			$tokens['{user_name}'] = $user->display_name;
			$tokens['{total}']     = $unread_messages['count'];

			// Send email

			$subject = strtr( $notification_email_settings['subject'], $tokens );
			$body    = strtr( $notification_email_settings['body'], $tokens );

			if ( get_option( 'ldpm_include_conversation_links', 0 ) ) {

				$conversations_details = '';
				foreach ( $unread_messages['conversations'] as $conversation_id => $conversation ) {

					$tokens_conversation_link = [
						'{chat_page}'         => "{$chat_page}?conversation_id={$conversation_id}",
						'{unread_messages}'   => count( $conversation['messages'] ),
						'{conversation_type}' => '',
					];

					if ( self::CHAT_TYPE_PRIVATE === $conversation['type'] ) {
						$sender          = get_userdata( $conversation['sender_id'] );
						$conversation_id = $conversation['sender_id'];
						$tokens_conversation_link['{conversation_type}'] = $sender->data->display_name;
					} elseif ( Learndash_Private_Message_Private_Groups::CHAT_TYPE_PRIVATE_GROUP === $conversation['type'] ) {
						$tokens_conversation_link['{conversation_type}'] = $private_group_instance->get_name( $conversation_id );
					} elseif ( self::CHAT_TYPE_COURSE === $conversation['type'] ) {
						$conversation_id                                 = $this->get_entity_id_from_conversation_id( $conversation_id );
						$tokens_conversation_link['{conversation_type}'] = get_the_title( $conversation_id );
					} elseif ( self::CHAT_TYPE_GROUP === $conversation['type'] ) {
						$conversation_id                                 = $this->get_entity_id_from_conversation_id( $conversation_id );
						$tokens_conversation_link['{conversation_type}'] = get_the_title( $conversation_id );
					}
					$text                   = strtr( $notification_email_settings['conversation_link'], $tokens_conversation_link );
					$conversations_details .= "\n{$text}\n";
				}

				$body = $body . "\n" . $conversations_details;
			}

			wp_mail( $user->user_email, $subject, $body );

			// Send sms

			$phone = get_user_meta( $user->ID, 'phone', true );

			if ( $twilio_client && ! empty( $phone ) ) {
				try {
					$twilio_client->messages->create(
						$phone,
						[
							'from' => $twilio_settings['from_number'],
							'body' => strtr( get_option( 'ldpm_notification_text' ), $tokens ),
						]
					);
				} catch ( \Exception $e ) {
				}
			}

			$archive->create( $user->ID );

		}
	}

	/**
	 * @param string|null $type
	 *
	 * @return bool
	 */
	private function is_valid_chat_type( ?string $type ): bool {
		return in_array( $type, [ self::CHAT_TYPE_GROUP, self::CHAT_TYPE_COURSE, self::CHAT_TYPE_PRIVATE, Learndash_Private_Message_Private_Groups::CHAT_TYPE_PRIVATE_GROUP ], true );
	}

	public function update_settings() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$settings_class = new Learndash_Private_Message_User_Settings( get_current_user_id() );
		$option         = isset( $_POST['option'] ) ? sanitize_text_field( wp_unslash( $_POST['option'] ) ) : '';
		$value          = isset( $_POST['value'] ) ? sanitize_text_field( wp_unslash( $_POST['value'] ) ) : 'false';
		$value          = 'true' === $value;
		$settings_class->update_setting( $option, $value );
	}

	public function create_private_group() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$name        = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : null;
		$invited_ids = isset( $_POST['invited_ids'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['invited_ids'] ) ) ) : [];

		if ( is_null( $name ) ) {
			wp_send_json_error( "Name can't be empty" );
		}

		if ( get_option( 'ldpm_enable_anonymous_users', 0 ) ) {
			wp_send_json_error( 'Not allowed' );
		}

		if ( ! current_user_can( 'administrator' ) ) {
			if ( ! get_option( 'ldpm_allow_create_private_chat_groups', 0 ) ) {
				wp_send_json_error( 'Not allowed' );
			}
		}

		$current_user = get_current_user_id();

		$pg_instance     = Learndash_Private_Message_Private_Groups::get_instance();
		$conversation_id = $pg_instance->create_conversation( $current_user, $name, $invited_ids );

		wp_send_json_success( $conversation_id );
	}

	public function invite_members_to_private_groups() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['conversation_id'] ) ) : null;
		$invited_ids     = isset( $_POST['invited_ids'] ) ? sanitize_text_field( wp_unslash( $_POST['invited_ids'] ) ) : [];

		if ( is_null( $conversation_id ) || empty( $invited_ids ) ) {
			wp_send_json_error();
		}

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
		$pg_instance->invite_members_to_private_groups( $conversation_id, $invited_ids );

		wp_send_json_success();
	}

	public function respond_to_invitation() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['conversation_id'] ) ) : null;
		$response        = isset( $_POST['response'] ) ? sanitize_text_field( wp_unslash( $_POST['response'] ) ) : 'false';
		$response        = 'true' === $response;

		if ( is_null( $conversation_id ) ) {
			wp_send_json_error();
		}

		$current_user_id = get_current_user_id();

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
		$pg_instance->respond_invitation( $conversation_id, $current_user_id, $response );

		wp_send_json_success();
	}

	public function leave_private_group() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['conversation_id'] ) ) : null;

		if ( is_null( $conversation_id ) ) {
			wp_send_json_error();
		}

		$current_user_id = get_current_user_id();

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
		$pg_instance->leave_private_group( $conversation_id, $current_user_id );

		wp_send_json_success();
	}

	public function delete_private_group() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['conversation_id'] ) ) : null;

		if ( is_null( $conversation_id ) ) {
			wp_send_json_error();
		}

		$current_user_id = get_current_user_id();

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();

		$is_leader = $pg_instance->is_group_leader( $current_user_id, $conversation_id );

		if ( $is_leader ) {
			$pg_instance->delete_private_group( $conversation_id );
		}

		wp_send_json_success();
	}

	public function is_group_leader() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['conversation_id'] ) ) : null;

		if ( is_null( $conversation_id ) ) {
			wp_send_json_error();
		}

		$current_user_id = get_current_user_id();

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
		$is_leader   = $pg_instance->is_group_leader( $current_user_id, $conversation_id );

		wp_send_json_success( $is_leader );
	}

	public function get_members_of_conversation() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['conversation_id'] ) ) : null;

		if ( is_null( $conversation_id ) ) {
			wp_send_json_error();
		}

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
		$members     = $pg_instance->get_members_of_conversation( $conversation_id );

		wp_send_json_success( $members );
	}

	public function get_available_members() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$current_user = get_current_user_id();

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
		$members     = $pg_instance->get_available_members( [ $current_user ] );

		wp_send_json_success( $members );
	}

	public function validate_user_invitation() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ldpm_chat' ) ) {
			wp_send_json_error();
		}

		$conversation_id = isset( $_POST['conversation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['conversation_id'] ) ) : null;
		$current_user    = get_current_user_id();

		$pg_instance = Learndash_Private_Message_Private_Groups::get_instance();
		$validation  = $pg_instance->validate_user_invitation( $current_user, $conversation_id );

		wp_send_json_success( $validation );
	}

	private function map_private_group_conversations( $user_id ) {
		$html          = '';
		$pg_instance   = Learndash_Private_Message_Private_Groups::get_instance();
		$conversations = $pg_instance->get_conversations_by_user_id( $user_id );

		if ( 0 === count( $conversations ) ) {
			return $html;
		}

		$html .= '<div class="imm-group">';

		$html .= $this->map_conversation_list_header(
			__( 'Private Groups', 'learndash-private-message' )
		);

		$html .= '<div class="imm-chat-paper imm-group__items">';

		foreach ( $conversations as $conversation ) {
			$html .= '<div class="ldpm-conversation-link imm-group__item" data-type="' . esc_attr( Learndash_Private_Message_Private_Groups::CHAT_TYPE_PRIVATE_GROUP ) . '" data-id="' . esc_attr( $conversation['id'] ) . '">';

			$html .= '<div class="imm-group__item__avatar">' . $conversation['name'][0] . '</div>';

			$html .= '<div class="imm-group__item__info">';

			$html .= '<span class="imm-group__item__name">' . esc_html( $conversation['name'] ) . '</span>';

			if ( is_null( $conversation['is_accepted'] ) ) {
				$html .= '<div class="imm-group__item__notifications">!</div>';
			}

			$html .= '</div>';
			$html .= '</div>';
		}

		$html .= '</div>';

		return $html;
	}

	private function has_user_role( $check_role ) {
		$user = wp_get_current_user();

		if ( in_array( $check_role, (array) $user->roles, true ) ) {
			return true;
		}
		return false;
	}
}
