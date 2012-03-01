<?php

namespace Javiacei\WeatherGuyBundle\Model\Unit;

/**
 * Celsius
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class Celsius extends Measure
{
    /**
     * {@inheritdoc }
     */
    public function getUnit()
    {
        return 'ºC';
    }
}

