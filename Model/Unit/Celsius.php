<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\Model\Unit;

/**
 * Description of TemperatureCelsius
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
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

