<?php
/**
 * Email Digest Sends
 *
 * @package     GamiPress\Email_Digests\Custom_Tables\Email_Digest_Sends
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Parse query args for email digest sends
 *
 * @since  1.0.0
 *
 * @param string $where
 * @param CT_Query $ct_query
 *
 * @return string
 */
function gamipress_email_digests_email_digest_sends_query_where( $where, $ct_query ) {

    global $ct_table;

    if( $ct_table->name !== 'gamipress_email_digest_sends' ) {
        return $where;
    }

    $table_name = $ct_table->db->table_name;

    // Coupon ID
    if( isset( $ct_query->query_vars['email_digest_id'] ) && absint( $ct_query->query_vars['email_digest_id'] ) !== 0 ) {

        $email_digest_id = $ct_query->query_vars['email_digest_id'];

        if( is_array( $email_digest_id ) ) {
            $email_digest_id = implode( ", ", $email_digest_id );

            $where .= " AND {$table_name}.email_digest_id IN ( {$email_digest_id} )";
        } else {
            $where .= " AND {$table_name}.email_digest_id = {$email_digest_id}";
        }
    }

    return $where;
}
add_filter( 'ct_query_where', 'gamipress_email_digests_email_digest_sends_query_where', 10, 2 );