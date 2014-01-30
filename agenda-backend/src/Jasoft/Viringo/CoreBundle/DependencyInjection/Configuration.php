<?php

namespace Jasoft\Viringo\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jasoft_viringo_core');

        $rootNode
            ->children()
                ->arrayNode('exception_handling')
                    ->children()
                        ->arrayNode('exception_email')
                            ->children()
                                ->booleanNode('send_email')->defaultFalse()->end()
                                ->scalarNode('sender')->end()
                                ->scalarNode('receptor')->end()
                                ->scalarNode('subject')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        
        return $treeBuilder;
    }
}
