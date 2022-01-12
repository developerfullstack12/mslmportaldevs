<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LearnDash_PowerPack_Hide_Comments_From_Assignments_Essay_On_Dashboard', false ) ) {
	/**
	 * LearnDash_PowerPack_Hide_Comments_From_Assignments_Essay_On_Dashboard Class.
	 */
	class LearnDash_PowerPack_Hide_Comments_From_Assignments_Essay_On_Dashboard {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_action( 'pre_get_comments', [ $this, 'pre_get_comments_func' ], 100 );
			}
		}

		/**
		 * Hide Comments From Assignments.
		 *
		 * @param WPQuery $comment_query The query object for the comments.
		 */
		public function pre_get_comments_func( $comment_query ) {
			$option_active_status = if_current_class_is_active( $this->current_class );

			if ( 'active' !== $option_active_status ) {
				return;
			}

			if ( is_admin() ) {
				$current_screen = get_current_screen();
				if ( 'dashboard' === $current_screen->id ) {
					if ( ! current_user_can( 'moderate_comments' ) ) {
						$post_query_args = [
							'post_type'   => [ 'sfwd-assignment', 'sfwd-essays' ],
							'post_status' => [ 'draft', 'publish', 'graded', 'not_graded' ],
							'fields'      => 'ids',
							'nopaging'    => true,
						];

						$post_query = new WP_Query( $post_query_args );
						if ( ( $post_query instanceof WP_Query ) && ( ! empty( $post_query->posts ) ) ) {
							$post__not_in = [];

							if ( '' === $comment_query->query_vars['post__not_in'] ) {
								$post__not_in = $post_query->posts;
							} else {
								$post__not_in = array_merge( (array) $comment_query->query_vars['post__not_in'], $post_query->posts );
							}

							if ( ! empty( $post__not_in ) ) {
								$comment_query->query_vars['post__not_in'] = $post__not_in;
							}
						}
					}
				}
			}
		}

		/**
		 * Add class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'comment', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Comments options for Assignments and Essay', 'learndash-powerpack' );
			$class_description = esc_html__( 'Enable this option will Hide comments from Assignments and Essay from showing on Dashboard Activity Widget.', 'learndash-powerpack' );

			return [
				'title'       => $class_title,
				'ld_type'     => $ld_type,
				'description' => $class_description,
				'settings'    => false,
			];
		}
	}

	new LearnDash_PowerPack_Hide_Comments_From_Assignments_Essay_On_Dashboard();
}

