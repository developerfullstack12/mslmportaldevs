<?php
namespace BooklyServiceSchedule\Backend\Components\Dialogs\Service\Edit\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Service\Edit\Proxy;
use BooklyServiceSchedule\Lib;
use Bookly\Backend\Components\Schedule\Component as ScheduleComponent;

/**
 * Class Local
 * @package BooklyServiceSchedule\Backend\Components\Dialogs\Service\Edit\ProxyProviders
 */
class Local extends Proxy\ServiceSchedule
{
    /**
     * @inheritDoc
     */
    public static function getTabHtml( $service_id )
    {
        $schedule = new ScheduleComponent( 'service_schedule[start_time][{index}]', 'service_schedule[end_time][{index}]' );
        $working  = Lib\Entities\ServiceScheduleDay::query()
            ->select( 'start_time, end_time, day_index, id' )
            ->where( 'service_id', $service_id )
            ->indexBy( 'day_index' )
            ->fetchArray();
        $sch_day_ids = array();
        for ( $i = 1; $i <= 7; $i ++ ) {
            if ( isset( $working[ $i ] ) ) {
                $sch_day_ids[] = $working[ $i ]['id'];
                $schedule->addHours( $working[ $i ]['id'], $i, $working[ $i ]['start_time'], $working[ $i ]['end_time'] );
            }
        }

        $break_rows = Lib\Entities\ServiceScheduleBreak::query()
            ->select( 'id, service_schedule_day_id, start_time, end_time' )
            ->whereIn( 'service_schedule_day_id', $sch_day_ids )
            ->sortBy( 'start_time' )->fetchArray();
        foreach ( $break_rows as $break ) {
            $schedule->addBreak( $break['service_schedule_day_id'], $break['id'], $break['start_time'], $break['end_time'] );
        }

        return $schedule->render( false );
    }

    /**
     * @inheritDoc
     */
    public static function renderTab()
    {
        self::renderTemplate( 'schedule_tab' );
    }
}