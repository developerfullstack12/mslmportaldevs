<?php
/**
 * Custom Tables
 *
 * @package     GamiPress\Email_Digests\Custom_Tables
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/custom-tables/email-digests.php';
require_once GAMIPRESS_EMAIL_DIGESTS_DIR . 'includes/custom-tables/email-digest-sends.php';

/**
 * Register all plugin Custom DB Tables
 *
 * @since  1.0.0
 *
 * @return void
 */
function gamipress_email_digests_register_custom_tables() {

    // Email Digests Table
    ct_register_table( 'gamipress_email_digests', array(
        'singular' => __( 'Email Digest', 'gamipress-email-digests' ),
        'plural' => __( 'Email Digests', 'gamipress-email-digests' ),
        'show_ui' => true,
        'version' => 1,
        'global' => gamipress_is_network_wide_active(),
        'supports' => array( 'meta' ),
        'views' => array(
            'list' => array(
                'menu_title' => __( 'Email Digests', 'gamipress-email-digests' ),
                'parent_slug' => 'gamipress'
            ),
            'add' => array(
                'show_in_menu' => false,
            ),
            'edit' => array(
                'show_in_menu' => false,
            ),
        ),
        'schema' => array(
            'email_digest_id' => array(
                'type' => 'bigint',
                'length' => '20',
                'auto_increment' => true,
                'primary_key' => true,
            ),
            'title' => array(
                'type' => 'text',
            ),
            'subject' => array(
                'type' => 'text',
            ),
            'content' => array(
                'type' => 'longtext',
            ),
            'status' => array(
                'type' => 'text',
            ),
            'date' => array(
                'type' => 'datetime',
                'default' => '0000-00-00 00:00:00'
            ),
        ),
    ) );

    // Email Digest Sends Table
    ct_register_table( 'gamipress_email_digest_sends', array(
        'singular' => __( 'Email Digest Send', 'gamipress-email-digests' ),
        'plural' => __( 'Email Digest Sends', 'gamipress-email-digests' ),
        'show_ui' => false,
        'version' => 1,
        'global' => gamipress_is_network_wide_active(),
        'supports' => array( 'meta' ),
        'schema' => array(
            'email_digest_send_id' => array(
                'type' => 'bigint',
                'length' => '20',
                'auto_increment' => true,
                'primary_key' => true,
            ),
            'email_digest_id' => array(
                'type' => 'bigint',
                'length' => '20',
                'key' => true,
            ),

            // Fields

            'description' => array(
                'type' => 'text',
            ),
            'date' => array(
                'type' => 'datetime',
                'default' => '0000-00-00 00:00:00'
            ),
        ),
    ) );

}
add_action( 'ct_init', 'gamipress_email_digests_register_custom_tables' );