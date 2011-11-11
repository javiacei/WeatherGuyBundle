<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\Geocoding;

/**
 * Description of IGeocodingAdapter
 * 
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
class GeocodingLocation implements IGeocodingLocation
{
    
    protected $latitude;
    
    protected $longitude;
    
    public function __construct($latitude, $longitude)
    {
        $this->latitude     = $latitude;
        $this->longitude    = $longitude; 
    }
    
    /**
     * {@inheritdoc }
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     *
     * {@inheritdoc }
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

}