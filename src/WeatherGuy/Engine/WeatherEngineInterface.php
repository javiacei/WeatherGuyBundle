<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy\Engine;

use
    WeatherGuy\Finder\IWeatherLocation
;

/**
 * Description of IWeatherEngine
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
interface IWeatherEngine
{
    public function getWeatherInformation(IWeatherLocation $location);
}
