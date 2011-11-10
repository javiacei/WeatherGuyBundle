<?php

namespace Ideup\WeatherGuyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use 
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\Unit\Celsius,
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\Unit\Millimeters,
    Ideup\WeatherGuyBundle\WeatherGuy\Finder\Unit\Hours
;

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
    
    protected function getDateOf(array $aemetCsvRow)
    {
        return new \DateTime("{$aemetCsvRow['day']}-{$aemetCsvRow['month']}-{$aemetCsvRow['year']}");
    }
    
    protected function getTemperatureOf(array $aemetCsvRow, $type)
    {
        if (!in_array($type, array('max', 'min', 'avg'))) {
            return null;
        }
        
        $dateString = $this->getDateOf($aemetCsvRow)->format('d-m-Y');
        $temperatureHHmm = '';
        if (
            array_key_exists("{$type}TemperatureHHmm", $aemetCsvRow) 
            && 'Varias' != $aemetCsvRow["{$type}TemperatureHHmm"]
        ){
            $temperatureHHmm = (string)$aemetCsvRow["{$type}TemperatureHHmm"];
        }
        
        $value  = (float)$aemetCsvRow["{$type}Temperature"];
        $moment = new \DateTime($dateString . " " . $temperatureHHmm);
        
        return new Celsius($value, $moment);
    }
    
    protected function getPrecipitationOf(array $aemetCsvRow)
    {
        return new Millimeters((float)$aemetCsvRow['precipitation']);
    }
    
    protected function getSunshineOf(array $aemetCsvRow)
    {
        return new Hours($aemetCsvRow['sunshine']);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stationManager = $this->getContainer()->get('weather.guy.finder.station.manager');
        $infoManager = $this->getContainer()->get('weather.guy.finder.information.manager');
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

            // Check if station with name = $info['name'] exists.
            $station = $stationManager->findStationByName($info['name']);
            if (null === $station) {
                // Create new station
                $output->writeln("<comment>Station '{$info['name']}' in '{$info['locality']}, {$info['city']}' doesn't exist.</comment>");
                $station = $stationManager->create($info['name'], $info['locality'], $info['city']);
                $stationManager->save($station);
                
                $output->writeln("<comment>Station '{$info['name']}' in '{$info['locality']}, {$info['city']}' created!.</comment>");
            }
            
            // Weather information Object
            $date = $this->getDateOf($info);
            try {
                $weatherInfo = $infoManager->create($station, $date);
            } catch (\Exception $exc) {
                // Weather information for $station at $date exists.
                continue;
            }
            
            $weatherInfo->setMaxTemperature($this->getTemperatureOf($info, 'max'));
            $weatherInfo->setMinTemperature($this->getTemperatureOf($info, 'min'));
            $weatherInfo->setAvgTemperature($this->getTemperatureOf($info, 'avg'));
            $weatherInfo->setPrecipitation($this->getPrecipitationOf($info));
            $weatherInfo->setSunshine($this->getSunshineOf($info));
            $infoManager->save($weatherInfo);
            
            $output->writeln("Weather information for station <info>'{$info['name']}'</info> in <info>'{$info['locality']}, {$info['city']}'</info> at <info>{$date->format('d-m-Y')}</info> <comment>imported</comment>");
        }
    }

}