<?php
namespace BooklyCollaborativeServices\Backend\Modules\Calendar\ProxyProviders;

use Bookly\Backend\Modules\Calendar\Proxy;
use BooklyCollaborativeServices\Backend\Components;

/**
 * Class Shared
 * @package BooklyCollaborativeServices\Backend\Modules\Calendar\ProxyProviders
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