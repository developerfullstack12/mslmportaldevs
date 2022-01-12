<?php
namespace BooklyRecurringAppointments\Lib\Notifications\Assets\Item\ProxyProviders;

use Bookly\Lib\DataHolders\Booking\Series;
use Bookly\Lib\Notifications\Assets\Item\Codes;
use Bookly\Lib\Notifications\Assets\Item\Proxy;
use Bookly\Lib\Utils;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Lib\Notifications\Assets\Item\ProxyProviders
 */
abstract class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function prepareCodes( Codes $codes )
    {
        /** @var Series $root */
        $item = $codes->getItem();
        $root = $item->getRoot();
        $for_client = $codes->forClient();

        if ( $root->isSeries() ) {
            $schedule = array();
            $sub_items = $codes->forClient() ? $root->getItems() : $root->getSubItems();

            foreach ( $sub_items as $sub_item ) {
                if ( $for_client || ( $item->getStaff() === $sub_item->getStaff() ) ) {
                    $schedule[] = array(
                        'start'      => $codes->tz( $sub_item->getAppointment()->getStartDate() ),
                        'end'        => $codes->tz( $sub_item->getAppointment()->getEndDate() ),
                        'token'      => $sub_item->getCA()->getToken(),
                        'duration'   => $sub_item->getService()->getDuration(),
                        'start_info' => $sub_item->getService()->getStartTimeInfo(),
                    );
                }
            }
            $codes->schedule     = $schedule;
            $codes->series_token = $root->getSeries()->getToken();
        }
    }

    /**
     * @inheritdoc
     */
    public static function prepareReplaceCodes( array $replace_codes, Codes $codes, $format )
    {
        if ( is_array( $codes->schedule ) ) {
            $schedule = $schedule_c = '';
            $position = 1;
            foreach ( $codes->schedule as $appointment ) {
                $date       = Utils\DateTime::formatDate( $appointment['start'] );
                $time       = $appointment['duration'] < DAY_IN_SECONDS ? Utils\DateTime::formatTime( $appointment['start'] ) : $appointment['start_info'];
                $cancel_url = admin_url( 'admin-ajax.php?action=bookly_cancel_appointment&token=' . $appointment['token'] );
                if ( $format == 'html' ) {
                    $schedule_c .= sprintf( '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $position, $date, $time, $cancel_url );
                    $schedule   .= sprintf( '<tr><td>%s</td><td>%s</td><td>%s</td></tr>', $position, $date, $time );
                } else {
                    $schedule_c .= sprintf( '%s. %s %s %s %s', $position, $date, __( 'at', 'bookly' ), $time, $cancel_url ) . PHP_EOL;
                    $schedule   .= sprintf( '%s. %s %s %s', $position, $date, __( 'at', 'bookly' ), $time ) . PHP_EOL;
                }
                $position ++;
            }
            if ( $format == 'html' ) {
                $replace_codes['appointment_schedule']   = '<table>' . $schedule . '</table>';
                $replace_codes['appointment_schedule_c'] = '<table>' . $schedule_c . '</table>';
            } else {
                $replace_codes['appointment_schedule']   = $schedule;
                $replace_codes['appointment_schedule_c'] = $schedule_c ;
            }
            $replace_codes['recurring_count'] = count( $codes->schedule );
            $replace_codes['approve_appointment_schedule_url'] = admin_url(
                'admin-ajax.php?action=bookly_recurring_appointments_approve_schedule&token=' .
                urlencode( Utils\Common::xorEncrypt( $codes->series_token, 'approve' ) )
            );
            $replace_codes['cancel_all_recurring_appointments_url'] = admin_url( 'admin-ajax.php?action=bookly_recurring_appointments_cancel_appointments&token=' . $codes->series_token );
            $replace_codes['cancel_all_recurring_appointments'] = $format == 'html'
                ? sprintf( '<a href="%1$s">%1$s</a>', $replace_codes['cancel_all_recurring_appointments_url'] )
                : $replace_codes['cancel_all_recurring_appointments_url'];
        } else {
            $replace_codes['appointment_schedule'] = '';
            $replace_codes['appointment_schedule_c'] = '';
            $replace_codes['recurring_count'] = '';
            $replace_codes['approve_appointment_schedule_url'] = '';
            $replace_codes['cancel_all_recurring_appointments'] = '';
            $replace_codes['cancel_all_recurring_appointments_url'] = '';
        }

        return $replace_codes;
    }
}