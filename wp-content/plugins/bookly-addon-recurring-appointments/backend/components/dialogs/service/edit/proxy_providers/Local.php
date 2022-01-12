<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Service\Edit\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Service\Edit\Proxy;

/**
 * Class Local
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Service\Edit\ProxyProviders
 */
class Local extends Proxy\RecurringAppointments
{
    /**
     * @inheritdoc
     */
    public static function renderSubForm( array $service )
    {
        $frequencies = array( 'daily', 'weekly', 'biweekly', 'monthly' );
        $recurrence_frequencies = explode( ',', $service['recurrence_frequencies'] );

        self::renderTemplate( 'recurring', compact( 'service', 'recurrence_frequencies', 'frequencies' ) );
    }
}