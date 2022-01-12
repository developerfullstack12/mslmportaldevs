<?php
/**
 * myCRED Importer Tool
 *
 * @package     GamiPress\Admin\Tools\myCRED\Importer
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register myCRED Importer Tool meta boxes
 *
 * @since  1.0.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */
function gamipress_mycred_importer_tool_meta_boxes( $meta_boxes ) {

    $prefix = 'gamipress_mycred_importer_';

    // Setup achievement types options
    $achievements_types = gamipress_get_achievement_types();
    $achievements_types_options = array();

    foreach( $achievements_types as $achievements_type_slug => $achievements_type ) {
        $achievements_types_options[$achievements_type_slug] = $achievements_type['plural_name'];
    }

    // Setup points types options
    $points_types = gamipress_get_points_types();
    $points_types_options = array();

    foreach( $points_types as $points_type_slug => $points_type ) {
        $points_types_options[$points_type_slug] = $points_type['plural_name'];
    }

    // Setup rank types options
    $ranks_types = gamipress_get_rank_types();
    $ranks_types_options = array();

    foreach( $ranks_types as $ranks_type_slug => $ranks_type ) {
        $ranks_types_options[$ranks_type_slug] = $ranks_type['plural_name'];
    }

    $fields = array(
        $prefix . 'desc' => array(
            'content' => __( 'This tool will migrate all myCRED stored data to GamiPress. All the new content will be <strong>appended</strong> to prevent override anything.', 'gamipress-mycred-importer' )
                . '<br>' . __( '<strong>Important!</strong> Please backup your database before starting this process.', 'gamipress-mycred-importer' )
                . ' <a  href="javascript:void(0);" onClick="jQuery(this).next(\'p\').slideToggle();">' . __( 'Read some important notes', 'gamipress-mycred-importer' ) . '</a>'
                . '<p style="display: none;">'
                . sprintf( __( '<strong>About link clicks:</strong> To supply myCRED link clicks hooks, you can check the <a href="%s" target="_blank">GamiPress - Link</a> add-on.', 'gamipress-mycred-importer' ), 'https://gamipress.com/add-ons/link' )
                . '<br>' . sprintf( __( '<strong>About video views:</strong> To supply myCRED video views hooks, you can check the <a href="%s" target="_blank">GamiPress - Multimedia Content</a> add-on.', 'gamipress-mycred-importer' ), 'https://gamipress.com/add-ons/multimedia-content' )
                . '<br>' . sprintf( __( '<strong>About buyCRED:</strong> To supply buyCRED, you can check the <a href="%s" target="_blank">GamiPress - Purchases</a> add-on.', 'gamipress-mycred-importer' ), 'https://gamipress.com/add-ons/gamipress-purchases' )
                . '<br>' . sprintf( __( '<strong>About sell content:</strong> To supply myCRED sell content, you can check the <a href="%s" target="_blank">GamiPress - Restrict Content</a> add-on.', 'gamipress-mycred-importer' ), 'https://gamipress.com/add-ons/gamipress-restrict-content' )
                . '<br>' . sprintf( __( '<strong>About notifications:</strong> To supply myCRED notifications, you can check the <a href="%s" target="_blank">GamiPress - Notifications</a> add-on.', 'gamipress-mycred-importer' ), 'https://gamipress.com/add-ons/gamipress-notifications' )
                . '<br>' . sprintf( __( '<strong>About specific trigger events:</strong> For specific trigger events (bbPress, BuddyPress, WooCommerce, Gravitiy Forms, etc ) you need to install each specific <a href="%s" target="_blank">GamiPress integration</a>. <strong>Note:</strong> All GamiPress integrations are completely free!', 'gamipress-mycred-importer' ), admin_url( 'admin.php?page=gamipress_add_ons' ) )
                . '</p>',
            'type' => 'html',
        ),
        $prefix . 'points_type' => array(
            'name' => __( 'myCRED Points Types', 'gamipress-mycred-importer' ),
            'content' => __( 'myCRED points types will be migrated as new GamiPress points types.', 'gamipress-mycred-importer' )
            . '<br>' . __( '<strong>Note:</strong> User points balance from myCRED will be added to their current points balance.', 'gamipress-mycred-importer' ),
            'type' => 'html',
        ),
        $prefix . 'override_points' => array(
            'name' => __( 'Override User Points Balance', 'gamipress-mycred-importer' ),
            'desc' => __( 'Check this option to keep myCRED points balance instead of sum them to the current points balance.', 'gamipress-mycred-importer' ),
            'type' => 'checkbox',
            'classes' => 'gamipress-switch',
        ),
        $prefix . 'import_achievements' => array(
            'name' => __( 'Import myCRED Badges', 'gamipress-mycred-importer' ),
            'desc' => __( 'Check this option to import myCRED badges as GamiPress achievements.', 'gamipress-mycred-importer' ),
            'type' => 'checkbox',
            'classes' => 'gamipress-switch',
        ),
        $prefix . 'badges_achievement_type' => array(
            'name' => __( 'myCRED Badges to', 'gamipress-mycred-importer' ),
            'desc' => __( 'Choose the achievement type you want to import the myCRED badges.', 'gamipress-mycred-importer' ),
            'content' => empty( $achievements_types_options ) ? sprintf( __( 'No achievement types found! To import myCRED badges, please create an <a href="%s">achievement type</a>.', 'gamipress-mycred-importer' ), admin_url( 'edit.php?post_type=rank-type' ) ) : '',
            'type' => empty( $achievements_types_options ) ? 'html' : 'select',
            'options' => $achievements_types_options,
        ),
        $prefix . 'badges_requirements_as_events' => array(
            'name' => __( 'myCRED badge requirements as events', 'gamipress-mycred-importer' ),
            'desc' => __( 'Check this option if you want to turn a myCRED requirement like "Get 10 points by commenting" to a requirement like "Comment 10 times".', 'gamipress-mycred-importer' )
                . '<br>' . __( 'If you don\'t check this option, a myCRED requirement like "Get 10 points by commenting" will be turned as to a requirement like "Earn 10 points".', 'gamipress-mycred-importer' )
                .  '<br>' . ' <a  href="javascript:void(0);" onClick="jQuery(this).next().next(\'span\').slideToggle();">' . __( 'More information', 'gamipress-mycred-importer' ) . '</a>'
                .  '<br>' . '<span style="display: none;">' . __( 'myCRED badge requirements are based on earning an amount of points by perform a specific action (eg: Get 10 points by commenting).', 'gamipress-mycred-importer' )
                . '<br>' . __( 'GamiPress setup achievement requirements based on events (eg: Comment 10 times, Earn 10 points, etc).', 'gamipress-mycred-importer' ) . '</span>',
            'type' => 'checkbox',
            'classes' => 'gamipress-switch',
        ),
        $prefix . 'import_ranks' => array(
            'name' => __( 'Import myCRED Ranks', 'gamipress-mycred-importer' ),
            'desc' => __( 'Check this option to import myCRED ranks as GamiPress ranks.', 'gamipress-mycred-importer' ),
            'type' => 'checkbox',
            'classes' => 'gamipress-switch',
        ),
    );

    // myCRED has ranks per points type so we need more settings
    $mycred_point_types = mycred_get_types();

    foreach( $mycred_point_types as $mycred_point_type => $mycred_point_type_label ) {

        $fields[$prefix . $mycred_point_type . '_rank_type'] = array(
            'name' => sprintf( __( '%s Ranks to', 'gamipress-mycred-importer' ), $mycred_point_type_label ),
            'desc' => sprintf( __( 'Choose the rank type you want to import the %s ranks.', 'gamipress-mycred-importer' ), $mycred_point_type_label ),
            'content' => empty( $ranks_types_options ) ? sprintf( __( 'No rank types found! To import %s ranks, please create some <a href="%s">rank types</a>.', 'gamipress-mycred-importer' ), $mycred_point_type_label, admin_url( 'edit.php?post_type=rank-type' ) ) : '',
            'type' => empty( $ranks_types_options ) ? 'html' : 'select',
            'options' => $ranks_types_options,
        );

    }

    // Import options
    $fields[$prefix . 'import_earnings'] = array(
        'name' => __( 'Import User Earnings', 'gamipress-mycred-importer' ),
        'desc' => __( 'Check this option to import user earned achievements, ranks and points.', 'gamipress-mycred-importer' ),
        'type' => 'checkbox',
        'classes' => 'gamipress-switch',
    );

    $fields[$prefix . 'import_logs'] = array(
        'name' => __( 'Import Logs', 'gamipress-mycred-importer' ),
        'desc' => __( 'Check this option to import logs.', 'gamipress-mycred-importer' ),
        'type' => 'checkbox',
        'classes' => 'gamipress-switch',
    );

    // Last field is the start import button
    $fields[$prefix . 'run'] = array(
        'label' => __( 'Start Importing Data', 'gamipress-mycred-importer' ),
        'type' => 'button',
        'button' => 'primary'
    );

    $meta_boxes['mycred-importer'] = array(
        'title' => __( 'myCRED Importer', 'gamipress-mycred-importer' ),
        'fields' => apply_filters( 'gamipress_mycred_importer_tool_fields', $fields )
    );

    return $meta_boxes;

}
add_filter( 'gamipress_tools_import_export_meta_boxes', 'gamipress_mycred_importer_tool_meta_boxes' );

