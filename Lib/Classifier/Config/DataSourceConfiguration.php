<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class DataSourceConfiguration implements ConfigurationInterface
{
    /**
     * Returns a specification for data sources
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('datasource');

        $rootNode
            ->prototype('array')
            ->children()
                ->scalarNode('category')->isRequired()->end()
                ->scalarNode('document')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
