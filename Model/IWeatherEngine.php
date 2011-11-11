<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Model;

/**
 * Description of IWeatherEngine
 * 
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
interface IWeatherEngine
{
    public function findWeatherInformation(WeatherStation $station, \DateTime $date);
}