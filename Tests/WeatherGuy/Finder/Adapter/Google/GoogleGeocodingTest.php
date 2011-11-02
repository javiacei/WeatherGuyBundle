<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Tests\WeatherGuy\Finder\Adapter\Google;

use 
    Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\Google\GoogleGeocoding
;

class GoogleGeocodingTest extends WebTestCase
{
    public function testGeocode()
    {
        $googleGeocoding = new GoogleGeocoding();
        $googleGeocoding->geocodeAddress("Santa Quiteria 20, Alpedrete, Madrid");
    }
}

