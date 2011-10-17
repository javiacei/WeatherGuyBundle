<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy;

use 
    WeatherGuy\Finder\IWeatherFinder,
    WeatherGuy\Engine\IWeatherEngine
;

class WeatherGuy implements WeatherGuyInterface
{

    protected $finder;
    protected $engine;
    
    public function __construct(IWeatherFinder $finder, IWeatherEngine $engine)
    {
        $this->finder   = $finder;
        $this->engine   = $engine;
    }

    public function getWeatherInformation($address)
    {
        
    }

}
