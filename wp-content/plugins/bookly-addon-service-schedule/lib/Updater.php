<?php
namespace BooklyServiceSchedule\Lib;

use Bookly\Lib as BooklyLib;

/**
 * Class Updates
 * @package BooklyServiceSchedule\Lib
 */
class Updater extends BooklyLib\Base\Updater
{
    public function update_2_4()
    {
        /** @global \wpdb $wpdb */
        global $wpdb;

        $wpdb->query( 'DELETE FROM `' . $this->getTableName( 'bookly_service_schedule_days' ) . '` WHERE day_index > 7' );
    }

    public function update_2_2()
    {
        $this->upgradeCharsetCollate( array(
            'bookly_service_schedule_breaks',
            'bookly_service_schedule_days',
        ) );
    }

    public function update_1_9()
    {
        global $wpdb;

        // Rename tables.
        $tables = array(
            'service_schedule_breaks',
            'service_schedule_days',
        );
        $query = 'RENAME TABLE ';
        foreach ( $tables as $table ) {
            $query .= sprintf( '`%s` TO `%s`, ', $this->getTableName( 'ab_' . $table ), $this->getTableName( 'bookly_' . $table ) );
        }
        $query = substr( $query, 0, -2 );
        $wpdb->query( $query );

        delete_option( 'bookly_service_schedule_enabled' );
    }

    public function update_1_1()
    {
        /** @global \wpdb $wpdb */
        global $wpdb;

        $breaks   = array();
        foreach ( $wpdb->get_results( 'SELECT start_time, end_time, service_id FROM ' . Entities\ServiceScheduleBreak::getTableName() ) as $break ) {
            $breaks[ $break->service_id ][] = array(
                'start_time' => $break->start_time,
                'end_time'   => $break->end_time,
            );
        }
        $this->drop( array( Entities\ServiceScheduleBreak::getTableName() ) );
        $wpdb->query(
            'CREATE TABLE IF NOT EXISTS `' . Entities\ServiceScheduleDay::getTableName() . '` (
                  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `service_id` INT UNSIGNED NOT NULL,
                  `day_index`  SMALLINT,
                  `start_time` TIME DEFAULT NULL,
                  `end_time`   TIME DEFAULT NULL,
                CONSTRAINT
                    FOREIGN KEY (service_id)
                    REFERENCES ' . \Bookly\Lib\Entities\Service::getTableName() . '(id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
                ) ENGINE = INNODB
             DEFAULT CHARACTER SET = utf8
             COLLATE = utf8_general_ci'
        );
        $wpdb->query(
            'CREATE TABLE IF NOT EXISTS `' . Entities\ServiceScheduleBreak::getTableName() . '` (
                  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `service_schedule_day_id` INT UNSIGNED NOT NULL,
                  `start_time` TIME DEFAULT NULL,
                  `end_time`   TIME DEFAULT NULL,
                CONSTRAINT
                    FOREIGN KEY (service_schedule_day_id)
                    REFERENCES ' . Entities\ServiceScheduleDay::getTableName() . '(id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
                ) ENGINE = INNODB
             DEFAULT CHARACTER SET = utf8
             COLLATE = utf8_general_ci'
        );
        $services = $wpdb->get_results( 'SELECT start_time, end_time, id FROM ' . \Bookly\Lib\Entities\Service::getTableName() );

        foreach ( $services as $service ) {
            $sch_day = new Entities\ServiceScheduleDay();
            $sch_day->setServiceId( $service->id )
                 ->setStartTime( $service->start_time )
                 ->setEndTime( $service->end_time );
            for ( $day_index = 1; $day_index <= 7; $day_index ++ ) {
                $entity = clone $sch_day;
                $entity->setDayIndex(  $day_index )
                    ->save();
                if ( isset( $breaks[ $service->id ] ) ) {
                    $sch_break = new Entities\ServiceScheduleBreak();
                    $sch_break->setServiceScheduleDayId( $entity->getId() );
                    foreach ( $breaks[ $service->id ] as $break ) {
                        $entity = clone $sch_break;
                        $entity->setStartTime( $break['start_time'] )
                            ->setEndTime( $break['end_time'] )
                            ->save();
                    }
                }
            }
        }
    }

}