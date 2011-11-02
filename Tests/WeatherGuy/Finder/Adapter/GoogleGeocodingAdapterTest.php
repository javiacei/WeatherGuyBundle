<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\Tests\WeatherGuy\Finder\Adapter\Google;

use 
    Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\GoogleGeocodingAdapter
;

/**
 * Description of GoogleGeocodingAdapterTest
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
class GoogleGeocodingAdapterTest extends WebTestCase
{
    protected $geocoding;
    
    protected function setUp()
    {
        $this->geocoding = new GoogleGeocodingAdapter();
    }
    
    public function testGetLocation()
    {
        $location = $this->geocoding->getLocation('barcelona');
        
    }
}
