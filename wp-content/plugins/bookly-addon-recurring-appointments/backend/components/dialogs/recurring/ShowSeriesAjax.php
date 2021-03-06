<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring;

use Bookly\Lib as BooklyLib;

/**
 * Class ShowSeriesAjax
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring
 */
class ShowSeriesAjax extends BooklyLib\Base\Ajax
{
    /**
     * @inheritDoc
     */
    protected static function permissions()
    {
        return array( '_default' => array( 'staff', 'supervisor' ) );
    }

    /**
     * Get Repeat data.
     */
    public static function getSeriesAppointments()
    {
        $appointments = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
            ->select( 'a.id, a.start_date, s.title service, s.duration, COALESCE(s.start_time_info,\'\') AS start_time_info, ca.units' )
            ->leftJoin( 'Appointment', 'a', 'a.id = ca.appointment_id' )
            ->leftJoin( 'Service', 's', 's.id = a.service_id' )
            ->where( 'ca.series_id', self::parameter( 'series_id' ) )
            ->sortBy( 'a.start_date' )
            ->fetchArray();

        wp_send_json_success( $appointments );
    }
}