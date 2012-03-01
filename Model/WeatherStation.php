<?php

namespace Javiacei\WeatherGuyBundle\Model;

/**
 * WeatherStation
 *
 * @package JaviaceiWeatherGuyBundle
 * @subpackage Model
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
abstract class WeatherStation
{
    public $id;
    
    public $name;
    
    public $latitude;
    
    public $longitude;
    
    public $city;
    
    public $locality;
    
    public $country;
    
    public $climatologicalValues;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function fromArray(array $data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }
    
    public function getAddress()
    {
        return $this->locality . " " . $this->city . ", " . $this->country;
    }
    
}