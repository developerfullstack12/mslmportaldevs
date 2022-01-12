<?php
namespace BooklyRecurringAppointments\Lib;

use Bookly\Lib as BooklyLib;

/**
 * Class Installer
 * @package BooklyRecurringAppointments\Lib
 */
class Installer extends Base\Installer
{
    /** @var array */
    protected $notifications = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Notifications email & sms.
        $default_settings = json_decode( '{"status":"any","option":2,"services":{"any":"any","ids":[]},"offset_hours":2,"perform":"before","at_hour":9,"before_at_hour":18,"offset_before_hours":-24,"offset_bidirectional_hours":0}', true );
        $settings = $default_settings;
        $settings['status']   = 'approved';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to customer about approved recurring appointment', 'bookly' ),
            'subject'     => __( 'Your appointment information', 'bookly' ),
            'message'     => __( "Dear {client_name}.\n\nThis is a confirmation that you have booked {service_name} (x {recurring_count}).\n\nPlease find the schedule of your booking below.\n\n{appointment_schedule}\n\nWe are waiting you at {company_address}.\n\nThank you for choosing our company.\n\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'approved';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to staff member about approved recurring appointment', 'bookly' ),
            'subject'     => __( 'New booking information', 'bookly' ),
            'message'     => __( "Hello.\n\nYou have a new booking.\n\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'cancelled';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to customer about cancelled recurring appointment', 'bookly' ),
            'subject'     => __( 'Booking cancellation', 'bookly' ),
            'message'     => __( "Dear {client_name}.\n\nYour booking of {service_name} (x {recurring_count}) has been cancelled.\n\nReason: {cancellation_reason}\n\nPlease find the schedule of the cancelled booking below:\n\n{appointment_schedule}\n\nThank you for choosing our company.\n\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'cancelled';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to staff member about cancelled recurring appointment', 'bookly' ),
            'subject'     => __( 'Booking cancellation', 'bookly' ),
            'message'     => __( "Hello.\n\nThe following booking has been cancelled.\n\nReason: {cancellation_reason}\n\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'rejected';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to customer about rejected recurring appointment', 'bookly' ),
            'subject'     => __( 'Booking rejection', 'bookly' ),
            'message'     => __( "Dear {client_name}.\n\nYour booking of {service_name} (x {recurring_count}) has been rejected.\n\nReason: {cancellation_reason}\n\nPlease find the schedule of the cancelled booking below:\n\n{appointment_schedule}\n\nThank you for choosing our company.\n\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'rejected';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to staff member about rejected recurring appointment ', 'bookly' ),
            'subject'     => __( 'Booking rejection', 'bookly' ),
            'message'     => __( "Hello.\n\nThe following booking has been rejected.\n\nReason: {cancellation_reason}\n\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'waitlisted';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to customer about placing on waiting list for recurring appointment', 'bookly' ),
            'subject'     => __( 'You have been added to waiting list for appointment', 'bookly' ),
            'message'     => __( "Dear {client_name}.\n\nThis is a confirmation that you have been added to the waiting list for {service_name} (x {recurring_count}).\n\nPlease find the service schedule below.\n\n{appointment_schedule}\n\nThank you for choosing our company.\n\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'waitlisted';
        $this->notifications[] = array(
            'gateway'     => 'email',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to staff member about placing on waiting list for recurring appointment ', 'bookly' ),
            'subject'     => __( 'New waiting list information', 'bookly' ),
            'message'     => __( "Hello.\n\nYou have new customer in the waiting list.\n\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'approved';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to customer about approved recurring appointment', 'bookly' ),
            'message'     => __( "Dear {client_name}.\nThis is a confirmation that you have booked {service_name} (x {recurring_count}).\nPlease find the schedule of your booking below.\n{appointment_schedule}\n\nWe are waiting you at {company_address}.\nThank you for choosing our company.\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'approved';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to staff member about approved recurring appointment', 'bookly' ),
            'message'     => __( "Hello.\nYou have a new booking.\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'cancelled';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to customer about cancelled recurring appointment', 'bookly' ),
            'message'     => __( "Dear {client_name}.\nYour booking of {service_name} (x {recurring_count}) has been cancelled.\nReason: {cancellation_reason}\nPlease find the schedule of the cancelled booking below: {appointment_schedule}\nThank you for choosing our company.\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'cancelled';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to staff member about cancelled recurring appointment ', 'bookly' ),
            'message'     => __( "Hello.\nThe following booking has been cancelled.\nReason: {cancellation_reason}\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'rejected';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to customer about rejected recurring appointment', 'bookly' ),
            'message'     => __( "Dear {client_name}.\nYour booking of {service_name} (x {recurring_count}) has been rejected.\nReason: {cancellation_reason}\nPlease find the schedule of the cancelled booking below: {appointment_schedule}\nThank you for choosing our company.\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'rejected';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'ca_status_changed_recurring',
            'name'        => __( 'Notification to staff member about rejected recurring appointment ', 'bookly' ),
            'message'     => __( "Hello.\nThe following booking has been rejected.\nReason: {cancellation_reason}\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'waitlisted';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to customer about placing on waiting list for recurring appointment', 'bookly' ),
            'message'     => __( "Dear {client_name}.\nThis is a confirmation that you have been added to the waiting list for {service_name} (x {recurring_count}).\nPlease find the service schedule below.\n{appointment_schedule}\nThank you for choosing our company.\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
            'active'      => 1,
            'to_customer' => 1,
            'settings'    => $settings,
        );
        $settings = $default_settings;
        $settings['status']   = 'waitlisted';
        $this->notifications[] = array(
            'gateway'     => 'sms',
            'type'        => 'new_booking_recurring',
            'name'        => __( 'Notification to staff member about placing on waiting list for recurring appointment ', 'bookly' ),
            'message'     => __( "Hello.\nYou have new customer in the waiting list.\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
            'active'      => 1,
            'to_staff'    => 1,
            'settings'    => $settings,
        );

        $this->options = array(
            'bookly_recurring_appointments_enabled'    => '1',
            'bookly_l10n_step_repeat'                  => __( 'Repeat', 'bookly' ),
            'bookly_l10n_step_repeat_button_next'      => __( 'Next', 'bookly' ),
            'bookly_l10n_info_repeat_step'             => __( 'You selected a booking for {#each appointments as appointment delimited by ", "}{appointment.service_name} at {appointment.appointment_time} on {appointment.appointment_date}{/each}. If you would like to make this appointment recurring please check the box below and set appropriate parameters. Otherwise press Next button below.', 'bookly' ),
            'bookly_l10n_label_repeat'                 => __( 'Repeat', 'bookly' ),
            'bookly_l10n_repeat'                       => __( 'Repeat', 'bookly' ), //combobox
            'bookly_l10n_repeat_another_time'          => __( 'Another time', 'bookly' ),
            'bookly_l10n_repeat_biweekly'              => __( 'Biweekly', 'bookly' ),
            'bookly_l10n_repeat_daily'                 => __( 'Daily', 'bookly' ),
            'bookly_l10n_repeat_day'                   => __( 'Day', 'bookly' ),
            'bookly_l10n_repeat_days'                  => __( 'day(s)', 'bookly' ),
            'bookly_l10n_repeat_deleted'               => __( 'Deleted', 'bookly' ),
            'bookly_l10n_repeat_every'                 => __( 'every', 'bookly' ),
            'bookly_l10n_repeat_first_in_cart_info'    => __( 'The first recurring appointment was added to cart. You will be invoiced for the remaining appointments later.', 'bookly' ),
            'bookly_l10n_repeat_monthly'               => __( 'Monthly', 'bookly' ),
            'bookly_l10n_repeat_no_available_slots'    => __( 'There are no available time slots for this day', 'bookly' ),
            'bookly_l10n_repeat_on'                    => __( 'On', 'bookly' ),
            'bookly_l10n_repeat_on_week'               => __( 'On', 'bookly' ),
            'bookly_l10n_repeat_required_week_days'    => __( 'Please select some days', 'bookly' ),
            'bookly_l10n_repeat_schedule'              => __( 'Schedule', 'bookly' ),
            'bookly_l10n_repeat_schedule_help'         => __( 'Another time was offered on pages {list}.', 'bookly' ),
            'bookly_l10n_repeat_schedule_info'         => __( 'Some of the desired time slots are busy. System offers the nearest time slot instead. Click the Edit button to select another time if needed.', 'bookly' ),
            'bookly_l10n_repeat_specific'              => __( 'Specific day', 'bookly' ),
            'bookly_l10n_repeat_this_appointment'      => __( 'Repeat this appointment', 'bookly' ),
            'bookly_l10n_repeat_until'                 => __( 'Until', 'bookly' ),
            'bookly_l10n_repeat_weekly'                => __( 'Weekly', 'bookly' ),
            'bookly_l10n_repeat_first'                 => __( 'First', 'bookly' ),
            'bookly_l10n_repeat_second'                => __( 'Second', 'bookly' ),
            'bookly_l10n_repeat_third'                 => __( 'Third', 'bookly' ),
            'bookly_l10n_repeat_fourth'                => __( 'Fourth', 'bookly' ),
            'bookly_l10n_repeat_last'                  => __( 'Last', 'bookly' ),
            'bookly_l10n_repeat_or'                    => __( 'or', 'bookly' ),
            'bookly_l10n_repeat_times'                 => __( 'time(s)', 'bookly' ),
            'bookly_recurring_appointments_payment'    => 'all',
            'bookly_recurring_appointments_use_groups' => '0',
            // URL.
            'bookly_recurring_appointments_approve_page_url'        => home_url(),
            'bookly_recurring_appointments_approve_denied_page_url' => home_url(),
        );
    }

    public function loadData()
    {
        parent::loadData();

        // Insert notifications.
        foreach ( $this->notifications as $data ) {
            $notification = new BooklyLib\Entities\Notification();
            $notification->setFields( $data )->save();
        }
    }

    /**
     * Create tables in database.
     */
    public function createTables() { }

    /**
     * Uninstall.
     */
    public function removeData()
    {
        global $wpdb;

        parent::removeData();

        $notifications_table = $wpdb->prefix . 'bookly_notifications';
        $result              = $wpdb->query( "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$notifications_table' AND TABLE_SCHEMA=SCHEMA()" );
        if ( $result == 1 ) {
            foreach ( $this->notifications as $notification ) {
                @$wpdb->query( "DELETE FROM `{$notifications_table}` WHERE `type` = '{$notification['type']}'" );
            }
        }
    }

}