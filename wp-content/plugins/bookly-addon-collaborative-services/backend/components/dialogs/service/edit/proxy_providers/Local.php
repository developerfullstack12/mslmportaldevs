<?php
namespace BooklyCollaborativeServices\Backend\Components\Dialogs\Service\Edit\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Service\Edit\Proxy;

/**
 * Class Local
 * @package BooklyCollaborativeServices\Backend\Modules\Services\ProxyProviders
 */
class Local extends Proxy\CollaborativeServices
{
    /**
     * @inheritdoc
     */
    public static function renderSubForm( array $service, array $service_collection )
    {
        self::renderTemplate( 'sub_form', compact( 'service', 'service_collection' ) );
    }
}