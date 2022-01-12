<?php
namespace BooklyRecurringAppointments\Lib\Notifications\Assets\Item\ProxyProviders;

use Bookly\Lib\Notifications\Assets\Item\Codes;
use Bookly\Lib\Notifications\Assets\Item\Proxy;
use BooklyRecurringAppointments\Lib\Notifications\Assets\Item\ICS;

/**
 * Class Local
 * @package BooklyRecurringAppointments\Lib\Notifications\Assets\Item\ProxyProviders
 */
abstract class Local extends Proxy\RecurringAppointments
{
    /**
     * @inheritdoc
     */
    public static function createICS( Codes $codes )
    {
        return new ICS( $codes );
    }
}