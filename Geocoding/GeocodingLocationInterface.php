<?php

namespace Javiacei\WeatherGuyBundle\Geocoding;

/**
 * GeocodingLocationInterface
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Geocoding
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
interface GeocodingLocationInterface
{
    /**
     * @return float 
     */
    public function getLatitude();

    /**
     * @return float 
     */
    public function getLongitude();
}