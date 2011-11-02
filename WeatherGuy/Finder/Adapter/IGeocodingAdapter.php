<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter;

/**
 * Description of IGeocodingAdapter
 * 
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
interface IGeocodingAdapter
{
     public function getLocation($address);
}