<?php
namespace BooklyCollaborativeServices\Lib;

/**
 * Class Updater
 * @package BooklyCollaborativeServices\Lib
 */
class Updater extends \Bookly\Lib\Base\Updater
{
    function update_2_1()
    {
        add_option( 'bookly_collaborative_hide_staff', '1' );
    }
}