<?php
/**
 * API functionality.
 *
 * @since 1.2.0
 */

defined( 'ABSPATH' ) || die;

/**
 * Class LD_GB_API
 *
 * API functionality.
 *
 * @since 1.2.0
 */
class LD_GB_API {

	/**
	 * LD_GB_API constructor.
	 *
	 * @since 1.2.0
	 */
	function __construct() {

		add_filter( 'ld_gb_admin_script_data', array( $this, 'script_data' ) );
		add_filter( 'rest_user_query', array( $this, 'remove_has_published_posts' ), 100, 2 );

		add_action( 'rest_api_init', array( $this, 'add_endpoints' ) );

	}

	/**
	 * Gets the active group ID for the Attendance, if one at all.
	 *
	 * @since 1.2.0
	 * @access private
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	function script_data( $data ) {

		if ( ! isset( $data['l10n'] ) ) $data['l10n'] = array();

		$data['l10n']['nonce'] = wp_create_nonce( 'wp_rest' );
		$data['l10n']['rest'] = trailingslashit( esc_url_raw( rest_url( 'ld-gb/v1' ) ) );
		$data['l10n']['wp_rest'] = trailingslashit( esc_url_raw( rest_url( 'wp/v2' ) ) );

		return $data;
	}

	/**
	 * Removes `has_published_posts` from the query args so even users who have not published content are returned by
	 * the request.
	 *
	 * Silly WordPress...
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_user_query/
	 *
	 * @param array $prepared_args Array of arguments for WP_User_Query.
	 * @param WP_REST_Request $request The current request.
	 *
	 * @return array
	 */
	function remove_has_published_posts( $prepared_args, $request ) {

		if ( $request['has_published_posts'] === 'false' ) {
			unset( $prepared_args['has_published_posts'] );
		}

		return $prepared_args;
	}

	/**
	 * Adds some Rest API endpoints
	 *
	 * @access	public
	 * @since	2.0.0
	 * @return  void
	 */
	public function add_endpoints() {

		register_rest_route( 'ld-gb/v1', '/get-gradebook-data/(?P<gradebook_id>\d+)/(?P<group_id>\d+)', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_gradebook_data' ),
            'permission_callback' => function( $request ) {
                return self::permission_callback_can_view_gradebook( $request );
            }
		) );
		
		register_rest_route( 'ld-gb/v1', '/export-gradebook-component-data/(?P<gradebook_id>\d+)/(?P<group_id>\d+)', array(
            'methods' => 'GET',
            'callback' => array( $this, 'export_gradebook_component_data' ),
            'permission_callback' => function( $request ) {
                return self::permission_callback_can_view_gradebook( $request );
            }
		) );

		register_rest_route( 'ld-gb/v1', '/export-gradebook-all-grades/(?P<gradebook_id>\d+)/(?P<group_id>\d+)', array(
            'methods' => 'GET',
            'callback' => array( $this, 'export_gradebook_all_grades' ),
            'permission_callback' => function( $request ) {
                return self::permission_callback_can_view_gradebook( $request );
            }
		) );

