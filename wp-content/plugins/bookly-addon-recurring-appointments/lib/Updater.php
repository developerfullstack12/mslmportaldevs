<?php
namespace BooklyRecurringAppointments\Lib;

use Bookly\Lib\Entities\Notification;

/**
 * Class Updates
 * @package BooklyRecurringAppointments\Lib
 */
class Updater extends \Bookly\Lib\Base\Updater
{
    function update_2_4()
    {
        /** @global \wpdb $wpdb */
        global $wpdb;

        $self = $this;
        $notifications_table  = $this->getTableName( 'bookly_notifications' );
        $notifications = array(
            'client_approved_recurring_appointment'   => array( 'type' => 'new_booking_recurring', 'name' => __( 'Notification to customer about approved recurring appointment', 'bookly' ) ),
            'client_cancelled_recurring_appointment'  => array( 'type' => 'ca_status_changed_recurring', 'name' => __( 'Notification to customer about cancelled recurring appointment', 'bookly' ) ),
            'client_pending_recurring_appointment'    => array( 'type' => 'new_booking_recurring', 'name' => __( 'Notification to customer about pending recurring appointment', 'bookly' ) ),
            'client_rejected_recurring_appointment'   => array( 'type' => 'ca_status_changed_recurring', 'name' => __( 'Notification to customer about rejected recurring appointment', 'bookly' ) ),
            'client_waitlisted_recurring_appointment' => array( 'type' => 'new_booking_recurring', 'name' => __( 'Notification to customer about placing on waiting list for recurring appointment', 'bookly' ) ),
            'staff_approved_recurring_appointment'    => array( 'type' => 'new_booking_recurring', 'name' => __( 'Notification to staff member about approved recurring appointment', 'bookly' ) ),
            'staff_cancelled_recurring_appointment'   => array( 'type' => 'ca_status_changed_recurring', 'name' => __( 'Notification to staff member about cancelled recurring appointment ', 'bookly' ) ),
            'staff_pending_recurring_appointment'     => array( 'type' => 'new_booking_recurring', 'name' => __( 'Notification to staff member about pending recurring appointment', 'bookly' ) ),
            'staff_rejected_recurring_appointment'    => array( 'type' => 'ca_status_changed_recurring', 'name' => __( 'Notification to staff member about rejected recurring appointment ', 'bookly' ) ),
            'staff_waitlisted_recurring_appointment'  => array( 'type' => 'new_booking_recurring', 'name' => __( 'Notification to staff member about placing on waiting list for recurring appointment', 'bookly' ) ),
        );

        // Set name
        $disposable_options[] = $this->disposable( __FUNCTION__ . '-1', function () use ( $self, $wpdb, $notifications_table, $notifications ) {
            if ( ! $self->existsColumn( 'bookly_notifications', 'name' ) ) {
                $self->alterTables( array(
                    'bookly_notifications' => array(
                        'ALTER TABLE `%s` ADD COLUMN `name` VARCHAR(255) NOT NULL DEFAULT "" AFTER `active`',
                    ),
                ) );
            }
            $update_name = 'UPDATE `' . $notifications_table . '` SET `name` = %s WHERE `type` = %s AND name = \'\'';
            foreach ( $notifications as $type => $value ) {
                $wpdb->query( $wpdb->prepare( $update_name, $value['name'], $type ) );
                switch ( substr( $type, 0, 6 ) ) {
                    case 'staff_':
                        $wpdb->query( sprintf( 'UPDATE `%s` SET `to_staff` = 1 WHERE `type` = "%s"', $notifications_table, $type ) );
                        break;
                    case 'client':
                        $wpdb->query( sprintf( 'UPDATE `%s` SET `to_customer` = 1 WHERE `type` = "%s"', $notifications_table, $type ) );
                        break;
                }
            }
        } );

        // WPML
        $disposable_options[] = $this->disposable( __FUNCTION__ . '-2', function () use ( $self, $wpdb, $notifications_table, $notifications ) {
            $records = $wpdb->get_results( $wpdb->prepare( 'SELECT id, `type`, `gateway` FROM `' . $notifications_table . '` WHERE COALESCE( `settings`, \'[]\' ) = \'[]\' AND `type` IN (' . implode( ', ', array_fill( 0, count( $notifications ), '%s' ) ) . ')', array_keys( $notifications ) ), ARRAY_A );
            $strings = array();
            foreach ( $records as $record ) {
                $type = $record['type'];
                if ( isset( $notifications[ $type ]['type'] ) && $type != $notifications[ $type ]['type'] ) {
                    $key   = sprintf( '%s_%s_%d', $record['gateway'], $type, $record['id'] );
                    $value = sprintf( '%s_%s_%d', $record['gateway'], $notifications[ $type ]['type'], $record['id'] );
                    $strings[ $key ] = $value;
                    if ( $record['gateway'] == 'email' ) {
                        $strings[ $key . '_subject' ] = $value . '_subject';
                    }
                }
            }
            $self->renameL10nStrings( $strings, false );
        } );

        // Add settings for notifications
        $disposable_options[] = $this->disposable( __FUNCTION__ . '-3', function () use ( $wpdb, $notifications_table, $notifications ) {
            $combined_notifications = get_option( 'bookly_cst_combined_notifications', 'missing' );
            if ( $combined_notifications === 'missing' ) {
                $combined_notifications = (bool) $wpdb->query( 'SELECT 1 FROM `' . $notifications_table . '` WHERE `type` = \'new_booking_combined\' AND `active` = 1 LIMIT 1' );
            }
            $combined_notifications_disabled = (int) ! $combined_notifications;
            $insert_from_select  = 'INSERT INTO `' . $notifications_table . '` (`gateway`, `name`, `subject`, `message`, `to_staff`, `to_customer`, `to_admin`, `attach_ics`, `attach_invoice`, `active`,  `settings`, `type`) 
                SELECT `gateway`, `name`, `subject`, `message`, `to_staff`, `to_customer`, `to_admin`, `attach_ics`, `attach_invoice`, %d, %s, %s
                  FROM `' . $notifications_table . '` WHERE id = %d';
            $update_settings     = 'UPDATE `' . $notifications_table . '` SET `type` = %s, `settings`= %s, `active` = %d WHERE id = %d';
            $default_settings    = json_decode( '{"status":"any","option":2,"services":{"any":"any","ids":[]},"offset_hours":2,"perform":"before","at_hour":9,"before_at_hour":18,"offset_before_hours":-24,"offset_bidirectional_hours":0}', true );
            $records = $wpdb->get_results( $wpdb->prepare( 'SELECT id, `type`, `gateway`, `message`, `subject`, `active`, `settings` FROM `' . $notifications_table . '` WHERE `type` IN (' . implode( ', ', array_fill( 0, count( $notifications ), '%s' ) ) . ')', array_keys( $notifications ) ), ARRAY_A );
            foreach ( $records as $record ) {
                if ( ! isset( $notifications[ $record['type'] ]['type'] )
                    || $notifications[ $record['type'] ]['type'] == $record['type']
                ) {
                    continue;
                }
                $clone_type = null;
                $new_type   = $notifications[ $record['type'] ]['type'];
                $new_active = $record['active'];
                $settings   = $default_settings;
                switch ( $record['type'] ) {
                    case 'client_approved_recurring_appointment';
                        $settings['status']   = 'approved';
                        $clone_type = ( $combined_notifications_disabled && $record['active'] ) ? 'ca_status_changed_recurring' : null;
                        $new_active = $combined_notifications_disabled ? $record['active'] : 0;
                        break;
                    case'client_cancelled_recurring_appointment':
                        $settings['status']   = 'cancelled';
                        $clone_type = $record['active'] ? 'new_booking_recurring' : null;
                        break;
                    case 'client_pending_recurring_appointment':
                        $settings['status']   = 'pending';
                        $new_active = $combined_notifications_disabled ? $record['active'] : 0;
                        break;
                    case 'client_rejected_recurring_appointment':
                        $settings['status']   = 'rejected';
                        $clone_type = $record['active'] ? 'new_booking_recurring' : null;
                        break;
                    case 'client_waitlisted_recurring_appointment':
                        $settings['status']   = 'waitlisted';
                        break;
                    case 'staff_approved_recurring_appointment':
                        $settings['status']   = 'approved';
                        $clone_type = $record['active'] ? 'ca_status_changed_recurring' : null;
                        break;
                    case 'staff_cancelled_recurring_appointment':
                        $settings['status']   = 'cancelled';
                        $clone_type = $record['active'] ? 'new_booking_recurring' : null;
                        break;
                    case 'staff_pending_recurring_appointment':
                        $settings['status']   = 'pending';
                        break;
                    case 'staff_rejected_recurring_appointment':
                        $settings['status']   = 'rejected';
                        $clone_type = $record['active'] ? 'new_booking_recurring' : null;
                        break;
                    case 'staff_waitlisted_recurring_appointment':
                        $settings['status']   = 'waitlisted';
                        break;
                }
                if ( $clone_type ) {
                    $wpdb->query( $wpdb->prepare( $insert_from_select, $new_active, json_encode( $settings ), $clone_type, $record['id'] ) );
                    $name = sprintf( '%s_%s_%d', $record['gateway'], $clone_type, $wpdb->insert_id );
                    do_action( 'wpml_register_single_string', 'bookly', $name, $record['message'] );
                    if ( $record['gateway'] == 'email' ) {
                        do_action( 'wpml_register_single_string', 'bookly', $name . '_subject', $record['subject'] );
                    }
                }
                $wpdb->query( $wpdb->prepare( $update_settings, $new_type, json_encode( $settings ), $new_active, $record['id'] ) );
            }
        } );

        foreach ( $disposable_options as $option_name ) {
            delete_option( $option_name );
        }
    }

