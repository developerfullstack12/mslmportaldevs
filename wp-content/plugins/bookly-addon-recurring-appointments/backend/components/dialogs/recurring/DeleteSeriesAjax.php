<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring;

use Bookly\Lib as BooklyLib;
use BooklyRecurringAppointments\Lib\Notifications;

/**
 * Class DeleteSeriesAjax
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring
 */
class DeleteSeriesAjax extends BooklyLib\Base\Ajax
{
    /**
     * @inheritdoc
     */
    protected static function permissions()
    {
        return array( '_default' => array( 'staff', 'supervisor' ) );
    }

    /**
     * Delete recurring appointment.
     */
    public static function deleteAppointment()
    {
        $query = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
            ->leftJoin( 'Appointment', 'a', 'a.id = ca.appointment_id' )
            ->where( 'ca.series_id', self::parameter( 'series_id' ) );
        if ( self::parameter( 'what' ) === 'current-and-next' ) {
            $current = BooklyLib\Entities\Appointment::query( 'a' )
                ->select( 'a.start_date' )
                ->where( 'a.id', self::parameter( 'appointment_id' ) )
                ->fetchRow();
            if ( $current ) {
                $query->whereGte( 'a.start_date', $current['start_date'] );
            }
        }

        if ( ! BooklyLib\Utils\Common::isCurrentUserSupervisor() ) {
            $query->leftJoin( 'Staff', 'st', 'st.id = a.staff_id' )->where( 'st.wp_user_id', get_current_user_id() );
        }

        /** @var BooklyLib\Entities\CustomerAppointment[] $customer_appointments */
        $customer_appointments = $query->find();

        $queue = array();

        if ( self::parameter( 'notify' ) ) {
            $first_ca = $customer_appointments[0];
            $series   = BooklyLib\DataHolders\Booking\Series::create( BooklyLib\Entities\Series::find( $first_ca->getSeriesId() ) );
            $customer = BooklyLib\Entities\Customer::find( $first_ca->getCustomerId() );
            $order    = BooklyLib\DataHolders\Booking\Order::create( $customer )->addItem( 0, $series );

            $series_of = BooklyLib\Entities\Service::TYPE_SIMPLE;
            if ( $first_ca->getCompoundToken() ) {
                $series_of = BooklyLib\Entities\Service::TYPE_COMPOUND;
            } elseif ( $first_ca->getCollaborativeToken() ) {
                $series_of = BooklyLib\Entities\Service::TYPE_COLLABORATIVE;
            }

            $cos = array();

            foreach ( $customer_appointments as $i => $ca ) {
                switch ( $ca->getStatus() ) {
                    case BooklyLib\Entities\CustomerAppointment::STATUS_CANCELLED:
                    case BooklyLib\Entities\CustomerAppointment::STATUS_REJECTED:
                    case BooklyLib\Entities\CustomerAppointment::STATUS_DONE:
                        break;
                    case BooklyLib\Entities\CustomerAppointment::STATUS_PENDING:
                    case BooklyLib\Entities\CustomerAppointment::STATUS_WAITLISTED:
                        $ca->setStatus( BooklyLib\Entities\CustomerAppointment::STATUS_REJECTED );
                        break;
                    case BooklyLib\Entities\CustomerAppointment::STATUS_APPROVED:
                        $ca->setStatus( BooklyLib\Entities\CustomerAppointment::STATUS_CANCELLED );
                        break;
                    default:
                        $busy_statuses = (array) BooklyLib\Proxy\CustomStatuses::prepareBusyStatuses( array() );
                        if ( in_array( $ca->getStatus(), $busy_statuses ) ) {
                            $ca->setStatus( BooklyLib\Entities\CustomerAppointment::STATUS_CANCELLED );
                        } else {
                            $ca->setStatus( BooklyLib\Entities\CustomerAppointment::STATUS_REJECTED );
                        }
                }

                if ( $series_of == BooklyLib\Entities\Service::TYPE_SIMPLE ) {
                    $series->addItem( $i, BooklyLib\DataHolders\Booking\Simple::create( $ca ) );
                } else {
                    $token = $ca->getCollaborativeToken() ?: $ca->getCompoundToken();
                    if ( ! array_key_exists( $token, $cos ) ) {
                        switch ( $series_of ) {
                            case BooklyLib\Entities\Service::TYPE_COMPOUND:
                                $cos[ $token ] = BooklyLib\DataHolders\Booking\Compound::create( BooklyLib\Entities\Service::find( $ca->getCompoundServiceId() ) );
                                break;
                            case BooklyLib\Entities\Service::TYPE_COLLABORATIVE:
                                $cos[ $token ] = BooklyLib\DataHolders\Booking\Collaborative::create( BooklyLib\Entities\Service::find( $ca->getCollaborativeServiceId() ) );
                                break;
                        }
                        $series->addItem( $i, $cos[ $token ] );
                    }
                    $cos[ $token ]->addItem( BooklyLib\DataHolders\Booking\Simple::create( $ca ) );
                }
            }

            BooklyLib\Notifications\Booking\Sender::sendForOrder(
                $order,
                array( 'cancellation_reason' => self::parameter( 'reason' ) ),
                false,
                $queue
            );
        }

        foreach ( $customer_appointments as $ca ) {
            BooklyLib\Utils\Log::deleteEntity( $ca, __METHOD__ );
            $ca->delete();
            $appointment = BooklyLib\Entities\Appointment::find( $ca->getAppointmentId() );
            if ( count( $appointment->getCustomerAppointments() ) == 0 ) {
                BooklyLib\Utils\Log::deleteEntity( $appointment, __METHOD__ );
                $appointment->delete();
            }
        }

        wp_send_json_success( compact( 'queue' ) );
    }
}