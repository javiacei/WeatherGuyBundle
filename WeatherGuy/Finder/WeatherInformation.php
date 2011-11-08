<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder;

/**
 * Description of WeatherStation
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
class WeatherInformation
{
    public $id;
    public $day;
    public $maxTemperature;
    public $maxTemperatureMoment;
    public $minTemperature;
    public $minTemperatureMoment;
    public $avgTemperature;
    public $precipitation;
    public $sunshine;
    public $station;
}