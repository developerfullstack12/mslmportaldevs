<?php
/**
 * LearnDash User Groups Leaderboards Shortcode
 *
 * @package     GamiPress\LearnDash_Group_Leaderboard\Shortcodes\Shortcode\LearnDash_User_Groups_Leaderboards
 * @since       1.0.3
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register the [gamipress_learndash_user_groups_leaderboards] shortcode.
 *
 * @since 1.0.3
 */
function gamipress_register_learndash_user_groups_leaderboards_shortcode() {

    gamipress_register_shortcode( 'gamipress_learndash_user_groups_leaderboards', array(
        'name'              => __( 'LearnDash User Groups Leaderboards', 'gamipress-learndash-group-leaderboard' ),
        'description'       => __( 'Render all leaderboards of all user\'s groups.', 'gamipress-learndash-group-leaderboard' ),
        'output_callback'   => 'gamipress_learndash_user_groups_leaderboards_shortcode',
        'icon'              => 'leaderboard',
        'fields'            => array(
            'current_user' => array(
                'name'              => __( 'Current User', 'gamipress-learndash-group-leaderboard' ),
                'description'       => __( 'Show groups leaderboards of the current logged in user.', 'gamipress-learndash-group-leaderboard' ),
                'type' 		        => 'checkbox',
                'classes' 	        => 'gamipress-switch',
            ),
            'user_id' => array(
                'name'              => __( 'User', 'gamipress-learndash-group-leaderboard' ),
                'description'       => __( 'Show groups leaderboards of a specific user.', 'gamipress-learndash-group-leaderboard' ),
                'type'              => 'select',
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_users'
            ),
            'exclude_groups' => array(
                'name'              => __( 'Excluded Groups', 'gamipress-learndash-group-leaderboard' ),
                'description'       => __( 'Groups to exclude.', 'gamipress-learndash-group-leaderboard' ),
                'shortcode_desc'    => __( 'Comma-separated list of groups ids you want to exclude to being rendered.', 'gamipress-learndash-group-leaderboard' ),
                'type'              => 'advanced_select',
                'multiple'          => true,
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_posts'
            ),
            'exclude_leaderboards' => array(
                'name'              => __( 'Excluded Leaderboards', 'gamipress-learndash-group-leaderboard' ),
                'description'       => __( 'Leaderboards to exclude.', 'gamipress-learndash-group-leaderboard' ),
                'shortcode_desc'    => __( 'Comma-separated list of leaderboards ids you want to exclude to being rendered.', 'gamipress-learndash-group-leaderboard' ),
                'type'              => 'advanced_select',
                'multiple'          => true,
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_posts'
            ),
            'excerpt' => array(
                'name'        => __( 'Show Excerpt', 'gamipress-learndash-group-leaderboard' ),
                'description' => __( 'Display the leaderboard short description.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'checkbox',
                'classes' => 'gamipress-switch',
                'default' => 'yes'
            ),
            'search' => array(
                'name' 	=> __( 'Show Search', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	=> __( 'Display a search input.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'checkbox',
                'classes'   => 'gamipress-switch',
                'default'   => 'yes',
            ),
            'sort' => array(
                'name' 	=> __( 'Enable Sort', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	=> __( 'Enable live column sorting.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'checkbox',
                'classes'   => 'gamipress-switch',
                'default'   => 'yes',
            ),
            'hide_admins' => array(
                'name' 	=> __( 'Hide Administrators', 'gamipress-learndash-group-leaderboard' ),
                'desc' 	=> __( 'Hide website administrators.', 'gamipress-learndash-group-leaderboard' ),
                'type' 	=> 'checkbox',
                'classes'   => 'gamipress-switch',
                'default'   => 'yes',
            ),
        ),
    ) );

}
add_action( 'init', 'gamipress_register_learndash_user_groups_leaderboards_shortcode' );

/**
 * LearnDash User Groups Leaderboards Shortcode.
 *
 * @since  1.0.3
 *
 * @param  array $atts Shortcode attributes.
 * @return string 	   HTML markup.
 */
function gamipress_learndash_user_groups_leaderboards_shortcode( $atts = array() ) {

    // Setup default attrs
    $atts = shortcode_atts( array(
        'current_user'          => 'yes',
        'user_id'               => '0',
        'exclude_groups'        => '',
        'exclude_leaderboards'  => '',
        'excerpt'               => 'yes',
        'search'                => 'yes',
        'sort'                  => 'yes',
        'hide_admins'           => 'yes',
    ), $atts, 'gamipress_learndash_user_groups_leaderboards' );

    // Setup user ID
    $user_id = get_current_user_id();

    // Current user
    if( $atts['current_user'] === 'no' && absint( $atts['user_id'] ) !== 0 ) {
        $user_id = absint( $atts['user_id'] );
    }

    if( absint( $user_id ) === 0 ) {
        return '';
    }

    // Excluded groups
    if ( ! is_array( $atts['exclude_groups'] ) && empty( $atts['exclude_groups'] ) ) {
        $atts['exclude_groups'] = array();
    }

    if ( ! is_array( $atts['exclude_groups'] ) ) {
        $atts['exclude_groups'] = explode( ',', $atts['exclude_groups'] );
    }

    // Excluded leaderboards
    if ( ! is_array( $atts['exclude_leaderboards'] ) && empty( $atts['exclude_leaderboards'] ) ) {
        $atts['exclude_leaderboards'] = array();
    }

    if ( ! is_array( $atts['exclude_leaderboards'] ) ) {
        $atts['exclude_leaderboards'] = explode( ',', $atts['exclude_leaderboards'] );
    }

    $user_groups = learndash_get_users_group_ids( $user_id );

    ob_start(); ?>

    <div class="learndash-user-groups-leaderboards learndash-user-<?php echo $user_id; ?>-groups-leaderboards">

        <?php do_action( 'gamipress_learndash_group_leaderboard_before_render_groups_leaderboards', $user_id, $user_groups, $atts ); ?>

        <?php foreach( $user_groups as $group_id ) :
            $leaderboard_id = gamipress_learndash_group_leaderboard_get_group_leaderboard( $group_id );

            // Check if group is excluded
            if( in_array( $group_id, $atts['exclude_groups'] ) ) continue;

            // Check if leaderboard is excluded
            if( in_array( $leaderboard_id, $atts['exclude_leaderboards'] ) ) continue;
            ?>

            <div class="learndash-group-leaderboard learndash-group-<?php echo $group_id; ?>-leaderboard-<?php echo $leaderboard_id; ?>">

                <?php do_action( 'gamipress_learndash_group_leaderboard_before_render_group_leaderboard', $user_id, $group_id, $leaderboard_id, $atts ); ?>

                <?php echo gamipress_do_shortcode( 'gamipress_leaderboard', array(
                    'id'            => $leaderboard_id,
                    'excerpt'       => $atts['excerpt'],
                    'search'        => $atts['search'],
                    'sort'          => $atts['sort'],
                    'hide_admins'   => $atts['hide_admins'],
                ) ); ?>

                <?php do_action( 'gamipress_learndash_group_leaderboard_after_render_group_leaderboard', $user_id, $group_id, $leaderboard_id, $atts ); ?>

            </div>

        <?php endforeach; ?>

        <?php do_action( 'gamipress_learndash_group_leaderboard_after_render_groups_leaderboards', $user_id, $user_groups, $atts ); ?>

    </div>

    <?php $output = ob_get_clean();

    // Return the rendered text with user position
    return $output;

}
