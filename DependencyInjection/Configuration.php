<?php

namespace Javiacei\WeatherGuyBundle\DependencyInjection;

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
 * @package JaviaceiWeatherGuyBundle
 * @subpackage DependencyInjection
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Fco Javier Aceituno
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
        $rootNode = $treeBuilder->root('javiacei_weather_guy');
        
        $rootNode
            ->children()
                ->scalarNode('ftp_server')->defaultValue('ftpdatos.aemet.es')->end()
                ->scalarNode('climatological_year_path')->defaultValue('series_climatologicas/valores_diarios/anual')->end()
                ->scalarNode('adapter_class')->defaultValue('Javiacei\WeatherGuyBundle\Geocoding\Adapter\GoogleGeocodingAdapter')->end()
                ->scalarNode('distance_range')->defaultValue('50')->end()
            ->end()
        ;

        return $treeBuilder;
    }
    
    
}
