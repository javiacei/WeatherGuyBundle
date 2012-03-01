<?php

namespace Javiacei\WeatherGuyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DownloadAemetWeatherCommand
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Command
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class DownloadAemetWeatherCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('weather:download:aemet')
            ->setDescription('Download Aemet weather information of a given year.')
            ->addArgument('year', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Year(s) to be imported.')
            ->addOption('directory', 'dir', InputOption::VALUE_REQUIRED, 'Directory to download aemet information.')
            ->setHelp(<<<EOT
Import Aemet weather information of a given year.
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $years  = $input->getArgument('year');
        $dir    = $input->getOption('directory');

        $remoteAemet = $this->getContainer()->get('weather.guy.aemet.remote');
        $remoteAemet->connect();
        
        $em = $this->getContainer()->get('doctrine')->getEntityManager('weather_guy');
        foreach ($years as $year) {
            $output->write("<comment>Downloading year $year into directory $dir...</comment>");
            $filename = $remoteAemet->downloadDailyWeatherTo($year, $dir);
            $output->writeln("<info>ok!</info>");
        }
        $remoteAemet->disconnect();
        
        $output->writeln('');
        $output->writeln("<info>Downloading process completed.</info>");
    }
}