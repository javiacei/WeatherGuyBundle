<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Model;

/**
 * Description of IWeatherFinder
 * 
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
interface IWeatherFinder
{
    public function findWeatherLocation($address, $distance);
}
