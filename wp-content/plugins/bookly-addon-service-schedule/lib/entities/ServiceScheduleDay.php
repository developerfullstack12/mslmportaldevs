<?php
namespace BooklyServiceSchedule\Lib\Entities;

use Bookly\Lib;

/**
 * Class ServiceScheduleDay
 * @package BooklyServiceSchedule\Lib\Entities
 */
class ServiceScheduleDay extends Lib\Base\Entity
{
    /** @var  int */
    protected $service_id;
    /** @var  int */
    protected $day_index;
    /** @var  string */
    protected $start_time;
    /** @var  string */
    protected $end_time;

    protected static $table = 'bookly_service_schedule_days';

    protected static $schema = array(
        'id'         => array( 'format' => '%d' ),
        'service_id' => array( 'format' => '%d', 'reference' => array( 'entity' => 'Service', 'namespace' => '\Bookly\Lib\Entities' ) ),
        'day_index'  => array( 'format' => '%d' ),  // 1-7 Sunday
        'start_time' => array( 'format' => '%s' ),
        'end_time'   => array( 'format' => '%s' ),
    );

    /**************************************************************************
     * Entity Fields Getters & Setters                                        *
     **************************************************************************/

    /**
     * Gets service_id
     *
     * @return int
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * Sets service
     *
     * @param Lib\Entities\Service $service
     * @return $this
     */
    public function setService( $service )
    {
        return $this->setServiceId( $service->getId() );
    }

    /**
     * Sets service_id
     *
     * @param int $service_id
     * @return $this
     */
    public function setServiceId( $service_id )
    {
        $this->service_id = $service_id;

        return $this;
    }

    /**
     * Gets day_index
     *
     * @return int
     */
    public function getDayIndex()
    {
        return $this->day_index;
    }

    /**
     * Sets day_index
     *
     * @param int $day_index
     * @return $this
     */
    public function setDayIndex( $day_index )
    {
        $this->day_index = $day_index;

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