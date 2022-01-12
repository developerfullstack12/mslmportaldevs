<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring;

use Bookly\Lib as BooklyLib;

/**
 * Class DeleteSeries
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring
 */
class DeleteSeries extends BooklyLib\Base\Component
{
    /**
     * Render delete series dialog.
     */
    public static function render()
    {
        self::enqueueStyles( array(
            'alias' => array( 'bookly-backend-globals', )
        ) );

        self::enqueueScripts( array(
            'module' => array( 'js/delete_series.js' => array( 'bookly-backend-globals' ), ),
        ) );

        self::renderTemplate( 'delete_series' );
    }
}