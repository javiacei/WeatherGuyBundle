<?php

namespace Javiacei\WeatherGuyBundle\Entity\Repository;

use Javiacei\WeatherGuyBundle\Geocoding\GeocodingLocation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\AbstractQuery;

/**
 * WeatherStationRepository
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Entity
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Ignacio Velázquez Gómez
 */
class WeatherStationRepository extends EntityRepository
{
    public function findClosestStation(GeocodingLocation $location, $distance)
    {
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('JaviaceiWeatherGuyBundle:WeatherStation', 'ws');
        $rsm->addScalarResult('id', 'id');

        $query = $this
            ->getEntityManager()->createNativeQuery(
                '   SELECT ws.id as id, SQRT(
                        POW(69.1 * (ws.latitude - :latitude), 2) +
                        POW(69.1 * (:longitude - ws.longitude) * COS(ws.latitude / 57.3), 2)
                    ) AS distance
                    FROM weather_guy_weather_station ws HAVING distance < :distance ORDER BY distance LIMIT 0,1;
                ', $rsm)
            ->setParameters(array(
                'latitude'  => $location->getLatitude(),
                'longitude' => $location->getLongitude(),
                'distance'  => $distance
            ))
        ;

        try {
            $result = $query->getSingleResult();
        }
        catch(\Doctrine\ORM\NoResultException $e){
            return null;
        }

        return $result;
    }
}
