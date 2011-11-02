<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder;

/**
 * Description of IWeatherFinder
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */

interface IWeatherFinder
{
    /**
     * Return the nearest weather station (location) depending on $address.
     * 
     * @param string $address
     * @return IWheatherLocation
     */
    public function getWeatherLocation($address);
}
