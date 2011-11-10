<?php

namespace Ideup\WeatherGuyBundle\DependencyInjection;

use 
    Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition,
    Symfony\Component\Config\Definition\Builder\TreeBuilder,
    Symfony\Component\Config\Definition\ConfigurationInterface
;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @package IdeupWeatherGuyBundle
 * @subpackage DependencyInjection
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 */
class Configuration implements ConfigurationInterface
{    
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ideup_weather_guy');
        
        $rootNode
            ->children()
                ->scalarNode('ftp_server')->defaultValue('ftpdatos.aemet.es')->end()
                ->scalarNode('climatological_year_path')->defaultValue('series_climatologicas/valores_diarios/anual')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