/**
 * First importer run (to clear marks)
 *
 * @since 1.0.3
 */
function gamipress_mycred_importer_ajax_first_run() {

    global $wpdb;

    // Let's to clean old imports
    $old_mycred_imports = $wpdb->get_results( $wpdb->prepare(
        "SELECT pm.meta_id, pm.post_id FROM {$wpdb->postmeta} AS pm WHERE pm.meta_key = %s",
        '_gamipress_mycred_legacy_id'
    ) );

    foreach( $old_mycred_imports as $old_mycred_import ) {
        // Delete the old created post
        $wpdb->delete(
            $wpdb->posts,
            array( 'ID' => $old_mycred_import->post_id )
        );

        // Delete the old created meta
        $wpdb->delete(
            $wpdb->postmeta,
            array( 'post_id' => $old_mycred_import->post_id )
        );
    }

    // Delete users meta to allow calculate balance again
    $wpdb->delete(
        $wpdb->usermeta,
        array( 'meta_key' => '_gamipress_imported_mycred_earnings' )
    );


}

/**
 * AJAX handler for the myCRED Importer points import action
 *
 * @since 1.0.0
 */
function gamipress_mycred_importer_ajax_import_points() {

    // Check user capabilities
    if( ! current_user_can( gamipress_get_manager_capability() ) ) {
        wp_send_json_error( __( 'You are not allowed to perform this action.', 'gamipress' ) );
    }

    global $wpdb;

    ignore_user_abort( true );
    set_time_limit( 0 );

    // Our prefix
    $prefix = '_gamipress_';

    if( isset( $_REQUEST['first_run'] ) && (bool) absint( $_REQUEST['first_run'] ) ) {
        gamipress_mycred_importer_ajax_first_run();
    }

    $mycred_point_types = mycred_get_types();
    $points_types = gamipress_get_points_types();

    // First, turn myCRED points types to our points types
    foreach( $mycred_point_types as $type => $label ) {

        // Setup points type vars
        $singular = mycred_get_point_type_name( $type, true );
        $plural = mycred_get_point_type_name( $type, false );
        $points_type = gamipress_sanitize_slug( $type );

        // If not exists, register as a new points type
        if( ! isset( $points_types[$points_type] ) ) {

            $points_type_id = wp_insert_post( array(
                'post_title'    => $singular,
                'post_type'     => 'points-type',
                'post_name'     => $points_type,
                'post_status'   => 'publish'
            ) );

            update_post_meta( $points_type_id, $prefix . 'plural_name', $plural );

        } else {

            $points_type_id = $points_types[$points_type]['ID'];

        }

        // Turn all points types hooks to points awards/deducts
        $hooks = mycred_core()->modules['type'][ $type ]['hooks'];

        foreach( $hooks->active as $hook ) {

            $hook_prefs = $hooks->hook_prefs[$hook];

            $trigger = gamipress_mycred_importer_convert_to_gamipress_trigger( $hook );

            // Skip if unknown trigger
            if( ! $trigger ) {
                continue;
            }

            if( $hook === 'publishing_content' || $hook === 'deleted_content' ) {
                // This hook has prefs per type

                foreach( $hook_prefs as $post_type => $post_type_prefs ) {

                    // Update the trigger type
                    if( $hook === 'publishing_content' ) {
                        $trigger = 'gamipress_publish_' . $post_type;
                    } else if( $hook === 'deleted_content' ) {
                        $trigger = 'gamipress_delete_' . $post_type;
                    }

                    gamipress_mycred_importer_hook_to_requirement( $points_type_id, $points_type, $trigger, $post_type_prefs );

                }
            } else if( $hook === 'comments' ) {
                // This hook has prefs per comment status

                // For comments, just approved is supported
                gamipress_mycred_importer_hook_to_requirement( $points_type_id, $points_type, $trigger, $hook_prefs['approved'] );

                if( $hook_prefs['approved']['author'] ) {
                    // Hook also is configured to award to the post author
                    $trigger = 'gamipress_user_post_comment';

                    $author_prefs = $hook_prefs['approved'];
                    $author_prefs['creds'] = $hook_prefs['approved']['author'];

                    gamipress_mycred_importer_hook_to_requirement( $points_type_id, $points_type, $trigger, $hook_prefs['approved'] );
                }

            } else if( $trigger === 'integration' ) {
                // Process integration hooks

                foreach( $hook_prefs as $sub_hook => $sub_hook_prefs ) {

                    // First try to get the hook + sub-hook
                    $trigger = gamipress_mycred_importer_convert_to_gamipress_trigger( $hook . '_' . $sub_hook );

                    // If not success, try just with sub-hook
                    if( ! $trigger ) {
                        $trigger = gamipress_mycred_importer_convert_to_gamipress_trigger( $sub_hook );
                    }

                    if( $trigger ) {
                        // Try to build the requirement from sub-hook prefs
                        gamipress_mycred_importer_hook_to_requirement( $points_type_id, $points_type, $trigger, $sub_hook_prefs );
                    }

                }


            } else {
                // Default hook process

                gamipress_mycred_importer_hook_to_requirement( $points_type_id, $points_type, $trigger, $hook_prefs );

            }
        }

    }

    // Return a success message
    wp_send_json_success( __( 'myCRED points has been migrated successfully.', 'gamipress' ) );
}
add_action( 'wp_ajax_gamipress_mycred_importer_import_points', 'gamipress_mycred_importer_ajax_import_points' );

