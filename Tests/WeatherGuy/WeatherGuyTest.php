<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Tests\WeatherGuy;


use
    Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Ideup\WeatherGuyBundle\WeatherGuy
;

class WeatherGuyTest extends WebTestCase
{
    public function testExistWeatherInformationMethod()
    {
        $reflectionWeatherGuy = new \ReflectionClass('Ideup\WeatherGuyBundle\WeatherGuy\WeatherGuy');        
        $this->assertTrue($reflectionWeatherGuy->hasMethod('getWeatherInformation'));
    }
}
