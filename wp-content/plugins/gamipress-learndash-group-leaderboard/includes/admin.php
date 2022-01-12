<?php
/**
 * Admin
 *
 * @package GamiPress\LearnDash_Group_Leaderboard\Admin
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
function gamipress_learndash_group_leaderboard_get_option( $option_name, $default = false ) {

    $prefix = 'learndash_group_leaderboard_';

    return gamipress_get_option( $prefix . $option_name, $default );
}

/**
 * Plugin Settings meta boxes
 *
 * @since  1.0.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function gamipress_learndash_group_leaderboard_settings_meta_boxes( $meta_boxes ) {

    $prefix = 'learndash_group_leaderboard_';

    $meta_boxes['gamipress-learndash-group-leaderboard-settings'] = array(
        'title' => __( 'LearnDash Group Leaderboard', 'gamipress-learndash-group-leaderboard' ),
        'fields' => apply_filters( 'gamipress_learndash_group_leaderboard_settings_fields', array(
            $prefix . 'users' => array(
                'name' 	=> __( 'Number of Users', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	=> __( 'Number of users to display in the group leaderboard (0 to all group members).', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'text_small',
                'attributes' => array(
                    'type' => 'number',
                    'pattern' => '\d*',
                ),
                'default' => '0'
            ),
            $prefix . 'users_per_page' => array(
                'name' 	=> __( 'Users Per Page', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	=> __( 'Number of users per page in the group leaderboard (0 to disable pagination).', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'text_small',
                'attributes' => array(
                    'type' => 'number',
                    'pattern' => '\d*',
                ),
                'default' => '10'
            ),
            $prefix . 'metrics' => array(
                'name' 	=> __( 'Metrics to track', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	=> __( 'Choose the metrics with which group leaderboards will be ranked.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'multicheck',
                'options' 	=> 'gamipress_leaderboards_metrics_options_cb', // Callback from Leaderboards add-on
                'classes' 	=> 'gamipress-switch',
            ),
            $prefix . 'period' => array(
                'name' 	        => __( 'Period', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Filter metrics to track based on a specific period selected. By default "None", that will rank users based on their current earnings.', 'gamipress-learndash-group-leaderboard' )
                    . '<br>' . sprintf( __( '<strong>Important:</strong> If you can\'t see any option, it means you need to update <a href="%s" target="_blank">GamiPress - Leaderboards</a> add-on.', 'gamipress-learndash-group-leaderboard' ), 'https://gamipress.com/add-ons/gamipress-leaderboards/' ),
                'type' 	        => 'select',
                'options_cb' 	=> 'gamipress_leaderboards_get_time_periods',
            ),
            $prefix . 'period_start_date' => array(
                'name' 	        => __( 'Start Date', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Choose period start date. Leave blank to no filter by a start date (metrics will be filtered only to the end date).', 'gamipress-learndash-group-leaderboard' )
                    . '<br>' . __( 'Accepts any valid PHP date format.', 'gamipress-learndash-group-leaderboard' ) . ' (<a href="https://gamipress.com/docs/advanced/date-fields" target="_blank">' .  __( 'More information', 'gamipress-learndash-group-leaderboard' ) .  '</a>)',
                'type'          => 'text',
            ),
            $prefix . 'period_end_date' => array(
                'name' 	        => __( 'End Date', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Choose period end date. Leave blank to no filter by an end date (metrics will be filtered from the start date to today).', 'gamipress-learndash-group-leaderboard' )
                    . '<br>' . __( 'Accepts any valid PHP date format.', 'gamipress-learndash-group-leaderboard' ) . ' (<a href="https://gamipress.com/docs/advanced/date-fields" target="_blank">' .  __( 'More information', 'gamipress-learndash-group-leaderboard' ) .  '</a>)',
                'type'          => 'text',
            ),
            // Need to set it as text and hide the field because CMB2 moves hidden fields to the end of the form
            $prefix . 'columns_order' => array(
                'name' 	        => __( 'Columns Order', 'gamipress-learndash-group-leaderboard' ),
                'type' 	        => 'text',
                'attributes' 	=> array( 'type' => 'hidden' ),
            ),
            $prefix . 'columns' => array(
                'name' 	        => __( 'Columns', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Choose the columns to show. Drag and drop any option to reorder them.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	        => 'multicheck',
                'options_cb' 	=> 'gamipress_learndash_group_leaderboard_columns_options_cb',
                'classes' 	    => 'gamipress-switch',
            ),
            $prefix . 'avatar_size' => array(
                'name' 	        => __( 'Avatar Size', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Size of the users avatars.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	        => 'text',
                'attributes' 	=> array(
                    'type' => 'number',
                    'pattern' => '\d*',
                ),
                'default'    => 96,
            ),
            $prefix . 'search' => array(
                'name' 	        => __( 'Show Search', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Display a search input.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	        => 'checkbox',
                'classes' 	    => 'gamipress-switch',
            ),
            $prefix . 'sort' => array(
                'name' 	        => __( 'Enable Sort', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Enable live column sorting.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	        => 'checkbox',
                'classes'       => 'gamipress-switch',
            ),
            $prefix . 'hide_admins' => array(
                'name' 	        => __( 'Hide Administrators', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	        => __( 'Hide website administrators.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	        => 'checkbox',
                'classes'       => 'gamipress-switch',
            ),
            $prefix . 'regenerate_leaderboards' => array(
                'name' 	=> __( 'Regenerate Group\'s Leaderboards', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	=> __( 'Click this button to launch an automatic process that will detect groups without a leaderboard assigned and will generate and assign a new one.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'button',
            ),
        ) )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_settings_addons_meta_boxes', 'gamipress_learndash_group_leaderboard_settings_meta_boxes' );

/**
 * Register plugin meta boxes
 *
 * @since  1.0.0
 */