/**
 * AJAX handler for the myCRED Importer achievements import action
 *
 * @since 1.0.0
 */
function gamipress_mycred_importer_ajax_import_achievements() {

    // Check user capabilities
    if( ! current_user_can( gamipress_get_manager_capability() ) ) {
        wp_send_json_error( __( 'You are not allowed to perform this action.', 'gamipress' ) );
    }

    global $wpdb;

    ignore_user_abort( true );
    set_time_limit( 0 );

    // Our prefix
    $prefix = '_gamipress_';

    $achievements_types = gamipress_get_achievement_types();

    // Get request parameters
    $desired_achievement_type = $_REQUEST['badges_achievement_type'];
    $requirements_as_events = (bool) $_REQUEST['badges_requirements_as_events'];

    if( ! isset( $achievements_types[$desired_achievement_type] ) ) {
        wp_send_json_error( __( 'You need to choose a valid achievement type.', 'gamipress' ) );
    }

    $achievement_type = $desired_achievement_type;

    $mycred_badges = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
         FROM {$wpdb->posts}
         WHERE post_type = %s
          AND ID NOT IN (
            SELECT pm.meta_value FROM {$wpdb->postmeta} AS pm WHERE pm.meta_key = %s
          )
         ORDER BY ID ASC;",
        'mycred_badge',
        '_gamipress_mycred_legacy_id'
    ) );

    $points_types = gamipress_get_points_types();

    foreach( $mycred_badges as $mycred_badge ) {

        // Setup myCRED vars
        $badge = mycred_get_badge( $mycred_badge->ID );

        // myCRED badges has levels with different points requirements, so we need to setup a new achievement per level (suffixed with " - Level %d")
        $level_counter = 0;
        foreach ( $badge->levels as $level => $setup ) {

            // First add the achievement post
            $post_data = (array) $mycred_badge;

            unset( $post_data['ID'] );
            $post_data['post_type'] = $achievement_type;

            // Only first level keeps their title, next levels will append " - Level %d"
            if( $level_counter !== 0 ) {
                $post_data['post_title'] .= ' - ' . sprintf( __( 'Level %d', 'gamipress-mycred-importer' ), $level_counter );
            }

            $new_achievement_id = wp_insert_post( $post_data );

            if( $new_achievement_id ) {

                // Update achievement post meta data
                update_post_meta( $new_achievement_id, $prefix . 'earned_by', ( $badge->manual ? 'admin' : 'triggers' ) );
                update_post_meta( $new_achievement_id, $prefix . 'maximum_earnings', 1 );
                update_post_meta( $new_achievement_id, $prefix . 'layout', str_replace( 'mycred_layout_', '', $badge->layout ) );
                update_post_meta( $new_achievement_id, $prefix . 'align', str_replace( 'mycred_align_', '', $badge->align ) );

                if( isset( $setup['reward'] ) && $setup['reward']['amount'] !== 0 ) {
                    $points_type = gamipress_sanitize_slug( $setup['reward']['type'] );

                    if( isset( $points_types[$points_type] ) ) {
                        update_post_meta( $new_achievement_id, $prefix . 'points', $setup['reward']['amount'] );
                        update_post_meta( $new_achievement_id, $prefix . 'points_type', $points_type );
                    }
                }

                if( strtoupper( $setup['compare'] ) === 'AND' ) {
                    update_post_meta( $new_achievement_id, $prefix . 'sequential', 1 );
                }

                if( isset( $setup['attachment_id'] ) ) {
                    update_post_meta( $new_achievement_id, '_thumbnail_id', $setup['attachment_id'] );
                }

                // To meet old ID
                update_post_meta( $new_achievement_id, $prefix . 'mycred_legacy_id', $mycred_badge->ID );
                update_post_meta( $new_achievement_id, $prefix . 'mycred_legacy_level', $level );

                // Array used to group all points requirements by points type
                $required_points = array();

                // Loop all badge requirements
                foreach ( $setup['requires'] as $req_level => $requirement ) {

                    if( $requirements_as_events ) {
                        // Turn requirement like "Get 10 points by commenting" to "Comment 10 times"

                        // Check reference
                        if( $requirement['reference'] === '' ) {
                            continue;
                        }

                        $trigger = gamipress_mycred_importer_convert_to_gamipress_trigger( $requirement['reference'] );

                        if( $trigger ) {

                            // Add a trigger specific step associated to the achievement post
                            $step_id = wp_insert_post( array(
                                'post_type'   => 'step',
                                'post_status' => 'publish',
                                'post_parent'   => $new_achievement_id,
                                'menu_order'    => 0,
                            ) );

                            $occurrences = absint( $requirement['amount'] );

                            // Update step meta data
                            update_post_meta( $step_id, $prefix . 'trigger_type', $trigger );
                            update_post_meta( $step_id, $prefix . 'count', ( $occurrences === 0 ? 1 : $occurrences ) );
                            update_post_meta( $step_id, $prefix . 'limit', 1 );
                            update_post_meta( $step_id, $prefix . 'limit_type', 'unlimited' );

                        }

                    } else {
                        // Turn requirement like "Get 10 points by commenting" to "Earn 10 points"

                        // Check the points type
                        $points_type = gamipress_sanitize_slug( $requirement['type'] );

                        if( ! isset( $points_types[$points_type] ) ) {
                            continue;
                        }

                        // Check the points required
                        $points = absint( $requirement['amount'] );

                        if( $points === 0 ) {
                            continue;
                        }

                        // Initialize the points type counter
                        if( ! isset( $required_points[$points_type] ) ) {
                            $required_points[$points_type] = 0;
                        }

                        // Sum the points of this points type
                        $required_points[$points_type] += $points;

                    }

                }

                // Loop all grouped requirements of earn points
                if( ! $requirements_as_events ) {

                    foreach ( $required_points as $points_type => $points ) {

                        // Add a "Earn points" step associated to the achievement post
                        $step_id = wp_insert_post( array(
                            'post_type'     => 'step',
                            'post_status'   => 'publish',
                            'post_parent'   => $new_achievement_id,
                            'menu_order'    => 0,
                        ) );

                        // Update step meta data
                        update_post_meta( $step_id, $prefix . 'trigger_type', 'earn-points' );
                        update_post_meta( $step_id, $prefix . 'points_required', $points );
                        update_post_meta( $step_id, $prefix . 'points_type_required', $points_type );
                        update_post_meta( $step_id, $prefix . 'count', 1 );
                        update_post_meta( $step_id, $prefix . 'limit', 1 );
                        update_post_meta( $step_id, $prefix . 'limit_type', 'unlimited' );

                    }

                }

                $level_counter++;

            }

        }

    }

    // Return a success message
    wp_send_json_success( __( 'myCRED achievements has been migrated successfully.', 'gamipress' ) );
}
add_action( 'wp_ajax_gamipress_mycred_importer_import_achievements', 'gamipress_mycred_importer_ajax_import_achievements' );

