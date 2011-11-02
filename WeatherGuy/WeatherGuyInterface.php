<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace Ideup\WeatherGuyBundle\WeatherGuy;

interface WeatherGuyInterface
{
  public function getWeatherInformation($address);
}
