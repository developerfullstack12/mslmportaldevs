<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring;

use Bookly\Lib as BooklyLib;

/**
 * Class ShowSeries
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring
 */
class ShowSeries extends BooklyLib\Base\Component
{
    /**
     * Render show series dialog.
     */
    public static function render()
    {
        self::enqueueScripts( array(
            'module' => array( 'js/series-dialog.js' => array( 'bookly-backend-globals' ), )
        ) );

        wp_localize_script( 'bookly-series-dialog.js', 'BooklyL10nSeriesDialog', array(
            'csrf_token' => BooklyLib\Utils\Common::getCsrfToken(),
            'moment_format_date' => BooklyLib\Utils\DateTime::convertFormat( 'date', BooklyLib\Utils\DateTime::FORMAT_MOMENT_JS ),
            'moment_format_time' => BooklyLib\Utils\DateTime::convertFormat( 'time', BooklyLib\Utils\DateTime::FORMAT_MOMENT_JS ),
            'l10n' => array(
                'recurring_appointments' => __( 'Recurring appointments', 'bookly' ),
                'na' => __( 'N/A', 'bookly' ),
                'close' => __( 'Close', 'bookly' ),
                'edit' => __( 'Edit', 'bookly' ),
            ),
        ) );

        print '<div id="bookly-series-dialog"></div>';
    }
}