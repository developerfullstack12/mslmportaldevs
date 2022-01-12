<?php
namespace BooklyCollaborativeServices\Backend\Components\Dialogs\Appointment\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Appointment\Edit\Proxy;

/**
 * Class Shared
 * @package BooklyCollaborativeServices\Backend\Components\Dialogs\Appointment\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function prepareL10n( $l10n )
    {
        $l10n['l10n']['part_of_collaborative_services'] = __( 'Part of collaborative service', 'bookly' );

        return $l10n;
    }
}