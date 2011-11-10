<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Tests\WeatherGuy\Finder;


use
    Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\WeatherStationManager,
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\WeatherStation
;

class WeatherStationManagerTest extends WebTestCase
{
    const LATITUDE_TEST = 40.6587542;
    
    const LONGITUDE_TEST = -4.0237125;
    
    const NAME_NEAREST_STATION = 2462;
    
    protected $stationManager;
    
    protected function setUp()
    {
        // EntityManager test
        $em = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        
        // Location Mock
        $geoLocation = $this->getMock('Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\IGeocodingLocation');
        
        $geoLocation
            ->expects($this->any())
            ->method('getLatitude')
            ->will($this->returnValue(self::LATITUDE_TEST));

        $geoLocation
            ->expects($this->any())
            ->method('getLongitude')
            ->will($this->returnValue(self::LONGITUDE_TEST));

        // Geocoding Mock
        $geocoding = $this->getMock('Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\IGeocodingAdapter');
        
        $geocoding
            ->expects($this->any())
            ->method('getLocation')
            ->will($this->returnValue($geoLocation));
        
        // Weather Station Manager service using EntityManager Mock and Geocoding Mock
        $this->stationManager = new WeatherStationManager($em, $geocoding);
    }
    
    public function testCreateWeatherStation()
    {
//        $stationManager = static::createClient()->getContainer()->get('weather.guy.finder.station.manager');
//        $station = $stationManager->create('test', 'Alpedrete', 'Madrid');
        
        $station = $this->stationManager->create('test', 'Alpedrete', 'Madrid');
        
        $this->assertTrue($station instanceof WeatherStation);
        $this->assertTrue($station->latitude == self::LATITUDE_TEST);
        $this->assertTrue($station->longitude == self::LONGITUDE_TEST);
    }
    
    public function testFindStationNearestTo()
    {
        $stationManager = static::createClient()->getContainer()->get('weather.guy.finder.station.manager');
        
        $station = $stationManager->findStationNearestTo('Alpedrete Madrid, España');

        $this->assertTrue($station->getName() == self::NAME_NEAREST_STATION);
    }
}