<?php

namespace Javiacei\WeatherGuyBundle\Model;

/**
 * WeatherGuy
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class WeatherGuy
{

    protected $weatherEngine;
    protected $weatherFinder;
    protected $distanceRange;

    public function __construct(WeatherFinderInterface $finder, WeatherEngineInterface $engine, $distanceRange)
    {
        $this->weatherFinder = $finder;
        $this->weatherEngine = $engine;
        $this->distanceRange = $distanceRange;
    }

    public function getWeatherLocation($address)
    {
        return $this->weatherFinder->findWeatherLocation($address, $this->distanceRange);
    }

    public function getWeatherLocationByGeo($lat, $long)
    {
        return $this->weatherFinder->findWeatherLocationByGeo($lat, $long, $this->distanceRange);
    }

    public function getWeatherInformation(WeatherStation $station, \DateTime $date)
    {
        return $this->weatherEngine->findWeatherInformation($station, $date);
    }

    public function findLatestByStation(WeatherStation $station)
    {
        return $this->weatherFinder->findLatestByStation($station);
    }

}