/**
 * AJAX handler for the myCRED Importer ranks import action
 *
 * @since 1.0.2
 */
function gamipress_mycred_importer_ajax_import_ranks() {

    // Check user capabilities
    if( ! current_user_can( gamipress_get_manager_capability() ) ) {
        wp_send_json_error( __( 'You are not allowed to perform this action.', 'gamipress' ) );
    }

    global $wpdb;

    ignore_user_abort( true );
    set_time_limit( 0 );

    // Setup vars
    $prefix = '_gamipress_';
    $mycred_point_types = mycred_get_types();
    $points_types = gamipress_get_points_types();
    $rank_types = gamipress_get_rank_types();

    // Loop all myCRED points types (myCRED ranks are separated per points type)
    foreach( $mycred_point_types as $mycred_point_type => $mycred_point_type_label ) {

        $points_type = gamipress_sanitize_slug( $mycred_point_type );

        if( ! isset( $points_types[$points_type] ) ) {
            continue;
        }

        // The desired rank type is passed from dynamic settings
        $rank_type = $_REQUEST[$mycred_point_type . '_rank_type'];

        if( ! isset( $rank_types[$rank_type] ) ) {
            continue;
        }

        // Get this points type ranks (ordered by minimum points required
        $mycred_ranks = $wpdb->get_results( $wpdb->prepare(
            "SELECT *
             FROM {$wpdb->posts} as p
             LEFT JOIN {$wpdb->postmeta} AS ctype ON ( p.ID = ctype.post_id AND ctype.meta_key = 'ctype' )
             LEFT JOIN {$wpdb->postmeta} AS min_points ON ( p.ID = min_points.post_id AND min_points.meta_key = 'mycred_rank_min' )
             WHERE p.post_type = %s
              AND p.post_status = %s
              AND ctype.meta_value = %s
              AND p.ID NOT IN (
                SELECT pm.meta_value FROM {$wpdb->postmeta} AS pm WHERE pm.meta_key = %s
              )
             ORDER BY min_points.meta_value ASC;",
            'mycred_rank',
            'publish',
            $mycred_point_type,
            '_gamipress_mycred_legacy_id'
        ) );

        $priority = 0;

        foreach( $mycred_ranks as $mycred_rank ) {

            $rank = mycred_get_rank( $mycred_rank->ID );

            // First add the rank post
            $post_data = (array) $mycred_rank;

            unset( $post_data['ID'] );
            $post_data['post_type'] = $rank_type;
            $post_data['menu_order'] = $priority;

            $new_rank_id = wp_insert_post( $post_data );

            if( $new_rank_id ) {

                // Update rank post meta data
                if( $rank->logo_id ) {
                    update_post_meta( $new_rank_id, '_thumbnail_id', $rank->logo_id );
                }

                // To meet old ID
                update_post_meta( $new_rank_id, $prefix . 'mycred_legacy_id', $mycred_rank->ID );

                if( $priority !== 0 ) {

                    // Next add a single rank requirement with the minimum points required associated to the rank post
                    $rank_requirement_id = wp_insert_post( array(
                        'post_type'   => 'rank-requirement',
                        'post_status' => 'publish',
                        'post_parent' => $new_rank_id,
                        'menu_order'  => 0
                    ) );

                    // Update rank requirement meta data
                    update_post_meta( $rank_requirement_id, $prefix . 'trigger_type', 'points-balance' );
                    update_post_meta( $rank_requirement_id, $prefix . 'points_required', $rank->minimum );
                    update_post_meta( $rank_requirement_id, $prefix . 'points_type_required', $points_type );
                }

                // Increase priority for next rank
                $priority++;

            }

        }

    }

    // Return a success message
    wp_send_json_success( __( 'myCRED ranks has been migrated successfully.', 'gamipress' ) );

}
add_action( 'wp_ajax_gamipress_mycred_importer_import_ranks', 'gamipress_mycred_importer_ajax_import_ranks' );

