<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy\Finder;

use
    WeatherGuy\Finder\Adapter\IGeocodingAdapter
;

/**
 * Description of WeatherFinder
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
class WeatherAEMETFinder implements IWeatherFinder
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
        $location = $this->geocodingAdapter->getWeatherLocation($address);
        
        // Now, I have to search the location of nearest weather station.
        
    }

}
