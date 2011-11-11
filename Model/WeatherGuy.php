<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\Model;

/**
 * Description of WeatherGuy
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
class WeatherGuy
{
    protected $weatherEngine;
    
    protected $weatherFinder;
    
    public function __construct(IWeatherFinder $finder, IWeatherEngine $engine)
    {
        $this->weatherFinder = $finder;
        $this->weatherEngine = $engine;
    }
    
    public function getWeatherLocation($address)
    {
        return $this->weatherFinder->findWeatherLocation($address, 50);
    }
    
    public function getWeatherInformation(WeatherStation $station, \DateTime $date)
    {
        return $this->weatherEngine->findWeatherInformation($station, $date);
    }
}