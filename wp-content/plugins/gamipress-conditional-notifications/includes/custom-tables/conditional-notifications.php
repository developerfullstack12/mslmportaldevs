<?php
/**
 * Conditional Notifications
 *
 * @package     GamiPress\Conditional_Notifications\Custom_Tables\Conditional_Notifications
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Define the search fields for logs
 *
 * @since 1.0.0
 *
 * @param array $search_fields
 *
 * @return array
 */
function gamipress_conditional_notifications_search_fields( $search_fields ) {

    $search_fields[] = 'title';

    return $search_fields;

}
add_filter( 'ct_query_gamipress_conditional_notifications_search_fields', 'gamipress_conditional_notifications_search_fields' );

/**
 * Columns for logs list view
 *
 * @since 1.2.8
 *
 * @param array $columns
 *
 * @return array
 */
function gamipress_manage_conditional_notifications_columns( $columns = array() ) {

    $columns['title']       = __( 'Title', 'gamipress-conditional-notifications' );
    $columns['max_displays']   = __( 'Max. Displays', 'gamipress-conditional-emails' );
    $columns['status']      = __( 'Status', 'gamipress-conditional-notifications' );
    $columns['date']        = __( 'Date', 'gamipress-conditional-notifications' );

    return $columns;
}
add_filter( 'manage_gamipress_conditional_notifications_columns', 'gamipress_manage_conditional_notifications_columns' );

/**
 * Sortable columns for logs list view
 *
 * @since 1.6.7
 *
 * @param array $sortable_columns
 *
 * @return array
 */
function gamipress_manage_conditional_notifications_sortable_columns( $sortable_columns ) {

    $sortable_columns['title']      = array( 'title', false );
    $sortable_columns['status']     = array( 'status', false );
    $sortable_columns['date']       = array( 'date', true );

    return $sortable_columns;

}
add_filter( 'manage_gamipress_conditional_notifications_sortable_columns', 'gamipress_manage_conditional_notifications_sortable_columns' );

/**
 * Columns rendering for list view
 *
 * @since  1.0.0
 *
 * @param string $column_name
 * @param integer $object_id
 */
function gamipress_conditional_notifications_manage_conditional_notifications_custom_column( $column_name, $object_id ) {

    // Setup vars
    $prefix = '_gamipress_conditional_notifications_';
    $conditional_notification = ct_get_object( $object_id );

    switch( $column_name ) {
        case 'title':
            ?>

            <strong>
                <a href="<?php echo ct_get_edit_link( 'gamipress_conditional_notifications', $conditional_notification->conditional_notification_id ); ?>"><?php echo $conditional_notification->title . ' (ID:' . $conditional_notification->conditional_notification_id . ')'; ?></a>
            </strong>

            <?php
            break;
        case 'max_displays':
            $displays = absint( ct_get_object_meta( $object_id, $prefix . 'displays', true ) );
            $max_displays = absint( ct_get_object_meta( $object_id, $prefix . 'max_displays', true ) );

            if( $max_displays === 0 )
                echo sprintf( __( 'Unlimited (%d displays)', 'gamipress-conditional-notifications' ), $displays );
            else
                echo $displays . '/' . $max_displays;

            break;
        case 'status':
            $statuses = gamipress_conditional_notifications_get_conditional_notification_statuses(); ?>

            <span class="gamipress-conditional-notifications-status gamipress-conditional-notifications-status-<?php echo $conditional_notification->status; ?>"><?php echo ( isset( $statuses[$conditional_notification->status] ) ? $statuses[$conditional_notification->status] : $conditional_notification->status ); ?></span>

            <?php
            break;
        case 'date':
            ?>

            <abbr title="<?php echo date( 'Y/m/d g:i:s a', strtotime( $conditional_notification->date ) ); ?>"><?php echo date( 'Y/m/d', strtotime( $conditional_notification->date ) ); ?></abbr>

            <?php
            break;
    }
}
add_action( 'manage_gamipress_conditional_notifications_custom_column', 'gamipress_conditional_notifications_manage_conditional_notifications_custom_column', 10, 2 );

/**
 * Default data when creating a new item (similar to WP auto draft) see ct_insert_object()
 *
 * @since  1.0.0
 *
 * @param array $default_data
 *
 * @return array
 */
function gamipress_conditional_notifications_default_data( $default_data = array() ) {

    $default_data['title'] = '';
    $default_data['status'] = 'inactive';
    $default_data['date'] = date( 'Y-m-d 00:00:00' );

    return $default_data;
}
add_filter( 'ct_gamipress_conditional_notifications_default_data', 'gamipress_conditional_notifications_default_data' );

