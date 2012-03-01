<?php

namespace Javiacei\WeatherGuyBundle\Model;

/**
 * WeatherFinderInterface
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
interface WeatherFinderInterface
{
    public function findWeatherLocation($address, $distance);
}
