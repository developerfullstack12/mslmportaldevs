<?php
namespace BooklyServiceSchedule\Backend\Components\Dialogs\Service\Edit\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Components\Dialogs\Service\Edit\Proxy;
use BooklyServiceSchedule\Lib;

/**
 * Class Shared
 * @package BooklyServiceSchedule\Backend\Components\Dialogs\Service\Edit\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function enqueueAssetsForServices()
    {
        self::enqueueStyles( array(
            'alias' => array( 'bookly-backend-globals', )
        ) );

        self::enqueueScripts( array(
            'module' => array( 'js/service-schedule.js' => array( 'bookly-backend-globals' ), ),
        ) );

        wp_localize_script( 'bookly-service-schedule.js', 'ServiceScheduleL10n', array(
            'are_you_sure' => __( 'Are you sure?', 'bookly' ),
            'saved'        => __( 'Settings saved.', 'bookly' ),
        ) );
    }

    /**
     * @inheritDoc
     */
    public static function updateService( array $alert, BooklyLib\Entities\Service $service, array $_post )
    {
        /** @var Lib\Entities\ServiceScheduleDay[] $days */
        $days = Lib\Entities\ServiceScheduleDay::query()->where( 'service_id', $service->getId() )->indexBy( 'id' )->find();
        foreach ( $_post['service_schedule']['start_time'] as $id => $value ) {
            $days[ $id ]->setStartTime( $value == '' ? null : $value )
                ->setEndTime( $_post['service_schedule']['end_time'][ $id ] )
                ->save();
        }

        return $alert;
    }
}