    function update_2_2()
    {
        add_option( 'bookly_recurring_appointments_use_groups', '0' );
    }

    function update_1_9()
    {
        $this->addL10nOptions( array(
            'bookly_l10n_repeat_or'    => __( 'or',         'bookly' ),
            'bookly_l10n_repeat_times' => __( 'time(s)',    'bookly' ),
        ) );
    }

    function update_1_8()
    {
        $notifications = array(
            array(
                'gateway' => 'email',
                'type'    => 'client_waitlisted_recurring_appointment',
                'subject' =>  __( 'You have been added to waiting list for appointment', 'bookly' ),
                'message' => wpautop( __( "Dear {client_name}.\n\nThis is a confirmation that you have been added to the waiting list for {service_name} (x {recurring_count}).\n\nPlease find the service schedule below.\n\n{appointment_schedule}\n\nThank you for choosing our company.\n\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ) ),
                'active'  => 1,
            ),
            array(
                'gateway' => 'email',
                'type'    => 'staff_waitlisted_recurring_appointment',
                'subject' => __( 'New waiting list information', 'bookly' ),
                'message' => wpautop( __( "Hello.\n\nYou have new customer in the waiting list.\n\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ) ),
                'active'  => 1,
            ),
            array(
                'gateway' => 'sms',
                'type'    => 'client_waitlisted_recurring_appointment',
                'subject' => '',
                'message' => __( "Dear {client_name}.\nThis is a confirmation that you have been added to the waiting list for {service_name} (x {recurring_count}).\nPlease find the service schedule below.\n{appointment_schedule}\nThank you for choosing our company.\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
                'active'  => 1,
            ),
            array(
                'gateway' => 'sms',
                'type'    => 'staff_waitlisted_recurring_appointment',
                'subject' => '',
                'message' => __( "Hello.\nYou have new customer in the waiting list.\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
                'active'  => 1,
            ),
        );

        foreach ( $notifications as $data ) {
            $notification = new Notification( $data );
            $notification->save();
        }

        add_option( 'bookly_recurring_appointments_approve_page_url', home_url() );
        add_option( 'bookly_recurring_appointments_approve_denied_page_url', home_url() );
    }

    function update_1_2()
    {
        $this->addL10nOptions( array(
            'bookly_l10n_repeat_no_available_slots' => __( 'There are no available time slots for this day', 'bookly' ),
            'bookly_l10n_step_repeat_button_next'   => __( 'Next', 'bookly' ),
        ) );
    }

}