		register_rest_route( 'ld-gb/v1', '/get-frontend-gradebook/(?P<gradebook_id>\d+)/(?P<group_id>\d+)', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_frontend_gradebook' ),
            'permission_callback' => function( $request ) {
                return self::permission_callback_can_view_gradebook( $request );
            }
		) );

		register_rest_route( 'ld-gb/v1', '/get-formatted-gradebook-data/(?P<gradebook_id>\d+)/(?P<group_id>\d+)', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_formatted_gradebook_data' ),
            'permission_callback' => function( $request ) {
                return self::permission_callback_can_view_gradebook( $request );
            }
		) );

		register_rest_route( 'ld-gb/v1', '/get-frontend-user-grades/(?P<user_id>\d+)/(?P<gradebook_id>\d+)/(?P<group_id>\d+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'get_frontend_user_grades' ),
			'permission_callback' => function( $request ) {
				return self::permission_callback_can_view_gradebook( $request );
			}	
		) );
		
		register_rest_route( 'ld-gb/v1', '/add-manual-grade/(?P<user_id>\d+)/(?P<gradebook_id>\d+)/(?P<component_id>\d+)', array(
			'methods' => 'POST',
			'callback' => array( $this, 'add_manual_grade' ),
			'permission_callback' => function( $request ) {
				return self::permission_callback_can_view_gradebook( $request );
			}	
		) );

		register_rest_route( 'ld-gb/v1', '/delete-manual-grade/(?P<user_id>\d+)/(?P<gradebook_id>\d+)/(?P<component_id>\d+)', array(
			'methods' => 'POST',
			'callback' => array( $this, 'delete_manual_grade' ),
			'permission_callback' => function( $request ) {
				return self::permission_callback_can_view_gradebook( $request );
			}	
		) );

		register_rest_route( 'ld-gb/v1', '/edit-grade/(?P<user_id>\d+)/(?P<gradebook_id>\d+)/(?P<component_id>\d+)', array(
			'methods' => 'POST',
			'callback' => array( $this, 'edit_grade' ),
			'permission_callback' => function( $request ) {
				return self::permission_callback_can_view_gradebook( $request );
			}	
		) );

		register_rest_route( 'ld-gb/v1', '/override-component-grade/(?P<user_id>\d+)/(?P<gradebook_id>\d+)/(?P<component_id>\d+)', array(
			'methods' => 'POST',
			'callback' => array( $this, 'override_component_grade' ),
			'permission_callback' => function( $request ) {
				return self::permission_callback_can_view_gradebook( $request );
			}	
		) );

		register_rest_route( 'ld-gb/v1', '/delete-component-override/(?P<user_id>\d+)/(?P<gradebook_id>\d+)/(?P<component_id>\d+)', array(
			'methods' => 'POST',
			'callback' => array( $this, 'delete_component_override' ),
			'permission_callback' => function( $request ) {
				return self::permission_callback_can_view_gradebook( $request );
			}	
		) );

	}

	/**
	 * Adds a simple endpoint to grab the Gradebook Data for a given Gradebook
	 *
     * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function get_gradebook_data( $request ) {

		try {

			$params = wp_parse_args( $_GET, array(
				'per_page' => 30,
			) );

			$data = learndash_gradebook_get_gradebook_data( $request['gradebook_id'], $request['group_id'], $params );

			return new WP_REST_Response( array(
				'gradebook_id' => (int) $request['gradebook_id'],
				'group_id' => (int) $request['group_id'],
				'grades' => isset( $data['grades'] ) ? $data['grades'] : array(),
				'components' => isset( $data['components'] ) ? $data['components'] : array(),
				'total_users' => $data['query']->total_users,
				'total_pages' => ceil( $data['query']->total_users / $params['per_page'] ),
			) );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Adds an endpoint to grab CSV Component Data for a Gradebook
	 * 
	 * This will only return as many results as there are per_page, so you may need to hit this multiple times and merge the results yourself
	 * 
	 * If you've requested a page with no results, a 500 error will be returned
	 *
     * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function export_gradebook_component_data( $request ) {

		try {

			$params = wp_parse_args( $_GET, array(
				'per_page' => 30,
			) );

			$data = learndash_gradebook_get_gradebook_data( $request['gradebook_id'], $request['group_id'], $params );

			if ( ! isset( $data['grades'] ) || empty( $data['grades'] ) ) {

				$message = __( 'No Grades found.', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			if ( ! isset( $data['components'] ) || ! $data['components'] ) $data['components'] = array();

			$csv_headers = array(
				'ID' => __( 'User ID', 'learndash-gradebook' ),
				'display_name' => __( 'Display Name', 'learndash-gradebook' ),
				'first_name' => __( 'First Name', 'learndash-gradebook' ),
				'last_name' => __( 'Last Name', 'learndash-gradebook' ),
				'user_email' => __( 'Email Address', 'learndash-gradebook' ),
				'user_login' => __( 'Username', 'learndash-gradebook' ),
				'grade' => __( 'Overall Grade', 'learndash-gradebook' ),
			);

			foreach ( $data['components'] as $component_id => $component_name ) {
				$csv_headers[ $component_id ] = $component_name;
			}

			$csv_headers = apply_filters( 'ld_gb_export_data_csv_headers', $csv_headers, $data, (int) $request['gradebook_id'], (int) $request['group_id'] );

			$csv_data = array();

			foreach ( $data['grades'] as $index => $row ) {

				$csv_data[ $index ] = array();

				foreach ( $csv_headers as $key => $header ) {

					$csv_data[ $index ][ $header ] = ( isset( $row[ $key ] ) && $row[ $key ] ) ? $row[ $key ] : '';

				}

			}

			$csv_data = array_values( $csv_data );

			$csv_data = apply_filters( 'ld_gb_export_component_data_results', $csv_data, $data, (int) $request['gradebook_id'], (int) $request['group_id'] );

			$csv_data = self::array_to_csv( $csv_data );

			return new WP_REST_Response( array(
				'gradebook_id' => (int) $request['gradebook_id'],
				'group_id' => (int) $request['group_id'],
				'csv_data' => $csv_data,
				'total_users' => $data['query']->total_users,
				'total_pages' => ceil( $data['query']->total_users / $params['per_page'] ),
			) );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Adds an endpoint to grab CSV Data for every Grade in a Gradebook
	 * 
	 * This will only return as many results as there are per_page, so you may need to hit this multiple times and merge the results yourself
	 * 
	 * If you've requested a page with no results, a 500 error will be returned
	 *
     * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function export_gradebook_all_grades( $request ) {

		try {

			$params = wp_parse_args( $_GET, array(
				'per_page' => 30,
			) );

			$data = learndash_gradebook_get_gradebook_data( $request['gradebook_id'], $request['group_id'], $params );

			if ( ! isset( $data['grades'] ) || empty( $data['grades'] ) ) {

				$message = __( 'No Grades found.', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			$csv_data = array();

			$csv_user_headers = array(
				'ID' => __( 'User ID', 'learndash-gradebook' ),
				'display_name' => __( 'Display Name', 'learndash-gradebook' ),
				'first_name' => __( 'First Name', 'learndash-gradebook' ),
				'last_name' => __( 'Last Name', 'learndash-gradebook' ),
				'user_email' => __( 'Email Address', 'learndash-gradebook' ),
				'user_login' => __( 'Username', 'learndash-gradebook' ),
			);

			$csv_grade_headers = array(
				'name' => __( 'Grade Name', 'learndash-gradebook' ),
				'type' => __( 'Grade Type', 'learndash-gradebook' ),
				'score' => __( 'Grade Score', 'learndash-gradebook' ),
				'completed' => __( 'Grade Completion Timestamp', 'learndash-gradebook' ),
				'status' => __( 'Grade Status', 'learndash-gradebook' ),
			);

			$timezone = get_option( 'timezone_string', 'America/Detroit' );

			$timezone_offset = 0;
			if ( strpos( $timezone, '/' ) === false ) {

				$timezone = str_replace( 'UTC-', '', $timezone );

				if ( $timezone ) {
					$timezone_offset = $timezone * HOUR_IN_SECONDS;
				}

			}
			else {

				$dateTimeZone = new DateTimeZone( $timezone );
				$timezone_offset = $dateTimeZone->getOffset( new DateTime( 'now', null ) );

			}

			foreach ( $data['grades'] as $index => $user ) {

				$user_grade = new LD_GB_UserGrade( $user['ID'], $request['gradebook_id'] );

				if ( ! $user_grade->get_components() ) continue;

				foreach ( $user_grade->get_components() as $component ) {

					$row = array();

					foreach ( $component['grades'] as $grade ) {

						// Populate User data per Row
						foreach ( $csv_user_headers as $key => $label ) {

							if ( isset( $user[ $key ] ) && $user[ $key ] ) {
								$row[ $label ] = $user[ $key ];
							}
							else {
								$row[ $label ] = '';
							}
			
						}

						// Populate this Row's Grade data
						foreach ( $csv_grade_headers as $key => $label ) {

							if ( isset( $grade[ $key ] ) && $grade[ $key ] ) {

								if ( $key == 'completed' ) {

									$timestamp = date_i18n( get_option( 'date_format', 'F j, Y' ) . ' @ ' . get_option( 'time_format', 'g:i a' ), $grade['completed'] + $timezone_offset );

									$row[ $label ] = $timestamp;

								}
								else {
									$row[ $label ] = $grade[ $key ];
								}

							}
							else {
								$row[ $label ] = '';
							}
			
						}

						$csv_data = array_merge( $csv_data, array( $row ) );

					}

				}

			}

			$csv_data = array_values( $csv_data );

			$csv_data = apply_filters( 'ld_gb_export_all_grades_results', $csv_data, $data, (int) $request['gradebook_id'], (int) $request['group_id'] );

			/**
			 * If a page would have no results, return nothing for the CSV so that the page gets skipped
			 * This only happens if there are more than per_page Users total and a page of Users has 0 grades entered
			 * 
			 * For instance, if per_page is set to 1 and 3 Users exist for a Gradebook, but only the first User found has any Grades at all, this will allow the second and third pages to still return results and not break the API call
			 */ 
			if ( empty( $csv_data ) ) {

				return new WP_REST_Response( array(
					'gradebook_id' => (int) $request['gradebook_id'],
					'group_id' => (int) $request['group_id'],
					'csv_data' => false,
					'total_users' => $data['query']->total_users,
					'total_pages' => ceil( $data['query']->total_users / $params['per_page'] ),
				) );
				
			}

			$csv_data = self::array_to_csv( $csv_data );

			return new WP_REST_Response( array(
				'gradebook_id' => (int) $request['gradebook_id'],
				'group_id' => (int) $request['group_id'],
				'csv_data' => $csv_data,
				'total_users' => $data['query']->total_users,
				'total_pages' => ceil( $data['query']->total_users / $params['per_page'] ),
			) );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Returns the HTML for the Frontend Gradebook
	 *
     * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function get_frontend_gradebook( $request ) {

		try {

			$params = wp_parse_args( $_GET, array(
				'grade_format' => apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], $request['group_id'] ),
			) );

			ob_start();

			/**
			 * Gradebook Results
			 * On first load, this will be the default Gradebook and Group Combo
			 * This same hook is called when loading a new Gradebook or changing Groups
			 *
			 * @hooked LD_GB_SC_FrontendGradebook::change_gradebook() 10
			 */
			do_action( 'ld_gb_frontend_gradebook_results', (int) $request['gradebook_id'], (int) $request['group_id'], $params['grade_format'] ); 

			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'gradebook_id' => (int) $request['gradebook_id'],
				'group_id' => (int) $request['group_id'],
				'grade_format' => $params['grade_format'],
				'html' => $html,
			) );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Adds a simple endpoint to grab the Gradebook Data for a given Gradebook
	 * This returns the data formatted for the Frontend Gradebook
	 *
     * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function get_formatted_gradebook_data( $request ) {

		try {

			$params = wp_parse_args( $_GET, array(
				'per_page' => 30,
				'grade_format' => apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], $request['group_id'] ),
			) );

			$data = learndash_gradebook_get_gradebook_data( $request['gradebook_id'], $request['group_id'], $params );

			$user_columns = learndash_gradebook_get_user_columns( $request['gradebook_id'], $request['group_id'] );

			$primary_column = 'display_name';
			foreach ( $user_columns as $key => $name ) {
				$primary_column = $key;
				break;
			}

			if ( isset( $data['grades'] ) ) {

				foreach ( $data['grades'] as $user_id => &$user_grade ) {

					if ( is_numeric( $user_grade['grade'] ) ) {

						$user_grade['grade'] = learndash_gradebook_get_grade_display( $user_grade['grade'], $params['grade_format'] );

					}
					else if ( is_bool( $user_grade['grade'] ) && ! $user_grade['grade'] ) {
						
						$user_grade['grade'] = '';

					}

					if ( isset( $data['components'] ) ) {

						foreach ( $data['components'] as $key => $name ) {

							if ( is_numeric( $user_grade[ $key ] ) ) {

								$user_grade[ $key ] = learndash_gradebook_get_grade_display( $user_grade[ $key ], $params['grade_format'] );

							}
							else if ( is_bool( $user_grade[ $key ] ) && ! $user_grade[ $key ] ) {
						
								$user_grade[ $key ] = '';
			
							}

						}

					}

					if ( isset( $user_grade[ $primary_column ] ) ) {

						ob_start();
		
						?>
		
						<a href="#open-edit-panel" class="open-edit-panel" data-user_id="<?php echo esc_attr( $user_id ); ?>" data-gradebook_id="<?php echo esc_attr( $request['gradebook_id'] ); ?>" data-group_id="<?php echo esc_attr( $request['group_id'] ); ?>" data-grade_format="<?php echo esc_attr( $params['grade_format'] ); ?>">
		
						<?php 
		
						$user_grade[ $primary_column ] = ob_get_clean() . $user_grade[ $primary_column ];

						ob_start();

						?>

						</a>

						<div class="hover-link">
							<a href="#open-edit-panel" class="open-edit-panel" data-user_id="<?php echo esc_attr( $user_id ); ?>" data-gradebook_id="<?php echo esc_attr( $request['gradebook_id'] ); ?>" data-group_id="<?php echo esc_attr( $request['group_id'] ); ?>" data-grade_format="<?php echo esc_attr( $params['grade_format'] ); ?>">
								<?php _e( 'View/Edit User Grades', 'learndash-gradebook' ); ?>
							</a>
						</div>

						<?php

						$user_grade[ $primary_column ] .= ob_get_clean();
		
					}

				}

			}

			/**
			 * If you're overriding frontend-gradebook/table-row.php, you'll likely need to adjust this as well for any subsequently loaded pages
			 *
			 * @var 	array
			 * @since	2.0.0
			 */
			$data = apply_filters( 'ld_gb_get_formatted_gradebook_data', $data, (int) $request['gradebook_id'], (int) $request['group_id'], $params );

			return new WP_REST_Response( array(
				'gradebook_id' => (int) $request['gradebook_id'],
				'group_id' => (int) $request['group_id'],
				'grades' => isset( $data['grades'] ) ? $data['grades'] : array(),
				'components' => isset( $data['components'] ) ? $data['components'] : array(),
				'total_users' => $data['query']->total_users,
				'total_pages' => ceil( $data['query']->total_users / $params['per_page'] ),
			) );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Returns the HTML for the User Grade Panel
	 *
	 * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function get_frontend_user_grades( $request ) {

		$params = wp_parse_args( $_GET, array(
			'grade_format' => apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], 0 ),
		) );

		try {

			ob_start();

			/**
			 * User Grade Panel
			 *
			 * @hooked LD_GB_SC_FrontendGradebook::edit_panel() 10
			 */
			do_action( 'ld_gb_frontend_gradebook_edit_panel', (int) $request['user_id'], (int) $request['gradebook_id'], (int) $request['group_id'], $params['grade_format'] );

			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'gradebook_id' => (int) $request['gradebook_id'],
				'user_id' => (int) $request['user_id'],
				'grade_format' => $params['grade_format'],
				'html' => $html,
			) );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Adds a Manual Grade for a given User+Gradebook+Component
	 *
	 * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function add_manual_grade( $request ) {

		try {

			if ( get_option( 'ld_gb_disable_manual_grades', false ) ) {

				$message = __( 'Manual Grades are disabled', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			if ( ! isset( $_POST['grade'] ) || ! $_POST['grade'] ) {

				$message = __( 'No grade data was passed to the API Endpoint', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			$grade = wp_parse_args( $_POST['grade'], array(
				'score' => 0,
				'name' => '',
				'status' => '',
				'component' => $request['component_id'],
				'gradebook' => $request['gradebook_id'],
				'user_id' => $request['user_id'],
				'type' => 'manual',
			) );
			
			$result = learndash_gradebook_update_manual_grade( $grade, false );

			if ( $result['type'] == 'error' ) {

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $result['error'] );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $result['error'],
					'html' => $html,
				), 500 );
			}

			$grade_format = ( isset( $_POST['grade_format'] ) && $_POST['grade_format'] ? $_POST['grade_format'] : apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], 0 ) );

			$user_row = $this->user_row( $request['user_id'], $request['gradebook_id'], $grade_format );

			$user_grade = new LD_GB_UserGrade( $request['user_id'], $request['gradebook_id'] );

			$edit_panel_user_grade = $this->edit_panel_user_grade( $request['user_id'], $request['gradebook_id'], $user_grade, $grade_format );

			$edit_panel_component_grade = $this->edit_panel_component_grade( $request['user_id'], $request['gradebook_id'], $request['component_id'], $user_grade, $grade_format );

			$edit_panel_grade_row = $this->edit_panel_grade_row( $request['user_id'], $request['gradebook_id'], $request['component_id'], $grade, $user_grade, $grade_format );

			$result['user_row'] = $user_row;
			$result['edit_panel_user_grade'] = $edit_panel_user_grade;
			$result['edit_panel_component_grade'] = $edit_panel_component_grade;
			$result['edit_panel_grade_row'] = $edit_panel_grade_row;

			return new WP_REST_Response( $result );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Deletes a Manual Grade for a given User+Gradebook+Component
	 *
	 * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function delete_manual_grade( $request ) {

		try {

			if ( get_option( 'ld_gb_disable_manual_grades', false ) ) {

				$message = __( 'Manual Grades are disabled', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			if ( ! isset( $_POST['grade'] ) || ! $_POST['grade'] ) {

				$message = __( 'No grade data was passed to the API Endpoint', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();
				
				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			$grade = wp_parse_args( $_POST['grade'], array(
				'name' => '',
				'component' => $request['component_id'],
				'gradebook' => $request['gradebook_id'],
				'user_id' => $request['user_id'],
			) );
			
			$result = learndash_gradebook_delete_manual_grade( $grade );

			if ( $result['type'] == 'error' ) {

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $result['error'] );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $result['error'],
					'html' => $html,
				), 500 );
			}

			$grade_format = ( isset( $_POST['grade_format'] ) && $_POST['grade_format'] ? $_POST['grade_format'] : apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], 0 ) );

			$user_row = $this->user_row( $request['user_id'], $request['gradebook_id'], $grade_format );

			$user_grade = new LD_GB_UserGrade( $request['user_id'], $request['gradebook_id'] );

			$edit_panel_user_grade = $this->edit_panel_user_grade( $request['user_id'], $request['gradebook_id'], $user_grade, $grade_format );

			$edit_panel_component_grade = $this->edit_panel_component_grade( $request['user_id'], $request['gradebook_id'], $request['component_id'], $user_grade, $grade_format );

			ob_start();

			$component = $this->get_component( $user_grade, $request['component_id'] );

			if ( empty( $component['grades'] ) ) {

				/**
				 * Edit Panel No Grades
				 *
				 * @hooked LD_GB_SC_FrontendGradebook::edit_panel_no_grades() 10
				 */
				do_action( 'ld_gb_frontend_gradebook_edit_panel_no_grades', $user_grade, $component, $request['user_id'], $request['gradebook_id'], $grade_format );

			}
			
			$edit_panel_no_grades = ob_get_clean();

			$result['user_row'] = $user_row;
			$result['edit_panel_user_grade'] = $edit_panel_user_grade;
			$result['edit_panel_component_grade'] = $edit_panel_component_grade;
			$result['edit_panel_no_grades'] = $edit_panel_no_grades;

			return new WP_REST_Response( $result );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Edits a Grade for a given User+Gradebook+Component
	 *
	 * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function edit_grade( $request ) {

		try {

			if ( ! isset( $_POST['grade'] ) || ! $_POST['grade'] ) {
			
				$message = __( 'No grade data was passed to the API Endpoint', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();
				
				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			$grade = wp_parse_args( $_POST['grade'], array(
				'score' => 0,
				'name' => '',
				'previous_name' => '',
				'status' => '',
				'component' => $request['component_id'],
				'gradebook' => $request['gradebook_id'],
				'user_id' => $request['user_id'],
				'type' => 'manual',
			) );

			if ( $grade['type'] == 'manual' && get_option( 'ld_gb_disable_manual_grades', false ) ) {
				
				$message = __( 'Manual Grades are disabled', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();
				
				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			if ( $grade['type'] == 'manual' ) {
				$result = learndash_gradebook_update_manual_grade( $grade, true );
			}
			else {
				$result = learndash_gradebook_edit_post_driven_grade( $grade );
			}

			if ( $result['type'] == 'error' ) {

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $result['error'] );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $result['error'],
					'html' => $html,
				), 500 );

			}

			$grade_format = ( isset( $_POST['grade_format'] ) && $_POST['grade_format'] ? $_POST['grade_format'] : apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], 0 ) );

			$user_row = $this->user_row( $request['user_id'], $request['gradebook_id'], $grade_format );

			$user_grade = new LD_GB_UserGrade( $request['user_id'], $request['gradebook_id'] );

			$edit_panel_user_grade = $this->edit_panel_user_grade( $request['user_id'], $request['gradebook_id'], $user_grade, $grade_format );

			$edit_panel_component_grade = $this->edit_panel_component_grade( $request['user_id'], $request['gradebook_id'], $request['component_id'], $user_grade, $grade_format );

			$edit_panel_grade_row = $this->edit_panel_grade_row( $request['user_id'], $request['gradebook_id'], $request['component_id'], $grade, $user_grade, $grade_format );

			$result['user_row'] = $user_row;
			$result['edit_panel_user_grade'] = $edit_panel_user_grade;
			$result['edit_panel_component_grade'] = $edit_panel_component_grade;
			$result['edit_panel_grade_row'] = $edit_panel_grade_row;

			return new WP_REST_Response( $result );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Overrides the Component Grade for a given User within a Gradebook
	 *
	 * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function override_component_grade( $request ) {

		try {

			if ( get_option( 'ld_gb_disable_component_override', false ) ) {

				$message = __( 'Component Grade Overrides are disabled', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			if ( ! isset( $_POST['score'] ) || $_POST['score'] === false ) {

				$message =  __( 'No Component grade data was passed to the API Endpoint', 'learndash-gradebook' );
				
				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();
				
				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}
			
			$result = learndash_gradebook_update_component_grade_override( $request['user_id'], $request['gradebook_id'], $request['component_id'], $_POST['score'] );

			$grade_format = ( isset( $_POST['grade_format'] ) && $_POST['grade_format'] ? $_POST['grade_format'] : apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], 0 ) );

			$user_row = $this->user_row( $request['user_id'], $request['gradebook_id'], $grade_format );

			$user_grade = new LD_GB_UserGrade( $request['user_id'], $request['gradebook_id'] );

			$edit_panel_user_grade = $this->edit_panel_user_grade( $request['user_id'], $request['gradebook_id'], $user_grade, $grade_format );

			$edit_panel_component_grade = $this->edit_panel_component_grade( $request['user_id'], $request['gradebook_id'], $request['component_id'], $user_grade, $grade_format );

			$result['user_row'] = $user_row;
			$result['edit_panel_user_grade'] = $edit_panel_user_grade;
			$result['edit_panel_component_grade'] = $edit_panel_component_grade;

			return new WP_REST_Response( $result );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Deletes a Component Grade Override for a given User within a Gradebook
	 *
	 * @param   array            $request  Params passed to the Request Object
     *
     * @access  public
     * @since   2.0.0
     * @return  WP_REST_Response REST Response
     */
	public function delete_component_override( $request ) {

		try {

			if ( get_option( 'ld_gb_disable_component_override', false ) ) {

				$message = __( 'Component Grade Overrides are disabled', 'learndash-gradebook' );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}

			$result = learndash_gradebook_delete_component_grade_override( $request['user_id'], $request['gradebook_id'], $request['component_id'] );

			if ( is_wp_error( $result ) ) {
				
				$message = implode( ';', $result->get_error_messages() );

				ob_start();
				do_action( 'ld_gb_frontend_gradebook_notice', $message );
				$html = ob_get_clean();

				return new WP_REST_Response( array(
					'message' => $message,
					'html' => $html,
				), 500 );

			}
			else if ( $result === true ) {

				// All overrides were deleted
				$result = array();

			}

			$grade_format = ( isset( $_POST['grade_format'] ) && $_POST['grade_format'] ? $_POST['grade_format'] : apply_filters( 'ld_gb_frontend_gradebook_grade_format', ld_gb_get_option_field( 'grade_display_mode', 'letter' ), $request['gradebook_id'], 0 ) );

			$user_row = $this->user_row( $request['user_id'], $request['gradebook_id'], $grade_format );

			$user_grade = new LD_GB_UserGrade( $request['user_id'], $request['gradebook_id'] );

			$edit_panel_user_grade = $this->edit_panel_user_grade( $request['user_id'], $request['gradebook_id'], $user_grade, $grade_format );

			$edit_panel_component_grade = $this->edit_panel_component_grade( $request['user_id'], $request['gradebook_id'], $request['component_id'], $user_grade, $grade_format );

			$result['user_row'] = $user_row;
			$result['edit_panel_user_grade'] = $edit_panel_user_grade;
			$result['edit_panel_component_grade'] = $edit_panel_component_grade;

			return new WP_REST_Response( $result );

		}
		catch ( Exception $exception ) {

			ob_clean();
			ob_start();
			do_action( 'ld_gb_frontend_gradebook_notice', $exception->getMessage(), 'alert' );
			$html = ob_get_clean();

			return new WP_REST_Response( array(
				'html' => $html,
				'exception' => array(
					'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
				),
			), 500 );

		}

	}

	/**
	 * Returns the Gradebook User Row HTML
	 * Used by many of the API Endpoints, so this is here to DRY it up
	 *
	 * @param   integer  $user_id       WP_User ID
	 * @param   integer  $gradebook_id  WP_Post ID
	 * @param   string   $grade_format  Grade Display Format
	 *
	 * @access	protected
	 * @since	2.0.0
	 * @return  string                  HTML
	 */
	protected function user_row( $user_id, $gradebook_id, $grade_format = 'letter' ) {

		ob_start();

		$user_columns = learndash_gradebook_get_user_columns( $gradebook_id, 0 );

		// Generate Gradebook Data for this user Specifically
		$data = learndash_gradebook_get_gradebook_data( $gradebook_id, 0, array(
			'include' => array( $user_id ),
		) );

		$user_grade = $data['grades'][ $user_id ];

		$components = ld_gb_get_field( 'components', $gradebook_id );

		/**
		 * Gradebook User Row
		 *
		 * @hooked LD_GB_SC_FrontendGradebook::table_row() 10
		 */
		do_action( 'ld_gb_frontend_gradebook_table_row', $user_id, $user_columns, $user_grade, $grade_format, $components, $gradebook_id, 0 );

		$user_row = ob_get_clean();

		return $user_row;

	}

	/**
	 * Returns the Edit Panel User Grade HTML
	 * Used by many of the API Endpoints, so this is here to DRY it up
	 *
	 * @param   integer  $user_id       WP_User ID
	 * @param   integer  $gradebook_id  WP_Post ID
	 * @param   object   $user_grade    LD_GB_UserGrade object
	 * @param   stirng   $grade_format  Grade Display Format
	 *
	 * @access	protected
	 * @since	2.0.0
	 * @return  string                  HTML
	 */
	protected function edit_panel_user_grade( $user_id, $gradebook_id, $user_grade, $grade_format = 'letter' ) {

		ob_start();

		/**
		 * Edit Panel User Overall Grade
		 *
		 * @hooked LD_GB_SC_FrontendGradebook::table_row() 10
		 */
		do_action( 'lb_gb_frontend_gradebook_edit_panel_user_grade', $user_id, $gradebook_id, $user_grade, $grade_format );

		$edit_panel_user_grade = ob_get_clean();

		return $edit_panel_user_grade;

	}

	/**
	 * Returns the Edit Panel Component Grade HTML
	 * Used by many of the API Endpoints, so this is here to DRY it up
	 *
	 * @param   integer  $user_id       WP_User ID
	 * @param   integer  $gradebook_id  WP_Post ID
	 * @param   integer  $component_id  Component Index
	 * @param   object   $user_grade    LD_GB_UserGrade Object
	 * @param   string   $grade_format  Grade Display Format
	 *
	 * @access	protected
	 * @since	2.0.0
	 * @return  string                  HTML
	 */
	protected function edit_panel_component_grade( $user_id, $gradebook_id, $component_id, $user_grade, $grade_format = 'letter' ) {

		ob_start();

		$component = $this->get_component( $user_grade, $component_id );

		/**
		 * Edit Panel Component Grade
		 *
		 * @hooked LD_GB_SC_FrontendGradebook::edit_panel_component_grade() 10
		 */
		do_action( 'ld_gb_frontend_gradebook_edit_panel_component_grade', $component, $grade_format, $user_id, $gradebook_id );

		$edit_panel_component_grade = ob_get_clean();

		return $edit_panel_component_grade;

	}

	/**
	 * Edit Panel Grade Row
	 * Used by many of the API Endpoints, so this is here to DRY it up
	 *
	 * @param   integer  $user_id       WP_User ID
	 * @param   integer  $gradebook_id  WP_Post ID
	 * @param   integer  $component_id  Component Index
	 * @param   array    $grade         Grade Data Array passed to the Endpoint
	 * @param   object   $user_grade    LD_GB_UserGrade Object
	 * @param   string   $grade_format  Grade Display Format
	 *
	 * @access	protected
	 * @since	2.0.0
	 * @return  string                  HTML
	 */
	protected function edit_panel_grade_row( $user_id, $gradebook_id, $component_id, $grade, $user_grade, $grade_format = 'letter' ) {

		$component = $this->get_component( $user_grade, $component_id );

		// Get the latest Grade data
		$found = false;
		foreach ( $component['grades'] as $component_grade ) {

			if ( $grade['type'] == 'manual' ) {
				if ( $grade['name'] == $component_grade['name'] ) $found = true;
			}
			else {
				if ( $grade['post_id'] == $component_grade['post_id'] ) $found = true;
			}

			if ( $found ) {
				$grade = $component_grade;
				break;
			}

		}

		ob_start();

		/**
		 * Edit Panel Grade Row
		 *
		 * @hooked LD_GB_SC_FrontendGradebook::edit_panel_grade_row() 10
		 */
		do_action( 'ld_gb_frontend_gradebook_edit_panel_grade_row', $grade, $user_grade, $component, $user_id, $gradebook_id, $grade_format );
		
		$edit_panel_grade_row = ob_get_clean();

		return $edit_panel_grade_row;

	}

	/**
	 * Gets Component Data from a User Grade by Index
	 *
	 * @param   object  $user_grade    LD_GB_UserGrade Object
	 * @param   array   $component_id  Component Index
	 *
	 * @access	protected
	 * @since	2.0.0
	 * @return  array                  Component Data
	 */
	protected function get_component( $user_grade, $component_id ) {

		$components = $user_grade->get_components();

		$component = array();
		foreach ( $components as $component ) {
			if ( $component['id'] == $component_id ) break;
		}

		return $component;

	}

	/**
	 * Converts an Array of associative Arrays to CSV
	 * Each interior associative Array is equivalent to one row of the CSV
	 * Array Keys in the first Array are used for the first row of the CSV
	 *
	 * @param   array  	$array      Array of associative Arrays
	 * @param   string  $separator  CSV separator
	 * @param   string  $delimiter  String delimiter
	 *
	 * @access	protected
	 * @since	2.0.0
	 * @return  string              CSV
	 */
	public static function array_to_csv( $array, $separator = ',', $delimiter = '"' ) {

		// No rows provided, bail
		if ( ! isset( $array[0] ) || ! $array[0] ) return false;

		$csv = '';

		$csv .= self::get_csv_line( array_keys( $array[0] ), $separator, $delimiter );

		foreach ( $array as $row ) {

			$csv .= self::get_csv_line( $row, $separator, $delimiter );

		}

		$csv = rtrim( $csv, "\n" );

		return $csv;

	}

	/**
	 * Not only does PHP require you to create a file pointer to convert an Array to CSV, but you have to do it line by line. Strangely limiting.
	 *
	 * @param   array  	$line_array  Array of CSV line values
	 * @param   string  $separator   CSV separator
	 * @param   string  $delimiter 	 String delimiter
	 *
	 * @access	protected
	 * @since	2.0.0
	 * @return  string               CSV Line
	 */
	public static function get_csv_line( $line_array, $separator = ',', $delimiter = '"' ) {

		$file_pointer = fopen( 'php://temp', 'r+b' );

		fputcsv( $file_pointer, $line_array, $separator, $delimiter );

		rewind( $file_pointer );

		$csv_line = stream_get_contents( $file_pointer );

		fclose( $file_pointer );

		return $csv_line;

	}

	/**
	 * Check if this User can view the requested Gradebook Datap
     *
     * @param   object  $request  WP_REST_Request object
     *
     * @access  public
     * @since   2.0.0
     * @return  boolean           Whether the User has access to this endpoint or not
     */
	public static function permission_callback_can_view_gradebook( $request ) {

		if ( ! current_user_can( 'view_gradebook' ) ) return false;

		// If we're checking against a specific Group and they are not an Admin or a Group Leader for that Group, bail
		if ( ( $request->get_param( 'group_id' ) && $request->get_param( 'group_id' ) != '0' ) && 
			! is_super_admin() && 
			! learndash_gradebook_is_user_group_leader_of_group( $request->get_param( 'group_id' ) ) ) {

			return false;

		}

		return apply_filters( 'learndash_gradebook_api_permission_callback_can_view_gradebook', true, $request );

	}

}