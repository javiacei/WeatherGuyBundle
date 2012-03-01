<?php

namespace Javiacei\WeatherGuyBundle\Model;

/**
 * WeatherEngineInterface
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
interface WeatherEngineInterface
{
    public function findWeatherInformation(WeatherStation $station, \DateTime $date);
}