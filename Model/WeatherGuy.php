<?php

namespace Javiacei\WeatherGuyBundle\Model;

/**
 * WeatherGuy
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class WeatherGuy
{
    protected $weatherEngine;
    
    protected $weatherFinder;
    
    public function __construct(WeatherFinderInterface $finder, WeatherEngineInterface $engine)
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