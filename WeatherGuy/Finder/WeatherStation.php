<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder;

/**
 * Description of WeatherStation
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
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