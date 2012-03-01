<?php

namespace Javiacei\WeatherGuyBundle\Entity\Repository;

use Javiacei\WeatherGuyBundle\Model\WeatherStation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\AbstractQuery;

/**
 * WeatherInformationRepository
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Entity
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Ignacio Velázquez Gómez
 */
class WeatherInformationRepository extends EntityRepository
{
    public function findInformation(WeatherStation $station, \DateTime $date)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from('JaviaceiWeatherGuyBundle:WeatherInformation', 'i')
            ->where('i.date = :date')
            ->andWhere('i.station = :station_id')
            ->setParameters(array(
                'station_id'    => $station->id,
                'date'          => $date
            ))
        ;

        try{
            $info = $queryBuilder->getQuery()->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $exc) {
            return null;
        }

        return $info;
    }
}
