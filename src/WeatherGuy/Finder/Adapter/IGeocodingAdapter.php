<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy\Finder\Adapter;

/**
 * Description of IGeocodingAdapter
 * 
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
interface IGeocodingAdapter
{
     public function getWeatherLocation($address);
}