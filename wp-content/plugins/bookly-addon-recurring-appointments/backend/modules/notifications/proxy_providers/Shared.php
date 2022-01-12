<?php
namespace BooklyRecurringAppointments\Backend\Modules\Notifications\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Modules\Notifications\Proxy;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Notifications\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function prepareNotificationCodes( array $codes, $type )
    {
        $codes['series']['appointment_schedule'] = array( 'description' => __( 'Recurring appointments schedule', 'bookly' ) );
        $codes['series']['appointment_schedule_c'] = array( 'description' => __( 'Recurring appointments schedule with cancel', 'bookly' ) );
        $codes['series']['approve_appointment_schedule_url'] = array( 'description' => __( 'URL for approving the whole schedule', 'bookly' ) );
        $codes['series']['cancel_all_recurring_appointments'] = array( 'description' => __( 'Cancel all appointments in chain link', 'bookly' ) );
        $codes['series']['cancel_all_recurring_appointments_url'] = array( 'description' => __( 'URL of cancel all appointments link (to use inside <a> tag)', 'bookly' ) );
        $codes['series']['recurring_count'] = array( 'description' => __( 'Recurring appointments', 'bookly' ) );

        return $codes;
    }
}