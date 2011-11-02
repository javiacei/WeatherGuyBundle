<?php

namespace Ideup\WeatherGuyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportAemetWeatherCommand extends ContainerAwareCommand
{
    const AEMET_FTP_SERVER      = "ftpdatos.aemet.es";
    const AEMET_WEATHER_PATH    = "series_climatologicas/valores_diarios/anual";
    
    protected function configure()
    {
        $this
            ->setName('weather:import:aemet')
            ->setDescription('Import Aemet weather information of a given year.')
            ->setDefinition(array(
                new InputArgument(
                        'year', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Year(s) to be imported.'
                )
            ))
            ->setHelp(<<<EOT
Import Aemet weather information of a given year.
EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this
            ->getContainer()
            ->get('weather.guy.aemet.remote')
            ->downloadDailyWeatherTo(
                $input->getArgument('year'),    // years
                __DIR__ . '/../TemporalData'    // temporal directory
            )
        ;
    }

}