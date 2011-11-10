<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder\Unit;

/**
 * Description of Measure
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
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
     * @return float Measure valur
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
