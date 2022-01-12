<?php
namespace BooklyServiceSchedule\Backend\Components\Dialogs\Appointment\Edit\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Appointment\Edit\Proxy\Shared as AppointmentEditProxy;

/**
 * Class Shared
 * @package BooklyServiceSchedule\Backend\Components\Dialogs\Appointment\Edit\ProxyProviders
 */
class Shared extends AppointmentEditProxy
{
    /**
     * @inheritDoc
     */
    public static function prepareL10n( $l10n )
    {
        $l10n['l10n']['notices']['interval_not_in_service_schedule'] = __( 'Selected period doesn\'t match service schedule', 'bookly' );
        $l10n['l10n']['notices']['overflow_capacity'] = __( 'The number of customers should not be more than %d', 'bookly' );

        return $l10n;
    }
}