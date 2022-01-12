<?php
/**
 * Email Digests Functions
 *
 * @package     GamiPress\Email_Digests\Email_Digests_Functions
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Get the registered email digests statuses
 *
 * @since  1.0.0
 *
 * @return array Array of email digests statuses
 */
function gamipress_email_digests_get_email_digest_statuses() {

    return apply_filters( 'gamipress_email_digests_get_email_digest_statuses', array(
        'active'    => __( 'Active', 'gamipress-email-digests' ),
        'inactive'  => __( 'Inactive', 'gamipress-email-digests' ),
    ) );

}

/**
 * Get the registered periodicity options
 *
 * @since  1.0.0
 *
 * @return array Array of periodicity options
 */
function gamipress_email_digests_get_periodicity_options() {

    return apply_filters( 'gamipress_email_digests_get_periodicity_options', array(
        'daily'     => __( 'Daily', 'gamipress-email-digests' ),
        'weekly'    => __( 'Weekly', 'gamipress-email-digests' ),
        'monthly'   => __( 'Monthly', 'gamipress-email-digests' ),
        'yearly'    => __( 'Yearly', 'gamipress-email-digests' ),
    ) );

}

/**
 * Get the date that email digest has been sent (falling back to email digest date field)
 *
 * @since  1.0.0
 *
 * @param int       $email_digest_id    The email digest ID
 *
 * @return string                       Last date email digest has been sent in Y-m-d format
 */
function gamipress_email_digests_get_last_email_digest_send_date( $email_digest_id ) {

    $last_send = gamipress_email_digests_get_last_email_digest_send( $email_digest_id );

    if( $last_send ) {
        return date( 'Y-m-d', strtotime( $last_send->date ) );
    }

    ct_setup_table( 'gamipress_email_digests' );

    $email_digest = ct_get_object( $email_digest_id );

    ct_reset_setup_table();

    return date( 'Y-m-d', strtotime( $email_digest->date ) );

}

/**
 * Get the last email digest send
 *
 * @since  1.0.0
 *
 * @param int       $email_digest_id    The email digest ID
 *
 * @return stdClass                     The last email digest send
 */
function gamipress_email_digests_get_last_email_digest_send( $email_digest_id, $output = OBJECT ) {

    ct_setup_table( 'gamipress_email_digest_sends' );

    $ct_query = new CT_Query( array(
        'email_digest_id' => $email_digest_id,
        'orderby' => 'date',
        'order' => 'DESC',
        'items_per_page' => 1
    ) );

    $send = $ct_query->get_results();

    if( is_array( $send ) && isset( $send[0] ) ) {
        $send = $send[0];
    }

    if( $output === ARRAY_N || $output === ARRAY_A ) {
        $send = (array) $send;
    }

    ct_reset_setup_table();

    return $send;

}

/**
 * Get the email digest sends
 *
 * @since  1.0.0
 *
 * @param int       $email_digest_id    The email digest ID
 *
 * @return array                        Array of email digest sends
 */
function gamipress_email_digests_get_email_digest_sends( $email_digest_id, $output = OBJECT ) {

    ct_setup_table( 'gamipress_email_digest_sends' );

    $ct_query = new CT_Query( array(
        'email_digest_id' => $email_digest_id,
        'orderby' => 'date',
        'order' => 'DESC'
    ) );

    $sends = $ct_query->get_results();

    if( $output === ARRAY_N || $output === ARRAY_A ) {

        // Turn array of objects into an array of arrays
        foreach( $sends as $send_index => $send ) {
            $sends[$send_index] = (array) $send;
        }

    }

    ct_reset_setup_table();

    return $sends;

}

/**
 * Inset a email digest send note
 *
 * @since  1.0.0
 *
 * @param integer   $email_digest_id    The email digest ID
 * @param string    $description        The email digest send description
 * @param string    $date               The email digest send date
 *
 * @return bool|integer                 The email digest send ID or false
 */
function gamipress_email_digests_insert_email_digest_send( $email_digest_id, $description, $date = '' ) {

    $ct_table = ct_setup_table( 'gamipress_email_digest_sends' );

    $return = $ct_table->db->insert( array(
        'email_digest_id' => $email_digest_id,
        'description' => $description,
        'date' => date( 'Y-m-d H:i:s', strtotime( $date ) ),
    ) );

    ct_reset_setup_table();

    return $return;

}