<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LearnDash_PowerPack_Remove_Video_Progression_Cookie_On_Topic_Completion', false ) ) {
	/**
	 * LearnDash_PowerPack_Remove_Video_Progression_Cookie_On_Topic_Completion Class.
	 */
	class LearnDash_PowerPack_Remove_Video_Progression_Cookie_On_Topic_Completion {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_action( 'learndash_topic_completed', [ $this, 'learndash_topic_completed_func' ] );
			}
		}

		/**
		 * Removes the video cookie on complete.
		 *
		 * @param array $args The arguments array.
		 */
		public function learndash_topic_completed_func( $args = [] ) {
			$option_active_status = if_current_class_is_active( $this->current_class );
			if ( 'active' !== $option_active_status ) {
				return;
			}
			$this->learndash_remove_video_cookie( $args['topic']->ID, $args['course']->ID, $args['user']->ID );
		}

		/**
		 * Removes the video cookie.
		 *
		 * @param int $step_id The ID of the step.
		 * @param int $course_id The ID of the course.
		 * @param int $user_id The ID of the user.
		 */
		public function learndash_remove_video_cookie( $step_id = 0, $course_id = 0, $user_id = 0 ) {
			if ( ( ! empty( $step_id ) ) && ( ! empty( $course_id ) ) && ( ! empty( $user_id ) ) ) {
				$step_settings = learndash_get_setting( $step_id );
				if ( ( isset( $step_settings['lesson_video_enabled'] ) ) && ( 'on' === $step_settings['lesson_video_enabled'] ) ) {
					if ( ( isset( $step_settings['lesson_video_url'] ) ) && ( ! empty( $step_settings['lesson_video_url'] ) ) ) {
						$step_settings['lesson_video_url'] = trim( $step_settings['lesson_video_url'] );
						$step_settings['lesson_video_url'] = html_entity_decode( $step_settings['lesson_video_url'] );

						$video_data = [];

						if ( ( strpos( $step_settings['lesson_video_url'], 'youtu.be' ) !== false ) || ( strpos( $step_settings['lesson_video_url'], 'youtube.com' ) !== false ) ) {
							$video_data['videos_found_provider'] = 'youtube';
						} elseif ( strpos( $step_settings['lesson_video_url'], 'vimeo.com' ) !== false ) {
							$video_data['videos_found_provider'] = 'vimeo';
						} elseif ( ( strpos( $step_settings['lesson_video_url'], 'wistia.com' ) !== false ) || ( strpos( $step_settings['lesson_video_url'], 'wistia.net' ) !== false ) ) {
							$video_data['videos_found_provider'] = 'wistia';
						} elseif ( strpos( $step_settings['lesson_video_url'], 'amazonaws.com' ) !== false ) {
							$video_data['videos_found_provider'] = 'local';
						} elseif ( ( strpos( $step_settings['lesson_video_url'], 'vooplayer' ) !== false ) || ( strpos( $step_settings['lesson_video_url'], 'spotlightr.com' ) !== false ) ) {
							$video_data['videos_found_provider'] = 'vooplayer';
						} elseif ( strpos( $step_settings['lesson_video_url'], trailingslashit( get_home_url() ) ) !== false ) {
							$video_data['videos_found_provider'] = 'local';
						}

						if ( ( substr( $step_settings['lesson_video_url'], 0, strlen( 'http://' ) ) == 'http://' ) || ( substr( $step_settings['lesson_video_url'], 0, strlen( 'https://' ) ) == 'https://' ) ) {
							if ( 'local' === $video_data['videos_found_provider'] ) {
								$video_data['videos_found_type']   = 'video_shortcode';
								$step_settings['lesson_video_url'] = '[video src="' . $step_settings['lesson_video_url'] . '"][/video]';
							} elseif ( ( 'youtube' === $video_data['videos_found_provider'] ) || ( 'vimeo' === $video_data['videos_found_provider'] ) ) {
								$video_data['videos_found_type']   = 'embed_shortcode';
								$step_settings['lesson_video_url'] = '[embed]' . $step_settings['lesson_video_url'] . '[/embed]';
							} elseif ( 'wistia' === $video_data['videos_found_provider'] ) {
								$video_data['videos_found_type']   = 'embed_shortcode';
								$step_settings['lesson_video_url'] = '[embed]' . $step_settings['lesson_video_url'] . '[/embed]';
							}
						} elseif ( substr( $step_settings['lesson_video_url'], 0, strlen( '[embed' ) ) == '[embed' ) {
							$video_data['videos_found_type'] = 'embed_shortcode';
						} elseif ( substr( $step_settings['lesson_video_url'], 0, strlen( '[video' ) ) == '[video' ) {
							$video_data['videos_found_type'] = 'video_shortcode';
						} elseif ( substr( $step_settings['lesson_video_url'], 0, strlen( '<iframe' ) ) == '<iframe' ) {
							$video_data['videos_found_type'] = 'iframe';
						} else {
							if ( 'vooplayer' === $video_data['videos_found_provider'] ) {
								if ( substr( $step_settings['lesson_video_url'], 0, strlen( '[vooplayer' ) ) == '[vooplayer' ) {
									$video_data['videos_found_type'] = 'vooplayer_shortcode';
								} else {
									$video_data['videos_found_type'] = 'iframe';
								}
							}
						}

						$video_cookie_key  = $user_id . '_' . $course_id . '_' . $step_id;
						$video_cookie_key .= '_' . $step_settings['lesson_video_url'];
						$video_cookie_key  = 'learndash-video-progress-' . md5( $video_cookie_key );

						$video_track_domain = '';
						if ( defined( 'COOKIE_DOMAIN' ) ) {
							$video_track_domain = COOKIE_DOMAIN;
						}

						$video_track_path = '';
						if ( ( is_multisite() ) && ( defined( 'SITECOOKIEPATH' ) ) ) {
							$video_track_path = SITECOOKIEPATH;
						} elseif ( defined( 'COOKIEPATH' ) ) {
							$video_track_path = COOKIEPATH;
						}

						// empty value and expiration one hour before.
						$res = setcookie( $video_cookie_key, '', time() - 3600, $video_track_path, $video_track_domain );
					}
				}
			}
		}

		/**
		 * Add the class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'topic', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Remove Video Progression Cookie on topic Completion', 'learndash-powerpack' );
			$class_description = '';
			$deprecated        = esc_html__( 'Setting Deprecated due the functionality is already on LearnDash Core', 'learndash-powerpack' );
			$deprecated_date   = gmdate( 'Y-m-d', strtotime( '2021-07-29' ) );

			return [
				'title'           => $class_title,
				'ld_type'         => $ld_type,
				'description'     => $class_description,
				'settings'        => false,
				'deprecated'      => $deprecated,
				'deprecated_date' => $deprecated_date,
			];
		}
	}

	new LearnDash_PowerPack_Remove_Video_Progression_Cookie_On_Topic_Completion();
}
