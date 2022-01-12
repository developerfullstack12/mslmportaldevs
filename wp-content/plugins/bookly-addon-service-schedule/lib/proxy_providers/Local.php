<?php
namespace BooklyServiceSchedule\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use BooklyServiceSchedule\Lib;

/**
 * Class Local
 * @package BooklyServiceSchedule\Lib\ProxyProviders
 */
abstract class Local extends BooklyLib\Proxy\ServiceSchedule
{
    /**
     * @inheritdoc
     */
    public static function getSchedule( $service_id )
    {
        return Lib\Entities\ServiceScheduleDay::query( 'sd' )
            ->select( 'sd.start_time, sd.end_time, sd.day_index,
                sb.start_time AS break_start,
                sb.end_time AS break_end' )
            ->leftJoin( 'ServiceScheduleBreak', 'sb', 'sb.service_schedule_day_id = sd.id', 'BooklyServiceSchedule\Lib\Entities' )
            ->where( 'sd.service_id', $service_id )
            ->whereNot( 'sd.start_time', null )
            ->fetchArray();
    }

}