<?php
namespace BooklyServiceSchedule\Lib\Entities;

use Bookly\Lib;

/**
 * Class ServiceScheduleBreak
 * @package BooklyServiceSchedule\Lib\Entities
 */
class ServiceScheduleBreak extends Lib\Base\Entity
{
    /** @var  int */
    protected $service_schedule_day_id;
    /** @var  string */
    protected $start_time;
    /** @var  string */
    protected $end_time;

    protected static $table = 'bookly_service_schedule_breaks';

    protected static $schema = array(
        'id'         => array( 'format' => '%d' ),
        'service_schedule_day_id' => array( 'format' => '%d', 'reference' => array( 'entity' => 'ServiceScheduleDay' ) ),
        'start_time' => array( 'format' => '%s' ),
        'end_time'   => array( 'format' => '%s' ),
    );

    /**************************************************************************
     * Entity Fields Getters & Setters                                        *
     **************************************************************************/

    /**
     * Gets service_schedule_day_id
     *
     * @return int
     */
    public function getServiceScheduleDayId()
    {
        return $this->service_schedule_day_id;
    }

    /**
     * Sets service_schedule_day_id
     *
     * @param int $service_schedule_day_id
     * @return $this
     */
    public function setServiceScheduleDayId( $service_schedule_day_id )
    {
        $this->service_schedule_day_id = $service_schedule_day_id;

        return $this;
    }

    /**
     * Gets start_time
     *
     * @return string
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Sets start_time
     *
     * @param string $start_time
     * @return $this
     */
    public function setStartTime( $start_time )
    {
        $this->start_time = $start_time;

        return $this;
    }

    /**
     * Gets end_time
     *
     * @return string
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * Sets end_time
     *
     * @param string $end_time
     * @return $this
     */
    public function setEndTime( $end_time )
    {
        $this->end_time = $end_time;

        return $this;
    }

}