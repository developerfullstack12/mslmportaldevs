<?php
namespace BooklyRecurringAppointments\Frontend\Modules\Booking\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Frontend\Modules\Booking\Proxy;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Frontend\Modules\Booking\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function enqueueBookingScripts( array $depends )
    {
        self::enqueueScripts( array(
            'alias' => array( 'bookly-moment.min.js' ),
        ) );

        return $depends;
    }
}