<?php
namespace BooklyRecurringAppointments\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\Entities\Notification;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Lib\Shared
 */
class Shared extends BooklyLib\Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function prepareNotificationTitles( array $titles )
    {
        $titles[ Notification::TYPE_NEW_BOOKING_RECURRING ]                         = __( 'New recurring booking notification', 'bookly' );
        $titles[ Notification::TYPE_CUSTOMER_APPOINTMENT_STATUS_CHANGED_RECURRING ] = __( 'Notification about recurring appointment status changes', 'bookly' );

        return $titles;
    }

    /**
     * @inheritdoc
     */
    public static function prepareNotificationTypes( array $types, $gateway )
    {
        $types[] = Notification::TYPE_NEW_BOOKING_RECURRING;
        $types[] = Notification::TYPE_CUSTOMER_APPOINTMENT_STATUS_CHANGED_RECURRING;

        return $types;
    }

}