<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy\Tests;

use WeatherGuy\WeatherGuy;

class WeatherGuyTest extends \PHPUnit_Framework_TestCase
{
    public function testExistWeatherInformationMethod()
    {
        $reflectionWeatherGuy = new \ReflectionClass('WeatherGuy\WeatherGuy');        
        $this->assertTrue($reflectionWeatherGuy->hasMethod('getWeatherInformation'));
    }
}
