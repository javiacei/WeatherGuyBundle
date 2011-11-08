<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter;

/**
 * Description of IGeocodingAdapter
 * 
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
interface IGeocodingLocation
{
     public function getLatitude();
     
     public function getLongitude();
}