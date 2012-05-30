<?php

namespace Javiacei\WeatherGuyBundle\Model\Manager;

use 
    Doctrine\ORM\EntityManager,
    Javiacei\WeatherGuyBundle\Geocoding\GeocodingAdapterInterface,
    Javiacei\WeatherGuyBundle\Entity\WeatherStation,
    Javiacei\WeatherGuyBundle\Model\WeatherFinderInterface,
    Javiacei\WeatherGuyBundle\Geocoding\GeocodingLocation
;

/**
 * WeatherStationManager
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class WeatherStationManager implements WeatherFinderInterface
{
    const DEFAULT_COUNTRY = "España";
    
    protected $geocoding;
    
    protected $em;
    
    public function __construct(EntityManager $em, GeocodingAdapterInterface $geo)
    {
        $this->geocoding    = $geo;
        $this->em           = $em;
    }

    /**
     * Creates a new WeatherStation
     *
     * @param string $name
     * @param string $locality
     * @param string $city
     * @param string $country
     * @return \Javiacei\WeatherGuyBundle\Entity\WeatherStation
     */
    public function create($name, $locality, $city, $country = self::DEFAULT_COUNTRY)
    {
        $address = $locality . " " . $city . ", " . $country;
        $geoLocation = $this->geocoding->getLocation($address);
        
        $data = array(
            'name'      => $name,
            'city'      => $city,
            'locality'  => $locality,
            'country'   => $country,
            'latitude'  => $geoLocation->getLatitude(),
            'longitude' => $geoLocation->getLongitude()
        );
        
        $weatherStation = new WeatherStation();
        $weatherStation->fromArray($data);

        return $weatherStation;
    }
    
    public function getEntityManager()
    {
        return $this->em;
    }
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('JaviaceiWeatherGuyBundle:WeatherStation');
    }
    
    public function save(WeatherStation $weatherStation)
    {
        $this->getEntityManager()->persist($weatherStation);
        $this->getEntityManager()->flush();
    }
    
    public function delete(WeatherStation $weatherStation)
    {
        $this->getEntityManager()->detach($weatherStation);
        $this->getEntityManager()->flush();
    }
    
    public function findStationByName($name)
    {
        return $this->getRepository()->findOneBy(array('name' => $name));
    }
    
    public function findStationsBy(array $criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }
    
    public function existStationBy(array $criteria)
    {
        return count($this->findStationsBy($criteria)) > 0;
    }

    public function findWeatherLocation($address, $distance)
    {
        $location = $this->geocoding->getLocation($address);

        $station = $this->getRepository()->findClosestStation($location, $distance);

        if ($station == null)
            return null;
        else
            return $this->getRepository()->findOneBy($station);
    }

    public function findWeatherLocationByGeo($lat, $long, $distance)
    {
//        $location = $this->geocoding->getLocation($address);

        $location = new GeocodingLocation($lat, $long);

        $station = $this->getRepository()->findClosestStation($location, $distance);

        if ($station == null)
            return null;
        else
            return $this->getRepository()->findOneBy($station);
    }
    
    public function findLatestByStation(WeatherStation $station){
        return $this->getEntityManager()->getRepository('JaviaceiWeatherGuyBundle:WeatherInformation')->findLatest($station);
    }
}