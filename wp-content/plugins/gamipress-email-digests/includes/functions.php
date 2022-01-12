<?php
/**
 * Functions
 *
 * @package     GamiPress\Email_Digests\Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register custom cron schedules
 *
 * @since 1.0.0
 *
 * @param array $schedules
 *
 * @return array
 */
function gamipress_email_digests_cron_schedules( $schedules ) {

    $schedules['five_minutes'] = array(
        'interval' => 300,
        'display'  => __( 'Every five minutes', 'gamipress-email-digests' ),
    );

    return $schedules;

}
add_filter( 'cron_schedules', 'gamipress_email_digests_cron_schedules' );

/**
 * WordPress cron checking.
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function gamipress_email_digests_doing_cron() {

    // Bail if not doing WordPress cron (>4.8.0)
    if ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) {
        return true;

        // Bail if not doing WordPress cron (<4.8.0)
    } elseif ( defined( 'DOING_CRON' ) && ( DOING_CRON === true ) ) {
        return true;
    }

    // Default to false
    return false;
}


/**
 * Send the email
 *
 * @since 1.0.0
 *
 * @param  WP_user      $user           User to send email.
 * @param  string       $subject        The subject line of the email to send.
 * @param  string       $message        The body of the email to send.
 *
 * @return bool
 */
function gamipress_email_digests_send_email( $user, $subject, $message ) {

    // parse the pattern tags on subject and content
    $subject = gamipress_email_digests_parse_pattern_tags( $subject, $user->ID );
    $message = gamipress_email_digests_parse_pattern_tags( $message, $user->ID );

    // Execute shortcodes on email content
    $message = do_shortcode( $message );

    // Send email to the user
    gamipress_send_email( $user->user_email, $subject, $message );

}

/**
 * Check the configured email digest to be sent to users.
 *
 * This function is only intended to be used by WordPress cron.
 *
 * To force the use of this function outside cron, set a code like:
 * define( 'DOING_CRON', true );
 * gamipress_email_digests_process_daily_event();
 *
 * @since 1.0.0
 *
 * @param string $date A valid date in Y-m-d format
 */
