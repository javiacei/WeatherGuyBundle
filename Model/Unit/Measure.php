<?php

namespace Javiacei\WeatherGuyBundle\Model\Unit;

/**
 * Measure
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
abstract class Measure
{
    protected $value;
    
    protected $moment;
    
    /**
     * @return string Unit string representation
     */
    abstract public function getUnit();
    
    public function __construct($value, \DateTime $moment = null)
    {
        $this->value    = $value;
        $this->moment   = $moment;
    }
    
    /**
     * @return float Measure value
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @return \DateTime Moment at this measure occurs.
     */
    public function getMoment()
    {
        return $this->moment;
    }
}