function gamipress_learndash_group_leaderboard_register_meta_boxes() {

    add_meta_box(
        'gamipress-learndash-group-leaderboard',
        __( 'LearnDash Group', 'gamipress-learndash-group-leaderboard' ),
        'gamipress_learndash_group_leaderboard_leaderboard_meta_box',
        'leaderboard',
        'side'
    );

}
add_action( 'add_meta_boxes', 'gamipress_learndash_group_leaderboard_register_meta_boxes' );

/**
 * Meta box display callback
 *
 * @since  1.0.0
 *
 * @param WP_Post $post Current post object
 */
function gamipress_learndash_group_leaderboard_leaderboard_meta_box( $post ) {

    // Check if leaderboard is for a specific group
    $group_id = absint( gamipress_get_post_meta( $post->ID, '_gamipress_learndash_group_leaderboard_group_id' ) );

    if( $group_id !== 0 ) :
        $group_title = get_post_field( 'post_title', $group_id ); ?>

        <p><?php echo __( 'Assigned to group', 'gamipress-learndash-group-leaderboard' ) . ' <strong>' . $group_title . '</strong>'; ?></p>

    <?php else : ?>
        <p><?php echo __( 'Not assigned to any group', 'gamipress-learndash-group-leaderboard' ); ?></p>
    <?php endif;

}

/**
 * Plugin automatic updates
 *
 * @since  1.0.0
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_learndash_group_leaderboard_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-learndash-group-leaderboard'] = __( 'LearnDash Group Leaderboard', 'gamipress-learndash-group-leaderboard' );

    return $automatic_updates_plugins;

}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_learndash_group_leaderboard_automatic_updates' );

// Columns options cb
function gamipress_learndash_group_leaderboard_columns_options_cb( $field ) {

    $columns_order = gamipress_learndash_group_leaderboard_get_option( 'columns_order', false );

    if( ! $columns_order ) {
        $columns_order = array();
    }

    $columns_options = gamipress_leaderboards_get_columns_options();

    $final_options = array();

    foreach( $columns_order as $column_option ) {
        if( isset( $columns_options[$column_option] ) ) {
            $final_options[$column_option] = '<input type="hidden" name="gamipress_learndash_group_leaderboard_columns_order[]" value="' . $column_option . '" />' .  $columns_options[$column_option];
        }
    }

    $columns_options_keys = array_keys( $columns_options );
    $unordered_column_options = array_diff( $columns_options_keys, $columns_order );

    // Append unordered column options
    foreach( $unordered_column_options as $column_option ) {
        if( isset( $columns_options[$column_option] ) ) {
            $final_options[$column_option] = '<input type="hidden" name="gamipress_learndash_group_leaderboard_columns_order[]" value="' . $column_option . '" />' .  $columns_options[$column_option];
        }
    }

    return $final_options;

}