/**
 * AJAX handler for the myCRED Importer earnings import action
 *
 * @since 1.0.0
 */
function gamipress_mycred_importer_ajax_import_earnings() {

    // Check user capabilities
    if( ! current_user_can( gamipress_get_manager_capability() ) ) {
        wp_send_json_error( __( 'You are not allowed to perform this action.', 'gamipress' ) );
    }

    global $wpdb;

    ignore_user_abort( true );
    set_time_limit( 0 );

    // Our prefix
    $prefix = '_gamipress_';

    // Setup vars
    $mycred_point_types = mycred_get_types();
    $points_types = gamipress_get_points_types();
    $achievements_types = gamipress_get_achievement_types();
    $rank_types = gamipress_get_rank_types();
    $override_points = absint( $_REQUEST['override_points'] );

    // Get all stored users
    $users = $wpdb->get_results( $wpdb->prepare(
        "SELECT ID
        FROM {$wpdb->users}
        WHERE ID NOT IN (
          SELECT um.user_id FROM {$wpdb->usermeta} AS um WHERE um.meta_key = %s
        )
        LIMIT 0, 100",
        '_gamipress_imported_mycred_earnings'
    ) );

    $ct_table = ct_setup_table( 'gamipress_user_earnings' );

    foreach( $users as $user ) {

        // Points balance
        foreach( $mycred_point_types as $type => $label ) {

            $points_type = gamipress_sanitize_slug( $type );

            if( ! isset( $points_types[$points_type] ) ) {
                continue;
            }

            // Default points
            $user_meta = '_gamipress_points';

            if( ! empty( $points_type ) ) {
                $user_meta = "_gamipress_{$points_type}_points";
            }

            // Get myCRED balance
            $mycred_user_points = (int) mycred_get_users_balance( $user->ID, $type );

            if( $override_points ) {
                // Update user points balance with myCRED points balance
                gamipress_update_user_meta( $user->ID, $user_meta, $mycred_user_points );
            } else {
                // Get current user balance
                $user_points = absint( gamipress_get_user_meta( $user->ID, $user_meta, true ) );

                // Update user points balance with GamiPress and myCRED points balance
                gamipress_update_user_meta( $user->ID, $user_meta, ( $user_points + $mycred_user_points ) );
            }

        }

        // Achievements earned

        // Check if MyCRED badges module is installed
        if( mycred_get_module( 'badges' ) !== false ) {

            $user_earned_achievements = mycred_get_users_badges( $user->ID, true );

            if( is_array( $user_earned_achievements ) ) {

                foreach( $user_earned_achievements as $mycred_badge_id => $mycred_badge_level ) {

                    // Get the GamiPress achievements ID based on myCRED legacy ID meta
                    $post_ids = $wpdb->get_results( $wpdb->prepare(
                        "SELECT pm.post_id FROM {$wpdb->postmeta} AS pm 
                            WHERE pm.meta_key = %s AND pm.meta_value = %d",
                        '_gamipress_mycred_legacy_id',
                        $mycred_badge_id
                    ) );

                    if( is_array( $post_ids ) ) {

                        $post_ids = wp_list_pluck( $post_ids, 'post_id' );

                        foreach( $post_ids as $post_id ) {

                            $level = absint( get_post_meta( $post_id, $prefix . 'mycred_legacy_level', true ) );

                            // Only award achievements on a lower level
                            if( $level <= $mycred_badge_level ) {

                                $points = get_post_meta( $post_id, $prefix . 'points', true );
                                $points_type = get_post_meta( $post_id, $prefix . 'points_type', true );

                                $earning_data = array(
                                    'user_id' => $user->ID,
                                    'post_id' => $post_id,
                                    'post_type' => get_post_type( $post_id ),
                                    'points' => absint( $points ),
                                    'points_type' => $points_type,
                                    'date' => date( 'Y-m-d H:i:s' )
                                );

                                if( is_gamipress_upgraded_to( '1.4.7' ) ) {
                                    $earning_data['title'] = get_the_title( $post_id );
                                }

                                $ct_table->db->insert( $earning_data );

                            }
                        }
                    }

                }

            }

        }

        // Rank reached

        // Check if MyCRED ranks module is installed
        if( mycred_get_module( 'ranks' ) !== false ) {

            // Loop all myCRED points types (myCRED ranks are separated per points type)
            foreach( $mycred_point_types as $mycred_point_type => $mycred_point_type_label ) {

                $points_type = gamipress_sanitize_slug( $mycred_point_type );

                if( ! isset( $points_types[$points_type] ) ) {
                    continue;
                }

                // The desired rank type is passed from dynamic settings
                $rank_type = $_REQUEST[$mycred_point_type . '_rank_type'];

                if( ! isset( $rank_types[$rank_type] ) ) {
                    continue;
                }

                // Get this points type ranks (ordered by minimum points required
                $mycred_ranks = $wpdb->get_results( $wpdb->prepare(
                    "SELECT *
                 FROM {$wpdb->posts} as p
                 LEFT JOIN {$wpdb->postmeta} AS ctype ON ( p.ID = ctype.post_id AND ctype.meta_key = 'ctype' )
                 LEFT JOIN {$wpdb->postmeta} AS min_points ON ( p.ID = min_points.post_id AND min_points.meta_key = 'mycred_rank_min' )
                 WHERE p.post_type = %s
                  AND p.post_status = %s
                  AND ctype.meta_value = %s
                 ORDER BY min_points.meta_value ASC;",
                    'mycred_rank',
                    'publish',
                    $mycred_point_type
                ) );

                $user_points = gamipress_get_user_points( $user->ID, $points_type );

                foreach( $mycred_ranks as $mycred_rank ) {

                    $rank = mycred_get_rank( $mycred_rank->ID );

                    // User just can reach a rank by points
                    if( $user_points >= $rank->minimum ) {

                        $post_id = $wpdb->get_var( $wpdb->prepare(
                            "SELECT pm.post_id FROM {$wpdb->postmeta} AS pm WHERE pm.meta_key = %s AND pm.meta_value = %d",
                            '_gamipress_mycred_legacy_id',
                            $mycred_rank->ID
                        ) );

                        // Just reach rank if is with a higher priority
                        if( gamipress_get_rank_priority( $post_id ) > gamipress_get_rank_priority( gamipress_get_user_rank_id( $user->ID, $rank_type ) ) ) {
                            gamipress_update_user_rank( $user->ID, $post_id );
                        }

                    }

                }

            }

        }

        // Set a meta to meet already imported users
        gamipress_update_user_meta( $user->ID, '_gamipress_imported_mycred_earnings', 1 );

    }

    // Check remaining users
    $users_to_import = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*)
        FROM {$wpdb->users}
        WHERE ID NOT IN (
          SELECT um.user_id FROM {$wpdb->usermeta} AS um WHERE um.meta_key = %s
        )",
        '_gamipress_imported_mycred_earnings'
    ) );

    if( absint( $users_to_import ) !== 0 ) {
        // Return a run again action
        wp_send_json_success( array(
            'run_again' => true,
            'message' => sprintf( __( 'Remaining users %d', 'gamipress' ), absint( $users_to_import ) )
        ) );
    } else {
        // Return a success message
        wp_send_json_success( __( 'myCRED earnings has been migrated successfully.', 'gamipress' ) );
    }

}
add_action( 'wp_ajax_gamipress_mycred_importer_import_earnings', 'gamipress_mycred_importer_ajax_import_earnings' );

