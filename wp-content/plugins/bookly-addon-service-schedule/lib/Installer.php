<?php
namespace BooklyServiceSchedule\Lib;

use BooklyServiceSchedule\Lib\Entities;
use Bookly\Lib as BooklyLib;

/**
 * Class Installer
 * @package BooklyServiceSchedule\Lib
 */
class Installer extends Base\Installer
{
    /**
     * Create tables in database.
     */
    public function createTables()
    {
        /** @global \wpdb $wpdb */
        global $wpdb;

        $charset_collate = $wpdb->has_cap( 'collation' )
            ? $wpdb->get_charset_collate()
            : 'DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci';

        $wpdb->query(
            'CREATE TABLE IF NOT EXISTS `' . Entities\ServiceScheduleDay::getTableName() . '` (
                  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `service_id` INT UNSIGNED NOT NULL,
                  `day_index`  SMALLINT,
                  `start_time` TIME DEFAULT NULL,
                  `end_time`   TIME DEFAULT NULL,
                CONSTRAINT
                    FOREIGN KEY (service_id)
                    REFERENCES ' . BooklyLib\Entities\Service::getTableName() . '(id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
                ) ENGINE = INNODB
                ' . $charset_collate
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
                ' . $charset_collate
        );
    }

    /**
     * Load data.
     */
    public function loadData()
    {
        parent::loadData();
        foreach ( BooklyLib\Entities\Service::query()->find() as $service ) {
            \BooklyServiceSchedule\Backend\Modules\Services\ProxyProviders\Shared::serviceCreated( $service );
        }
    }

}