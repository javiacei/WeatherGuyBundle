<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\Google;

use Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\IGeocodingLocation;

/**
 * Description of GoogleLocation
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
class GoogleLocation implements IGeocodingLocation
{
    const LOCALITY = 'locality';
    const CITY = 'administrative_area_level_2'; // TODO
    const COUNTRY = 'country';
    
    public $formattedAddress;
    
    public $position;
    
    public $country;
    
    public $city;
    
    public $locality;
    
    // TODO: Redo
    public function __construct(\stdClass $data)
    {
        // Formatted Address
        $this->formattedAddress = $data->formatted_address;

        // Locality
        $localityType = self::LOCALITY;
        $localityClosure = function($addressComponent) use ($localityType) {
            return in_array($localityType, $addressComponent->types);
        };
        
        $addressComponent = array_filter(
            $data->address_components, $localityClosure
        );
        $addressComponent = array_pop($addressComponent);

        if ($addressComponent) {
            $this->locality = $addressComponent->long_name;
        } else {
            // Natural feature
            $this->locality = $data->address_components[0];
        }
        
        // City
        $cityType = self::CITY;
        $cityClosure = function($addressComponent) use ($cityType) {
            return in_array($cityType, $addressComponent->types);
        };
        
        $addressComponent = array_filter(
            $data->address_components, $cityClosure
        );
        $addressComponent = array_pop($addressComponent);
        
        if ($addressComponent) {
            $this->city = $addressComponent->long_name;
        } else {
            // Natural feature
            $this->city = $data->address_components[0];
        }
        
        // Country
        $countryType = self::COUNTRY;
        $countryClosure = function($addressComponent) use ($countryType) {
            return in_array($countryType, $addressComponent->types);
        };
        
        $addressComponent = array_filter(
            $data->address_components, $countryClosure
        );
        $addressComponent = array_pop($addressComponent);

        $this->country = $addressComponent->long_name;
        
        // Position
        $this->position = array(
            'latitude'  => $data->geometry->location->lat,
            'longitude' => $data->geometry->location->lng,
        );
    }
    
    public function getLatitude()
    {
        return $this->position['latitude'];
    }
    
    public function getLongitude()
    {
        return $this->position['longitude'];
    }
}
