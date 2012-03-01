<?php

namespace Javiacei\WeatherGuyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * JaviaceiWeatherGuyExtension Dependency Injection Extension
 *
 * Class that defines the Dependency Injection Extension to expose the bundle's semantic configuration
 * 
 * @package JaviaceiLyricsBundle
 * @subpackage DependencyInjection
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class JaviaceiWeatherGuyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs); 
        
        // registering services
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('weather.xml');
        $loader->load('remote.xml');
        $loader->load('orm.xml');
        
        $container->setParameter('ftp_server', $config['ftp_server']);
        $container->setParameter('climatological_year_path', $config['climatological_year_path']);
        
        $container->setParameter('adapter_class', $config['adapter_class']);
    }
}
