<?php
namespace BooklyCollaborativeServices\Backend\Modules\Services\ProxyProviders;

use Bookly\Backend\Modules\Services\Proxy;
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
    public static function prepareServiceColors( array $colors, $service_id, $service_type )
    {
        if ( $service_type == Service::TYPE_COLLABORATIVE ) {
            $rows   = SubService::query( 'ss' )
                ->select( 's.id, s.color' )
                ->innerJoin( 'Service', 's', 'ss.sub_service_id = s.id' )
                ->where( 'ss.service_id', $service_id )
                ->sortBy( 'ss.position' )
                ->fetchArray();
            $colors = array(
                count( $rows ) > 0 ? $rows[0]['color'] : '-1',
                count( $rows ) > 1 ? $rows[ count( $rows ) - 1 ]['color'] : '-1',
                '-1'
            );
        }

        return $colors;
    }

    /**
     * @inheritdoc
     */
    public static function prepareServiceIcons( $icons )
    {
        $icons[ Service::TYPE_COLLABORATIVE ] = 'fas fa-align-left';

        return $icons;
    }

    /**
     * @inheritdoc
     */
    public static function prepareServiceTypes( $types )
    {
        $types[ Service::TYPE_COLLABORATIVE ] = __( 'Collaborative', 'bookly' );

        return $types;
    }
}