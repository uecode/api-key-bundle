<?php

namespace Uecode\Bundle\ApiKeyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('uecode_api_key');

        $rootNode
            ->children()
                ->booleanNode('force_api_key')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
