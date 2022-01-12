<?php
namespace BooklyCollaborativeServices\Backend\Components\Dialogs\Service\Edit\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Service\Edit\Proxy;
use Bookly\Lib\Entities\Service;
use Bookly\Lib\Entities\SubService;

/**
 * Class Shared
 * @package BooklyCollaborativeServices\Backend\Modules\Services\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function enqueueAssetsForServices()
    {
        self::enqueueScripts( array(
            'module' => array( 'js/collaborative-services.js' => array( 'jquery' ), ),
        ) );
    }

    /**
     * @inheritdoc
     */
    public static function prepareUpdateService( array $data )
    {
        if ( $data['type'] == Service::TYPE_COLLABORATIVE ) {
            $ids = array();
            if ( isset ( $data['sub_services'] ) && is_array( $data['sub_services'] ) ) {
                /** @var SubService[] $sub_services */
                $sub_services = SubService::query()
                    ->where( 'service_id', $data['id'] )
                    ->find()
                ;
                foreach ( $data['sub_services'] as $position => $item ) {
                    $sub_service = array_shift( $sub_services );
                    if ( ! $sub_service ) {
                        // Create new sub-service item.
                        $sub_service = new SubService();
                        $sub_service->setServiceId( $data['id'] );
                    }
                    if ( $item['sub_service_id'] != 0) {
                        $sub_service
                            ->setType( SubService::TYPE_SERVICE )
                            ->setSubServiceId( $item['sub_service_id'] )
                            ->setDuration( null )
                        ;
                    }
                    $sub_service
                        ->setPosition( $position )
                        ->save()
                    ;
                    $ids[] = $sub_service->getId();
                }
            }
            // Delete redundant items.
            SubService::query()
                ->delete()
                ->where( 'service_id', $data['id'] )
                ->whereNotIn( 'id', $ids )
                ->execute()
            ;
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public static function prepareAfterServiceList( $html, array $service_collection )
    {
        return $html . self::renderTemplate( 'sub_service_templates', compact( 'service_collection' ), false );
    }
}