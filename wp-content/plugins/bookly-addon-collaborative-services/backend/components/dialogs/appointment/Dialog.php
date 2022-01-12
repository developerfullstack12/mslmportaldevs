<?php
namespace BooklyCollaborativeServices\Backend\Components\Dialogs\Appointment;

use Bookly\Lib as BooklyLib;

/**
 * Class Dialog
 * @package BooklyCollaborativeServices\Backend\Components\Dialogs\Appointment
 */
class Dialog extends BooklyLib\Base\Component
{
    /**
     * Render collaborative dialog.
     */
    public static function render()
    {
        self::enqueueScripts( array(
            'module' => array( 'js/collaborative-dialog.js' => array( 'bookly-backend-globals' ), )
        ) );

        wp_localize_script( 'bookly-collaborative-dialog.js', 'BooklyL10nCollaborativeDialog', array(
            'csrf_token' => BooklyLib\Utils\Common::getCsrfToken(),
            'moment_format_date' => BooklyLib\Utils\DateTime::convertFormat( 'date', BooklyLib\Utils\DateTime::FORMAT_MOMENT_JS ),
            'moment_format_time' => BooklyLib\Utils\DateTime::convertFormat( 'time', BooklyLib\Utils\DateTime::FORMAT_MOMENT_JS ),
            'l10n' => array(
                'collaborative_service' => __( 'Collaborative service', 'bookly' ),
                'close' => __( 'Close', 'bookly' ),
                'edit' => __( 'Edit', 'bookly' ),
                'staff_any'  => get_option( 'bookly_l10n_option_employee' ),
            ),
        ) );

        print '<div id="bookly-collaborative-dialog"></div>';
    }
}