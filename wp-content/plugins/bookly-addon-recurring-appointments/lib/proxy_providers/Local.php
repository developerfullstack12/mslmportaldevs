<?php
namespace BooklyRecurringAppointments\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;

/**
 * Class Local
 * @package BooklyRecurringAppointments\Lib
 */
class Local extends BooklyLib\Proxy\RecurringAppointments
{
    /**
     * @inheritDoc
     */
    public static function hideChildAppointments( $default, BooklyLib\CartItem $cart_item )
    {
        if (
            $cart_item->getSeriesUniqueId()
            && get_option( 'bookly_recurring_appointments_payment' ) === 'first'
            && ( ! $cart_item->getFirstInSeries() )
        ) {
            return true;
        }

        return $default;
    }
}