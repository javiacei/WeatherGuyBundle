<?php

namespace Ideup\WeatherGuyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * IdeupWeatherGuy Dependency Injection Extension
 *
 * Class that defines the Dependency Injection Extension to expose the bundle's semantic configuration
 * 
 * @package IdeupWeatherGuyBundle
 * @subpackage DependencyInjection
 * @author Francisco Javier Aceituno <javier.aceituno@ideup.com>
 */
class IdeupWeatherGuyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs); 
        
        // registering services
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('finder.xml');
        $loader->load('remote.xml');
        $loader->load('orm.xml');
        
        $container->setParameter('ftp_server', $config['ftp_server']);
        $container->setParameter('climatological_year_path', $config['climatological_year_path']);
    }
}
