<?php
namespace BooklyServiceSchedule\Backend\Components\Dialogs\Appointment\Edit\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Appointment\Edit\Proxy;
use Bookly\Lib as BooklyLib;
use Bookly\Lib\Utils\DateTime;
use BooklyServiceSchedule\Lib;

/**
 * Class Local
 * @package BooklyServiceSchedule\Backend\Components\Dialogs\Appointment\Edit\ProxyProviders
 */
abstract class Local extends Proxy\ServiceSchedule
{
    /**
     * @inheritDoc
     */
    public static function checkAppointmentErrors( $result, $start_date, $end_date, $service_id, $service_duration )
    {
        $start = date_create( $start_date );
        $end = date_create( $end_date );
        $schedule_items = array();
        foreach ( Lib\ProxyProviders\Local::getSchedule( $service_id ) as $item ) {
            $schedule_items[ $item['day_index']][] = $item;
        }
        $special_days = array();
        foreach ( (array) BooklyLib\Proxy\SpecialDays::getServiceSchedule( $service_id, $start, $end ) as $day ) {
            $special_days[ $day['date'] ][] = $day;
        }

        $interval_valid = true;

        // Check service schedule days off
        $date = clone $start;
        while ( $date < $end ) {
            if (
                ! isset ( $special_days[ $date->format( 'Y-m-d' ) ] ) &&
                ! isset ( $schedule_items[ $date->format( 'w' ) + 1 ] )
            ) {
                $interval_valid = false;
                break;
            }
            $date->modify( '+1 day' );
        }

        if ( $interval_valid && $service_duration < DAY_IN_SECONDS ) {
            // For services with duration not in days check staff working hours
            $interval_valid = false;
            // Check start and previous day to get night schedule
            $date = clone $start;
            $date->modify( '-1 day' );
            while ( $date <= $start ) {
                $Ymd = $date->format( 'Y-m-d' );
                $Ymd_secs = strtotime( $Ymd );
                if ( isset ( $special_days[ $Ymd ] ) ) {
                    // Special day
                    $day_start = $Ymd . ' ' . $special_days[ $Ymd ][0]['start_time'];
                    $day_end = date( 'Y-m-d H:i:s', $Ymd_secs + DateTime::timeToSeconds( $special_days[ $Ymd ][0]['end_time'] ) );
                    if ( $day_start <= $start_date && $day_end >= $end_date ) {
                        // Check if interval does not intersect with breaks
                        $intersects = false;
                        foreach ( $special_days[ $Ymd ] as $break ) {
                            if ( $break['break_start'] ) {
                                $break_start = date(
                                    'Y-m-d H:i:s',
                                    $Ymd_secs + DateTime::timeToSeconds( $break['break_start'] )
                                );
                                $break_end = date(
                                    'Y-m-d H:i:s',
                                    $Ymd_secs + DateTime::timeToSeconds( $break['break_end'] )
                                );
                                if ( $break_start < $end_date && $break_end > $start_date ) {
                                    $intersects = true;
                                    break;
                                }
                            }
                        }
                        if ( ! $intersects ) {
                            $interval_valid = true;
                            break;
                        }
                    }
                } else {
                    // Regular schedule
                    $w = $date->format( 'w' );
                    if ( isset ( $schedule_items[ $w + 1 ] ) ) {
                        $item = $schedule_items[ $w + 1 ];
                        $day_start = $Ymd . ' ' . $item[0]['start_time'];
                        $day_end = date( 'Y-m-d H:i:s', $Ymd_secs + DateTime::timeToSeconds( $item[0]['end_time'] ) );
                        if ( $day_start <= $start_date && $day_end >= $end_date ) {
                            // Check if interval does not intersect with breaks
                            $intersects = false;
                            foreach ( $item as $break ) {
                                if ( $break['break_start'] ) {
                                    $break_start = date(
                                        'Y-m-d H:i:s',
                                        $Ymd_secs + DateTime::timeToSeconds( $break['break_start'] )
                                    );
                                    $break_end = date(
                                        'Y-m-d H:i:s',
                                        $Ymd_secs + DateTime::timeToSeconds( $break['break_end'] )
                                    );
                                    if ( $break_start < $end_date && $break_end > $start_date ) {
                                        $intersects = true;
                                        break;
                                    }
                                }
                            }
                            if ( ! $intersects ) {
                                $interval_valid = true;
                                break;
                            }
                        }
                    }
                }
                $date->modify( '+1 day' );
            }
        }
        if ( ! $interval_valid ) {
            $result['interval_not_in_service_schedule'] = true;
        }

        return $result;
    }
}