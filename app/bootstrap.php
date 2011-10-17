<?php

require_once(__DIR__.'/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;

$classLoader = new UniversalClassLoader();
$classLoader->registerNamespaces(array(
    'WeatherGuy\Tests' => __DIR__,
    'WeatherGuy' => __DIR__.'/../src',
));
$classLoader->register();
