<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy\Tests\Adapter\Google;

use 
    WeatherGuy\Finder\Adapter\Google\GoogleGeocoding
;

class GoogleGeocodingTest extends \PHPUnit_Framework_TestCase
{
    public function testGeocode()
    {
        $googleGeocoding = new GoogleGeocoding();
        $googleGeocoding->geocodeAddress("Santa Quiteria 20, Alpedrete, Madrid");
    }
}