/**
 * Register custom CMB2 meta boxes
 *
 * @since  1.0.0
 */
function gamipress_conditional_notifications_conditional_notifications_meta_boxes( ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_conditional_notifications_';

    // Title
    gamipress_add_meta_box(
        'gamipress-conditional-notification-title',
        __( 'Title', 'gamipress-conditional-notifications' ),
        'gamipress_conditional_notifications',
        array(
            'title' => array(
                'name' 	=> __( 'Title', 'gamipress-conditional-notifications' ),
                'type' 	=> 'text',
                'attributes' => array(
                    'placeholder' => __( 'Enter title here', 'gamipress-conditional-notifications' ),
                )
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Audio settings
    $audio_query_args = array(
        'type' => array(
            'audio/midi',
            'audio/mpeg',
            'audio/x-aiff',
            'audio/x-pn-realaudio',
            'audio/x-pn-realaudio-plugin',
            'audio/x-realaudio',
            'audio/x-wav',
        ),
    );

    // Notification Configuration
    gamipress_add_meta_box(
        'gamipress-conditional-notification-notification',
        __( 'Notification Configuration', 'gamipress-conditional-notifications' ),
        'gamipress_conditional_notifications',
        array(
            'subject' => array(
                'name' 	=> __( 'Title', 'gamipress-conditional-notifications' ),
                'type' 	=> 'text',
                'desc' 	=> __( 'Notification title (leave blank to hide it). For a list available tags, check next field description.', 'gamipress-conditional-notifications' ),
            ),
            'content' => array(
                'name' 	=> __( 'Content', 'gamipress-conditional-notifications' ),
                'desc' 	=> __( 'Notification content. Available tags:', 'gamipress-conditional-notifications' )
                    . ' ' . gamipress_conditional_notifications_get_pattern_tags_html(),
                'type' 	=> 'wysiwyg',
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Style Configuration
    gamipress_add_meta_box(
        'gamipress-conditional-notification-style',
        __( 'Notification Style &amp; Sound Effects', 'gamipress-conditional-notifications' ),
        'gamipress_conditional_notifications',
        array(

            // Sound settings

            $prefix . 'show_sound' => array(
                'name'    => __( 'Show notification sound effect', 'gamipress-conditional-notifications' ),
                'desc'    => __( 'Upload, choose or paste the URL of the notification sound to play when this notification gets displayed (leave blank to keep sound effect configured from settings).', 'gamipress-conditional-notifications' ),
                'type'    => 'file',
                'text'    => array(
                    'add_upload_file_text' => __( 'Add or Upload Audio', 'gamipress-conditional-notifications' ),
                ),
                'query_args' => $audio_query_args,
            ),
            $prefix . 'hide_sound' => array(
                'name'    => __( 'Hide notification sound effect', 'gamipress-conditional-notifications' ),
                'desc'    => __( 'Upload, choose or paste the URL of the notification sound to play when this notification gets hidden (leave blank to keep sound effect configured from settings).', 'gamipress-conditional-notifications' ),
                'type'    => 'file',
                'text'    => array(
                    'add_upload_file_text' => __( 'Add or Upload Audio', 'gamipress-conditional-notifications' ),
                ),
                'query_args' => $audio_query_args,
            ),

            // Color settings

            $prefix . 'background_color' => array(
                'name' => __( 'Background Color', 'gamipress-conditional-notifications' ),
                'desc' => __( 'Set the notification background color (leave blank to keep background color configured from settings).', 'gamipress-conditional-notifications' ),
                'type' => 'colorpicker',
                'options' => array( 'alpha' => true ),
            ),
            $prefix . 'title_color' => array(
                'name' => __( 'Title Color', 'gamipress-conditional-notifications' ),
                'desc' => __( 'Set the text color of the notification title (leave blank to keep title color configured from settings).', 'gamipress-conditional-notifications' ),
                'type' => 'colorpicker',
                'options' => array( 'alpha' => true ),
            ),
            $prefix . 'text_color' => array(
                'name' => __( 'Text Color', 'gamipress-conditional-notifications' ),
                'desc' => __( 'Set the text color of the notification content (leave blank to keep text color configured from settings).', 'gamipress-conditional-notifications' ),
                'type' => 'colorpicker',
                'options' => array( 'alpha' => true ),
            ),
            $prefix . 'link_color' => array(
                'name' => __( 'Link Color', 'gamipress-conditional-notifications' ),
                'desc' => __( 'Set the text color of the notification link (leave blank to keep link color configured from settings).', 'gamipress-conditional-notifications' ),
                'type' => 'colorpicker',
                'options' => array( 'alpha' => true ),
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Condition Configuration
    gamipress_add_meta_box(
        'gamipress-conditional-notification-condition',
        __( 'Condition Configuration', 'gamipress-conditional-notifications' ),
        'gamipress_conditional_notifications',
        array(
            $prefix . 'condition' => array(
                'name' 	    => __( 'Condition', 'gamipress-conditional-notifications' ),
                'type' 	    => 'select',
                'options'   => gamipress_conditional_notifications_get_conditional_notification_conditions()
            ),
            $prefix . 'points' => array(
                'name' 	    => __( 'Points', 'gamipress-conditional-notifications' ),
                'type' 	    => 'gamipress_points',
            ),
            $prefix . 'achievement_type' => array(
                'name'        => __( 'Achievement Type', 'gamipress-conditional-notifications' ),
                'type'        => 'select',
                'option_all'  => false,
                'option_none' => true,
                'options_cb'  => 'gamipress_options_cb_achievement_types',
            ),
            $prefix . 'achievement' => array(
                'name'              => __( 'Achievement', 'gamipress-conditional-notifications' ),
                'type'              => 'select',
                'classes' 	        => 'gamipress-post-selector',
                'attributes' 	    => array(
                    'data-post-type' => implode( ',',  gamipress_get_achievement_types_slugs() ),
                    'data-placeholder' => __( 'Select an achievement', 'gamipress-conditional-notifications' ),
                ),
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_posts'
            ),
            $prefix . 'rank' => array(
                'name'              => __( 'Rank', 'gamipress-conditional-notifications' ),
                'type'              => 'select',
                'classes' 	        => 'gamipress-post-selector',
                'attributes' 	    => array(
                    'data-post-type' => implode( ',',  gamipress_get_rank_types_slugs() ),
                    'data-placeholder' => __( 'Select a rank', 'gamipress-conditional-notifications' ),
                ),
                'default'           => '',
                'options_cb'        => 'gamipress_options_cb_posts'
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Conditional Notification Details
    gamipress_add_meta_box(
        'gamipress-conditional-notification-details',
        __( 'Details', 'gamipress-conditional-notifications' ),
        'gamipress_conditional_notifications',
        array(
            'status' => array(
                'name' 	=> __( 'Status', 'gamipress-conditional-notifications' ),
                'type' 	=> 'select',
                'options' => gamipress_conditional_notifications_get_conditional_notification_statuses()
            ),
            'date' => array(
                'name' 	=> __( 'Date', 'gamipress-conditional-notifications' ),
                'desc' 	=> __( 'Enter the conditional notification creation date. This field is important since first notification will be displayed <strong>after</strong> date selected.', 'gamipress-conditional-notifications' ),
                'type' 	=> 'text_date_timestamp',
            ),
            $prefix . 'max_displays' => array(
                'name' 	=> __( 'Maximum Displays', 'gamipress-conditional-notifications' ),
                'desc' 	=> __( 'Maximum number of times that this notification will be displayed (set 0 for no maximum).', 'gamipress-conditional-notifications' ),
                'type' 	=> 'text',
                'attributes' => array(
                    'type' => 'number'
                ),
                'default' => '0',
            ),
        ),
        array(
            'context' => 'side',
        )
    );

}
add_action( 'cmb2_admin_init', 'gamipress_conditional_notifications_conditional_notifications_meta_boxes' );

/**
 * Turns array of date and time into a valid mysql date on update object data
 *
 * @since 1.0.0
 *
 * @param array $object_data
 * @param array $original_object_data
 *
 * @return array
 */
function gamipress_conditional_notifications_insert_conditional_notification_data( $object_data, $original_object_data ) {

    global $ct_table;

    // If not is our custom table, return
    if( $ct_table->name !== 'gamipress_conditional_notifications' ) {
        return $object_data;
    }

    // Fix date format
    if( isset( $object_data['date'] ) && ! empty( $object_data['date'] ) ) {
        $object_data['date'] = date( 'Y-m-d 00:00:00', strtotime( $object_data['date'] ) );
    }

    return $object_data;

}
add_filter( 'ct_insert_object_data', 'gamipress_conditional_notifications_insert_conditional_notification_data', 10, 2 );