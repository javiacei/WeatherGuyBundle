<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace WeatherGuy;

interface WeatherGuyInterface
{
  public function getWeatherInformation($address);
}
