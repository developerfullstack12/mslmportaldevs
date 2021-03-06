<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPF_LearnPress extends WPF_Integrations_Base {

	/**
	 * The slug for WP Fusion's module tracking.
	 *
	 * @since 3.38.14
	 * @var string $slug
	 */

	public $slug = 'learnpress';

	/**
	 * The plugin name for WP Fusion's module tracking.
	 *
	 * @since 3.38.14
	 * @var string $name
	 */
	public $name = 'Learnpress';

	/**
	 * The link to the documentation on the WP Fusion website.
	 *
	 * @since 3.38.14
	 * @var string $docs_url
	 */
	public $docs_url = 'https://wpfusion.com/documentation/learning-management/learnpress/';

	/**
	 * Gets things started
	 *
	 * @access  public
	 * @since   1.0
	 * @return  void
	 */

	public function init() {

		add_action( 'learn-press/user-enrolled-course', array( $this, 'user_enrolled_course' ), 10, 3 );
		add_action( 'learn-press/updated-user-item-meta', array( $this, 'updated_user_item_meta' ) );

		add_action( 'learn-press/user-course-finished', array( $this, 'user_finish_course' ), 10, 3 );
		add_action( 'learn-press/user-completed-lesson', array( $this, 'user_complete_lesson' ), 10, 3 );

		// Access control
		add_action( 'learn-press/course-item/is-blocked', array( $this, 'course_item_is_blocked' ), 10, 4 );
		add_filter( 'wpf_redirect_post_id', array( $this, 'redirect_post_id' ) );

		add_action( 'learn-press/course-item-content', array( $this, 'restricted_content_message' ), 10 ); // 10 so it runs before the built in blocked message

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 20, 2 );
		add_action( 'save_post', array( $this, 'save_meta_box_data' ), 20, 2 );

	}

	/**
	 * Applies tags when a user enrolls in a LearnPress course
	 *
	 * @access public
	 * @return void
	 */

	public function user_enrolled_course( $course_id, $user_id, $inserted = false ) {

		$wpf_settings = get_post_meta( $course_id, 'wpf_settings_learnpress', true );

		if ( ! empty( $wpf_settings['apply_tags_start'] ) ) {
			wp_fusion()->user->apply_tags( $wpf_settings['apply_tags_start'], $user_id );
		}

	}


	/**
	 * With the WooCommerce Payment Methods Integration, the
	 * learn-press/user-enrolled-course hook doesn't fire after a purchase, for
	 * some reason, so this is a fallback.
	 *
	 * @since  3.37.30
	 *
	 * @param  array $item   The item
	 */

	public function updated_user_item_meta( $item ) {

		if ( ! empty( $item ) && 'lp_course' == $item->item_type && 'purchased' == $item->status ) {
			$this->user_enrolled_course( $item->item_id, $item->user_id );
		}

	}


	/**
	 * Applies tags when a LearnPress course is completed
	 *
	 * @access public
	 * @return void
	 */

	public function user_finish_course( $course_id, $user_id, $return ) {

		$wpf_settings = get_post_meta( $course_id, 'wpf_settings_learnpress', true );

		if ( ! empty( $wpf_settings['apply_tags_complete'] ) ) {
			wp_fusion()->user->apply_tags( $wpf_settings['apply_tags_complete'], $user_id );
		}

	}

	/**
	 * Applies tags when a LearnPress lesson is completed
	 *
	 * @access public
	 * @return void
	 */

	public function user_complete_lesson( $lesson_id, $result, $user_id ) {

		$wpf_settings = get_post_meta( $lesson_id, 'wpf_settings_learnpress', true );

		if ( ! empty( $wpf_settings['apply_tags_complete'] ) ) {
			wp_fusion()->user->apply_tags( $wpf_settings['apply_tags_complete'], $user_id );
		}

	}

	/**
	 * Can a user access a lesson / other item within a course
	 *
	 * @access public
	 * @return bool Is Blocked
	 */

	public function course_item_is_blocked( $is_blocked, $item_id, $course_id, $user_id ) {

		if ( false == wp_fusion()->access->user_can_access( $item_id, $user_id ) ) {
			$is_blocked = true;
		}

		return $is_blocked;

	}

	/**
	 * Make sure we properly check a lesson's access rules, not the course
	 *
	 * @access public
	 * @return int Post ID
	 */

	public function redirect_post_id( $post_id ) {

		global $post;

		if ( 'lp_course' == $post->post_type ) {

			if ( 'lp_course' != get_query_var( 'item-type' ) ) {

				$post_item = learn_press_get_post_by_name( get_query_var( 'course-item' ), get_query_var( 'item-type' ) );

				if ( $post_item ) {
					$post_id = $post_item->ID;
				}
			}
		}

		return $post_id;

	}

	/**
	 * Restricted content message
	 *
	 * @access public
	 * @return mixed HTML Restricted Content Message
	 */

	public function restricted_content_message() {

		$item = LP_Global::course_item();

		if ( ! wp_fusion()->access->user_can_access( $item->get_id() ) ) {

			// This is messy but what can you do...

			echo '<!-- WP Fusion is hiding the LearnPress protected content message in favor of the WP Fusion restricted content message -->';
			echo '<style type="text/css">.learn-press-content-protected-message { display: none; }</style>';

			echo wp_fusion()->access->get_restricted_content_message( $item->get_id() );

		}

		return;

	}


	/**
	 * Adds meta box
	 *
	 * @access public
	 * @return mixed
	 */

	public function add_meta_box( $post_id, $data ) {

		add_meta_box( 'wpf-learnpress-meta', 'WP Fusion - Course Settings', array( $this, 'meta_box_callback' ), 'lp_course' );
		add_meta_box( 'wpf-learnpress-meta', 'WP Fusion - Lesson Settings', array( $this, 'meta_box_callback_lesson' ), 'lp_lesson' );

	}

	/**
	 * Displays meta box content
	 *
	 * @access public
	 * @return mixed
	 */

	public function meta_box_callback( $post ) {

		wp_nonce_field( 'wpf_meta_box_learnpress', 'wpf_meta_box_learnpress_nonce' );

		$settings = array(
			'apply_tags_start'    => array(),
			'apply_tags_complete' => array(),
		);

		if ( get_post_meta( $post->ID, 'wpf_settings_learnpress', true ) ) {
			$settings = array_merge( $settings, get_post_meta( $post->ID, 'wpf_settings_learnpress', true ) );
		}

		echo '<table class="form-table"><tbody>';

		echo '<tr>';

		echo '<th scope="row"><label for="tag_link">Apply tags when enrolled:</label></th>';
		echo '<td>';

		$args = array(
			'setting'   => $settings['apply_tags_start'],
			'meta_name' => 'wpf_settings_learnpress',
			'field_id'  => 'apply_tags_start',
		);

		wpf_render_tag_multiselect( $args );

		echo '<span class="description">These tags will be applied to the user when they are enrolled in the course.</span>';
		echo '</td>';

		echo '</tr>';

		echo '<tr>';

		echo '<th scope="row"><label for="tag_link">Apply tags when completed:</label></th>';
		echo '<td>';

		$args = array(
			'setting'   => $settings['apply_tags_complete'],
			'meta_name' => 'wpf_settings_learnpress',
			'field_id'  => 'apply_tags_complete',
		);

		wpf_render_tag_multiselect( $args );

		echo '<span class="description">These tags will be applied to the user when they complete the course.</span>';
		echo '</td>';

		echo '</tr>';

		echo '</tbody></table>';

	}

	/**
	 * Displays meta box content (groups)
	 *
	 * @access public
	 * @return mixed
	 */

	public function meta_box_callback_lesson( $post ) {

		wp_nonce_field( 'wpf_meta_box_learnpress', 'wpf_meta_box_learnpress_nonce' );

		$settings = array(
			'apply_tags_start'    => array(),
			'apply_tags_complete' => array(),
		);

		if ( get_post_meta( $post->ID, 'wpf_settings_learnpress', true ) ) {
			$settings = array_merge( $settings, get_post_meta( $post->ID, 'wpf_settings_learnpress', true ) );
		}

		echo '<table class="form-table"><tbody>';

		echo '<tr>';

		echo '<th scope="row"><label for="tag_link">Apply tags when completed:</label></th>';
		echo '<td>';

		$args = array(
			'setting'   => $settings['apply_tags_complete'],
			'meta_name' => 'wpf_settings_learnpress',
			'field_id'  => 'apply_tags_complete',
		);

		wpf_render_tag_multiselect( $args );

		echo '<span class="description">These tags will be applied to the user when they complete the lesson.</span>';
		echo '</td>';

		echo '</tr>';

		echo '</tbody></table>';

	}

	/**
	 * Runs when WPF meta box is saved
	 *
	 * @access public
	 * @return void
	 */

	public function save_meta_box_data( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpf_meta_box_learnpress_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['wpf_meta_box_learnpress_nonce'], 'wpf_meta_box_learnpress' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Don't update on revisions
		if ( $_POST['post_type'] == 'revision' ) {
			return;
		}

		if ( isset( $_POST['wpf_settings_learnpress'] ) ) {
			$data = $_POST['wpf_settings_learnpress'];
		} else {
			$data = array();
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, 'wpf_settings_learnpress', $data );

	}


}

new WPF_LearnPress();
