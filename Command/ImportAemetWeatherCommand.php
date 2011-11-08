<?php

namespace Ideup\WeatherGuyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportAemetWeatherCommand extends ContainerAwareCommand
{
    protected $csvStructure = array(
        'name',
        'locality',
        'city',
        'altitude',
        'year',
        'month',
        'day',
        'maxTemperature',
        'maxTemperatureHHmm',
        'minTemperature',
        'minTemperatureHHmm',
        'avgTemperature',
        'windGust',
        'windDirection',
        'windHH',
        'avgSpeed',
        'precipitation',
        'sunshine',
        'maxPressure',
        'maxPressureHH',
        'minPressure',
        'minPressureHH'
    );
    
    protected function configure()
    {
        $this
            ->setName('weather:import:aemet')
            ->setDescription('Download Aemet weather information of a given year.')
            ->addArgument('file', InputArgument::REQUIRED, 'File to be imported.')
            ->setHelp(<<<EOT
Import Aemet weather information of a given year.
EOT
        );
    }
    
    private function prepareRow($row)
    {
        if (count($this->csvStructure) !== count($row)) {
            return null;
        }
        
        $info = array_combine($this->csvStructure, $row);
        
        return array_map(
            function($e){
                if (mb_detect_encoding($e, "auto") == 'UTF-8') {
                    return utf8_encode($e);
                }
                
                return $e;
            }, $info
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stationManager = $this->getContainer()->get('weather.guy.finder.station.manager');
        $filename  = $input->getArgument('file');
        
        $file = new \SplFileObject($filename);
        $titlesLine = $file->fgetcsv(";");
        
        $output->writeln("<info>Processing file $file...</info>");
        while($row = $file->fgetcsv(";")) {
            $info = $this->prepareRow($row);
            
            // To jump empty lines
            if (null === $info) {
                continue;
            }
            
            $output->writeln("<comment>Looking for station '{$info['name']}' in '{$info['locality']}, {$info['city']}' ...</comment>");
            
            // Check if station with name = $info['name'] exists.
            $existStation = $stationManager->existStationBy(array('name' => $info['name']));
            if (false === $existStation) {
                // Create new station
                $output->writeln("<comment>Station '{$info['name']}' in '{$info['locality']}, {$info['city']}' doesn't exist.</comment>");
                $station = $stationManager->create($info['name'], $info['locality'], $info['city']);
                $stationManager->save($station);
                
                $output->writeln("<comment>Station '{$info['name']}' in '{$info['locality']}, {$info['city']}' created!.</comment>");
            }
            
            
            $output->writeln("<comment>Station '{$info['name']}' in '{$info['locality']}, {$info['city']}' at {$info['day']}-{$info['month']}-{$info['year']} exists!.</comment>");
        }
    }

}