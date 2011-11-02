<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder;

use
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\IGeocodingAdapter
;

/**
 * Description of WeatherFinder
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
class AEMETFinder implements IWeatherFinder
{

    protected $geocodingAdapter;
    
    public function __construct(IGeocodingAdapter $geocodingAdapter)
    {
        $this->geocodingAdapter = $geocodingAdapter;
    }
    
    /**
     *
     * {@inheritdoc }
     */
    public function getWeatherLocation($address)
    {
        // Search address using geocoding adapter
        $location = $this->geocodingAdapter->getLocation($address);
        
        // Now, I have to search the location of nearest weather station.
        
    }

}
