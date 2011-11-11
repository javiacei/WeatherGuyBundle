<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Geocoding;

/**
 * Description of IGeocodingAdapter
 * 
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
interface IGeocodingAdapter
{
     public function getLocation($address);
}