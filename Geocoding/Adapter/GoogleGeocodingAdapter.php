<?php

namespace Javiacei\WeatherGuyBundle\Geocoding\Adapter;

use
    Javiacei\WeatherGuyBundle\Geocoding\GeocodingAdapterInterface,
    Javiacei\WeatherGuyBundle\Geocoding\Google\GoogleGeocoding,
    Javiacei\WeatherGuyBundle\Geocoding\GeocodingLocation
;

/**
 * GoogleGeocodingAdapter
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Geocoding
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class GoogleGeocodingAdapter implements GeocodingAdapterInterface
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
            return null;
//            throw new \Exception("No location found for '$address'");
        }

        // Returns first result (more important).
        $googleLocation = reset($locations);

        return new GeocodingLocation(
            $googleLocation->geometry->location->lat,
            $googleLocation->geometry->location->lng
        );
    }

}
