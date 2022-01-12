<?php
/**
 * Admin
 *
 * @package GamiPress\Block_Users\Admin
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
function gamipress_block_users_get_option( $option_name, $default = false ) {

    $prefix = 'gamipress_block_users_';

    return gamipress_get_option( $prefix . $option_name, $default );
}

/**
 * Plugin settings meta boxes
 *
 * @since  1.0.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function gamipress_block_users_settings_meta_boxes( $meta_boxes ) {

    $prefix = 'gamipress_block_users_';

    $meta_boxes['gamipress-block-users-settings'] = array(
        'title' => __( 'Block Users', 'gamipress-block-users' ),
        'fields' => apply_filters( 'gamipress_block_users_settings_fields', array(
            $prefix . 'blocked_roles' => array(
                'name'          => __( 'Blocked Roles', 'gamipress-block-users' ),
                'desc'          => __( 'Block users by role to being awarded. Also, users on this roles activity won\'t be registered on logs.', 'gamipress-block-users' ),
                'type'          => 'advanced_select',
                'multiple'      => true,
                'options_cb'    => 'gamipress_block_users_get_roles_options',
            ),
            $prefix . 'blocked_users' => array(
                'name'          => __( 'Blocked Users', 'gamipress-block-users' ),
                'desc'          => __( 'Block specific users to being awarded. Also, this users activity won\'t be registered on logs.', 'gamipress-block-users' ),
                'type'          => 'advanced_select',
                'multiple'      => true,
                'options_cb'    => 'gamipress_options_cb_users',
            ),
        ) )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_addons_meta_boxes', 'gamipress_block_users_settings_meta_boxes' );

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_block_users_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-block-users'] = __( 'GamiPress - Block Users', 'gamipress-block-users' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_block_users_automatic_updates' );

// Callback to retrieve user roles as select options
function gamipress_block_users_get_roles_options() {

    $options = array();

    $editable_roles = array_reverse( get_editable_roles() );

    foreach ( $editable_roles as $role => $details ) {

        $options[$role] = translate_user_role( $details['name'] );

    }

    return $options;
    
}