function gamipress_email_digests_process_daily_event( $date = '' ) {

    global $wpdb;

    // Bail if not doing cron
    if ( ! gamipress_email_digests_doing_cron() ) {
        return;
    }

    if( empty( $date ) ) {
        $date = date( 'Y-m-d' );
    }

    /**
     * Filter the current date to allow use this function with specific dates
     *
     * @since 1.0.0
     *
     * @param string $date  The current date. Format Y-m-d.
     *
     * @return string       Pass it with format Y-m-d.
     */
    $date = apply_filters( 'gamipress_email_digests_process_daily_event_date', $date );
    $time = strtotime( $date );

    // Setup vars
    $prefix = '_gamipress_email_digests_';
    $day = date( 'd', $time );
    $day_of_week = date( 'N', $time );
    $last_day_of_month = date( 't', $time );
    $month = date( 'm', $time );
    $year = date( 'Y', $time );

    // Setup table
    $ct_table = ct_setup_table( 'gamipress_email_digests' );

    // Search all email digests actives and published before current date
    $email_digests = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM {$ct_table->db->table_name} AS ed
        WHERE ed.status = %s
          AND ed.date < %s",
        'active',
        date( 'Y-m-d 00:00:00', $time )
    ) );

    foreach( $email_digests as $email_digest ) {

        // Setup vars
        $email_digest_id = $email_digest->email_digest_id;
        $email_digests_to_send = get_option( 'gamipress_email_digests_to_send', array() );
        $send = false;

        // Avoid to check if already is on our email digests to send array
        if( ! isset( $email_digests_to_send[$email_digest_id] ) ) {

            // get the last time this email digest has been sent
            $last_send_date = gamipress_email_digests_get_last_email_digest_send_date( $email_digest_id );

            if( ! empty( $last_send_date ) && ! empty( $email_digest->subject ) && ! empty( $email_digest->content ) ) {

                $periodicity = ct_get_object_meta( $email_digest_id, $prefix . 'periodicity', true );

                // Calculate the difference between the current date and last send date
                $diff =  (int) abs( $time - strtotime( $last_send_date ) );

                switch( $periodicity ) {
                    // Daily
                    case 'daily':
                        // Send if difference is higher or equal than 1 day
                        if( $diff >= DAY_IN_SECONDS ) {
                            $send = true;
                        }
                        break;
                    // Weekly
                    case 'weekly':
                        // Check if difference is higher or equal than 7 days (1 week)
                        if( $diff >= WEEK_IN_SECONDS ) {

                            $weekly_preference = ct_get_object_meta( $email_digest_id, $prefix . 'weekly_preference', true );

                            // Check if current day of week matches with desired day of week
                            if( absint( $day_of_week ) === absint( $weekly_preference ) ) {
                                $send = true;
                            }
                        }
                        break;
                    // Monthly
                    case 'monthly':
                        // Check if difference is higher or equal than 1 month
                        if( $diff >= MONTH_IN_SECONDS ) {

                            $monthly_preference = ct_get_object_meta( $email_digest_id, $prefix . 'monthly_preference', true );

                            // Set last day of the month as maximum value of this field
                            $monthly_preference = ( absint( $monthly_preference ) > absint( $last_day_of_month ) ? $last_day_of_month : $monthly_preference );

                            // Check if current day matches with desired day
                            if( absint( $day ) === absint( $monthly_preference ) ) {
                                $send = true;
                            }
                        }
                        break;
                    // Yearly
                    case 'yearly':
                        // Check if difference is higher or equal than 1 year
                        if( $diff >= YEAR_IN_SECONDS ) {

                            $yearly_preference = ct_get_object_meta( $email_digest_id, $prefix . 'yearly_preference', true );

                            if( ! empty( $yearly_preference ) ) {

                                // Check if day and month are correctly setup
                                $day_preference = ( isset( $yearly_preference['day'] ) ? absint( $yearly_preference['day'] ) : 0 );
                                $month_preference = ( isset( $yearly_preference['month'] ) ? absint( $yearly_preference['month'] ) : 0 );

                                // Check if day and month matches with current day and month
                                if( $day_preference === absint( $day ) && $month_preference === absint( $month ) )  {
                                    $send = true;
                                }

                            }
                        }
                        break;

                }

            }

        }

        /**
         * Filter to let external plugins determine if email digest should be sent
         *
         * @since 1.0.0
         *
         * @param bool      $send
         * @param stdClass  $email_digest   The email digest object
         * @param string    $date           Date that email digest will be sent
         *
         * @return bool
         */
        $send = apply_filters( 'gamipress_email_digests_send_email_digest', $send, $email_digest, $date );

        if( $send ) {

            // Append this email digest to being send by the other cron jobs
            $email_digests_to_send[$email_digest_id] = $date;

            // Update email digests to send
            update_option( 'gamipress_email_digests_to_send', $email_digests_to_send );

        }

    }

    // Reset setup table
    ct_reset_setup_table();

}
add_action( 'gamipress_email_digests_daily_cron', 'gamipress_email_digests_process_daily_event' );

/**
 * Check if there is email digest to be sent to users (triggered hourly and every 5 minutes).
 *
 * Email digests are decided by gamipress_email_digests_process_daily_event() function.
 *
 * This function is only intended to be used by WordPress cron.
 *
 * @since 1.0.0
 */
