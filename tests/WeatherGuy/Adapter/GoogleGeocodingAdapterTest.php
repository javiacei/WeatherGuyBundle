<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace WeatherGuy\Tests\Adapter\Google;

use 
    WeatherGuy\Finder\Adapter\GoogleGeocodingAdapter
;

/**
 * Description of GoogleGeocodingAdapterTest
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
class GoogleGeocodingAdapterTest extends \PHPUnit_Framework_TestCase
{
    protected $geocoding;
    
    protected function setUp()
    {
        $this->geocoding = new GoogleGeocodingAdapter();
    }
    
    public function testGetWeatherLocation()
    {
        $location = $this->geocoding->getWeatherLocation('barcelona');
        
        var_dump($location);
    }
}
