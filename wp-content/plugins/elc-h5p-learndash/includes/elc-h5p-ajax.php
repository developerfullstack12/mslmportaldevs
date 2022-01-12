<?php
/**
 * @file elc-h5p-ajax.php
 * Created by michaeldajewski on 7/04/19.
 */

/**
 * Helper function to get from xapi the content id - if defined.
 *
 * @param  array $data xapi passed from H5P event
 * @return int|void    content id
 */
function elc_get_content_id( array $data ) {
	return $data[ 'object' ][ 'definition' ][ 'extensions' ][ 'http://h5p.org/x-api/h5p-local-content-id' ];
}

/**
 * Helper function.
 * Find in post content all h5p shortcodes and if they they have
 * corresponding 'elc_h5p_save_success_' meta_key.
 * If any of corresponding 'elc_h5p_save_success_' is 0 - meaning user failed,
 * return false. (Do not enable buttons).
 *
 * IMPORTANT:
 * @SEE: learndash_fetch_quiz_questions filter in
 *       wp-content/plugins/sfwd-lms/includes/lib/wp-pro-quiz/lib/model/WpProQuiz_Model_QuestionMapper.php:236
 *
 * @param $post_id
 * @param $user_id
 * @return bool
 */
function elc_multiple_h5p_pass( $post_id, $content_id, $user_id ) {
	if( get_post_type( $post_id ) === 'sfwd-quiz' && ! elc_is_h5p_id_match( $post_id, $content_id ) ) {
		$questions = elc_h5p_get_quiz_questions_by_post_id( $post_id );

		foreach( $questions as $q ) {
			$q_post_id = $q->getQuestionPostId();
			$q_content = get_post_field( 'post_content', $q_post_id, 'raw' );
			// Get shortcode arguments for H5P shortcodes.

			$shortcode_args[ 'h5p' ] = isset( $shortcode_args[ 'h5p' ] ) ? array_merge(
				$shortcode_args[ 'h5p' ],
				elc_get_shortcode_args( $q_content, array( 'h5p' ) )
			) : elc_get_shortcode_args( $q_content, array( 'h5p' ) );
			// Get shortcode arguments for elc_h5p shortcodes.
			$shortcode_args[ 'elc_h5p' ] = isset( $shortcode_args[ 'h5p' ] ) ? array_merge(
				$shortcode_args[ 'elc_h5p' ],
				elc_get_shortcode_args( $q_content, array( 'elc_h5p' ) )
			) : elc_get_shortcode_args( $q_content, array( 'elc_h5p' ) );
		}
	} else {
		// Get post content.
		$post_content = get_post_field( 'post_content', $post_id, 'raw' );
		// Get shortcode arguments for H5P shortcodes.
		$shortcode_args[ 'h5p' ] = elc_get_shortcode_args( $post_content, array( 'h5p' ) );
		// Get shortcode arguments for elc_h5p shortcodes.
		$shortcode_args[ 'elc_h5p' ] = elc_get_shortcode_args( $post_content, array( 'elc_h5p' ) );
	}

	$b_enable = true;

	foreach( $shortcode_args[ 'h5p' ] as $key => $value ) {
		$content_id = $value[ 'id' ];
		$ignore = elc_h5p_ignore( $shortcode_args[ 'elc_h5p' ], $content_id );

		if( ! $ignore ) {
			$settings = elc_get_h5p_content_settings( $content_id );
			if( ! is_null( $settings ) ) {
				$lib_name = elc_get_h5p_library_name( $settings );
				// Chek if the library is on the white_list.
				if( in_array( $lib_name, ELC_H5PLD_WHITE_LIST ) ) {
					// We process the h5p shortcode, otherwise we do nothing.
					$elc_h5p_save_success_meta = (bool)get_user_meta( $user_id, 'elc_h5p_save_success_' . $content_id, true );
					$b_enable = $b_enable && $elc_h5p_save_success_meta;
					if( ! $b_enable ) break;
				}
			}
		}
	}

	return $b_enable;
}

/**
 * Sanitize quiz question.
 * Requires the answer type to be Assessment.
 * Allow:
 * - only one h5p shortcode
 * - only one answer
 *
 * @param WpProQuiz_Model_Question $q
 * @param integer $content_points H5P content score max points.
 * @param string $answer_translated_text Translated text string to be inserted at the beginning of LD Question Answer.
 * @return WpProQuiz_Model_Question
 */
