<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Geocoding;

/**
 * Description of IGeocodingLocation
 * 
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
interface IGeocodingLocation
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