<?php
add_filter( 'learndash_data_reports_headers', 'elc_certificate_id_data_reports_headers', 50, 2 );

function elc_certificate_id_data_reports_headers( $data_headers, $data_slug ) {

	if( $data_slug == 'user-courses' ) {

		if( ! isset( $data_headers[ 'certificate_ids' ] ) ) {
			$data_headers[ 'certificate_ids' ] = array(
				'label'   => 'certificate_ids',
				'default' => '',
				'display' => 'elc_certificate_id_custom_reporting_column'
			);
		}
	} else if( $data_slug == 'user-quizzes' ) {

		if( ! isset( $data_headers[ 'certificate_ids' ] ) ) {
			$data_headers[ 'certificate_ids' ] = array(
				'label'   => 'certificate_ids',
				'default' => '',
				'display' => 'elc_certificate_id_custom_reporting_column'
			);
		}
	}

	// Always return $data_headers
	return $data_headers;
}

/**
 * This is an example of a custom reporting column. The function is setup via the 'learndash_data_reports_headers' filter to add the custom report header.
 *
 * @param $column_value The current value of the header. Default is empty ''.
 * @param $column_key string This is the unique column key your assigned when adding the report header via the 'learndash_data_reports_headers' hook.
 * @param $report_item object This is the activity object. This contains some reference information like course_id, course title, lesson_id, lesson_title, etc.
 * @param $report_user object This is the user object associated with the $report_item. For example the user id is $report_user->ID
 *
 * @return $column_value string
 */
function elc_certificate_id_custom_reporting_column( $column_value = '', $column_key, $report_item, $report_user ) {
	switch ( $column_key ) {
		case 'certificate_ids':
			if( $report_user instanceof WP_User ) {
				// Get the user_id.
				$user_id = $report_item->user_id;
				$post_id = $report_item->post_id;
				$post_type = $report_item->post_type;

				if( 'sfwd-courses' === $post_type || 'sfwd-quiz' === $post_type ) {
					// Get usermeta.
					$certificates = get_user_meta( $user_id, 'elc_certificate_ids', true );

					if( $certificates ) {
						// It may contain more than 1, so let's use an array.
						$cids = '';
						$needle = "-$post_id-";
						// Do not use comma as a separator.
						$separator = ' | ';

						foreach( $certificates as $certificate ) {
							$cid = $certificate[ 'cid' ];
							// If cid contains post_id it has a tracked certificate.
							// strpos() is $haystack, $needle.
							if( strpos( $cid, $needle ) !== false ) {
								// This post contains a tracked certificate.
								$cids .= $cid . $separator;
							}
						}
						// Strip off last occurance of separator.
						$column_value = rtrim( $cids, $separator );

					} else {
						$column_value = 'No tracked certificates.';
					}
				}
			}
			break;
	}

	// always return $column_value
	return $column_value;
}
