<?php
namespace BooklyRecurringAppointments\Backend\Modules\Calendar\ProxyProviders;

use Bookly\Backend\Modules\Calendar\Proxy;
use BooklyRecurringAppointments\Backend\Components;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Calendar\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function renderAddOnsComponents()
    {
        Components\Dialogs\Recurring\DeleteSeries::render();
        Components\Dialogs\Recurring\ShowSeries::render();
    }
}