function gamipress_email_digests_process_hourly_event() {

    // Bail if not doing cron
    if ( ! gamipress_email_digests_doing_cron() ) {
        return;
    }

    // Get the current email digest that is being sending
    $email_digest_sending = get_option( 'gamipress_email_digest_sending', array() );

    // Get the emails digest to send
    $email_digests_to_send = get_option( 'gamipress_email_digests_to_send', array() );

    if( empty( $email_digest_sending ) ) {

        foreach( $email_digests_to_send as $email_digest_id => $date ) {

            $email_digest_sending = array(
                'email_digest_id' => $email_digest_id,
                'date' => $date,
                'offset' => 0,
                'users_sent_count' => 0,
                'users_count' => 0,
            );

            // Set the sending email digest the first one
            update_option( 'gamipress_email_digest_sending', $email_digest_sending );

            break;
        }
    }

    if( ! empty( $email_digest_sending ) ) {

        // Setup table
        ct_setup_table( 'gamipress_email_digests' );

        // Setup vars
        $email_digest_id = $email_digest_sending['email_digest_id'];
        $email_digest = ct_get_object( $email_digest_id );
        $date = $email_digest_sending['date'];
        $offset = absint( $email_digest_sending['offset'] );
        $limit = 200;

        // If email digests doesn't exists then stop to send this email
        if( ! $email_digest ) {

            if( isset( $email_digests_to_send[$email_digest_id] ) ) {
                unset( $email_digests_to_send[$email_digest_id] );

                // Update email digests to send without this email digest ID
                update_option( 'gamipress_email_digests_to_send', $email_digests_to_send );
            }

            // Clear email digest sending
            delete_option( 'gamipress_email_digest_sending' );

            ct_reset_setup_table();

            // Bail the function and wait to next call
            return;
        }

        // Get stored users
        $users = gamipress_email_digests_get_users_to_send_email_digest( $email_digest, $date, $offset, $limit );

        foreach( $users as $user ) {

            $send_to_user = true;

            /**
             * Filter to let external plugins determine if email digest should be sent to this user
             *
             * @since 1.0.0
             *
             * @param bool      $send_to_user
             * @param stdClass  $email_digest   The email digest object
             * @param WP_User   $user           The WP User object
             * @param string    $date           Date that email digest will be sent
             *
             * @return bool
             */
            $send_to_user = apply_filters( 'gamipress_email_digests_send_email_digest_to_user', $send_to_user, $email_digest, $user, $date );

            if( $send_to_user ) {
                // Send email to the user
                gamipress_email_digests_send_email( $user, $email_digest->subject, $email_digest->content );

                $email_digest_sending['users_sent_count']++;
            }

        }

        $offset += $limit;

        $users_count = gamipress_email_digests_get_users_to_send_email_digest_count( $email_digest, $date );

        // Check if this process has sent email to all users or not
        if( $users_count > $offset ) {

            // Update email digest offset and users count
            $email_digest_sending['offset'] = $offset;
            $email_digest_sending['users_count'] = $users_count;

            // Set the sending email digest the first one
            update_option( 'gamipress_email_digest_sending', $email_digest_sending );

            // Wait for next function call

        } else {

            $description = sprintf( __( 'Email sent to %d users successfully.', 'gamipress-email-digests' ), $email_digest_sending['users_sent_count'] );

            /**
             * Filter to let external plugins set a custom send description
             *
             * @since 1.0.0
             *
             * @param string    $description
             * @param stdClass  $email_digest   The email digest object
             * @param string    $date           Date that email digest will be sent
             *
             * @return string
             */
            $description = apply_filters( 'gamipress_email_digests_send_email_digest_to_user', $description, $email_digest, $date );

            // Register the email digest send
            gamipress_email_digests_insert_email_digest_send( $email_digest_id, $description, $date );

            if( isset( $email_digests_to_send[$email_digest_id] ) ) {
                unset( $email_digests_to_send[$email_digest_id] );

                // Update email digests to send without this email digest ID
                update_option( 'gamipress_email_digests_to_send', $email_digests_to_send );
            }

            // Clear email digest sending
            delete_option( 'gamipress_email_digest_sending' );

            ct_reset_setup_table();

            // Bail the function and wait to next call
            return;

        }

        ct_reset_setup_table();

    }

}
add_action( 'gamipress_email_digests_five_minutes_cron', 'gamipress_email_digests_process_hourly_event' );
add_action( 'gamipress_email_digests_hourly_cron', 'gamipress_email_digests_process_hourly_event' );

/**
 * Get users that will receive a specific email digest
 *
 * @since 1.0.0
 *
 * @param stdClass  $email_digest   The email digest object
 * @param string    $date           Date that email digest will be sent
 * @param int       $offset
 * @param int       $limit
 *
 * @return array
 */
