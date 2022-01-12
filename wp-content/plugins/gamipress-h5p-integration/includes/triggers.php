<?php
/**
 * Triggers
 *
 * @package GamiPress\H5P\Triggers
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register plugin specific triggers
 *
 * @since  1.0.0
 *
 * @param array $triggers
 * @return mixed
 */
function gamipress_h5p_activity_triggers( $triggers ) {

    $triggers[__( 'H5P', 'gamipress-h5p-integration' )] = array(

        // Complete content
        'gamipress_h5p_complete_content'                                => __( 'Complete any interactive content', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content'                       => __( 'Complete a specific interactive content', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content_type'                  => __( 'Complete any interactive content of a specific type', 'gamipress-h5p-integration' ),

        // At 100%
        'gamipress_h5p_max_complete_content'                            => __( 'Complete any interactive content at maximum score', 'gamipress-h5p-integration' ),
        'gamipress_h5p_max_complete_specific_content'                   => __( 'Complete a specific interactive content at maximum score', 'gamipress-h5p-integration' ),
        'gamipress_h5p_max_complete_specific_content_type'              => __( 'Complete any interactive content of a specific type at maximum score', 'gamipress-h5p-integration' ),

        // Min Score
        'gamipress_h5p_complete_content_min_score'                      => __( 'Complete any interactive content with a minimum score', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content_min_score'             => __( 'Complete a specific interactive content with a minimum score', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content_type_min_score'        => __( 'Complete any interactive content of a specific type with a minimum score', 'gamipress-h5p-integration' ),

        // Max Score
        'gamipress_h5p_complete_content_max_score'                      => __( 'Complete any interactive content with a maximum score', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content_max_score'             => __( 'Complete a specific interactive content with a maximum score', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content_type_max_score'        => __( 'Complete any interactive content of a specific type with a maximum score', 'gamipress-h5p-integration' ),

        // Between Score
        'gamipress_h5p_complete_content_between_score'                  => __( 'Complete any interactive content on a range of scores', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content_between_score'         => __( 'Complete a specific interactive content on a range of scores', 'gamipress-h5p-integration' ),
        'gamipress_h5p_complete_specific_content_type_between_score'    => __( 'Complete any interactive content of a specific type on a range of scores', 'gamipress-h5p-integration' ),
    );

    return $triggers;

}
add_filter( 'gamipress_activity_triggers', 'gamipress_h5p_activity_triggers' );

/**
 * Build custom activity trigger label
 *
 * @since  1.0.0
 *
 * @param string    $title
 * @param integer   $requirement_id
 * @param array     $requirement
 *
 * @return string
 */
function gamipress_h5p_activity_trigger_label( $title, $requirement_id, $requirement ) {

    global $wpdb;

    $content_type = ( isset( $requirement['h5p_content_type'] ) ) ? $requirement['h5p_content_type'] : '';
    $score = ( isset( $requirement['h5p_score'] ) ) ? absint( $requirement['h5p_score'] ) : 0;
    $min_score = ( isset( $requirement['h5p_min_score'] ) ) ? absint( $requirement['h5p_min_score'] ) : 0;
    $max_score = ( isset( $requirement['h5p_max_score'] ) ) ? absint( $requirement['h5p_max_score'] ) : 0;

    switch( $requirement['trigger_type'] ) {

        // Complete specific content type event
        case 'gamipress_h5p_complete_specific_content_type':
            if( $content_type !== '' )
                return sprintf( __( 'Complete a %s', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_type_title( $content_type ) );
            break;
        // Complete specific content type at maximum score event
        case 'gamipress_h5p_max_complete_specific_content_type':
            if( $content_type !== '' )
                return sprintf( __( 'Complete a %s at maximum score', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_type_title( $content_type ) );
            break;

        // Min score
        case 'gamipress_h5p_complete_content_min_score':
            return sprintf( __( 'Completed an interactive content with a score of %d or higher', 'gamipress-h5p-integration' ), $score );
            break;
        case 'gamipress_h5p_complete_specific_content_min_score':
            $achievement_post_id = absint( $requirement['achievement_post'] );
            return sprintf( __( 'Complete %s with a score of %d or higher', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_title( $achievement_post_id ), $score );
            break;
        case 'gamipress_h5p_complete_specific_content_type_min_score':
            if( $content_type !== '' )
                return sprintf( __( 'Complete a %s with a score of %d or higher', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_type_title( $content_type ), $score );
            break;

        // Max score
        case 'gamipress_h5p_complete_content_max_score':
            return sprintf( __( 'Completed an interactive content with a score of %d or lower', 'gamipress-h5p-integration' ), $score );
            break;
        case 'gamipress_h5p_complete_specific_content_max_score':
            $achievement_post_id = absint( $requirement['achievement_post'] );
            return sprintf( __( 'Complete %s with a score of %d or lower', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_title( $achievement_post_id ), $score );
            break;
        case 'gamipress_h5p_complete_specific_content_type_max_score':
            if( $content_type !== '' )
                return sprintf( __( 'Complete a %s with a score of %d or lower', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_type_title( $content_type ), $score );
            break;

        // Between score
        case 'gamipress_h5p_complete_content_between_score':
            return sprintf( __( 'Completed an interactive content with a score between %d and %d', 'gamipress-h5p-integration' ), $min_score, $max_score );
            break;
        case 'gamipress_h5p_complete_specific_content_between_score':
            $achievement_post_id = absint( $requirement['achievement_post'] );
            return sprintf( __( 'Complete %s with a score between %d and %d', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_title( $achievement_post_id ), $min_score, $max_score );
            break;
        case 'gamipress_h5p_complete_specific_content_type_between_score':
            if( $content_type !== '' )
                return sprintf( __( 'Complete a %s with a score between %d and %d', 'gamipress-h5p-integration' ), gamipress_h5p_get_content_type_title( $content_type ), $min_score, $max_score );
            break;

    }

    return $title;
}
add_filter( 'gamipress_activity_trigger_label', 'gamipress_h5p_activity_trigger_label', 10, 3 );

/**
 * Register plugin specific activity triggers
 *
 * @since  1.0.0
 *
 * @param  array $specific_activity_triggers
 * @return array
 */
function gamipress_h5p_specific_activity_triggers( $specific_activity_triggers ) {

    $specific_activity_triggers['gamipress_h5p_complete_specific_content'] = array( 'h5p_contents' );
    $specific_activity_triggers['gamipress_h5p_max_complete_specific_content'] = array( 'h5p_contents' );
    $specific_activity_triggers['gamipress_h5p_complete_specific_content_min_score'] = array( 'h5p_contents' );
    $specific_activity_triggers['gamipress_h5p_complete_specific_content_max_score'] = array( 'h5p_contents' );
    $specific_activity_triggers['gamipress_h5p_complete_specific_content_between_score'] = array( 'h5p_contents' );

    return $specific_activity_triggers;

}
add_filter( 'gamipress_specific_activity_triggers', 'gamipress_h5p_specific_activity_triggers' );

/**
 * Register plugin specific activity triggers labels
 *
 * @since  1.0.0
 *
 * @param  array $specific_activity_trigger_labels
 * @return array
 */
function gamipress_h5p_specific_activity_trigger_label( $specific_activity_trigger_labels ) {

    $specific_activity_trigger_labels['gamipress_h5p_complete_specific_content'] = __( 'Complete %s', 'gamipress-h5p-integration' );
    $specific_activity_trigger_labels['gamipress_h5p_max_complete_specific_content'] = __( 'Complete %s at maximum score', 'gamipress-h5p-integration' );

    return $specific_activity_trigger_labels;
}
add_filter( 'gamipress_specific_activity_trigger_label', 'gamipress_h5p_specific_activity_trigger_label' );

/**
 * Get plugin specific activity trigger post title
 *
 * @since  1.0.0
 *
 * @param  string   $post_title
 * @param  integer  $specific_id
 * @param  string   $trigger_type
 *
 * @return string
 */
function gamipress_h5p_specific_activity_trigger_post_title( $post_title, $specific_id, $trigger_type ) {

    switch( $trigger_type ) {
        case 'gamipress_h5p_complete_specific_content':
        case 'gamipress_h5p_max_complete_specific_content':
        case 'gamipress_h5p_complete_specific_content_min_score':
        case 'gamipress_h5p_complete_specific_content_max_score':
        case 'gamipress_h5p_complete_specific_content_between_score':
            if( absint( $specific_id ) !== 0 ) {

                // Get the content title
                $content_title = gamipress_h5p_get_content_title( $specific_id );

                $post_title = $content_title;
            }
            break;
    }

    return $post_title;

}
add_filter( 'gamipress_specific_activity_trigger_post_title', 'gamipress_h5p_specific_activity_trigger_post_title', 10, 3 );

/**
 * Get plugin specific activity trigger permalink
 *
 * @since  1.0.0
 *
 * @param  string   $permalink
 * @param  integer  $specific_id
 * @param  string   $trigger_type
 * @param  integer  $site_id
 *
 * @return string
 */
function gamipress_h5p_specific_activity_trigger_permalink( $permalink, $specific_id, $trigger_type, $site_id ) {

    switch( $trigger_type ) {
        case 'gamipress_h5p_complete_specific_content':
        case 'gamipress_h5p_max_complete_specific_content':
        case 'gamipress_h5p_complete_specific_content_min_score':
        case 'gamipress_h5p_complete_specific_content_max_score':
        case 'gamipress_h5p_complete_specific_content_between_score':
            $permalink = '';
            break;
    }

    return $permalink;

}
add_filter( 'gamipress_specific_activity_trigger_permalink', 'gamipress_h5p_specific_activity_trigger_permalink', 10, 4 );

/**
 * Get user for a h5pn trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer $user_id user ID to override.
 * @param  string  $trigger Trigger name.
 * @param  array   $args    Passed trigger args.
 * @return integer          User ID.
 */
function gamipress_h5p_trigger_get_user_id( $user_id, $trigger, $args ) {

    switch ( $trigger ) {
        // Complete content
        case 'gamipress_h5p_complete_content':
        case 'gamipress_h5p_complete_specific_content':
        case 'gamipress_h5p_complete_specific_content_type':
        // At 100%
        case 'gamipress_h5p_max_complete_content':
        case 'gamipress_h5p_max_complete_specific_content':
        case 'gamipress_h5p_max_complete_specific_content_type':
        // Min score
        case 'gamipress_h5p_complete_content_min_score':
        case 'gamipress_h5p_complete_specific_content_min_score':
        case 'gamipress_h5p_complete_specific_content_type_min_score':
        // Max score
        case 'gamipress_h5p_complete_content_max_score':
        case 'gamipress_h5p_complete_specific_content_max_score':
        case 'gamipress_h5p_complete_specific_content_type_max_score':
        // Between score
        case 'gamipress_h5p_complete_content_between_score':
        case 'gamipress_h5p_complete_specific_content_between_score':
        case 'gamipress_h5p_complete_specific_content_type_between_score':
            $user_id = $args[1];
            break;
    }

    return $user_id;

}
add_filter( 'gamipress_trigger_get_user_id', 'gamipress_h5p_trigger_get_user_id', 10, 3 );

/**
 * Get the id for a h5pn specific trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer  $specific_id Specific ID.
 * @param  string  $trigger Trigger name.
 * @param  array   $args    Passed trigger args.
 *
 * @return integer          Specific ID.
 */
function gamipress_h5p_specific_trigger_get_id( $specific_id, $trigger = '', $args = array() ) {

    switch ( $trigger ) {
        case 'gamipress_h5p_complete_specific_content':
        case 'gamipress_h5p_max_complete_specific_content':
        case 'gamipress_h5p_complete_specific_content_min_score':
        case 'gamipress_h5p_complete_specific_content_max_score':
        case 'gamipress_h5p_complete_specific_content_between_score':
            $specific_id = $args[2];
            break;
    }

    return $specific_id;
}
add_filter( 'gamipress_specific_trigger_get_id', 'gamipress_h5p_specific_trigger_get_id', 10, 3 );

/**
 * Extended meta data for event trigger logging
 *
 * @since 1.0.0
 *
 * @param array 	$log_meta
 * @param integer 	$user_id
 * @param string 	$trigger
 * @param integer 	$site_id
 * @param array 	$args
 *
 * @return array
 */
function gamipress_h5p_log_event_trigger_meta_data( $log_meta, $user_id, $trigger, $site_id, $args ) {

    switch ( $trigger ) {
        // Complete content
        case 'gamipress_h5p_complete_content':
        case 'gamipress_h5p_complete_specific_content':
        case 'gamipress_h5p_complete_specific_content_type':
        // At 100%
        case 'gamipress_h5p_max_complete_content':
        case 'gamipress_h5p_max_complete_specific_content':
        case 'gamipress_h5p_max_complete_specific_content_type':
            // Add the result ID, content ID and the content type
            $log_meta['result_id'] = $args[0];
            $log_meta['content_id'] = $args[2];
            $log_meta['content_type'] = $args[3];
            break;
        // Min score
        case 'gamipress_h5p_complete_content_min_score':
        case 'gamipress_h5p_complete_specific_content_min_score':
        case 'gamipress_h5p_complete_specific_content_type_min_score':
        // Max score
        case 'gamipress_h5p_complete_content_max_score':
        case 'gamipress_h5p_complete_specific_content_max_score':
        case 'gamipress_h5p_complete_specific_content_type_max_score':
        // Between score
        case 'gamipress_h5p_complete_content_between_score':
        case 'gamipress_h5p_complete_specific_content_between_score':
        case 'gamipress_h5p_complete_specific_content_type_between_score':
            // Add the result ID, content ID, the content type and the score
            $log_meta['result_id'] = $args[0];
            $log_meta['content_id'] = $args[2];
            $log_meta['content_type'] = $args[3];
            $log_meta['score'] = $args[4];
            break;
    }

    return $log_meta;
}
add_filter( 'gamipress_log_event_trigger_meta_data', 'gamipress_h5p_log_event_trigger_meta_data', 10, 5 );

/**
 * Extra data fields
 *
 * @since 1.0.4
 *
 * @param array     $fields
 * @param int       $log_id
 * @param string    $type
 *
 * @return array
 */
function gamipress_h5p_log_extra_data_fields( $fields, $log_id, $type ) {

    global $wpdb;

    $prefix = '_gamipress_';

    if( $type !== 'event_trigger' ) {
        return $fields;
    }

    $log = ct_get_object( $log_id );
    $trigger = $log->trigger_type;

    switch( $trigger ) {
        // Complete content
        case 'gamipress_h5p_complete_content':
        case 'gamipress_h5p_complete_specific_content':
        case 'gamipress_h5p_complete_specific_content_type':
            // At 100%
        case 'gamipress_h5p_max_complete_content':
        case 'gamipress_h5p_max_complete_specific_content':
        case 'gamipress_h5p_max_complete_specific_content_type':

            $fields[] = array(
                'name' 	            => __( 'Result', 'gamipress-h5p-integration' ),
                'desc' 	            => __( 'Result attached to this log.', 'gamipress-h5p-integration' ),
                'id'   	            => $prefix . 'result_id',
                'type' 	            => 'text',
            );

            $fields[] = array(
                'name' 	            => __( 'Content', 'gamipress-h5p-integration' ),
                'desc' 	            => __( 'Content attached to this log.', 'gamipress-h5p-integration' ),
                'id'   	            => $prefix . 'content_id',
                'type' 	            => 'text',
            );

            // Get active libraries
            $options = array();
            $content_types = $wpdb->get_results(
                "SELECT l.name, l.title
                FROM {$wpdb->prefix}h5p_libraries AS l
                WHERE l.runnable = 1"
            );

            foreach( $content_types as $content_type ) {
                $options[$content_type->name] = $content_type->title;
            }

            $fields[] = array(
                'name' 	            => __( 'Content Type', 'gamipress-h5p-integration' ),
                'desc' 	            => __( 'Content type attached to this log.', 'gamipress-h5p-integration' ),
                'id'   	            => $prefix . 'content_type',
                'type' 	            => 'select',
                'options'           => $options
            );

            break;
        // Min score
        case 'gamipress_h5p_complete_content_min_score':
        case 'gamipress_h5p_complete_specific_content_min_score':
        case 'gamipress_h5p_complete_specific_content_type_min_score':
            // Max score
        case 'gamipress_h5p_complete_content_max_score':
        case 'gamipress_h5p_complete_specific_content_max_score':
        case 'gamipress_h5p_complete_specific_content_type_max_score':
            // Between score
        case 'gamipress_h5p_complete_content_between_score':
        case 'gamipress_h5p_complete_specific_content_between_score':
        case 'gamipress_h5p_complete_specific_content_type_between_score':

            $fields[] = array(
                'name' 	            => __( 'Result', 'gamipress-h5p-integration' ),
                'desc' 	            => __( 'Result attached to this log.', 'gamipress-h5p-integration' ),
                'id'   	            => $prefix . 'result_id',
                'type' 	            => 'text',
            );

            $fields[] = array(
                'name' 	            => __( 'Content', 'gamipress-h5p-integration' ),
                'desc' 	            => __( 'Content attached to this log.', 'gamipress-h5p-integration' ),
                'id'   	            => $prefix . 'content_id',
                'type' 	            => 'text',
            );

            // Get active libraries
            $options = array();
            $content_types = $wpdb->get_results(
                "SELECT l.name, l.title
                    FROM {$wpdb->prefix}h5p_libraries AS l
                    WHERE l.runnable = 1"
            );

            foreach( $content_types as $content_type ) {
                $options[$content_type->name] = $content_type->title;
            }

            $fields[] = array(
                'name' 	            => __( 'Content Type', 'gamipress-h5p-integration' ),
                'desc' 	            => __( 'Content type attached to this log.', 'gamipress-h5p-integration' ),
                'id'   	            => $prefix . 'content_type',
                'type' 	            => 'select',
                'options'           => $options
            );

            $fields[] = array(
                'name' 	            => __( 'Score', 'gamipress-h5p-integration' ),
                'desc' 	            => __( 'Score attached to this log.', 'gamipress-h5p-integration' ),
                'id'   	            => $prefix . 'score',
                'type' 	            => 'text',
            );

            break;
    }

    return $fields;

}
add_filter( 'gamipress_log_extra_data_fields', 'gamipress_h5p_log_extra_data_fields', 10, 3 );