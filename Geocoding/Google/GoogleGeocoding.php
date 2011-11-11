<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */
namespace Ideup\WeatherGuyBundle\Geocoding\Google;

/**
 * Description of GoogleGeocoding
 *
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */

class GoogleGeocoding
{
    const OK = "OK";
    
    const GOOGLE_SERVICE_URL = "https://maps.googleapis.com/maps/api/geocode/json?parameters";
    
    protected $parameters = array();
    
    /**
     *
     * @param array $options 
     */
    public function __construct(array $options)
    {
        $this->setParameters($options);
    }
    
    /**
     * This method returns params formatted (html)
     * 
     * @return string 
     */
    protected function getHtmlParameters()
    {
        $glue = "&";
        $htmlParams = "";
        
        $parameters = $this->getParameters();
        foreach ($parameters as $name => $value) {
            $htmlParams .= $name . '=' . str_replace(" ", '+', $value) . $glue;
        }
        
        return substr($htmlParams, 0, -strlen($glue));
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }
    
    public function setParameters(array $params)
    {
        foreach ($params as $pName => $pValue) {
            $this->setParameter($pName, $pValue);
        }
    }
    
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }
    
    public function getUrl()
    {
        return str_replace("parameters", $this->getHtmlParameters(), self::GOOGLE_SERVICE_URL);
    }
    
    private function geocode()
    {
        $url = $this->getUrl();
        
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
                $locations[] = $r;
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
