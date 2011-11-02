<?php

namespace Ideup\WeatherGuyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportAemetWeatherCommand extends ContainerAwareCommand
{
    const AEMET_FTP_SERVER = "ftpdatos.aemet.es";
    const AEMET_WEATHER_PATH = "series_climatologicas/valores_diarios/anual";
    
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
        $conn = ftp_connect(self::AEMET_FTP_SERVER);
        if (false === ftp_login($conn, 'anonymous', 'email@email.com')) {
            ftp_close($conn);
            $output->writeln("<error>Connection refused</error>");
            return;
        }
        
        $years = $input->getArgument('year');
        foreach($years as $year) {
            $output->writeln("<info>Importing Aemet weather information of year $year ...</info>");
            
            $fileLocalName = $year . ".CSV.gz";
            $handle = fopen(__DIR__ . '/../TemporalData/' .  $fileLocalName, 'w');
            
            $fileRemoteName = self::AEMET_WEATHER_PATH . '/' . $fileLocalName;
            $output->writeln("<info>Downloading year $year ...</info>");
            if (true === ftp_fget($conn, $handle, $fileRemoteName, FTP_BINARY)) {
                $output->writeln("<info>Year $year downloaded.</info>");
            }
            fclose($handle);

            $output->writeln("<info>Decompressing year $year.</info>");
            $uncompressFile = gzopen(__DIR__ . '/../TemporalData/' .  $fileLocalName, 'rb');
            if (false === $uncompressFile) {
                $output->writeln("<error>ZipArchive error</error>");
                return;
            }
            $outFile = fopen(__DIR__ . '/../TemporalData/' . $year . '.csv', 'wb');
            
            // Keep repeating until the end of the input file
            while(!gzeof($uncompressFile)) {
                // Read buffer-size bytes
                // Both fwrite and gzread and binary-safe
                fwrite($outFile, gzread($uncompressFile, 4096));
            }

            // Files are done, close files
            fclose($outFile);
            gzclose($uncompressFile);
        }
        
        ftp_close($conn);
    }

}