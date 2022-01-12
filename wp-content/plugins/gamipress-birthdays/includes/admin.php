<?php
/**
 * Admin
 *
 * @package GamiPress\Birthdays\Admin
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcut function to get plugin options
 *
 * @since  1.0.0
 *
 * @param string    $option_name
 * @param bool      $default
 *
 * @return mixed
 */
function gamipress_birthdays_get_option( $option_name, $default = false ) {

    $prefix = 'gamipress_birthdays_';

    return gamipress_get_option( $prefix . $option_name, $default );
}

/**
 * GamiPress BuddyBoss Notifications Settings meta boxes
 *
 * @since  1.0.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function gamipress_birthdays_settings_meta_boxes( $meta_boxes ) {

    $prefix = 'gamipress_birthdays_';

    $from_options = array(
        'user_meta' => __( 'User Meta', 'gamipress-birthdays' )
    );

    // BuddyPress
    if ( class_exists( 'BuddyPress' ) ) {
        $from_options['buddypress_field'] = __( 'BuddyPress Profile Field', 'gamipress-birthdays' );
    }

    // BuddyBoss
    if ( defined( 'BP_PLATFORM_VERSION' ) ) {
        $from_options['buddypress_field'] = __( 'BuddyBoss Profile Field', 'gamipress-birthdays' );
    }

    $meta_boxes['gamipress-birthdays-settings'] = array(
        'title' => gamipress_dashicon( 'buddicons-community' ) . __( 'Birthdays', 'gamipress-birthdays' ),
        'fields' => apply_filters( 'gamipress_birthdays_settings_fields', array(
            $prefix . 'from' => array(
                'name' => __( 'From where check the user birthday?', 'gamipress-birthdays' ),
                'type' => 'select',
                'options' => $from_options,
            ),
            $prefix . 'user_meta' => array(
                'name' => __( 'User meta key', 'gamipress-birthdays' ),
                'desc' => __( 'The meta key where the user birthday is stored.', 'gamipress-birthdays' )
                . '<br>' . __( '<strong>Important:</strong> The meta should be stored with a valid date format like YYYY-MM-DD.', 'gamipress-birthdays' ),
                'type' => 'text',
            ),
            $prefix . 'buddypress_field' => array(
                'name' => __( 'Field ID', 'gamipress-birthdays' ),
                'desc' => __( 'The profile field ID. The field ID can be found in the URL when editing a profile field, in the part of the URL that says "&field_id={FIELD_ID}", where {FIELD_ID} is the number that corresponds to the field ID.', 'gamipress-birthdays' )
                    . '<br>' . __( '<strong>Important:</strong> The field needs to be configured with the type "Date" with the date format <strong><code>Y-m-d</code></strong>.', 'gamipress-birthdays' ),
                'type' => 'text',
            ),
        ) ),
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_addons_meta_boxes', 'gamipress_birthdays_settings_meta_boxes' );

/**
 * GamiPress Birthdays Licensing meta box
 *
 * @since  1.0.0
 *
 * @param $meta_boxes
 *
 * @return mixed
 */
function gamipress_birthdays_licenses_meta_boxes( $meta_boxes ) {

    $meta_boxes['gamipress-birthdays-license'] = array(
        'title' => __( 'GamiPress Birthdays', 'gamipress-birthdays' ),
        'fields' => array(
            'gamipress_birthdays_license' => array(
                'name' => __( 'License', 'gamipress-birthdays' ),
                'type' => 'edd_license',
                'file' => GAMIPRESS_BIRTHDAYS_FILE,
                'item_name' => 'Birthdays',
            ),
        )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_licenses_meta_boxes', 'gamipress_birthdays_licenses_meta_boxes' );

/**
 * GamiPress Birthdays automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_birthdays_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-birthdays'] = __( 'Birthdays', 'gamipress-birthdays' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_birthdays_automatic_updates' );