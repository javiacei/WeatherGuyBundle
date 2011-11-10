<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\Model;

/**
 * Description of WeatherInformation
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
class WeatherInformation
{
    public $id;
    public $date;
    public $maxTemperature;
    public $minTemperature;
    public $avgTemperature;
    public $precipitation;
    public $sunshine;
    public $station;
    
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
        $this->maxTemperature = $t;
    }
    
    public function getMaxTemperature()
    {
        return $this->maxTemperature;
    }
    
    public function setMinTemperature(Unit\Measure $t)
    {
        $this->minTemperature = $t;
    }
    
    public function getMinTemperature()
    {
        return $this->minTemperature;
    }
    
    public function setAvgTemperature(Unit\Measure $t)
    {
        $this->avgTemperature = $t;
    }
    
    public function getAvgTemperature()
    {
        return $this->avgTemperature;
    }
    
    public function setPrecipitation(Unit\Measure $p)
    {
        $this->precipitation = $p;
    }
    
    public function getPrecipitation()
    {
        return $this->precipitation;
    }
    
    public function setSunshine(Unit\Measure $s)
    {
        $this->sunshine = $s;
    }
    
    public function getSunshine()
    {
        return $this->sunshine;
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