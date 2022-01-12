<?php
namespace BooklyCollaborativeServices\Backend\Modules\Appointments\ProxyProviders;

use Bookly\Backend\Modules\Appointments\Proxy;
use BooklyCollaborativeServices\Backend\Components;

/**
 * Class Shared
 * @package BooklyCollaborativeServices\Backend\Modules\Appointments
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function renderAddOnsComponents()
    {
        Components\Dialogs\Appointment\Dialog::render();
    }
}