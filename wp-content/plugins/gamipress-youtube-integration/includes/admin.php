<?php
/**
 * Admin
 *
 * @package GamiPress\Youtube\Admin
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_youtube_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-youtube-integration'] = __( 'Youtube integration', 'gamipress-youtube-integration' );

    return $automatic_updates_plugins;

}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_youtube_automatic_updates' );