/**
 * AJAX handler for the myCRED Importer logs import action
 *
 * @since 1.0.0
 */
function gamipress_mycred_importer_ajax_import_logs() {

    // Check user capabilities
    if( ! current_user_can( gamipress_get_manager_capability() ) ) {
        wp_send_json_error( __( 'You are not allowed to perform this action.', 'gamipress' ) );
    }

    global $wpdb;

    ignore_user_abort( true );
    set_time_limit( 0 );

    // Our prefix
    $prefix = '_gamipress_';

    // Setup vars
    $mycred_point_types = mycred_get_types();
    $points_types = gamipress_get_points_types();
    $achievements_types = gamipress_get_achievement_types();
    $rank_types = gamipress_get_rank_types();

    $mycred_log_table = mycred()->log_table;

    $ct_table = ct_setup_table( 'gamipress_logs' );

    $mycred_logs = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
        FROM {$mycred_log_table} AS l
        LEFT JOIN {$ct_table->meta->db->table_name} AS lm ON l.id = lm.meta_value AND lm.meta_key = %s
        WHERE lm.meta_value IS NULL
        LIMIT 0, 100",
        $prefix . 'mycred_legacy_id'
    ) );

    foreach( $mycred_logs as $mycred_log ) {

        $trigger = gamipress_mycred_importer_convert_to_gamipress_trigger( $mycred_log->ref );

        // Commented because not converted triggers causes infinite loop
        // if( $trigger || in_array( $mycred_log->ref, array( 'badge_reward', 'manual' ) ) ) {

            $type = 'event_trigger';

            if( $mycred_log->ref === 'badge_reward' ) {
                $type = 'achievement_earn';
            }

            $log_data = array(
                'title' => $mycred_log->entry,
                'type' => $type,
                'trigger_type' => ( $trigger ? $trigger : __( '(no trigger)', 'gamipress' ) ),
                'access' => 'public',
                'user_id' => absint( $mycred_log->user_id ),
                'date' => date( 'Y-m-d H:i:s', $mycred_log->time )
            );

            $log_id = $ct_table->db->insert( $log_data );

            if( $log_id ) {

                // Add the description
                $ct_table->meta->db->insert( array(
                    'log_id' => $log_id,
                    'meta_key' => $prefix . 'description',
                    'meta_value' => __( 'Log imported from myCRED', 'gamipress-mycred-importer' ),
                ) );

                // Trigger type
                if( $trigger ) {
                    $ct_table->meta->db->insert( array(
                        'log_id' => $log_id,
                        'meta_key' => $prefix . 'trigger_type',
                        'meta_value' => $trigger,
                    ) );
                }

                // Points
                $points_type = gamipress_sanitize_slug( $mycred_log->ctype );

                if( absint( $mycred_log->creds ) && isset( $points_types[$points_type] ) ) {
                    $ct_table->meta->db->insert( array(
                        'log_id' => $log_id,
                        'meta_key' => $prefix . 'points',
                        'meta_value' => absint( $mycred_log->creds ),
                    ) );

                    $ct_table->meta->db->insert( array(
                        'log_id' => $log_id,
                        'meta_key' => $prefix . 'points_type',
                        'meta_value' => $points_type,
                    ) );
                }

                // Achievement ID
                if( $mycred_log->ref === 'badge_reward' && absint( $mycred_log->ref_id ) ) {
                    $post_id = $wpdb->get_var( $wpdb->prepare(
                        "SELECT pm.post_id FROM {$wpdb->postmeta} AS pm WHERE pm.meta_key = %s AND pm.meta_value = %d",
                        '_gamipress_mycred_legacy_id',
                        $mycred_log->ref_id
                    ) );

                    if( $post_id ) {
                        $ct_table->meta->db->insert( array(
                            'log_id' => $log_id,
                            'meta_key' => $prefix . 'achievement_id',
                            'meta_value' => absint( $mycred_log->ref_id ),
                        ) );
                    }
                }

                // Post ID
                if( absint( $mycred_log->ref_id ) && $mycred_log->ref !== 'badge_reward' ) {
                    $ct_table->meta->db->insert( array(
                        'log_id' => $log_id,
                        'meta_key' => $prefix . 'achievement_post',
                        'meta_value' => absint( $mycred_log->ref_id ),
                    ) );
                }

                // To meet old ID
                $ct_table->meta->db->insert( array(
                    'log_id' => $log_id,
                    'meta_key' => $prefix . 'mycred_legacy_id',
                    'meta_value' => $mycred_log->id,
                ) );

            }

        //}

    }

    // Check remaining logs
    $logs_to_import = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(l.id)
        FROM {$mycred_log_table} AS l
        LEFT JOIN {$ct_table->meta->db->table_name} AS lm ON l.id = lm.meta_value AND lm.meta_key = %s
        WHERE lm.meta_value IS NULL",
        $prefix . 'mycred_legacy_id'
    ) );

    if( absint( $logs_to_import ) !== 0 ) {
        // Return a run again action
        wp_send_json_success( array(
            'run_again' => true,
            'message' => sprintf( __( 'Remaining logs %d', 'gamipress' ), absint( $logs_to_import ) )
        ) );
    } else {
        // Return a success message
        wp_send_json_success( __( 'myCRED logs has been migrated successfully.', 'gamipress' ) );
    }
}
add_action( 'wp_ajax_gamipress_mycred_importer_import_logs', 'gamipress_mycred_importer_ajax_import_logs' );

