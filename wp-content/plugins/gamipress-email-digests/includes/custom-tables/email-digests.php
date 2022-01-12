<?php
/**
 * Email Digests
 *
 * @package     GamiPress\Email_Digests\Custom_Tables\Email_Digests
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
function gamipress_email_digests_search_fields( $search_fields ) {

    $search_fields[] = 'title';

    return $search_fields;

}
add_filter( 'ct_query_gamipress_email_digests_search_fields', 'gamipress_email_digests_search_fields' );

/**
 * Columns for logs list view
 *
 * @since 1.2.8
 *
 * @param array $columns
 *
 * @return array
 */
function gamipress_manage_email_digests_columns( $columns = array() ) {

    $columns['title']       = __( 'Title', 'gamipress-email-digests' );
    $columns['periodicity'] = __( 'Periodicity', 'gamipress-email-digests' );
    $columns['status']      = __( 'Status', 'gamipress-email-digests' );
    $columns['date']        = __( 'Date', 'gamipress-email-digests' );

    return $columns;
}
add_filter( 'manage_gamipress_email_digests_columns', 'gamipress_manage_email_digests_columns' );

/**
 * Sortable columns for logs list view
 *
 * @since 1.6.7
 *
 * @param array $sortable_columns
 *
 * @return array
 */
function gamipress_manage_email_digests_sortable_columns( $sortable_columns ) {

    $sortable_columns['title']      = array( 'title', false );
    $sortable_columns['status']     = array( 'status', false );
    $sortable_columns['date']       = array( 'date', true );

    return $sortable_columns;

}
add_filter( 'manage_gamipress_email_digests_sortable_columns', 'gamipress_manage_email_digests_sortable_columns' );

/**
 * Columns rendering for email digest list view
 *
 * @since  1.0.0
 *
 * @param string $column_name
 * @param integer $object_id
 */
function gamipress_email_digests_manage_email_digests_custom_column( $column_name, $object_id ) {

    // Setup vars
    $prefix = '_gamipress_email_digests_';
    $email_digest = ct_get_object( $object_id );

    switch( $column_name ) {
        case 'title':
            ?>

            <strong>
                <a href="<?php echo ct_get_edit_link( 'gamipress_email_digests', $email_digest->email_digest_id ); ?>"><?php echo $email_digest->title . ' (ID:' . $email_digest->email_digest_id . ')'; ?></a>
            </strong>

            <?php
            break;
        case 'periodicity':
            $periodicity = ct_get_object_meta( $object_id, $prefix . 'periodicity', true );
            $periodicity_options = gamipress_email_digests_get_periodicity_options(); ?>

            <span class="gamipress-email-digests-periodicity gamipress-email-digests-periodicity-<?php echo $periodicity; ?>"><?php echo ( isset( $periodicity_options[$periodicity] ) ? $periodicity_options[$periodicity] : $periodicity ); ?></span>

            <?php
            break;
        case 'status':
            $statuses = gamipress_email_digests_get_email_digest_statuses(); ?>

            <span class="gamipress-email-digests-status gamipress-email-digests-status-<?php echo $email_digest->status; ?>"><?php echo ( isset( $statuses[$email_digest->status] ) ? $statuses[$email_digest->status] : $email_digest->status ); ?></span>

            <?php
            break;
        case 'date':
            ?>

            <abbr title="<?php echo date( 'Y/m/d g:i:s a', strtotime( $email_digest->date ) ); ?>"><?php echo date( 'Y/m/d', strtotime( $email_digest->date ) ); ?></abbr>

            <?php
            break;
    }
}
add_action( 'manage_gamipress_email_digests_custom_column', 'gamipress_email_digests_manage_email_digests_custom_column', 10, 2 );

/**
 * Default data when creating a new item (similar to WP auto draft) see ct_insert_object()
 *
 * @since  1.0.0
 *
 * @param array $default_data
 *
 * @return array
 */
