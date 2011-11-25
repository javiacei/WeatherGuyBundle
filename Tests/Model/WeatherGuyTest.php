<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Tests\Model\Manager;


use
    Symfony\Bundle\FrameworkBundle\Test\WebTestCase,

    Ideup\WeatherGuyBundle\Model\WeatherGuy
;

class WeatherGuyTest extends WebTestCase
{
    const ADDRESS = "Alpedrete, Madrid";

    const DATE = "01-01-2011";

    // Integration test.
    // IMPORTANT: To run this test you need to import AEMET 2011 year at least
    // first day of first month.
    //
    // 1- $> php app/console weather:download:aemet --directory="/tmp" 2011
    // 2- $> php app/console weather:import:aemet /tmp/2011.csv
    //
    // This example can be used to know how you can use the service.
    public function testGetWeatherLocationUsingWeatherGuyService()
    {
        $client = static::createClient();
        $weatherGuy = $client->getContainer()->get('weather.guy');

        $weatherLocation = $weatherGuy->getWeatherLocation(self::ADDRESS);
        $weatherInformation = $weatherGuy->getWeatherInformation(
            $weatherLocation,
            new \DateTime(self::DATE)
        );

        $this->assertTrue($weatherInformation instanceof \Ideup\WeatherGuyBundle\Model\WeatherInformation);
    }
}