function elc_h5p_sanitize_quiz_question( WpProQuiz_Model_Question $q, $content_points, $answer_translated_text ) {
	// For now we allow only one answer in the question.
	$q->setPoints( (int)$content_points );
	$q->setAnswerPointsActivated( true );
	$q->setAnswerPointsDiffModusActivated( true );
	$q->setDisableCorrect( true );

	$q->setMapper( null );

	// We create new answer data object with default settings,
	// and substitute with it the question answer data.
	$ad = new WpProQuiz_Model_AnswerTypes();
	$answer_text = $answer_translated_text . ': { ';

	for( $i = 1; $i <= $content_points; $i++ ) {
		$answer_text .= '[' . $i . '] ';
	}
	$answer_text .= '}';
	$ad->setAnswer( $answer_text ); // 'H5P score'

	$q->setAnswerData( array( $ad ) );

	return $q;
}

/**
 * AJAX callback function.
 * The function saves to user_meta intermittent and/or completion results.
 * Than it sends back AJAX success.
 * Only data necessary to update UI.
 *
 * @SEE: assets/js/elc-h5p-ld.js elcSendAJAX
 * Events are filtered by elcHandleXAPI in order to minimize number of AJAX calls.
 * Process only events where result.completion is true.
 */
function elc_insert_data() {

	check_ajax_referer( 'elc_insert_data', 'nonce' );

	global $wp_query;
	global $pagenow;
	// @SEE: https://wordpress.stackexchange.com/a/170177
	// Must write to database and than get it from database when calling learndash_quiz_submitted hook.
	// This is not that expensive since we do it only once when particular question was updated.
	//
//	global $elc_h5p_updated_questions;
//	$elc_h5p_updated_questions[] = 'asdf';
//	$elc_h5p_updated_questions = array();
	$postid = $wp_query->post->ID;

	// xapi contains event.data.statement - relevant data.
	$xapi = $_REQUEST[ 'xapi' ];
	$data = json_decode( stripslashes( $xapi ), true );

	// Save to user_meta elc_h5p_save_* keys.
	$user_id = get_current_user_id();

	// @SEE: wp-content/plugins/h5p/h5p-php-library/js/h5p-x-api-event.js
	// H5P.XAPIEvent.prototype.setObject
	// There is no getContentId function but above explains statement below.
	$content_id = elc_get_content_id( $data );

	// Get post id.
	$url = wp_get_referer();

	// The Quiz may be embedded (shortcode) in the course/lesson/topic post.
	// The jQuery elcHandleXAPI will add into data the dataQuizMeta.
	if( isset( $data[ 'dataQuizMeta' ][ 'quiz_post_id' ] ) ) {
		$post_id = $data[ 'dataQuizMeta' ][ 'quiz_post_id' ];
	} else {
		$post_id = url_to_postid( $url );
	}

	$post_content = get_post_field( 'post_content', $post_id, 'raw' );

	// Check if post has elc_h5p shortcode
	$shortcode_args[ 'elc_h5p' ] = elc_get_shortcode_args( $post_content, array( 'elc_h5p' ) );

	// If there is elc_h5p shortcode with matching id and has ignore parameter we do nothing.
	$ignore = elc_h5p_ignore( $shortcode_args[ 'elc_h5p' ], $content_id );

	if( $ignore ) {
		wp_die();
	}

	// Set 'elc_h5p_save_success_' to 0 untill we decide if user passed or not.
	// This meta key has to be set in order for us to cleanup history
	// in 'wp_h5p_contents_user_data' table.
	// @SEE: elc_learndash_delete_user_data()
	update_user_meta( $user_id, 'elc_h5p_save_success_' . $content_id, '0' );

	/**
	 * Filters data before it is used.
	 * @SEE: elc-h5p-learndash/assets/js/elc-h5p-ld.js
	 *       var elcSendAJAX.
	 *
	 * The return value is a $data param or empty array.
	 *
	 */
	$data = apply_filters( 'elc_h5p_filter_data', $data );

	if( empty( $data ) ) {
		wp_die();
	}
	$result = $data[ 'result' ];

	// Write to database intermittent results
	update_user_meta( $user_id, 'elc_h5p_save_score_scaled_' . $content_id, $result[ 'score' ][ 'scaled' ] );
	update_user_meta( $user_id, 'elc_h5p_save_score_raw_' . $content_id, $result[ 'score' ][ 'raw' ] );

	$post_type = get_post_type( $post_id );
	if( $post_type === 'sfwd-quiz' ) {
//		$elc_h5p_updated_questions = array();
		$quiz_global_points_delta = 0;
		$ld_quiz_questions_object = LDLMS_Factory_Post::quiz_questions( intval( $post_id ) );
		if( $ld_quiz_questions_object ) {
			$questions = $ld_quiz_questions_object->get_questions( 'pro_objects' );
			foreach( $questions as $q ) {
				if( $q->getAnswerType() === 'assessment_answer' ) {
					$pid = $q->getQuestionPostId();
					if( elc_is_h5p_id_match( $pid, $content_id ) ) {
						$quiz_post_settings = learndash_get_setting( $post_id );
						if( ! is_array( $quiz_post_settings ) ) {
							$quiz_post_settings = array();
						}
						if( ! isset( $quiz_post_settings[ 'passingpercentage' ] ) ) {
							$quiz_post_settings[ 'passingpercentage' ] = 0;
						}
						$passingpercentage = absint( $quiz_post_settings[ 'passingpercentage' ] );
						$content_points = $data[ 'result' ][ 'score' ][ 'max' ];
						$options = elc_h5p_get_options();
						$answer_translated_text = $options[ 'question_label' ];

						$ad = $q->getAnswerData();
						if( $content_points !== $q->getPoints() ||
							! $q->isAnswerPointsActivated() ||
							! $q->isAnswerPointsDiffModusActivated() ||
							! $q->isDisableCorrect() ||
							strpos( $ad[ 0 ]->getAnswer(), $answer_translated_text ) !== 0
						) {
							$quiz_global_points_delta = $content_points - $q->getPoints();
							$q = elc_h5p_sanitize_quiz_question( $q, $content_points, $answer_translated_text );
							$questionMapper = new WpProQuiz_Model_QuestionMapper();
							if( is_a( $questionMapper->save( $q ), 'WpProQuiz_Model_Question' ) ) {

								// @SEE: learndash_proquiz_sync_question_fields( $question_post_id = 0, $question_pro_id = 0 )
								$pro_id = $q->getID();
								learndash_proquiz_sync_question_fields( $pid, $pro_id );
								$b_question_updated = true;

								// If question possible points were changed than
								// we need to adjust it in wp_user_meta _sfwd_quizzes.
								if( $quiz_global_points_delta !== 0 ) {
									$elc_h5p_updated_questions = get_option( '_elc_h5p_updated_questions' );

									$elc_h5p_updated_questions[ $pro_id ] = array(
										'post_id'                  => $q->getQuestionPostId(),
										'quiz_global_points_delta' => $quiz_global_points_delta,
									);//getQuestionPostId
									update_option( '_elc_h5p_updated_questions', $elc_h5p_updated_questions );
								}
							}
						}
					}
				}
			}
		}
	}

	$b_subContentId = isset( $data[ 'object' ][ 'definition' ][ 'extensions' ][ 'http://h5p.org/x-api/h5p-subContentId' ] );
	$b_ending_point = isset( $data[ 'context' ][ 'extensions' ][ 'http://id.tincanapi.com/extension/ending-point' ] );

	if( ! $b_subContentId && ! $b_ending_point ) {
		// Get plugin settings from database.
		$options = get_option( 'elc_h5p_options' );

		// Passing evaluation.
		if( isset( $result[ 'success' ] ) ) {
			$passing_case_msg = 'result.success';
			$pass = $result[ 'success' ];
		} elseif( isset( $result[ 'score' ][ 'scaled' ] ) ) {
			$passing_case_msg = 'result.score.scaled';
			$pass = $result[ 'score' ][ 'scaled' ] > 0; // This one is for Summary, Mark the Words,

			/* Special cases START */
			if( $result[ 'score' ][ 'scaled' ] == 0 ) {
				// InteractiveVideo with FreeTextQuestion interactions.
				// FreeTextQuestion interactions return score.raw equal to 0 (undefined).
				$lib_name = explode( '-', substr(
					$data[ 'context' ][ 'contextActivities' ][ 'category' ][ 0 ][ 'id' ], 29
				) )[ 0 ];
				if( $lib_name == 'InteractiveVideo' ) {
					// Get InteractiveVideo interactions.
					$H5PP = H5P_Plugin::get_instance();
					$content = $H5PP->get_content( $content_id );
					$content_filtered = json_decode( $content[ 'filtered' ], true );
					$content_interactions = $content_filtered[ 'interactiveVideo' ][ 'assets' ][ 'interactions' ];
					$result_score_max = $result[ 'score' ][ 'max' ];
					// Subtract from result.score.max the maxScore of each FreeTextQuestion.
					// If the resulted result.score.max equals 0 set pass to true.
					foreach( $content_interactions as $interaction ) {
						if( strpos( $interaction[ 'action' ][ 'library' ], 'FreeTextQuestion' ) ) {
							$result_score_max -= $interaction[ 'action' ][ 'params' ][ 'maxScore' ];
						}
						if( $result_score_max == 0 ) {
							$pass = true;
						}
					}
					$content_summaries = $content_filtered[ 'interactiveVideo' ][ 'summary' ][ 'task' ][ 'params' ][ 'summaries' ];
					foreach( $content_summaries as $summary ) {
						if( isset( $summary[ 'summary' ] ) ) {
							$result_score_max -= 1;
						}
						if( $result_score_max == 0 ) {
							$pass = true;
						}
					}
				} elseif( $lib_name == 'Summary' ) {
					// Standalone Summary.
					// Summary does not have retry button.
					// If it fails, the user cannot correct the answers
					// and he will be locked forever with 'mark complete' button being disabled.
					if( $result[ 'completion' ] ) {
						$pass = true;
					}
				}
			}
			/* Special cases END */
		} elseif( isset( $result[ 'score' ][ 'raw' ] ) && isset( $result[ 'score' ][ 'max' ] ) &&
			$result[ 'score' ][ 'raw' ] === 0 && $result[ 'score' ][ 'max' ] === 0
		) {
			// Branching Scenario when 'Scoring options' is set to:
			// 'No scoring',
			// or 'Dynamically calculate score from user answers' and there is no content that sets score,
			// or 'Statically set score for each end scenario' and 'default "End scenario" screen'
			// 'Score' is set to 0.
			//
			// Documentation Tool, the completion event the result.score.max and raw is always 0.
			//
			// The plugin must enable the 'Mark complete' button to avoid the loop where the button is diabled for
			// all possible interactions.
			//
			$passing_case_msg = 'NO result.score.scaled';
			$pass = true;
		} else {
			// How did we get here?
			// @TODO: decide what do we do with the $pass true or false.
			$passing_case_msg = 'none';
			$pass = false;
		}

		// Save $pass to database
		update_user_meta( $user_id, 'elc_h5p_save_success_' . $content_id, $pass );

		// Set values for 'elcH5Presponse'.
		$msg_key = $pass ? 'succ_msg' : 'fail_msg';

		// If there are multiple h5p content in the same post we have to verify if all of them passed.
		// Check multiple h5p for logged in users only,
		// since nor H5P or LearnDash or Wordpress can save data in database for anonymous user.
		if( $user_id > 0 ) {
			$b_enable = elc_multiple_h5p_pass( $post_id, $content_id, $user_id );
		} else {
			$b_enable = $pass;
		}

		// If isset($quiz_post_settings) we were evaluating quiz question

		// Build response data to send back.
		$response = array(
			'ldMarkCompleteButtonEnable' => $b_enable,
			'wpProQuizButtonEnable'      => $b_enable,
			'h5pId'                      => $content_id,
			'elcH5Presponse'             => array(
				'text'     => $options[ $msg_key ],
				'cssClass' => $msg_key,
			),
			'elcQuizGPdelta'             => $quiz_global_points_delta,
			'elcQuizPassingPercentage'   => $passingpercentage,
			'answerText'                 => $answer_translated_text,
			'questionUpdated'            => $b_question_updated,
			'score'                      => array(
				'min' => $result[ 'score' ][ 'min' ],
				'max' => $result[ 'score' ][ 'max' ],
				'raw' => $result[ 'score' ][ 'raw' ],
			),
		);

		// Send JSON success.
		//
		wp_send_json_success( $response );
	} else {
		wp_die();
	}
}

/**
 * Register Ajax callback function(s).
 */
add_action( 'wp_ajax_nopriv_elc_insert_data', 'elc_insert_data' );
add_action( 'wp_ajax_elc_insert_data', 'elc_insert_data' );

/**
 * Ajax action callback function.
 */
function elc_clear_h5p_user_data() {
	check_ajax_referer( 'elc_insert_data', 'nonce' );

	global $wpdb;
	$h5pIDs = $_REQUEST[ 'h5pIDs' ];
	$data = implode( ',', json_decode( stripslashes( $h5pIDs ), true ) );

	$user_id = (int)get_current_user_id();

	$sql = "DELETE FROM {$wpdb->prefix}h5p_contents_user_data WHERE user_id = %d AND content_id IN ($data)";
	$query = $wpdb->prepare( $sql, array( $user_id ) );
	$result = $wpdb->get_results( $query );
}

/**
 * Register Ajax callback function(s).
 */
add_action( 'wp_ajax_nopriv_elc_clear_h5p_user_data', 'elc_clear_h5p_user_data' );
add_action( 'wp_ajax_elc_clear_h5p_user_data', 'elc_clear_h5p_user_data' );
