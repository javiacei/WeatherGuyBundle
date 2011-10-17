<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy\Finder\Adapter;

use 
    WeatherGuy\Finder\Adapter\Google\GoogleGeocoding
;

/**
 * Description of GoogleGeolocationAdapter
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
class GoogleGeocodingAdapter implements IGeocodingAdapter
{
    protected $googleGeolocation;
    
    public function __construct()
    {
        $this->googleGeolocation = new GoogleGeocoding();
    }
    
    public function getWeatherLocation($address)
    {
        $locations = $this->googleGeolocation->geocodeAddress($address);
        
        // Return only one location
        if (empty($locations)) {
            throw new \Exception("No location found for '$address'");
        }
        
        // Returns first result (more important).
        return reset($locations);
    }

}