/**
 * Create a GamiPress requirement based on a myCRED hook setup
 *
 * @param $points_type_id
 * @param $points_type
 * @param $trigger
 * @param $hook_prefs
 */
function gamipress_mycred_importer_hook_to_requirement( $points_type_id, $points_type, $trigger, $hook_prefs ) {

    // Our prefix
    $prefix = '_gamipress_';

    // Check points
    $points = intval( $hook_prefs['creds'] );

    if( $points === 0 ) {
        return;
    }

    // Check limits
    $count = 1;
    $limit = 1;
    $limit_type = 'unlimited';

    if( isset( $hook_prefs['limit'] ) ) {

        $limit_parts = explode( '/', $hook_prefs['limit'] );

        $limit = absint( $limit_parts[0] );

        switch( $limit_parts[1] ) {
            case 'd':
                $limit_type = 'daily';
                break;
            case 'w':
                $limit_type = 'weekly';
                break;
            case 'm':
                $limit_type = 'monthly';
                break;
            case 'x':
            case 't':
            default:
                $limit_type = 'unlimited';
                break;
        }

    }

    // Some hooks has the limits config (for example, comments hook)
    if( isset( $hook_prefs['limits'] ) ) {

        if( isset( $hook_prefs['limits']['per_day'] ) && absint( $hook_prefs['limits']['per_day'] ) > 0 ) {
            $limit = absint( $hook_prefs['limits']['per_day'] );
            $limit_type = 'daily';
        }

        if( isset( $hook_prefs['limits']['per_post'] ) && absint( $hook_prefs['limits']['per_post'] ) > 0 ) {
            $count = absint( $hook_prefs['limits']['per_post'] );
        }

    }

    // If points is positive, then setup a points award, if not, then a points deduct
    $requirement_type = ( $points > 0 ? 'points-award' : 'points-deduct' );

    // Setup the requirement object
    $requirement_id = wp_insert_post( array(
        'post_type'   => $requirement_type,
        'post_status' => 'publish',
        'post_parent' => $points_type_id,
        'menu_order' => 0,
    ) );

    // Update requirement meta data
    update_post_meta( $requirement_id, $prefix . 'trigger_type', $trigger );
    update_post_meta( $requirement_id, $prefix . 'points', absint( $hook_prefs['creds'] ) ); // Points amount need to be positive (included for deducts)
    update_post_meta( $requirement_id, $prefix . 'points_type', $points_type );
    update_post_meta( $requirement_id, $prefix . 'maximum_earnings', 0 ); // By default, myCRED hooks has not maximum earnings
    update_post_meta( $requirement_id, $prefix . 'count', $count );
    update_post_meta( $requirement_id, $prefix . 'limit', $limit );
    update_post_meta( $requirement_id, $prefix . 'limit_type', $limit_type );

}

