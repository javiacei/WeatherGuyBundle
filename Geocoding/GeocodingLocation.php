<?php

namespace Javiacei\WeatherGuyBundle\Geocoding;

/**
 * GeocodingLocation
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Geocoding
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class GeocodingLocation implements GeocodingLocationInterface
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