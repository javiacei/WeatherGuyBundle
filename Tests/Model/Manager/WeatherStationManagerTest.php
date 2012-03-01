<?php

namespace Javiacei\WeatherGuyBundle\Tests\Model\Manager;

use
    Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    
    Javiacei\WeatherGuyBundle\Model\WeatherStation,
    Javiacei\WeatherGuyBundle\Model\Manager\WeatherStationManager
;

/**
 * WeatherStationManagerTest
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Tests
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
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
        $geoLocation = $this->getMock('Javiacei\WeatherGuyBundle\Geocoding\IGeocodingLocation');
        
        $geoLocation
            ->expects($this->any())
            ->method('getLatitude')
            ->will($this->returnValue(self::LATITUDE_TEST));

        $geoLocation
            ->expects($this->any())
            ->method('getLongitude')
            ->will($this->returnValue(self::LONGITUDE_TEST));

        // Geocoding Mock
        $geocoding = $this->getMock('Javiacei\WeatherGuyBundle\Geocoding\IGeocodingAdapter');
        
        $geocoding
            ->expects($this->any())
            ->method('getLocation')
            ->will($this->returnValue($geoLocation));
        
        // Weather Station Manager service using EntityManager Mock and Geocoding Mock
        $this->stationManager = new WeatherStationManager($em, $geocoding);
    }
    
    public function testCreateWeatherStation()
    {
        $station = $this->stationManager->create('test', 'Alpedrete', 'Madrid');
        
        $this->assertTrue($station instanceof WeatherStation);
        $this->assertTrue($station->latitude == self::LATITUDE_TEST);
        $this->assertTrue($station->longitude == self::LONGITUDE_TEST);
    }
    
    public function testFindWeatherLocation()
    {
        $stationManager = static::createClient()->getContainer()->get('weather.guy.station.manager');
        $station = $stationManager->findWeatherLocation('Alpedrete Madrid, España');
        $this->assertTrue($station->getName() == self::NAME_NEAREST_STATION);
    }
}