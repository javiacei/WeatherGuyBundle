<?php

namespace Javiacei\WeatherGuyBundle\Geocoding;

/**
 * GeocodingAdapterInterface
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Geocoding
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
interface GeocodingAdapterInterface
{
     public function getLocation($address);
}