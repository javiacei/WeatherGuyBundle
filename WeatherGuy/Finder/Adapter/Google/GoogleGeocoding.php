<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder\Adapter\Google;

/**
 * Description of GoogleGeocoding
 *
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
 */
class GoogleGeocoding
{
    const OK = "OK";
    
    const GOOGLE_SERVICE_URL = "https://maps.googleapis.com/maps/api/geocode/json?parameters";
    
    protected $parameters = array();
    
    public function getDefaultParameters()
    {
        return array(
            'sensor'    => "false",
            'language'  => "es"
        );
    }
    
    public function getParameters()
    {
        return array_merge($this->getDefaultParameters(), $this->parameters);
    }
    
    public function getHtmlParameters()
    {
        $glue = "&";
        $htmlParams = "";
        
        $parameters = $this->getParameters();
        foreach ($parameters as $name => $value) {
            $htmlParams .= $name . '=' . str_replace(" ", '+', $value) .$glue;
        }
        
        return substr($htmlParams, 0, -strlen($glue));
    }
    
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }
    
    private function geocode()
    {
        $url = str_replace("parameters", $this->getHtmlParameters(), self::GOOGLE_SERVICE_URL);
        
         // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);
        
        $data = json_decode($output);
        $locations = array();
        
        if (self::OK === $data->status) {
            foreach($data->results as $r) {
                $locations[] = new GoogleLocation($r);
            }
        }
        
        return $locations;
    }
    
    public function geocodeAddress($address)
    {
        $this->setParameter('address', $address);
        return $this->geocode();
    }
}