function gamipress_email_digests_get_users_to_send_email_digest( $email_digest, $date, $offset, $limit ) {

    global $wpdb;

    $from = "{$wpdb->users} AS u ";

    /**
     * Filter to let external plugins determine FROM clause
     *
     * @since 1.0.0
     *
     * @param string    $from           FROM clause
     * @param stdClass  $email_digest   The email digest object
     * @param string    $date           Date that email digest will be sent
     * @param int       $offset
     * @param int       $limit
     *
     * @return string
     */
    $from = apply_filters( 'gamipress_email_digests_get_users_to_send_email_digest_from', $from, $email_digest, $date, $offset, $limit );

    $where = "1=1 ";

    /**
     * Filter to let external plugins determine WHERE clause
     *
     * @since 1.0.0
     *
     * @param string    $where          WHERE clause
     * @param stdClass  $email_digest   The email digest object
     * @param string    $date           Date that email digest will be sent
     * @param int       $offset         SQL query offset (0 if is count query)
     * @param int       $limit          SQL query limit (0 if is count query)
     *
     * @return string
     */
    $where = apply_filters( 'gamipress_email_digests_get_users_to_send_email_digest_where', $where, $email_digest, $date, $offset, $limit );

    $sql = "SELECT u.* 
            FROM {$from}
            WHERE {$where}
            ORDER BY u.ID ASC 
            LIMIT {$offset}, {$limit}";

    /**
     * Filter to let external plugins determine which users should receive the email
     *
     * @since 1.0.0
     *
     * @param string    $sql            SQL query
     * @param stdClass  $email_digest   The email digest object
     * @param string    $date           Date that email digest will be sent
     * @param int       $offset         SQL query offset (0 if is count query)
     * @param int       $limit          SQL query limit (0 if is count query)
     *
     * @return string
     */
    $sql = apply_filters( 'gamipress_email_digests_get_users_to_send_email_digest_sql', $sql, $email_digest, $date, $offset, $limit );

    // Get stored users
    return $wpdb->get_results( $sql );

}

/**
 * Get users that will receive a specific email digest
 *
 * @since 1.0.0
 *
 * @param stdClass  $email_digest   The email digest object
 * @param string    $date           Date that email digest will be sent
 *
 * @return int
 */
function gamipress_email_digests_get_users_to_send_email_digest_count( $email_digest, $date ) {

    global $wpdb;

    $from = "{$wpdb->users} AS u ";

    /**
     * Filter to let external plugins determine FROM clause
     *
     * @since 1.0.0
     *
     * @param string    $from           FROM clause
     * @param stdClass  $email_digest   The email digest object
     * @param string    $date           Date that email digest will be sent
     * @param int       $offset         SQL query offset (0 if is count query)
     * @param int       $limit          SQL query limit (0 if is count query)
     *
     * @return string
     */
    $from = apply_filters( 'gamipress_email_digests_get_users_to_send_email_digest_from', $from, $email_digest, $date, 0, 0 );

    $where = "1=1 ";

    /**
     * Filter to let external plugins determine WHERE clause
     *
     * @since 1.0.0
     *
     * @param string    $where          WHERE clause
     * @param stdClass  $email_digest   The email digest object
     * @param string    $date           Date that email digest will be sent
     * @param int       $offset         SQL query offset (0 if is count query)
     * @param int       $limit          SQL query limit (0 if is count query)
     *
     * @return string
     */
    $where = apply_filters( 'gamipress_email_digests_get_users_to_send_email_digest_where', $where, $email_digest, $date, 0, 0 );

    $sql = "SELECT COUNT(*)
            FROM {$from}
            WHERE {$where}
            ORDER BY u.ID ASC";

    /**
     * Filter to let external plugins determine which users should receive the email
     *
     * @since 1.0.0
     *
     * @param string    $sql            SQL query
     * @param stdClass  $email_digest   The email digest object
     * @param string    $date           Date that email digest will be sent
     * @param int       $offset
     * @param int       $limit
     *
     * @return string
     */
    $sql = apply_filters( 'gamipress_email_digests_get_users_to_send_email_digest_sql', $sql, $email_digest, $date, 0, 0 );

    // Get users count
    return absint( $wpdb->get_var( $sql ) );

}