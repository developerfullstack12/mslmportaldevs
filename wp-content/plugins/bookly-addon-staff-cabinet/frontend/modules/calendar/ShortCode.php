<?php
namespace BooklyStaffCabinet\Frontend\Modules\Calendar;

use Bookly\Lib as BooklyLib;
use BooklyStaffCabinet\Lib;
use BooklyStaffCabinet\Frontend\Components as FrontendComponents;

/**
 * Class Page
 * @package BooklyStaffCabinet\Frontend\Modules\Calendar
 */
class ShortCode extends BooklyLib\Base\Component
{
    /**
     * Init component.
     */
    public static function init()
    {
        // Register short code.
        add_shortcode( 'bookly-staff-calendar', array( __CLASS__, 'render' ) );

        // Assets.
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'linkStyles' ) );
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'linkScripts' ) );
    }

    /**
     * Link styles.
     */
    public static function linkStyles()
    {
        if ( get_option( 'bookly_gen_link_assets_method' ) == 'enqueue' || self::postsHaveShortCode() ) {
            self::enqueueStyles( array(
                'bookly' => array( 'backend/modules/calendar/resources/css/event-calendar.min.css' => array( 'bookly-backend-globals' ) ),
                'frontend' => array( 'css/staff-cabinet.css' => array( 'bookly-event-calendar.min.css' ), ),
                'module' => array( 'css/staff-cabinet-calendar.css' => array( 'bookly-staff-cabinet.css' ), )
            ) );
        }
    }

    /**
     * Link scripts.
     */
    public static function linkScripts()
    {
        // Disable emoji in IE11
        if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident/7.0' ) !== false ) {
            if ( self::postsHaveShortCode() ) {
                BooklyLib\Utils\Common::disableEmoji();
            }
        }

        if ( get_option( 'bookly_gen_link_assets_method' ) == 'enqueue' || self::postsHaveShortCode() ) {
            self::enqueueScripts( array(
                'bookly' => array(
                    'backend/modules/calendar/resources/js/event-calendar.min.js' => array( 'bookly-backend-globals' ),
                    'backend/modules/calendar/resources/js/calendar-common.js' => array( 'bookly-event-calendar.min.js' ),
                ),
                'module' => array( 'js/staff-cabinet-calendar.js' => array( 'bookly-calendar-common.js' ) ),
            ) );

            $slot_length_minutes = get_option( 'bookly_gen_time_slot_length', '15' );
            $slot = new \DateInterval( 'PT' . $slot_length_minutes . 'M' );

            $hidden_days = array();
            $min_time = '00:00:00';
            $max_time = '24:00:00';
            $scroll_time = '08:00:00';
            // Find min and max business hours
            $min = $max = null;
            foreach ( BooklyLib\Config::getBusinessHours() as $day => $bh ) {
                if ( $bh['start'] === null ) {
                    if ( BooklyLib\Config::showOnlyBusinessDaysInCalendar() ) {
                        $hidden_days[] = $day;
                    }
                    continue;
                }
                if ( $min === null || $bh['start'] < $min ) {
                    $min = $bh['start'];
                }
                if ( $max === null || $bh['end'] > $max ) {
                    $max = $bh['end'];
                }
            }
            if ( $min !== null ) {
                $scroll_time = $min;
                if ( BooklyLib\Config::showOnlyBusinessHoursInCalendar() ) {
                    $min_time = $min;
                    $max_time = $max;
                } else if ( $max > '24:00:00' ) {
                    $min_time = BooklyLib\Utils\DateTime::buildTimeString( BooklyLib\Utils\DateTime::timeToSeconds( $max ) - DAY_IN_SECONDS );
                    $max_time = $max;
                }
            }

            wp_localize_script( 'bookly-staff-cabinet-calendar.js', 'BooklySCCalendarL10n', array(
                'hiddenDays'             => $hidden_days,
                'slotDuration'           => $slot->format( '%H:%I:%S' ),
                'slotMinTime'            => $min_time,
                'slotMaxTime'            => $max_time,
                'scrollTime'             => $scroll_time,
                'datePicker'             => BooklyLib\Utils\DateTime::datePickerOptions(),
                'locale'                 => BooklyLib\Config::getShortLocale(),
                'mjsDateFormat'          => BooklyLib\Utils\DateTime::convertFormat( 'date', BooklyLib\Utils\DateTime::FORMAT_MOMENT_JS ),
                'mjsTimeFormat'          => BooklyLib\Utils\DateTime::convertFormat( 'time', BooklyLib\Utils\DateTime::FORMAT_MOMENT_JS ),
                'today'                  => __( 'Today', 'bookly' ),
                'week'                   => __( 'Week', 'bookly' ),
                'day'                    => __( 'Day', 'bookly' ),
                'month'                  => __( 'Month', 'bookly' ),
                'allDay'                 => __( 'All Day', 'bookly' ),
                'delete'                 => __( 'Delete', 'bookly' ),
                'list'                   => __( 'List', 'bookly' ),
                'noEvents'               => __( 'No appointments for selected period.', 'bookly' ),
                'areYouSure'             => __( 'Are you sure?', 'bookly' ),
                'recurring_appointments' => array(
                    'active' => (int) BooklyLib\Config::recurringAppointmentsActive(),
                    'title'   => __( 'Recurring appointments', 'bookly' ),
                ),
                'waiting_list'           => array(
                    'active' => (int) BooklyLib\Config::waitingListActive(),
                    'title'  => __( 'On waiting list', 'bookly' ),
                ),
                'packages'               => array(
                    'active' => (int) BooklyLib\Config::packagesActive(),
                    'title'  => __( 'Package', 'bookly' ),
                ),
                'more' => __( '+%d more', 'bookly' ),
            ) );
        }
    }

    /**
     * Render Calendar shortcode.
     *
     * @param array $attributes
     * @return string
     */
    public static function render( $attributes )
    {
        // Disable caching.
        BooklyLib\Utils\Common::noCache();

        if ( is_user_logged_in() && $staff = BooklyLib\Entities\Staff::query()->select( 'id, visibility' )->where( 'wp_user_id', get_current_user_id() )->fetchRow() ) {
            $custom_fields = array();
            foreach ( (array) BooklyLib\Proxy\CustomFields::getTranslated() as $field ) {
                if ( ! in_array( $field->type, array( 'captcha', 'text-content' ) ) ) {
                    $custom_fields[] = $field;
                }
            }

            \BooklyPro\Backend\Components\License\Components::renderLicenseNotice( false );
            if ( $staff['visibility'] == 'archive' ) {
                return FrontendComponents\Notice\Permission::generateAccountDisabled();
            }
            return \BooklyPro\Lib\Config::graceExpired()
                ? null
                : self::renderTemplate( 'short_code', array(
                    'calendar_id' => uniqid( 'calendar-' ),
                    'staff_id' => $staff['id'],
                    'custom_fields' => $custom_fields,
                    'hide' => array_key_exists( 'hide', (array) $attributes ) ? (array)$attributes['hide'] : array()
                ), false );
        }

        return FrontendComponents\Notice\Permission::generate();
    }

    /**
     * Check whether current posts have shortcode 'bookly-staff-calendar'
     *
     * @return bool
     */
    protected static function postsHaveShortCode()
    {
        static $result;

        if ( $result === null ) {
            $result = BooklyLib\Utils\Common::postsHaveShortCode( 'bookly-staff-calendar' );
        }

        return $result;
    }
}