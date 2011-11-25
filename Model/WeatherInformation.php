<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\Model;

/**
 * Description of WeatherInformation
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
abstract class WeatherInformation
{
    protected $id;
    
    protected $date;
    
    // Max temperature
    protected $maxTemperatureValue;
    protected $maxTemperatureMoment;
    protected $maxTemperatureUnitClass;
    
    // Min temperature
    protected $minTemperatureValue;
    protected $minTemperatureMoment;
    protected $minTemperatureUnitClass;
    
    // Avg temperature
    protected $avgTemperatureValue;
    protected $avgTemperatureUnitClass;
    
    // Precipitation
    protected $precipitationValue;
    protected $precipitationUnitClass;
    
    // Sunshine
    protected $sunshineValue;
    protected $sunshineUnitClass;
    
    protected $station;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setMaxTemperature(Unit\Measure $t)
    {
        $this->maxTemperatureValue      = $t->getValue();
        $this->maxTemperatureUnitClass  = get_class($t);
        $this->maxTemperatureMoment     = $t->getMoment();
    }
    
    public function getMaxTemperature()
    {
        return new $this->maxTemperatureUnitClass(
            $this->maxTemperatureValue,
            $this->maxTemperatureMoment
        );
    }
    
    public function setMinTemperature(Unit\Measure $t)
    {
        $this->minTemperatureValue      = $t->getValue();
        $this->minTemperatureUnitClass  = get_class($t);
        $this->minTemperatureMoment     = $t->getMoment();
    }
    
    public function getMinTemperature()
    {
        return new $this->minTemperatureUnitClass(
            $this->minTemperatureValue,
            $this->minTemperatureMoment
        );
    }
    
    public function setAvgTemperature(Unit\Measure $t)
    {
        $this->avgTemperatureValue      = $t->getValue();
        $this->avgTemperatureUnitClass  = get_class($t);
    }
    
    public function getAvgTemperature()
    {
        return new $this->avgTemperatureUnitClass($this->avgTemperatureValue);
    }
    
    public function setPrecipitation(Unit\Measure $p)
    {
        $this->precipitationValue       = $p->getValue();
        $this->precipitationUnitClass   = get_class($p);
    }
    
    public function getPrecipitation()
    {
        return new $this->precipitationUnitClass($this->precipitationValue);
    }
    
    public function setSunshine(Unit\Measure $s)
    {
        $this->sunshineValue        = $s->getValue();
        $this->sunshineUnitClass    = get_class($s);
    }
    
    public function getSunshine()
    {
        return new $this->sunshineUnitClass($this->sunshineValue);
    }
    
    public function setStation(WeatherStation $weatherStation)
    {
        $this->station = $weatherStation;
    }
    
    public function getStation()
    {
        return $this->station;
    }
    
    public function fromArray(array $data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }
}