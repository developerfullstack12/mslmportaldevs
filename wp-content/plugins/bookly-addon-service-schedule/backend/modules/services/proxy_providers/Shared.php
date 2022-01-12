<?php
namespace BooklyServiceSchedule\Backend\Modules\Services\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Modules\Services\Proxy;
use BooklyServiceSchedule\Lib;

/**
 * Class Shared
 * @package BooklyServiceSchedule\Backend\Modules\Services\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function duplicateService( $source_id, $target_id )
    {
        foreach ( Lib\Entities\ServiceScheduleDay::query()->where( 'service_id', $source_id )->fetchArray() as $day ) {
            $new_day = new Lib\Entities\ServiceScheduleDay( $day );
            $new_day->setId( null )->setServiceId( $target_id )->save();
            foreach ( Lib\Entities\ServiceScheduleBreak::query()->where( 'service_schedule_day_id', $day['id'] )->fetchArray() as $break ) {
                $new_break = new Lib\Entities\ServiceScheduleBreak( $break );
                $new_break->setId( null )->setServiceScheduleDayId( $new_day->getId() )->save();
            }
        }
    }


    /**
     * @inheritDoc
     */
    public static function serviceCreated( BooklyLib\Entities\Service $service )
    {
        $sch_day = new Lib\Entities\ServiceScheduleDay();
        $sch_day->setServiceId( $service->getId() );
        $week = array( 1 => 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' );
        foreach ( $week as $day_index => $day ) {
            $item = clone $sch_day;
            $item->setDayIndex( $day_index )
                ->setStartTime( get_option( 'bookly_bh_' . $day . '_start' ) ?: null )
                ->setEndTime( get_option( 'bookly_bh_' . $day . '_end' ) ?: null )
                ->save();
        }
    }
}