<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Geocoding\Adapter;

use 
    Ideup\WeatherGuyBundle\Geocoding\IGeocodingAdapter,
    Ideup\WeatherGuyBundle\Geocoding\Google\GoogleGeocoding,
    Ideup\WeatherGuyBundle\Geocoding\GeocodingLocation
;

/**
 * Description of GoogleGeolocationAdapter
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
class GoogleGeocodingAdapter implements IGeocodingAdapter
{
    protected $googleGeolocation;
    
    public function __construct()
    {
        $geocodingOptions = array(
            'sensor'    => "false",
            'language'  => "es"
        );
        
        $this->googleGeolocation = new GoogleGeocoding($geocodingOptions);
    }
    
    /**
     *
     * @param string $address
     * @return GeocodingLocation
     */
    public function getLocation($address)
    {
        $locations = $this->googleGeolocation->geocodeAddress($address);
        
        // Return only one location
        if (empty($locations)) {
            throw new \Exception("No location found for '$address'");
        }
        
        // Returns first result (more important).
        $googleLocation = reset($locations);
        
        return new GeocodingLocation(
            $googleLocation->geometry->location->lat,
            $googleLocation->geometry->location->lng
        );
    }

}