/**
 * Turns a myCRED hook type to a GamiPress trigger
 *
 * @param string $type
 *
 * @return string|false
 */
function gamipress_mycred_importer_convert_to_gamipress_trigger( $type ) {

    switch( $type ) {

        // WordPress triggers
        case 'registration':
        case 'logging_in':
            $trigger = 'gamipress_login';
            break;
        case 'site_visit':
            $trigger = 'gamipress_site_visit';
            break;
        case 'view_contents':
            $trigger = 'gamipress_specific_post_visit';
            break;
        case 'publishing_content':
            $trigger = 'gamipress_publish_post';
            break;
        case 'deleted_content':
            $trigger = 'gamipress_delete_post';
            break;
        case 'comments':
            $trigger = 'gamipress_new_comment';
            break;

        // GamiPress - Link

        case 'link_click':
            $trigger = 'gamipress_link_click';
            break;

        // GamiPress - Multimedia Content

        case 'video_view':
            $trigger = 'gamipress_multimedia_content_watch_video';
            break;

        // BuddyPress

        case 'hook_bp_profile':
        case 'hook_bp_groups':
            $trigger = 'integration';
            break;

        case 'update':
        case 'new_profile_update':
            $trigger = 'gamipress_bp_update_profile';
            break;
        case 'removed_update':
        case 'deleted_profile_update':
            $trigger = false;  // Not supported yet
            break;
        case 'avatar':
        case 'hook_bp_profile_avatar':
        case 'upload_avatar':
            $trigger = 'gamipress_bp_upload_avatar';
            break;
        case 'cover':
        case 'hook_bp_profile_cover':
        case 'upload_cover':
            $trigger = 'gamipress_bp_upload_cover_image';
            break;
        case 'new_friend':
        case 'new_friendship':
            $trigger = 'gamipress_bp_friendship_accepted';
            break;
        case 'leave_friend':
        case 'ended_friendship':
            $trigger = false;  // Not supported yet
            break;
        case 'new_comment':
            $trigger = 'gamipress_bp_new_activity_comment';
            break;
        case 'delete_comment':
        case 'comment_deletion':
            $trigger = false;  // Not supported yet
            break;
        case 'add_favorite':
        case 'fave_activity':
            $trigger = 'gamipress_bp_favorite_activity';
            break;
        case 'remove_favorite':
        case 'unfave_activity':
            $trigger = false;  // Not supported yet
            break;
        case 'message':
        case 'new_message':
            $trigger = 'gamipress_bp_send_message';
            break;
        case 'send_gift':
        case 'sending_gift':
            $trigger = false;  // Not supported yet
            break;

        case 'create':
            $trigger = 'gamipress_bp_new_group';
            break;
        case 'delete':
            $trigger = false;  // Not supported yet
            break;
        case 'new_topic':
        case 'hook_bp_groups_new_topic':
            $trigger = 'gamipress_bp_group_publish_activity';
            break;
        case 'edit_topic':
            $trigger = false;  // Not supported yet
            break;
        case 'new_post':
            $trigger = 'gamipress_bp_group_publish_activity';
            break;
        case 'edit_post':
            $trigger = false;  // Not supported yet
            break;
        case 'join':
            $trigger = 'gamipress_bp_join_group';
            break;
        case 'leave':
            $trigger = false;  // Not supported yet
            break;
        case 'avatar':
        case 'hook_bp_groups_avatar':
            $trigger = false;  // Not supported yet
            break;
        case 'cover':
        case 'hook_bp_groups_cover':
            $trigger = false;  // Not supported yet
            break;
        //case 'comments': // Commented to avoid issues with WordPress comments hook
        case 'hook_bp_groups_comments':
            $trigger = false;  // Not supported yet
            break;

        // bbPress

        case 'hook_bbpress':
            $trigger = 'integration';
            break;

        case 'new_forum':
            $trigger = 'gamipress_bbp_new_forum';
            break;
        case 'delete_forum':
            $trigger = false; // Not supported yet
            break;
        case 'new_topic':
        case 'hook_bbpress_new_topic':
        case 'new_forum_topic':
            $trigger = 'gamipress_bbp_new_topic';
            break;
		case 'delete_topic':
            $trigger = false; // Not supported yet
            break;
        case 'fav_topic':
            $trigger = 'gamipress_bbp_favorite_topic';
            break;
        case 'new_reply':
        case 'new_forum_reply':
            $trigger = 'gamipress_bbp_new_reply';
            break;
        case 'delete_reply':
            $trigger = false; // Not supported yet
            break;

        // Contact Form 7

        case 'contact_form_submission':
            $trigger = 'gamipress_wpcf7_new_form_submission';
            break;

        // Gravity Forms

        case 'gravity_form_submission':
            $trigger = 'gamipress_gf_new_form_submission';
            break;

        // AffiliateWP

        case 'affiliatewp':
            $trigger = 'integration';
            break;

        case 'affiliate_signup':
            $trigger = 'gamipress_affwp_register_affiliate';
            break;
        case 'affiliate_visit_referral':
            $trigger = 'gamipress_affwp_referral_visit';
            break;

        // WooCommerce

        case 'wooreview':
        case 'product_review':
            $trigger = 'gamipress_wc_new_review';
            break;

        default:
            $trigger = false;
            break;
    }

    return $trigger;

}