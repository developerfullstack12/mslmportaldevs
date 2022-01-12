<?php
namespace BooklyCollaborativeServices\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\Entities\Service;
use Bookly\Lib\Entities\Staff;
use Bookly\Lib\Entities\StaffService;
use Bookly\Lib\Utils;
use BooklyCollaborativeServices\Lib;

/**
 * Class Shared
 * @package BooklyCollaborativeServices\Lib\ProxyProviders
 */
class Shared extends BooklyLib\Proxy\Shared
{
    /**
     * @inheritDoc
     */
    public static function prepareCaSeSt( $result )
    {
        // Add collaborative services.
        $query = BooklyLib\Proxy\Shared::prepareCaSeStQuery(
            Service::query( 's' )
               ->leftJoin( 'SubService', 'sub', 'sub.service_id = s.id' )
               ->leftJoin( 'StaffService', 'ss', 'ss.service_id = sub.sub_service_id' )
               ->where( 's.type', Service::TYPE_COLLABORATIVE )
        );
        $services = $query->find();

        /** @var Service $service */
        foreach ( $services as $service ) {
            $sub_services = $service->getSubServices();
            if ( ! empty ( $sub_services ) ) {
                // Find min and max capacity.
                $max_capacity = PHP_INT_MAX;
                $min_capacity = 1;
                $has_extras   = 0;
                foreach ( $sub_services as $sub_service ) {
                    if ( BooklyLib\Config::groupBookingActive() ) {
                        $res = StaffService::query()
                            ->select( 'MAX(capacity_max) AS max_capacity, MIN(capacity_min) AS min_capacity' )
                            ->where( 'service_id', $sub_service->getId() )
                            ->fetchRow();
                        if ( $res ) {
                            if ( $max_capacity > $res['max_capacity'] ) {
                                $max_capacity = $res['max_capacity'];
                            }
                            if ( $min_capacity < $res['min_capacity'] ) {
                                $min_capacity = $res['min_capacity'];
                            }
                        }
                    } else {
                        $max_capacity = 1;
                    }
                    if ( $has_extras == 0 ) {
                        $has_extras = (int) BooklyLib\Proxy\ServiceExtras::findByServiceId( $sub_service->getId() );
                    }
                }
                $duration        = 0;
                $sub_service_ids = array();
                foreach ( $sub_services as $sub_service ) {
                    if ( ! in_array( $sub_service->getId(), $sub_service_ids ) ) {
                        $sub_service_ids[] = $sub_service->getId();
                    }
                    $duration          = max( $duration, $sub_service->getDuration() );
                }

                $result['services'][ $service->getId() ] = array(
                    'id'           => (int) $service->getId(),
                    'category_id'  => (int) $service->getCategoryId(),
                    'name'         => $service->getTranslatedTitle(),
                    'duration'     => Utils\DateTime::secondsToInterval( $duration ),
                    'min_capacity' => (int) $min_capacity,
                    'max_capacity' => (int) $max_capacity,
                    'has_extras'   => $has_extras,
                    'pos'          => (int) $service->getPosition(),
                    'type'         => 'collaborative',
                );

                if ( ! $service->getCategoryId() && ! isset ( $result['categories'][0] ) ) {
                    $result['categories'][0] = array(
                        'id'   => 0,
                        'name' => __( 'Uncategorized', 'bookly' ),
                        'pos'  => 99999,
                    );
                }

                // Add service to staff.
                $query = Staff::query( 'st' )
                    ->select( 'st.id, st.full_name, st.position, ss.service_id, ss.capacity_min, ss.capacity_max, ss.price, s.units_min, s.units_max' )
                    ->where( 'ss.service_id', $sub_services[0]->getId() )
                    ->innerJoin( 'StaffService', 'ss', 'ss.staff_id = st.id AND st.visibility = "public"' )
                    ->leftJoin( 'Service', 's', 's.id = ss.service_id' );
                $query = BooklyLib\Proxy\Shared::prepareStaffServiceQuery( $query );
                if ( ! BooklyLib\Proxy\Locations::servicesPerLocationAllowed() ) {
                    $query->where( 'ss.location_id', null );
                }

                foreach ( $query->fetchArray() as $staff_service ) {
                    if ( ! isset ( $result['staff'][ $staff_service['id'] ] ) ) {
                        $staff = Staff::find( $staff_service['id'] );

                        $result['staff'][ $staff_service['id'] ] = array(
                            'id'       => (int) $staff_service['id'],
                            'name'     => $staff->getTranslatedName(),
                            'services' => array(),
                            'pos'      => (int) $staff->getPosition(),
                        );
                    }
                    $location_data             = array(
                        'min_capacity' => (int) $min_capacity,
                        'max_capacity' => (int) $max_capacity,
                        'price'        => get_option( 'bookly_app_staff_name_with_price' ) ? Utils\Price::format( $service->getPrice() ) : null,
                    );
                    $staff_service['duration'] = $duration;
                    $location_data             = BooklyLib\Proxy\Shared::prepareCategoryServiceStaffLocation( $location_data, $staff_service );
                    foreach ( BooklyLib\Proxy\Locations::prepareLocationsForCombinedServices( array( 0 ), $sub_service_ids ) as $location_id ) {
                        $result['staff'][ $staff_service['id'] ]['services'][ $service->getId() ]['locations'][ $location_id ] = $location_data;
                    }
                }
            }
        }

        return $result;
    }
}