function gamipress_email_digests_default_data( $default_data = array() ) {

    $default_data['title'] = '';
    $default_data['status'] = 'inactive';
    $default_data['date'] = date( 'Y-m-d 00:00:00' );

    return $default_data;
}
add_filter( 'ct_gamipress_email_digests_default_data', 'gamipress_email_digests_default_data' );

/**
 * Register custom email digests CMB2 meta boxes
 *
 * @since  1.0.0
 */
function gamipress_email_digests_email_digests_meta_boxes( ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_gamipress_email_digests_';

    // Title
    gamipress_add_meta_box(
        'gamipress-email-digest-title',
        __( 'Title', 'gamipress-email-digests' ),
        'gamipress_email_digests',
        array(
            'title' => array(
                'name' 	=> __( 'Title', 'gamipress-email-digests' ),
                'type' 	=> 'text',
                'attributes' => array(
                    'placeholder' => __( 'Enter title here', 'gamipress-email-digests' ),
                )
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Email Configuration
    gamipress_add_meta_box(
        'gamipress-email-digest-email',
        __( 'Email Configuration', 'gamipress-email-digests' ),
        'gamipress_email_digests',
        array(
            'subject' => array(
                'name' 	=> __( 'Subject', 'gamipress-email-digests' ),
                'type' 	=> 'text',
            ),
            'content' => array(
                'name' 	=> __( 'Content', 'gamipress-email-digests' ),
                'desc' 	=> __( 'Available tags:', 'gamipress-email-digests' )
                . ' ' . gamipress_email_digests_get_pattern_tags_html(),
                'type' 	=> 'wysiwyg',
            ),
        ),
        array(
            'priority' => 'core',
        )
    );

    // Periodicity
    gamipress_add_meta_box(
        'gamipress-email-digest-periodicity',
        __( 'Periodicity', 'gamipress-email-digests' ),
        'gamipress_email_digests',
        array(
            $prefix . 'periodicity' => array(
                'name' 	=> __( 'Periodicity', 'gamipress-email-digests' ),
                'type' 	=> 'select',
                'options' => gamipress_email_digests_get_periodicity_options()
            ),

            // Weekly

            $prefix . 'weekly_preference' => array(
                'name' 	=> __( 'Which day of the week you want to send the email?', 'gamipress-email-digests' ),
                'type' 	=> 'radio',
                'options' => array(
                    '1' => __( 'Monday', 'gamipress-email-digests' ),
                    '2' => __( 'Tuesday', 'gamipress-email-digests' ),
                    '3' => __( 'Wednesday', 'gamipress-email-digests' ),
                    '4' => __( 'Thursday', 'gamipress-email-digests' ),
                    '5' => __( 'Friday', 'gamipress-email-digests' ),
                    '6' => __( 'Saturday', 'gamipress-email-digests' ),
                    '7' => __( 'Sunday', 'gamipress-email-digests' ),
                ),
                'default' => '1',
            ),

            // Monthly

            $prefix . 'monthly_preference' => array(
                'name' 	=> __( 'Which day of the month you want to send the email?', 'gamipress-email-digests' ),
                'desc' 	=> '<br>' . __( 'If the day you set is higher that number of days of current month, the email will be sent the last day of the month.', 'gamipress-email-digests' )
                . '<br>' . __( 'For example, if you set this setting to 31 and month has 28 days, email will be sent the 28th day.', 'gamipress-email-digests' ),
                'type' 	=> 'text_small',
                'attributes' => array(
                    'type' => 'number',
                    'step' => 1,
                    'min' => 1,
                    'max' => 31,
                    'placeholder' => __( 'day', 'gamipress-email-digests' ),
                ),
            ),

            // Yearly

            $prefix . 'yearly_preference' => array(
                'name' 	=> __( 'Which day of which month of the year you want to send the email?', 'gamipress-email-digests' ),
                'desc' 	=> __( 'If the day you set is higher that number of days of current month, the email will be sent the last day of the month.', 'gamipress-email-digests' )
                    . '<br>' . __( 'For example, if you set this setting to 31 and month has 28 days, email will be sent the 28th day.', 'gamipress-email-digests' ),
                'type' 	=> 'day_month',
            ),

        )
    );

    // Email Digest Details
    gamipress_add_meta_box(
        'gamipress-email-digest-details',
        __( 'Email Digest Details', 'gamipress-email-digests' ),
        'gamipress_email_digests',
        array(
            'status' => array(
                'name' 	=> __( 'Status', 'gamipress-email-digests' ),
                'type' 	=> 'select',
                'options' => gamipress_email_digests_get_email_digest_statuses()
            ),
            'date' => array(
                'name' 	=> __( 'Date', 'gamipress-email-digests' ),
                'desc' 	=> __( 'Enter the email digest creation date. This field is important since first email will be sent <strong>after</strong> date selected.', 'gamipress-email-digests' ),
                'type' 	=> 'text_date_timestamp',
            ),
        ),
        array(
            'context' => 'side',
        )
    );

    // Email Digest Sends
    gamipress_add_meta_box(
        'gamipress-email-digest-sends',
        __( 'Sends', 'gamipress-email-digests' ),
        'gamipress_email_digests',
        array(
            'email_digest_sends' => array(
                'content_cb' => 'gamipress_email_digests_sends_table',
                'type' 	=> 'html',
            )
        )
    );

}
add_action( 'cmb2_admin_init', 'gamipress_email_digests_email_digests_meta_boxes' );

function gamipress_email_digests_sends_table( $field, $object_id, $object_type ) {

    ct_setup_table( 'gamipress_email_digests' );

    $email_digest = ct_get_object( $object_id );

    $sends = gamipress_email_digests_get_email_digest_sends( $object_id ); ?>

    <table class="widefat fixed striped comments wp-list-table comments-box email-digest-sends-list">

        <tbody id="the-comment-list" data-wp-lists="list:comment">

        <?php if( ! empty( $sends ) ) :
            foreach( $sends as $send ) :

            gamipress_email_digests_admin_render_send( $send, $email_digest );

            endforeach;
        else: ?>
            <p style="margin-left: 1em;"><?php echo __( 'No sends registered yet.', 'gamipress-email-digests' ) ?></p>
        <?php endif;?>

        </tbody>

    </table>

    <?php
}

/**
 * Render the given payment note
 *
 * @since 1.0.0
 *
 * @param stdClass $send
 * @param stdClass $email_digest
 */
function gamipress_email_digests_admin_render_send( $send, $email_digest ) {
    ?>

    <tr id="email-digest-send-<?php echo $send->email_digest_send_id ?>" class="comment email-digest-send byuser comment-author-admin depth-1 approved">
        <td class="comment column-comment has-row-actions column-primary">
            <p>
                <strong class="email-digest-send-title"><?php echo __( 'Email Send', 'gamipress-email-digests' ); ?></strong>
                <span class="email-digest-send-date"><?php echo date( 'Y/m/d', strtotime( $send->date ) ); ?></span>
                <br>
                <span class="email-digest-send-description"><?php echo $send->description; ?></span>
            </p>
        </td>
    </tr>

    <?php
}

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
function gamipress_email_digests_insert_email_digest_data( $object_data, $original_object_data ) {

    global $ct_table;

    // If not is our custom table, return
    if( $ct_table->name !== 'gamipress_email_digests' ) {
        return $object_data;
    }

    // Fix date format
    if( isset( $object_data['date'] ) && ! empty( $object_data['date'] ) ) {
        $object_data['date'] = date( 'Y-m-d 00:00:00', strtotime( $object_data['date'] ) );
    }

    return $object_data;

}
add_filter( 'ct_insert_object_data', 'gamipress_email_digests_insert_email_digest_data', 10, 2 );

/**
 * Setup misc publishing actions from submit meta box.
 *
 * @since 1.0.0
 *
 * @param object        $object         Object.
 * @param CT_Table      $ct_table       CT Table object.
 * @param bool          $editing        True if edit screen, false if is adding a new one.
 * @param CT_Edit_View  $view           Edit view object.
 */
function gamipress_email_digests_misc_publishing_actions( $object, $ct_table, $editing, $view ) {

    $email_digest_actions = array();

    $email_digest_actions['send_test_email'] = array(
        'label' => __( 'Send a test email', 'gamipress-email-digests' ),
        'icon' => 'dashicons-email-alt'
    );

    $email_digest_actions = apply_filters( 'gamipress_email_digests_email_digest_actions', $email_digest_actions, $object ); ?>

    <?php foreach( $email_digest_actions as $action => $action_args ) :

        // Setup action vars
        if( isset( $action_args['url'] ) && ! empty( $action_args['url'] ) ) {
            $url = $action_args['url'];
        } else {
            $url = add_query_arg( array( 'gamipress_email_digests_email_digest_action' => $action ) );
        }

        if( isset( $action_args['target'] ) && ! empty( $action_args['target'] ) ) {
            $target = $action_args['target'];
        } else {
            $target = '_self';
        } ?>

        <div class="misc-pub-section email-digest-action">

            <?php if( isset( $action_args['icon'] ) ) : ?><span class="dashicons <?php echo $action_args['icon']; ?>"></span><?php endif; ?>

            <a href="<?php echo $url; ?>" data-action="<?php echo $action; ?>" target="<?php echo $target; ?>">
                <span class="action-label"><?php echo $action_args['label']; ?></span>
            </a>

        </div>

    <?php endforeach; ?>

    <?php
}
add_action( 'ct_gamipress_email_digests_edit_screen_submit_meta_box_misc_publishing_actions', 'gamipress_email_digests_misc_publishing_actions', 10, 4 );

/**
 * Payment actions handler
 *
 * Fire hook gamipress_email_digests_process_email_digest_action_{$action}
 *
 * @since 1.0.0
 */
function gamipress_email_digests_handle_email_digest_actions() {

    if( isset( $_REQUEST['gamipress_email_digests_email_digest_action'] ) && isset( $_REQUEST['email_digest_id'] ) ) {

        $action = $_REQUEST['gamipress_email_digests_email_digest_action'];
        $email_digest_id = absint( $_REQUEST['email_digest_id'] );

        if( $email_digest_id !== 0 ) {

            /**
             * Hook gamipress_email_digests_process_email_digest_action_{$action}
             *
             * @since 1.0.0
             *
             * @param integer $email_digest_id
             */
            do_action( "gamipress_email_digests_process_email_digest_action_{$action}", $email_digest_id );

            // Redirect to the same URL but without the action var if action do not process a redirect
            wp_redirect( remove_query_arg( array( 'gamipress_email_digests_email_digest_action' ) ) );
            exit;

        }

    }

}
add_action( 'admin_init', 'gamipress_email_digests_handle_email_digest_actions' );

/**
 * Send test email action
 *
 * @since 1.0.0
 *
 * @param int $email_digest_id
 */
function gamipress_email_digests_send_test_email_action( $email_digest_id ) {

    ct_setup_table( 'gamipress_email_digests' );

    $email_digest = ct_get_object( $email_digest_id );

    $user = get_userdata( get_current_user_id() );

    gamipress_email_digests_send_email( $user, $email_digest->subject, $email_digest->content );

    $redirect = add_query_arg( array( 'message' => 'send_test_email' ), ct_get_edit_link( 'gamipress_email_digests', $email_digest_id ) );

    // Redirect to the same payment edit screen and with the var message
    wp_redirect( $redirect );
    exit;

}
add_action( 'gamipress_email_digests_process_email_digest_action_send_test_email', 'gamipress_email_digests_send_test_email_action' );

/**
 * Register custom messages
 *
 * @since 1.0.0
 *
 * @param array $messages
 *
 * @return array
 */
function gamipress_email_digests_register_custom_messages( $messages ) {

    $messages['send_test_email'] = __( 'Email sent successfully.', 'gamipress-email-digests' );

    return $messages;
}
add_filter( 'ct_table_updated_messages', 'gamipress_email_digests_register_custom_messages' );