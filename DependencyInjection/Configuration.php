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
 * @author Fco Javier Aceituno <javier.aceituno@ideup.com>
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
                ->scalarNode('db_driver')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('finder_class')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
