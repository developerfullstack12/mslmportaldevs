<?php
namespace BooklyServiceSchedule\Backend\Components\Dialogs\Service\Edit;

use Bookly\Backend\Components\Schedule\BreakItem;
use Bookly\Lib as BooklyLib;
use BooklyServiceSchedule\Lib;

/**
 * Class Ajax
 * @package BooklyServiceSchedule\Backend\Components\Dialogs\Service\Edit
 */
class Ajax extends BooklyLib\Base\Ajax
{

    /**
     * Save break.
     */
    public static function saveBreak()
    {
        $id         = self::parameter( 'id', null );
        $service_id = self::parameter( 'service_id', null );
        $day_index  = self::parameter( 'index' );
        if ( $id ) {
            $schedule_break = Lib\Entities\ServiceScheduleBreak::find( $id );
        } else {
            $sch_day = Lib\Entities\ServiceScheduleDay::query()
                ->select( 'id' )
                ->where( 'service_id', $service_id )
                ->where( 'day_index',  $day_index )
                ->fetchRow();
            if ( $sch_day ) {
                $service_schedule_day_id = $sch_day['id'];
            } else {
                $sch_day = new Lib\Entities\ServiceScheduleDay();
                $sch_day->setServiceId( $service_id )
                    ->setDayIndex( $day_index )
                    ->save();
                $service_schedule_day_id = $sch_day->getId();
            }
            $schedule_break = new Lib\Entities\ServiceScheduleBreak();
            $schedule_break->setServiceScheduleDayId( $service_schedule_day_id );
        }
        $end_time   = self::parameter( 'end_time' );
        $start_time = self::parameter( 'start_time' );
        if ( self::isBreakIntervalAvailable( $start_time, $end_time, $service_id, $day_index, $id ) ) {
            $schedule_break->setStartTime( $start_time )
                ->setEndTime( $end_time )
                ->save();
            $break = new BreakItem( $schedule_break->getId(), $schedule_break->getStartTime(), $schedule_break->getEndTime() );

            wp_send_json_success( array(
                'html'     => $break->render( false ),
                'interval' => $break->getFormatedInterval(),
            ) );
        } else {
            wp_send_json_error( array( 'message' => __( 'The requested interval is not available', 'bookly' ) ) );
        }
    }

    /**
     * Delete break.
     */
    public static function deleteBreak()
    {
        Lib\Entities\ServiceScheduleBreak::query()
            ->where( 'id', self::parameter( 'id' ) )
            ->delete()
            ->execute();

        wp_send_json_success() ;
    }

    /**
     * Check break range is available.
     *
     * @param string $start_time
     * @param string $end_time
     * @param int    $service_id
     * @param int    $day_index
     * @param int    $self_id
     * @return bool
     */
    protected static function isBreakIntervalAvailable( $start_time, $end_time, $service_id, $day_index, $self_id = 0 )
    {
        if ( $start_time > $end_time ) {
            return false;
        }

        return Lib\Entities\ServiceScheduleBreak::query( 'sb' )
            ->leftJoin( 'ServiceScheduleDay', 'sd', 'sd.id = sb.service_schedule_day_id', 'BooklyServiceSchedule\Lib\Entities' )
            ->where( 'sd.service_id', $service_id )
            ->where( 'sd.day_index',  $day_index )
            ->whereNot( 'sb.id',      $self_id )
            ->whereLt( 'sb.start_time', $end_time )
            ->whereGt( 'sb.end_time', $start_time )
            ->count() == 0;
    }

}