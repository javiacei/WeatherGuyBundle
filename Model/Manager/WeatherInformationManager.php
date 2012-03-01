<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Javiacei\WeatherGuyBundle\Model\Manager;

use 
    Doctrine\ORM\EntityManager,
    Javiacei\WeatherGuyBundle\Entity\WeatherInformation,
    Javiacei\WeatherGuyBundle\Model\WeatherStation,
    Javiacei\WeatherGuyBundle\Model\WeatherEngineInterface
;

/**
 * WeatherInformationManager
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class WeatherInformationManager implements WeatherEngineInterface
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getEntityManager()
    {
        return $this->em;
    }
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('JaviaceiWeatherGuyBundle:WeatherInformation');
    }
    
    public function create(WeatherStation $station, \DateTime $date)
    {
        $weatherInfo = $this->findWeatherInformation($station, $date);   
        
        if (null !== $weatherInfo) {
            throw new \Exception("Weather information of station {$station->name} at {$date->format('d-m-Y')} exists.");
        }
        
        // Otherwise I will create new one.
        $weatherInfo = new WeatherInformation();
        $weatherInfo->setStation($station);
        $weatherInfo->setDate($date);
        
        return $weatherInfo;
    }
    
    public function save(WeatherInformation $weatherInfo)
    {
        $this->getEntityManager()->persist($weatherInfo);
        $this->getEntityManager()->flush();
    }
    
    public function delete(WeatherInformation $weatherInformation)
    {
        $this->getEntityManager()->detach($weatherInformation);
        $this->getEntityManager()->flush();
    }
    
    public function findInformationBy(array $criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    public function findWeatherInformation(WeatherStation $station, \DateTime $date)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        try {
            $info = $qb
                ->select('i')
                ->from('JaviaceiWeatherGuyBundle:WeatherInformation', 'i')
                ->where('i.date = :date')
                ->andWhere('i.station = :station_id')
                ->setParameters(array(
                    'station_id'    => $station->id,
                    'date'          => $date
                ))
                ->getQuery()->getSingleResult()
            ;
        } catch (\Doctrine\ORM\NoResultException $exc) {
            $info = null;
        }
        
        return $info;
    }
}