<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder;

use 
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\IGeocodingAdapter,
    Doctrine\ORM\EntityManager,
    Ideup\WeatherGuyBundle\Entity\WeatherStation
;

/**
 * Description of WeatherLocationManager
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
class WeatherStationManager
{
    const DEFAULT_COUNTRY = "España";
    
    protected $geocoding;
    
    protected $em;
    
    public function __construct(EntityManager $em, IGeocodingAdapter $geo)
    {
        $this->geocoding    = $geo;
        $this->em           = $em;
    }
    
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
        return $this->getEntityManager()->getRepository('IdeupWeatherGuyBundle:WeatherStation');
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
    
    public function findStationsBy(array $criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }
    
    public function existStationBy(array $criteria)
    {
        return count($this->findStationsBy($criteria)) > 0;
    }
}