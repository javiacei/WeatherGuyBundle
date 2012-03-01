WeatherGuyBundle
==================

The WeatherGuyBundle allows you to retrieve weather information about Spain via different weather providers.

Weather info providers:

- AEMET http://www.aemet.es


Installation
------------

Add WeatherGuyBundle to your vendor/bundles/ directory.

Add the following lines in your ``deps`` file:

    [WeatherGuyBundle]
      git =http://github.com/javiacei/WeatherGuyBundle.git
      target=/bundles/Javiacei/WeatherGuyBundle
      version=master

Run the vendors script:

    ./bin/vendors install

Add the Javiacei namespace to your `app/autoload.php`:

    // app/autoload.php
    $loader->registerNamespaces(array(
        // your other namespaces
        'Javiacei' => __DIR__.'/../vendor/bundles',
    );


Add WeatherGuyBundle to your `app/AppKernel.php`:

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            new Javiacei\WeatherGuyBundle\JaviaceiWeatherGuyBundle(),
        );
    }


Configuration
-------------

Tell Doctrine where are your weather's database parameters:

    doctrine:
        dbal:
            connections:
                default:
                    driver:   %database_driver%
                    host:     %database_host%
                    dbname:   %database_name%
                    user:     %database_user%
                    password: %database_password%
                    charset:  UTF8
                weather_guy:
                    driver:   %database_weather_driver%
                    host:     %database_weather_host%
                    dbname:   %database_weather_name%
                    user:     %database_weather_user%
                    password: %database_weather_password%
                    charset:  UTF8
        orm:
            entity_managers:
                default:
                    mappings:
                        GNFHomeBundle: { type: annotation, dir: Entity/ }
                        GNFSmartMeterBundle: { type: annotation, dir: Entity/ }
                        GNFAlertBundle: { type: annotation, dir: Entity/ }
                        GNFNewsletterBundle: { type: annotation, dir: Entity/ }
                weather_guy:
                    connection:   weather_guy
                    mappings:
                        JaviaceiWeatherGuyBundle: ~

Add these lines to your app/config.yml to setting up the data source:

    javiacei_weather_guy:
        ftp_server: ftpdatos.aemet.es
        climatological_year_path: series_climatologicas/valores_diarios/anual
        adapter_class: Javiacei\WeatherGuyBundle\Geocoding\Adapter\GoogleGeocodingAdapter


Usage
-----

### Download weather data

Firstly, generate the corresponding database via doctrine through a shell terminal:

    $ php ./app/console doctrine:schema:create --em=weather_guy

Because of the AEMET's wheather information is available on the Internet via csv files we must download the source
through a shell terminal:

    $ php ./app/console weather:download:aemet --directory=/path/to/your/folder 2012

Now, import the data from the previously downloaded CSV files to your weather database through a shell terminal:

    $ php ./app/console weather:import:aemet /path/to/your/folder/2012.csv

Where 2012 can be substituted by any year you want.

### Get weather data

As a service:

    public function indexAction(Request $request)
    {
        //retrieving the service
        $weatherService = $this->getContainer()->get('weather.guy');

        //Looking for the closest weather station given a location
        $station = $weatherService->getWeatherLocation('Alpedrete Madrid, España');

        //getting the weather info
        $data = $weatherService->getWeatherInformation($station, new \DateTime('2012/02/01'));

    }


License
-------

This bundle is under de GNU license. See the complete license in::

    LICENSE

Authors
-------

- Fco. Javier Aceituno Lapido

TODO
----

- Unit testing
- Find more weather providers
