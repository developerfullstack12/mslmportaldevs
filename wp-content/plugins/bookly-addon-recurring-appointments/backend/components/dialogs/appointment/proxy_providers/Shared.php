<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Appointment\Edit\Proxy\Shared as AppointmentEditProxy;
use Bookly\Lib\Utils;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment
 */
class Shared extends AppointmentEditProxy
{
    /**
     * @inheritDoc
     */
    public static function prepareL10n( $l10n )
    {
        /** @var \WP_Locale $wp_locale */
        global $wp_locale;

        $weekdays = Local::getWeekDays();
        $weekday_abbrev = array_values( $wp_locale->weekday_abbrev );
        $days = array();
        foreach ( $weekdays as $i => $day ) {
            $days[] = array(
                'id' => $day,
                'title' => $weekday_abbrev[ $i ],
            );
        }

        $l10n['recurring'] = array(
            'types' => array(
                array( 'id' => 'daily', 'title' => __( 'Daily', 'bookly' ) ),
                array( 'id' => 'weekly', 'title' => __( 'Weekly', 'bookly' ) ),
                array( 'id' => 'biweekly', 'title' => __( 'Biweekly', 'bookly' ) ),
                array( 'id' => 'monthly', 'title' => __( 'Monthly', 'bookly' ) ),
            ),
            'monthly_items' => array(
                array( 'id' => 'day', 'title' => __( 'Specific day', 'bookly' ) ),
                array( 'id' => 'first', 'title' => __( 'First', 'bookly' ) ),
                array( 'id' => 'second', 'title' => __( 'Second', 'bookly' ) ),
                array( 'id' => 'third', 'title' => __( 'Third', 'bookly' ) ),
                array( 'id' => 'fourth', 'title' => __( 'Fourth', 'bookly' ) ),
                array( 'id' => 'last', 'title' => __( 'Last', 'bookly' ) ),
            ),
            'days' => $days,
        );
        $l10n['moment_format_time'] = Utils\DateTime::convertFormat( 'time', Utils\DateTime::FORMAT_MOMENT_JS );

        $l10n['l10n']['recurring'] = array(
            'all_appointments' => __( 'All appointments', 'bookly' ),
            'another_time' => __( 'Another time', 'bookly' ),
            'another_time_on_pages' => __( 'Another time was offered on pages', 'bookly' ),
            'apply' => __( 'Apply', 'bookly' ),
            'appointments_will_be_scheduled_at' => __( 'Appointments will be scheduled at', 'bookly' ),
            'back' => __( 'Back', 'bookly' ),
            'biweekly' => __( 'Biweekly', 'bookly' ),
            'daily' => __( 'Daily', 'bookly' ),
            'day' => __( 'Specific day', 'bookly' ),
            'days' => __( 'day(s)', 'bookly' ),
            'delete' => __( 'Delete', 'bookly' ),
            'deleted' => __( 'Deleted', 'bookly' ),
            'edit' => __( 'Edit', 'bookly' ),
            'every' => __( 'Every', 'bookly' ),
            'first' => __( 'First', 'bookly' ),
            'fourth' => __( 'Fourth', 'bookly' ),
            'last' => __( 'Last', 'bookly' ),
            'monthly' => __( 'Monthly', 'bookly' ),
            'next' => __( 'Next', 'bookly' ),
            'number_of_days_to_shift_appointments' => __( 'Number of days to shift appointments', 'bookly' ),
            'on' => __( 'On', 'bookly' ),
            'only_this_appointment' => __( 'Only this appointment', 'bookly' ),
            'or' => __( 'or', 'bookly' ),
            'repeat' => __( 'Repeat', 'bookly' ),
            'repeat_this_appointment' => __( 'Repeat this appointment', 'bookly' ),
            'reschedule_info' => __( 'You are going to reschedule the recurring appointment. Please select recurring appointments which should be rescheduled as well.', 'bookly' ),
            'restore' => __( 'Restore', 'bookly' ),
            'second' => __( 'Second', 'bookly' ),
            'some_slots_are_busy' => __( 'Some of the desired time slots are busy. System offers the nearest time slot instead. Click the Edit button to select another time if needed.', 'bookly' ),
            'third' => __( 'Third', 'bookly' ),
            'this_and_next_appointments'  => __( 'This and next appointments', 'bookly' ),
            'times' => __( 'time(s)', 'bookly' ),
            'until' => __( 'Until', 'bookly' ),
            'weekly' => __( 'Weekly', 'bookly' ),
        );

        $l10n['l10n']['view_series'] = __( 'View series', 'bookly' );
        $l10n['l10n']['notices']['until_cant_be_earlier'] = __( 'The "Until" date cannot be earlier than the date of the appointment', 'bookly' );

        return $l10n;
    }
}