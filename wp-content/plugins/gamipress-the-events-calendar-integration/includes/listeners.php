<?php
/**
 * Listeners
 *
 * @package GamiPress\The_Events_Calendar\Listeners
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * After saving a ticket listener
 *
 * @since 1.0.0
 *
 * @param int                           $post_id  Post ID of post the ticket is tied to
 * @param Tribe__Tickets__Ticket_Object $ticket   Ticket that was just saved
 * @param array                         $raw_data Ticket data
 * @param string                        $class    Commerce engine class
 */
function gamipress_the_events_calendar_after_save_ticket_listener( $post_id, $ticket, $raw_data, $class ) {

    $ticket_id = $ticket->ID;
    $event_id = $ticket->get_event_id();

    $provider = $ticket->get_provider();
    $attendees = $provider->get_attendees_by_id( $ticket_id );

    if ( empty( $attendees ) ) {
        return;
    }

    foreach( $attendees as $attendee ) {

        $user_id  = absint( $attendee['user_id'] );

        if( $class === 'Tribe__Tickets__RSVP' && $attendee['order_status'] === 'yes' ) {
            // RSVP

            // RSVP an event
            do_action( 'gamipress_the_events_calendar_rsvp_event', $event_id, $user_id, $ticket_id, $ticket );

            // RSVP a specific event
            do_action( 'gamipress_the_events_calendar_rsvp_specific_event', $event_id, $user_id, $ticket_id, $ticket );
        } else {
            // Ticket was bought

            // Purchase a ticket for an event
            do_action( 'gamipress_the_events_calendar_purchase_ticket', $event_id, $user_id, $ticket_id, $ticket );

            // Purchase a ticket for a specific event
            do_action( 'gamipress_the_events_calendar_purchase_ticket_specific_event', $event_id, $user_id, $ticket_id, $ticket );
        }

    }

}
add_action( 'event_tickets_after_save_ticket', 'gamipress_the_events_calendar_after_save_ticket_listener', 10, 4 );

/**
 * Action fired when an RSVP has had attendee tickets generated for it
 *
 * @param int    $product_id   RSVP ticket post ID
 * @param string $order_id     ID (hash) of the RSVP order
 * @param int    $qty          Quantity ordered
 * @param array  $attendee_ids List of attendee IDs generated.
 */
function gamipress_the_events_calendar_tickets_generated_listener( $product_id, $order_id, $qty, $attendee_ids ) {

    $attendees = tribe_tickets_get_attendees( $order_id, 'rsvp_order' );

    if ( empty( $attendees ) ) {
        return;
    }

    foreach ( $attendees as $attendee ) {

        $user_id  = absint( $attendee['user_id'] );
        $event_id = absint( $attendee['event_id'] );
        $ticket_id = absint( $attendee['ticket_id'] );

        if( $attendee['order_status'] === 'yes' ) {

            // RSVP an event
            do_action( 'gamipress_the_events_calendar_rsvp_event', $event_id, $user_id, $ticket_id );

            // RSVP a specific event
            do_action( 'gamipress_the_events_calendar_rsvp_specific_event', $event_id, $user_id, $ticket_id );

        }

    }

}
add_action( 'event_tickets_rsvp_tickets_generated_for_product', 'gamipress_the_events_calendar_tickets_generated_listener', 10, 4);
add_action( 'event_tickets_woocommerce_tickets_generated_for_product', 'gamipress_the_events_calendar_tickets_generated_listener', 10, 4);
add_action( 'event_tickets_tpp_tickets_generated_for_product', 'gamipress_the_events_calendar_tickets_generated_listener', 10, 4);

/**
 * Checkin listener
 *
 * @since 1.0.0
 *
 * @param int       $attendee_id    Attendee post ID
 * @param bool|null $qr             true if from QR checkin process
 */
function gamipress_the_events_calendar_checkin_listener( $attendee_id, $qr ) {

    if ( ! $attendee_id ) {
        return;
    }

    $attendees = tribe_tickets_get_attendees( $attendee_id, 'rsvp_order' );

    if ( empty( $attendees ) ) {
        return;
    }

    foreach ( $attendees as $attendee ) {

        $user_id  = absint( $attendee['user_id'] );
        $event_id = absint( $attendee['event_id'] );

        // Check-in at an event
        do_action( 'gamipress_the_events_calendar_checkin_event', $event_id, $user_id, $attendee_id, $qr );

        // Check-in at a specific event
        do_action( 'gamipress_the_events_calendar_checkin_specific_event', $event_id, $user_id, $attendee_id, $qr );

    }

}
add_action( 'event_tickets_checkin', 'gamipress_the_events_calendar_checkin_listener', 10, 2 );
add_action( 'rsvp_checkin', 'gamipress_the_events_calendar_checkin_listener', 10, 2 );
add_action( 'eddtickets_checkin', 'gamipress_the_events_calendar_checkin_listener', 10, 2 );
add_action( 'wootickets_checkin', 'gamipress_the_events_calendar_checkin_listener', 10, 2 );